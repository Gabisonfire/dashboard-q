<?php	
	include 'forecast.io.php';
        $errors = [];
        
        // Check for config file
        if(!file_exists("config.ini"))
        {
            echo "<span class=\"error-center\">Failed to load config.ini</span>";
            Exit(1);
        }
        
	$cfg = parse_ini_file("config.ini");

   // Get SID from qBittorrent API
  function authenticate()
  {    
    global $cfg;
    $ch = curl_init();
    $creds = 'username=' . urlencode($cfg['torrent_username']) . '&password=' . urlencode($cfg['torrent_password']);
    $url = $cfg['torrent_url'] . "/login";
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
    $url = $cfg['torrent_url'] . $query;
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
?>