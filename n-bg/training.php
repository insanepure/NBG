<?php
include 'inc/incoben.php';
if(logged_in()){
$aktion = $_GET['aktion'];                                      
$uclan = getwert(session_id(),"charaktere","clan","session");  
if($aktion == "entspannen"){  
$uaktion = getwert(session_id(),"charaktere","aktion","session");  
if($uaktion == ""){    
$dauer = $_POST['dauer'];
if($dauer < 1){
$dauer = 1;
}
if($dauer > 10){
$dauer = 10;
}
if(is_numeric($dauer)){
$dauer = $dauer*60;   
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));       
$uid = getwert(session_id(),"charaktere","id","session");  
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                          
$sql="UPDATE charaktere SET aktion ='Entspannen',aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                
mysqli_close($con);
$error = "Du entspannst dich ein wenig."; 

}
else{
$error = "Für die Dauer wurde keine gültige Zeit angegeben.";
}
}
else{
$error = "Du tust bereits etwas.";
}
}
if($aktion == "training"){   
$uaktion = getwert(session_id(),"charaktere","aktion","session");  
if($uaktion == ""){
$was = $_POST['was'];   
$dauer = $_POST['dauer'];
if($dauer < 1){
$dauer = 1;
}
if($dauer > 336){
$dauer = 336;
}
if(is_numeric($dauer)){
$dauer = $dauer*60;     
if($was == "HP"||$was == "Chakra"||$was == "Kraft"||$was == "Tempo"||$was == "Intelligenz"||$was == "Genauigkeit"||$was == "Chakrakontrolle"||$was == "Widerstand"){
if($uclan == "tai"&&$was != "Intelligenz"&&$was != "Chakrakontrolle"||$uclan != "tai"){
if($was == "HP"){
$wert = 'hp';
}         
if($was == "Chakra"){
$wert = 'chakra';
}        
if($was == "Kraft"){
$wert = 'kr';
}               
if($was == "Tempo"){
$wert = 'tmp';
}                
if($was == "Intelligenz"){
$wert = 'intl';
}                  
if($was == "Genauigkeit"){
$wert = 'gnk';
}                 
if($was == "Chakrakontrolle"){
$wert = 'chrk';
}                  
if($was == "Widerstand"){
$wert = 'wid';
} 
$uwertm = getwert(session_id(),"charaktere","m$wert","session");
if($uwertm < 10000&&$was != "Chakra"&&$was != "HP"||$uwertm < 100000&&$was == "Chakra"||$uwertm < 100000&&$was == "HP"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));       
$uid = getwert(session_id(),"charaktere","id","session");   
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                         
$sql="UPDATE charaktere SET aktion ='$was trainieren',aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                
mysqli_close($con);
$error = "Du trainierst nun ".$was.'!'; 
}
else{
$error = "Du kannst das nicht noch mehr trainieren.";
}
}
else{
$error = 'Als Tai kannst du keine Intelligenz und Chakrakontrolle trainieren.';
}
}
else{
$error = "Du kannst das nicht trainieren.";
}
}
else{
$error = "Für die Dauer wurde keine gültige Zeit angegeben.";
}
}
else{
$error = "Du tust bereits etwas.";
}
}

}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
echo '<h2 class="shadow">Training</h2>';
echo '<form method="post" action="training.php?aktion=training">';
echo '<table width="100%">';
echo '<tr>';
echo '<td align="center">';
echo '<div class="auswahl">';
echo '<select name="was">';              
echo '<option value="HP">HP</option>';  
echo '<option value="Chakra">Chakra</option>';   
echo '<option value="Kraft">Kraft</option>';   
echo '<option value="Tempo">Tempo</option>';  
if($uclan != 'tai'){
echo '<option value="Intelligenz">Intelligenz</option>';  
echo '<option value="Chakrakontrolle">Chakrakontrolle</option>'; 
}
echo '<option value="Genauigkeit">Genauigkeit</option>';  
echo '<option value="Widerstand">Widerstand</option>'; 
echo '</select>';  
echo '</div>';   
echo '</td>';
echo '</tr>';   
echo '<tr>';
echo '<td align="center">';
echo '<div class="auswahl">';
echo ' <select name="dauer">';
$tempint = 0;  
while($tempint < 47){
$tempint++;
echo '<option value="'.$tempint.'">'.$tempint.'';
if($tempint == 1){
echo ' Stunde</option>';
}
else{  
echo ' Stunden</option>';
}    
}           
$tempint = 1;  
while($tempint < 14){
$tempint++;
$tempint2 = $tempint*24;
echo '<option value="'.$tempint2.'">'.$tempint.'';
if($tempint == 1){
echo ' Tag</option>';
}
else{  
echo ' Tage</option>';
}    
}
echo ' </select>';    
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<input class="button" name="login" id="login" value="trainieren" type="submit">';
echo '</form>';    
echo '<br>';
echo '<h3>Entspannen</h3>';
echo '<br>';
echo '(10% HP und Chakra pro Stunde)';    
echo '<br>';
echo '<form method="post" action="training.php?aktion=entspannen">';
echo '<table width="100%">';
echo '<td align="center">';
echo '<div class="auswahl">';
echo ' <select name="dauer">';
$tempint = 0;  
while($tempint < 10){
$tempint++;
echo '<option value="'.$tempint.'">'.$tempint.'';
if($tempint == 1){
echo ' Stunde</option>';
}
else{  
echo ' Stunden</option>';
}    
}           
echo ' </select>';    
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<input class="button" name="login" id="login" value="entspannen" type="submit">';
echo '</form>';    
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