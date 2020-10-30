<?php
include 'inc/incoben.php';
if(logged_in()){                                         
$uid = getwert(session_id(),"charaktere","id","session");      
$uort = getwert(session_id(),"charaktere","ort","session");    
$turnier = getwert(session_id(),"charaktere","turnier","session");    
$aktion = $_GET['aktion'];
if($turnier != 0){    
$tzeit = getwert($turnier,"turnier","start","id");                    
$teilnehmer = getwert($turnier,"turnier","teilnehmer","id");         
$finale = getwert($turnier,"turnier","finale","id");      
$tzeit = strtotime($tzeit);         
if($tzeit < time()){   
$trunde = getwert(session_id(),"charaktere","trunde","session");   
$uwo = getwert(session_id(),"charaktere","two","session");      
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
turnier,
two,
bild,
kbild,
trunde
FROM
charaktere
WHERE turnier = "'.$turnier.'"
ORDER BY
two ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$gspieler = 0;
$gunter = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gspieler++;         
if($trunde == $row['trunde']){ 
if($row['two'] == $uwo&&$uid != $row['id']){
$gegner = $row['id'];
$gname = $row['name'];  
$kbild = $row['kbild'];
}       
}
elseif($trunde > $row['trunde']){
$gwas = getwert($row['id']."' AND turnier='".$row['turnier']."' AND runde='".$row['trunde'],"turnierstats","was","spieler");  
if($gwas == 0)
  $gunter = 1;
}
if($finale != 0&&$trunde == 99){
$fgegner = $row['id'];    
} 
}
$result->close(); $db->close();
if($aktion == "kick"){ 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
turnier,
two,
trunde,
did
FROM
charaktere
WHERE turnier = "'.$turnier.'"
ORDER BY
two ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

  
$timer = 60 * 5; // 5 Minuten
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$zeit = time() - strtotime($row['did']);
  if($zeit > $timer)
  {
    $sql="UPDATE turnierstats SET was ='1' WHERE was='0' AND spieler = '".$row['id']."' AND turnier='".$turnier."' LIMIT 1";
    if (!mysqli_query($con, $sql))
    {
    die('Error: ' . mysqli_error($con));  
    } 
    $sql="UPDATE charaktere SET turnier ='0',two ='0',trunde ='0' WHERE id = '".$row['id']."' LIMIT 1";
    if (!mysqli_query($con, $sql))
    {
    die('Error: ' . mysqli_error($con));  
    } 
  }
}
$result->close(); $db->close();
mysqli_close($con);
}
if($gunter == 0){
if($aktion == "spring"&&$gegner == ""&&$finale != $uid){ 
if($gspieler != 2&&$finale == 1||$finale == 0){
turnierset($uid);
$error = 'Du bist eine Runde gesprungen.';
}
}
}
if($aktion == "win"&&$gspieler == 1){       
$titem = getwert($turnier,"turnier","item","id");   
$titema = getwert($turnier,"turnier","itema","id");   
$geht = 1;                            
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
if($titem != 0&&$geht == 1){
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
typ,
anlegbar
FROM
item  
WHERE id = "'.$titem.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['id'] == $titem){
$iname = $row['name'];
$ibild = $row['bild'];
$ityp = $row['typ'];
$ianlegbar = $row['anlegbar'];
}
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
WHERE besitzer = "'.$uid.'" AND name= "'.$iname.'" AND anzahl != "99" AND angelegt = ""
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
'$titema')"; 
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
if($tint < $titema){  
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
werte,
besitzer,
anzahl,
angelegt
FROM
items    
WHERE besitzer = "'.$uid.'" AND name= "'.$iname.'" AND anzahl != "99" AND angelegt = ""
ORDER BY
name,
besitzer
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
//BEISPIEL: 1 Item 99 , 1 Item 97 , 1 Item 20 , kaufe 10
$nanzahl = $row['anzahl']+$titema; //bei 97+10 = 107
if($nanzahl > 99){
$titema = $nanzahl-99; //nunoch 77
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
if($titema != 0){  
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
if($geht == 1){
$tryo = getwert($turnier,"turnier","ryo","id");       
$trank = getwert($turnier,"turnier","rank","id");  
if($tryo != "0"){     
$uryo = getwert(session_id(),"charaktere","ryo","session");    
$nryo = $uryo+$tryo;
$sql="UPDATE charaktere SET ryo ='$nryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($trank != ""){     
$sql="UPDATE charaktere SET rank ='$trank' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$sql="UPDATE charaktere SET turnier ='0',two ='0',trunde ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
/*
$sql="DELETE FROM turnier WHERE id = '".$turnier."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="DELETE FROM turnierstats WHERE turnier = '".$turnier."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
*/
$error = 'Du hast das Turnier gewonnen und die Belohnung erhalten.';
}
mysqli_close($con);
}

if($aktion == "kampf"){ 
if($gspieler == 2&&$finale != 0){ 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($finale == $uid){                            
$gegner = $fgegner;        
$frunde = getwert($fgegner,"charaktere","trunde","id");   
$fwo = getwert($fgegner,"charaktere","two","id");      
}
else{
$gegner = $finale;   
$frunde = getwert($uid,"charaktere","trunde","id");   
$fwo = getwert($uid,"charaktere","two","id");    
}
$sql="UPDATE charaktere SET two ='$fwo',trunde ='$frunde' WHERE id = '".$finale."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

$sql="INSERT INTO turnierstats(
`turnier`,
`spieler`,
`runde`,
`block`)
VALUES
('$turnier',
'$finale',  
'$frunde',
'$fwo')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
$teilnehmer = getwert($turnier,"turnier","teilnehmer","id");  
$teilnehmer = $teilnehmer+1;              
$sql="UPDATE turnier SET teilnehmer ='$teilnehmer',finale ='0' WHERE id = '".$turnier."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                
mysqli_close($con); 
} 
if($gegner != 0){       
$tort = getwert($turnier,"turnier","ort","id");    
$uhp = getwert(session_id(),"charaktere","hp","session");   
$ukid = getwert(session_id(),"charaktere","kampfid","session");  
$uort = getwert(session_id(),"charaktere","ort","session");  
if($uhp > 0&&$ukid == 0){  
$ghp = getwert($gegner,"charaktere","hp","id");  
$gkid = getwert($gegner,"charaktere","kampfid","id");    
$gort = getwert($gegner,"charaktere","ort","id");   
if($ghp > 0&&$gkid == 0){  
$kname = 'Turnierkampf';    
ausruest($uid);  
ausruest($gegner);
$teams = '1;2';
$owetter = getwert($tort,"orte","wetter","id");
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO fights(
`name`,
mode,
runde,
teams,
art,
offen,
begin,
pw,
ort,
wetter)
VALUES
('$kname',
'1vs1',
'1',
'$teams',
'Turnier',
'0',
'1',
'',
'$tort',
'$owetter')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$kid = mysqli_insert_id($con);   
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);         
$uchakra = getwert($uid,"charaktere","chakra","id"); 
$gchakra = getwert($gegner,"charaktere","chakra","id");      
$uname = getwert(session_id(),"charaktere","name","session"); 
$gname = getwert($gegner,"charaktere","name","id");           
$gbild = getwert($gegner,"charaktere","kbild","id");  
$ubild = getwert(session_id(),"charaktere","kbild","session");
$sql="UPDATE charaktere SET 
shp ='$uhp',
schakra ='$uchakra',
kampfid ='$kid',
lkaktion ='$zeit',
kname ='$uname',
powerup ='',
dstats ='',
debuff ='',
kkbild ='$ubild',
team='1'
 WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="UPDATE charaktere SET 
shp ='$ghp',
schakra ='$gchakra',
kampfid ='$kid',
lkaktion ='$zeit',
kname ='$gname',
powerup ='',
dstats ='',
debuff ='',
kkbild ='$gbild',
team='2'
 WHERE id = '".$gegner."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$error = 'Der Kampf wurde gestartet.';
}
else{
turnierset($uid);
$error = 'Dein Gegner war nicht zum Kampf bereit.';
}      
}
}
}
}
}
if($aktion == 'leave'){
if($turnier != 0){   
$tzeit = getwert($turnier,"turnier","start","id");    
$tzeit = strtotime($tzeit);
if($tzeit >= time()){   
$tenter = getwert($turnier,"turnier","enter","id");  
if($tenter == 1){      
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$sql="UPDATE turnier SET teilnehmer=(teilnehmer-1) WHERE id = '".$turnier."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="UPDATE charaktere SET turnier='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$sql="DELETE FROM turnierstats WHERE spieler='".$uid."' AND turnier='".$turnier."' LIMIT 1";    
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
mysqli_close($con);
$error = 'Du hast das Turnier verlassen.'; 
}
}
}
}
if($aktion == "join"){
if($turnier == 0){
$tid = $_GET['tid'];      
$uhp = getwert(session_id(),"charaktere","hp","session");  
if($uhp > 0){      
$two = getwert($tid,"turnier","ort","id");      
$tenter = getwert($tid,"turnier","enter","id");     
$teilnehmer = getwert($tid,"turnier","teilnehmer","id");     
if($tenter == 1){
if($two == $uort){       
$tzeit = getwert($tid,"turnier","start","id");    
$tzeit = strtotime($tzeit);
if($tzeit >= time()){    
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
turnier,
two
FROM
charaktere
WHERE turnier ="'.$tid.'"
ORDER BY
two ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$two = 1;
$tcount = 0;
$tspieler = 0;
$uwo = 0;
//1 , 1 , 2 , 3 , 3
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($uwo == 0){
$tspieler++;  
if($two != $row['two']&&$tspieler != 2){
$uwo = $two;
}
elseif($two == $row['two']&&$tspieler==2){   
$tspieler = 0;
$two = $two+1;
}
elseif($tspieler==2){
$uwo = $two;
}
}
}
$result->close(); $db->close();
if($uwo == 0){
$uwo = $two;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET turnier ='$tid',two ='$uwo',trunde ='1' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
$teilnehmer = $teilnehmer+1;
$sql="UPDATE turnier SET teilnehmer ='$teilnehmer' WHERE id = '".$tid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
$sql="INSERT INTO turnierstats(
`turnier`,
`spieler`,
`runde`,
`block`)
VALUES
('$tid',
'$uid',  
'1',
'$uwo')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con); 
$error = 'Turnier beigetreten.';
$turnier = $tid; 
}
else{
echo 'Das Turnier hat schon begonnen.';
}
}
}
}
else{
$error = 'Du hast keine HP mehr.';
}
}
else{
$error = 'Du bist schon in einem Turnier.';
}
}

}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                                           
//Hier kommt der Code hin
$page = $_GET['page'];
if($page == 'see'&&$_GET['tid']){
$turnier = $_GET['tid'];              
$zeit = getwert($turnier,"turnier","start","id");     
$zeit2 = strtotime($zeit);
if(time() > $zeit2){
$teilnehmer = getwert($turnier,"turnier","teilnehmer","id");   
echo '<br><center><table class="table" height="100%" cellspacing="0">';
echo '<tr height="100%">';
$count = 1;
$rteilnehmer = $teilnehmer;
while($rteilnehmer != 0){  
echo '<td class="tdborder tdbg">Runde '.$count.'</td>';
$rteilnehmer = ceil($rteilnehmer/2);
if($rteilnehmer == 1){
$rteilnehmer = 0;
}
$count++;    
}         
$finale = getwert($turnier,"turnier","finale","id");  
if($finale != 0){
echo '<td class="tdborder tdbg">Finale</td>'; 
$count = $count+1;
} 
echo '<td class="tdborder tdbg">Gewinner</td>';     
echo '</tr><tr height="90%">';
$runde = 1;
$wrunde = $count;
while($count != 0){ 
echo '<td>';
echo '<table height="100%" width="100%" cellspacing="0">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
spieler,
runde,
block,
turnier,
was
FROM
turnierstats
WHERE turnier="'.$turnier.'"  AND runde="'.$runde.'"
ORDER BY
block ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}          
$iblock = 1;   
$tspieler = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($wrunde != $runde){
$tspieler++;
if($tspieler == 3){
echo '<tr><td align="center" style="border-right-width:1px;border-right-style:solid; border-top-width:1px;border-top-style:solid;">';
$tspieler = 1;
}
else{
echo '<tr><td align="center" style="border-right-width:1px;border-right-style:solid;">';
}
}
else{    
echo '<tr><td align="center">';
}
$sname = getwert($row['spieler'],"charaktere","name","id");
if($row['was'] == 0){
echo '<a href="user.php?id='.$row['spieler'].'">'.$sname.'</a>';
}
if($row['was'] == 1){
echo '<a href="user.php?id='.$row['spieler'].'"><strike>'.$sname.'</strike></a>';
}
if($row['was'] == 2){   
echo '<a href="user.php?id='.$row['spieler'].'"><i>'.$sname.'</i></a>';

}
echo '</td></tr>';
}
$result->close(); $db->close();
if($tspieler == 0&&$count != 1){     
echo '<tr><td align="center" style="border-right-width:1px;border-right-style:solid;">';
if($count == 2&&$finale != 0){                                                       
$sname = getwert($finale,"charaktere","name","id");
echo '<a href="user.php?id='.$finale.'">'.$sname.'</a>';
}
echo '</td></tr>';
}
elseif($count == 2&&$finale != 0){     
echo '<tr><td align="center" style="border-right-width:1px;border-right-style:solid;">';                   
$sname = getwert($finale,"charaktere","name","id");
echo '<a href="user.php?id='.$finale.'">'.$sname.'</a>';   
echo '</td></tr>';
}
echo '</table>';
echo '</td>';   
$count--;
$runde++;
}
echo '</tr>';      
echo '</table></center>';
}
echo '<br><a href="turnier.php">Zurück</a>';
}
if($page == ''){
if($turnier == 0||$turnier != 0&&$tzeit >= time()){
echo '<center><table class="table" cellspacing="0" width="500px">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
ort,
start,
ryo,
rank,
item,
itema,
enter,
teilnehmer,
finale
FROM
turnier';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<tr>';
echo '<td class="tdborder tdbg">Name</td>';         
echo '<td class="tdborder tdbg">Ort</td>';
echo '<td class="tdborder tdbg">Teilnehmer</td>';
echo '<td class="tdborder tdbg">Start</td>';
echo '<td class="tdborder tdbg">Gewinn</td>';    
echo '<td class="tdborder tdbg"></td>';
echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr>';
echo '<td>'.$row['name'].'</td>';           
$oname = getwert($row['ort'],"orte","name","id");   
echo '<td>'.ucwords($oname).'</td>';          
$zeit2 = strtotime($row['start']);
if($turnier == $row['id']){
$uzeit = $zeit2;
} 
$zeit = date("d.m.Y H:i:s",$zeit2);     
if($row['finale'] == 0){ 
echo '<td>'.$row['teilnehmer'].'</td>';
}
else{
echo '<td>'.($row['teilnehmer']+1).'</td>';
}
echo '<td>'.$zeit.'</td>';
echo '<td>';
if($row['ryo'] != 0){
echo 'Ryo: '.$row['ryo'].'<br>';
}   
if($row['rank'] != ""){
echo 'Rank: '.ucwords($row['rank']).'<br>';
} 
if($row['item'] != 0){            
$itemn = getwert($row['item'],"item","name","id");  
echo 'Item: '.$row['itema'].'x '.$itemn.'<br>';
}
echo '</td>';
echo '<td>';                
if($uort == $row['ort']){
if($row['id'] != $turnier){
if($turnier == 0){
if($row['enter'] != 0&&time() <= $zeit2){
echo '<a href="turnier.php?aktion=join&tid='.$row['id'].'">Beitreten</a><br>';
}
}
}
else{
if($row['enter'] != 0&&time() <= $zeit2){
echo '<a href="turnier.php?aktion=leave">Verlassen</a><br>';
}
}  
}       
if(time() > $zeit2){
echo '<a href="turnier.php?page=see&tid='.$row['id'].'">Zuschauen</a>';
}
echo '</td>';
echo '</tr>';
}
$result->close(); $db->close();
echo '</table></center>';
}
if($turnier != 0&&time() > $uzeit){      
echo '<br><center><table class="table" height="100%" cellspacing="0">';
echo '<tr height="100%">';
$count = 1;
$rteilnehmer = $teilnehmer;
while($rteilnehmer != 0){  
echo '<td class="tdborder tdbg">Runde '.$count.'</td>';
$rteilnehmer = ceil($rteilnehmer/2);
if($rteilnehmer == 1){
$rteilnehmer = 0;
}
$count++;    
}       $finale = getwert($turnier,"turnier","finale","id");  
if($finale != 0){
echo '<td class="tdborder tdbg">Finale</td>'; 
$count = $count+1;
} 
echo '<td class="tdborder tdbg">Gewinner</td>';     
echo '</tr><tr height="90%">';
$runde = 1;
$wrunde = $count;
while($count != 0){ 
echo '<td>';
echo '<table height="100%" width="100%" cellspacing="0">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
spieler,
runde,
block,
turnier,
was
FROM
turnierstats  
WHERE turnier="'.$turnier.'"  AND runde="'.$runde.'"
ORDER BY
block ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}          
$iblock = 1;   
$tspieler = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($wrunde != $runde){
$tspieler++;
if($tspieler == 3){
echo '<tr><td align="center" style="border-right-width:1px;border-right-style:solid; border-top-width:1px;border-top-style:solid;">';
$tspieler = 1;
}
else{
echo '<tr><td align="center" style="border-right-width:1px;border-right-style:solid;">';
}
}
else{    
echo '<tr><td align="center">';
}
$sname = getwert($row['spieler'],"charaktere","name","id");
if($row['was'] == 0){
echo '<a href="user.php?id='.$row['spieler'].'">'.$sname.'</a>';
}
if($row['was'] == 1){
echo '<a href="user.php?id='.$row['spieler'].'"><strike>'.$sname.'</strike></a>';
}
if($row['was'] == 2){   
echo '<a href="user.php?id='.$row['spieler'].'"><i>'.$sname.'</i></a>';

}
echo '</td></tr>';
}
$result->close(); $db->close();
if($tspieler == 0&&$count != 1){     
echo '<tr><td align="center" style="border-right-width:1px;border-right-style:solid;">';
if($count == 2&&$finale != 0){                                                       
$sname = getwert($finale,"charaktere","name","id");
echo '<a href="user.php?id='.$finale.'">'.$sname.'</a>';
}
echo '</td></tr>';
}
elseif($count == 2&&$finale != 0){     
echo '<tr><td align="center" style="border-right-width:1px;border-right-style:solid;">';                   
$sname = getwert($finale,"charaktere","name","id");
echo '<a href="user.php?id='.$finale.'">'.$sname.'</a>';   
echo '</td></tr>';
}
echo '</table>';
echo '</td>';   
$count--;
$runde++;
}
echo '</tr>';      
echo '</table></center>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
turnier,
two,
trunde
FROM
charaktere  
WHERE turnier="'.$turnier.'"
ORDER BY
trunde ASC,
two ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$tspieler = 0;
$two = 1;     
$trunde = 1; 
$gspieler = 0;     
$fgegner = 0;          
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gspieler++;  
if($trunde == $row['trunde']){
if($tspieler == 2){
$tspieler = 0;
$two = $two+1;
}
}
else{
$trunde = $row['trunde'];   
$tspieler = 0;
$two = 1;
}        
$tspieler++;
if($finale != 0&&$trunde != 99){
$fgegner = $row['id'];    
} 

}
$result->close(); $db->close();
if($tzeit < time()){
echo '<br>';
if($gspieler == 2&&$finale != 0){
if($finale == $uid){                            
$sname = getwert($fgegner,"charaktere","name","id");
echo 'Gegner: <a href="user.php?id='.$fgegner.'">'.$sname.'</a>';
echo '<br>';
echo '<a href="turnier.php?aktion=kampf">Kampf starten</a>';
}
else{
$sname = getwert($finale,"charaktere","name","id");
echo 'Gegner: <a href="user.php?id='.$finale.'">'.$sname.'</a>';
echo '<br>';
echo '<a href="turnier.php?aktion=kampf">Kampf starten</a>';
}
}
else{
if($gunter == 0){
if($gspieler != 1){
if($gegner != ""){
echo 'Gegner: <a href="user.php?id='.$gegner.'">'.$gname.'</a>';
echo '<br>';
echo '<a href="turnier.php?aktion=kampf">Kampf starten</a>';
}
else{
if($finale != $uid){
echo 'Du hast keinen Gegner, du kannst diese Runde überspringen.<br><a href="turnier.php?aktion=spring">Runde überspringen</a>';
}
else{
echo 'Du bist im Finale und musst auf die Gegner warten.';
}
}
}
else{
echo 'Du hast gewonnen!<br><a href="turnier.php?aktion=win">Belohnung abholen</a>';
}
}
else{
echo 'Es befinden sich noch Spieler in der Vorrunde.';
echo '<br/>';
echo '<a href="turnier.php?aktion=kick">Inaktive kicken</a>';
}
}
}
}
}
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