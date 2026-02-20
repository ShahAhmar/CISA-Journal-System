<?php
$file = 'assets/images/portal-hero.png';
if (file_exists($file)) {
    echo "<h1>Success! File found.</h1>";
    echo "<img src='$file' style='width:300px;'>";
} else {
    echo "<h1>Error! File NOT found at: " . realpath($file) . "</h1>";
    echo "Current Directory: " . getcwd();
}
?>