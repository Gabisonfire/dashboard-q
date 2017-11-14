<?php
	include 'forecast.io.php';
    $errors = [];

    $initialSetup = false;

    // Check for needed file
    $cfg = checkConfig();
    function checkConfig()
    {
        if(!file_exists("config.ini"))
        {
            return;
            echo "<span class=\"info-center\">Config not found, redirecting to setup.</span>";
            echo "<script> window.location.href=\"settings.php\";</script>";
        }

        try{
            $config = file("config.ini");
            $cfg = parse_ini_file("config.ini");
        }
        catch (Exception $e)
        {
            echo "<span class=\"error-center\">Error parsing config.ini. " . $e->getMessage() . "</span>";
            Exit(1);
        }

        foreach($config as $line)
        {
            $index = strpos($line, " =");
            if($index === FALSE){continue;}
            $param = substr($line, 0, $index);
            switch($param){
                case "torrent_client": break;
                case "torrent_username": break;
                case "torrent_password": break;
                case "torrent_host": break;
                case "torrent_port": break;
                case "prtg_map": break;
                case "forecast_key": break;
                case "forecast_lat": break;
                case "forecast_long": break;
                case "show_errors": break;
                case "show_weather": break;
                case "show_prtg": break;
                case "refresh_seconds": break;
                case "storage_path": break;
                case "storage_name": break;
				case "show_storage": break;
				case "title_first_part": break;
				case "title_second_part": break;
                case "initial_setup": break;
                default:
                {
                    echo "<span class=\"error-center\">Invalid parameter in config.ini. (" . $line . ")</span>";
                    Exit(1);
                }
            }
        }

        return $cfg;
    }

   // Get SID from qBittorrent API
  function authenticate()
  {
    global $cfg;
    $ch = curl_init();
    $creds = 'username=' . urlencode($cfg['torrent_username']) . '&password=' . urlencode($cfg['torrent_password']);
    $url = $cfg['torrent_host'] . ":" . $cfg['torrent_port'] . "/login";
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$creds);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt($ch,CURLOPT_TIMEOUT, 20);
    try {
    $response = curl_exec($ch);
    $buffer = explode("\n", $response);
    if(count($buffer) < 4)
    {
        return array($response, null);
    }
    $start = strpos($buffer[4], "SID=");
    $stop = strpos($buffer[4], "; path");
    $sid = substr($buffer[4], $start + 4, strlen($buffer[4]) - $stop - $start - 6);
    return array($sid, $ch);
    }
    catch (Exception $e)
    {
        return array($e->getMessage(), null);
    }
  }

  // Make get request to torrent API
  function getRequest($query)
  {
    global $cfg;
    global $errors;
    $url = $cfg['torrent_host'] . ":" . $cfg['torrent_port'] . $query;
    $content = authenticate();

    // if $ch is null, there was an error authenticating. Return that error.
    if($content[1] == null)
    {
        array_push($errors, "Error authenticating to torrent client. " . $content[0]);
        return null;
    }
    $sid = $content[0];
    $ch = $content[1];
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: SID=" . $sid));
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt($ch,CURLOPT_TIMEOUT, 20);
    try {
        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);
        return $response;
    }
    catch (Exception $e)
    {
        array_push($errors, "Error contacting api. " . error_get_last()['message']);
        return array(null);
    }
  }

  // Make post request to Transmission API for Download and Upload Stats
  function transmissionAll()
  {
    global $cfg;
    $torrent_host = $cfg['torrent_host'];
    $torrent_port = $cfg['torrent_port'];
    $creds = $cfg['torrent_username'] . ":" . $cfg['torrent_password'];
    $json = array("method" => "session-stats") ;
    $a = json_encode($json) ;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_URL, "http://$torrent_host:$torrent_port/transmission/rpc");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $a);
    curl_setopt($ch, CURLOPT_HTTPAUTH, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $creds);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    try {
        $r = curl_exec($ch);
        $ret = preg_match  ( "%.*\r\n(X-Transmission-Session-Id: .*?)(\r\n.*)%", $r, $result) ;
        $X_Transmission_Session_Id  = $result[1] ;
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ($X_Transmission_Session_Id)) ;
        $r = curl_exec($ch);
        curl_close($ch);
        $stats = json_decode($r, true) ;
        $stats = $stats ["arguments"] ;
        return $stats;
    }
    catch (Exception $e)
    {
        array_push($errors, "Error contacting api. " . error_get_last()['message']);
        return array(null);
    }
  }

  // Make post request to Transmission API for Torrents list
  function transmissionTorrents()
  {
    global $cfg;
    $torrent_host = $cfg['torrent_host'];
    $torrent_port = $cfg['torrent_port'];
    $creds = $cfg['torrent_username'] . ":" . $cfg['torrent_password'];
    $json = array("arguments" => array("fields" => array("name", "uploadRatio", "status", "peersGettingFromUs")),"method" => "torrent-get") ;
    $a = json_encode($json) ;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_URL, "http://$torrent_host:$torrent_port/transmission/rpc");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $a);
    curl_setopt($ch, CURLOPT_HTTPAUTH, 1);
    curl_setopt($ch, CURLOPT_USERPWD, $creds);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    try {
        $r = curl_exec($ch);
        $ret = preg_match  ( "%.*\r\n(X-Transmission-Session-Id: .*?)(\r\n.*)%", $r, $result) ;
        $X_Transmission_Session_Id  = $result[1] ;
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array ($X_Transmission_Session_Id)) ;
        $r = curl_exec($ch);
        curl_close($ch);
        $stats = json_decode($r, true) ;
        $stats = $stats ["arguments"] ;
        return $stats;
    }
    catch (Exception $e)
    {
        array_push($errors, "Error contacting api. " . error_get_last()['message']);
        return array(null);
    }
  }


  // Get Request to forecast.io API
  function weather()
  {
    global $cfg;
    global $errors;
    $api_key = $cfg['forecast_key'];
    $latitude = $cfg['forecast_lat'];
    $longitude = $cfg['forecast_long'];
    $units = 'auto';
    $lang = 'en';
    $forecast = new ForecastIO($api_key, $units, $lang);
    $condition = $forecast->getCurrentConditions($latitude, $longitude);
    if($condition)
    {
        return array($condition->getSummary(), $condition->getIcon(), $condition->getTemperature(), $condition->getApparentTemperature());
    }
    array_push($errors, "Error fetching weather. " . error_get_last()['message']);
    return array("Error fecthing weather", "rain", "0", "0");
  }
