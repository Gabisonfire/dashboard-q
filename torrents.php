<div class="row">
    <div class="col-lg-12 col-md-3 col-sm-12 col-xs-12">
        <div class="info-box all-bg">
            <h3>All</h3>
            <?php
                if($torrents == null){
                    echo "There was a problem fetching torrents.";
                } else {
                    if ($client == "qbittorrent"){
                        foreach($torrents as $torrent){
                            $ratio = $torrent['ratio'];
                            if(strlen($ratio) > 4){
                                $ratio = substr($ratio, 0, 4);
                            }
                        echo $torrent['name'] . "<span style=\"color: orange; font-weight: bold;\"> | Ratio: " . $ratio . "</span><br>";
                        }
                    } elseif ($client == "transmission"){
                        foreach($torrents['torrents'] as $torrent){
                            $ratio = $torrent['uploadRatio'];
                            if(strlen($ratio) > 4){
                                $ratio = substr($ratio, 0, 4);
                            }
                        echo $torrent['name'] . "<span style=\"color: orange; font-weight: bold;\"> | Ratio: " . $ratio . "</span><br>";
                        }
                    }
                }
            ?>
        </div>
    </div>
</div>