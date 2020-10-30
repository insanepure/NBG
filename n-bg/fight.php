<?php
include 'inc/incoben.php';
include 'inc/ffunct.php';
if(logged_in()){
$ukid = getwert(session_id(),"charaktere","kampfid","session");
$kbegin = getwert($ukid,"fights","begin","id");
$kende = getwert($ukid,"fights","ende","id");
$kart = getwert($ukid,"fights","art","id");
if($kbegin == 1&&$kende == 0){
if($ukid != 0){
$ucode = getwert(session_id(),"charaktere","kampfcode","session");
$uteam = getwert(session_id(),"charaktere","team","session");
$uaktion = getwert(session_id(),"charaktere","kaktion","session");
$aktion = $_GET['aktion'];
if($aktion == 'control'&&$uaktion == 'Zufall'){
if($_GET['code'] == $ucode||$ucode == ''){
$rand1 = rand(0,10000);
$rand2 = rand(10,100);
$rand3 = rand(10,100);
$zahl = (time()+($rand1*$rand2))/$rand3;
$neucode = md5($zahl);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET kampfcode ='$neucode',kaktion='',kziel='' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}

}
if($aktion == "kick"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
//Kicke spieler wenn er nichts getan hat
$zielid = real_escape_string($_POST['ziel']);
if($zielid != $uid){
$zielwo = real_escape_string($_POST['wo']);
if($zielwo == "npcs"){
$zbesitzer = getwert($zielid,"$zielwo","besitzer","id");
$zlkaktion = getwert($zbesitzer,"charaktere","lkaktion","id");
}
else{
$zlkaktion = getwert($zielid,"$zielwo","lkaktion","id");
$zadmin = getwert($zielid,"charaktere","admin","id");
}
$zkaktion = getwert($zielid,"$zielwo","kaktion","id");
$zkid = getwert($zielid,"$zielwo","kampfid","id");
$zeit2 = time();
$zeit = date("Y-m-d H:i:s",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($zlkaktion);
$test3 = $test2-$test;
$zeit = 180; // 3 Min
if($test3 >= $zeit&&$zkaktion == ""&&$zkid == $ukid&&$zadmin != 3){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($kart == 'Eroberung'||$kart == 'Bijuu'){
$sql="UPDATE $zielwo SET kaktion ='Zufall',kziel='Zufall' WHERE id = '".$zielid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$sql="UPDATE $zielwo SET kaktion ='aufgeben' WHERE id = '".$zielid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
mysqli_close($con);
aktion($ukid);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
}
}
mysqli_close($con);
//überprüfe ob alle eine Aktion gemacht haben
}
if($uhp == 0&&$aktion == ""||$uaktion == 'Zufall'){
$geht = 1;
//Möglicher Bug hier:
//Wenn ein Spieler tot ist und viel aktualisieren klickt, dann wird die Aktion hier unten auch ausgeführt
//Vielleicht noch ein Test machen obs ein NPC Kampf ist
if($uaktion != 'Zufall'){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
hp,
kampfid,
kaktion
FROM
charaktere
WHERE kampfid="'.$ukid.'" AND hp !="0" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 0;
}
$result->close();
$db->close();
}
if($geht == 1){
if($_GET['code'] == $ucode||$ucode == ''){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET kampfcode ='$neucode' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
aktion($ukid);
}
}
}
elseif($aktion != ''){
if($_GET['code'] == $ucode||$ucode == ''){
$uhp = getwert(session_id(),"charaktere","hp","session");
$uid = getwert(session_id(),"charaktere","id","session");
$rand1 = rand(0,10000);
$rand2 = rand(10,100);
$rand3 = rand(10,100);
$zahl = (time()+($rand1*$rand2))/$rand3;
$neucode = md5($zahl);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET kampfcode ='$neucode' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$uhp = getwert(session_id(),"charaktere","hp","session");
$uchakra = getwert(session_id(),"charaktere","chakra","session");
$umchakra = getwert(session_id(),"charaktere","mchakra","session");
$ujutsus = getwert(session_id(),"charaktere","kbutton","session");
$upowerup = getwert(session_id(),"charaktere","powerup","session");

$ucode = getwert(session_id(),"charaktere","kampfcode","session");
$uteam = getwert(session_id(),"charaktere","team","session");
//Wenn angriff
if($uaktion != '' && $aktion == 'unblock'){
aktion($ukid);
}
else if($aktion == 'aufgeben'){
if($uaktion == ''&&$_POST['check'] == 'Ja'){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($kart == 'Eroberung'||$kart == 'Bijuu'){
$sql="UPDATE charaktere SET kaktion ='Zufall',kziel='Zufall' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE npcs SET kaktion ='Zufall',kziel='Zufall' WHERE besitzer = '".$uid."' LIMIT 3";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$sql="UPDATE charaktere SET kaktion ='aufgeben' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE npcs SET kaktion ='aufgeben' WHERE besitzer = '".$uid."' LIMIT 3";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
mysqli_close($con);
aktion($ukid);
}
}
$wid = $_GET['wid'];
if($aktion == "angriff"&&$uhp != 0||$aktion == "angriff"&&$wid != 0){
  
  
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
    $uname = getwert(session_id(),"charaktere","name","session");
    $betreff = 'Recaptcha '.$uname;
    $pmtext = $uname.' ('.$uid.') hatte eine Score von '.$recaptcha->score.' beim Kampf';
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
  
$hatitem = 0;
//Mache eigene Aktion
//überprüfe ob alle eine Aktion gemacht haben
$geht = 1;
if($wid != 0&&is_numeric($wid)){
$geht = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kaktion,
kampfid,
besitzer,
bwo,
hp,
chakra,
mchakra,
team,
jutsus,
powerup,
besitzer
FROM
npcs
WHERE kampfid="'.$ukid.'" AND besitzer="'.$uid.'" AND id = "'.$wid.'" AND bwo="charaktere" AND kaktion = "" AND hp != "0" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 1;
$uhp = $row['hp'];
$uchakra = $row['chakra'];
$umchakra = $row['mchakra'];
$uteam = $row['team'];
$ujutsus = $row['jutsus'];
$uaktion = $row['kaktion'];
$upowerup = $row['powerup'];
$besitzer = $row['besitzer'];
$uid = $row['id'];
$hatitem = 1;
}
$result->close();
$db->close();
}
if($geht == 1&&$uaktion == ""&&$_POST['ziel'] != ""){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$zielid = real_escape_string($_POST['ziel']);
$zielwo = real_escape_string($_POST['wo']);
$zexist = getwert($zielid,$zielwo,"kampfid","id");
if($zexist != ""){
if($zexist == $ukid){
$chadd = real_escape_string($_POST['chadd']);
if(!is_numeric($chadd) || $chadd < 0 || $chadd > 10){
$chadd = 0;
}
$attacke = real_escape_string($_POST['attacke']);
$puben = getwert($attacke,"jutsus","puben","id");
$geht = 1;
if($puben != ""){
$array = explode("@", trim($puben));
$count = 0;
$geht = 0;
while(isset($array[$count])){   
$count2 = 0;
$array2 = explode(";", trim($upowerup));
while($array2[$count2] != ""){
if($array2[$count2] == $array[$count]){
$geht = 1;
}
$count2++;
}
$count++;
}
}
if($geht == 1){
$chakrab = getwert($attacke,"jutsus","chakra","id");
$jart = getwert($attacke,"jutsus","art","id");
$kregeln = getwert($ukid,"fights","regeln","id");
$kgeht = 1;
if($kregeln != 0){
$count = 0;
while($count != strlen($kregeln)){
$regel = substr($kregeln,$count,1);
if($regel == 1){
if($jart == 2){
$kgeht = 0;
}
}
elseif($regel == 2){
if($jart == 3){
$kgeht = 0;
}
}
elseif($regel == 3){
if($jart == 5){
$kgeht = 0;
}
}
elseif($regel == 4){
if($jart == 6||$jart == 14){
$kgeht = 0;
}
}
elseif($regel == 5){
if($jart == 7){
$kgeht = 0;
}
}
elseif($regel == 6){
if($jart == 8||$jart == 9){
$kgeht = 0;
}
}
elseif($regel == 7){
if($jart == 10||$jart == 12){
$kgeht = 0;
}
}
elseif($regel == 8){
if($jart == 11){
$kgeht = 0;
}
}
else{
$chadd = 0;
}
$count++;
}
}
if($jart == 1&&$uid == $zielid&&$zielwo == 'charaktere'||$jart == 1&&$wid != 0&&$besitzer == $zielid&&$zielwo == 'charaktere'){
$kgeht = 0;
}
if($kgeht == 1){
if($chadd != 0 && $jart != 8 && $jart != 9)
{
  $chadd = $chakrab * ($chadd-1);
}
  
$ijut = 0;
if($jart == 8||$jart == 9){
$ijut = 1;
$jdmg = getwert($attacke,"jutsus","dmg","id");
$ihat = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
anzahl,
kbenutzt
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$jdmg.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$ihat = $ihat+($row['anzahl']-$row['kbenutzt']);
}
$result->close();
$db->close();
if($chadd > 1){
$ianzahl = $chadd;
}
else{
$ianzahl = 1;
$chadd = 0;
}

}
else{
$prozent = substr($chakrab, -1);
if($prozent == "%"){
$chakrab = substr($chakrab, 0,-1);
$chakrab = (($umchakra*$chakrab)/100);
}
$chakrab = $chadd+$chakrab;
//Prüfe alles
}
$hgeht = 1;
if($upowerup != ""){
$neujutsus = "";
$array = explode(";", trim($upowerup));
$count = 0;
while(isset($array[$count])){   
$jutsugeb = getwert($array[$count],"jutsus","jutsugeb","id");
if($jutsugeb != ""){
$hgeht = 0;
if($neujutsus == ""){
$neujutsus = $jutsugeb;
}
else{
$neujutsus = $neujutsus.';'.$jutsugeb;
}
}
if($neujutsus == ""){
$neujutsus = $array[$count];
}
else{
$neujutsus = $neujutsus.';'.$array[$count];
}
$count++;
}
}
if($hgeht == 1){
$array = explode(";", trim($ujutsus));
}
else{
$array = explode(";", trim($neujutsus));
}
$count = 0;
$geht = 0;
while(isset($array[$count])){   
if($array[$count] == $attacke){
$geht = 1;
}
$count++;
}
if($jart == 14){
//Check Hunde
if($wid == 0){
$geht = 0;
$pus = getwert($uid,'charaktere',"powerup","id");
$array = explode(";", trim($pus));
$count = 0;
$an = 0;
while(isset($array[$count])){   
if($array[$count] == $attacke){
$an = 1;
}
$count++;
}
if($an == 0){

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
besitzer,
deaktiv,
hp
FROM
summon
WHERE besitzer="'.$uid.'" AND hp != "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$hat = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$hat++;
}
$result->close();
$db->close();
$uclan = getwert(session_id(),"charaktere","clan","session");
if($uclan == 'inuzuka'&&$hat >= 1){
$geht = 1;
}
if($uclan == 'jiongu'&&$hat >= 2){
$geht = 1;
}
}
else{
$geht = 1;
}
}
else{
$geht = 1;
}
}
if($jart == 9){
$uitempus = getwert(session_id(),"charaktere","itempus","session");
$array = explode(";", trim($uitempus));
$count = 0;
$geht = 1;
while(isset($array[$count])){   
if($array[$count] == $attacke){
$geht = 0;
}
$count++;
}

}
if($geht == 1){
if($attacke != 0){
$zielhp = getwert($zielid,$zielwo,"hp","id");
$geht = 1;
if($zielwo == "npcs"){
$zpuppe = getwert($zielid,$zielwo,"puppe","id");
$jtyp = getwert($attacke,"jutsus","typ","id");
if($zpuppe == 1&&$jtyp == "genjutsu"){
$geht = 0;
}
}
if($geht == 1){
if($zielhp != 0){
if(is_numeric($chadd)&&$uchakra >= $chakrab&&$ijut == 0||$ijut == 1&&$ihat >= $ianzahl&&$ianzahl <= 50){
$jitem = getwert($attacke,"jutsus","item","id");
if($jitem == ""){
$hatitem = 1;
}
else{
$array = explode(";", trim($jitem));
$count = 0;
while(isset($array[$count])){   
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt
FROM
items
WHERE besitzer="'.$uid.'" AND name = "'.$array[$count].'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['angelegt'] == 'LHand'||$row['angelegt'] == 'RHand'||$row['angelegt'] == 'LHand&RHand'){
$hatitem = 1;
}
}
$result->close();$db->close();
$count++;
}
}
if($hatitem == 1){
//überprüfe ob es ein Kombipartner gibt
$kombijutsu = getwert($attacke,'jutsus',"kombipartner","id");
if($kombijutsu)
{
$nuchakra = $uchakra-$chakrab;
if($nuchakra < 0){
$nuchakra = 0;
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kombipartner,
kaktion,
team,
kziel,
kzwo,
kchadd,
chakra
FROM
charaktere
WHERE team="'.$uteam.'" AND kombipartner="0" AND kaktion="'.$kombijutsu.'" AND kziel="'.$zielid.'" AND kzwo="'.$zielwo.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kombipartner = $row['id'];
$kombiwo = 'charaktere';
$chadd = $chadd+$row['kchadd'];
$kchakra = $row['chakra']-$row['kchadd'];
}
$result->close();$db->close();
if(!$kombipartner){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kombipartner,
kaktion,
team,
kziel,
kzwo,
kchadd,
chakra
FROM
npcs
WHERE team="'.$uteam.'" AND kombipartner="0" AND kaktion="'.$kombijutsu.'" AND kziel="'.$zielid.'" AND kzwo="'.$zielwo.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kombipartner = $row['id'];
$kombiwo = 'npcs';
$chadd = $chadd+$row['kchadd'];
$kchakra = $row['chakra']-$row['kchadd'];
}
$result->close();$db->close();
}
if($kombipartner){
$attacke = getwert($attacke,'jutsus',"kombineu","id");
$chakrak = getwert($kombijutsu,'jutsus',"chakra","id");
$nkchakra = $kchakra-$chakrak;
if($nkchakra < 0){
$nkchakra = 0;
}
$sql="UPDATE ".$kombiwo." SET kaktion ='Kombi',chakra='$nkchakra' WHERE id = '".$kombipartner."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($wid == 0){
$sql="UPDATE charaktere SET kombipartner ='$kombipartner',kombipartnerw='$kombiwo',chakra='$nuchakra' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$sql="UPDATE npcs SET kombipartner ='$kombipartner',kombipartnerw='$kombiwo',chakra='$nuchakra' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
if($chadd >= 0){
if($zielid != 0){
//Speichere eigene Aktion
if($wid == 0){
$sql="UPDATE charaktere SET kaktion ='$attacke',kzwo ='$zielwo',kchadd ='$chadd',ktargetwo ='$zielwo',lchakra ='$chadd',ktarget ='$zielid',kziel ='$zielid' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$sql="UPDATE npcs SET ktargetwo ='$zielwo',kzwo ='$zielwo',kchadd ='$chadd',kaktion ='$attacke',lchakra ='$chadd',ktarget ='$zielid',kziel ='$zielid' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

}
//überprüfe ob alle eine Aktion getan haben
aktion($ukid);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
}
} //chkadd größer gleich 0
}
else{
$error = 'Du hast nicht das benötigte Item angelegt.';
}
} //chkadd kleiner gleich chakra und ist zahl
else{
$error = "Du hast nicht genügend Chakra.";
}
} //ziel ist nicht tot
else{
$error = "Das Ziel ist tot.";
}
}//Puppe/Nicht Puppe
} //jusu existiert
} //Hat das jutsu
} //Ob Regeln eingehalten
} //Hat das benötigte Powerup
} //Wenn im selben Kampf sind
} //Gegner existiert nicht
mysqli_close($con);
} //hat keine Aktion geWählt
} //angreifen
}
}
}
}
}
?>
<?php
include 'inc/header.php';
?>
<?php
$ukid = getwert(session_id(),"charaktere","kampfid","session");
if(Logged_in()&&$ukid != 0&&$kbegin == 1){
?>
<?php
if(!$account->IsLogged() || $account->Get('id') != 1)
//if(false)
{
    $random = rand(1,1);
    if($random == 0)
    {
    ?>
      <!-- ADC Rota 202959 PRE BK 728x90 -->
      <script type="text/javascript" language="Javascript" src="https://bk.adcocktail.com/pre_bk_rota.php?format=728x90&uid=89196&wsid=202959&ft=off"></script>
      <!-- ADC Rota 202959 PRE BK 728x90 -->
    <?php
    }
    else
    {
    ?>
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <ins class="adsbygoogle"
           style="display:inline-block;width:728px;height:90px"
           data-ad-client="ca-pub-7145796878009968"
           data-ad-slot="5089102624"></ins>
      <script>
           (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    <?php
    }
}
?>

  <script>
  grecaptcha.ready(function() {
      grecaptcha.execute('6LdMP7kUAAAAABZPx7qz5I5snHzWntPFMT__E-lu', {action: 'fight'});
  });
  </script>
</center>
<?php
  
$uaktion = getwert(session_id(),"charaktere","kaktion","session");
$ucode = getwert(session_id(),"charaktere","kampfcode","session");
$ujutsus = getwert(session_id(),"charaktere","kbutton","session");
$upowerup = getwert(session_id(),"charaktere","powerup","session");
$lchakra = getwert(session_id(),"charaktere","lchakra","session");
$cchakra = getwert(session_id(),"charaktere","chakra","session");
$uid = getwert(session_id(),"charaktere","id","session");
if($uaktion != ""){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kaktion,
kampfid,
besitzer,
bwo,
hp,
jutsus,
name,
team,
powerup,
ktarget,
ktargetwo,
lchakra,
chakra,
gradgerufen
FROM
npcs
WHERE kampfid="'.$ukid.'" AND besitzer="'.$uid.'" AND bwo="charaktere" AND kaktion = "" AND hp != "0" AND gradgerufen="0"
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$npcakt = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($npcakt == 0){
$npcakt = $row['id'];
$ujutsus = $row['jutsus'];
$upowerup = $row['powerup'];
$ziel = $row['ktarget'];
$lchakra = $row['lchakra'];
$cchakra = $row['chakra'];
$zwo = $row['ktargetwo'];
}
}
$result->close();
$db->close();
}
if($cchakra < $lchakra){
$lchakra = 0;
}
//Design Anfang

if($_GET['ziel'] == ""){
if($ziel == ''){
$zwo = getwert(session_id(),"charaktere","ktargetwo","session");
$ziel = getwert(session_id(),"charaktere","ktarget","session");
}
if($ziel != 0){
$thp = getwert($ziel,$zwo,"hp","id");
if($thp == 0)
{
$ziel = 0;
$zwo = '';
}
}
}
else{
$ziel = $_GET['ziel'];
$zwo = $_GET['zwo'];
}
if($ziel == 0){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
hp,
kampfid,
team
FROM
charaktere
WHERE kampfid = "'.$ukid.'" AND team != "'.$uteam.'" AND hp != "0"
ORDER BY team,name DESC LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == 0){
$ziel = $row['id'];
$zwo = 'charaktere';
}
}
$result->close();
$db->close();
}
if($ziel == 0){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
hp,
kampfid,
team
FROM
npcs
WHERE kampfid = "'.$ukid.'" AND team != "'.$uteam.'" AND hp != "0"
ORDER BY team,name DESC LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == 0){
$ziel = $row['id'];
$zwo = 'npcs';
}
}
$result->close();
$db->close();
}
echo '<table class="ktabelle"><tr><td align="center">';
if($uaktion == ""){
echo '<form method="post" action="fight.php?code='.$ucode.'&aktion=angriff">';
echo '<input type="hidden" value="'.$ziel.'" name="ziel">';
echo '<input type="hidden" value="'.$zwo.'" name="wo">';
}
else{
if($npcakt != 0){
echo '<form method="post" action="fight.php?code='.$ucode.'&aktion=angriff&wid='.$npcakt.'">';
echo '<input type="hidden" value="'.$ziel.'" name="ziel">';
echo '<input type="hidden" value="'.$zwo.'" name="wo">';
}
}
echo '<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
  <input type="hidden" name="action" value="validate_captcha">';
