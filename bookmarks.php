<!DOCTYPE html>
<html lang="en">
    <head>
        <style>
            #bm-listbox {width: 600px; }
            #deleteText {font-weight: bold; color: red;}
        </style>
    </head>
<body>
    <h1> Bookmarks</h1>
    <button id="home" onclick="window.location.href='home.php'">Home</button><br><br>
<?php

if( isset($_POST['bookmarks']))
{
    file_put_contents("bookmarks.dat", $_POST['bookmarks']);    
    echo "<script> window.top.location.reload(); </script>";
}



if (!file_exists("bookmarks.dat")) {
    file_put_contents("bookmarks.dat", "");
    echo "<script> window.location.href='bookmarks.php' </script>";
}

$bookmarks = array_map('trim', file("bookmarks.dat"));

class Bookmark {

    var $name;
    var $url;
    var $icon;
    var $iframe;
    var $isCategory;
    var $delete;

}

// Parse bookmarks file
function spawnBookmarks() {
    $bookmark_array = [];
    global $bookmarks;
    for ($i = 0; $i < count($bookmarks); $i++) {
        $bm = $bookmarks[$i];
        if (startsWith($bm, "[") && endsWith($bm, "]")) {
            $new = new Bookmark();
            $name = substr($bm, 1, strlen($bm) - 2);
            $new->name = trim($name);
            do {
                $i++;
                if ($i >= count($bookmarks)) {
                    break;
                }
                if (startsWith($bookmarks[$i], "url=")) {
                    $new->url = substr($bookmarks[$i], 4, strlen($bookmarks[$i]) - 4);
                }
                if (startsWith($bookmarks[$i], "icon=")) {
                    $new->icon = substr($bookmarks[$i], 5, strlen($bookmarks[$i]) - 5);
                }
                if (startsWith($bookmarks[$i], "iframe=")) {
                    $new->iframe = substr($bookmarks[$i], 7, strlen($bookmarks[$i]) - 7);
                    if ($new->iframe === "true") {
                        $new->iframe = true;
                    } else
                        $new->iframe = false;
                }
                if (startsWith($bookmarks[$i], "isCategory=")) {
                    $new->isCategory = substr($bookmarks[$i], 11, strlen($bookmarks[$i]) - 11);
                    if ($new->isCategory === "true") {
                        $new->isCategory = true;
                    } else
                        $new->isCategory = false;
                }
            } while (trim($bookmarks[$i]) !== "");
            array_push($bookmark_array, $new);
        }
    }
    return $bookmark_array;
}

// Simple functions to check strings
function startsWith($haystack, $needle) {
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle) {
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

$bookmarks = spawnBookmarks();

echo "<select onChange=\"loadBookmark(this)\" id=\"bm-listbox\" name=\"bm-listbox\" size=\"" . sizeof($bookmarks). "\">";
foreach($bookmarks as $bm)
{
    echo "<option value=\"" . $bm->name . "\">" . $bm->name . "</option>";    
}
echo "</select>";
?>
<br>
<br>
<form action="bookmarks.php" method="post">
  Name:<br>
  <input type="text" id="name" name="name" value="">
  <br>
  URL:<br>
  <input type="text" id="url" name="url" value="">
  <br>
  Icon:<br>
  <input type="text" id="icon" name="icon" value=""> <a href="https://www.elegantthemes.com/blog/resources/elegant-icon-font" target="_blank">Reference</a>
  <br><br>  
  Display in iframe?: <input type="checkbox" id="iframe" name="iframe">
  <br>
  is Category?: <input type="checkbox" id="iscategory" name="iscategory">
  <br>
  <br>
  <label id="deleteText" for="delete">Delete:</label><input type="checkbox" id="delete" name="delete">
  <br>
  <br> 
  <input type="hidden" name="bookmarks" id="bookmarks">
</form> 
<button id="moveup" onclick="moveUp()">Move Up</button><button id="movedown" onclick="moveDown()">Move Down</button> <br><br>
<button id="save" onclick="saveBookmarks(null)">Save</button> <span> If the name does not exist, a new bookmark will be created.</span>
</body>

<script type='text/javascript'>
    function loadBookmark(bm)
    {
        var b_array = <?php echo json_encode($bookmarks); ?>;
        var bm_name = bm.options[bm.selectedIndex].value;
        for (index = 0; index < b_array.length; index++)
        {
            if(b_array[index].name == bm_name)
            {
                document.getElementById('name').value = b_array[index].name;
                document.getElementById('url').value = b_array[index].url;
                document.getElementById('icon').value = b_array[index].icon;
                document.getElementById('iframe').checked = b_array[index].iframe;
                document.getElementById('iscategory').checked = b_array[index].isCategory;
            }
        }
    }
    
    function saveBookmarks(bookmark_array)
    {
        var b_array;
        if(bookmark_array == null)
        {
            b_array = <?php echo json_encode($bookmarks); ?>;
        }  else {
            b_array = bookmark_array;
        }
        var bm_name = document.getElementById('name').value;
        if(!bm_name) {return;}
        var exists = false;
        // Check if exists and make modifications
        for (index = 0; index < b_array.length; index++)
        {
            if(b_array[index].name == bm_name)
            {
                exists = true;
                b_array[index].url = document.getElementById('url').value;
                b_array[index].icon = document.getElementById('icon').value;
                b_array[index].iframe = document.getElementById('iframe').checked;
                b_array[index].isCategory = document.getElementById('iscategory').checked;
                b_array[index].delete = document.getElementById('delete').checked;
                break;
            }            
        }
        if(!exists)
        {
            b_array.push({
                "name" : bm_name,
                "url" : document.getElementById('url').value,
                "icon" : document.getElementById('icon').value,
                "iframe" : document.getElementById('iframe').checked,
                "isCategory" : document.getElementById('iscategory').checked});
        }

        // Save array to file and reload page.
        var text = "";
        for (index = 0; index < b_array.length; index++)
        {
            if(b_array[index].delete) {continue;}
            text+= "[" + b_array[index].name + "]\n" +
                    "url=" + b_array[index].url + "\n" +
                    "icon=" + b_array[index].icon + "\n" +
                    "iframe=" + b_array[index].iframe + "\n" +
                    "isCategory=" + b_array[index].isCategory + "\n\n";
            
        }
        var bookmarks = document.getElementById('bookmarks');
        bookmarks.value = text;
        bookmarks.form.submit();
    }
    
    function moveUp()
    {
        var b_array = <?php echo json_encode($bookmarks); ?>;
        var bm_name = document.getElementById('name').value;
        var original_position;
        if(!bm_name) {return;}
        for (index = 0; index < b_array.length; index++)
        {
            if(b_array[index].name == bm_name)
            {
                original_position = index;
                break;
            }            
        }
        if(original_position > 0)
        {
            var temp = b_array[original_position - 1];
            b_array[original_position - 1] = b_array[original_position];
            b_array[original_position] = temp;
            saveBookmarks(b_array);
        }
    }
    
    function moveDown()
    {
        var b_array = <?php echo json_encode($bookmarks); ?>;
        var bm_name = document.getElementById('name').value;
        var original_position;
        if(!bm_name) {return;}
        for (index = 0; index < b_array.length; index++)
        {
            if(b_array[index].name == bm_name)
            {
                original_position = index;
                break;
            }            
        }
        if(original_position + 2 <= b_array.length && b_array.length > 1)
        {
            var temp = b_array[original_position + 1];
            b_array[original_position + 1] = b_array[original_position];
            b_array[original_position] = temp;
            saveBookmarks(b_array);
        }
    }
</script>
</html>