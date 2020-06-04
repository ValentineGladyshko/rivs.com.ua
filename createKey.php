<?php 
$myfile = fopen("key.txt", "w");
$key = openssl_random_pseudo_bytes(32);
fwrite($myfile, base64_encode($key));
fclose($myfile);
?>