<?php
session_start();
?>

<?php
session_unset();
session_destroy();
echo "THIS SESSION HAS EXPIRED<br>";
echo '<a href="index.php">Homepage</a>';
?>