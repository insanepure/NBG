<?php
include 'inc/incoben.php';
if(logged_in()){      

}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                                           
//Hier kommt der Code hin
//Hier kommt der Code hin
}
//nicht eingeloggt , zeige Loginfenster
else{
include 'inc/design3.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
include 'inc/mainindex.php';
}
include 'inc/design2.php'; ?>