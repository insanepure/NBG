<?php    
include 'inc/incoben.php';                 
if(logged_in()){
$event = 0;
$umissi = getwert(session_id(),"charaktere","mission","session");
$ort = getwert(session_id(),"charaktere","ort","session");         
$dorf = getwert(session_id(),"charaktere","dorf","session");      
$reise = getwert(session_id(),"charaktere","reise","session");  
$uwo = getwert(session_id(),"charaktere","mwo","session");         
$ukid = getwert(session_id(),"charaktere","kampfid","session");   
$uaktion = getwert(session_id(),"charaktere","aktion","session");       
$event = checkevent();

$aktion = $_GET['aktion'];
if($aktion == "abgeben"){   
if($umissi != 0){    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));           
$mwo = getwert($umissi,"missions","punkte","id");   
if($mwo == $uwo){ 
$geht = 1;         
$uid = getwert(session_id(),"charaktere","id","session");   
$uryo = getwert(session_id(),"charaktere","ryo","session");      
$cstory = getwert(session_id(),"charaktere","cstory","session");   
$story = getwert(session_id(),"charaktere","story","session");      
$ulevel = getwert(session_id(),"charaktere","level","session");   
$izeit = getwert(session_id(),"charaktere","izeit","session");         
$mryo = getwert($umissi,"missions","ryo","id");      
$mstory = getwert($umissi,"missions","story","id");   
$mclan = getwert($umissi,"missions","clan","id");       
$mjutsu = getwert($umissi,"missions","jutsu","id");         
$mrank = getwert($umissi,"missions","rank","id");   
$msummon = getwert($umissi,"missions","summon","id");   
$mvertrag = getwert($umissi,"missions","vertrag","id");   
$melement = getwert($umissi,"missions","element","id");  
$mbluterbe = getwert($umissi,"missions","bluterbe","id"); 
$mgrank = getwert($umissi,"missions","grank","id");          
$mjutsue = getwert($umissi,"missions","jutsue","id");    
$mexp = getwert($umissi,"missions","exp","id");      
$mitem = getwert($umissi,"missions","item","id");   
$mitema = getwert($umissi,"missions","itemanzahl","id");    
$mwohin = getwert($umissi,"missions","wohin","id");       
if($mitem != 0&&$geht == 1){
$slots = checkslots($uid);   
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
shop,
preis,
beschreibung,
bild,
werte,
typ,
anlegbar
FROM
item
WHERE id = "'.$mitem.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$iname = $row['name'];
$iwerte = $row['werte'];
$ibild = $row['bild'];
$ityp = $row['typ'];
$ianlegbar = $row['anlegbar'];
}
$result->close();$db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
angelegt
FROM
items       
WHERE besitzer = "'.$uid.'" AND name = "'.$iname.'" AND anzahl != "99" AND angelegt = ""
ORDER BY
name,
besitzer
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
//BEISPIEL: 1 Item 99 , 1 Item 97 , 1 Item 20 = 81
$tint = 0;
$hat = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$tint = $tint+(99-$row['anzahl']);  
$hat = 1;
}
$result->close();$db->close(); 
if($hat == 0){
if($slots[1] != 0){
//Neues Item erstellen    
$sql="INSERT INTO items(
`name`,
bild,   
besitzer,
typ,
anlegbar,
anzahl)
VALUES
('$iname',
'$ibild',  
'$uid',
'$ityp',
'$ianlegbar',
'$mitema')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
}
else{
$geht = 0;
$error = 'Du hast nicht genügend Platz im Inventar.';
}
}
else{
//item 1 97 , item 2 98 , also 3 
if($tint < $mitema){  
if($slots[1] == 0){
$geht = 0;
}
}
if($geht == 1){
//Ersmal bei allen anderen items das addieren    
  
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
angelegt
FROM
items        
WHERE besitzer = "'.$uid.'" AND name = "'.$iname.'" AND anzahl != "99" AND angelegt = ""
ORDER BY
name,
besitzer
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$nanzahl = $row['anzahl']+$mitema; //bei 97+10 = 107
if($nanzahl > 99){
$mitema = $nanzahl-99; //nunoch 77
$nanzahl = 99;
}
else{
$mitema = 0;
}
$sql="UPDATE items SET anzahl ='$nanzahl' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close();$db->close();
if($mitema != 0){  
$sql="INSERT INTO items(
`name`,
bild,   
besitzer,
typ,
anlegbar,
anzahl)
VALUES
('$iname',
'$ibild',  
'$uid',
'$ityp',
'$ianlegbar',
'$mitema')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}    

}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}
}
}                          
if($mgrank != ""&&$geht == 1){
$geht2 = 1;
if($mgrank == "kage"){ 
$geht2 = 0;
$mkage = "";
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
rank,
dorf
FROM
charaktere
WHERE dorf = "'.$dorf.'" and rank = "kage" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$mkage = $row['id'];
}
$result->close();$db->close();
if($mkage == ""){
$geht2 = 1;
}  
}
if($geht2 == 1){
$sql="UPDATE charaktere SET rank ='$mgrank' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($melement != ""&&$geht == 1){     
$uelemente = getwert(session_id(),"charaktere","elemente","session"); 
$array = explode(";", trim($uelemente)); 
$count = 0;
$hatele = 0;   
while(isset($array[$count])){
if($array[$count] == $melement){
$hatele = 1;
}
$count++;
}     
if($hatele == 0){   
if($uelemente == ""){    
$nelemente = $melement;   
}
else{
$nelemente = $uelemente.';'.$melement;
}    
$sql="UPDATE charaktere SET elemente ='$nelemente' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}

}
if($mbluterbe != ""&&$geht == 1){
$sql="UPDATE charaktere SET clan ='$mbluterbe' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($msummon != 0&&$geht == 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
besitzer,
reihenfolge
FROM
summon
WHERE besitzer = "'.$uid.'"
ORDER BY
reihenfolge
LIMIT 10';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$sanzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
$sanzahl++;
}
$result->close();$db->close();
if($sanzahl < 10){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
besitzer,
reihenfolge
FROM
summon    
WHERE besitzer = "'.$uid.'"
ORDER BY
reihenfolge
LIMIT 10';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$reihenfolge = 1;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
if($row['reihenfolge'] == 1&&$reihenfolge == 1){
$reihenfolge = 2;
}  
if($row['reihenfolge'] == 2&&$reihenfolge == 2){
$reihenfolge = 3;
}
if($row['reihenfolge'] == 3&&$reihenfolge == 3){
$reihenfolge = 4;
}
}
$result->close();$db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
mhp,
mchakra,
mkr,
mintl,
mtmp,
mgnk,
mchrk,
mwid,
statspunkte
FROM
charaktere   
WHERE id = "'.$uid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
$ustats = ($row['mhp']/10)+($row['mchakra']/10)+$row['mkr']+$row['mintl']+$row['mgnk']+$row['mchrk']+$row['mtmp']+$row['mwid']+$row['statspunkte'];  
}
$result->close();$db->close();
$ustats = $ustats-80;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
hp,
chakra,
kr,
wid,
tmp,
gnk,
intl,
chrk,
jutsus,
kbild,
bild,
geschlecht,
kaufstats
FROM
npc
WHERE id = "'.$msummon.'" Limit 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
$sql="INSERT INTO summon(
name,
hp,     
mhp,   
chakra, 
mchakra,
kr,      
tmp,
gnk,
intl,
chrk,
wid,
jutsus,
kbild,
bild,  
reihenfolge,
statspunkte, 
besitzer,
geschlecht)
VALUES
('".$row['name']."',
'100',    
'100',  
'100',    
'100',  
'10', 
'10',   
'10', 
'10', 
'10',  
'10', 
'".$row['jutsus']."',  
'".$row['kbild']."', 
'".$row['bild']."', 
'$reihenfolge',   
'$ustats',     
'$uid',
'".$row['geschlecht']."')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
$result->close();$db->close();

}
else{
$geht = 0;
$error = 'Du kannst nicht mehr als 10 Puppen haben. Entferne eine, um die Mission zu beenden.';
}

}
if($mexp != 0&&$geht == 1){
if($ulevel == 70){
$istats = floor($izeit/60);
$izeit = $izeit-($istats*60);    
$statspunkte = getwert(session_id(),"charaktere",'statspunkte',"session"); 
$statspunkte = $istats+$statspunkte;
$sql="UPDATE charaktere SET izeit ='$izeit',statspunkte='$statspunkte' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
mysqli_close($con);
levelup($uid,$mexp);   
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
}     
}  
if($mrank == "d"||$mrank == "c"||$mrank == "b"||$mrank == "a"||$mrank == "s"||$mrank == "m"){
$mrankm = $mrank.'missi';
$ump = getwert(session_id(),"charaktere",$mrankm,"session");  
$ump = $ump+1;   
$sql="UPDATE charaktere SET $mrankm ='$ump' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($mvertrag != ""&&$geht == 1){ 
$sql="UPDATE charaktere SET vertrag ='$mvertrag' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
}
if($mwohin != 0&&$geht == 1){ 
$sql="UPDATE charaktere SET ort ='$mwohin',reise ='',rwo ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
}
if($mjutsu != 0&&$geht == 1){      
$ujutsus = getwert(session_id(),"charaktere","jutsus","session"); 
$ukbutton = getwert(session_id(),"charaktere","kbutton","session");  
if($mjutsue == "0"){
$array = explode(";", trim($ujutsus)); 
$count = 0;
$hatschon = 0;
while(isset($array[$count])){
if($array[$count] == $mjutsu){
$hatschon = 1;
}
$count++;
}
if($hatschon == 0){
$array = explode(";", trim($ukbutton)); 
$count = 0;
while(isset($array[$count])){
$count++;
}
if($count < 10){
$ukbutton = $ukbutton.';'.$mjutsu;
}
$ujutsus = $ujutsus.';'.$mjutsu;  
}
}
else{
$array = explode(";", trim($ujutsus)); 
$count = 0;
$ujutsus = "";
while(isset($array[$count])){
if($array[$count] == $mjutsue){
$array[$count] = $mjutsu;
}
if($ujutsus == ""){
$ujutsus = $array[$count];
}
else{
$ujutsus = $ujutsus.';'.$array[$count];
}
$count++;
}
$array = explode(";", trim($ukbutton)); 
$count = 0;
$ukbutton = "";
while(isset($array[$count])){
if($array[$count] == $mjutsue){
$array[$count] = $mjutsu;
}
if($ukbutton == ""){
$ukbutton = $array[$count];
}
else{
$ukbutton = $ukbutton.';'.$array[$count];
}
$count++;
}
}
$sql="UPDATE charaktere SET jutsus ='$ujutsus',kbutton ='$ukbutton' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
if($mclan != ""&&$mstory != 0&&$geht == 1){
$cstory = $cstory+1;
$sql="UPDATE charaktere SET cstory ='$cstory' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
} 
if($mclan == ""&&$mstory != 0&&$geht == 1){
$story = $story+1;
$sql="UPDATE charaktere SET story ='$story' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
} 
if($mryo != 0&&$geht == 1){        
$uryo = $mryo+$uryo;  
$sql="UPDATE charaktere SET ryo ='$uryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
if($geht == 1){
$sql="UPDATE charaktere SET mission ='0',mwo='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
$umissi = 0;
$error = "Mission abgegeben.<br>"; 
}   
mysqli_close($con); 
}
else{
$error = "Du hast die Mission noch nicht fertig.";
}
}
else{ 
$error = "Du bist in keiner Mission.";

}

}
if($aktion == "end"){   
if($umissi != 0){   
if($ukid == "0"){
if($uaktion == ""){
$check = $_POST['check'];
if($check == "check"){ 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));      
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET mission ='0',mwo='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con); 
$umissi = 0;
$error = "Mission abgebrochen.<br>"; 
}
}
else{
$error = 'Du kannst die Mission nicht abbrechen, während du eine Aktion tätigst.';
}
}
else{
$error = 'Du kannst im Kampf die Mission nicht abbrechen.<br>';
}
}
else{ 
$error = "Du bist auf keiner Mission.";

}    

}
if($aktion == "start"){
if($umissi == 0){       
$mid = real_escape_string($_GET['id']);    
$mexist = getwert($mid,"missions","name","id");
if($mexist != ""){    
$mwo = getwert($mid,"missions","wo","id");         
$array = explode("@", trim($mwo));
$count = 0;
$istda = 0;
$array2 = explode("$", trim($array[0]));  
while(isset($array2[$count])){
if($array2[$count] == $ort){
$istda = 1;
}
$count++;
}
if($istda == 1){                
$mitemb = getwert($mid,"missions","itemb","id");
$hatitem = checkhatitem($mitemb);
if($hatitem == 1){             
$mstory = getwert($mid,"missions","story","id");
$mclan = getwert($mid,"missions","clan","id");  
$mlevel = getwert($mid,"missions","level","id"); 
$mrank = getwert($mid,"missions","mrank","id"); 
$melement = getwert($mid,"missions","element","id");    
$urank = getwert(session_id(),"charaktere","rank","session");  
$cstory = getwert(session_id(),"charaktere","cstory","session");   
$story = getwert(session_id(),"charaktere","story","session");    
$level = getwert(session_id(),"charaktere","level","session");   
$clan = getwert(session_id(),"charaktere","clan","session");      
$eles = getwert(session_id(),"charaktere","elemente","session"); 
$eles = explode(";", trim($eles));   
$count2 = 0;
$elea = 0;
while(isset($eles[$count2]))
{
  if($melement != $eles[$count2]){     
    $elea++;
  }
  $count2++;
}              
if($elea != 2&&$melement != ''||$clan == 'jiongu'||$clan == 'ishoku sharingan'||$melement == ''||$clan == 'jinton'){
if($mstory == 0||$mstory == $story&&$mclan == ""||$mstory == $cstory&&$mclan == $clan){
if($level >= $mlevel){                
$missi = $_GET['missi'];
if($missi == "d"||$missi == "c"||$missi == "b"||$missi == "a"||$missi == "s"||$missi == "story"||$missi == "clan"||$missi == 'event'&&$event != ''){    
$ulevel = getwert(session_id(),"charaktere","level","session");   
$rank = getwert(session_id(),"charaktere","rank","session");      
$missi2 = getwert($mid,"missions","rank","id");                   
$eventid = getwert($mid,"missions","event","id"); 
  
if($missi2 == 'event'&&$event == $eventid||$missi2 == "clan"||$missi2 == "story"||$rank == "admin"||$missi2 == "d"||
   $rank == "genin"&&$missi2 == "c"||$rank == "genin"&&$missi2 == "c"||
   $rank == "chuunin"&&$missi2 == "c"||$rank == "chuunin"&&$missi2 == "b"||
   $rank == "jounin"&&$missi2 == "c"||$rank == "jounin"&&$missi2 == "b"||$rank == "jounin"&&$missi2 == "a"||
   $rank == "kage"&&$missi2 != 'm'&&$missi2 != 'event'&&$missi2 != 'story'&&$missi2 != 'clan'||
   $rank == "anbu"&&$missi2 != 'm'&&$missi2 != 'event'&&$missi2 != 'story'&&$missi2 != 'clan'||
   $rank == "nuke-nin"&&$missi == "d"&&$mrank == 'd'||
   $rank == "nuke-nin"&&$missi == "c"&&$ulevel >= 10&&$missi2 == 'm'&&$mrank == 'c'||
   $rank == "nuke-nin"&&$missi == "b"&&$ulevel >= 30&&$missi2 == 'm'&&$mrank == 'b'||
   $rank == "nuke-nin"&&$missi == "a"&&$ulevel >= 50&&$missi2 == 'm'&&$mrank == 'a'||
   $rank == "nuke-nin"&&$missi == "s"&&$ulevel >= 60&&$missi2 == 'm'&&$mrank == 's')
{ 
if($rank == 'admin'||$ort==$dorf||$missi == "d"||$missi == "story"||$missi == "clan"||$ort == '13'||$missi == 'event'&&$event == $eventid){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));      
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET mission ='$mid',mwo='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}      
$umissi = $mid;
mysqli_close($con); 
$error = "Mission gestartet.<br>"; 
}
else{
$error = 'Diese Mission ist von dir nicht ausführbar.';
}
}
else{
$error = 'Diese Mission ist ungültig.';
}
}
else{
$error = 'Diese Missionsart gibt es nicht.';
}
}
else{
$error ="Dein Level ist zu niedrig.";
}
}
else{
$error = "Du kannst diese Mission nicht machen.";
}
}
else{
$error = 'Du kannst nicht mehr als zwei Elemente lernen.';
}
}
}
else{
$error = "Du befindest dich nicht an den richtigen Ort.";
}
}
else{
$error = "Diese Mission existiert nicht.";
}
}
else{
$error = "Du bist bereits auf einer Mission.";
}

}
}  
if(logged_in()){          
include 'inc/design1.php';  
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                  
include 'inc/bbcode.php';
?>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LdMP7kUAAAAABZPx7qz5I5snHzWntPFMT__E-lu', {action: 'mission'});
});
</script>
<?php
if($umissi == 0){
$rank = getwert(session_id(),"charaktere","rank","session");    
$missi = $_GET['missi']; 
if($missi == ""){
echo '<table width="100%"><tr height="150px"><td colspan="2"><table width="100%"><tr>';     
if($rank == "student"){   
echo '<td align="center"><div class="dmissi"><a href="missions.php?missi=d"></a></div></td>';
}
if($rank == "genin"){        
echo '<td align="center"><div class="dmissi"><a href="missions.php?missi=d"></a></div></td>'; 
if($ort == $dorf){
echo '<td align="center"><div class="cmissi"><a href="missions.php?missi=c"></a></div></td>'; 
} 
}
if($rank == "chuunin"){        
echo '<td align="center"><div class="dmissi"><a href="missions.php?missi=d"></a></div></td>';    
if($ort == $dorf){
echo '<td align="center"><div class="cmissi"><a href="missions.php?missi=c"></a></div></td>';    
echo '<td align="center"><div class="bmissi"><a href="missions.php?missi=b"></a></div></td>'; 
}  
}
if($rank == "jounin"){        
echo '<td align="center"><div class="dmissi"><a href="missions.php?missi=d"></a></div></td>';  
if($ort == $dorf){
echo '<td align="center"><div class="cmissi"><a href="missions.php?missi=c"></a></div></td>';     
echo '<td align="center"><div class="bmissi"><a href="missions.php?missi=b"></a></div></td>'; 
echo '<td align="center"><div class="amissi"><a href="missions.php?missi=a"></a></div></td>'; 
}
}
if($rank == "anbu"){        
echo '<td align="center"><div class="dmissi"><a href="missions.php?missi=d"></a></div></td>'; 
if($ort == $dorf){
echo '<td align="center"><div class="cmissi"><a href="missions.php?missi=c"></a></div></td>';     
echo '<td align="center"><div class="bmissi"><a href="missions.php?missi=b"></a></div></td>'; 
echo '<td align="center"><div class="amissi"><a href="missions.php?missi=a"></a></div></td>';    
echo '<td align="center"><div class="smissi"><a href="missions.php?missi=s"></a></div></td>';    
}
}
if($rank == "kage"){        
echo '<td align="center"><div class="dmissi"><a href="missions.php?missi=d"></a></div></td>';    
if($ort == $dorf){
echo '<td align="center"><div class="cmissi"><a href="missions.php?missi=c"></a></div></td>';     
echo '<td align="center"><div class="bmissi"><a href="missions.php?missi=b"></a></div></td>'; 
echo '<td align="center"><div class="amissi"><a href="missions.php?missi=a"></a></div></td>';    
echo '<td align="center"><div class="smissi"><a href="missions.php?missi=s"></a></div></td>';
}
}   
if($rank == "admin"){        
echo '<td align="center"><div class="dmissi"><a href="missions.php?missi=d"></a></div></td>';    
echo '<td align="center"><div class="cmissi"><a href="missions.php?missi=c"></a></div></td>';     
echo '<td align="center"><div class="bmissi"><a href="missions.php?missi=b"></a></div></td>'; 
echo '<td align="center"><div class="amissi"><a href="missions.php?missi=a"></a></div></td>';    
echo '<td align="center"><div class="smissi"><a href="missions.php?missi=s"></a></div></td>';
}
if($rank == "nuke-nin"){    
$ulevel = getwert(session_id(),"charaktere","level","session");           
echo '<td align="center"<div class="dmissi"><a href="missions.php?missi=d"></a></div></td>';  
if($ort == '13'){
if($ulevel >= 10){
echo '<td align="center"<div class="cmissi"><a href="missions.php?missi=c"></a></div></td>';
}
if($ulevel >= 30){
echo '<td align="center"<div class="bmissi"><a href="missions.php?missi=b"></a></div></td>';
}
if($ulevel >= 50){
echo '<td align="center"<div class="amissi"><a href="missions.php?missi=a"></a></div></td>';
}
if($ulevel >= 60){
echo '<td align="center"<div class="smissi"><a href="missions.php?missi=s"></a></div></td>';
}
}


}         
echo '</tr></table>';
echo '</td></tr><tr height="150px">';
echo '<td align="center"><div class="storym"><a href="missions.php?missi=story"></a></div></td>'; 
echo '<td align="center"><div class="clanm"><a href="missions.php?missi=clan"></a></div></td>';   
if($event != 0){
echo '</tr><tr height="150px">';
echo '<td align="center" colspan="2"><div class="eventm"><a href="missions.php?missi=event"></a></div></td>'; 
}
echo '</tr></table><br>'; 
}
elseif($missi == "d"||$missi == "c"||$missi == "b"||$missi == "a"||$missi == "s"||$missi == "story"||$missi == "clan"||$missi == 'event'&&$event != 0){  
$ulevel = getwert(session_id(),"charaktere","level","session");   
if($missi == 'event'&&$event != 0||$missi == "clan"||$missi == "story"||$rank == "admin"||
   $rank == "student"&&$missi == "d"||
   $rank == "genin"&&$missi == "d"||$rank == "genin"&&$missi == "c"||
   $rank == "chuunin"&&$missi == "d"||$rank == "chuunin"&&$missi == "c"||$rank == "chuunin"&&$missi == "b"||
   $rank == "jounin"&&$missi == "d"||$rank == "jounin"&&$missi == "c"||$rank == "jounin"&&$missi == "b"||$rank == "jounin"&&$missi == "a"||
   $rank == "kage"||
   $rank == "anbu"||
   $rank == "nuke-nin"&&$missi == "d"||
   $rank == "nuke-nin"&&$missi == "c"&&$ulevel >= 10||
   $rank == "nuke-nin"&&$missi == "b"&&$ulevel >= 30||
   $rank == "nuke-nin"&&$missi == "a"&&$ulevel >= 50||
   $rank == "nuke-nin"&&$missi == "s"&&$ulevel >= 60){ 
if($rank == "admin"||$ort==$dorf||$missi == "d"||$missi == "story"||$missi == "clan"||$ort == '13'||$missi == 'event'&&$event != ''){
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">';
echo 'Name';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Beschreibung';     
echo '</td>';       
echo '<td width="90px" class="tdbg tdborder">';
echo 'Dauer';     
echo '</td>';    
echo '<td width="120px" class="tdbg tdborder">';
echo 'Belohnung';     
echo '</td>';      
echo '<td class="tdbg tdborder">';
echo '';
echo '</td>';
echo '</tr>';    
$story = getwert(session_id(),"charaktere","story","session"); 
$cstory = getwert(session_id(),"charaktere","cstory","session");  
$clan = getwert(session_id(),"charaktere","clan","session");    
$level = getwert(session_id(),"charaktere","level","session");          
$urank = getwert(session_id(),"charaktere","rank","session");      
$uelemente = getwert(session_id(),"charaktere","elemente","session"); 
$eles = explode(";", trim($uelemente));   
$db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      name,
      aufgabe,
      art,
      was,
      wo,
      ryo,
      rank,
      beschreibung,
      punkte,
      exp,
      item,
      jutsu,
      itemanzahl,
      clan,
      story,
      level,
      wohin,
      summon,
      bluterbe,
      mrank,
      grank,
      element,
      itemb,
      event
FROM
    missions
    ORDER by
    name';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }           
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false       
      $hatitem = checkhatitem($row['itemb']);
      if($hatitem == 1){        
      if($row['rank'] == $missi||
         $rank == 'nuke-nin'&&$row['rank'] == 'm'&&$missi == 'd'&&$row['mrank'] == 'd'||
         $rank == 'nuke-nin'&&$row['rank'] == 'm'&&$missi == 'c'&&$row['mrank'] == 'c'&&$level >= 10||
         $rank == 'nuke-nin'&&$row['rank'] == 'm'&&$missi == 'b'&&$row['mrank'] == 'b'&&$level >= 30||
         $rank == 'nuke-nin'&&$row['rank'] == 'm'&&$missi == 'a'&&$row['mrank'] == 'a'&&$level >= 50||
         $rank == 'nuke-nin'&&$row['rank'] == 'm'&&$missi == 's'&&$row['mrank'] == 's'&&$level >= 60){   
      $array = explode("@", trim($row['wo']));  
      $count = 0; 
      $istda = 0;
      $array2 = explode("$", trim($array[0]));
      while(isset($array2[$count])){
      if($array2[$count] == $ort){
      $istda = 1;
      }
      $count++;
      }          
      $count2 = 0;
      $elea = 0;
      while(isset($eles[$count2])){
      if($row['element'] != $eles[$count2]){     
      $elea++;
      }
      $count2++;
      }            
      if($elea != 2&&$row['element'] != ''||$clan == 'jiongu'||$row['element'] == ''||$clan == 'ishoku sharingan'||$clan == 'jinton'){ 
      if($istda == 1&&$row['event'] == $event&&$level >= $row['level']||$istda == 1&&$row['story'] == 0&&$level >= $row['level']&&$missi != 'event'||$istda == 1&&$row['story'] == $story&&$row['clan'] == ""&&$level >= $row['level']||$istda == 1&&$row['story'] == $cstory&&$row['clan'] == $clan&&$level >= $row['level']){
      echo '<tr>';
      echo '<td height="30px"><b>'.$row['name'].'</b></td>'; 
      echo '<td>';             
      echo $bbcode->parse ($row['beschreibung']);     
      echo '</td>';    
      echo '<td>';             
      $art = explode("@", trim($row['art']));     
      $wo = explode("@", trim($row['wo']));   
      $was = explode("@", trim($row['was']));
      $count = 0;
      $ndauer = 0;
      while(isset($art[$count])){   
      if($art[$count] == 3||$art[$count] == 4){    
      $dauer = 0;    
      $rdauer = 0;   
      $do = 0;
      if($art[$count] == 4){   
      $dauer = explode(";", trim($was[$count]));
      $dauer = $dauer[1];                       
      }
      if($art[$count] == 3){
      $count2 = $count-1;   
      $ort3 = $wo[$count2];
      $ort2 = $was[$count];
      $sort = "$ort3;$ort2";  
      $rdauer = getwert($sort,"orte","rdauer","name");
      if($rdauer == 0){   
      $sort = "$ort2;$ort3";     
      $rdauer = getwert($sort,"orte","rdauer","name");
      }
      if($rdauer != ""){
      $rdauer = $rdauer*15*2;
      }  
      }    
      $ndauer = $ndauer+$dauer+$rdauer;
      }
      $count++;
      }   
        
      echo '<font color=red>';
        
      $hours = floor($ndauer/60);  
      $minutes = $ndauer-($hours*60);
      if($hours != 0)
      {
        echo $hours;
        if($hours == 1)
          echo ' Stunde';
        else
          echo ' Stunden';
      }
        echo ' ';
      if($minutes != 0)
      {
        echo $minutes;
        if($minutes == 1)
          echo ' Minute';
        else
          echo ' Minuten';
      }
       
      echo '</font><br>';
      echo '</td>';  
      echo '<td><b>';
      if($row['ryo'] != 0){
      echo $row['ryo'].' Ryo'; 
      echo '<br>';   
      }             
      if($row['exp'] != 0){
      echo $row['exp'].' Exp'; 
      echo '<br>'; 
      }          
      if($row['item'] != 0){    
      $iname = getwert($row['item'],"item","name","id");  
      echo $row['itemanzahl'].'x '.$iname; 
      echo '<br>';  
      }
      if($row['jutsu'] != 0){          
      $jname = getwert($row['jutsu'],"jutsus","name","id");  
      echo $jname;    
      echo '<br>';  
      }  
      if($row['summon'] != 0){          
      $sname = getwert($row['summon'],"npc","name","id");  
      echo $sname;    
      echo '<br>';  
      }     
      if($row['element'] != ""){          
      echo $row['element'];    
      echo '<br>';  
      }    
      if($row['bluterbe'] != ""){          
      echo ucwords($row['bluterbe']);    
      echo '<br>';  
      }            
      if($row['grank'] != ""){    
      echo ucwords($row['grank']); 
      echo '<br>'; 
      }   
      echo '</b></td>';
      echo '<td>';
      echo '<form method="post" action="missions.php?missi='.$missi.'&aktion=start&id='.$row['id'].'"><input class="button2" name="login" id="login" value="starten" type="submit"></form>';
      echo '</td>';
      echo '</tr>';
      }
      elseif($missi == 'clan'||$missi == 'story'){ 
      if($row['story'] == 0||$row['story'] == $story&&$row['clan'] == ""||$row['story'] == $cstory&&$row['clan'] == $clan){    
      if(is_numeric($row['brank'])&&$urank2 >= $row['brank']||$urank == $row['brank']||$row['brank'] == ""){  
       echo '<tr>';
      echo '<td height="30px"><b>'.$row['name'].'</b></td>'; 
      echo '<td>';             
      echo $bbcode->parse ($row['beschreibung']); 
      echo '</td>';  
      echo '<td>';             
      $art = explode("@", trim($row['art']));     
      $wo = explode("@", trim($row['wo']));   
      $was = explode("@", trim($row['was']));
      $count = 0;
      $ndauer = 0;
      while(isset($art[$count])){   
      if($art[$count] == 3||$art[$count] == 4){    
      $dauer = 0;    
      $rdauer = 0;   
      $do = 0;
      if($art[$count] == 4){   
      $dauer = explode(";", trim($was[$count]));
      $dauer = $dauer[1];                       
      }
      if($art[$count] == 3){
      $count2 = $count-1;   
      $ort3 = $wo[$count2];
      $ort2 = $was[$count];
      $sort = "$ort3;$ort2";  
      $rdauer = getwert($sort,"orte","rdauer","name");
      if($rdauer == 0){   
      $sort = "$ort2;$ort3";     
      $rdauer = getwert($sort,"orte","rdauer","name");
      }
      if($rdauer != ""){
      $rdauer = $rdauer*15;
      }  
      }    
      $ndauer = $ndauer+$dauer+$rdauer;
      }
      $count++;
      }   
        
      echo '<font color=red>';
      $hours = floor($ndauer/60);  
      $minutes = $ndauer-($hours*60);
      if($hours != 0)
      {
        echo $hours;
        if($hours == 1)
          echo ' Stunde';
        else
          echo ' Stunden';
      }
        echo ' ';
      if($minutes != 0)
      {
        echo $minutes;
        if($minutes == 1)
          echo ' Minute';
        else
          echo ' Minuten';
      }
      echo '</font><br>';
      echo '</td>';  
      echo '<td><b>';
      if($row['ryo'] != 0){
      echo $row['ryo'].' Ryo'; 
      echo '<br>';   
      }             
      if($row['exp'] != 0){
      echo $row['exp'].' Exp'; 
      echo '<br>'; 
      }          
      if($row['item'] != 0){    
      $iname = getwert($row['item'],"item","name","id");  
      echo $row['itemanzahl'].'x '.$iname; 
      echo '<br>';  
      }
      if($row['jutsu'] != 0){          
      $jname = getwert($row['jutsu'],"jutsus","name","id");  
      echo $jname;    
      echo '<br>';  
      }  
      if($row['summon'] != 0){          
      $sname = getwert($row['summon'],"npc","name","id");  
      echo $sname;    
      echo '<br>';  
      }     
      if($row['element'] != ""){          
      echo $row['element'];    
      echo '<br>';  
      }    
      if($row['bluterbe'] != ""){          
      echo ucwords($row['bluterbe']);    
      echo '<br>';  
      }            
      if($row['grank'] != ""){    
      echo ucwords($row['grank']); 
      echo '<br>'; 
      }   
      echo '</b></td>';  
      echo '<td>';    
      $count = 0;
      $istda = 0;
      $edorf = 0;                 
      $array = explode("@", trim($row['wo']));  
      $array2 = explode("$", trim($array[0]));
      $tort = "";
      $tort2 = ""; 
      while(isset($array2[$count])){
      if($array2[$count] == $ort){
      $istda = 1;
      }
      if($array2[$count] == $dorf){
      $edorf = 1;
      }  
      $tort2 = getwert($array2[$count],"orte","name","id");  
      $tort2 = ucwords($tort2); 
      if($tort == ""){
      $tort = $tort2;
      }
      else{ 
      $count2 = $count+1;
      if($array2[$count2] == ""){
      $tort = $tort.' oder '.$tort2;
      }
      else{
      $tort = $tort.','.$tort2;
      }
      }
      $count++;
      }
      if($edorf == 0){
      if($tort == "Suna,Kiri,Kumo,Oto,Ame,Kusa,Taki,Iwa oder Konoha"){
      echo 'Ort: Jedes Dorf';  
      }
      else{       
      echo 'Ort: '.$tort; 
      }  
      }
      else{         
      $tort = getwert($dorf,"orte","name","id");   
      $tort = ucwords($tort);  
      echo 'Ort: '.$tort;
      }
      if($row['level'] != ""){
      echo '<br>Level: '.$row['level']; 
      }     
      echo '</td>'; 
      }
      }
      }
      echo '</tr>'; 
      }
      
      }
      }
      }
    
      $result->close();   
$db->close();     
      echo '</table>';
      }
      }
      echo '<br><a href="missions.php">Zurück</a>';
      }
  }
  else{    
$izeit = getwert(session_id(),"charaktere","izeit","session");   
$ulevel = getwert(session_id(),"charaktere","level","session");  
$izeit = $izeit/60; 
echo '<h2 class="shadow">Aktive Mission</h2><br>';
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">';
echo 'Name';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Aufgabe';     
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Belohnung';     
echo '</td>';   
echo '<td class="tdbg tdborder">';
echo '';
echo '</td>';
echo '</tr>';
$db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      name,
      abeschr,
      art,
      was,
      wo,
      ryo,
      rank,
      punkte,
      exp,
      item,
      itemanzahl,
      jutsu,
      summon,
      bluterbe,
      grank,
      element
      
FROM
    missions
    WHERE id = "'.$umissi.'" Limit 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }               
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
      echo '<tr>';
      echo '<td height="30px"><b>'.$row['name'].'</b></td>'; 
      echo '<td>';  
      $array = explode("@", trim($row['abeschr']));
      $aufgabe = $array[$uwo];                        
      $array = explode("@", trim($row['wo']));    
      $wo = $array[0];   
      if($aufgabe != ""){
      echo $bbcode->parse ($aufgabe); 
      }
      else{          
      $count = 0;
      $istda = 0;
      $edorf = 0;
      $array2 = explode("$", trim($wo)); 
      $tort = ""; 
      while(isset($array2[$count])){
      if($array2[$count] == $ort){
      $istda = 1;
      }
      if($array2[$count] == $dorf){
      $edorf = 1;
      }
      if($reise == ""){   
      $tort2 = getwert($array2[$count],"orte","name","id");  
      $tort2 = ucwords($tort2); 
      }
      else{              
      $array = explode(";", trim($reise));         
      $tort2 = getwert($array[1],"orte","name","id");   
      $tort2 = ucwords($tort2);  
      }  
      if($tort == ""){
      $tort = $tort2;
      }
      else{ 
      $count2 = $count+1;
      if($array2[$count2] == ""){
      $tort = $tort.' oder '.$tort2;
      }
      else{
      $tort = $tort.','.$tort2;
      }
      }
      $count++;
      }
      if($edorf == 0){
      if($tort == "Suna,Kiri,Kumo,Oto,Ame,Kusa,Taki,Iwa oder Konoha"){
      $tort = 'jedes Dorf';
      } 
      }
      else{
      $tort = getwert($dorf,"orte","name","id");   
      $tort = ucwords($tort);   
      }
      echo $bbcode->parse ("Der Abgabeort für die Mission ist [color=red]".$tort."[/color]."); 
      }
      echo '</td>';  
      echo '<td><b>';
      if($row['ryo'] != 0){
      echo $row['ryo'].' Ryo'; 
      echo '<br>';   
      }             
      if($row['exp'] != 0&&$ulevel != 70){
      echo $row['exp'].' Exp'; 
      echo '<br>'; 
      }          
      elseif($ulevel == 70){
      if($izeit == 1)
      {
      echo $izeit.' Statspunkt<br>';
      }
      else{
      echo $izeit.' Statspunkte<br>';
      }
      }
      if($row['item'] != 0){    
      $iname = getwert($row['item'],"item","name","id");  
      echo $row['itemanzahl'].'x '.$iname; 
      echo '<br>';  
      }
      if($row['jutsu'] != 0){          
      $jname = getwert($row['jutsu'],"jutsus","name","id");  
      echo $jname; 
      echo '<br>';  
      }  
      if($row['summon'] != 0){          
      $sname = getwert($row['summon'],"npc","name","id");  
      echo $sname;    
      echo '<br>';  
      }   
      if($row['element'] != ""){          
      echo $row['element'];    
      echo '<br>';  
      }    
      if($row['bluterbe'] != ""){          
      echo ucwords($row['bluterbe']);    
      echo '<br>';  
      }               
      if($row['grank'] != ""){    
      echo ucwords($row['grank']); 
      echo '<br>'; 
      }   
      echo '</b></td>';
      echo '<td>';
      if($aufgabe != ""){
      echo '<form method="post" action="missions.php?missi='.$missi.'&aktion=end"><input class="cursor" type="checkbox" name="check" value="check"> <input class="button" name="login" id="login" value="Mission abbrechen" type="submit"></form>';
      }
      else{  
      if($istda == 1){    
      echo '<form method="post" action="missions.php?missi='.$missi.'&aktion=abgeben"><input class="button" name="login" id="login" value="abgeben" type="submit"></form>';
      }
      }
      echo '</td>';
      echo '</tr>'; 
      }
      $result->close();   
$db->close();     
      echo '</table>';
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