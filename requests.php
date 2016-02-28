<?php	
	include 'forecast.io.php';
	$cfg = parse_ini_file("config.ini");

   // Get SID from qBittorrent API
  function authenticate()
  {    
	global $cfg;
    $ch = curl_init();
    $creds = 'username=' . urlencode($cfg['username']) . '&password=' . urlencode($cfg['password']);
    $url = $cfg['qbittorrent_url'] . "/login";
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_POST, 1);         
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$creds);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
    curl_setopt($ch,CURLOPT_TIMEOUT, 20);
    $response = curl_exec($ch);  
    $buffer = explode("\n", $response);
    $start = strpos($buffer[4], "SID=");
    $stop = strpos($buffer[4], "; path");
    $sid = substr($buffer[4], $start + 4, strlen($buffer[4]) - $stop - $start - 6); 
    return array($sid, $ch);
  }
  
  // MAke get request to qBittorrent API
  function getRequest($query)
  {
	global $cfg;
    $url = $cfg['qbittorrent_url'] . $query;
    $content = authenticate();
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
    $response = curl_exec($ch);
    $response = json_decode($response, true);
    curl_close($ch);
    return $response;  
  }
  
  // Get Request to forecast.io API
  function weather()
  {
	global $cfg;
	$api_key = $cfg['forecast_key'];
	$latitude = $cfg['forecast_lat'];
	$longitude = $cfg['forecast_long'];
	$units = 'auto';  
	$lang = 'en';
	$forecast = new ForecastIO($api_key, $units, $lang);
	$condition = $forecast->getCurrentConditions($latitude, $longitude);
	return array($condition->getSummary(), $condition->getIcon(), $condition->getTemperature(), $condition->getApparentTemperature());
  }
?>