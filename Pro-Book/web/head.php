<?php 
    function generateHead($pageName){
        echo "<head>";
        echo "<meta charset=\"utf-8\">";
        echo "<title>$pageName Page</title>";
        echo "<link rel=\"stylesheet\" href=\"../css/$pageName.css\">";
        echo "</head>";
    }
?>