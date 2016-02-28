<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="refresh" content="300">

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
	<link href="css/widgets.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
	<link href="css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
  </head>
 <body>
 <?php
	// MAke request to get all torrents
	include 'requests.php';
	$cfg = parse_ini_file("config.ini");
	$torrents = getRequest("/query/torrents?filter=all&sort=name");
	$weather = weather();
 ?>
  <!--main content start-->
      <section id="main-content">
          <section class="wrapper-frame">            
              <!--overview start-->
			  <div class="row">	
			  		<div class="col-lg-6">
					<h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
					</div>
					<div class="col-1">
						<canvas id="weather-canvas" width="64" height="64"></canvas>
						<script src="js/skycons.js"></script>
						<script>						
						var icons = new Skycons();
						icons.set("weather-canvas", "<?php echo $weather[1];?>");
						icons.play();
						</script>						
					</div>
					<div class="col-5">					
					<h3 class="page-header"><?php echo "<b>" . round($weather[2]) . "</b>, " . $weather[0] . ",  Feels like <b>" . round($weather[3]) . "</b>";?></h3>		
					</div>
			  </div>
			  <div class="row">				
				<div class="col-lg-12">
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="home.php">Home</a></li>
						<li><i class="fa fa-laptop"></i>Dashboard</li>						  	
					</ol>
				</div>
			</div>
              
            <div class="row">			
				<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box blue-bg">
						<h3>Downloading</h3>						
						<?php
						foreach($torrents as $torrent)
						{
							if($torrent['state'] == "downloading")
							{
								echo $torrent['name'] . "<br>";
							}
						}
						?>
					</div><!--/.info-box-->			
				</div><!--/.col-->

				<div class="col-lg-6 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box green-bg">	
						<h3>Seeding</h3>
						<?php
						foreach($torrents as $torrent)
						{
							if($torrent['state'] == "uploading")
							{
								echo $torrent['name'] . "<br>";
							}
						}
						?>
					</div><!--/.info-box-->			
				</div><!--/.col-->
				
			</div><!--/.row-->	

			<div class="row">
				<div class="col-lg-12 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box-prtg white-bg">
					<?php
					global $cfg;
					echo "<iframe width=100% height=100% frameborder=\"0\" src=\"" . $cfg['prtg_map'] .  "\"></iframe>";
					?>
					<div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-12 col-md-3 col-sm-12 col-xs-12">
					<div class="info-box all-bg">
					<h3>All</h3>
						<?php
						foreach($torrents as $torrent)
						{							
							$ratio = $torrent['ratio'];
							if(strlen($ratio) > 4) 
							{
								$ratio = substr($ratio, 0, 4);
							}
							echo $torrent['name'] . "<span style=\"color: orange; font-weight: bold;\"> | Ratio: " . $ratio . "</span><br>";							
						}
						?>
					<div>
				</div>
			</div>
			
           </div>  
            
		  
		  <!-- Today status end -->
			

          </section>
      </section>
      <!--main content end-->
  </section>
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