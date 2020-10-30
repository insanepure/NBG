<?php
include 'inc/incoben.php';
// Hier kommen Skripts hin die vorm Laden ausgeführt werden
if(logged_in()){
$aktion = $_GET['aktion'];                                            
$uid = getwert(session_id(),"charaktere","id","session");   
if($aktion == 'dorfdecline'){
$dorf = $_GET['dorf'];
$ninv = getwert($dorf,"orte","nukeinvite","id");                        
$array = explode(";", trim($ninv));   
$count = 0;
$geht = 0;
$ninvites = '';
while(isset($array[$count])){      
if($array[$count] == $uid){
$geht = 1;
}
else{
if($ninvites == ''){
$ninvites = $array[$count];
}
else{
$ninvites = $ninvites.';'.$array[$count];
}
}
$count++;
}
if($geht == 1){   
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
    $sql="UPDATE orte SET nukeinvite ='$ninvites' WHERE id = '".$dorf."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }
      $error = 'Du bist dem Dorf nicht beigetreten.';
      mysqli_close($con);
} 
}
if($aktion == 'dorfaccept'){     
$kin = getwert(session_id(),"charaktere","kin","session"); 
$bijuu = getwert(session_id(),"charaktere","bijuu","session"); 
if($kin == 0||$bijuu != ''){
$dorf = $_GET['dorf'];
$ninv = getwert($dorf,"orte","nukeinvite","id");                        
$array = explode(";", trim($ninv));   
$count = 0;
$geht = 0;
$ninvites = '';
while(isset($array[$count])){      
if($array[$count] == $uid){
$geht = 1;
}
else{
if($ninvites == ''){
$ninvites = $array[$count];
}
else{
$ninvites = $ninvites.';'.$array[$count];
}
}
$count++;
} 
if($geht == 1){   
$uort = getwert(session_id(),"charaktere","ort","session"); 
$uorg = getwert(session_id(),"charaktere","org","session");       
$umissi = getwert(session_id(),"charaktere","mission","session");
if($umissi == '0'){
if($uorg == 0){
if($uort == $dorf){         
$ulevel = getwert(session_id(),"charaktere","level","session");     
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
if($ulevel < 20){
$nrank = 'genin';
}
else{
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer
FROM
items
WHERE besitzer="'.$uid.'" AND name = "Chuunin Weste" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$hatweste = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$hatweste = 1;
}
$result->close();$db->close(); 
if($ulevel < 30){
if($hatweste == 1){
$nrank = 'chuunin';
}
else{
$nrank = 'genin';
}
}
else{
if($ulevel < 50){
$nrank = 'chuunin';
}
else{
$nrank = 'jounin';
}
}
}
 $sql="UPDATE charaktere SET rank ='$nrank',mmissi ='0',dorf ='$dorf' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }             
      $sql="UPDATE items SET bild ='bilder/items/stirnband.png',name ='Stirnband' WHERE besitzer = '".$uid."' AND name='Nuke Stirnband' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }   
      $sql="DELETE FROM items WHERE besitzer = '".$uid."' AND name='Nuke-Nin Mantel'";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      } 
    $sql="UPDATE orte SET nukeinvite ='$ninvites' WHERE id = '".$dorf."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }
      $error = 'Du bist dem Dorf beigetreten.';
      mysqli_close($con);
}
else{
$error = 'Du musst dich in dem Dorf befinden.';
}
}
else{
$error = 'Du musst zuerst deine Organisation verlassen.';
}
}
else{
$error = "Auf einer Mission kannst du nicht zum Dorfninja werden.";
}
}
}
else{
$error = 'Du musst zunächst den Krieg verlassen.';
}
}  
if($aktion == "stats"){                               
$uclan = getwert(session_id(),"charaktere","clan","session");   
$ukid = getwert(session_id(),"charaktere","kampfid","session"); 
if($ukid == 0){  
$geht = 1;
$hp = $_POST['hp']; 
if($hp < 0){
$geht = 0;
} 
$chakra = $_POST['chakra']; 
if($chakra < 0){
$geht = 0;
}
$kraft = $_POST['kraft']; 
if($kraft < 0){
$geht = 0;
}
$wid = $_POST['wid']; 
if($wid < 0){
$geht = 0;
} 
if($uclan != "tai"){
$int = $_POST['int']; 
if($int < 0){
$geht = 0;
}  

$chrk = $_POST['chrk']; 
if($chrk < 0){
$geht = 0;
} 
}
else{
$int = 0; 
$chrk = 0;
}  
$tmp = $_POST['tmp']; 
if($tmp < 0){
$geht = 0;
}  
$gnk = $_POST['gnk'];    
if($gnk < 0){
$geht = 0;
}  
if($geht == 1){                                    
$ustats = getwert(session_id(),"charaktere","statspunkte","session");   
$werte = $kraft+$wid+$int+$chrk+$tmp+$gnk+$hp+$chakra;
if($werte <= $ustats){
$ustats = $ustats-$werte;      
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
if($chakra != 0){        
$uwert = getwert(session_id(),"charaktere","mchakra","session");  
$uwert2 = getwert(session_id(),"charaktere","chakra","session"); 
$nwert = ($chakra*10)+$uwert;           
if($nwert > 100000){
$ustats = $ustats+($nwert-100000);
$nwert = 100000;
}         
$nplus = $nwert-$uwert; 
$nwert2 = $uwert2+$nplus;       
if($nwert2 > 100000){
$nwert2 = 100000;
}  
$sql="UPDATE charaktere SET mchakra ='$nwert',chakra ='$nwert2' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
} 
if($hp != 0){        
$uwert = getwert(session_id(),"charaktere","mhp","session");  
$uwert2 = getwert(session_id(),"charaktere","hp","session"); 
$nwert = ($hp*10)+$uwert;           
if($nwert > 100000){
$ustats = $ustats+($nwert-100000);
$nwert = 100000;
}             
$nplus = $nwert-$uwert; 
$nwert2 = $uwert2+$nplus;     
if($nwert2 > 100000){
$nwert2 = 100000;
}  
$sql="UPDATE charaktere SET mhp ='$nwert',hp ='$nwert2' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
} 
if($kraft != 0){        
$uwert = getwert(session_id(),"charaktere","mkr","session"); 
$nwert = $kraft+$uwert;     
if($nwert > 10000){
$ustats = $ustats+($nwert-10000);
$nwert = 10000;
} 
$sql="UPDATE charaktere SET mkr ='$nwert',kr ='$nwert' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
}
if($wid != 0){        
$uwert = getwert(session_id(),"charaktere","mwid","session"); 
$nwert = $wid+$uwert;     
if($nwert > 10000){
$ustats = $ustats+($nwert-10000);
$nwert = 10000;
} 
$sql="UPDATE charaktere SET mwid ='$nwert',wid ='$nwert' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
}  
if($int != 0){        
$uwert = getwert(session_id(),"charaktere","mintl","session"); 
$nwert = $int+$uwert; 
if($nwert > 10000){
$ustats = $ustats+($nwert-10000);
$nwert = 10000;
}  
$sql="UPDATE charaktere SET mintl ='$nwert',intl ='$nwert' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
}
if($chrk != 0){        
$uwert = getwert(session_id(),"charaktere","mchrk","session"); 
$nwert = $chrk+$uwert;  
if($nwert > 10000){
$ustats = $ustats+($nwert-10000);
$nwert = 10000;
} 
$sql="UPDATE charaktere SET mchrk ='$nwert',chrk ='$nwert' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}      
}
if($tmp != 0){        
$uwert = getwert(session_id(),"charaktere","mtmp","session"); 
$nwert = $tmp+$uwert;      
if($nwert > 10000){
$ustats = $ustats+($nwert-10000);
$nwert = 10000;
} 
$sql="UPDATE charaktere SET mtmp ='$nwert',tmp ='$nwert' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
}
if($gnk != 0){        
$uwert = getwert(session_id(),"charaktere","mgnk","session"); 
$nwert = $gnk+$uwert;
if($nwert > 10000){
$ustats = $ustats+($nwert-10000);
$nwert = 10000;
}  
$sql="UPDATE charaktere SET mgnk ='$nwert',gnk ='$nwert' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
}    
$uwert2 = 0;          
$uwert = getwert(session_id(),"charaktere","mhp","session");  
$uwert2 = $uwert+$uwert2;    
$uwert = getwert(session_id(),"charaktere","mchakra","session");  
$uwert2 = $uwert+$uwert2;                          
$uwert = getwert(session_id(),"charaktere","mkr","session");  
$uwert2 = $uwert+$uwert2;                      
$uwert = getwert(session_id(),"charaktere","mwid","session");  
$uwert2 = $uwert+$uwert2;                       
$uwert = getwert(session_id(),"charaktere","mtmp","session");  
$uwert2 = $uwert+$uwert2;                       
$uwert = getwert(session_id(),"charaktere","mchrk","session");  
$uwert2 = $uwert+$uwert2;     
$uwert = getwert(session_id(),"charaktere","mintl","session");  
$uwert2 = $uwert+$uwert2;                 
$uwert = getwert(session_id(),"charaktere","mgnk","session");  
$uwert2 = $uwert+$uwert2;   
if($uclan != "tai"){       
$mwert = 260000;       
}
else{ 
$mwert = 240020;       
}
if($uwert2 == $mwert){
$ustats = 0;
}
$sql="UPDATE charaktere SET statspunkte ='$ustats' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$error = "Deine Statspunkte wurden erfolgreich verteilt."; 
mysqli_close($con);

}
else{
$error = "Die Werte ergeben mehr als die Statspunkte, die du hast.";
}

}
else{
$error = "Du kannst nicht irgendwo Minus setzen.";
}
}
else{
$error = "Du kannst in einem Kampf die Punkte nicht verteilen.";
}
}  
if($aktion == "abbrechen"){          
$uaktion = getwert(session_id(),"charaktere","aktion","session"); 
if($_POST['check'] == 'Ja'){
if($uaktion != ""){          
$ukid = getwert(session_id(),"charaktere","kampfid","session");  
if($ukid == 0){
if($uaktion == "Entspannen"){   
$uhp = getwert(session_id(),"charaktere","hp","session");    
$umhp = getwert(session_id(),"charaktere","mhp","session"); 
$uchakra = getwert(session_id(),"charaktere","chakra","session");    
$umchakra = getwert(session_id(),"charaktere","mchakra","session");     
$aktiond = getwert(session_id(),"charaktere","aktiond","session");  
$aktions = getwert(session_id(),"charaktere","aktions","session"); 
$zeit = time();
$zeit2 = strtotime($aktions);
$zeit3 = $zeit-$zeit2; 
$zeit3 = $zeit3/3600;
$zeit3 = floor($zeit3);
$nhp = ($umhp/10)*$zeit3; 
$nhp = round($nhp);
$uhp = $nhp+$uhp;                 
if($uhp > $umhp){
$uhp = $umhp;
}
$nchakra = ($umchakra/10)*$zeit3;  
$uchakra = $nchakra+$uchakra;
if($uchakra > $umchakra){
$uchakra = $umchakra;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET hp ='$uhp',chakra ='$uchakra' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con); 


}
$trainieren = substr($uaktion,-10);
if($trainieren == "trainieren"){           
$wert = substr($uaktion,0,-11); 
if($wert == "HP"){
$wert = 'hp';
}         
if($wert == "Chakra"){
$wert = 'chakra';
}        
if($wert == "Kraft"){
$wert = 'kr';
}               
if($wert == "Tempo"){
$wert = 'tmp';
}                
if($wert == "Intelligenz"){
$wert = 'intl';
}                  
if($wert == "Genauigkeit"){
$wert = 'gnk';
}                 
if($wert == "Chakrakontrolle"){
$wert = 'chrk';
}                  
if($wert == "Widerstand"){
$wert = 'wid';
} 
$uwert = getwert(session_id(),"charaktere",$wert,"session");    
$uwertm = getwert(session_id(),"charaktere","m$wert","session");    
$aktiond = getwert(session_id(),"charaktere","aktiond","session");  
$aktions = getwert(session_id(),"charaktere","aktions","session"); 
$zeit = time();
$zeit2 = strtotime($aktions);
$zeit3 = $zeit-$zeit2; 
$zeit3 = floor($zeit3/60);
if($wert == "hp"||$wert == "chakra"){
$nwert = $uwert+(floor($zeit3/60)*10);
if($nwert > 100000){
$nwert = 100000;
}
$nwertm = $uwertm+(floor($zeit3/60)*10);   
if($nwertm > 100000){
$nwertm = 100000;
}
}
else{
$nwert = $uwert+floor($zeit3/60);  
if($nwert > 10000){
$nwert = 10000;
}
$nwertm = $uwertm+floor($zeit3/60);
if($nwertm > 10000){
$nwertm = 10000;
}
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET $wert ='$nwert',m$wert ='$nwertm' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con); 

}  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));        
$sql="UPDATE charaktere SET aktion ='', aktiond ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
mysqli_close($con); 
$error = "Aktion abgebrochen.";
}
}
}
}
}
?>
<?php //lädt jetzt erst das Design
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
echo '<h3>Charakter</h3><br>';  
$page = $_GET['page'];             
if($page == ""){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
angelegt,
besitzer,
typ
FROM
items
WHERE besitzer="'.$uid.'" AND typ="3" AND angelegt!=""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

$kra = 0;
$tmpa = 0;
$intla = 0;
$gnka = 0;
$chrka = 0;
$wida = 0;                           
$ulevel = getwert(session_id(),"charaktere","level","session"); 
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$iwerte = getwert($row['name'],"item","werte","name"); 
$array = explode(";", trim($iwerte));    
if($array[0] != 0){ 
$ilevel = substr($array[0], -1);
if($ilevel == "L"){              
$ilevel = substr($array[0], 0,-1);
$ilevel = $ilevel*$ulevel;
if($ilevel >= 500){
$ilevel = 500;
}
$kra = $kra+$ilevel;
}
else{
$kra = $kra+$array[0];
}
}
if($array[1] != 0){
$ilevel = substr($array[1], -1);
if($ilevel == "L"){              
$ilevel = substr($array[1], 0,-1);
$ilevel = $ilevel*$ulevel;    
if($ilevel >= 500){
$ilevel = 500;
}
$intla = $intla+$ilevel;
}
else{
$intla = $intla+$array[1];
}
}
if($array[2] != 0){
$ilevel = substr($array[2], -1);
if($ilevel == "L"){
$ilevel = substr($array[2], 0,-1);
$ilevel = $ilevel*$ulevel;  
if($ilevel >= 500){
$ilevel = 500;
}
$chrka = $chrka+$ilevel;
}
else{
$chrka = $chrka+$array[2];
}
}
if($array[3] != 0){
$ilevel = substr($array[3], -1);
if($ilevel == "L"){              
$ilevel = substr($array[3], 0,-1);
$ilevel = $ilevel*$ulevel; 
if($ilevel >= 500){
$ilevel = 500;
}
$tmpa = $tmpa+$ilevel;
}
else{
$tmpa = $tmpa+$array[3];
}
}
if($array[4] != 0){
$ilevel = substr($array[4], -1);
if($ilevel == "L"){              
$ilevel = substr($array[4], 0,-1);
$ilevel = $ilevel*$ulevel;  
if($ilevel >= 500){
$ilevel = 500;
}
$gnka = $gnka+$ilevel;
}
else{
$gnka = $gnka+$array[4];
}
}  
if($array[5] != 0){    
$ilevel = substr($array[5], -1);
if($ilevel == "L"){              
$ilevel = substr($array[5], 0,-1);
$ilevel = $ilevel*$ulevel; 
if($ilevel >= 500){
$ilevel = 500;
}
$wida = $wida+$ilevel;
}
else{
$wida = $wida+$array[5];
}
}

}
$result->close();
$db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
level,
name,
clan,
dorf,
rank,
mhp,
mchakra,
mkr,
mintl,
mchrk,
mtmp,
mgnk,
mwid,
elemente,
vertrag,
session,
statspunkte,
dmissi,
cmissi,
bmissi,
amissi,
smissi,
mmissi,
siege,
niederlagen,
quotient,
wks
FROM
charaktere
WHERE session = "'.session_id().'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<table width=100%>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>HP</b><br>HP ist ein Wert, der angibt, wieviel Schaden du aushalten kannst.'";
echo ')" onMouseout="hidetext()">HP:</b></td>';
echo '<td width="25%" class="shadow">'.$row['mhp'];
echo '</td>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Chakra</b><br>Chakra beschreibt deine mentale Energie, die du für Jutsus benötigt.'";    
echo ')" onMouseout="hidetext()">Chakra:</b></td>';
echo '<td width="25%" class="shadow">'.$row['mchakra'];  
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Kraft</b><br>Kraft beschreibt die Stärke der Taijutsus.'";
echo ')" onMouseout="hidetext()">Kraft:</b></td>';
echo '<td width="25%" class="shadow">'.$row['mkr'];
if($kra != 0){
echo ' <b class="statsadd">+ '.$kra.'</b>';
}
echo '</td>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Tempo</b><br>Tempo beschreibt deine Schnelligkeit. Umso mehr Tempo du hast , umso größer ist die Chance , dass der Angriff des Gegners nicht trifft.'";
echo ')" onMouseout="hidetext()">Tempo:</b></td>';
echo '<td width="25%" class="shadow">'.$row['mtmp'];  
if($tmpa != 0){
echo ' <b class="statsadd">+ '.$tmpa.'</b>';
}
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Intelligenz</b><br>Intelligenz beschreibt die Stärke der Genjutsus.'";
echo ')" onMouseout="hidetext()">Intelligenz:</b></td>';
echo '<td width="25%" class="shadow">'.$row['mintl'];    
if($intla != 0){
echo ' <b class="statsadd">+ '.$intla.'</b>';
}
echo '</td>'; 
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Genauigkeit</b><br>Genauigkeit beschreibt die Konzentration auf den Gegner und gibt an, wie genau man zielt.'";
echo ')" onMouseout="hidetext()">Genauigkeit:</b></td>';
echo '<td width="25%" class="shadow">'.$row['mgnk'];   
if($gnka != 0){
echo ' <b class="statsadd">+ '.$gnka.'</b>';
}
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Chakrakontrolle</b><br>Chakrakontrolle beschreibt die Stärke der Ninjutsus.'";
echo ')" onMouseout="hidetext()">Chakrakontrolle:</b></td>';
echo '<td width="25%" class="shadow">'.$row['mchrk'];  
if($chrka != 0){
echo ' <b class="statsadd">+ '.$chrka.'</b>';
}
echo '</td>';  
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Widerstand</b><br>Widerstand beschreibt die mentale sowie die körperliche Stärke und gibt an, wie viel du körperlich bzw mental aushältst.'";
echo ')" onMouseout="hidetext()">Widerstand:</b></td>';
echo '<td width="25%" class="shadow">'.$row['mwid']; 
if($wida != 0){
echo ' <b class="statsadd">+ '.$wida.'</b>';
}
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Elemente</b><br>Es gibt fünf Elemente: Katon (Feuer) , Raiton (Blitz) , Suiton (Wasser) , Doton (Erde) und Fuuton (Wind).<br> Sie ermöglichen das lernen von speziellen Elementjutsus.'";
echo ')" onMouseout="hidetext()">Elemente:</b></td>'; 
echo '<td width="25%" class="shadow">';
$count = 0;
$array = explode(";", trim($row['elemente']));
while(isset($array[$count])){   
echo $array[$count].' ';
if($count == 2){
echo '<br>';
}
$count++;
}
echo '</td>';  
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Vertrag</b><br>Du kannst mit Tieren einen Vertrag abschließen. Du triffst sie auf deiner Reise zufällig.'";
echo ')" onMouseout="hidetext()">Vertrag:</b></td>';
echo '<td width="25%" class="shadow">'.ucwords($row['vertrag']); 
echo '</td>'; 
echo '</tr>'; 
echo '<tr>';
echo '<td width="25%">';
echo '<b class="shadowh" onMouseover="showtext(';
echo "'<b>D-Missionen</b><br>Erledigte Missionen auf den Rank D.'";
echo ')" onMouseout="hidetext()">D-Missionen:</b>';   
echo '<br>';
echo '<b class="shadowh" onMouseover="showtext(';
echo "'<b>C-Missionen</b><br>Erledigte Missionen auf den Rank C.'";
echo ')" onMouseout="hidetext()">C-Missionen:</b>'; 
echo '<br>';
echo '<b class="shadowh" onMouseover="showtext(';
echo "'<b>B-Missionen</b><br>Erledigte Missionen auf den Rank B.'";
echo ')" onMouseout="hidetext()">B-Missionen:</b>'; 
echo '<br>'; 
echo '</td>';   

