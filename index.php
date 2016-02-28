<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Dashboard</title>

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
  	  <div class="frame">
		<iframe id="theframe" name="search_iframe" src="home.php" frameborder="0"></iframe>
	  </div>

  <!-- container section start -->
  <section id="container" class="">
     
      
      <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

            <!--logo start-->
            <a href="index.php" class="logo">gab<span class="lite">network</span></a>
            <!--logo end-->         
            </div>
			

      </header>      
      <!--header end-->

      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">		  
              <!-- sidebar menu start-->
              <ul class="sidebar-menu">                
                  <li class="active">
                      <a class="" href="home.php" target="search_iframe">
                          <i class="icon_desktop"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
				  <li class="">
                      <a href="https://192.168.0.0:32400/web/index.html" target="search_iframe">
                          <i class="arrow_triangle-right_alt2"></i>
                          <span>Plex</span>
                      </a>
                  </li>       
				  <li class="">
                      <a href="https://192.168.0.0/home/" target="search_iframe">
                          <i class="icon_calendar"></i>
                          <span>Sickrage</span>
                      </a>
                  </li>
                  <li>
                      <a href="https://192.168.0.0:8080" target="search_iframe">
                          <i class="icon_cloud-download_alt"></i>
                          <span>qBittorrent</span>
                      </a>
                  </li>
				  <li class="">
                      <a href="https://192.168.0.0:5050" target="search_iframe">
                          <i class="icon_film"></i>
                          <span>CouchPotato</span>
                      </a>
                  </li>
                             
				  <li class="">
                      <a href="https://192.168.0.0/public/login.htm?loginurl=%2Fpublic%2F&errormsg=" target="_blank">
                          <i class="icon_loading"></i>
                          <span>PRTG</span>
                      </a>
                  </li>
                  
				  <li class="">
                      <a href="https://192.168.0.0" target="_blank">
                          <i class="icon_flowchart"></i>
                          <span>Proxmox</span>
                      </a>
                  </li>
                  
              </ul>
              <!-- sidebar menu end-->
          </div>		  		  	
      </aside>
      <!--sidebar end-->

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
	<script src="js/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="js/jquery-jvectormap-world-mill-en.js"></script>
	<script src="js/jquery.autosize.min.js"></script>
	<script src="js/jquery.placeholder.min.js"></script>
	<script src="js/jquery.slimscroll.min.js"></script>
 

 

  </body>
</html>
