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
              <iframe id="theframe" name="search_iframe" src="home.php" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
	  </div>

  <!-- container section start -->
  <section id="container" class="">
     
      
      <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>


          
            <!-- Settings button-->
            <div id="settings_icon">
                <div class="icon-reorder tooltips" data-original-title="Settings" data-placement="bottom"><a href="settings.php" target="search_iframe"><i class="icon_adjust-vert"></i></a></div>
            </div>
            
            <div id="settings_icon">
                <div class="icon-reorder tooltips" data-original-title="Bookmarks" data-placement="bottom"><a href="bookmarks.php" target="search_iframe"><i class="icon_tags_alt"></i></a></div>
            </div>   

            <!--logo start-->
            <?php 
            include 'requests.php';
			echo '<a href=index.php class=logo>' . $cfg['title_first_part'] . '<span class=lite>' . " " . $cfg['title_second_part'] . '</span></a>';								
            
			if($cfg['show_storage'] == "true") {
				include 'storage.php';
			}			
            ?>
            <!--logo end-->

          <div class="clock">
              <span class="time-or"><?php echo date("h:")?><span class="time-blu"><?php echo date("i")?></span></span>
          </div>

          </div>
            
			

      </header>      
      <!--header end-->
      
 <?php    
 
        if(file_exists("bookmarks.dat")){    
            $bookmarks = array_map('trim', file("bookmarks.dat"));
        }
        
        class Bookmark {
            var $name;
            var $url;
            var $icon;
            var $iframe; 
            var $isCategory;
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
                        if(startsWith($bookmarks[$i], "isCategory="))
                        {
                            $new->isCategory = substr($bookmarks[$i], 11, strlen($bookmarks[$i]) - 11);
                            if($new->isCategory === "true") {$new->isCategory = true;} else $new->isCategory = false;
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
                  $firstpass = true;
                  echo "<ul class=\"accordion\">";
                  foreach($bms as $bm)
                  {
                      if ($bm->isCategory)
                      {
                         if($firstpass)
                         {
                             $firstpass = false;
                         }  else {
                            echo "</ul>";
                            echo "</li>";
                         }
                         echo "<li>";
                         echo "<a class=\"toggle\" href=\"javascript:void(0);\">";
                         echo "<i class=\"". $bm->icon ."\"></i>";
                         echo "<span>" . $bm->name ."</span>";
                         echo "</a>";
                         echo "<ul class=\"inner\">";
                      }
                      else {                        
                        echo "<li>";                      
                        if($bm->iframe)
                        {
                          echo "<a href=\"" . $bm->url . "\" target=\"search_iframe\">";
                        }
                        else
                        {
                          echo "<a href=\"" . $bm->url . "\" target=\"_blank\">";                        
                        }
                          echo "<i class=\"". $bm->icon ."\"></i>";
                          echo "<span>". $bm->name ."</span>";
                          echo "</a>";  
                          echo "</li>";
                      }
                  }  
                  echo "</ul>";
                  echo "</li>";
                  echo "</ul>";
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
    <!--custom script for all page-->
    <script src="js/scripts.js"></script>
    <!-- custom script for this page-->
	<script src="js/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="js/jquery-jvectormap-world-mill-en.js"></script>
	<script src="js/jquery.autosize.min.js"></script>
	<script src="js/jquery.placeholder.min.js"></script>
	<script src="js/jquery.slimscroll.min.js"></script>
        
<script>
    $('.toggle').click(function(e) {
    e.preventDefault();
  
    var $this = $(this);
  
    if ($this.next().hasClass('show')) {
        $this.next().removeClass('show');
        $this.next().slideUp(350);        
    } else {
        $this.parent().parent().find('li .inner').removeClass('show');
        $this.parent().parent().find('li .inner').slideUp(350);
        $this.next().toggleClass('show');
    }
});
</script>
  </body>
</html>
