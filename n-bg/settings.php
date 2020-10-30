<?php
include 'inc/incoben.php';
$aktion = $_GET['aktion'];
if(logged_in()){                                            
if($aktion == "tutorial"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));     
$uid = getwert(session_id(),"charaktere","id","session");   
$sql="UPDATE charaktere SET tutorial ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);  
$error = "Tutorial wird wiederholt.";
}
if($aktion == "kdata"){
$wahl = $_POST['wahl'];
if($wahl == "Ja"||$wahl == "Nein"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($wahl == "Ja"){
$kdata = 1;          
$error = "Kriegsdaten werden nun angezeigt.";
}
if($wahl == "Nein"){
$kdata = 0;       
$error = "Kriegsdaten werden nicht mehr angezeigt.";
}                                                      
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET kdata ='$kdata' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}
}    
if($aktion == "themes"){
$autoplay = $_POST['autoplay'];
if($autoplay == "Ja"||$autoplay == "Nein"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($autoplay == "Ja"){
$autoplay = 1;
}
if($autoplay == "Nein"){
$autoplay = 0;
}                               
$uid = getwert(session_id(),"charaktere","id","session");     
$sql="UPDATE charaktere SET autoplay ='$autoplay' WHERE id = '".$uid."' LIMIT 1";    
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = "Themes-Status geändert.";
}
} 
if($aktion == "chat"){
$wahl = $_POST['wahl'];
if($wahl == "Ja"||$wahl == "Nein"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($wahl == "Ja"){
$chat = 1;
}
if($wahl == "Nein"){
$chat = 0;
}                   
$uid = getwert(session_id(),"charaktere","id","session");                 
$sql="UPDATE charaktere SET chat ='$chat' WHERE id = '".$uid."' LIMIT 1";    
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = "Chateinstellungen geändert.";
}
}     
if($aktion == "kbutton"){        
$kampfid = getwert(session_id(),"charaktere","kampfid","session");
if($kampfid == 0){
$button = $_GET['button'];               
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");     
$count = 0;
$geht = 0;                   
$array = explode(";", trim($ujutsus));
while(isset($array[$count])){   
if($array[$count] == $button){
$geht = 1;
}
$count++;
}
if($geht == 1){   
$was = $_GET['was'];      
$ukbutton = getwert(session_id(),"charaktere","kbutton","session");   
$anzahl = 0;
$hatbut = 0;   
$hschlag = 0;
$htritt = 0;
$array = explode(";", trim($ukbutton));
while($array[$anzahl] != ""){
if($array[$anzahl] == 1||$array[$anzahl] == 2||$array[$anzahl] == 456||$array[$anzahl] == 457){
$hatben = $hatben+1;
}
if($array[$anzahl] == $button){
$hatbut = 1;
}
$anzahl++;
}
if($was == "add"){ 
if($hatbut == 0){  
//1;2;3;4;5  
if($anzahl < 15){
if($ukbutton == ""){
$nkbutton = $button;
}
else{   
$nkbutton = $ukbutton.';'.$button;

}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET kbutton ='$nkbutton' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = "Du hast ein Jutsus für den Kampf hinzugefügt.";

}
else{
$error = "Du kannst nicht mehr als 15 Jutsus für den Kampf hinzufügen.";
}
}
else{
$error = "Du hast das Jutsu schon für den Kampf hinzugefügt.";
}

}
if($was == "del"){      
if($hatbut == 1){ 
if($anzahl > 1){
 
if($hatben > 1||$hatben == 1&&$button != 1&&$button != 2&&$button != 456&&$button != 457){    
$count = 0;
$nkbutton = "";
while(isset($array[$count])){   
if($array[$count] != $button){
if($nkbutton == ""){
$nkbutton = $array[$count];
}
else{
$nkbutton = $nkbutton.';'.$array[$count];
}
}
$count++;
}  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET kbutton ='$nkbutton' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = "Du hast einen Jutsu vom Kampf entfernt.";
}
else{
$error = "Du benötigst Schlag oder Tritt.";
}
}
else{
$error = "Du musst mindestens ein Jutsu haben.";
}
}
else{
$error = "Dieses Jutsu hast du noch nicht für den Kampf hinzugefügt, es kann daher nicht entfernt werden.";
}
}
}
else{
$error = "Du besitzt dieses Jutsu nicht.";
}
}
else{
$error = "Du befindest dich in einem Kampf.";
}
}  
if($aktion == "mapc"){
$mapc = real_escape_string($_POST['mapc']);
if($mapc != ""){

if($mapc == "1"||$mapc == "2"||$mapc == "3"||$mapc == "4"||$mapc == "5"||$mapc == "6"){   
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET mapc ='$mapc' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);       
$error = "Charakter der Map geändert.<br>";

}
else{
$error = $error."Diese Möglichkeit gibt es nicht.<br>";
}

}
}
if($aktion == "delete"){
$wahl = $_POST['wahl'];
$check = $_POST['check'];
if($wahl == "Ja"&&$check == "check"){     
$kampfid = getwert(session_id(),"charaktere","kampfid","session");  
$org = getwert(session_id(),"charaktere","org","session");
if($org == "0"){
if($kampfid == 0){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");
$sql="DELETE FROM freunde WHERE an = '".$uid."' OR von = '".$uid."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}             
$sql="DELETE FROM ignoriert WHERE user = '".$uid."' OR ignoriert = '".$uid."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$sql="DELETE FROM summon WHERE besitzer = '".$uid."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM items WHERE besitzer = '".$uid."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM markt WHERE besitzer = '".$uid."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM charaktere WHERE id = '".$uid."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);       
$error = "Account gelöscht.<br>";
}
else{
$error = "Du kannst dich im Kampf nicht löschen.<br>";
}
}
else{
$error = 'Verlasse zunächst dein Team/deine Organisation.<br>';
}
}
}
if($aktion == "changepw"){                            
$pw1 = real_escape_string($_POST['pw1']);       
$pw2 = real_escape_string($_POST['pw2']);
if($pw1 == '')
{
  $error = 'Das Passwort ist ungültig.<br/>';
}
else if($pw1 == $pw2)
{
  $account->ChangePassword($pw1);
  $error = 'Du hast dein Passwort geändert.<br/>';
}
else{
$error = "Die Passwörter stimmen nicht überein.<br>";
}
}
if($aktion == "design"){                            
$design = real_escape_string($_POST['design']);
if($design == "naruto"||$design == "sasuke"||$design == "rocklee"||$design == 'akatsuki'||$design == 'sakura'||$design == 'chidori'||$design == 'kisame'||$design == 'gaara'||$design == "neji"||$design == "aburame"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET design ='$design' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$error = "Du hast dein Design geändert.<br>";
mysqli_close($con);  
}
else{
$error = "Das Design gibt es nicht.<br>";
}
}
}

