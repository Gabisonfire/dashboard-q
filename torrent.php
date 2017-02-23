<div class="row">
    <!--Downloading Section-->
    <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box blue-bg">
            <h3>Downloading <span class="speeds">
            <?php
                if ($client == "qbittorent"){
                    echo round(intval($global_info['dl_info_speed'])/1000, 2) . " kB/s";
                } elseif ($client == "transmission"){
                    echo round(intval($global_info['downloadSpeed'])/1000, 2) . " kB/s";
                }
            ?>
            </span></h3>
            <?php
                if($torrents == null){
                    echo "There was a problem fetching torrents.";
                } else {
                    if ($client == "qbittorrent"){
                        foreach($torrents as $torrent){
                            if($torrent['state'] == "downloading"){
                                echo $torrent['name'] . "<br>";
                            }
                        }
                    } elseif ($client == "transmission"){
                        foreach($torrents['torrents'] as $torrent){
                            if($torrent['status'] == "4"){
                                echo $torrent['name'] . "<br>";
                            }
                        }
                    }
                }
            ?>
        </div><!--/.info-box-->
    </div><!--/.col-->
    <!--Seeding Section-->
    <div class="col-lg-6 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box green-bg">
            <h3>Seeding <span class="speeds">
                <?php
                    if ($client == "qbittorent"){
                        echo round(intval($global_info['up_info_speed'])/1000, 2) . " kB/s"; 
                    } elseif ($client == "transmission"){
                        echo round(intval($global_info['uploadSpeed'])/1000, 2) . " kB/s";
                    }
                ?>
            </span></h3>
            <?php
                if($torrents == null){
                    echo "There was a problem fetching torrents.";
                } else {
                    if ($client == "qbittorrent"){
                        foreach($torrents as $torrent){
                            if($torrent['state'] == "uploading"){
                                echo $torrent['name'] . "<br>";
                            }
                        }
                    } elseif ($client == "transmission"){
                        foreach($torrents['torrents'] as $torrent){
                            if($torrent['status'] == "6" && $torrent['peersGettingFromUs'] != "0"){
                                echo $torrent['name'] . "<br>";
                            }
                        }
                    }
                }
            ?>
        </div><!--/.info-box-->
    </div><!--/.col-->
</div><!--/.row-->
