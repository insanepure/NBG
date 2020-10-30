<?php

//Cron Style ist 
//  *      *         *       *        *
//  0,30  15         *       *        2        // jeden Dienstag um 15:00 und 15:30
// */5     *         *       *        *        // alle 5 Minuten
//Minute Stunde Tag (Monat) Monat Tag (Woche)
//
//
//Page 1 = Autologout  - um 0 und 30 Min jede Stunde // 0,30 * * * * 
//Page 2 = 0 Uhr Update    - 00:00 jeden Tag // 59 23 * * *
//Page 3 = Genin       - Di , Do und SA um 10:00 und 20:00uhr // 0 10,20 * * 2,4,6
//Page 4 = Chuunin      - Sonntag 15:00, 18, 20, 22 // 0 15,18,20,22 * * 3,5,7
//Page 5 = Kage Turnier (Jeden 10. des Monats)  - 09 um 15  // 0 15 9 * *
//Page 6 = Update Start - 23:50 jeden Tag // 50 23 * * *
//Page 7 = Kriegstimer - alle 5 minuten // */5 * * * *


ini_set ('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$server_adr = '.';
include_once 'inc/serverdaten.php';
ignore_user_abort(true);   
set_time_limit(30);

$page = $argv[1];

function ausruest($uid){   
include 'inc/serverdaten.php';
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
WHERE besitzer="'.$uid.'"';
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
$check = 0;         
$ulevel = getwert($uid,"charaktere","level","id"); 
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['typ'] == 3){
if($row['angelegt'] != ""){
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
$check = 1;
}
else{
$kra = $kra+$array[0]; 
$check = 1;
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
$check = 1;
}
else{
$intla = $intla+$array[1];  
$check = 1;
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
$check = 1;
}
else{
$chrka = $chrka+$array[2];
$check = 1;
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
$check = 1;
}
else{
$tmpa = $tmpa+$array[3];   
$check = 1;
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
$check = 1;
}
else{
$gnka = $gnka+$array[4];    
$check = 1;
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
$check = 1;
}
else{
$wida = $wida+$array[5];
$check = 1;
}
}

}
}
}
$result->close();
$db->close();
if($check == 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
mkr,
mtmp,
mgnk,
mchrk,
mintl,
mwid
FROM
charaktere
WHERE id="'.$uid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
      if($kra != 0){   
      $nkr = $row['mkr']+$kra;
      $sql="UPDATE charaktere SET kr ='$nkr' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }      
      }
      if($tmpa != 0){   
      $ntmp = $row['mtmp']+$tmpa;
      $sql="UPDATE charaktere SET tmp ='$ntmp' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }      
      } 
      if($intla != 0){   
      $nintl = $row['mintl']+$intla;
      $sql="UPDATE charaktere SET intl ='$nintl' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }      
      }
      if($gnka != 0){   
      $ngnk = $row['mgnk']+$gnka;
      $sql="UPDATE charaktere SET gnk ='$ngnk' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }      
      }
      if($chrka != 0){   
      $nchrk = $row['mchrk']+$chrka;
      $sql="UPDATE charaktere SET chrk ='$nchrk' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }      
      }
      if($wida != 0){   
      $nwid = $row['mwid']+$wida;
      $sql="UPDATE charaktere SET wid ='$nwid' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }      
      }    
      
      mysqli_close($con);


}
$result->close(); $db->close(); 
}
}  
function getwert($id,$tabelle,$was,$was2){
include 'inc/serverdaten.php';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'Select '.$was.','.$was2.' FROM '.$tabelle.' WHERE '.$was2.' = '."'".$id."' LIMIT 1";
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$row = $result->fetch_assoc();
return $row[$was];
$result->close(); $db->close();     
} //getwert
function getanzahl($id,$tabelle,$wert2,$was){    
include 'inc/serverdaten.php';                     
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
if($was != 0){
$sql = 'SELECT
id,
'.$wert2.'
FROM
'.$tabelle.'
ORDER BY id DESC';
}
else{
$sql = 'SELECT
id
FROM
'.$tabelle.'
ORDER BY id DESC';
}
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$anzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($was == 1&&$row[$wert2] == $id||$was == 0||$was == 2&&$row[$wert2] != $id){
$anzahl++;
}
}
$result->close(); $db->close(); 
return $anzahl;
} //getanzahl
//Page 1 = Autologout   
//Page 2 = 0 Uhr Update    
//Page 3 = Genin          
//Page 4 = Chuunin       
//Page 5 = Kage Turnier (Jeden 10. des Monats)     
//Page 6 = Update Start
//Page 7 = Kriegstimer
echo 'Start<br>';       
if($page == 7){                                                         
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
art,
kwo,
dorf
FROM
kriegkampf';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}                  
$npc = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
echo 'Kriegskampf';
$team[0] = $row['dorf'];      
if($row['art'] == 'Eroberung'){  
$kname = 'Eroberungskampf';  
$art = 'Eroberung';  
$eroberer = getwert($row['kwo'],"krieg","erobert","id");  
if($eroberer == 0){
$eroberer = 'kein';
}
$team[1] = $eroberer;   
$teama[1] = 1;
$npc = 86;
}
elseif($row['art'] == 'Patrouillie'){  
$kname = 'Patrouillie';  
$art = 'Eroberung';  
$npc = 71;
$teama[1] = 1;
$team[1] = 99;
}         
else{
$art = 'Bijuu';
$kname = "Bijuukampf";  
}
$kmode = '1vs1';   
$teams = '1;2';
$ort = '0';     
$owetter = getwert($row['kwo'],"krieg","wetter","id");
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
'$kmode',
'1',
'$teams',
'$art',
'0',
'1',
'',
'$ort',
'$owetter')";       
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}             
$kid = mysqli_insert_id($con);
$sql="UPDATE krieg SET kampf ='$kid' WHERE id = '".$row['kwo']."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }          
$sql = 'SELECT
name,
kbild,
id,
kampfid,
dorf,
hp
FROM
charaktere
WHERE kriegkampf ="'.$row['id'].'"';
$result2 = $db->query($sql);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}    
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false 
echo '<br>------<br>';
echo 'ID: '.$row2['id'].'<br>';
$t = 0;
$uteam = 0;
echo 'Uteam1: '.$uteam.'<br>';
while($team[$t] != ''&&$uteam == 0){  
echo '$t: '.$t.'<br>';                     
echo '$team: '.$team[$t].'<br>'; 
if($row2['dorf'] == $team[$t]){    
echo 'Gleich<br>';
$uteam = $t+1;
$teama[$t]++;
}
else
{
if($team[$t] != 'kein'){  
$count = 0;
$tally = getwert($team[$t],"orte","ally","id");   
$array = explode(";", trim($tally));
while($array[$count] != ''){
if($array[$count] == $row2['dorf']){
$uteam = $t+1;
$teama[$t]++;
$array[$count+1] = '';
}
$count++;
}
echo 'Uteama: '.$uteam.'<br>';
}
}
$t++;
}     
echo 'Uteam2: '.$uteam.'<br>';
if($uteam == 0){    
echo '$t: '.$t.'<br>';                 
$team[$t] = $row['dorf'];
$teama[$t] = 1;
$uteam = $t+1;      
echo 'Uteam3: '.$uteam.'<br>';
}
mysqli_close($con);
ausruest($row2['id']);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);  
$hp = $row2['hp'];
if($hp == 0){
$hp = 1;
}
$sql="UPDATE charaktere SET hp='$hp',team ='$uteam',kkbild ='".$row2['kbild']."',debuff ='',dstats ='',powerup ='',kampfid ='$kid',lkaktion ='$zeit',kname ='".$row2['name']."' WHERE id = '".$row2['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result2->close();    
$t = 0;
$mode = '';
$teams = '';
echo '<br>------<br>';
while($team[$t] != ''){
echo 't: '.$t.'<br>';
$mode = $mode.''.$teama[$t];   
echo '$mode: '.$mode.'<br>';
$teams = $teams.''.($t+1);      
echo '$teams: '.$teams.'<br>';
if($team[$t+1] != ''){
$mode = $mode.'vs';    
$teams = $teams.';';
echo '$teams2: '.$teams.'<br>';
}             
echo '$teams3: '.$teams.'<br>';
$t++;
}    
$sql="UPDATE fights SET mode ='$mode',teams='$teams' WHERE id = '".$kid."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }  
$sql="UPDATE charaktere SET kriegkampf='0' WHERE kriegkampf = '".$row['id']."'";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
if($npc != 0){
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
kbild,
jutsus,
vgemacht
FROM
npc
WHERE id="'.$npc.'" LIMIT 1';
$result2 = $db->query($sql);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
$nteam = 2;   
$npc = $row2['name'];
$nkr = $row2['kr'];
$nhp = $row2['hp'];
$nchakra = $row2['chakra'];
$nwid = $row2['wid'];
$ntmp = $row2['tmp'];
$ngnk = $row2['gnk'];
$nintl = $row2['intl'];
$nchrk = $row2['chrk'];
$nkbild = $row2['kbild'];
$njutsus = $row2['jutsus'];
$vertag = $row2['vgemacht'];

$sql="INSERT INTO npcs(
`name`,
`kname`,
`vertrag`,
kr,
mkr,
wid,
mwid,
tmp,
mtmp,
gnk,
mgnk,
intl,
mintl,
chrk,
mchrk,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
jutsus,
kaktion,
kziel,        
npcid,
kbild,
kkbild)
VALUES
('$npc',
'$npc',
'$vertrag',
'$nkr',
'$nkr',
'$nwid',
'$nwid',
'$ntmp',
'$ntmp',
'$ngnk',
'$ngnk',
'$nintl',
'$nintl',
'$nchrk',
'$nchrk',
'$kid',
'$nteam',
'$nhp',
'$nhp',
'$nchakra',
'$nchakra',
'$njutsus',
'Zufall',
'Zufall',    
'$npcid',  
'$nkbild',
'$nkbild')";  
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result2->close();

}
      $sql="DELETE FROM kriegkampf WHERE id = '".$row['id']."'";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }  
