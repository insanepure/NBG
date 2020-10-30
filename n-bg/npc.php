<?php
include 'inc/incoben.php';
if(logged_in()){
$urank = getwert(session_id(),"charaktere","rank","session");
$uid = getwert(session_id(),"charaktere","id","session");
$uclan = getwert(session_id(),"charaktere","clan","session");
$edo = 0;
if($urank != 'student'){
$event = checkevent();
$uorg = getwert(session_id(),"charaktere","org","session");
$unpcwin = getwert(session_id(),"charaktere","npcwin","session");
$npcfights = getwert(session_id(),"charaktere","npcfights","session");
if($_GET['aktion'] == 'tkampf'&&$_GET['page'] == 'team'){
$otkampf = getwert($uorg,"org","teamkampf","id");
$oname = getwert($uorg,"org","name","id");
if($otkampf != 0){
$array = explode("@", trim($otkampf));
$users = explode(";", trim($array[1]));
$tnpc = $array[0];
$count = 0;
$drin = 0;
while($users[$count] != ''){
if($users[$count] == $uid){
$drin = 1;
}
$count++;
}
if($count >= 3&&$drin == 1){
$geht = 1;
$count = 0;
while($users[$count] != ''){
$wert = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
hp,
kampfid,
mhp,
mchakra,
mkr,
mintl,
mchrk,
mtmp,
mgnk,
mwid
FROM
charaktere
WHERE id = "'.$users[$count].'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc() ) {  
$hp = $row['hp'];
$kid = $row['kampfid'];
if(($row['mhp']/10) > $wert)
{
 $wert = $row['mhp']/10;
}
if(($row['mchakra']/10) > $wert)
{
 $wert = $row['mchakra']/10;
}
if($row['mkr'] > $wert)
{
 $wert = $row['mkr'];
}
if($row['mintl'] > $wert)
{
 $wert = $row['mintl'];
}
if($row['mchrk'] > $wert)
{
 $wert = $row['mchrk'];
}
if($row['mtmp'] > $wert)
{
 $wert = $row['mtmp'];
}
if($row['mgnk'] > $wert)
{
 $wert = $row['mgnk'];
}
if($row['mwid'] > $wert)
{
 $wert = $row['mwid'];
}
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if ($uclan == 'kugutsu' || $edo == 1){
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
mhp,
mchakra,
kr,
intl,
chrk,
tmp,
gnk,
wid,
besitzer
FROM
summon
WHERE besitzer = "'.$users[$count].'"AND reihenfolge <=3 LIMIT 3';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc() ) {  
if(($row['mhp']/10) > $wert)
{
 $wert = $row['mhp']/10;
}
if(($row['mchakra']/10) > $wert)
{
 $wert = $row['mchakra']/10;
}
if($row['kr'] > $wert)
{
 $wert = $row['kr'];
}
if($row['intl'] > $wert)
{
 $wert = $row['intl'];
}
if($row['chrk'] > $wert)
{
 $wert = $row['chrk'];
}
if($row['tmp'] > $wert)
{
 $wert = $row['tmp'];
}
if($row['gnk'] > $wert)
{
 $wert = $row['gnk'];
}
if($row['wid'] > $wert)
{
 $wert = $row['wid'];
}
}
$result->close(); $db->close();
}
if($hp == 0||$kid != 0){
$geht = 0;
}
$count++;
}
if($geht == 1){
$npcstats = getwert($tnpc,"npc","npcstats","id");
$npcplus = getwert($tnpc,"npc","npcplus","id");
$npcstärke = round($wert*($npcstats/100))+$npcplus;
$rand = rand(1,6);
if($rand == 1){
$kwetter = 'Sonne';
}
if($rand == 2){
$kwetter = 'Regen';
}
if($rand == 3){
$kwetter = 'Gewitter';
}
if($rand == 4){
$kwetter = 'Hitze';
}
if($rand == 5){
$kwetter = 'Erdrutsch';
}
if($rand == 6){
$kwetter = 'Sturm';
}
$mode = $count.'vs1';
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
mission,
wetter)
VALUES
('$oname',
'$mode',
'1',
'1;2',
'NPC',
'0',
'1',
'',
'',
'',
'$kwetter')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$kid = mysqli_insert_id($con);
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$count = 0;
while($users[$count] != ''){
mysqli_close($con);
ausruest($users[$count]);

$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uname = getwert($users[$count],"charaktere","name","id");
$ubild = getwert($users[$count],"charaktere","kbild","id");
$hp = getwert($users[$count],"charaktere","hp","id");
$chakra = getwert($users[$count],"charaktere","chakra","id");
$sql="UPDATE charaktere SET
kampfid ='$kid',
lkaktion ='$zeit',
kname ='$uname',
powerup='',
dstats='',
debuff='',
kkbild ='$ubild',
team='1',
npcwin='0',
shp ='$hp',
schakra ='$chakra'
 WHERE id = '".$users[$count]."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$count++;
}
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
kbild,
jutsus,
vgemacht
FROM
npc
WHERE id = "'.$tnpc.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$nteam = 2;
$nname = $row['name'];
$nkr = $npcstärke;
$nhp = $npcstärke*10;
$nchakra = $npcstärke*10;
$nwid = round($npcstärke/1.5);
$ntmp = round($npcstärke/1.5);
$ngnk = $npcstärke;
$nintl = $npcstärke;
$nchrk = $npcstärke;
$nkbild = $row['kbild'];
$njutsus = $row['jutsus'];
$vertrag = $row['vgemacht'];
$npcid = $row['id'];

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
('$nname',
'$nname',
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
$result->close();
$db->close();
$sql="UPDATE org SET teamkampf='' WHERE id='".$uorg."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = 'Der Kampf beginnt.';

}
else{
$error = 'Ein User ist in einem Kampf oder hat nicht genügend HP.';
}

}

}
}
if($_GET['aktion'] == 'reset'&&$_GET['page'] == 'team'){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET npcwin='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = 'Du hast den Teamkampf verlassen.';
}
if($_GET['aktion'] == 'join'&&$_GET['page'] == 'team'){
$otkampf = getwert($uorg,"org","teamkampf","id");
if($otkampf != 0){
$array = explode("@", trim($otkampf));
$users = explode(";", trim($array[1]));
$tnpc = $array[0];
$tnpcname = getwert($tnpc,"npc","npcname","id");
$npclevel = getwert($tnpc,"npc","npclevel","id");
$ulevel = getwert(session_id(),"charaktere","level","session");
if($ulevel >= $npclevel){
$count = 0;
$drin = 0;
while($users[$count] != ''){
if($users[$count] == $uid){
$drin = 1;
}
$count++;
}
if($count != 5&&$drin == 0){
$unextnpc = getwert($unpcwin,"npc","npcnext","id");
if($unextnpc == $tnpc||$unpcwin == 0&&$tnpcname != ''){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$neuteamkampf = $tnpc.'@'.$array[1].';'.$uid;
$sql="UPDATE org SET teamkampf='".$neuteamkampf."' WHERE id='".$uorg."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = 'Team beigetreten.';
}
}
}
else{
$error = 'Dein Level ist zu niedrig.';
}

}
}
if($_GET['aktion'] == 'leave'&&$_GET['page'] == 'team'){
teamkampfleave($uorg,$uid);
$error = 'Du hast den Teamkampf verlassen.';
}
if($_GET['aktion'] == 'abholen'&&$unpcwin != 0){
if($npcfights < 10){
$itemgewinn = getwert($unpcwin,"npc","itemgewinn","id");
$geht = 1;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($itemgewinn != 0){
$itemchance = getwert($unpcwin,"npc","itemchance","id");
$zufall = rand(1,100);
if($itemchance >= $zufall){
$titema = 1;
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
WHERE id = "'.$itemgewinn.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['id'] == $itemgewinn){
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
$npcfights = $npcfights+1;
$sql="UPDATE charaktere SET npcfights='".$npcfights."' WHERE id = '".$uid."' LIMIT 1";
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
$titema = 0;
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
'$titema')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$npcfights = $npcfights+1;
$sql="UPDATE charaktere SET npcfights='".$npcfights."' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}
}
}
else{
$error = 'Du hast keinen Gewinn bekommen.';
}
}
if($geht == 1){
$sql="UPDATE charaktere SET npcwin='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$npckampf = getwert($unpcwin,"npc","npckampf","id");
if($npckampf == 2){
$npclevel = getwert($unpcwin,"npc","npclevel","id");
$uorgp = getwert($uorg,"org","punkte","id");
$uorgp = $uorgp+($npclevel/10);
$sql="UPDATE org SET punkte='".$uorgp."' WHERE id = '".$uorg."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($error == ''){
$error = 'Du hast einen Gewinn erhalten!';
}
}
mysqli_close($con);
}
else{
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET npcwin='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = 'Du kannst heute keinen Gewinn mehr abholen.';
}

}
$npc = $_GET['npc'];
if(is_numeric($npc)){
$npckampf = getwert($npc,"npc","npckampf","id");
$npcevent = getwert($npc,"npc","event","id");
if($npcevent == $event||$npcevent == 0){
if($npckampf != 0){
if($_GET['page'] == 'team'){
$npcname = getwert($npc,"npc","npcname","id");
}
elseif($_GET['page'] == 'solo'&&$npckampf == 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
hp,
kampfid,
mhp,
mchakra,
mkr,
mintl,
mchrk,
mtmp,
mgnk,
mwid
FROM
charaktere
WHERE  session = "'.session_id().'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc() ) {  
$uhp = $row['hp'];
$ukid = $row['kampfid'];
$ustärke = ($row['mhp']/10)+($row['mchakra']/10)+$row['mkr']+$row['mintl']+$row['mchrk']+$row['mtmp']+$row['mgnk']+$row['mwid'];
$ustärke = round($ustärke/8);
$wert = $row['mhp']/10;
if(($row['mchakra']/10) > $wert)
{
 $wert = $row['mchakra']/10;
}
if($row['mkr'] > $wert)
{
 $wert = $row['mkr'];
}
if($row['mintl'] > $wert)
{
 $wert = $row['mintl'];
}
if($row['mchrk'] > $wert)
{
 $wert = $row['mchrk'];
}
if($row['mtmp'] > $wert)
{
 $wert = $row['mtmp'];
}
if($row['mgnk'] > $wert)
{
 $wert = $row['mgnk'];
}
if($row['mwid'] > $wert)
{
 $wert = $row['mwid'];
}
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if ($uclan == 'kugutsu' || $edo == 1){
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
mhp,
mchakra,
kr,
intl,
chrk,
tmp,
gnk,
wid,
besitzer
FROM
summon
WHERE besitzer = "'.$uid.'" AND reihenfolge <=3 LIMIT 3';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc() ) {  
if(($row['mhp']/10) > $wert)
{
 $wert = $row['mhp']/10;
}
if(($row['mchakra']/10) > $wert)
{
 $wert = $row['mchakra']/10;
}
if($row['kr'] > $wert)
{
 $wert = $row['kr'];
}
if($row['intl'] > $wert)
{
 $wert = $row['intl'];
}
if($row['chrk'] > $wert)
{
 $wert = $row['chrk'];
}
if($row['tmp'] > $wert)
{
 $wert = $row['tmp'];
}
if($row['gnk'] > $wert)
{
 $wert = $row['gnk'];
}
if($row['wid'] > $wert)
{
 $wert = $row['wid'];
}
}
$result->close(); $db->close();
}
}
$npclevel = getwert($npc,"npc","npclevel","id");
$ulevel = getwert(session_id(),"charaktere","level","session");
if($_GET['aktion'] == 'open'&&$ulevel >= $npclevel&&$_GET['page'] == 'team'&&$npckampf == 2){
$unpcwin = getwert(session_id(),"charaktere","npcwin","session");
$npcnext = getwert($unpcwin,"npc","npcnext","id");
if($npcnext == $npc&&$npcnext != 0||$unpcwin == 0){
$otkampf = getwert($uorg,"org","teamkampf","id");
$error = $otkampf;
if($otkampf == ''){
//NPC@User;User;User
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$teamkampf = $npc.'@'.$uid;
$sql="UPDATE org SET teamkampf ='".$teamkampf."' WHERE id = '".$uorg."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = 'Teamkampf wurde eröffnet.';
}
else{
$error = 'Es ist ein Kampf bereits offen.';
}
}
}
if($_GET['aktion'] == 'kampf'&&$ulevel >= $npclevel&&$_GET['page'] == 'solo'&&$npckampf == 1 && $_SERVER['REQUEST_METHOD'] === 'POST'){
$npcstats = getwert($npc,"npc","npcstats","id");
$npcplus = getwert($npc,"npc","npcplus","id");
$npcstärke = round($wert*($npcstats/100))+$npcplus;
if($uhp != 0){
if($ukid == 0){
ausruest($uid);
$rand = rand(1,6);
if($rand == 1){
$kwetter = 'Sonne';
}
if($rand == 2){
$kwetter = 'Regen';
}
if($rand == 3){
$kwetter = 'Gewitter';
}
if($rand == 4){
$kwetter = 'Hitze';
}
if($rand == 5){
$kwetter = 'Erdrutsch';
}
if($rand == 6){
$kwetter = 'Sturm';
}
  
$uname = getwert(session_id(),"charaktere","name","session");
$userid = getwert(session_id(),"charaktere","id","session"); 
  
// Build POST request:
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_secret = '6LdMP7kUAAAAAPPjqniyH1IXcw2U8mCI2pF_s7Pm';
$recaptcha_response = $_POST['g-recaptcha-response'];
// Make and decode POST request:
$recaptcha = file_get_contents($recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$recaptcha_response);
$recaptcha = json_decode($recaptcha);
if($recaptcha && $recaptcha->success)
{
  $account->UpdateRecaptcha($recaptcha);
  if(false && $recaptcha->score < 0.7)
  {
    $betreff = 'Recaptcha '.$uname;
    $pmtext = $uname.' ('.$userid.') hatte eine Score von '.$recaptcha->score.' beim NPC-Kampf';
    $zeit2 = time();
    $zeit = date("YmdHis",$zeit2);
    $anid = 1;
    $senderid = 0;
    $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
    mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
    $sql="INSERT INTO pms(
    `id`,`an`,`von`,`betreff`,`text`,`date`)
    VALUES
    ('".uniqid()."',
    '$anid',
    '$senderid',
    '$betreff',
    '$pmtext',
    '$zeit')";
    if (!mysqli_query($con, $sql))
    {
    die('Error: ' . mysqli_error($con));
    }  
    mysqli_close($con); 
  }
} 
  
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
mission,
wetter)
VALUES
('NPCKampf',
'1vs1',
'1',
'1;2',
'NPC',
'0',
'1',
'',
'',
'',
'$kwetter')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$kid = mysqli_insert_id($con);
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$ubild = getwert(session_id(),"charaktere","kbild","session");
$hp = getwert(session_id(),"charaktere","hp","session");
$chakra = getwert(session_id(),"charaktere","chakra","session");
$sql="UPDATE charaktere SET
kampfid ='$kid',
lkaktion ='$zeit',
kname ='$uname',
powerup='',
dstats='',
debuff='',
kkbild ='$ubild',
team='1',
npcwin='0',
shp ='$hp',
schakra ='$chakra'
 WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
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
kbild,
jutsus,
vgemacht
FROM
npc
WHERE id = "'.$npc.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$nteam = 2;
$nname = $row['name'];
$nkr = $npcstärke;
$nhp = $npcstärke*10;
$nchakra = $npcstärke*10;
$nwid = $npcstärke;
$ntmp = $npcstärke;
$ngnk = $npcstärke;
$nintl = $npcstärke;
$nchrk = $npcstärke;
$nkbild = $row['kbild'];
$njutsus = $row['jutsus'];
$vertrag = $row['vgemacht'];
$npcid = $row['id'];

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
('$nname',
'$nname',
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
$result->close();
$db->close();
mysqli_close($con);
$error = 'Der Kampf beginnt.<br/><a href="fight.php">Klick mich<br/>';
}
else{
$error = 'Du bist in einem Kampf.<br/><a href="fight.php">Klick mich<br/>';
}
}
else{
$error = 'Du hast nicht genügend HP.';
}
}
}
}
}

}
}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
if($urank != 'student'){
//Hier kommt der Code hin
echo '<h3>NPC-Kämpfe</h3><br>';
if($npcwin == 0){
$page = $_GET['page'];
if($page == 'solo'){
if($npc == ''){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
bild,
kbild,
npckampf,
itemgewinn,
hp,
event,
npclevel
FROM
npc
WHERE
npckampf = "1" AND event="'.$event.'"
OR
npckampf = "1" AND event="0"
ORDER BY npclevel';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table width="100%">';
echo '<tr>';
$count = 0;
while ($row = $result->fetch_assoc() ) {  
if($count == 5){
echo '</tr><tr>';
$count = 0;
}
$count++;
echo '<td>';
echo '<a href="npc.php?page=solo&npc='.$row['id'].'"><img src="'.$row['kbild'].'"></img></a>';
echo '</td>';
}
$result->close(); $db->close();
echo '</tr></table>';
echo '<br><a href="npc.php">Zurück</a>';
}
elseif(is_numeric($npc)){
if($npckampf == 1){
echo 'Maximale Gewinnanzahl: '.$npcfights.'/10<br><br>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
bild,
name,
itemgewinn,
itemchance,
npcstats,
npcplus,
npclevel,
event
FROM
npc
WHERE
id = "'.$npc.'" AND event="'.$event.'"
OR
id = "'.$npc.'" AND event="0"
LIMIT 1';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc() ) {  
echo '<img src="'.$row['bild'].'"></img><br>';
echo '<b>Name: </b><i class="shadow">'.$row['name'].'</i><br>';
$iname = getwert($row['itemgewinn'],"item","name","id");
echo '<b>Gewinn: </b><i class="shadow">'.$iname.'</i><br>';
echo '<b>Itemchance: </b><i class="shadow">'.$row['itemchance'].'%</i><br>';
echo '<b>Erforderliches Level: </b><i class="shadow">'.$row['npclevel'].'</i><br>';
$npcstärke = round($wert*($row['npcstats']/100))+$row['npcplus'];
$svergleich = round(($ustärke/$npcstärke)*100);
echo '<b>stärke: </b><i class="shadow">';
if($svergleich >= 150){
echo '<font color=#22c842>Armselig</font>';
}
elseif($svergleich >= 125){
echo '<font color=#009284>Schwächlich</font>';
}
elseif($svergleich >= 100){
echo '<font color=#00c8db>Schwach</font>';
}
elseif($svergleich >= 75){
echo '<font color=#0075ff>Gleich stark</font>';
}
elseif($svergleich >= 50){
echo '<font color=#7900ff>Stark</font>';
}
elseif($svergleich >= 25){
echo '<font color=#ed00ff>Mächtig</font>';
}
else{
echo '<font color=#ff0000>Göttlich</font>';
}
echo '</i><br><br>';
if($ulevel >= $npclevel){
?>
  <div id="captcha_text">
    Lade ...
  </div>
<?php
echo '<form method="post" id="captcha" style="display:none" action="npc.php?page=solo&npc='.$npc.'&aktion=kampf">';
echo '<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
  <input type="hidden" name="action" value="validate_captcha">';
echo '<input class="button" name="login" id="login" value="Kampf starten" type="submit">';
echo '</form>';
}

}
$result->close(); $db->close();
}
echo '<br><a href="npc.php?page=solo">Zurück</a>';
}
}
elseif($page == 'team'){
if($uorg != 0){
$otkampf = getwert($uorg,"org","teamkampf","id");
if($otkampf != 0){
$array = explode("@", trim($otkampf));
$users = explode(";", trim($array[1]));
$tnpc = $array[0];
$tnpcbild = getwert($tnpc,"npc","bild","id");
$tnpcname = getwert($tnpc,"npc","npcname","id");
echo '<br><center><table class="table2" cellspacing="0" >';
echo '<tr>';
echo '<td class="tdbg" width="250px">NPC</td>';
echo '<td class="tdbg" width="250px">Teilnehmer</td>';
echo '</tr>';
echo '<tr height="250px">';
echo '<td class="tdborder"><img src="'.$tnpcbild.'"></img><br><b class="shadow">'.$tnpcname.'</b></td>';
echo '<td class="tdborder">';
$count = 0;
$drin = 0;
while($users[$count] != ''){
if($users[$count] == $uid){
$drin = 1;
}
$tname = getwert($users[$count],"charaktere","name","id");
echo '<a href="user.php?id='.$users[$count].'">'.$tname.'</a> ';
$count++;
}
echo '</td>';
echo '</tr>';
echo '<tr height="50px">';
echo '<td class="tdbg tdborder" colspan="2">';
if($drin == 1){
echo '<table width="100%"><tr>';
echo '<td>';
echo '<form method="post" action="npc.php?page=team&aktion=leave">';
echo '<input class="button" name="login" id="login" value="Kampf verlassen" type="submit">';
echo '</form>';
echo '</td>';
if($count >= 3){
echo '<td>';
echo '<form method="post" action="npc.php?page=team&aktion=tkampf">';
echo '<input class="button" name="login" id="login" value="Kampf starten" type="submit">';
echo '</form>';
echo '</td>';
}
echo '</tr></table>';
}
else{
if($count != 5){
if($unpcwin == 0&&$tnpcname != ''){
echo '<form method="post" action="npc.php?page=team&aktion=join">';
echo '<input class="button" name="login" id="login" value="Kampf beitreten" type="submit">';
echo '</form>';
}
}
}
echo '</td>';
echo '</tr>';
echo '</table></center>';
}
else{
if($npc == ''){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
bild,
kbild,
npckampf,
itemgewinn,
npcname,
hp,
npclevel,
event
FROM
npc
WHERE
npckampf = "2" AND npcname != "" AND event="'.$event.'"
OR
npckampf = "2" AND npcname != "" AND event="0"
ORDER BY npclevel';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table width="100%">';
echo '<tr>';
$count = 0;
while ($row = $result->fetch_assoc() ) {  
if($count == 5){
echo '</tr><tr>';
$count = 0;
}
$count++;
echo '<td>';
echo '<a href="npc.php?page=team&npc='.$row['id'].'"><img src="'.$row['kbild'].'"></img></a>';
echo '</td>';
}
$result->close(); $db->close();
echo '</tr></table>';
echo '<br><a href="npc.php">Zurück</a>';
}
elseif(is_numeric($npc)){
if($npckampf == 2&&$npcname != ''){
echo 'Maximale Gewinnanzahl: '.$npcfights.'/10<br><br>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
bild,
name,
itemgewinn,
itemchance,
npcstats,
npcplus,
npclevel,
npcname,
npcnext,
event
FROM
npc
WHERE
id = "'.$npc.'" AND event="'.$event.'"
OR
id = "'.$npc.'" AND event="0"
LIMIT 1';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc() ) {  
echo '<img src="'.$row['bild'].'"></img><br>';
echo '<b>Name: </b><i class="shadow">'.$row['npcname'].'</i><br>';
$iname = getwert($row['itemgewinn'],"item","name","id");
$nextnpc = $row['npcnext'];
while($iname == ''){
$igewinn = getwert($nextnpc,"npc","itemgewinn","id");
$iname = getwert($igewinn,"item","name","id");
if($iname == ''){
$nextnpc = getwert($nextnpc,"npc","npcnext","id");
}
}
echo '<b>Gewinn: </b><i class="shadow">'.$iname.'</i><br>';
$ichance = getwert($nextnpc,"npc","itemchance","id");
echo '<b>Itemchance: </b><i class="shadow">'.$ichance.'%</i><br>';
echo '<b>Erforderliches Level: </b><i class="shadow">'.$row['npclevel'].'</i><br>';
echo '<br><br>';
if($ulevel >= $npclevel&&$otkampf == 0){
echo '<form method="post" action="npc.php?page=team&npc='.$npc.'&aktion=open">';
echo '<input class="button" name="login" id="login" value="Kampf eröffnen" type="submit">';
echo '</form>';
}

}
$result->close(); $db->close();
}
echo '<br><a href="npc.php?page=team">Zurück</a>';
}
}
}
else{
echo 'Du musst in einem Team oder einer Organisation sein, um diese Kämpfe bestreiten zu können.<br>';
}
}
else{
echo '<div class="snpc" style="float:left;"><a href="npc.php?page=solo"></a></div>';
echo '<div class="tnpc" style="float:right;"><a href="npc.php?page=team"></a></div>';
}
}
else{
$nextnpc = getwert($npcwin,"npc","npcnext","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
if($nextnpc == 0){
$sql = 'SELECT
id,
bild,
itemgewinn,
itemchance,
npcnext
FROM
npc
WHERE id = "'.$npcwin.'" LIMIT 1';
}
else{
$sql = 'SELECT
id,
bild,
name,
itemgewinn,
itemchance,
npcnext
FROM
npc
WHERE id = "'.$nextnpc.'" LIMIT 1';
}
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc() ) {  
if($nextnpc == 0){
echo '<img src="'.$row['bild'].'"></img><br><br>';
if($row['itemgewinn'] != 0){
$iname = getwert($row['itemgewinn'],"item","name","id");
echo 'Du hast deinen Gegner besiegt.<br><br>';
echo 'Die Chance, dass du <i class="shadow">'.$iname.'</i> bekommst, beträgt '.$row['itemchance'].'%!';
echo '<br><br>';
echo '<form method="post" action="npc.php?aktion=abholen">';
echo '<input class="button" name="login" id="login" value="Gewinn abholen" type="submit">';
echo '</form>';
}
}
else{
echo '<img src="'.$row['bild'].'"></img><br>';
echo '<b class="shadow">'.$row['name'].'</b>';
echo '<br><br>';
echo '<form method="post" action="npc.php?page=team&npc='.$row['id'].'&aktion=open">';
echo '<input class="button" name="login" id="login" value="Kampf eröffnen" type="submit">';
echo '</form>';
echo '<br>';
echo '<form method="post" action="npc.php?page=team&npc='.$npc.'&aktion=reset">';
echo '<input class="button" name="login" id="login" value="Teamkampf beenden" type="submit">';
echo '</form>';
}


}
$result->close(); $db->close();
$otkampf = getwert($uorg,"org","teamkampf","id");
if($otkampf != 0){
$array = explode("@", trim($otkampf));
$users = explode(";", trim($array[1]));
$tnpc = $array[0];
$tnpcbild = getwert($tnpc,"npc","bild","id");
$tnpcname = getwert($tnpc,"npc","npcname","id");
echo '<br><center><table class="table2" cellspacing="0" >';
echo '<tr>';
echo '<td class="tdbg" width="250px">NPC</td>';
echo '<td class="tdbg" width="250px">Teilnehmer</td>';
echo '</tr>';
echo '<tr height="250px">';
echo '<td class="tdborder"><img src="'.$tnpcbild.'"></img><br><b class="shadow">'.$tnpcname.'</b></td>';
echo '<td class="tdborder">';
$count = 0;
$drin = 0;
while($users[$count] != ''){
if($users[$count] == $uid){
$drin = 1;
}
$tname = getwert($users[$count],"charaktere","name","id");
echo '<a href="user.php?id='.$users[$count].'">'.$tname.'</a> ';
$count++;
}
echo '</td>';
echo '</tr>';
echo '<tr height="50px">';
echo '<td class="tdbg tdborder" colspan="2">';
if($drin == 1){
echo '<table width="100%"><tr>';
echo '<td>';
echo '<form method="post" action="npc.php?page=team&aktion=leave">';
echo '<input class="button" name="login" id="login" value="Kampf verlassen" type="submit">';
echo '</form>';
echo '</td>';
if($count >= 3){
echo '<td>';
echo '<form method="post" action="npc.php?page=team&aktion=tkampf">';
echo '<input class="button" name="login" id="login" value="Kampf starten" type="submit">';
echo '</form>';
echo '</td>';
}
echo '</tr></table>';
}
else{
if($count != 5){
if($nextnpc == $tnpc){
echo '<form method="post" action="npc.php?page=team&aktion=join">';
echo '<input class="button" name="login" id="login" value="Kampf beitreten" type="submit">';
echo '</form>';
}
}
}
echo '</td>';
echo '</tr>';
echo '</table></center>';
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