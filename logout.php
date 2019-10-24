<?php


?>



<?php
session_start();
session_unset();
session_destroy();




include 'init.php';

echo "<div class='loginErorrs'>";
echo "<div class='container alert alert-success'>  <i class='far fa-check-circle'></i> Good Bey ! :) </div>";
echo "</div>";


header("refresh:1 , url=index.php");


exit();


include $tmpl . 'footer.php';


 ?>