mysqli_close($con);
}  
$result->close();
$db->close();   

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kriegaktion,
kriegaktiond,
kriegaktions,
kriegwer,
hp,
kwo,
kwob,
name,
kbild,
id,
kampfid,
dorf
FROM
charaktere
WHERE kriegaktion !=""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}                                              
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false 
$test2 = strtotime($zeit);
$test = strtotime($row['kriegaktions']); 
$test3 = $test2-$test;
$test4 = ($row['kriegaktiond']*60)-$test3;   
if($test4 <= 0){    
if($row['kriegaktion'] == 'Krieg reisen'){  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$sql="UPDATE charaktere SET kwo ='".$row['kwob']."',kwob ='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
      mysqli_close($con);
}
else{
if($row['hp'] != 0&&$row['kampfid'] == 0){      
$kkampf = getwert($row['kwo'],"krieg","kampf","id");   
if($kkampf == 0){
echo $row['id'].' KAMPFSTART<br>';
if($row['kriegaktion'] == 'Bijuukampf'){      
$kmode = '1vs1';   
$teams = '1;2';
$kname = "Bijuukampf";  
$ort = '0';    
ausruest($row['id']);
$owetter = getwert($row['kwo'],"krieg","wetter","id");
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$bijuu = $row['kriegwer'];
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
'$kmode',
'1',
'$teams',
'Bijuu',
'0',
'1',
'',
'$ort',
'$owetter')";       
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$kid = mysqli_insert_id($con);
$sql="UPDATE krieg SET kampf ='$kid' WHERE id = '".$row['kwo']."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }             
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);  
$sql="UPDATE charaktere SET team ='1',kkbild ='".$row['kbild']."',debuff ='',dstats ='',powerup ='',kampfid ='$kid',lkaktion ='$zeit',kname ='".$row['name']."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
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
kbild,
jutsus,
vgemacht
FROM
npc
WHERE name="'.$bijuu.'" LIMIT 1';
$result2 = $db->query($sql);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
$nteam = 2;   
$npc = $row2['name'];
$nkr = $row2['kr'];
$nhp = $row2['hp'];
$nchakra = $row2['chakra'];
$nwid = $row2['wid'];
$ntmp = $row2['tmp'];
$ngnk = $row2['gnk'];
$nintl = $row2['intl'];
$nchrk = $row2['chrk'];
$nkbild = $row2['kbild'];
$njutsus = $row2['jutsus'];
$vertag = $row2['vgemacht'];

$sql="INSERT INTO npcs(
`name`,
`kname`,
`vertrag`,
kr,
mkr,
wid,
mwid,
tmp,
mtmp,
gnk,
mgnk,
intl,
mintl,
chrk,
mchrk,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
jutsus,
kaktion,
kziel,        
npcid,
kbild,
kkbild)
VALUES
('$npc',
'$npc',
'$vertrag',
'$nkr',
'$nkr',
'$nwid',
'$nwid',
'$ntmp',
'$ntmp',
'$ngnk',
'$ngnk',
'$nintl',
'$nintl',
'$nchrk',
'$nchrk',
'$kid',
'$nteam',
'$nhp',
'$nhp',
'$nchakra',
'$nchakra',
'$njutsus',
'Zufall',
'Zufall',    
'$npcid',  
'$nkbild',
'$nkbild')";  
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result2->close();
mysqli_close($con);  
}
else{
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
if($row['kriegaktion'] == 'Jinchuurikikampf'){
$art = 'Bijuu';
}
else if($row['kriegaktion'] == 'Krieg erobern'){
$art = 'Eroberung';
}
else{
$art = 'Patrouillie';
}        
echo 'a'; 
$sql="INSERT INTO kriegkampf(
`art`,
`dorf`,
`kwo`)
VALUES
('$art',
'".$row['dorf']."',
'".$row['kwo']."')";             
echo $sql;
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$kid = mysqli_insert_id($con);
$sql="UPDATE charaktere SET kriegkampf ='$kid' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
if($row['kriegaktion'] == 'Jinchuurikikampf'){
$sql="UPDATE charaktere SET kriegkampf ='$kid' WHERE id = '".$row['kriegwer']."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
}
mysqli_close($con);
}
/*
ausruest($row['id']);       
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$kmode = '1vs1';   
$teams = '1;2'; 
if($row['kriegaktion'] == 'Krieg erobern'||$row['kriegaktion'] == 'Krieg patrollieren'){
if($row['kriegaktion'] == 'Krieg erobern'){ 
$kname = "Eroberung";  
}     
else{
$kname = "Patrouille";  
}
$ort = '0';    
$owetter = getwert($row['kwo'],"krieg","wetter","id");
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
'$kmode',
'1',
'$teams',
'Eroberung',
'0',
'1',
'',
'$ort',
'$owetter')";       
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$kid = mysqli_insert_id($con);
$sql="UPDATE krieg SET kampf ='$kid' WHERE id = '".$row['kwo']."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }             
$sql="UPDATE charaktere SET  team ='1',kkbild ='".$row['kbild']."',debuff ='',dstats ='',powerup ='',kampfid ='$kid',lkaktion ='$zeit',kname ='".$row['name']."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}         
if($row['kriegaktion'] == 'Krieg erobern'){ 
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
kbild,
jutsus,
vgemacht
FROM
npc
WHERE id = 86';
}
else{
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
kbild,
jutsus,
vgemacht
FROM
npc
WHERE id = 71';
}
$result2 = $db->query($sql);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
$nteam = 2;   
$npc = $row2['name'];
$nkr = $row2['kr'];
$nhp = $row2['hp'];
$nchakra = $row2['chakra'];
$nwid = $row2['wid'];
$ntmp = $row2['tmp'];
$ngnk = $row2['gnk'];
$nintl = $row2['intl'];
$nchrk = $row2['chrk'];
$nkbild = $row2['kbild'];
$njutsus = $row2['jutsus'];
$vertag = $row2['vgemacht'];

$sql="INSERT INTO npcs(
`name`,
`kname`,
`vertrag`,
kr,
mkr,
wid,
mwid,
tmp,
mtmp,
gnk,
mgnk,
intl,
mintl,
chrk,
mchrk,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
jutsus,
kaktion,
kziel,        
npcid,
kbild,
kkbild)
VALUES
('$npc',
'$npc',
'$vertrag',
'$nkr',
'$nkr',
'$nwid',
'$nwid',
'$ntmp',
'$ntmp',
'$ngnk',
'$ngnk',
'$nintl',
'$nintl',
'$nchrk',
'$nchrk',
'$kid',
'$nteam',
'$nhp',
'$nhp',
'$nchakra',
'$nchakra',
'$njutsus',
'Zufall',
'Zufall',    
'$npcid',  
'$nkbild',
'$nkbild')";  
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result2->close();  
mysqli_close($con); 
*/
}
} 
}     
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$sql="UPDATE charaktere SET kriegaktion ='',kriegaktiond ='0',kriegwer='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }   
mysqli_close($con); 
}      
}
$result->close();
$db->close();   
}
if($page == 5){   
//Kage Turnier
$zeit = time()+(60*60*24); //24 Stunden später    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
chuunin,
was,
id,
nuke
FROM
orte
WHERE nuke != "1" AND was = "dorf"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$start = date("YmdHis",$zeit);
$ort = $row['id'];
echo 'Starte Turnier';  
echo '<br>';  
$sql="INSERT INTO turnier(
`name`,
start,   
rank,
item,
itema, 
ort,
enter)
VALUES
('Kage Turnier',
'$start',
'kage',
'97',
'1',    
'$ort',
'0')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$tid = mysqli_insert_id($con);   
echo $sql;              
echo '<br>';  
$sql="UPDATE orte SET kagetid = '$tid' WHERE id = '".$row['id']."' LIMIT 1";
echo $sql;
mysqli_query($con, $sql);
echo '<br>';
}
$result->close(); $db->close();  
$sql="UPDATE charaktere SET rank = 'anbu' WHERE rank = 'kage' AND level >= 60";
echo $sql;
mysqli_query($con, $sql);  
$sql="UPDATE charaktere SET rank = 'jounin' WHERE rank = 'kage' AND level >= 50";
echo $sql;
mysqli_query($con, $sql);    
$sql="DELETE FROM items WHERE name = 'Kage Umhang'";
echo $sql;
mysqli_query($con, $sql);
//items weg
 
