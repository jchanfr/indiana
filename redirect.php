<?php
if(isset($_GET["c"])){
	$url = $_GET["l"];
	header("location: ". $url);
    exit;
}
?>