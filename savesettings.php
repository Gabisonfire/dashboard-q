<?php
include 'requests.php';

// We check if initial setup before writing it to file in case it gets reloaded(because its not re-written to the config file).
$init = isset($cfg['initial_setup']);

$cfg['torrent_client'] = $_POST['torrent_client'];
$cfg['torrent_username'] = $_POST['torrent_username'];
$cfg['torrent_password'] = $_POST['torrent_password'];
$cfg['torrent_host'] = $_POST['torrent_host'];
$cfg['torrent_port'] = $_POST['torrent_port'];
$cfg['prtg_map'] = $_POST['prtg_map'];
$cfg['forecast_key'] = $_POST['forecast_key'];
$cfg['forecast_lat'] = $_POST['forecast_lat'];
$cfg['forecast_long'] = $_POST['forecast_long'];
$cfg['show_errors'] = $_POST['show_errors'];
$cfg['show_prtg'] = $_POST['show_prtg'];
$cfg['show_storage'] = $_POST['show_storage'];
$cfg['show_weather'] = $_POST['show_weather'];
$cfg['refresh_seconds'] = $_POST['refresh_seconds'];
$cfg['storage_path'] = $_POST['storage_path'];
$cfg['storage_name'] = $_POST['storage_name'];
$cfg['title_first_part'] = $_POST['title_first_part'];
$cfg['title_second_part'] = $_POST['title_second_part'];

if($init)
{
    unset($cfg['initial_setup']);
}

function write_ini_file($assoc_arr, $path, $has_sections=FALSE) {
    $content = "";
    if ($has_sections) {
        foreach ($assoc_arr as $key=>$elem) {
            $content .= "[".$key."]\n";
            foreach ($elem as $key2=>$elem2) {
                if(is_array($elem2))
                {
                    for($i=0;$i<count($elem2);$i++)
                    {
                        $content .= $key2."[] = \"".$elem2[$i]."\"\n";
                    }
                }
                else if($elem2=="") $content .= $key2." = \n";
                else $content .= $key2." = \"".$elem2."\"\n";
            }
        }
    }
    else {
        foreach ($assoc_arr as $key=>$elem) {
            if(is_array($elem))
            {
                for($i=0;$i<count($elem);$i++)
                {
                    $content .= $key."[] = \"".$elem[$i]."\"\n";
                }
            }
            else if($elem=="") $content .= $key." = \n";
            else $content .= $key." = \"".$elem."\"\n";
        }
    }

    if (!$handle = fopen($path, 'w')) {
        return false;
    }

    $success = fwrite($handle, $content);
    fclose($handle);

    return $success;
}

write_ini_file($cfg, "config.ini");
echo "<script> window.top.location.reload();</script>";