mysqli_close($con);      
}
if($page == 4){
echo 'Chuunin Prüfung<br>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
chuunin,
was,
id,
nuke
FROM
orte
WHERE nuke != "1"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$statt = 0;
$orte = "";
$count = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['was'] == 'dorf'&&$row['chuunin'] == 0){
$orte[$count] = $row['id'];
$count++;
}                         
if($row['chuunin'] != 0){   
$statt = $row['chuunin'];
$statto = $row['id'];
}
}
$result->close(); $db->close();    
$count = $count-1;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
if($statt == 4){  //22Uhr
echo 'Setze Chuuninort';    
echo '<br>';
$sql="UPDATE orte SET chuunin = '0' WHERE chuunin = '4' LIMIT 1";
echo $sql;
mysqli_query($con, $sql);   
echo '<br>';
$oz = rand(0,$count);
$ort = $orte[$oz];
echo 'Ort: '.$ort;   
echo '<br>';
$sql="UPDATE orte SET chuunin = '1' WHERE id ='".$ort."' LIMIT 1";
echo $sql;
mysqli_query($con, $sql);   
echo '<br>';
}            
if($statt == 1){ //15 Uhr
echo 'Starte schriftlicher Teil';  
echo '<br>';  
$sql="UPDATE orte SET chuunin = '2' WHERE chuunin = '1' LIMIT 1";
echo $sql;
mysqli_query($con, $sql);
$start = time()+(60*60*3);    
$start = date("YmdHis",$start);
echo 'Starte Turnier';  
echo '<br>';  
$sql="INSERT INTO turnier(
`name`,
start,   
rank,
item,
itema, 
ort,
enter)
VALUES
('Chuunin Prüfung',
'$start',
'chuunin',
'40',
'1',    
'$statto',
'0')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$tid = mysqli_insert_id($con);   
echo $sql;              
echo '<br>';  
$sql="UPDATE orte SET chuunintid = '$tid' WHERE chuunin = '2' LIMIT 1";
echo $sql;
mysqli_query($con, $sql);
echo '<br>';

}           
if($statt == 2){ //18Uhr
echo 'Starte Turnier';  
echo '<br>';  
$sql="UPDATE orte SET chuunin = '3' WHERE chuunin = '2' LIMIT 1";
echo $sql;
mysqli_query($con, $sql);     
echo '<br>';

}           
if($statt == 3){ //20Uhr
echo 'Beende Prüfung';  
echo '<br>';  
$sql="UPDATE orte SET chuunintid = '0',chuunin = '4' WHERE chuunin = '3' LIMIT 1";
echo $sql;
mysqli_query($con, $sql);   
echo '<br>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
start,
id
FROM
turnier
WHERE name = "Chuunin Prüfung" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$statt = 0;
$orte = "";
$count = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$tzeit = strtotime($row['start']);
if($tzeit < time()){   
$test = getwert($row['id'],"charaktere","name","turnier");     
if($test == ""){
$sql="DELETE FROM turnier WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}

}
$result->close(); $db->close();

}
mysqli_close($con);
}
if($page == 3){
echo 'Genin Prüfung<br>';
echo 'Findet statt: ';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
genin
FROM
orte
WHERE genin = "1" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$statt = 0;   
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$statt = 1;
}
$result->close(); $db->close();  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
if($statt == 1){
echo 'Ja<br>';
echo 'Beende die Prüfung ..';
echo '<br>';
$sql="UPDATE orte SET genin = '0' WHERE was = 'dorf'";
echo $sql;
mysqli_query($con, $sql);
echo '<br>';
}
else{
echo 'Nein<br>';
echo 'Starte die Prüfung ..';
echo '<br>';
$sql="UPDATE orte SET genin = '1' WHERE was = 'dorf'";
echo $sql;
mysqli_query($con, $sql);
echo '<br>';
}
mysqli_close($con);
}
if($page == 6){   
echo '0 Uhr Update Start';
echo '<br>';
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
$update = "Es findet gerade das 0Uhr-Update statt.";      
$sql='UPDATE game
SET onoff="'.$update.'" LIMIT 1';
mysqli_query($con, $sql);
echo $sql;
echo '<br>';
mysqli_close($con);

}
if($page == 2){   
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
echo '0 Uhr Update';
echo '<br>';
$sql = 'SELECT id,date FROM pms';     
echo $sql.'<br>';
$result = mysqli_query($con, $sql) or die(mysqli_error($con));  
while ($row = mysqli_fetch_assoc($result))
{       
$zeit = time()-strtotime($row['date']);    
if($zeit >= (60*60*24*30)){ //30 Tage
$sql = 'DELETE FROM pms WHERE id="'.$row['id'].'"';  
echo $sql.'<br>';
mysqli_query($con, $sql); 
}
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
wetter,
id,
bijuu,
rorte
FROM
krieg';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$wetter = $row['wetter'];
if($wetter == "Sonne"){
$r1 = "Regen";
$r2 = "Hitze";   
}

if($wetter == "Regen"){
$r1 = "Gewitter";
$r2 = "Sturm";  
}

if($wetter == "Gewitter"){
$r1 = "Sturm";
$r2 = "Regen";  
}

if($wetter == "Sturm"){   
$r1 = "Erdrutsch";
$r2 = "Gewitter";  
}

if($wetter == "Erdrutsch"){ 
$r1 = "Hitze";  
$r2 = "Regen";
}

if($wetter == "Hitze"){
$r1 = "Gewitter";
$r2 = "Erdrutsch";  
}
$rand = rand(1,10);
if($rand <= 2){
$g = $r1;
}
else{
$rand = rand(1,10);
if($rand <= 1){
$g = $r2;
}
else{
$g = "Sonne";
}
}          
$sql="UPDATE krieg
SET wetter='".$g."',kampf='0'
WHERE id='".$row['id']."' LIMIT 1";
echo $sql.'<br/>';
mysqli_query($con, $sql);
if($row['bijuu'] != ""){
$array = explode(";", trim($row['rorte']));
$count = 0;
$nort = 0;
$sort = 0;
while($array[$count] != ''){  
echo 'a';
$tbijuu = getwert($array[$count],"krieg","bijuu","id");    
if($tbijuu == ''){ 
$rand = rand(1,2);
if($rand == 1){
$nort = $array[$count];
}
else{
$sort = $array[$count];
}
}
$count++;
}
if($sort == 0){
$nort = $row['id'];
}
if($nort == 0){
$nort = $sort;
}
if($nort != $row['id']){
$sql="UPDATE krieg
SET bijuu='".$row['bijuu']."'
WHERE id='".$nort."' LIMIT 1";
echo $sql.'<br/>';
mysqli_query($con, $sql);
$sql="UPDATE krieg
SET bijuu=''
WHERE id='".$row['id']."' LIMIT 1";
echo $sql.'<br/>';
mysqli_query($con, $sql);
}
}
}
$result->close(); $db->close(); 

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
tag
FROM
game';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$tag = $row['tag'];
$ntag = $tag+1;                          
$sql="UPDATE game
SET tag=$ntag";
echo $sql;
mysqli_query($con, $sql);
}
$result->close(); $db->close(); 
      $sql="TRUNCATE TABLE `fights`";
      mysqli_query($con, $sql);           
      $sql="TRUNCATE TABLE `npcs`";
      mysqli_query($con, $sql);    
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id
FROM
turnier';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$tanzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$anzahl = getanzahl($row['id'],"charaktere","turnier","1");
if($anzahl == 0){
$sql="DELETE FROM turnier WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="DELETE FROM turnierstats WHERE turnier = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}
else{
$tanzahl++;
}
}
$result->close(); $db->close();   
if($tanzahl == 0){          
      $sql="TRUNCATE TABLE `turnier`";
      mysqli_query($con, $sql);    
$sql="UPDATE orte
SET kagetid=0";
mysqli_query($con, $sql);
        
      $sql="TRUNCATE TABLE `turnierstats`";
      mysqli_query($con, $sql);  
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
shp,
id,
schakra,
did,
level,
exp,
(mhp/10+mchakra/10+mkr+mintl+mchrk+mgnk+mwid+mtmp) AS werte
FROM
charaktere
ORDER BY
admin ASC,
level DESC,
exp DESC,
werte DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}         
$zeit2 = time();
$zeit = date("Y-m-d H:i:s",$zeit2);
$test2 = strtotime($zeit);
$platz = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$did = $row['did'];
$test = strtotime($did);
$test3 = $test2-$test;
// Sekunde * Minute * Stunden * Tage * 3 = 90 Tage
//60*60*24*30*3
$delete = 60*60*24*30*3;
if($test3 >= $delete){
$sql="DELETE FROM freunde WHERE an = '".$row['id']."' OR von = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM summon WHERE besitzer = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM items WHERE besitzer = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM markt WHERE besitzer = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM charaktere
WHERE id='".$row['id']."' LIMIT 1";
mysqli_query($con, $sql);   
}
else{
$platz++;
if($row['shp'] != 0){
$sql="UPDATE charaktere
SET hp='".$row['shp']."',shp='0'
WHERE id='".$row['id']."' LIMIT 1";
mysqli_query($con, $sql);  
}
if($row['schakra'] != 0){
$sql="UPDATE charaktere
SET chakra='".$row['schakra']."',schakra='0'
WHERE id='".$row['id']."' LIMIT 1";
mysqli_query($con, $sql);   
}   
$sql="UPDATE charaktere
SET platz='".$platz."'
WHERE id='".$row['id']."' LIMIT 1";
mysqli_query($con, $sql);  

}
}
$result->close(); $db->close(); 

