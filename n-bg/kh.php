<?php
include 'inc/incoben.php';
if(logged_in()){              
$uid = getwert(session_id(),"charaktere","id","session");   
$uhp = getwert(session_id(),"charaktere","hp","session");   
$umhp = getwert(session_id(),"charaktere","mhp","session");  
$uchakra = getwert(session_id(),"charaktere","chakra","session");  
$umchakra = getwert(session_id(),"charaktere","mchakra","session"); 
$hk = ($umhp-$uhp)+($umchakra-$uchakra);
$aktion = $_GET['aktion'];     
if($aktion == "heil"){        
$uaktion = getwert(session_id(),"charaktere","aktion","session");
if($uaktion == ""){      
if($uhp < $umhp||$uchakra < $umchakra){
$uryo = getwert(session_id(),"charaktere","ryo","session"); 
if($uryo >= $hk){
$nryo = $uryo-$hk;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                              
$sql="UPDATE charaktere SET aktion ='Krankenhausbesuch',ryo ='$nryo',aktiond ='60',aktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                
mysqli_close($con);
$error = "Du heilst dich im Krankenhaus.";

}
}
else{
$error = 'Du bist bereits vollständig geheilt.';
}


}
else{
$error = 'Du tust bereits etwas.';
}

}
}
if(logged_in()){
include 'inc/design1.php';   
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}     
if($uhp < $umhp||$uchakra < $umchakra){
echo '<b>Du kannst dich hier für <b class="shadow">'.$hk.'</b> Ryo komplett heilen.';  
echo '<br>';          
echo 'Die Heilung dauert <b class="shadow">eine Stunde</b>.</b>';
echo '<br>';                                                       
echo '<br>';           
echo '<form method="post" action="kh.php?aktion=heil"><input class="button" name="login" id="login" value="heilen" type="submit"></form>';
}
else{
echo '<b>Du kannst dich hier heilen lassen.';
echo '<br>';
echo 'Komm wieder, wenn du nicht schon vollständig geheilt bist.';
}
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