echo '<td class="shadow" width="25%">';
echo $row['dmissi'].'<br>';   
echo $row['cmissi'].'<br>';
echo $row['bmissi'].'<br>';
echo '</td>';  
echo '<td width="25%">';
echo '<b class="shadowh" onMouseover="showtext(';
echo "'<b>A-Missionen</b><br>Erledigte Missionen auf den Rank A.'";
echo ')" onMouseout="hidetext()">A-Missionen:</b>';
echo '<br>';   
echo '<b class="shadowh" onMouseover="showtext(';
echo "'<b>S-Missionen</b><br>Erledigte Missionen auf den Rank S.'";
echo ')" onMouseout="hidetext()">S-Missionen:</b>';   
echo '<br>';  
echo '<b class="shadowh" onMouseover="showtext(';
echo "'<b>Kriminalität</b><br>Du erhältst Kriminalität Punkte, wenn du kriminelle Missionen machst.'";
echo ')" onMouseout="hidetext()">Kriminalität</b>';   
echo '<br>';
echo '</td>'; 
echo '<td class="shadow" width="25%">';
echo $row['amissi'].'<br>';   
echo $row['smissi'].'<br>';
echo $row['mmissi'].'<br>';
echo '</td>'; 
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Siege</b><br>Siege gibt an, wieviele Wertungskämpfe du gewonnen hast.'";
echo ')" onMouseout="hidetext()">Siege:</b></td>';
echo '<td width="25%" class="shadow">'.$row['siege'];  
echo '</td>';  
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Niederlagen</b><br>Niederlagen gibt an, wieviele Wertungskämpfe du verloren hast.'";
echo ')" onMouseout="hidetext()">Niederlagen:</b></td>';
echo '<td width="25%" class="shadow">'.$row['niederlagen']; 
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Quotient</b><br>Siege geteilt durch die Niederlagen'";
echo ')" onMouseout="hidetext()">Quotient:</b></td>';
echo '<td width="25%" class="shadow">'.$row['quotient'];  
echo '</td>';  
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Heutige Wertungskämpfe</b><br>Du kannst maximal 4 Wertungskämpfe am Tag machen.'";
echo ')" onMouseout="hidetext()">Heutige Kämpfe:</b></td>';
echo '<td width="25%" class="shadow">'.$row['wks']; 
echo '</td>';
echo '</tr>';
echo '</table>';             
echo '<br>';      
$ustärke = ($row['mhp']/10)+($row['mchakra']/10)+$row['mkr']+$row['mintl']+$row['mchrk']+$row['mtmp']+$row['mgnk']+$row['mwid'];
echo '<b class="shadowh" onMouseover="showtext(';
echo "'<b>Gesamtstärke</b><br>Deine Werte addiert, HP und Chakra werden durch 10 geteilt.'";
echo ')" onMouseout="hidetext()">Gesamtstärke: '.$ustärke.'</b>';
echo '<br>';                                                          
echo '<br>';
if($row['statspunkte'] != "0"){
echo '<p class="shadow">Du kannst noch <b>'.$row['statspunkte'].'</b> Statspunkte verteilen. Tu dies <a href="chara.php?page=stats">hier</a>.</p><br>';
}
}
$result->close();
$db->close();   
}
else{ 
$ustats = getwert(session_id(),"charaktere","statspunkte","session");        
echo '<p class="shadow">Du hast insgesamt <b id="zahl2">'.$ustats.'</b> Punkte.<br> Du kannst noch <b id="zahl">'.$ustats.'</b> Punkte verteilen.<br></p>';
echo '<div class="relativ statswahl">';              
echo '<form method="post" action="chara.php?aktion=stats">';
echo '<div class="werte" style="left:100px; top:0px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext('; 
$mhp = getwert(session_id(),"charaktere","mhp","session");   
echo "'<b>HP</b><br>HP ist ein Wert, der angibt, wieviel du aushalten kannst.'";
echo ')" onMouseout="hidetext()">HP:<br>('.$mhp.')</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="hp" name="hp" value="0" size="2" maxlength="3" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';
echo '<div class="werte" style="left:360px; top:0px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Chakra</b><br>Chakra beschreibt deine mentale Energie, die du für Jutsus benötigt.'";    
$mchakra = getwert(session_id(),"charaktere","mchakra","session");   
echo ')" onMouseout="hidetext()">Chakra:<br>('.$mchakra.')</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="chakra" name="chakra" value="0" size="2" maxlength="3" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';
echo '<div class="werte" style="left:100px; top:40px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext('; 
$mkr = getwert(session_id(),"charaktere","mkr","session");   
echo "'<b>Kraft</b><br>Kraft beschreibt die Stärke der Taijutsus.'";
echo ')" onMouseout="hidetext()">Kraft:<br>('.$mkr.')</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="kraft" name="kraft" value="0" size="2" maxlength="3" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';
echo '<div class="werte" style="left:360px; top:40px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Widerstand</b><br>Widerstand beschreibt die mentale sowie die körperliche Stärke und gibt an, wie viel ich körperlich bzw mental aushalte.'";    
$mwid = getwert(session_id(),"charaktere","mwid","session");   
echo ')" onMouseout="hidetext()">Widerstand:<br>('.$mwid.')</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="wid" name="wid" value="0" size="2" maxlength="3" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>'; 
echo '<div class="werte" style="left:100px; top:80px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Intelligenz</b><br>Intelligenz beschreibt die Stärke der Genjutsus.'";
$mintl = getwert(session_id(),"charaktere","mintl","session");   
echo ')" onMouseout="hidetext()">Intelligenz:<br>('.$mintl.')</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="int" name="int" value="0" size="2" maxlength="3" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';  
echo '<div class="werte" style="left:360px; top:80px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Chakrakontrolle</b><br>Chakrakontrolle beschreibt die Stärke der Ninjutsus.'";
$mchrk = getwert(session_id(),"charaktere","mchrk","session");   
echo ')" onMouseout="hidetext()">Chakrakontrolle:<br>('.$mchrk.')</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="chrk" name="chrk" value="0" size="2" maxlength="3" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';  
echo '<div class="werte" style="left:100px; top:120px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Tempo</b><br>Tempo beschreibt deine Schnelligkeit. Umso mehr Tempo du hast , umso größer ist die Chance , dass der Angriff des Gegners nicht trifft.'";  
$mtmp = getwert(session_id(),"charaktere","mtmp","session");   
echo ')" onMouseout="hidetext()">Tempo:<br>('.$mtmp.')</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="tmp" name="tmp" value="0" size="2" maxlength="3" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';  
echo '<div class="werte" style="left:360px; top:120px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Genauigkeit</b><br>Genauigkeit beschreibt die Konzentration auf den Gegner und gibt an, wie genau man zielt.'";    
$mgnk = getwert(session_id(),"charaktere","mgnk","session");   
echo ')" onMouseout="hidetext()">Genauigkeit:<br>('.$mgnk.')</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="gnk" name="gnk" value="0" size="2" maxlength="3" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';  
echo '<div class="werte" style="left: 320px; top:170px;">
<input type="submit" value="weiter" id="login" name="login" class="button2"/>    
</form>';
echo '</div>';       
echo '<div class="werte" style="left:270px; top:7px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown2('."'incr','hp'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown2('."'decr','hp'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                               
echo '<div class="werte" style="left:530px; top:7px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown2('."'incr','chakra'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown2('."'decr','chakra'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                           
echo '<div class="werte" style="left:270px; top:47px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown2('."'incr','kraft'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown2('."'decr','kraft'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                               
echo '<div class="werte" style="left:530px; top:47px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown2('."'incr','wid'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown2('."'decr','wid'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                     
echo '<div class="werte" style="left:270px; top:87px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown2('."'incr','int'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown2('."'decr','int'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                          
echo '<div class="werte" style="left:530px; top:87px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown2('."'incr','chrk'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown2('."'decr','chrk'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                       
echo '<div class="werte" style="left:270px; top:127px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown2('."'incr','tmp'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown2('."'decr','tmp'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                          
echo '<div class="werte" style="left:530px; top:127px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown2('."'incr','gnk'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown2('."'decr','gnk'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>'; 
echo '</div></p>';
}
echo '<div id="textdiv" class="shadow"></div>';
if($page != ""){
echo '<a href="chara.php">Zurück</a>';
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