$sql='UPDATE charaktere
SET session=NULL,npcfights="0",kampfid="0",kido="0",kwas="0",wksucht="0",wks="0",kziel="",kzwo="",adminin="0",kaktion=""';
mysqli_query($con, $sql);

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
wetter,
art,
id,
name
FROM
orte';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
/*
Arten von Wetter
-Sonne
-Regen
-Gewitter
-Sturm
-Erdrutsch
-Hitze
Arten von Umgebung
Wald
Wüste
Meer
Berge
*/      
         
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false

$wetter = $row['wetter'];
$art = $row['art']; 
if($wetter == "Sonne"){
if($art == "Wald"){
$r1 = "Hitze";
$r2 = "Regen";  
}
if($art == "Wüste"){
$r1 = "Hitze";    
$r2 = "Sturm";
}
if($art == "Meer"){
$r1 = "Regen"; 
$r2 = "Gewitter";
}
if($art == "Berge"){
$r1 = "Regen";  
$r2 = "Erdrutsch";
}
}

if($wetter == "Regen"){
if($art == "Wald"){
$r1 = "Gewitter";
$r2 = "Sturm";  
}
if($art == "Meer"){
$r1 = "Gewitter"; 
$r2 = "Sturm";
}
if($art == "Berge"){
$r1 = "Erdrutsch";  
$r2 = "Gewitter";
}
}