//Jutsuleiste
echo '<table class="katk" cellpadding="0" cellspacing="0">';
echo '<tr>';
echo '<td class="katkl">';
echo '<div class="katkl katklb"></div>';
echo '</td>';
echo '<td class="katkm">';
echo '<div class="katkm katkmb">';
echo '<div class="katkc shadow">';
echo '<br>';
if($uaktion == ""||$npcakt != 0){
echo '<center>Multiplikator<div class="slidercontainer">';
$min = 1;
$max = 10;
$value = 1;
$width = 200;
$step = 1;
if(isset($_POST['chadd']))
  $value = $_POST['chadd'];
  
echo '<input type="range" min="'.$min.'" max="'.$max.'" value="'.$value.'" class="slider" name="chadd" style="height:25px;">';
echo '<table style="margin-top:-5px;"><tr>';
for($i =$min; $i <= $max; $i += $step)
{
  echo '<td height="5px" width="'.$width/$max.'" align="center" style="font-size:1.0em">'.$i.'</td>';
}
echo '</tr></table>';
echo '</center></div><br/>';
echo '<table width="100%" align="center"><tr>';
$hgeht = 1;
if($upowerup != ""){
$neujutsus = "";
$array = explode(";", trim($upowerup));
$count = 0;
while(isset($array[$count])){   
$jutsugeb = getwert($array[$count],"jutsus","jutsugeb","id");
if($jutsugeb != ""){
$hgeht = 0;
if($neujutsus == ""){
$neujutsus = $jutsugeb;
}
else{
$neujutsus = $neujutsus.';'.$jutsugeb;
}
}
if($neujutsus == ""){
$neujutsus = $array[$count];
}
else{
$neujutsus = $neujutsus.';'.$array[$count];
}
$count++;
}
}
if($hgeht == 1){
$array = explode(";", trim($ujutsus));
}
else{
$array = explode(";", trim($neujutsus));
}
$count = 0;
while(isset($array[$count])){   
echo '<td align=center>';
$jname = getwert($array[$count],"jutsus","name","id");
$jbild = getwert($array[$count],"jutsus","bild","id");
$jchakra = getwert($array[$count],"jutsus","chakra","id");
$jdmg = getwert($array[$count],"jutsus","dmg","id");
$jart = getwert($array[$count],"jutsus","art","id");
echo '<input class="jutsu '.strtolower($jbild).'" name="attacke" id="login" value="'.$array[$count].'" type="submit">';
echo '<a class="sinfo">Info<span class="spanmenu" style="top:20px; left:-100px; width:200px;">';
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
echo '</span>';
echo '</a></td>';
$count++;
}
echo '</tr></table>';
}
else{
if($uaktion != 'Zufall'){
  
$geht = 1;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
hp,
kampfid,
kaktion
FROM
charaktere
WHERE kampfid="'.$ukid.'" AND hp !="0" AND kaktion = "" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 0;
}
$result->close();
$db->close();  
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
hp,
kampfid,
kaktion
FROM
npcs
WHERE kampfid="'.$ukid.'" AND hp !="0" AND kaktion = "" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 0;
}
$result->close();
$db->close();  
echo '<a href="fight.php?aktion=refresh&code='.$ucode.'">Aktualisieren</a><br>';
if($geht == 1)
{
  echo '<br/>';
  echo '<a href="fight.php?aktion=unblock&code='.$ucode.'">Runde aktualisieren</a><br>';
}
echo '<img src="bilder/design/wait.gif" width="60px" height="60px"></img><br>';
echo '<b>Warte bis alle eine Aktion getätigt haben.</b><br>';
echo '<br>';
}
else{
echo 'Du wurdest im Kampf gekickt oder hast aufgegeben.<br>';
echo '<a href="fight.php?aktion=control&code='.$ucode.'">Kontrolle übernehmen</a><br>';
echo '<br>';
echo '<a href="fight.php?aktion=refresh&code='.$ucode.'">Aktualisieren</a><br>';
echo '<img src="bilder/design/wait.gif" width="60px" height="60px"></img><br>';
echo '<b>Warte bis alle eine Aktion getätigt haben.</b><br>';
echo '<br>';
}
}
echo '</div>';
echo '</div>';
echo '</td>';
echo '<td class="katkr">';
echo '<div class="katkr katkrb"></div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</form>';
//Jutsuleiste ende