if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                                                                 
echo '<h2 class="shadow">Einstellungen</h2>';        
echo '<table width="100%">';
echo '<tr>';
$design = getwert(session_id(),"charaktere","design","session");
echo '<td colspan="2">';
echo '<h3>Kampfjutsus</h3>';
//1;2;3                                                     
$ukbutton = getwert(session_id(),"charaktere","kbutton","session");
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");  
$array = explode(";", trim($ujutsus));
$count = 0;                  
$count2 = 0;                 
echo '<table width="100%">';
echo '<tr>';
while(isset($array[$count])){       
$jname = getwert($array[$count],"jutsus","name","id");
$jbild = getwert($array[$count],"jutsus","bild","id");
$jchakra = getwert($array[$count],"jutsus","chakra","id");
$jdmg = getwert($array[$count],"jutsus","dmg","id");
$jart = getwert($array[$count],"jutsus","art","id");
echo '<td>';                  
$array2 = explode(";", trim($ukbutton));
$count3 = 0;           
$haktiv = 0;
while($array2[$count3] != ""){
if($array2[$count3] == $array[$count]){
$haktiv = 1;
}
$count3++;
}
if($haktiv == 1)
{
echo '<a class="sinfo" href="settings.php?aktion=kbutton&was=del&button='.$array[$count].'">';
echo '<img border="0" src="bilder/jutsus/'.strtolower($jbild).'a.png" width="50px" height="50px">';
}
else
{
echo '<a class="sinfo" href="settings.php?aktion=kbutton&was=add&button='.$array[$count].'">';
echo '<img border="0" src="bilder/jutsus/'.strtolower($jbild).'.png" width="50px" height="50px">';
}
echo '</img><span class="spanmap">';
echo 'Name: '.$jname.'<br/>';
echo 'Chakra: '.$jchakra.'<br/>';
echo 'Art: ';
if($jart == "1"){
echo 'Schaden';
}
if($jart == "2"){
echo 'Verteidigung';
}
if($jart == "3"){
echo 'Bunshin';
}
if($jart == "4"){
echo 'Henge';
}
if($jart == "5"){
echo 'Rufen';
}
if($jart == "6"||$jart == "14"){
echo 'Powerup';
}
if($jart == "7"){
echo 'Debuff';
}
if($jart == "8"){
echo 'Item werfen';
}
if($jart == "9"){
echo 'Item einnehmen';
}
if($jart == "10"){
echo 'Heilung';
}
if($jart == "11"){
echo 'Schaden (mehrere)';
}
if($jart == "12"){
echo 'Heilung (selbst)';
}
if($jart == "13"){
echo 'Spezial';
}
if($jart == "15"){
echo 'Kombination';
}
if($jart == "16"){
echo 'Heilung (mehrere)';
}
if($jart == "1"||$jart == 15||$jart == 16||$jart == 2||$jart == 10||$jart == 11||$jart == 12){
echo '<br/>';
echo 'Wert: ';
echo $jdmg;
}
if($jart == "6"||$jart == "14"){
$req = explode(";", trim($jdmg));
if($req[0] != 0){
$inc = $req[0];
echo 'HP: '.$inc.'%';
echo '<br>';
}
if($req[1] != 0){
$inc = $req[1];
echo 'Chakra: '.$inc.'%';
echo '<br>';
}
if($req[2] != 0){
$inc = $req[2];
echo 'Kraft: '.$inc.'%';
echo '<br>';
}
if($req[3] != 0){
$inc = $req[3];
echo 'Tempo: '.$inc.'%';
echo '<br>';
}
if($req[4] != 0){
$inc = $req[4];
echo 'Intelligenz: '.$inc.'%';
echo '<br>';
}
if($req[5] != 0){
$inc = $req[5];
echo 'Genauigkeit: '.$inc.'%';
echo '<br>';
}
if($req[6] != 0){
$inc = $req[6];
echo 'Chakrakontrolle: '.$inc.'%';
echo '<br>';
}
if($req[7] != 0){
$inc = $req[7];
echo 'Widerstand: '.$inc.'%';
echo '<br>';
}
}
if($jart == "7"){
$req = explode(";", trim($jdmg));
if($req[0] != 0){
$inc = $req[0];
echo 'Kraft: '.$inc.'%';
echo '<br>';
}
if($req[1] != 0){
$inc = $req[1];
echo 'Tempo: '.$inc.'%';
echo '<br>';
}
if($req[2] != 0){
$inc = $req[2];
echo 'Intelligenz: '.$inc.'%';
echo '<br>';
}
if($req[3] != 0){
$inc = $req[3];
echo 'Genauigkeit: '.$inc.'%';
echo '<br>';
}
if($req[4] != 0){
$inc = $req[4];
echo 'Chakrakontrolle: '.$inc.'%';
echo '<br>';
}
if($req[5] != 0){
$inc = $req[5];
echo 'Widerstand: '.$inc.'%';
echo '<br>';
}
}
if($jart == "8"){
$multi = getwert($jdmg,"item","werte","name");
echo $multi;
}
if($jart == "9"){
$multi = getwert($jdmg,"item","werte","name");
$req = explode(";", trim($multi));
if($req[0] != 0){
$inc = $req[0];
echo 'HP: '.$inc.'%';
echo '<br>';
}
if($req[1] != 0){
$inc = $req[1];
echo 'Chakra: '.$inc.'%';
echo '<br>';
}
if($req[2] != 0){
$inc = $req[2];
echo 'Kraft: '.$inc.'%';
echo '<br>';
}
if($req[3] != 0){
$inc = $req[3];
echo 'Tempo: '.$inc.'%';
echo '<br>';
}
if($req[4] != 0){
$inc = $req[4];
echo 'Intelligenz: '.$inc.'%';
echo '<br>';
}
if($req[5] != 0){
$inc = $req[5];
echo 'Genauigkeit: '.$inc.'%';
echo '<br>';
}
if($req[6] != 0){
$inc = $req[6];
echo 'Chakrakontrolle: '.$inc.'%';
echo '<br>';
}
if($req[7] != 0){
$inc = $req[7];
echo 'Widerstand: '.$inc.'%';
echo '<br>';
}
}
echo '<br/>';
echo '</span>
</a>';
$count++;         
echo '</td>';
$count2++;
if($count2 == 5&&$array[$count] != ""){
$count2 = 0;
echo '</tr><tr>';
}
}             
echo '</tr>';
echo '</table>';  

