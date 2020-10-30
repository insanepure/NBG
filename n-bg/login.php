<?php
include_once 'inc/incoben.php';
$aktion = $_GET['aktion'];
$page = $_GET['page'];
$newsid = $_GET['nid'];
      
if(!logged_in()){
include 'inc/design3.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
include 'inc/login.php';
echo '<br/><a href="index.php">Zurück</a>';
}
include 'inc/design2.php'; ?>