echo '<table class="ktabelle"><tr>';
echo '<td width="25%" valign="top" align="right">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
kaktion,
lkaktion,
kziel,
kzwo,
powerup,
debuff
FROM
charaktere
WHERE kampfid="'.$ukid.'" AND team % 2
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == 0&&$row['team'] != $uteam&&$row['hp'] != 0){
$ziel = $row['id'];
$zwo = 'charaktere';
}
echo '<div class="ksob"></div>';
echo '<div class="ksmb">';
echo '<table class="kspieler">';
echo '<tr class="kspieler">';
echo '<td align="center">';
echo $row['kname'];
if($row['team'] == 1){
echo '<font color="#0000ff">';
}
if($row['team'] == 2){
echo '<font color="#ff0000">';
}
if($row['team'] == 3){
echo '<font color="#00ff00">';
}
if($row['team'] == 4){
echo '<font color="#ffcc00">';
}
if($row['team'] == 5){
echo '<font color="#00e8b2">';
}
if($row['team'] == 6){
echo '<font color="#ff00ff">';
}
if($row['team'] == 7){
echo '<font color="#8B4513">';
}
if($row['team'] == 8){
echo '<font color="#5829ad">';
}
if($row['team'] == 9){
echo '<font color="#FF6EB4">';
}
if($row['team'] == 10){
echo '<font color="#FF7F00">';
}
echo '<br>Team '.$row['team'];
echo '</font>';
echo '<br>';
echo '<div style="position:relative; height:75px; width:75px;">';
if($ziel == $row['id']&&$zwo == "charaktere"){
echo '<div class="ksx" style="position:absolute; z-index:2;">';
echo '</div>';
}
else{
echo '<div class="ksbild" style="position:absolute; z-index:2;" >';
echo '<a href="fight.php?ziel='.$row['id'].'&zwo=charaktere">';
echo '<img src="bilder/kampf/ksn.png" border=0></img>';
echo '</a>';
echo '</div>';
}
if($row['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row['kkbild'].'" width="75px" height="75px"></img>';
}
else{
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="75px" height="75px"></img>';
}
echo '</div>';
echo '<div class="ksbar" style="margin-bottom:1px">';
echo '<div class="kshp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="ksbc">'; ;
if($row['team'] == $uteam){
echo $row['hp'].'/'.$row['mhp'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="ksbar">';
echo '<div class="kschakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="ksbc">'; ;
if($row['team'] == $uteam){
echo $row['chakra'].'/'.$row['mchakra'];
}
echo '</div>';
echo '</div>';
echo '</div>';
echo '<b class="att">';
if($row['kaktion'] == ""){
echo 'Wählt';
}
else{
if($row['team'] == $uteam||$row['kaktion'] == "Besiegt"){
if($row['kaktion'] != "Besiegt"&&$row['kaktion'] != "Zufall"&&$row['kaktion'] != "Kick"&&$row['kaktion'] != 'aufgeben'&&$row['kaktion'] != 'Kombi'){
$attacke = getwert($row['kaktion'],"jutsus","name","id");
$kzielname = getwert($row['kziel'],$row['kzwo'],"name","id");
}
else{
$attacke = $row['kaktion'];
$kzielname = "";
}
echo $attacke;
echo '<br>';
echo $kzielname;
}
else{
echo 'Wartet';
}
}
echo '</b><br>';
if($row['kaktion'] == ""){
if($row['id'] != $uid){
$zeit2 = time();
$zeit = date("Y-m-d H:i:s",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($row['lkaktion']);
$test3 = $test2-$test;
$zeit = 180; // 3 Min
$test4 = $zeit-$test3;
if($test3 >= $zeit){
echo '<form method="post" action="fight.php?code='.$ucode.'&aktion=kick">';
echo '<input type="hidden" value="'.$row['id'].'" name="ziel">';
echo '<input type="hidden" value="charaktere" name="wo">';
echo '<input class="button3" name="button" id="login" value="Kick" type="submit">';
echo '</form>';
}
else{
$cID = $cID+1;
echo '<b id="cID'.$cID.'">';
echo " Init<script>countdown($test4,'cID$cID');</script></b>";
}
}
else{
echo '<form method="post" action="fight.php?code='.$ucode.'&aktion=aufgeben">';
echo '<input type="checkbox" name="check" value="Ja"> ';
echo '<input class="button2" name="button" id="login" value="aufgeben" type="submit">';
echo '</form>';
}
}
echo '</td>';
//PU/DEBUFFS
if($row['powerup'] != ""||$row['debuff'] != ""){
echo '<td align="center" width="50%">';
echo '<table width="100%">';
echo '<tr>';
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$pc2 = 0;
while($pus[$pcount] != ""&&$pcount <= 9){
$pbild = getwert($pus[$pcount],"jutsus","bild","id");
echo '<td width="50%" align="center">';
echo '<div style="position:relative; height:30px; width:30px;">';
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>';
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$pbild.'h.png" width="30px" height="30px"></img>';
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$pcount++;
}
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
while($darray[$dcount] != ""&&$pcount <= 9){
$dbuff = explode(";", trim($darray[$dcount]));
$dbild = getwert($dbuff[0],"jutsus","bild","id");
echo '<td width="50%" align="center">';
echo '<div style="position:relative; height:30px; width:30px;">';
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>';
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$dbild.'h.png" width="30px" height="30px"></img>';
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$dcount++;
$pcount++;
}
echo '</tr></table>';
}
else{
echo '<td align="center">';
}
echo '</td>';
echo '</tr>';
echo '<tr class="kspieler">';
echo '<td colspan="2">';
//Beschwörungen
echo '<table width="100%" border="0">';
echo '<tr>';
$sql2 = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
besitzer,
bwo,
kaktion,
kzwo,
kziel
FROM
npcs
WHERE kampfid="'.$ukid.'" AND besitzer="'.$row['id'].'" AND bwo="charaktere"
ORDER BY
team,
name
DESC
LIMIT 3';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<td valign="top" align="center">';
echo '<div style="position:relative; height:50px; width:50px;">';
if($ziel == $row2['id']&&$zwo == "npcs"){
echo '<div class="kbx" style="position:absolute; z-index:2;">';
echo '</div>';
}
else{
echo '<div class="kbbild" style="position:absolute; z-index:2;" >';
echo '<a href="fight.php?ziel='.$row2['id'].'&zwo=npcs">';
echo '<img src="bilder/kampf/kbn.png" border=0></img>';
echo '</a>';
echo '</div>';
}

if($row2['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row2['kkbild'].'" width="50px" height="50px"></img>';
}
else{
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="50px" height="50px"></img>';
}
echo '</div>';
echo '<div class="kbbar" style="margin-bottom:1px">';
echo '<div class="kbhp" style="width:';
$prozent = $row2['hp']/$row2['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="kbbc">'; ;
if($row2['team'] == $uteam){
echo $row2['hp'].'/'.$row2['mhp'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="kbbar">';
echo '<div class="kbchakra" style="width:';
$prozent = $row2['chakra']/$row2['mchakra'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="kbbc">'; ;
if($row2['team'] == $uteam){
echo $row2['chakra'].'/'.$row2['mchakra'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<b class="att"><center>';
if($row2['kaktion'] == ""){
echo 'Wählt';
}
else{
if($row2['team'] == $uteam||$row2['kaktion'] == "Besiegt"){
if($row2['kaktion'] != "Besiegt"&&$row2['kaktion'] != "Zufall"&&$row2['kaktion'] != "Kick"&&$row2['kaktion'] != 'aufgeben'&&$row2['kaktion'] != 'Kombi'){
$attacke = getwert($row2['kaktion'],"jutsus","name","id");
$kzielname = getwert($row2['kziel'],$row2['kzwo'],"name","id");
}
else{
$attacke = "Besiegt";
$kzielname = "";
}
echo $attacke;
echo '<br>';
echo $kzielname;
}
else{
echo 'Wartet';
}
}

if($row2['kaktion'] == ""){
echo '<br>';
$zeit2 = time();
$zeit = date("Y-m-d H:i:s",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($row['lkaktion']);
$test3 = $test2-$test;
$zeit = 180; // 3 Min
$test4 = $zeit-$test3;
if($test3 >= $zeit){
echo '<form method="post" action="fight.php?code='.$ucode.'&aktion=kick">';
echo '<input type="hidden" value="'.$row2['id'].'" name="ziel">';
echo '<input type="hidden" value="npcs" name="wo">';
echo '<input class="button3" name="button" id="login" value="Kick" type="submit">';
echo '</form>';
}
else{
$cID = $cID+1;
echo '<b id="cID'.$cID.'">';
echo " Init<script>countdown($test4,'cID$cID');</script></b>";
}
}

echo '</b></center>';
echo '</td>';
}
$result2->close();
echo '</tr></table>';
echo '</td></tr></table>';
echo '</div>';
echo '<div class="ksub"></div><br>';
}
$result->close();
$db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
kaktion,
lkaktion,
kziel,
kzwo,
besitzer,
powerup,
debuff
FROM
npcs
WHERE kampfid="'.$ukid.'" AND team % 2 AND besitzer="0"
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == 0&&$row['team'] != $uteam&&$row['hp'] != 0){
$ziel = $row['id'];
$zwo = 'npcs';
}
echo '<div class="ksob"></div>';
echo '<div class="ksmb">';
echo '<table class="kspieler" border=0>';
echo '<tr class="kspieler">';
echo '<td align="center">';
echo $row['kname'];
if($row['team'] == 1){
echo '<font color="#0000ff">';
}
if($row['team'] == 2){
echo '<font color="#ff0000">';
}
if($row['team'] == 3){
echo '<font color="#00ff00">';
}
if($row['team'] == 4){
echo '<font color="#ffcc00">';
}
if($row['team'] == 5){
echo '<font color="#00e8b2">';
}
if($row['team'] == 6){
echo '<font color="#ff00ff">';
}
if($row['team'] == 7){
echo '<font color="#8B4513">';
}
if($row['team'] == 8){
echo '<font color="#5829ad">';
}
if($row['team'] == 9){
echo '<font color="#FF6EB4">';
}
if($row['team'] == 10){
echo '<font color="#FF7F00">';
}
echo '<br>Team '.$row['team'];
echo '</font>';
echo '<br>';
echo '<div style="position:relative; height:75px; width:75px;">';
if($ziel == $row['id']&&$zwo == "npcs"){
echo '<div class="ksx" style="position:absolute; z-index:2;">';
echo '</div>';
}
else{
echo '<div class="ksbild" style="position:absolute; z-index:2;" >';
echo '<a href="fight.php?ziel='.$row['id'].'&zwo=npcs">';
echo '<img src="bilder/kampf/ksn.png" border=0></img>';
echo '</a>';
echo '</div>';
}
if($row['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row['kkbild'].'" width="75px" height="75px"></img>';
}
else{
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="75px" height="75px"></img>';
}
echo '</div>';
echo '<div class="ksbar" style="margin-bottom:1px">';
echo '<div class="kshp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="ksbc">'; ;
if($row['team'] == $uteam){
echo $row['hp'].'/'.$row['mhp'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="ksbar">';
echo '<div class="kschakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="ksbc">'; ;
if($row['team'] == $uteam){
echo $row['chakra'].'/'.$row['mchakra'];
}
echo '</div>';
echo '</div>';
echo '</div>';
echo '<b class="att">';
if($row['kaktion'] == ""){
echo 'Wählt';
}
else{
if($row['team'] == $uteam||$row['kaktion'] == "Besiegt"){
if($row['kaktion'] != "Besiegt"&&$row['kaktion'] != "Zufall"&&$row['kaktion'] != "Kick"&&$row['kaktion'] != 'aufgeben'&&$row['kaktion'] != 'Kombi'){
$attacke = getwert($row['kaktion'],"jutsus","name","id");
$kzielname = getwert($row['kziel'],$row['kzwo'],"name","id");
}
else{
$attacke = $row['kaktion'];
$kzielname = "";
}
echo $attacke;
echo '<br>';
echo $kzielname;
}
else{
echo 'Wartet';
}
}
echo '</b><br>';
echo '</td>';
//PU/DEBUFFS
if($row['powerup'] != ""||$row['debuff'] != ""){
echo '<td align="center" width="50%">';
echo '<table width="100%">';
echo '<tr>';
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$pc2 = 0;
while($pus[$pcount] != ""&&$pcount <= 9){
$pbild = getwert($pus[$pcount],"jutsus","bild","id");
echo '<td width="50%" align="center">';
echo '<div style="position:relative; height:30px; width:30px;">';
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>';
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$pbild.'h.png" width="30px" height="30px"></img>';
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$pcount++;
}
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
while($darray[$dcount] != ""&&$pcount <= 9){
$dbuff = explode(";", trim($darray[$dcount]));
$dbild = getwert($dbuff[0],"jutsus","bild","id");
echo '<td width="50%" align="center">';
echo '<div style="position:relative; height:30px; width:30px;">';
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>';
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$dbild.'h.png" width="30px" height="30px"></img>';
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$dcount++;
$pcount++;
}
echo '</tr></table>';
}
else{
echo '<td align="center">';
}
echo '</td>';
echo '</tr>';
echo '<tr class="kspieler">';
echo '<td colspan="2">';
//Beschwörungen
echo '<table width="100%" border="0">';
echo '<tr>';
$sql2 = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
besitzer,
bwo,
kaktion,
kzwo,
kziel
FROM
npcs
WHERE kampfid="'.$ukid.'" AND besitzer="'.$row['id'].'" AND bwo="npcs"
ORDER BY
team,
name
DESC
LIMIT 3';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<td valign="top" align="center">';
echo '<div style="position:relative; height:50px; width:50px;">';
if($ziel == $row2['id']&&$zwo == "npcs"){
echo '<div class="kbx" style="position:absolute; z-index:2;">';
echo '</div>';
}
else{
echo '<div class="kbbild" style="position:absolute; z-index:2;" >';
echo '<a href="fight.php?ziel='.$row2['id'].'&zwo=npcs">';
echo '<img src="bilder/kampf/kbn.png" border=0></img>';
echo '</a>';
echo '</div>';
}
if($row2['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row2['kkbild'].'" width="50px" height="50px"></img>';
}
else{
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="50px" height="50px"></img>';
}
echo '</div>';
echo '<div class="kbbar" style="margin-bottom:1px">';
echo '<div class="kbhp" style="width:';
$prozent = $row2['hp']/$row2['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="kbbc">'; ;
if($row2['team'] == $uteam){
echo $row2['hp'].'/'.$row2['mhp'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="kbbar">';
echo '<div class="kbchakra" style="width:';
$prozent = $row2['chakra']/$row2['mchakra'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="kbbc">'; ;
if($row2['team'] == $uteam){
echo $row2['chakra'].'/'.$row2['mchakra'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<b class="att"><center>';
if($row2['kaktion'] == ""){
echo 'Wählt';
}
else{
if($row2['team'] == $uteam||$row2['kaktion'] == "Besiegt"){
if($row2['kaktion'] != "Besiegt"&&$row2['kaktion'] != "Zufall"&&$row2['kaktion'] != "Kick"&&$row2['kaktion'] != 'aufgeben'&&$row2['kaktion'] != 'Kombi'){
$attacke = getwert($row2['kaktion'],"jutsus","name","id");
$kzielname = getwert($row2['kziel'],$row2['kzwo'],"name","id");
}
else{
$attacke = "Besiegt";
$kzielname = "";
}
echo $attacke;
echo '<br>';
echo $kzielname;
}
else{
echo 'Wartet';
}
}

echo '</b></center>';
echo '</td>';
}
$result2->close();
echo '</tr></table>';
echo '</td></tr></table>';
echo '</div>';
echo '<div class="ksub"></div><br>';
}
$result->close();
$db->close();
echo '</td>';
echo '<td width="50%" valign="top" align="center">';
echo '<div class="klogo"></div>';
echo '<div class="klogm">';
echo '<div class="klog2 shadow" style="color:#414243">';
$kwetter = getwert($ukid,"fights","wetter","id");
echo '<div class="shadow" style="width:100px; height:100px; background:url(bilder/wetter/'.$kwetter.'.png);"><br><br>'.$kwetter.'</div>';
$klog = getwert($ukid,"fights","log","id");
echo $klog;
echo '</div>';
echo '</div>';
echo '<div class="klogu"></div>';
echo '</td>';
echo '<td width="25%" valign="top" align="left">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
kaktion,
lkaktion,
kziel,
kzwo,
powerup,
debuff
FROM
charaktere
WHERE kampfid="'.$ukid.'" AND team % 2 = "0"
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == 0&&$row['team'] != $uteam&&$row['hp'] != 0){
$ziel = $row['id'];
$zwo = 'charaktere';
}
echo '<div class="ksob"></div>';
echo '<div class="ksmb">';
echo '<table class="kspieler" border=0>';
echo '<tr class="kspieler">';
echo '<td align="center">';
echo $row['kname'];
if($row['team'] == 1){
echo '<font color="#0000ff">';
}
if($row['team'] == 2){
echo '<font color="#ff0000">';
}
if($row['team'] == 3){
echo '<font color="#00ff00">';
}
if($row['team'] == 4){
echo '<font color="#ffcc00">';
}
if($row['team'] == 5){
echo '<font color="#00e8b2">';
}
if($row['team'] == 6){
echo '<font color="#ff00ff">';
}
if($row['team'] == 7){
echo '<font color="#8B4513">';
}
if($row['team'] == 8){
echo '<font color="#5829ad">';
}
if($row['team'] == 9){
echo '<font color="#FF6EB4">';
}
if($row['team'] == 10){
echo '<font color="#FF7F00">';
}
echo '<br>Team '.$row['team'];
echo '</font>';
echo '<br>';
echo '<div style="position:relative; height:75px; width:75px;">';
if($ziel == $row['id']&&$zwo == "charaktere"){
echo '<div class="ksx" style="position:absolute; z-index:2;">';
echo '</div>';
}
else{
echo '<div class="ksbild" style="position:absolute; z-index:2;" >';
echo '<a href="fight.php?ziel='.$row['id'].'&zwo=charaktere">';
echo '<img src="bilder/kampf/ksn.png" border=0></img>';
echo '</a>';
echo '</div>';
}
if($row['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row['kkbild'].'" width="75px" height="75px"></img>';
}
else{
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="75px" height="75px"></img>';
}
echo '</div>';
echo '<div class="ksbar" style="margin-bottom:1px">';
echo '<div class="kshp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="ksbc">'; ;
if($row['team'] == $uteam){
echo $row['hp'].'/'.$row['mhp'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="ksbar">';
echo '<div class="kschakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="ksbc">'; ;
if($row['team'] == $uteam){
echo $row['chakra'].'/'.$row['mchakra'];
}
echo '</div>';
echo '</div>';
echo '</div>';
echo '<b class="att">';
if($row['kaktion'] == ""){
echo 'Wählt';
}
else{
if($row['team'] == $uteam||$row['kaktion'] == "Besiegt"){
if($row['kaktion'] != "Besiegt"&&$row['kaktion'] != "Zufall"&&$row['kaktion'] != "Kick"&&$row['kaktion'] != 'aufgeben'&&$row['kaktion'] != 'Kombi'){
$attacke = getwert($row['kaktion'],"jutsus","name","id");
$kzielname = getwert($row['kziel'],$row['kzwo'],"name","id");
}
else{
$attacke = $row['kaktion'];
$kzielname = "";
}
echo $attacke;
echo '<br>';
echo $kzielname;
}
else{
echo 'Wartet';
}
}
echo '</b><br>';
if($row['kaktion'] == ""){
if($row['id'] != $uid){
$zeit2 = time();
$zeit = date("Y-m-d H:i:s",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($row['lkaktion']);
$test3 = $test2-$test;
$zeit = 180; // 3 Min
$test4 = $zeit-$test3;
if($test3 >= $zeit){
echo '<form method="post" action="fight.php?code='.$ucode.'&aktion=kick">';
echo '<input type="hidden" value="'.$row['id'].'" name="ziel">';
echo '<input type="hidden" value="charaktere" name="wo">';
echo '<input class="button3" name="button" id="login" value="Kick" type="submit">';
echo '</form>';
}
else{
$cID = $cID+1;
echo '<b id="cID'.$cID.'">';
echo " Init<script>countdown($test4,'cID$cID');</script></b>";
}
}
else{
echo '<form method="post" action="fight.php?code='.$ucode.'&aktion=aufgeben">';
echo '<input type="checkbox" name="check" value="Ja"> ';
echo '<input class="button2" name="button" id="login" value="aufgeben" type="submit">';
echo '</form>';
}
}
echo '</td>';
//PU/DEBUFFS
if($row['powerup'] != ""||$row['debuff'] != ""){
echo '<td align="center" width="50%">';
echo '<table width="100%">';
echo '<tr>';
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$pc2 = 0;
while($pus[$pcount] != ""&&$pcount <= 9){
$pbild = getwert($pus[$pcount],"jutsus","bild","id");
echo '<td width="50%" align="center">';
echo '<div style="position:relative; height:30px; width:30px;">';
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>';
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$pbild.'h.png" width="30px" height="30px"></img>';
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$pcount++;
}
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
while($darray[$dcount] != ""&&$pcount <= 9){
$dbuff = explode(";", trim($darray[$dcount]));
$dbild = getwert($dbuff[0],"jutsus","bild","id");
echo '<td width="50%" align="center">';
echo '<div style="position:relative; height:30px; width:30px;">';
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>';
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$dbild.'h.png" width="30px" height="30px"></img>';
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$dcount++;
$pcount++;
}
echo '</tr></table>';
}
else{
echo '<td align="center">';
}
echo '</td>';
echo '</tr>';
echo '<tr class="kspieler">';
echo '<td colspan="2">';
//Beschwörungen
echo '<table width="100%" border="0">';
echo '<tr>';
$sql2 = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
besitzer,
bwo,
kaktion,
kzwo,
kziel
FROM
npcs
WHERE kampfid="'.$ukid.'" AND besitzer="'.$row['id'].'" AND bwo="charaktere"
ORDER BY
team,
name
DESC
LIMIT 3';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<td valign="top" align="center">';
echo '<div style="position:relative; height:50px; width:50px;">';
if($ziel == $row2['id']&&$zwo == "npcs"){
echo '<div class="kbx" style="position:absolute; z-index:2;">';
echo '</div>';
}
else{
echo '<div class="kbbild" style="position:absolute; z-index:2;" >';
echo '<a href="fight.php?ziel='.$row2['id'].'&zwo=npcs">';
echo '<img src="bilder/kampf/kbn.png" border=0></img>';
echo '</a>';
echo '</div>';
}

if($row2['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row2['kkbild'].'" width="50px" height="50px"></img>';
}
else{
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="50px" height="50px"></img>';
}
echo '</div>';
echo '<div class="kbbar" style="margin-bottom:1px">';
echo '<div class="kbhp" style="width:';
$prozent = $row2['hp']/$row2['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="kbbc">'; ;
if($row2['team'] == $uteam){
echo $row2['hp'].'/'.$row2['mhp'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="kbbar">';
echo '<div class="kbchakra" style="width:';
$prozent = $row2['chakra']/$row2['mchakra'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="kbbc">'; ;
if($row2['team'] == $uteam){
echo $row2['chakra'].'/'.$row2['mchakra'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<b class="att"><center>';
if($row2['kaktion'] == ""){
echo 'Wählt';
}
else{
if($row2['team'] == $uteam||$row2['kaktion'] == "Besiegt"){
if($row2['kaktion'] != "Besiegt"&&$row2['kaktion'] != "Zufall"&&$row2['kaktion'] != "Kick"&&$row2['kaktion'] != 'aufgeben'&&$row2['kaktion'] != 'Kombi'){
$attacke = getwert($row2['kaktion'],"jutsus","name","id");
$kzielname = getwert($row2['kziel'],$row2['kzwo'],"name","id");
}
else{
$attacke = "Besiegt";
$kzielname = "";
}
echo $attacke;
echo '<br>';
echo $kzielname;
}
else{
echo 'Wartet';
}
}

if($row2['kaktion'] == ""){
echo '<br>';
$zeit2 = time();
$zeit = date("Y-m-d H:i:s",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($row['lkaktion']);
$test3 = $test2-$test;
$zeit = 180; // 3 Min
$test4 = $zeit-$test3;
if($test3 >= $zeit){
echo '<form method="post" action="fight.php?code='.$ucode.'&aktion=kick">';
echo '<input type="hidden" value="'.$row2['id'].'" name="ziel">';
echo '<input type="hidden" value="npcs" name="wo">';
echo '<input class="button3" name="button" id="login" value="Kick" type="submit">';
echo '</form>';
}
else{
$cID = $cID+1;
echo '<b id="cID'.$cID.'">';
echo " Init<script>countdown($test4,'cID$cID');</script></b>";
}
}

echo '</b></center>';
echo '</td>';
}
$result2->close();
echo '</tr></table>';
echo '</td></tr></table>';
echo '</div>';
echo '<div class="ksub"></div><br>';
}
$result->close();
$db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
kaktion,
lkaktion,
kziel,
kzwo,
besitzer,
powerup,
debuff
FROM
npcs
WHERE kampfid="'.$ukid.'" AND team %2 = "0" AND besitzer="0"
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == 0&&$row['team'] != $uteam&&$row['hp'] != 0){
$ziel = $row['id'];
$zwo = 'npcs';
}
echo '<div class="ksob"></div>';
echo '<div class="ksmb">';
echo '<table class="kspieler" border=0>';
echo '<tr class="kspieler">';
echo '<td align="center">';
echo $row['kname'];
if($row['team'] == 1){
echo '<font color="#0000ff">';
}
if($row['team'] == 2){
echo '<font color="#ff0000">';
}
if($row['team'] == 3){
echo '<font color="#00ff00">';
}
if($row['team'] == 4){
echo '<font color="#ffcc00">';
}
if($row['team'] == 5){
echo '<font color="#00e8b2">';
}
if($row['team'] == 6){
echo '<font color="#ff00ff">';
}
if($row['team'] == 7){
echo '<font color="#8B4513">';
}
if($row['team'] == 8){
echo '<font color="#5829ad">';
}
if($row['team'] == 9){
echo '<font color="#FF6EB4">';
}
if($row['team'] == 10){
echo '<font color="#FF7F00">';
}
echo '<br>Team '.$row['team'];
echo '</font>';
echo '<br>';
echo '<div style="position:relative; height:75px; width:75px;">';
if($ziel == $row['id']&&$zwo == "npcs"){
echo '<div class="ksx" style="position:absolute; z-index:2;">';
echo '</div>';
}
else{
echo '<div class="ksbild" style="position:absolute; z-index:2;" >';
echo '<a href="fight.php?ziel='.$row['id'].'&zwo=npcs">';
echo '<img src="bilder/kampf/ksn.png" border=0></img>';
echo '</a>';
echo '</div>';
}
if($row['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row['kkbild'].'" width="75px" height="75px"></img>';
}
else{
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="75px" height="75px"></img>';
}
echo '</div>';
echo '<div class="ksbar" style="margin-bottom:1px">';
echo '<div class="kshp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="ksbc">'; ;
if($row['team'] == $uteam){
echo $row['hp'].'/'.$row['mhp'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="ksbar">';
echo '<div class="kschakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="ksbc">'; ;
if($row['team'] == $uteam){
echo $row['chakra'].'/'.$row['mchakra'];
}
echo '</div>';
echo '</div>';
echo '</div>';
echo '<b class="att">';
if($row['kaktion'] == ""){
echo 'Wählt';
}
else{
if($row['team'] == $uteam||$row['kaktion'] == "Besiegt"){
if($row['kaktion'] != "Besiegt"&&$row['kaktion'] != "Zufall"&&$row['kaktion'] != "Kick"&&$row['kaktion'] != 'aufgeben'&&$row['kaktion'] != 'Kombi'){
$attacke = getwert($row['kaktion'],"jutsus","name","id");
$kzielname = getwert($row['kziel'],$row['kzwo'],"name","id");
}
else{
$attacke = $row['kaktion'];
$kzielname = "";
}
echo $attacke;
echo '<br>';
echo $kzielname;
}
else{
echo 'Wartet';
}
}
echo '</b><br>';
echo '</td>';
//PU/DEBUFFS
if($row['powerup'] != ""||$row['debuff'] != ""){
echo '<td align="center" width="50%">';
echo '<table width="100%">';
echo '<tr>';
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$pc2 = 0;
while($pus[$pcount] != ""&&$pcount <= 9){
$pbild = getwert($pus[$pcount],"jutsus","bild","id");
echo '<td width="50%" align="center">';
echo '<div style="position:relative; height:30px; width:30px;">';
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>';
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$pbild.'h.png" width="30px" height="30px"></img>';
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$pcount++;
}
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
while($darray[$dcount] != ""&&$pcount <= 9){
$dbuff = explode(";", trim($darray[$dcount]));
$dbild = getwert($dbuff[0],"jutsus","bild","id");
echo '<td width="50%" align="center">';
echo '<div style="position:relative; height:30px; width:30px;">';
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>';
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$dbild.'h.png" width="30px" height="30px"></img>';
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$dcount++;
$pcount++;
}
echo '</tr></table>';
}
else{
echo '<td align="center">';
}
echo '</td>';
echo '</tr>';
echo '<tr class="kspieler">';
echo '<td colspan="2">';
//Beschwörungen
echo '<table width="100%" border="0">';
echo '<tr>';
$sql2 = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
besitzer,
bwo,
kaktion,
kzwo,
kziel
FROM
npcs
WHERE kampfid="'.$ukid.'" AND besitzer="'.$row['id'].'" AND bwo="npcs"
ORDER BY
team,
name
DESC
LIMIT 3';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<td valign="top" align="center">';
echo '<div style="position:relative; height:50px; width:50px;">';
if($ziel == $row2['id']&&$zwo == "npcs"){
echo '<div class="kbx" style="position:absolute; z-index:2;">';
echo '</div>';
}
else{
echo '<div class="kbbild" style="position:absolute; z-index:2;" >';
echo '<a href="fight.php?ziel='.$row2['id'].'&zwo=npcs">';
echo '<img src="bilder/kampf/kbn.png" border=0></img>';
echo '</a>';
echo '</div>';
}
if($row2['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row2['kkbild'].'" width="50px" height="50px"></img>';
}
else{
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="50px" height="50px"></img>';
}
echo '</div>';
echo '<div class="kbbar" style="margin-bottom:1px">';
echo '<div class="kbhp" style="width:';
$prozent = $row2['hp']/$row2['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="kbbc">'; ;
if($row2['team'] == $uteam){
echo $row2['hp'].'/'.$row2['mhp'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="kbbar">';
echo '<div class="kbchakra" style="width:';
$prozent = $row2['chakra']/$row2['mchakra'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';
echo '<div class="kbbc">'; ;
if($row2['team'] == $uteam){
echo $row2['chakra'].'/'.$row2['mchakra'];
}
echo '</div>';
echo '</div>';
echo '</div>';

echo '<b class="att"><center>';
if($row2['kaktion'] == ""){
echo 'Wählt';
}
else{
if($row2['team'] == $uteam||$row2['kaktion'] == "Besiegt"){
if($row2['kaktion'] != "Besiegt"&&$row2['kaktion'] != "Zufall"&&$row2['kaktion'] != "Kick"&&$row2['kaktion'] != 'aufgeben'&&$row2['kaktion'] != 'Kombi'){
$attacke = getwert($row2['kaktion'],"jutsus","name","id");
$kzielname = getwert($row2['kziel'],$row2['kzwo'],"name","id");
}
else{
$attacke = "Besiegt";
$kzielname = "";
}
echo $attacke;
echo '<br>';
echo $kzielname;
}
else{
echo 'Wartet';
}
}

echo '</b></center>';
echo '</td>';
}
$result2->close();
echo '</tr></table>';
echo '</td></tr></table>';
echo '</div>';
echo '<div class="ksub"></div><br>';
}
$result->close();
$db->close();
echo '</td>';
echo '</tr></table>';
echo '</td></tr></table>';
$time_end = getmicrotime();
$time = round($time_end - $time_start,4);
  
echo '<center><a href="index.php">Zurück zum Hauptmenü</a></center>';
echo '<center class="footer"><br>Seite in '.$time.' Sekunden generiert</center>';
}
else{
if(!logged_in()){
include 'inc/design3.php';
include 'inc/mainindex.php';
}
else{
include 'inc/design1.php';
$uwas = getwert(session_id(),"charaktere","kwas","session");
$uid = getwert(session_id(),"charaktere","id","session");
if($uwas == 0){
echo '<a href="index.php" border="0"><img src="bilder/kampf/kkampf.png" border="0"></img></a>';
}
elseif($uwas != 0){

$ukido = getwert(session_id(),"charaktere","kido","session");
/*
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET kwas ='0' WHERE id = '".$uid."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE charaktere SET kido ='0' WHERE id = '".$uid."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
*/
if($uwas == 1){
echo '<a href="index.php" border="0"><img src="bilder/kampf/win.png" border="0"></img></a>';
}
//gewonnen
elseif($uwas == 2){
echo '<a href="index.php" border="0"><img src="bilder/kampf/loose.png" border="0"></img></a>';
//verloren
}
elseif($uwas == 3){
echo '<a href="index.php" border="0"><img src="bilder/kampf/unent.png" border="0"></img></a>';
//unentschieden
}

echo '<center><div class="klogo"></div>';
echo '<div class="klogm">';
echo '<div class="klog2 shadow" style="color:#414243">';
$klog = getwert($ukido,"fights","log","id");
echo $klog;
echo '</div>';
echo '</div>';
echo '<div class="klogu"></div></center>';
}
}
include 'inc/design2.php';
}
?>