echo '</td>';
echo '</tr>';   
echo '<tr>';   
echo '<td>';
echo '<h3 class="shadow">Themes</h3>';     
$autoplay = getwert(session_id(),"charaktere","autoplay","session");
echo '<form method="post" action="settings.php?aktion=themes">';
echo '<center><div class="auswahl">';
echo '<select name="autoplay">';  
if($autoplay == "1"){            
echo '<option value="Ja" selected>Automatisch abspielen</option>';
}
else{   
echo '<option value="Ja">Automatisch abspielen</option>';
}
if($autoplay == "0"){            
echo '<option value="Nein" selected>Nicht abspielen</option>';
}
else{   
echo '<option value="Nein">Nicht abspielen</option>';
}   
echo '</select>';
echo '</div>';
echo '</center>';  
echo '<br>';
echo '<input class="button" name="login" id="login" value="senden" type="submit">';
echo '</form>';   
echo '</td>';
echo '<td>';    
echo '<h3 class="shadow">Design</h3>';
echo '<form method="post" action="settings.php?aktion=design">';
echo '<center><div class="auswahl">';
echo '<select name="design">';  
if($design == "naruto"){            
echo '<option value="naruto" selected>Naruto</option>';
}
else{   
echo '<option value="naruto">Naruto</option>';
}
if($design == "sasuke"){            
echo '<option value="sasuke" selected>Sasuke</option>';
}
else{   
echo '<option value="sasuke">Sasuke</option>';
}   
if($design == "rocklee"){            
echo '<option value="rocklee" selected>Rock Lee</option>';
}
else{   
echo '<option value="rocklee">Rock Lee</option>';
}     
if($design == "akatsuki"){            
echo '<option value="akatsuki" selected>Akatsuki</option>';
}
else{   
echo '<option value="akatsuki">Akatsuki</option>';
}     
if($design == "sakura"){            
echo '<option value="sakura" selected>Sakura</option>';
}
else{   
echo '<option value="sakura">Sakura</option>';
}     
if($design == "chidori"){            
echo '<option value="chidori" selected>Chidori</option>';
}
else{   
echo '<option value="chidori">Chidori</option>';
}     
if($design == "gaara"){            
echo '<option value="gaara" selected>Gaara</option>';
}
else{   
echo '<option value="gaara">Gaara</option>';
}          
if($design == "kisame"){            
echo '<option value="kisame" selected>Kisame</option>';
}
else{   
echo '<option value="kisame">Kisame</option>';
}        
if($design == "neji"){            
echo '<option value="neji" selected>Neji</option>';
}
else{   
echo '<option value="neji">Neji</option>';
}       
if($design == "aburame"){            
echo '<option value="aburame" selected>Aburame</option>';
}
else{   
echo '<option value="aburame">Aburame</option>';
}
echo '</select>';
echo '</div></center>';  
echo '<br>';
echo '<input class="button" name="login" id="login" value="ändern" type="submit">';
echo '</form>';       
echo '<br>';    
echo '</td></tr>';
echo '<tr>';   
$mapc = getwert(session_id(),"charaktere","mapc","session");
echo '<td align="center">';
echo '<h3 class="shadow">Mapcharakter</h3>';
echo '<form method="post" action="settings.php?aktion=mapc">';
echo '<table>';
echo '<tr>';
echo '<td>';
if($mapc == '1'){
echo '<input type="radio" name="mapc" value="1" checked>';
}
else{   
echo '<input type="radio" name="mapc" value="1">';
}
echo '<img src="bilder/map/char1.gif">';
echo '</td>';   
echo '<td>';
if($mapc == '2'){
echo '<input type="radio" name="mapc" value="2" checked>';
}
else{   
echo '<input type="radio" name="mapc" value="2">';
}
echo '<img src="bilder/map/char2.gif">';
echo '</td>';
echo '</tr>';   
echo '<tr>';
echo '<td>';
if($mapc == '3'){
echo '<input type="radio" name="mapc" value="3" checked>';
}
else{   
echo '<input type="radio" name="mapc" value="3">';
}
echo '<img src="bilder/map/char3.gif">';
echo '</td>';   
echo '<td>';
if($mapc == '4'){
echo '<input type="radio" name="mapc" value="4" checked>';
}
else{   
echo '<input type="radio" name="mapc" value="4">';
}
echo '<img src="bilder/map/char4.gif">';
echo '</td>';
echo '</tr>';   
echo '<tr>';
echo '<td>';
if($mapc == '5'){
echo '<input type="radio" name="mapc" value="5" checked>';
}
else{   
echo '<input type="radio" name="mapc" value="5">';
}
echo '<img src="bilder/map/char5.gif">';
echo '</td>';   
echo '<td>';
if($mapc == '6'){
echo '<input type="radio" name="mapc" value="6" checked>';
}
else{   
echo '<input type="radio" name="mapc" value="6">';
}
echo '<img src="bilder/map/char6.gif">';
echo '</td>';
echo '</tr>';  
echo '</table>';
echo '<input class="button" name="login" id="login" value="ändern" type="submit">';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<h3 class="shadow">Chat</h3>';     
$chat = getwert(session_id(),"charaktere","chat","session");
echo '<form method="post" action="settings.php?aktion=chat">';
echo '<center><div class="auswahl">';
echo '<select name="wahl">';  
if($chat == "1"){            
echo '<option value="Ja" selected>Aktivieren</option>';
}
else{   
echo '<option value="Ja">Aktivieren</option>';
}
if($chat == "0"){            
echo '<option value="Nein" selected>Deaktivieren</option>';
}
else{   
echo '<option value="Nein">Deaktivieren</option>';
}   
echo '</select>';
echo '</div>';
echo '</center>';  
echo '<br>';
echo '<input class="button" name="login" id="login" value="senden" type="submit">';
echo '</form>';    
echo '</td></tr>';
echo '<tr>';
echo '<td><h2 class="shadow">Tutorial</h2>';
echo '<form method="post" action="settings.php?aktion=tutorial">';     
echo '<input class="button" name="login" id="login" value="Tutorial wiederholen" type="submit">';
echo '</form>';       
echo '<br>';    
echo '</td>';  
echo '<td><h2 class="shadow">Kriegsdaten</h2>';
$kdata = getwert(session_id(),"charaktere","kdata","session");
echo '<form method="post" action="settings.php?aktion=kdata">';
echo '<center><div class="auswahl">';
echo '<select name="wahl">';  
if($kdata == "1"){            
echo '<option value="Ja" selected>Aktivieren</option>';
}
else{   
echo '<option value="Ja">Aktivieren</option>';
}
if($kdata == "0"){            
echo '<option value="Nein" selected>Deaktivieren</option>';
}
else{   
echo '<option value="Nein">Deaktivieren</option>';
}   
echo '</select>';
echo '</div>';
echo '</center>';  
echo '<br>';
echo '<input class="button" name="login" id="login" value="senden" type="submit">';
echo '</form>';       
echo '<br>';    
echo '</td></tr>';   
echo '<tr>'; 
echo '<td>';
echo '<h3 class="shadow">Passwort</h3>';   
echo '<form method="post" action="settings.php?aktion=changepw">';
echo '<center>';
echo '<table>';
echo '<tr>';
echo '<td>Passwort</td>';
echo '<td>';
echo '<div class="eingabe1">
<input class="eingabe2" name="pw1" id="userpass1" value="" size="15" maxlength="30" type="password">
</div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>wiederholen</td>';
echo '<td>';
echo '<div class="eingabe1">
<input class="eingabe2" name="pw2" id="userpass2" value="" size="15" maxlength="30" type="password">
</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</center>';  
echo '<input class="button" name="login" id="login" value="ändern" type="submit">';
echo '</form>';    
echo '</td>';
echo '<td>';
echo '<h3 class="shadow">Charakter</h3>';   
echo '<form method="post" action="settings.php?aktion=delete">';
echo '<center><div class="auswahl">';
echo '<select name="wahl">';     
echo '<option value="Ja">Löschen</option>';        
echo '<option value="Nein" selected>Nicht löschen</option>';
echo '</select>';
echo '</div>';
echo '<input class="cursor" type="checkbox" name="check" value="check"> Sicher?';
echo '</center>';  
echo '<br>';
echo '<input class="button" name="login" id="login" value="löschen" type="submit">';
echo '</form>';    
echo '</td>';
echo '</tr>';
echo '</table>';         
//$acc = getwert(session_id(),"charaktere","acc","session"); 
//$pwd = getwert(session_id(),"charaktere","pw","session");
//echo '<a href="http://chat.narutobg.de/login.php?wo=nbg&acc='.$acc.'&password='.$pwd.'">Testchat</a>';  
//echo '<br><a href="#" onClick="Fenster2('."'http://chat.narutobg.de/login.php?wo=nbg&acc=".$acc."&password=".$pwd."'".')" class="sinfo">Popup</a>';     
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