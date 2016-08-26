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
            <?php 
            
            // Edit page title below
            $first_part = "MY";
            $second_part = "NETWORK";
            
            echo '<a href=\"index.php\" class=\"logo\">' . $first_part . '<span class=\"lite\">' . $second_part . '</span></a>';
            ?>
            <?php
            include 'requests.php';
            if ($cfg['free_storage']){
                        include 'free_storage';
            }
            if ($cfg['total_storage']){
                include 'total_storage';
            }
            $free_storage = ($cfg['free_storage']);
            $total_storage = ($cfg['total_storage']);
           
            /* get disk space free (in bytes) */
            $df = disk_free_space($free_storage);
            /* and get disk space total (in bytes)  */
            $dt = disk_total_space($total_storage);
            /* now we calculate the disk space used (in bytes) */
            $du = $dt - $df;
            /* percentage of disk used - this will be used to also set the width % of the progress bar */
            $dp = sprintf('%.2f',($du / $dt) * 100);
            /* and we formate the size from bytes to MB, GB, etc. */
            $df = formatSize($df);
            $du = formatSize($du);
            $dt = formatSize($dt);
            function formatSize( $bytes )
        {
            $types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
            for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
                   return( round( $bytes, 2 ) . " " . $types[$i] );
}
?>
            
            <div class="storage">        
                        <i class="icon_drive"></i><a href="http://192.168.100.244/admin/" target="_blank">
                        <?php echo "NAS Storage:  $du Used - $df Free - $dt Total"; ?>
                        </a>
                </div>           
            <div class="clock">
            <span class="time-or"><?php echo date("h:")?><span class="time-blu"><?php echo date("i")?></span></span>
            </div>
            <!--logo end-->         
            </div>
            
			

      </header>      
      <!--header end-->
      
 <?php
        if(!file_exists("bookmarks.dat")){
            echo "<span class=\"error-center\">Failed to load bookmarks.dat</span>";
            Exit(1);
        }
        
        $bookmarks = array_map('trim', file("bookmarks.dat"));
        
        class Bookmark {
            var $name;
            var $url;
            var $icon;
            var $iframe;                    
        }
        
        // Parse bookmarks file
        function spawnBookmarks()
        {
            $bookmark_array = [];
            global $bookmarks;
            for($i = 0; $i < count($bookmarks); $i++)
            {
                $bm = $bookmarks[$i];
                if(startsWith($bm, "[") && endsWith($bm, "]"))
                {
                    $new = new Bookmark();
                    $name = substr($bm, 1, strlen($bm)-2);
                    $new->name = trim($name);
                    do{
                        $i++;
                        if($i >= count($bookmarks)) {break;}
                        if(startsWith($bookmarks[$i], "url="))
                        {
                            $new->url = substr($bookmarks[$i], 4, strlen($bookmarks[$i]) - 4);
                        }
                        if(startsWith($bookmarks[$i], "icon="))
                        {
                            $new->icon = substr($bookmarks[$i], 5, strlen($bookmarks[$i]) - 5);
                        }
                        if(startsWith($bookmarks[$i], "iframe="))
                        {
                            $new->iframe = substr($bookmarks[$i], 7, strlen($bookmarks[$i]) - 7);
                            if($new->iframe === "true") {$new->iframe = true;} else $new->iframe = false;
                        }
                    } while (trim($bookmarks[$i]) !== "");
                    array_push($bookmark_array, $new);
                }
            }
            return $bookmark_array;
        }
      
        // Simple functions to check strings
        function startsWith($haystack, $needle)
        {
            $length = strlen($needle);
            return (substr($haystack, 0, $length) === $needle);
        }

        function endsWith($haystack, $needle)
        {
            $length = strlen($needle);
            if ($length == 0) {
                return true;
            }

            return (substr($haystack, -$length) === $needle);
        }      
      ?>
      
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
                  <?php
                  $bms = spawnBookmarks();
                  foreach($bms as $bm)
                  {
                      echo "<li class=\"\">";                      
                      if($bm->iframe)
                        echo "<a href=\"" . $bm->url . "\" target=\"search_iframe\">";
                      else
                        echo "<a href=\"" . $bm->url . "\" target=\"_blank\">";
                        echo "<i class=\"". $bm->icon ."\"></i>";
                        echo "<span>". $bm->name ."</span>";
                        echo "</a>";
                        echo "</li>";
                  }                                                      
                  ?>		
                  
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