if($wetter == "Gewitter"){
if($art == "Wald"){
$r1 = "Sturm";
$r2 = "Regen";  
}
if($art == "Meer"){
$r1 = "Sturm"; 
$r2 = "Regen";
}
if($art == "Berge"){
$r1 = "Sturm";  
$r2 = "Regen";
}
}

if($wetter == "Sturm"){ 
if($art == "Wüste"){
$r1 = "Hitze";    
$r2 = "Sturm";
}
if($art == "Wald"){
$r1 = "Regen";
$r2 = "Gewitter";  
}
if($art == "Meer"){
$r1 = "Gewitter"; 
$r2 = "Regen";
}
if($art == "Berge"){
$r1 = "Gewitter";  
$r2 = "Erdrutsch";
}
}

if($wetter == "Erdrutsch"){ 
if($art == "Berge"){
$r1 = "Sturm";  
$r2 = "Regen";
}
} 

if($wetter == "Hitze"){ 
if($art == "Wüste"){
$r1 = "Sturm";    
$r2 = "Hitze";
}
if($art == "Wald"){
$r1 = "Regen";
$r2 = "Gewitter";  
}
}
$rand = rand(1,10);
if($rand <= 3){
$g = $r1;
}
else{
$rand = rand(1,10);
if($rand <= 4){
$g = $r2;
}
else{
$g = "Sonne";
}
}


$sql="UPDATE orte
SET wetter='".$g."'
WHERE id='".$row['id']."' LIMIT 1";
mysqli_query($con, $sql);
echo $row['name'].' '.$g.'<br>';    

}
$result->close(); $db->close();   
                          
$sql="UPDATE game
SET onoff=''";
mysqli_query($con, $sql);
mysqli_close($con);   
}
if($page == 1){
echo 'Logout';
echo '<br>';
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
session,
id,
did
FROM
charaktere
WHERE session != "NULL"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$did = $row['did'];
$test = strtotime($did);
$test3 = time()-$test;
if($test3 >= 1800){
$sql='UPDATE charaktere
SET session=NULL,adminin="0",wksucht="0"
WHERE id="'.$row['id'].'" LIMIT 1';
echo $sql;
echo '<br>';
mysqli_query($con, $sql);
}
}
$result->close(); $db->close(); 
mysqli_close($con);
}
echo 'Ende';