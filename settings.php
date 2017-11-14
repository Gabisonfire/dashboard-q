<!DOCTYPE html>
<html lang="en">
<head>
    <link href="css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.png">
</head>


<!-- Generic function for loading settings from $cfg array -->
<?php
    // Returns true if true else false for anything else
    function LoadSettingsBool($arr, $toLoad) {
        return $arr[$toLoad] == "true";
    }

?>

<!-- Load Settings -->
<?php
    if(file_exists("config.ini")) {
    include 'requests.php';
    ?>
    <div id="settings_page">
        <form action="savesettings.php" method="POST">
        <h1>Dashboard-q Settings</h1>
        <table id="settings_table">
            <tr>
                <td>Torrent client:</td>
                <td>
                    <select name="torrent_client">
                        <?php
                            if($cfg['torrent_client'] == "qbittorrent"){
                        ?>
                        <option value="qbittorrent" selected="selected">qBittorrent</option>
                        <option value="transmission">Transmission</option>
                        <option value="">Disable</option>
                        <?php }
                            else if
                                ($cfg['torrent_client'] == "transmission") {
                        ?>
                            <option value="transmission" selected="selected">Transmission</option>
                            <option value="qbittorrent">qBittorrent</option>
                            <option value="">Disable</option>
                            <?php }
                            else if
                            ($cfg['torrent_client'] == "") {
                                ?>
                            <option value="transmission">Transmission</option>
                            <option value="qbittorrent">qBittorrent</option>
                            <option value="" selected="selected">Disable</option>
                        <?php } else { ?>
                        <option value="qbittorrent">qBittorrent</option>
                        <option value="transmission">Transmission</option>
                        <option value="">Disable</option>
                        <?php }?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Torrent username</td>
                <td><input type="text" name="torrent_username" value="<?php echo $cfg["torrent_username"];?>"></td>
            </tr>
            <tr>
                <td>Torrent password</td>
                <td><input type="password" name="torrent_password" value="<?php echo $cfg["torrent_password"];?>"></td>
            </tr>
            <tr>
                <td>Torrent host ip/hostname</td>
                <td><input type="text" name="torrent_host" value="<?php echo $cfg["torrent_host"];?>"></td>
            </tr>
            <tr>
                <td>Torrent client port</td>
                <td><input type="text" name="torrent_port" value="<?php echo $cfg["torrent_port"];?>"></td>
            </tr>
            <tr>
                <td>PRTG map URL</td>
                <td><input type="text" name="prtg_map" value="<?php echo $cfg["prtg_map"];?>"></td>
            </tr>
            <tr>
                <td>Forecast API Key</td>
                <td><input type="text" name="forecast_key" value="<?php echo $cfg["forecast_key"];?>"></td>
            </tr>
            <tr>
                <td>Forecast API Latitude</td>
                <td><input type="text" name="forecast_lat" value="<?php echo $cfg["forecast_lat"];?>"></td>
            </tr>
            <tr>
                <td>Forecast API Longitude</td>
                <td><input type="text" name="forecast_long" value="<?php echo $cfg["forecast_long"];?>"></td>
            </tr>
            <tr>
                <td>Show Errors</td>
                <td>
                    <select name="show_errors">
                        <?php if (LoadSettingsBool($cfg, "show_errors")){ ?>
                            <option value="true" selected="selected">yes</option>
                            <option value="false">no</option>
                        <?php } else {?>
                            <option value="false" selected="selected">no</option>
                            <option value="true">yes</option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Show Weather</td>
                <td>
                    <select name="show_weather">
                    <?php
                    if (LoadSettingsBool($cfg, "show_weather")){
                        ?>
                        <option value="true" selected="selected">yes</option>
                        <option value="false">no</option>
                    <?php } else {?>
                        <option value="false" selected="selected">no</option>
                        <option value="true">yes</option>
                    <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Show PRTG</td>
                <td>
                    <select name="show_prtg">
                    <?php
                    if (LoadSettingsBool($cfg, "show_prtg")){
                        ?>
                        <option value="true" selected="selected">yes</option>
                        <option value="false">no</option>
                    <?php } else {?>
                        <option value="false" selected="selected">no</option>
                        <option value="true">yes</option>
                    <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Show Storage</td>
                <td>
                    <select name="show_storage">
                    <?php
                    if (LoadSettingsBool($cfg, "show_storage")){
                        ?>
                        <option value="true" selected="selected">yes</option>
                        <option value="false">no</option>
                    <?php } else {?>
                        <option value="false" selected="selected">no</option>
                        <option value="true">yes</option>
                    <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Auto-Refresh interval (secs)</td>
                <td><input type="text" name="refresh_seconds" value="<?php echo $cfg["refresh_seconds"];?>"></td>
            </tr>
            <tr>
                <td>Storage path</td>
                <td><input type="text" name="storage_path" value="<?php echo $cfg["storage_path"];?>"></td>
            </tr>
            <tr>
                <td>Storage label</td>
                <td><input type="text" name="storage_name" value="<?php echo $cfg["storage_name"];?>"></td>
            </tr>
            <tr>
                <td>Title first part</td>
                <td><input type="text" name="title_first_part" value="<?php echo $cfg["title_first_part"];?>"></td>
            </tr>
            <tr>
                <td>Title second part</td>
                <td><input type="text" name="title_second_part" value="<?php echo $cfg["title_second_part"];?>"></td>
            </tr>
            <tr>
                <td colspan="2"><input id="save_button" type="submit" name="save_changes" value="Save Changes"></td>
            </tr>
        </table>
        </form>
    </div>


    <?php }
    else {

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
        //initiate an empty array and write to file
        $cfg = [
            "torrent_client" => "",
            "torrent_username" => "",
            "torrent_password" => "",
            "torrent_host" => "",
            "torrent_port" => "",
            "prtg_map" => "",
            "forecast_key" => "",
            "forecast_lat" => "",
            "forecast_long" => "",
            "show_errors" => "",
            "show_weather" => "",
            "show_prtg" => "",
            "show_storage" => "",
            "refresh_seconds" => "",
            "storage_path" => "",
            "storage_name" => "",
            "title_first_part" => "",
            "title_second_part" => "",
            "initial_setup" => true,
        ];
        write_ini_file($cfg, "config.ini");
        echo "<script> window.location.href = \"settings.php\";</script>";
    }
    ?>