<?php
include 'inc/incoben.php';
if(logged_in()){
include 'inc/header.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                               
$event = checkevent();                          
$umissi = getwert(session_id(),"charaktere","mission","session");   
$uort = getwert(session_id(),"charaktere","ort","session");   
$emap = getwert($uort,"orte","map","id");    
if($emap == 0){   
$emap = getwert($event,"events","map","id"); 
if($emap != 0){
$event = 1;
}
else{
$emap = '';
}
}
else{
$event = 1;
}
$uwo = getwert(session_id(),"charaktere","mwo","session"); 
  ?>
<center>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NBG Top -->
<ins class="adsbygoogle"
     style="display:inline-block;width:963px;height:90px"
     data-ad-client="ca-pub-7145796878009968"
     data-ad-slot="6601247425"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
  </center>
<?php
if($_GET['map'] == ''){
echo '<center><div class="map"><div class="wege">';

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
wo
FROM
missions
WHERE id="'.$umissi.'" Limit 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$is = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$array = explode("@", trim($row['wo']));
$mort = explode("$", trim($array[$uwo]));  
}
$result->close();
$db->close();     
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
l,
t,
nuke,
was,
map
FROM
orte
WHERE
map=0';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}          
 $ort = getwert(session_id(),"charaktere","ort","session");
  $mapc = getwert(session_id(),"charaktere","mapc","session");  
  $rank = getwert(session_id(),"charaktere","rank","session");
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['was'] != "reise"){
if($rank == "nuke-nin"&&$row['nuke'] == 1||$row['nuke'] == 0||$rank == 'admin'){
echo '<div class="m'.$row['was'].'2" style="position:absolute; left:'.$row['l'].'px; top:'.$row['t'].'px; z-index:3;"><a href="reisen.php?ziel='.$row['id'].'" class="sinfo"><span class="spanmap">'.ucwords($row['name']).'</span></a></div>
<div class="m'.$row['was'].'" style="position:absolute; left:'.$row['l'].'px; top:'.$row['t'].'px; z-index:0;"></div>';   
}
}          
$count = 0;             
while($mort[$count] != ""){
if($mort[$count] == $row['id']){
echo '<div class="mamissi" style="position:absolute; left:'.$row['l'].'px; top:'.$row['t'].'px; z-index:1;"></div>';
}
$count++;
}
if($row['was'] == "reise"){
$array = explode(";", trim($row['name']));    
}
if($ort == $row['id']){
echo '<div class="mchar'.$mapc.'" style="position:absolute; left:'.$row['l'].'px; top:'.$row['t'].'px; z-index:2;"></div>';
}
}
$result->close(); $db->close();   
echo '</div></div>';
if($event != ''&&$emap != ''){
echo '<br/><a href="map.php?map=event">Zur Eventkarte</a><br>';
}
echo '<br/><a href="index.php">Zurück</a><br/></center>';
}
else{
echo '<center>';
if($_GET['map'] == 'event'&&$event != ''&&$emap != ''){      
echo '<div class="event'.$emap.'"><div class="event'.$emap.'w">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
wo
FROM
missions
WHERE id="'.$umissi.'" Limit 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$is = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$array = explode("@", trim($row['wo']));
$mort = explode("$", trim($array[$uwo]));  
}
$result->close();
$db->close();     
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
l,
t,
nuke,
was,
map
FROM
orte
WHERE
map='.$emap;
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}          
 $ort = getwert(session_id(),"charaktere","ort","session");
  $mapc = getwert(session_id(),"charaktere","mapc","session");  
  $rank = getwert(session_id(),"charaktere","rank","session");
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['was'] != "reise"){
if($rank == "nuke-nin"&&$row['nuke'] == 1||$row['nuke'] == 0||$rank == 'admin'){
echo '<div class="m'.$row['was'].'2" style="position:absolute; left:'.$row['l'].'px; top:'.$row['t'].'px; z-index:3;"><a href="reisen.php?ziel='.$row['id'].'" class="sinfo"><span class="spanmap">'.ucwords($row['name']).'</span></a></div>
<div class="m'.$row['was'].'" style="position:absolute; left:'.$row['l'].'px; top:'.$row['t'].'px; z-index:0;"></div>';   
}
}          
$count = 0;             
while($mort[$count] != ""){    
if($mort[$count] == $row['id']){
echo '<div class="mamissi" style="position:absolute; left:'.$row['l'].'px; top:'.$row['t'].'px; z-index:1;"></div>';
}
$count++;
}
if($row['was'] == "reise"){
$array = explode(";", trim($row['name']));    
}
if($ort == $row['id']){
echo '<div class="mchar'.$mapc.'" style="position:absolute; left:'.$row['l'].'px; top:'.$row['t'].'px; z-index:2;"></div>';
}
}
$result->close(); $db->close();   
echo '</div></div>';
}  
echo '<br/><a href="map.php">Zurück</a><br/></center>';
}
}
//nicht eingeloggt , zeige Loginfenster
else{                          
include 'inc/design3.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
include 'inc/mainindex.php';   
include 'inc/design2.php';
}?>