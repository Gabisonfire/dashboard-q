<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Main</title>
        <!-- Bootstrap CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- bootstrap theme -->
        <link href="css/bootstrap-theme.css" rel="stylesheet">
        <!--external css-->
        <!-- font icon -->
        <link href="css/elegant-icons-style.css" rel="stylesheet" />
        <link href="css/font-awesome.min.css" rel="stylesheet" />
        <!-- Custom styles -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />
        <link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
        <?php
            if(!file_exists("config.ini"))
            {
                echo "<span class=\"info-center\">Config not found, redirecting to setup.</span>";
                echo "<script> window.location.href=\"settings.php\";</script>";
                //Exit(1);
            }
        
            if(!file_exists("bookmarks.dat")){
                echo "<span class=\"error-center\">Failed to load bookmarks.dat</span>";
                echo "<script> window.location.href='bookmarks.php' </script>";
            }  
        
        
        include 'requests.php';
        //$cfg is loaded from requests.php
        echo '<meta http-equiv="refresh" content="' . $cfg['refresh_seconds'] . '" >';
        ?>
    </head>
    <body>
        <?php
        
 
        
            // Process requests
            $client = strtolower($cfg['torrent_client']);
            if( $client == "qbittorrent"){
                $torrents = getRequest("/query/torrents?filter=all&sort=name");
                $global_info = getRequest("/query/transferInfo");
            } elseif ($client == "transmission"){
                $torrents = transmissionTorrents();
    	        $global_info = transmissionAll();
            }
            //Show Errors?
            $show_errors = $cfg['show_errors'];
            //Show Weather
            if( $cfg['show_weather'] == "true"){
                $weather = weather();
            }
        ?>
    
        <!--main content start-->
        <section id="main-content">
            <!--overview start-->
            <section class="wrapper-frame">
                <!--Dashboard and Weather Row-->
                <!--Dashboard section-->
                <div class="row">
                    <div class="col-lg-6">
                        <h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
                    </div>
                    <!--Weather Section-->
                    <div class="col-1">
                        <?php if($cfg['show_weather'] == "true"){ ?>
                            <canvas id="weather-canvas" width="64" height="64"></canvas>
                            <script src="js/skycons.js"></script>
                            <script>
                                var icons = new Skycons();
                                icons.set("weather-canvas", "<?php echo $weather[1];?>");
                                icons.play();
                            </script>
                        <?php } ?>
                    </div>
                    <div class="col-5">
                        <?php if($cfg['show_weather'] == "true"){ ?>
                            <h3 class="page-header"><?php echo "<b>" . round($weather[2]) . "</b>, " . $weather[0] . ",  Feels like <b>" . round($weather[3]) . "</b>";?></h3>
                        <?php } ?>
                    </div>
                </div>
                <!--Breadcrumb Section-->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li><i class="fa fa-home"></i><a href="home.php">Home</a></li>
                            <li><i class="fa fa-laptop"></i>Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!--Downloading and Seeding Section-->
                <?php
                    if (!$cfg['torrent_client'] == ""){
                        include 'torrents_info.php';
                    }
                ?>
                <!--prtg section-->
                <?php
                    if ($cfg['show_prtg'] == "true"){
                        include 'prtg.php';
                    }
                ?>
                <!--Torrent List section-->
                <?php
                    if (!$cfg['torrent_client'] == ""){
                        include 'torrents_listing.php';
                    }
                ?>
                <!--Error display-->
                <?php
                    if($show_errors && count($errors) > 0){
                        echo "<div class=\"row\">";
                        echo "<div class=\"col-lg-12 col-md-3 col-sm-12 col-xs-12\">";
                        echo "<div class=\"info-box red-bg\">";
                        echo "<h3><span style=\"color: black; font-weight: bold;\">Errors</span></h3>";
                        foreach($errors as $err){
                            echo "<span style=\"color: black; font-weight: bold;\">" . $err . "</span><br>";
                        }
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                ?>
            </section>
            <!--overview end-->
        </section>
        <!--main content end-->

        <!-- container section start -->
        <!-- javascripts -->
        <script src="js/jquery.js"></script>
        <script src="js/jquery-ui-1.10.4.min.js"></script>
        <script src="js/jquery-1.8.3.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
        <!-- bootstrap -->
        <script src="js/bootstrap.min.js"></script>
        <!-- nice scroll -->
        <script src="js/jquery.scrollTo.min.js"></script>
        <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
        <!-- custom select -->
        <script src="js/jquery.customSelect.min.js" ></script>
        <!--custome script for all page-->
        <script src="js/scripts.js"></script>
        <!-- custom script for this page-->
        <script src="js/jquery.autosize.min.js"></script>
        <script src="js/jquery.placeholder.min.js"></script>
        <script src="js/jquery.slimscroll.min.js"></script>
        <!--weather scripts-->
        <script src="js/skycons.js"></script>
    </body>
</html>
