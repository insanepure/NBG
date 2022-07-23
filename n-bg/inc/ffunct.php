<?php
function logbearbeitung($sattacke,$uid,$uwo,$gid,$gwo,$itext,$tottext,$beides,$dmg,$ianzahl,$cdmg,$partner,$pwo){
include 'serverdaten.php';
$text = $text.'<table width="460px" cellspacing="0"><tr>';
if($gid){
if($beides == 1){
$text = $text.'<td align="center">';
$jbild = getwert($sattacke,"jutsus","bild","id");
$text = $text.'<img src="bilder/jutsus/'.strtolower($jbild).'h.png"></img>';
$text = $text.'</td>';
}
}
$text = $text.'<td align="center">';
//Geschlechtserkennung
$uteam = getwert($uid,$uwo,"team","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
geschlecht
FROM
'.$uwo.'
WHERE id="'.$uid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$uexist = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$uname = $row['name'];
$usex = $row['geschlecht'];
$uexist = 1;
}
$result->close(); $db->close();
if($uexist == 0){
if(is_numeric($uid)){
$uname = "NoUser";
$usex = "männlich";
}
else{
$uname = $uid;
$usex = "männlich";
}
}
if($gid){
$gteam = getwert($gid,$gwo,"team","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
geschlecht
FROM
'.$gwo.'
WHERE id="'.$gid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$gexist = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gname = $row['name'];
$gsex = $row['geschlecht'];
$gexist = 1;
}
$result->close(); $db->close();
if($gexist == 0){
if(is_numeric($gid)){
$gname = "NoUser";
$gsex = "männlich";
}
else{
$gname = $gid;
$gsex = "männlich";
}
}
}
if($partner){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
geschlecht
FROM
'.$pwo.'
WHERE id="'.$partner.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$pexist = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$pname = $row['name'];
$psex = $row['geschlecht'];
$pexist = 1;
}
$result->close(); $db->close();
if($pexist == 0){
if(is_numeric($pid)){
$pname = "NoUser";
$psex = "männlich";
}
else{
$pname = $partner;
$psex = "männlich";
}
}
}
//Teamfarben
if($uteam == 1){
$ufarbe = "#0000ff";
}
if($uteam == 2){
$ufarbe = "#ff0000";
}
if($uteam == 3){
$ufarbe = "#00ff00";
}
if($uteam == 4){
$ufarbe = "#ffcc00";
}
if($uteam == 5){
$ufarbe = "#00e8b2";
}
if($uteam == 6){
$ufarbe = "#ff00ff";
}
if($uteam == 7){
$ufarbe = "#8B4513";
}
if($uteam == 8){
$ufarbe = "#5829ad";
}
if($uteam == 9){
$ufarbe = "#FF6EB4";
}
if($uteam == 10){
$ufarbe = "#FF7F00";
}
//Gegner
if($gteam == 1){
$gfarbe = "#0000ff";
}
if($gteam == 2){
$gfarbe = "#ff0000";
}
if($gteam == 3){
$gfarbe = "#00ff00";
}
if($gteam == 4){
$gfarbe = "#ffcc00";
}
if($gteam == 5){
$gfarbe = "#00e8b2";
}
if($gteam == 6){
$gfarbe = "#ff00ff";
}
if($gteam == 7){
$gfarbe = "#8B4513";
}
if($gteam == 8){
$gfarbe = "#5829ad";
}
if($gteam == 9){
$gfarbe = "#FF6EB4";
}
if($gteam == 10){
$gfarbe = "#FF7F00";
}
$ufarbe = '<font color="'.$ufarbe.'">';
$gfarbe = '<font color="'.$gfarbe.'">';
$tottext = str_replace("gegner", $gname, $tottext);
$tottext = str_replace("gteam", $gfarbe, $tottext);
$itext = str_replace("uteam", $ufarbe, $itext);
$itext = str_replace("gegner", $gname, $itext);
$itext = str_replace("partner", $pname, $itext);
$itext = str_replace("gteam", $gfarbe, $itext);
$itext = str_replace("dmg", $dmg, $itext);
$itext = str_replace("cmg", $cdmg, $itext);
$itext = str_replace("gteam", $gfarbe, $itext);
$itext = str_replace("user", $uname, $itext);
$jutsu = getwert($sattacke,"jutsus","name","id");
$itext = str_replace("sjutsu", $jutsu, $itext);
$itext = str_replace("ianzahl", $ianzahl, $itext);


//Geschlechtstexter
if($usex == "männlich"){
$stext = "dieser";
}
if($usex == "weiblich"){
$stext = "diese";
}

if($gsex == "männlich"){
$gtext = "dieser";
}
if($gsex == "weiblich"){
$gtext = "diese";
}

$itext = str_replace("udieser/udiese", $stext, $itext);
$itext = str_replace("gdieser/gdiese", $gtext, $itext);
//Geschlechter
if($ianzahl == 1){
$begrenz = "Begrenzung";
}
else{
$begrenz = "Begrenzungen";
}
$itext = str_replace("Begrenzungen/Begrenzung", $begrenz, $itext);
if($ianzahl == 1){
$liegen = "liegt";
}
else{
$liegen = "liegen";
}
$itext = str_replace("liegen/liegt", $liegen, $itext);
if($ianzahl == 1){
$kunais = "Kunai";
}
else{
$kunais = "Kunais";
}
$itext = str_replace("Kunai/Kunais", $kunais, $itext);
if($dmg == 1){
$klone = "Beschwörung";
}
else{
$klone = "Beschwörungen";
}
$itext = str_replace("beschwörung/beschwörungen", $klone, $itext);
if($dmg == 1){
$puppe = "Puppe";
}
else{
$puppe = "Puppen";
}
$itext = str_replace("Puppe/Puppen", $puppe, $itext);
if($dmg == 1){
$hund = "Hund";
}
else{
$hund = "Hunde";
}
$itext = str_replace("Hund/Hunde", $hund, $itext);
$text = $text.$tottext.$itext;

$text = $text.'</td>';

if($gid){
if($beides == 0){
$text = $text.'<td align="center">';
$jbild = getwert($sattacke,"jutsus","bild","id");
$text = $text.'<img src="bilder/jutsus/'.strtolower($jbild).'h.png"></img>';
$text = $text.'</td>';
}
}
//Aktion
$text = $text.'</tr></table>';
$text = $text.'<br>';
return $text;
}
function jart16($jdmg,$jtreffer,$jtyp,$schadd,$spieler,$swo){
include 'serverdaten.php';
$getroffen = 0;
$steam = getwert($spieler,$swo,"team","id");
$ukid = getwert($spieler,$swo,"kampfid","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp
FROM
charaktere
WHERE kampfid = "'.$ukid.'" AND team = "'.$steam.'" AND hp != "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$kspieler = 0;
$cspieler = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kspieler++;
$cspieler++;
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp,
gradgerufen
FROM
npcs
WHERE kampfid = "'.$ukid.'" AND team = "'.$steam.'" AND hp != "0" AND gradgerufen ="0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kspieler++;
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp,
besitzer,
gradgerufen
FROM
npcs
WHERE besitzer="0" AND kampfid="'.$ukid.'" AND team = "'.$steam.'" AND hp !="0" AND gradgerufen ="0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$cspieler++;
}
$result->close(); $db->close();
if($cspieler == 0){
$cspieler = 1;
}
if($kspieler == 0){
$schadd = 0;
}
if($schadd != 0){
$schadd = $schadd/$kspieler;
$schadd = round($schadd);
}
else{
$schadd = 0;
}
if($jdmg > 0.4){
$jdmg = ($jdmg+0.1)-($cspieler*0.1);
if($jdmg < 0.4){
$jdmg = 0.4;
}
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
//Normaler Schaden , einzelnt auf eine Person

if($jtyp == "Taijutsu"){
//Kraft
$satk = getwert($spieler,$swo,"kr","id");
}
if($jtyp == "Ninjutsu"){
//Chakrakontrolle
$satk = getwert($spieler,$swo,"chrk","id");
}
if($jtyp == "Genjutsu"){
//Intelligenz
$satk = getwert($spieler,$swo,"intl","id");
}
$gdmg = 0;
$getroffen = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp,
mhp,
id
FROM
charaktere
WHERE kampfid="'.$ukid.'" AND team = "'.$steam.'" AND hp != "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$zmhp = $row['mhp'];
$zhp = $row['hp'];
$dmg = 0;
if($zhp < $zmhp && $zhp != 0){
$treffer2 = 1;
$getroffen++;
//Damageformel
//Alte Formel: ((ATTACKE+CHAKRA)*JUTSUDMG)-DEF
//$dmg2 = ($satk*2*$jdmg)-$zdef;
//$dmg = (($satk+$schadd)*$jdmg)-$zdef;
//if($dmg2 <= $dmg){
//$dmg = $dmg2;
//}
//Neue Formel: Angriffswert * (1,9 + [(2*Chakra)/(Angriffswert+Chakra)])
$dmg = $satk*($jdmg+( ((2*$schadd)/($satk+$schadd))));
$dmg = round($dmg);
//berechne DMG
$zhp2 = $zhp+$dmg;
//
//Speichere beim Gegner
if($zhp2 >= $zmhp){
$dmg = $zmhp-$zhp;
$zhp = $zmhp;
}
else{
$zhp = $zhp2;
}
$gdmg += $dmg;
$sql="UPDATE charaktere SET hp ='$zhp' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} //treffer
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp,
mhp,
id,
gradgerufen
FROM
npcs
WHERE kampfid="'.$ukid.'" AND team = "'.$steam.'" AND hp != "0" AND gradgerufen="0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$zmhp = $row['mhp'];
$zhp = $row['hp'];
$dmg = 0;
if($zhp < $zmhp && $zhp != 0){
$treffer2 = 1;
$getroffen++;
//Damageformel
//Alte Formel: ((ATTACKE+CHAKRA)*JUTSUDMG)-DEF
//$dmg2 = ($satk*2*$jdmg)-$zdef;
//$dmg = (($satk+$schadd)*$jdmg)-$zdef;
//if($dmg2 <= $dmg){
//$dmg = $dmg2;
//}
//Neue Formel: Angriffswert * (1,9 + [(2*Chakra)/(Angriffswert+Chakra)])
$dmg = $satk*($jdmg+( ((2*$schadd)/($satk+$schadd))));
$dmg = round($dmg);
//berechne DMG
$zhp2 = $zhp+$dmg;
//
//Speichere beim Gegner
if($zhp2 >= $zmhp){
$dmg = $zmhp-$zhp;
$zhp = $zmhp;
}
else{
$zhp = $zhp2;
}
$gdmg += $dmg;
$sql="UPDATE npcs SET hp ='$zhp' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} //treffer
}
$result->close(); $db->close();
 //treffer
if($getroffen == 0){
$treffer2 = 0;
}
else{
$gdmg = $gdmg/$getroffen;
$gdmg = round($gdmg);
$treffer2 = 1;
}
$array[0] = $treffer2;
$array[1] = $gdmg;
$array[2] = $getroffen;
mysqli_close($con);
return $array;
}
function jart15($jdmg,$jcdmg,$jtreffer,$jtyp,$sziel,$schadd,$szwo,$zhp,$spieler,$swo,$partner,$pwo){
include 'serverdaten.php';
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
//Normaler Schaden , einzelnt auf eine Person
if($jtyp == "Taijutsu"){
//Kraft
$satk = getwert($spieler,$swo,"kr","id");
$patk = getwert($partner,$pwo,"kr","id");
}
if($jtyp == "Ninjutsu"){
//Chakrakontrolle
$satk = getwert($spieler,$swo,"chrk","id");
$patk = getwert($partner,$pwo,"chrk","id");
}
if($jtyp == "Genjutsu"){
//Intelligenz
$satk = getwert($spieler,$swo,"intl","id");
$patk = getwert($partner,$pwo,"intl","id");
}

$satk = ($satk+$patk)/2;
//Widerstand
$zdef = getwert($sziel,$szwo,"wid","id");
//Berechne Trefferchance
//Genauigkeit
$sgnk = getwert($spieler,$swo,"gnk","id");
$pgnk = getwert($partner,$pwo,"gnk","id");
$sgnk = ($sgnk+$pgnk)/2;
//Tempo
$ztmp = getwert($sziel,$szwo,"tmp","id");
//Trefferformel
//(GENAUIGKEIT*JUTSUTREFFER)*50/TEMPO
//(100*0.9)*50 / 150 (100*1)*50 / 150
// 90 * 50 / 150 10 * 50 / 150
// 4500 / 200 5000 / 200
// 23 25
$dmg = 0;
$cdmg = 0;
$treffer = (($sgnk*$jtreffer)*50)/$ztmp;
$treffer = round($treffer);
if($treffer >= 100){
$treffer = 100;  //Maxtrefferchance
}
if($treffer <= 10){
$treffer = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
if($zufall <= $treffer){
$treffer2 = 1;
//Damageformel
//Alte Formel: ((ATTACKE+CHAKRA)*JUTSUDMG)-DEF
//$dmg2 = ($satk*2*$jdmg)-$zdef;
//$dmg = (($satk+$schadd)*$jdmg)-$zdef;
//if($dmg2 <= $dmg){
//$dmg = $dmg2;
//}
//Neue Formel: Angriffswert * (1,9 + [(2*Chakra)/(Angriffswert+Chakra)])
$dmg = ($satk*($jdmg+( ((2*$schadd)/($satk+$schadd)))))-$zdef;

$dmg = round($dmg);
if($dmg <= 5){
$dmg = 5;
}
//berechne DMG
$zhp = $zhp-$dmg;
//Speichere beim Gegner
if($zhp <= 0){ //gegner ist tot
$zhp = 0;
}
if($jcdmg != 0){
$zchakra = getwert($sziel,$szwo,"chakra","id");
$cdmg = $dmg/100*$jcdmg;
$cdmg = round($cdmg);
if($cdmg <= 5){
$cdmg = 5;
}
$zchakra = $zchakra-$cdmg;
if($zchakra <= 0){
$zchakra = 0;
}
$sql="UPDATE ".$szwo." SET chakra ='$zchakra' WHERE id = '".$sziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$sql="UPDATE ".$szwo." SET hp ='$zhp' WHERE id = '".$sziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} //treffer
else{ //kein treffer
$treffer2 = 0;
}
$array[0] = $treffer2;
$array[1] = $zhp;
$array[2] = $dmg;
$array[3] = $cdmg;
return $array;
}
function jart14($sattacke,$jdmg,$spieler,$swo){
include 'serverdaten.php';
$pus = getwert($spieler,$swo,"powerup","id");
$jcheck = getwert($sattacke,"jutsus","pucheck","id");
$array = explode(";", trim($pus));
$count = 0;
$hat = 0;
$treffer = 0;
$neuepus = "";
$altpus = "";
//jcheck == 3 - alle pus weg , nur das neue pu da
//jcheck == 2 - alle pus die 3 und 2 sind weg , neues pu dazu
//jcheck == 1 - alle pus die 3 sind weg, neues pu dazu
while(isset($array[$count])){   
if($jcheck == "0"){
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
if($jcheck == "1"){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($array[$count] != $sattacke){
if($pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}

if($jcheck == "2"){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($array[$count] != $sattacke){
if($pcheck == "2"||$pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}

if($jcheck == "3"){
if($array[$count] != $sattacke){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($pcheck == "1"||$pcheck == "2"||$pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}

if($array[$count] == $sattacke){
$hat = 1;
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
$count++;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($hat == 0){
$pwerte = explode(";", trim($jdmg));
$treffer = 1;
if($neuepus == ""){
$neuepus = $sattacke;
}
else{
$neuepus = $neuepus.';'.$sattacke;
}
//Schau ob auf den Feld, wenn ja, weg
/*
$gesetzt = 0;
$uclan = getwert($spieler,"charaktere","clan","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
besitzer,
npcid
FROM
npcs
WHERE besitzer="'.$spieler.'" AND npcid != "0" ORDER BY id LIMIT 3';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($uclan == 'inuzuka'&&$gesetzt != 1){
$sql="UPDATE summon SET deaktiv='1' WHERE id = '".$row['npcid']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM npcs WHERE id = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$gesetzt = $gesetzt+1;
}
if($uclan == 'jiongu'&&$gesetzt != 2){
$sql="UPDATE summon SET deaktiv='1' WHERE id = '".$row['npcid']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM npcs WHERE id = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$gesetzt = $gesetzt+1;
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
besitzer,
deaktiv,
reihenfolge
FROM
summon
WHERE besitzer="'.$spieler.'" AND deaktiv ="0"
ORDER BY
reihenfolge
LIMIT 10';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$uclan = getwert($spieler,"charaktere","clan","id");
$sused = getwert($spieler,"charaktere","summonused","id");
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 1;
$count2 = 0;
$scheck = explode("@", trim($sused));
while($scheck[$count2] != ""){
$count3 = 0;
$scheck2 = explode(";", trim($scheck[$count2]));
$scheckid = $scheck2[0];
$scheckwo = $scheck2[1];
if($scheckwo == 'summon'&&$scheckid == $row['id']){
$geht = 0;
}
$count2++;
}
if($geht == 1){
if($uclan == 'inuzuka'&&$gesetzt != 1){
$sql="UPDATE summon SET deaktiv='1' WHERE id = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

$gesetzt = $gesetzt+1;
}
if($uclan == 'jiongu'&&$gesetzt != 2){
$sql="UPDATE summon SET deaktiv='1' WHERE id = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$gesetzt = $gesetzt+1;
}
}
}
$result->close();
$db->close();
}
else{
$sql="UPDATE summon SET deaktiv='0' WHERE besitzer = '".$spieler."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
  */
}
if($altpus != ""){
$count = 0;
$altpus = explode(";", trim($altpus));
while($altpus[$count] != ""){
$jname = getwert($altpus[$count],"jutsus","dmg","id");
$jname2 = explode(";", trim($jname));
if($jname2[1] != ""){
$jdmg = $jname;
}
else{
$jdmg = getwert($jname,"item","werte","name");
}
$jwerte = explode(";", trim($jdmg));
$count2 = 0;
while($jwerte[$count2] != ""){
$pwerte[$count2] = $pwerte[$count2]-$jwerte[$count2];
$count2++;
}
$altjart = getwert($altpus[$count],"jutsus","art","id");
if($altjart == 14){
$sql="UPDATE summon SET deaktiv='0' WHERE besitzer = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$count++;
}
}
if($pwerte[0] != 0){
$uwertm = getwert($spieler,$swo,"mhp","id");
$uwd = $uwertm*($pwerte[0]/100);
$uwert = getwert($spieler,$swo,"hp","id");
$nwert = $uwert+$uwd;
if($nwert < 1){
$nwert = 1;
}
$sql="UPDATE ".$swo." SET hp ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[1] != 0){
$uwertm = getwert($spieler,$swo,"mchakra","id");
$uwd = $uwertm*($pwerte[1]/100);
$uwert = getwert($spieler,$swo,"chakra","id");
$nwert = $uwert+$uwd;
if($nwert < 1){
$nwert = 1;
}
$sql="UPDATE ".$swo." SET chakra ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[2] != 0){
$uwertm = getwert($spieler,$swo,"mkr","id");
$uwd = $uwertm*($pwerte[2]/100);
$uwert = getwert($spieler,$swo,"kr","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET kr ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[3] != 0){
$uwertm = getwert($spieler,$swo,"mtmp","id");
$uwd = $uwertm*($pwerte[3]/100);
$uwert = getwert($spieler,$swo,"tmp","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET tmp ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[4] != 0){
$uwertm = getwert($spieler,$swo,"mintl","id");
$uwd = $uwertm*($pwerte[4]/100);
$uwert = getwert($spieler,$swo,"intl","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET intl ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[5] != 0){
$uwertm = getwert($spieler,$swo,"mgnk","id");
$uwd = $uwertm*($pwerte[5]/100);
$uwert = getwert($spieler,$swo,"gnk","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET gnk ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[6] != 0){
$uwertm = getwert($spieler,$swo,"mchrk","id");
$uwd = $uwertm*($pwerte[6]/100);
$uwert = getwert($spieler,$swo,"chrk","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET chrk ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[7] != 0){
$uwertm = getwert($spieler,$swo,"mwid","id");
$uwd = $uwertm*($pwerte[7]/100);
$uwert = getwert($spieler,$swo,"wid","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET wid ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}

$sql="UPDATE ".$swo." SET powerup ='$neuepus' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
return $treffer;
}
function jart13($jtreffer,$jdmg,$ziel,$szwo,$zhp,$spieler,$swo,$schadd,$jchakra){
include 'serverdaten.php';
$ukid = getwert($spieler,$swo,"kampfid","id");
//$jdmg 1 = versiegeln
//$jdmg 2 = entsiegeln
//$jdmg 3 = puppe
//$jdmg 4 = KAI
$treffer = 0;
$ianzahl = 0;
if($jdmg == 4){
$chakrae = $jchakra+$schadd;
$udebuffs = getwert($spieler,$swo,"debuff","id");
if($udebuffs != ''){
$debuffs = explode("@", trim($udebuffs));
$ndebuffs = '';
$dcount = 0;
$sgnk = getwert($spieler,$swo,"gnk","id");
while($debuffs[$dcount] != ""){
$debuffs2 = explode(";", trim($debuffs[$dcount]));
$dcaster = $debuffs2[1];
$dwo = $debuffs2[2];
$zgnk = getwert($dwo,$dwo,"gnk","id");
$treffer2 = (($sgnk*$jtreffer)*50)/$zgnk;
$treffer2 = round($treffer2);
if($treffer2 >= 100){
$treffer2 = 100;  //Maxtrefferchance
}
if($treffer2 <= 10){
$treffer2 = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
if($zufall <= $treffer2){
$djutsuchakra = getwert($debuffs2[0],"jutsus","chakra","id");
if($chakrae >= $djutsuchakra){
$chakrae = $chakrae-$djutsuchakra;
$ianzahl++;
$treffer = 1;
}
else{
if($ndebuffs == ""){
$ndebuffs = $debuffs2[0].';'.$debuffs2[1].';'.$debuffs2[2];
}
else{
$ndebuffs = $ndebuffs.'@'.$debuffs2[0].';'.$debuffs2[1].';'.$debuffs2[2];
}
}
}
else{
if($ndebuffs == ""){
$ndebuffs = $debuffs2[0].';'.$debuffs2[1].';'.$debuffs2[2];
}
else{
$ndebuffs = $ndebuffs.'@'.$debuffs2[0].';'.$debuffs2[1].';'.$debuffs2[2];
}
}
$dcount++;
}

$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE ".$szwo." SET debuff ='$ndebuffs' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}
}
if($zhp != 0){
if($jdmg == 3){
$kart = getwert($ukid,"fights","art","id");
if($kart == 'Bijuu'||$kart == 'Eroberung'){
if($ziel != $spieler){
$zmhp = getwert($ziel,"charaktere","mhp","id");
$sgnk = getwert($spieler,"charaktere","gnk","id");
$ztmp = getwert($ziel,"charaktere","tmp","id");
$zhp2 = $zmhp/10;
if($zhp <= $zhp2){
$treffer = (($sgnk*$jtreffer)*50)/$ztmp;
$treffer = round($treffer);
if($treffer >= 100){
$treffer = 100;  //Maxtrefferchance
}
if($treffer <= 10){
$treffer = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
if($zufall <= $treffer){
$treffer = 0;
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
WHERE besitzer="'.$spieler.'"
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
$sanzahl = $sanzahl+1;
if($sanzahl <= 10){
$count = 0;
$rgeht = 1;
if($reihenfolge > 3){
$rgeht = 0;
$reihenfolge = 4;
}
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
WHERE besitzer="'.$spieler.'"
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

$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
mhp,
mchakra,
mkr,
mwid,
mtmp,
mgnk,
mintl,
mchrk';
  
$jutsusSQL = 'kbutton';
$kbildSQL = 'kbild';
$bildSQL = 'bild';
if($szwo == 'npcs')
{
  $jutsusSQL = 'jutsus';
  $kbildSQL = 'kbild';
  $bildSQL = 'kbild';
  $sql = $sql.',jutsus,kkbild,kbild';
}
$sql = $sql.','.$jutsusSQL.','.$kbildSQL.','.$bildSQL;

$sql = $sql.'
FROM
'.$szwo.'
WHERE id="'.$ziel.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
  
  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$njutsus = '';
  
  
  
$array = explode(";", trim($row[$jutsusSQL]));
$count = 0;
$janzahl = 0;
while(isset($array[$count])){   
$jart = getwert($array[$count],"jutsus","art","id");
if($array[$count] != 240){
if($jart != 3&&$jart != 5&&$jart != 8&&$jart != 9&&$jart != 10&&$jart != 12&&$jart != 13){
if($janzahl < 15){
if($njutsus == ""){
$njutsus = $array[$count];
}
else{
$njutsus = $njutsus.';'.$array[$count];
}
$janzahl++;
}
}
}
$count++;
}
$nkr = $row['mkr']/2;
if($nkr < 10)
{
$nkr = 10;
}
$nhp = $row['mhp'];
$nchakra = $row['mchakra']/1.25;
$nwid = $row['mwid']/1.25;
if($nwid < 10)
{
$nwid = 10;
}
$ntmp = $row['mtmp']/1.25;
if($ntmp < 10)
{
$ntmp = 10;
}
$ngnk = $row['mgnk']/1.25;
if($ngnk < 10)
{
$ngnk = 10;
}
$nintl = $row['mintl']/2;
if($nintl < 10)
{
$nintl = 10;
}
$nchrk = $row['mchrk']/2;
if($nchrk < 10)
{
$nchrk = 10;
}
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
besitzer,
geschlecht)
VALUES
('".$row['name']." Puppe',
'".$nhp."',
'".$nhp."',
'".$nchakra."',
'".$nchakra."',
'".$nkr."',
'".$ntmp."',
'".$ngnk."',
'".$nintl."',
'".$nchrk."',
'".$nwid."',
'".$njutsus."',
'".$row[$kkbildSQL]."',
'".$row[$kbildSQL]."',
'$reihenfolge',
'$spieler',
'".$row['geschlecht']."')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close();$db->close();
$sql="UPDATE $szwo SET hp ='0' WHERE id = '".$ziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$zhp = 0;
$treffer = 1;
}


}
else{
$treffer = 0;
}
}
}
}
}
if($jdmg == 2){
$kart = getwert($ukid,"fights","art","id");
if($kart == 'Bijuu'||$kart == 'Eroberung'){
if($szwo == 'charaktere'){
$zbijuu = getwert($ziel,"charaktere","bijuu","id");
if($zbijuu != ''){
$zmhp = getwert($ziel,"charaktere","mhp","id");
$zhp2 = $zmhp/10;
if($zhp <= $zhp2){
$treffer = 1;
$ujutsus = getwert($ziel,"charaktere","jutsus","id");
$array = explode(";", trim($ujutsus));
$count = 0;
$njutsus = '';
while(isset($array[$count])){   
if($array[$count] != 232&&$array[$count] != 234&&$array[$count] != 235&&$array[$count] != 236&&$array[$count] != 237&&$array[$count] != 240){
if($njutsus == ''){
$njutsus = $array[$count];
}
else{
$njutsus = $njutsus.';'.$array[$count];
}
}
$count++;
}
$ukbutton = getwert($ziel,"charaktere","kbutton","id");
$kwo = getwert($ziel,"charaktere","kwo","id");
$array = explode(";", trim($ukbutton));
$count = 0;
$nkbutton = '';
while(isset($array[$count])){   
if($array[$count] != 232&&$array[$count] != 234&&$array[$count] != 235&&$array[$count] != 236&&$array[$count] != 237&&$array[$count] != 240){
if($nkbutton == ''){
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
$zhp = 0;
$sql="UPDATE charaktere SET hp ='0',kbutton ='$nkbutton',jutsus ='$njutsus',bijuu ='' WHERE id = '".$ziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$geht = 0;
while($geht == 0){
$kbijuu = '';
$kbijuu = getwert($kwo,"krieg","bijuu","id");
if($kbijuu == ''){
$geht = 1;
}
else{
$kwo = $kwo+1;
if($kwo > 324){
$kwo = 0;
}
}
}
$sql="UPDATE krieg SET bijuu ='$zbijuu' WHERE id = '".$kwo."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}
}
}
}
}
if($jdmg == 1){
$kart = getwert($ukid,"fights","art","id");
if($kart == 'Bijuu'){
if($szwo == 'charaktere'){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
hp,
mhp,
kampfid,
team,
besitzer,
id
FROM
npcs
WHERE kampfid="'.$ukid.'" AND team = "2" AND hp != "0" AND besitzer="0" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$bijuu = $row['name'];
$bijuuhp = $row['hp'];
$bijuumhp = $row['mhp'];
$bijuuid = $row['id'];
}
$result->close(); $db->close();
if($bijuu != ''){
$bhp2 = $bijuumhp/10;
if($bijuuhp <= $bhp2){
$zbijuu = getwert($ziel,"charaktere","bijuu","id");
if($zbijuu == ''){
$treffer = 1;
$ujutsus = getwert($ziel,"charaktere","jutsus","id");
$ukbutton = getwert($ziel,"charaktere","kbutton","id");
$njutsus = $ujutsus.';232';
$array = explode(";", trim($ukbutton));
$count = 0;
while(isset($array[$count])){   
$count++;
}
if($count < 10){
$nkbutton = $ukbutton.';232';
}
else{
$nkbutton = $ukbutton;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE npcs SET hp ='0' WHERE id = '".$bijuuid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE charaktere SET kbutton ='$nkbutton',jutsus ='$njutsus',bijuu ='$bijuu' WHERE id = '".$ziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE krieg SET bijuu ='' WHERE bijuu = '".$bijuu."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}
}
}
}
}
}
}
$was[0] = $treffer;
$was[1] = $zhp;
$was[2] = $ianzahl;
return $was;
}
function jart11($jdmg,$jtreffer,$jtyp,$schadd,$spieler,$swo){
include 'serverdaten.php';
$getroffen = 0;
$steam = getwert($spieler,$swo,"team","id");
$ukid = getwert($spieler,$swo,"kampfid","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp
FROM
charaktere
WHERE kampfid = "'.$ukid.'" AND team != "'.$steam.'" AND hp != "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$kspieler = 0;
$cspieler = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kspieler++;
$cspieler++;
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp,
gradgerufen
FROM
npcs
WHERE kampfid = "'.$ukid.'" AND team != "'.$steam.'" AND hp != "0" AND gradgerufen ="0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kspieler++;
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp,
besitzer,
gradgerufen
FROM
npcs
WHERE besitzer="0" AND kampfid="'.$ukid.'" AND team != "'.$steam.'" AND hp !="0" AND gradgerufen ="0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$cspieler++;
}
$result->close(); $db->close();
if($cspieler == 0){
$cspieler = 1;
}
if($kspieler == 0){
$schadd = 0;
}
if($schadd != 0){
$schadd = $schadd/$kspieler;
$schadd = round($schadd);
}
else{
$schadd = 0;
}
if($jdmg > 1.4){
$jdmg = ($jdmg+0.1)-($cspieler*0.1);
if($jdmg < 1.4){
$jdmg = 1.4;
}
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
//Normaler Schaden , einzelnt auf eine Person

if($jtyp == "Taijutsu"){
//Kraft
$satk = getwert($spieler,$swo,"kr","id");
}
if($jtyp == "Ninjutsu"){
//Chakrakontrolle
$satk = getwert($spieler,$swo,"chrk","id");
}
if($jtyp == "Genjutsu"){
//Intelligenz
$satk = getwert($spieler,$swo,"intl","id");
}
//Genauigkeit
$sgnk = getwert($spieler,$swo,"gnk","id");
$gdmg = 0;
$getroffen = 0;
$tot = '';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp,
wid,
tmp,
id
FROM
charaktere
WHERE kampfid="'.$ukid.'" AND team != "'.$steam.'" AND hp != "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$zdef = $row['wid'];
$ztmp = $row['tmp'];
$zhp = $row['hp'];
$dmg = 0;
$treffer = (($sgnk*$jtreffer)*50)/$ztmp;
$treffer = round($treffer);
if($treffer >= 100){
$treffer = 100;  //Maxtrefferchance
}
if($treffer <= 10){
$treffer = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
if($zufall <= $treffer){
$getroffen = $getroffen+1;
//Damageformel
//Schaden = ( Angriff * ( Multi + ( ((2* Chakraeinsatz) / (Angriff + Chakraeinsatz))*0.75)))- Verteidigung)
$dmg = ($satk*($jdmg+( ((2*$schadd)/($satk+$schadd)))))-$zdef;
$dmg = round($dmg);
if($dmg <= 5){
$dmg = 5;
}
//berechne DMG
$gdmg = $gdmg+$dmg;
$zhp = $zhp-$dmg;
//Speichere beim Gegner
if($zhp <= 0){ //gegner ist tot
$zhp = 0;
if($tot == ''){
$tot = $row['id'].'@charaktere';
}
else{
$tot = $tot.';'.$row['id'].'@charaktere';
}
}
$sql="UPDATE charaktere SET hp ='$zhp' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} //treffer
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
team,
hp,
wid,
tmp,
id,
gradgerufen
FROM
npcs
WHERE kampfid="'.$ukid.'" AND team != "'.$steam.'" AND hp != "0" AND gradgerufen="0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$zdef = $row['wid'];
$ztmp = $row['tmp'];
$zhp = $row['hp'];
$dmg = 0;
$treffer = (($sgnk*$jtreffer)*50)/$ztmp;
$treffer = round($treffer);
if($treffer >= 100){
$treffer = 100;  //Maxtrefferchance
}
if($treffer <= 10){
$treffer = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
if($zufall <= $treffer){
$getroffen = $getroffen+1;
//Damageformel
//((ATTACKE+CHAKRA)*JUTSUDMG)-DEF
$dmg = ($satk*($jdmg+( ((2*$schadd)/($satk+$schadd)))))-$zdef;
$dmg = round($dmg);
if($dmg <= 5){
$dmg = 5;
}
//berechne DMG
$gdmg = $gdmg+$dmg;
$zhp = $zhp-$dmg;
//Speichere beim Gegner
if($zhp <= 0){ //gegner ist tot
$zhp = 0;
if($tot == ''){
$tot = $row['id'].'@npcs';
}
else{
$tot = $tot.';'.$row['id'].'@npcs';
}
}
$sql="UPDATE npcs SET hp ='$zhp' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} //treffer
}
$result->close(); $db->close();
 //treffer
if($getroffen == 0){
$treffer2 = 0;
}
else{
$gdmg = $gdmg/$getroffen;
$gdmg = round($gdmg);
$treffer2 = 1;
}
$array[0] = $treffer2;
$array[1] = $gdmg;
$array[2] = $getroffen;
$array[3] = $tot;
mysqli_close($con);
return $array;
}
function jart10($jdmg,$jtyp,$sziel,$schadd,$szwo,$zhp,$spieler,$swo){
include 'serverdaten.php';
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
//Normaler Schaden ,einzelt auf eine Person
if($jtyp == "Taijutsu"){
//Kraft
$satk = getwert($spieler,$swo,"kr","id");
}
if($jtyp == "Ninjutsu"){
//Chakrakontrolle
$satk = getwert($spieler,$swo,"chrk","id");
}
if($jtyp == "Genjutsu"){
//Intelligenz
$satk = getwert($spieler,$swo,"intl","id");
}
$zmhp = getwert($sziel,$szwo,"mhp","id");
$dmg = 0;
if($zhp < $zmhp && $zhp != 0){
$treffer2 = 1;
//Damageformel
//Alte Formel: ((ATTACKE+CHAKRA)*JUTSUDMG)-DEF
//$dmg2 = ($satk*2*$jdmg)-$zdef;
//$dmg = (($satk+$schadd)*$jdmg)-$zdef;
//if($dmg2 <= $dmg){
//$dmg = $dmg2;
//}
//Neue Formel: Angriffswert * (1,9 + [(2*Chakra)/(Angriffswert+Chakra)])
$dmg = $satk*($jdmg+( ((2*$schadd)/($satk+$schadd))));
$dmg = round($dmg);
//berechne DMG
$zhp2 = $zhp+$dmg;
//
//Speichere beim Gegner
if($zhp2 >= $zmhp){
$dmg = $zmhp-$zhp;
$zhp = $zmhp;
}
else{
$zhp = $zhp2;
}
$sql="UPDATE ".$szwo." SET hp ='$zhp' WHERE id = '".$sziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} //treffer
else{ //kein treffer
$treffer2 = 0;
}
$array[0] = $treffer2;
$array[1] = $zhp;
$array[2] = $dmg;
mysqli_close($con);
return $array;
}
function jart9($sattacke,$jdmg,$spieler,$swo){
include 'serverdaten.php';
$pus = getwert($spieler,$swo,"powerup","id");
$array = explode(";", trim($pus));
$count = 0;
$hat = 0;
while(isset($array[$count])){   
if($array[$count] == $sattacke){
$hat = 1;
}
$count++;
}
if($hat == 0){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$ianzahl = 1;
$jdmg2 = 0;
if($swo == "charaktere"){
$ianzahl2 = $ianzahl;
$ukid = getwert($spieler,$swo,"kampfid","id");
$kart = getwert($ukid,"fights","art","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
kbenutzt
FROM
items
WHERE besitzer="'.$spieler.'" AND name="'.$jdmg.'" AND anzahl > kbenutzt';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ianzahl2 != 0){
if($jdmg2 == 0){
$jdmg2 = getwert($row['name'],"item","werte","name");
if(($row['anzahl']-$row['kbenutzt']) < $ianzahl2)
{
$gbenutzt = $row['anzahl'];
$itanzahl = 0;
$ianzahl2 = $ianzahl2-($row['anzahl']-$row['kbenutzt']);
}
else{
$gbenutzt = $ianzahl2+$row['kbenutzt'];
$itanzahl = $row['anzahl']-$ianzahl2;
$ianzahl2 = $ianzahl2-$row['anzahl'];
}
if($ianzahl2 < 0){
$ianzahl2 = 0;
}
if($kart != 'NPC'&&$kart != "Spaß"&&$kart != "Turnier"&&$kart != 'Wertung'){
if($itanzahl > 0){
//Mache das<hr size="1" noshade>
$sql="UPDATE items SET anzahl ='$itanzahl' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
//Mache das
$sql="DELETE FROM items WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
else{
$sql="UPDATE items SET kbenutzt ='$gbenutzt' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
}
$result->close();
$db->close();
//items wegmachen
$uitempus = getwert($spieler,$swo,"itempus","id");
if($uitempus == ''){
$uitempus = $sattacke;
}
else{
$uitempus = $uitempus.';'.$sattacke;
}
$sql="UPDATE charaktere SET itempus ='$uitempus' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($swo == "npcs"){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
werte
FROM
item
WHERE name="'.$jdmg.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($jdmg2 == 0){
$jdmg2 = $row['werte'];
}
}
$result->close();
$db->close();
}

$pus = getwert($spieler,$swo,"powerup","id");
$jcheck = getwert($sattacke,"jutsus","pucheck","id");
$array = explode(";", trim($pus));
$count = 0;
$neuepus = "";
$altpus = "";
//jcheck == 3 - alle pus weg , nur das neue pu da
//jcheck == 2 - alle pus die 3 und 2 sind weg , neues pu dazu
//jcheck == 1 - alle pus die 3 sind weg, neues pu dazu
while(isset($array[$count])){   
if($jcheck == "0"){
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
if($jcheck == "1"){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($array[$count] != $sattacke){
if($pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}

if($jcheck == "2"){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($array[$count] != $sattacke){
if($pcheck == "2"||$pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}

if($jcheck == "3"){
if($array[$count] != $sattacke){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($pcheck == "1"||$pcheck == "2"||$pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}
$count++;
}
$pwerte = explode(";", trim($jdmg2));
$treffer = 1;
if($pwerte[8] != ""){
$sattacke = $pwerte[8];
}

if($neuepus == ""){
$neuepus = $sattacke;
}
else{
$neuepus = $neuepus.';'.$sattacke;
}

if($altpus != ""){
$count = 0;
$altpus = explode(";", trim($altpus));
while($altpus[$count] != ""){
$jname = getwert($altpus[$count],"jutsus","dmg","id");
$jname2 = explode(";", trim($jname));
if($jname2[1] != ""){
$jdmg = $jname;
}
else{
$jdmg = getwert($jname,"item","werte","name");
}
$jwerte = explode(";", trim($jdmg));
$count2 = 0;
while($jwerte[$count2] != ""){
$pwerte[$count2] = $pwerte[$count2]-$jwerte[$count2];
$count2++;
}
$count++;
}
}

if($pwerte[0] != 0){
$uwertm = getwert($spieler,$swo,"mhp","id");
$uwd = $uwertm*($pwerte[0]/100);
$uwert = getwert($spieler,$swo,"hp","id");
$nwert = $uwert+$uwd;
if($nwert < 1){
$nwert = 1;
}
$sql="UPDATE ".$swo." SET hp ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[1] != 0){
$uwertm = getwert($spieler,$swo,"mchakra","id");
$uwd = $uwertm*($pwerte[1]/100);
$uwert = getwert($spieler,$swo,"chakra","id");
$nwert = $uwert+$uwd;
if($nwert < 1){
$nwert = 1;
}
$sql="UPDATE ".$swo." SET chakra ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[2] != 0){
$uwertm = getwert($spieler,$swo,"mkr","id");
$uwd = $uwertm*($pwerte[2]/100);
$uwert = getwert($spieler,$swo,"kr","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET kr ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[3] != 0){
$uwertm = getwert($spieler,$swo,"mtmp","id");
$uwd = $uwertm*($pwerte[3]/100);
$uwert = getwert($spieler,$swo,"tmp","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET tmp ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[4] != 0){
$uwertm = getwert($spieler,$swo,"mintl","id");
$uwd = $uwertm*($pwerte[4]/100);
$uwert = getwert($spieler,$swo,"intl","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET intl ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[5] != 0){
$uwertm = getwert($spieler,$swo,"mgnk","id");
$uwd = $uwertm*($pwerte[5]/100);
$uwert = getwert($spieler,$swo,"gnk","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET gnk ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[6] != 0){
$uwertm = getwert($spieler,$swo,"mchrk","id");
$uwd = $uwertm*($pwerte[6]/100);
$uwert = getwert($spieler,$swo,"chrk","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET chrk ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[7] != 0){
$uwertm = getwert($spieler,$swo,"mwid","id");
$uwd = $uwertm*($pwerte[7]/100);
$uwert = getwert($spieler,$swo,"wid","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET wid ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$sql="UPDATE ".$swo." SET powerup ='$neuepus' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$geht = 1;
}
if($hat == 1){
$geht = 0;
}
return $geht;
}
function jart8($jdmg,$jtreffer,$jtyp,$sziel,$schadd,$szwo,$zhp,$spieler,$swo){
include 'serverdaten.php';
//DMG = Kunai Shuriken
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
//Normaler Schaden , einzelnt auf eine Person
if($jtyp == "Taijutsu"){
//Kraft
$satk = getwert($spieler,$swo,"kr","id");
}
if($jtyp == "Ninjutsu"){
//Chakrakontrolle
$satk = getwert($spieler,$swo,"chrk","id");
}
if($jtyp == "Genjutsu"){
//Intelligenz
$satk = getwert($spieler,$swo,"intl","id");
}
//Widerstand
$zdef = getwert($sziel,$szwo,"wid","id");
//Berechne Trefferchance
//Genauigkeit
$sgnk = getwert($spieler,$swo,"gnk","id");
//Tempo
$ztmp = getwert($sziel,$szwo,"tmp","id");
//Trefferformel
//(GENAUIGKEIT*JUTSUTREFFER)*50/TEMPO
//(100*0.9)*50 / 150 (100*1)*50 / 150
// 90 * 50 / 150 10 * 50 / 150
// 4500 / 200 5000 / 200
// 23 25
$dmg = 0;
$treffer = (($sgnk*$jtreffer)*50)/$ztmp;
$treffer = round($treffer);
if($treffer >= 100){
$treffer = 100;  //Maxtrefferchance
}
if($treffer <= 10){
$treffer = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
$ianzahl = 0;
if($zufall <= $treffer){
$treffer2 = 1;
//Damageformel
//((ATTACKE+CHAKRA)*JUTSUDMG)-DEF
if($schadd != 0){
$ianzahl = $schadd;
}
else{
$ianzahl = 1;
}
$jdmg2 = 0;
if($swo == "charaktere"){
$ianzahl2 = $ianzahl;
$ukid = getwert($spieler,$swo,"kampfid","id");
$kart = getwert($ukid,"fights","art","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
kbenutzt
FROM
items
WHERE besitzer="'.$spieler.'" AND name="'.$jdmg.'" AND anzahl > kbenutzt';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($jdmg2 == 0){
$jdmg2 = getwert($row['name'],"item","werte","name");
if(($row['anzahl']-$row['kbenutzt']) < $ianzahl2)
{
$gbenutzt = $row['anzahl'];
$itanzahl = 0;
$ianzahl2 = $ianzahl2-($row['anzahl']-$row['kbenutzt']);
}
else{
$gbenutzt = $ianzahl2+$row['kbenutzt'];
$itanzahl = $row['anzahl']-$ianzahl2;
$ianzahl2 = $ianzahl2-$row['anzahl'];
}
if($ianzahl2 <= 0){
$ianzahl2 = 0;
}
if($kart != 'NPC'&&$kart != "Spaß"&&$kart != "Turnier"&&$kart != 'Wertung'){
if($itanzahl > 0){
//Mache das
$sql="UPDATE items SET anzahl ='$itanzahl' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
//Mache das
$sql="DELETE FROM items WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
else{
$sql="UPDATE items SET kbenutzt ='$gbenutzt' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
$result->close();
$db->close();
//items wegmachen

}
if($swo == "npcs"){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
werte
FROM
item
WHERE name="'.$jdmg.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($jdmg2 == 0){
$jdmg2 = $row['werte'];
}
}
$result->close();
$db->close();
}
$jdmg2 = $jdmg2+(0.02*$ianzahl);
//Damageformel
//Alte Formel: ((ATTACKE+CHAKRA)*JUTSUDMG)-DEF
//$dmg2 = ($satk*2*$jdmg)-$zdef;
//$dmg = (($satk+$schadd)*$jdmg)-$zdef;
//if($dmg2 <= $dmg){
//$dmg = $dmg2;
//}
//Neue Formel: Angriffswert * (1,9 + [(2*Chakra)/(Angriffswert+Chakra)])
$dmg = ($satk*($jdmg2+( ((2*$schadd)/($satk+$schadd)))))-$zdef;

$dmg = round($dmg);
if($dmg <= 5){
$dmg = 5;
}
//berechne DMG
$zhp = $zhp-$dmg;
//Speichere beim Gegner
if($zhp <= 0){ //gegner ist tot
$zhp = 0;
}
$sql="UPDATE ".$szwo." SET hp ='$zhp' WHERE id = '".$sziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} //treffer
else{ //kein treffer
$treffer2 = 0;
}
$array[0] = $treffer2;
$array[1] = $zhp;
$array[2] = $dmg;
$array[3] = $ianzahl;
mysqli_close($con);
return $array;
}
function jart7($sattacke,$jtreffer,$sziel,$szwo,$spieler,$swo){
include 'serverdaten.php';
$zdebuff = getwert($sziel,$szwo,"debuff","id");
//jutsu;anwender;anwenderwo@
//1;3;charaktere
//geht 1 = guck ob trifft
//geht 2 = deaktiviert
//geht 0 = nicht wegmachbar/anwendbar
$geht = 1;
if($zdebuff != ""){
$array = explode("@", trim($zdebuff));
$count = 0;
while(isset($array[$count])){   
$zd = explode(";", trim($array[$count]));
if($sattacke == $zd[0]){
if($spieler == $zd[1]&&$swo == $zd[2]){
$geht = 2;
}
else{
$geht = 0;
}
}
$count++;
}
}
if($geht != 0){
$nzdebuff = "";
if($geht == 1){
//drauf
//Berechne Trefferchance
//Genauigkeit
$sgnk = getwert($spieler,$swo,"gnk","id");
//Tempo
$ztmp = getwert($sziel,$szwo,"tmp","id");
//Trefferformel
//(GENAUIGKEIT*JUTSUTREFFER)*50/TEMPO
//(100*0.9)*50 / 150 (100*1)*50 / 150
// 90 * 50 / 150 10 * 50 / 150
// 4500 / 200 5000 / 200
// 23 25
$treffer = (($sgnk*$jtreffer)*50)/$ztmp;
$treffer = round($treffer);
if($treffer >= 100){
$treffer = 100;  //Maxtrefferchance
}
if($treffer <= 10){
$treffer = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
if($zufall <= $treffer){
if($zdebuff == ""){
$nzdebuff = $sattacke.';'.$spieler.';'.$swo;
}
else{
$nzdebuff = $zdebuff.'@'.$sattacke.';'.$spieler.';'.$swo;
}

}
else{
$geht = 0;
$nzdebuff = $zdebuff;
}

}
if($geht == 2){
//Runter
$array = explode("@", trim($zdebuff));
$count = 0;
while(isset($array[$count])){   
$zd = explode(";", trim($array[$count]));
if($sattacke == $zd[0]){
if($spieler == $zd[1]&&$swo == $zd[2]){
}
else{
if($nzdebuff == ""){
$nzdebuff = $sattacke.';'.$spieler.';'.$swo;
}
else{
$nzdebuff = $nzdebuff.'@'.$sattacke.';'.$spieler.';'.$swo;
}
}
}
$count++;
}


}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));

$sql="UPDATE ".$szwo." SET debuff ='$nzdebuff' WHERE id = '".$sziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);

}


return $geht;
}
function jart6($sattacke,$jdmg,$spieler,$swo){
include 'serverdaten.php';
$pus = getwert($spieler,$swo,"powerup","id");
$jcheck = getwert($sattacke,"jutsus","pucheck","id");
$array = explode(";", trim($pus));
$count = 0;
$hat = 0;
$treffer = 0;
$neuepus = "";
$altpus = "";
//jcheck == 3 - alle pus weg , nur das neue pu da
//jcheck == 2 - alle pus die 3 und 2 sind weg , neues pu dazu
//jcheck == 1 - alle pus die 3 sind weg, neues pu dazu
while(isset($array[$count])){   
if($jcheck == "0"){
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
if($jcheck == "1"){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($array[$count] != $sattacke){
if($pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}

if($jcheck == "2"){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($array[$count] != $sattacke){
if($pcheck == "2"||$pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}

if($jcheck == "3"){
if($array[$count] != $sattacke){
$pcheck = getwert($array[$count],"jutsus","pucheck","id");
if($pcheck == "1"||$pcheck == "2"||$pcheck == "3"){
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
else{
if($neuepus == ""){
$neuepus = $array[$count];
}
else{
$neuepus = $neuepus.';'.$array[$count];
}
}
}
}

if($array[$count] == $sattacke){
$hat = 1;
if($altpus == ""){
$altpus = $array[$count];
}
else{
$altpus = $array[$count].';'.$altpus;
}
}
$count++;
}
if($hat == 0){
$pwerte = explode(";", trim($jdmg));
$treffer = 1;
if($neuepus == ""){
$neuepus = $sattacke;
}
else{
$neuepus = $neuepus.';'.$sattacke;
}
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($altpus != ""){
$count = 0;
$altpus = explode(";", trim($altpus));
while($altpus[$count] != ""){
$jname = getwert($altpus[$count],"jutsus","dmg","id");
$jname2 = explode(";", trim($jname));
if($jname2[1] != ""){
$jdmg = $jname;
}
else{
$jdmg = getwert($jname,"item","werte","name");
}
$jwerte = explode(";", trim($jdmg));
$count2 = 0;
while($jwerte[$count2] != ""){
$pwerte[$count2] = $pwerte[$count2]-$jwerte[$count2];
$count2++;
}
$altjart = getwert($altpus[$count],"jutsus","art","id");
if($altjart == 14){
$sql="UPDATE summon SET deaktiv='0' WHERE besitzer = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$count++;
}
}
if($pwerte[0] != 0){
$uwertm = getwert($spieler,$swo,"mhp","id");
$uwd = $uwertm*($pwerte[0]/100);
$uwert = getwert($spieler,$swo,"hp","id");
$nwert = $uwert+$uwd;
if($nwert < 1){
$nwert = 1;
}
$sql="UPDATE ".$swo." SET hp ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[1] != 0){
$uwertm = getwert($spieler,$swo,"mchakra","id");
$uwd = $uwertm*($pwerte[1]/100);
$uwert = getwert($spieler,$swo,"chakra","id");
$nwert = $uwert+$uwd;
if($nwert < 1){
$nwert = 1;
}
$sql="UPDATE ".$swo." SET chakra ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[2] != 0){
$uwertm = getwert($spieler,$swo,"mkr","id");
$uwd = $uwertm*($pwerte[2]/100);
$uwert = getwert($spieler,$swo,"kr","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET kr ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[3] != 0){
$uwertm = getwert($spieler,$swo,"mtmp","id");
$uwd = $uwertm*($pwerte[3]/100);
$uwert = getwert($spieler,$swo,"tmp","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET tmp ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[4] != 0){
$uwertm = getwert($spieler,$swo,"mintl","id");
$uwd = $uwertm*($pwerte[4]/100);
$uwert = getwert($spieler,$swo,"intl","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET intl ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[5] != 0){
$uwertm = getwert($spieler,$swo,"mgnk","id");
$uwd = $uwertm*($pwerte[5]/100);
$uwert = getwert($spieler,$swo,"gnk","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET gnk ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[6] != 0){
$uwertm = getwert($spieler,$swo,"mchrk","id");
$uwd = $uwertm*($pwerte[6]/100);
$uwert = getwert($spieler,$swo,"chrk","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET chrk ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($pwerte[7] != 0){
$uwertm = getwert($spieler,$swo,"mwid","id");
$uwd = $uwertm*($pwerte[7]/100);
$uwert = getwert($spieler,$swo,"wid","id");
$nwert = $uwert+$uwd;
$sql="UPDATE ".$swo." SET wid ='$nwert' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}

$sql="UPDATE ".$swo." SET powerup ='$neuepus' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
return $treffer;
}
function jart5($jdmg,$jchakra,$schadd,$spieler,$swo){
include 'serverdaten.php';
$kid = getwert($spieler,$swo,"kampfid","id");
$nteam = getwert($spieler,$swo,"team","id");
$skaktion = getwert($spieler,$swo,"kaktion","id");
//jdmg = 1.00 -Kuchiyose
//jdmg = 2.00 -hund rufen//Puppen
//jdmg = 3.00 - Körper rufen (1000 Chakra, 100%)
//jdmg = 4.00 - Aufteilen (nur ein Bruder)
//jdmg = Beschworener NPC
$einmalig = 0;
$sused = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
kampfid,
bwo,
npcid,
einmalig
FROM
npcs
WHERE kampfid="'.$kid.'" AND besitzer="'.$spieler.'" AND bwo="'.$swo.'" LIMIT 3';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$nanzahl = 0;
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$summoned[$nanzahl] = $row['name'];
$summoned2[$nanzahl] = $row['npcid'];
if($row['einmalig'] == 1){
$nanzahl = 3;
}
if($nanzahl < 3){
$nanzahl++;
}
}
$result->close(); $db->close();
if($nanzahl != 3){
$sused = getwert($spieler,$swo,"summonused","id");
if($jdmg == 4){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
hp,
reihenfolge,
besitzer,
name,
hp,
mhp,
chakra,
mchakra,
kr,
wid,
tmp,
gnk,
intl,
chrk,
kbild,
jutsus,
deaktiv
FROM
summon
WHERE besitzer="'.$spieler.'" AND hp != "0" AND deaktiv = "0"
ORDER BY
reihenfolge
LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$gchakra = $schadd+$jchakra;
$sa = 0;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($nanzahl == 0){
$count2 = 0;
$geht = 1;
while($summoned2[$count2] != ""){
if($summoned2[$count2] == $row['id']){
$geht = 0;
}
$count2++;
}
$count2 = 0;
$scheck = explode("@", trim($sused));
while($scheck[$count2] != ""){
$count3 = 0;
$scheck2 = explode(";", trim($scheck[$count2]));
$scheckid = $scheck2[0];
$scheckwo = $scheck2[1];
if($scheckwo == 'summon'&&$scheckid == $row['id']){
$geht = 0;
}
$count2++;
}
if($geht == 1){
if($gchakra >= $jchakra){
if($sused == ''){
$sused = $row['id'].';summon';
}
else{
$sused = $sused.'@'.$row['id'].';summon';
}
$sa++;
$gchakra = $gchakra-$jchakra;
$nkr = $row['kr'];
$nhp = $row['hp'];
$nmhp = $row['mhp'];
$nchakra = $row['chakra'];
$nmchakra = $row['mchakra'];
$nwid = $row['wid'];
$ntmp = $row['tmp'];
$ngnk = $row['gnk'];
$nintl = $row['intl'];
$nchrk = $row['chrk'];
$njutsu = $row['jutsus'];
$npc = $row['name'];
$npc2 = $row['name'];
$nkbild = $row['kbild'];
$nkbild2 = $row['kbild'];
$nid = $row['id'];
$puppe = 0;


if($swo == "charaktere"){
$kziel = "";
$kaktion = "";
}
else{
$kziel = "Zufall";
$kaktion = "Zufall";
}

$sql="INSERT INTO npcs(
`name`,
`kname`,
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
besitzer,
bwo,
kaktion,
kziel,
kkbild,
npcid,
puppe,
gradgerufen,
einmalig,
kbild)
VALUES
('$npc',
'$npc2',
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
'$nmhp',
'$nchakra',
'$nmchakra',
'$njutsu',
'$spieler',
'$swo',
'$kaktion',
'$kziel',
'$nkbild2',
'$nid',
'$puppe',
'1',
'1',
'$nkbild')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$nanzahl++;
}
}
}
}
$result->close(); $db->close();
mysqli_close($con);
if($sa != 0){
$geht = 1;
}
else{
$geht = 0;
}

}
elseif($jdmg == 3){   //Pain Körper
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
vertrag,
vchakra
FROM
npc
WHERE id="209" OR id="210" OR id="211"
ORDER by
vchakra
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$count = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$count2 = 0;
$geht = 1;
while($summoned[$count2] != ""){
if($summoned[$count2] == $row['name']){
$geht = 0;
}
$count2++;
}
//ID;Wo@ID;Wo
$count2 = 0;
$scheck = explode("@", trim($sused));
while($scheck[$count2] != ""){
$count3 = 0;
$scheck2 = explode(";", trim($scheck[$count2]));
$scheckid = $scheck2[0];
$scheckwo = $scheck2[1];
if($scheckwo == 'npc'&&$scheckid == $row['id']){
$geht = 0;
}
$count2++;
}
if($geht == 1){
$beschr[$count] = $row['id'];
$bechr[$count] = $row['vchakra'];
$count++;
}
}
$result->close(); $db->close();
//Gamabunta: 1000 , Gamahiro: 500 , Gama: 250 , Kichi: 100
//x1 = 1x Kichi (100)
//x2 = 2x Kichi (200)
//x3 = 3x Kichi (300)
//4x = 1x Gama (200) x 2x Kichi (200)
//Setze Chakra: 500
$gchakra = $schadd+$jchakra;
//Habe: 600
$sa = 0;
$count = 0;
while($beschr[$count] != ""&&$nanzahl != 3&&$gchakra >= $jchakra){
//Wenn Chakra (100,500,250,100) kleiner gleich gchakra (600) ist,
//also 0 - nichts , 1 - (-500) , 2 - nicht , 3 (-500).
if($bechr[$count] <= $gchakra){
if($sused == ''){
$sused = $beschr[$count].';npc';
}
else{
$sused = $sused.'@'.$beschr[$count].';npc';
}
$summon[$sa] = $beschr[$count];
$gchakra = $gchakra-$bechr[$count];
$nanzahl++;
$sa++;
}
$count++;
}

}
elseif($jdmg == 1){ //Kuchiyose
$vertrag = getwert($spieler,$swo,"vertrag","id");
if($vertrag != ""){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
vertrag,
vchakra
FROM
npc
WHERE vertrag="'.$vertrag.'"
ORDER by
vchakra
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$count = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$count2 = 0;
$geht = 1;
while($summoned[$count2] != ""){
if($summoned[$count2] == $row['name']){
$geht = 0;
}
$count2++;
}
//ID;Wo@ID;Wo
$count2 = 0;
$scheck = explode("@", trim($sused));
while($scheck[$count2] != ""){
$count3 = 0;
$scheck2 = explode(";", trim($scheck[$count2]));
$scheckid = $scheck2[0];
$scheckwo = $scheck2[1];
if($scheckwo == 'npc'&&$scheckid == $row['id']){
$geht = 0;
}
$count2++;
}
if($geht == 1){
$beschr[$count] = $row['id'];
$bechr[$count] = $row['vchakra'];
$count++;
}
}
$result->close(); $db->close();
//Gamabunta: 1000 , Gamahiro: 500 , Gama: 250 , Kichi: 100
//Setze Chakra: 500
$gchakra = $schadd+$jchakra;
//Habe: 600
$sa = 0;
$count = 0;
while($beschr[$count] != ""&&$nanzahl != 3&&$gchakra >= $jchakra){
//Wenn Chakra (100,500,250,100) kleiner gleich gchakra (600) ist,
//also 0 - nichts , 1 - (-500) , 2 - nicht , 3 (-500).
if($bechr[$count] <= $gchakra){
if($sused == ''){
$sused = $beschr[$count].';npc';
}
else{
$sused = $sused.'@'.$beschr[$count].';npc';
}
$summon[$sa] = $beschr[$count];
$gchakra = $gchakra-$bechr[$count];
$nanzahl++;
$sa++;
}
$count++;
}
//nun beschw?re.
}

}
elseif($jdmg == 2){ //hund rufen (k?nn ja auch mehrere sein)//Puppen
//je nach sortierung
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
hp,
reihenfolge,
besitzer,
name,
hp,
mhp,
chakra,
mchakra,
kr,
wid,
tmp,
gnk,
intl,
chrk,
kbild,
jutsus,
deaktiv
FROM
summon
WHERE besitzer="'.$spieler.'" AND hp != "0" AND deaktiv = "0" AND reihenfolge <= 3 AND reihenfolge != 0
ORDER BY
reihenfolge';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$gchakra = $schadd+$jchakra;
$sa = 0;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($nanzahl != 3){
$count2 = 0;
$geht = 1;
while($summoned2[$count2] != ""){
if($summoned2[$count2] == $row['id']){
$geht = 0;
}
$count2++;
}
$count2 = 0;
$scheck = explode("@", trim($sused));
while($scheck[$count2] != ""){
$count3 = 0;
$scheck2 = explode(";", trim($scheck[$count2]));
$scheckid = $scheck2[0];
$scheckwo = $scheck2[1];
if($scheckwo == 'summon'&&$scheckid == $row['id']){
$geht = 0;
}
$count2++;
}
if($geht == 1){
if($gchakra >= $jchakra){
if($sused == ''){
$sused = $row['id'].';summon';
}
else{
$sused = $sused.'@'.$row['id'].';summon';
}
$sa++;
$gchakra = $gchakra-$jchakra;
$nkr = $row['kr'];
$nhp = $row['hp'];
$nmhp = $row['mhp'];
$nchakra = $row['chakra'];
$nmchakra = $row['mchakra'];
$nwid = $row['wid'];
$ntmp = $row['tmp'];
$ngnk = $row['gnk'];
$nintl = $row['intl'];
$nchrk = $row['chrk'];
$njutsu = $row['jutsus'];
$npc = $row['name'];
$npc2 = $row['name'];
$nkbild = $row['kbild'];
$nkbild2 = $row['kbild'];
$nid = $row['id'];
$puppe = 0;
if($skaktion == "Kugutsu no Jutsu"){
$puppe = 1;
}


if($swo == "charaktere"){
$kziel = "";
$kaktion = "";
}
else{
$kziel = "Zufall";
$kaktion = "Zufall";
}

$sql="INSERT INTO npcs(
`name`,
`kname`,
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
besitzer,
bwo,
kaktion,
kziel,
kkbild,
npcid,
puppe,
gradgerufen,
kbild)
VALUES
('$npc',
'$npc2',
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
'$nmhp',
'$nchakra',
'$nmchakra',
'$njutsu',
'$spieler',
'$swo',
'$kaktion',
'$kziel',
'$nkbild2',
'$nid',
'$puppe',
'1',
'$nkbild')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$nanzahl++;
}
}
}
}
$result->close(); $db->close();
mysqli_close($con);
if($sa != 0){
$geht = 1;
}
else{
$geht = 0;
}
}
else{  // $jdmg == Der zu summon ist
$summon2 = explode(";", trim($jdmg));
if($nanzahl == 0){
$geht = 1;
$count2 = 0;
$scheck = explode("@", trim($sused));
while($scheck[$count2] != ""){
$count3 = 0;
$scheck2 = explode(";", trim($scheck[$count2]));
$scheckid = $scheck2[0];
$scheckwo = $scheck2[1];
if($scheckwo == 'npc'&&$scheckid == $jdmg){
$geht = 0;
}
$count2++;
}
if($geht == 1){
$einmalig = 1;
$sused = 1;
$summon[0] = $jdmg;
if($sused == ''){
$sused = $jdmg.';npc';
}
else{
$sused = $sused.'@'.$jdmg.';npc';
}
$nanzahl++;
}
}

}

if($summon[0] != ""&&$jdmg != 2){
$geht = 1;
$count = 0;
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
mchrk,
mtmp,
mgnk,
mwid,
kampfid
FROM
'.$swo.'
WHERE id = "'.$spieler.'" LIMIT 1
';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$umhp = $row['mhp'];
$umchakra = $row['mchakra'];
$umkr = $row['mkr'];
$umintl = $row['mintl'];
$umchrk = $row['mchrk'];
$umtmp = $row['mtmp'];
$umgnk = $row['mgnk'];
$umwid = $row['mwid'];
}
$result->close();
$db->close();
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
while($summon[$count] != ""){
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
vchakra
FROM
npc
WHERE id="'.$summon[$count].'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($jdmg == 1||$jdmg == 3){
$inc = $row['vchakra']/500;
}
else{
$inc = 1.3;
}
$nkr = round($umkr*$inc);
if($inc <= 1){
$nhp = round($umhp*$inc);
}
else{
$nhp = round($umhp);
}
$nchakra = round($umchakra*$inc);
$nwid = round($umwid*$inc);
$ntmp = round($umtmp*$inc);
$ngnk = round($umgnk*$inc);
$nintl = round($umintl*$inc);
$nchrk = round($umchrk*$inc);
$njutsus = $row['jutsus'];
$array = explode(";", trim($njutsus));
$count2 = 0;
$nnjutsus = "";
while($array[$count2] != ""){
$jart = getwert($array[$count2],"jutsus","art","id");
if($jart != 3&&$jart != 5){
if($nnjutsus == ""){
$nnjutsus = $array[$count2];
}
else{
$nnjutsus = $nnjutsus.';'.$array[$count2];
}
}
$count2++;
}
$njutsu = $nnjutsus;
$npc = $row['name'];
$npc2 = $row['name'];
$nkbild = $row['kbild'];
$nkbild2 = $row['kbild'];
$nart = "summon";

if($swo == "charaktere"){
$kziel = "";
$kaktion = "";
}
else{
$kziel = "Zufall";
$kaktion = "Zufall";
}

$sql="INSERT INTO npcs(
`name`,
`kname`,
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
besitzer,
bwo,
kaktion,
kziel,
kkbild,
kbild,
gradgerufen,
einmalig)
VALUES
('$npc',
'$npc2',
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
'$njutsu',
'$spieler',
'$swo',
'$kaktion',
'$kziel',
'$nkbild2',
'$nkbild',
'1',
'$einmalig')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close();
$db->close();
$count++;
}
mysqli_close($con);
}
}
if($jdmg == 1&&$geht == 1||$jdmg == 2&&$geht == 1||$jdmg == 4&&$geht == 1||$sused == 1){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE ".$swo." SET summonused ='$sused' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}


if($geht == 1){
$treffer2 = 1;
} //treffer
else{ //kein treffer
$treffer2 = 0;
}
$array[0] = $treffer2;
$array[1] = $sa;
return $array;
}
function jart4($szwo,$sziel,$spieler,$swo,$jdmg){
include 'serverdaten.php';
if($jdmg == ""){
$zbild = getwert($sziel,$szwo,"kkbild","id");
$zname = getwert($sziel,$szwo,"name","id");
}
else{
$zbild = 'bilder/npcs/k'.$jdmg.'.png';
$zname = getwert($spieler,$swo,"kname","id");
}
$treffer = 1;
if($szwo == $swo&&$sziel == $spieler) {
$zbild = getwert($sziel,$szwo,"kbild","id");
$zname = getwert($sziel,$szwo,"name","id");
$treffer = 0;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE ".$swo." SET kkbild ='$zbild',kname ='$zname' WHERE id = '".$spieler."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
return $treffer;
}
function jart3($jdmg,$jchakra,$schadd,$spieler,$swo){
include 'serverdaten.php';
$kid = getwert($spieler,$swo,"kampfid","id");
$nteam = getwert($spieler,$swo,"team","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
kampfid,
bwo,
einmalig
FROM
npcs
WHERE kampfid="'.$kid.'" AND besitzer="'.$spieler.'" AND bwo="'.$swo.'" LIMIT 3';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$nanzahl = 0;
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['einmalig'] == 1){
$nanzahl = 3;
}
if($nanzahl < 3){
$nanzahl++;
}
}
$result->close(); $db->close();
if($nanzahl != 3){
$geht = 1;
$nanzahl2 = $nanzahl+1;
while($schadd >= $jchakra&&$nanzahl2 != 3){
$schadd = $schadd-$jchakra;
$nanzahl2++;
}
$dmg = $nanzahl2-$nanzahl;
$count = 0;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
while($count != $dmg){
$count = $count+1;
if($swo == "charaktere"){
$kjutsus = "kbutton";
}
else{
$kjutsus = "jutsus";
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
kname,
mhp,
mchakra,
mkr,
mwid,
mtmp,
mgnk,
mintl,
mchrk,
kbild,
kkbild,
'.$kjutsus.'
FROM
'.$swo.'
WHERE id="'.$spieler.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$npc = "Klon von ".$row['name'];
if($row['name'] == $row['kname']){
$npc2 = "Klon von ".$row['name'];
}
else{
$npc2 = $row['kname'];
}
if($jdmg != 0){
$nkr = $row['mkr']*0.6;
$nhp = $row['mhp'];
$nchakra = $row['mchakra']*0.75;
$nwid = $row['mwid']*0.75;
$ntmp = $row['mtmp']*0.75;
$ngnk = $row['mgnk']*0.75;
$nintl = $row['mintl']*0.6;
$nchrk = $row['mchrk']*0.6;
$njutsus = $row[$kjutsus];
}
else{
$nkr = 1;
$nhp = 1;
$nchakra = 1;
$nwid = 1;
$ntmp = $row['mtmp'];
$ngnk = 1;
$nintl = 1;
$nchrk = 1;
$njutsus = "3";
}
$nkbild = $row['kbild'];
$nkbild2 = $row['kkbild'];
$nart = "klon";
$array = explode(";", trim($njutsus));
$count2 = 0;
$nnjutsus = "";
while($array[$count2] != ""){
$jart = getwert($array[$count2],"jutsus","art","id");  
if($jart != 3&&$jart != 5&&$jart != 8&&$jart != 9){
$geht = 1;
if($jart == 13){
$jcdmg = getwert($array[$count2],"jutsus","dmg","id");
$geht = 0;
if($jcdmg == 4){
$geht = 1;
}
}
if($geht == 1){
if($nnjutsus == ""){
$nnjutsus = $array[$count2];
}
else{
$nnjutsus = $nnjutsus.';'.$array[$count2];
}
}
}
$count2++;
}
$njutsu = $nnjutsus;
if($swo == "charaktere"){
$kziel = "";
$kaktion = "";
}
else{
$kziel = "Zufall";
$kaktion = "Zufall";
}

$sql="INSERT INTO npcs(
`name`,
`kname`,
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
besitzer,
bwo,
kaktion,
kziel,
kkbild,
gradgerufen,
kbild)
VALUES
('$npc',
'$npc2',
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
'$njutsu',
'$spieler',
'$swo',
'$kaktion',
'$kziel',
'$nkbild2',
'1',
'$nkbild')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close();
$db->close();
}
mysqli_close($con);
}
if($geht == 1){
$treffer2 = 1;
} //treffer
else{ //kein treffer
$treffer2 = 0;
}
$array[0] = $treffer2;
$array[1] = $dmg;
return $array;
}
function jart2($sziel,$spieler,$swo,$szwo){
include 'serverdaten.php';
$kid = getwert($spieler,$swo,"kampfid","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kziel,
kzwo,
kaktion,
kampfid,
gnk,
id,
hp,
name,
team
FROM
charaktere
WHERE kampfid="'.$kid.'" AND kziel ="'.$sziel.'" AND kzwo="'.$szwo.'" AND hp != "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$jart = getwert($row['kaktion'],"jutsus","art","id");
if($jart == 2){ //verteidigen
$zgnk = $row['gnk'];
$ziel = $row['id'];
$zwo = "charaktere";
$zhp = $row['hp'];
$zname = $row['name'];
$zteam = $row['team'];
}
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kziel,
kzwo,
kaktion,
kampfid,
gnk,
id,
hp,
name,
team
FROM
npcs
WHERE kampfid="'.$kid.'" AND kziel ="'.$sziel.'" AND kzwo="'.$szwo.'" AND hp != "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$jart = getwert($row['kaktion'],"jutsus","art","id");
if($jart == 2){ //verteidigen
$zgnk = $row['gnk'];
$ziel = $row['id'];
$zwo = "npcs";
$zhp = $row['hp'];
$zname = $row['name'];
$zteam = $row['team'];
}
}
$result->close(); $db->close();
if($ziel){
$sgnk = getwert($spieler,$swo,"gnk","id");
$treffer = ($zgnk*50)/$sgnk;
$treffer = round($treffer);
if($treffer >= 100){
$treffer = 100;  //Maxtrefferchance
}
if($treffer <= 10){
$treffer = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
if($zufall <= $treffer){
$neuesziel[0] = $ziel;
$neuesziel[1] = $zwo;
$neuesziel[2] = $zhp;
if($zwo == "npcs"){
$neuesziel[3] = $zname;
}
else{
$neuesziel[3] = $ziel;
}
$neuesziel[4] = $zteam;
}
}
return $neuesziel;
}

function jart1($jdmg,$jcdmg,$jtreffer,$jtyp,$sziel,$schadd,$szwo,$zhp,$spieler,$swo){
include 'serverdaten.php';
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
//Normaler Schaden , einzelnt auf eine Person
if($jtyp == "Taijutsu"){
//Kraft
$satk = getwert($spieler,$swo,"kr","id");
}
if($jtyp == "Ninjutsu"){
//Chakrakontrolle
$satk = getwert($spieler,$swo,"chrk","id");
}
if($jtyp == "Genjutsu"){
//Intelligenz
$satk = getwert($spieler,$swo,"intl","id");
}
//Widerstand
$zdef = getwert($sziel,$szwo,"wid","id");
//Berechne Trefferchance
//Genauigkeit
$sgnk = getwert($spieler,$swo,"gnk","id");
//Tempo
$ztmp = getwert($sziel,$szwo,"tmp","id");
//Trefferformel
//(GENAUIGKEIT*JUTSUTREFFER)*50/TEMPO
//(100*0.9)*50 / 150 (100*1)*50 / 150
// 90 * 50 / 150 10 * 50 / 150
// 4500 / 200 5000 / 200
// 23 25
$dmg = 0;
$cdmg = 0;
$treffer = (($sgnk*$jtreffer)*50)/$ztmp;
$treffer = round($treffer);
if($treffer >= 100){
$treffer = 100;  //Maxtrefferchance
}
if($treffer <= 10){
$treffer = 10;  //Mintrefferchance
}
$zufall = rand(1,100);
if($zufall <= $treffer){
$treffer2 = 1;
//Damageformel
//Alte Formel: ((ATTACKE+CHAKRA)*JUTSUDMG)-DEF
//$dmg2 = ($satk*2*$jdmg)-$zdef;
//$dmg = (($satk+$schadd)*$jdmg)-$zdef;
//if($dmg2 <= $dmg){
//$dmg = $dmg2;
//}
//Neue Formel: Angriffswert * (1,9 + [(2*Chakra)/(Angriffswert+Chakra)]) - Widerstand
$dmg = ($satk*($jdmg+((2*$schadd)/($satk+$schadd))))-$zdef;

$dmg = round($dmg);
if($dmg <= 5){
$dmg = 5;
}
//berechne DMG
$zhp = $zhp-$dmg;
//Speichere beim Gegner
if($zhp <= 0){ //gegner ist tot
$zhp = 0;
}
if($jcdmg != 0){
$zchakra = getwert($sziel,$szwo,"chakra","id");
$cdmg = $dmg/100*$jcdmg;
$cdmg = round($cdmg);
if($cdmg <= 5){
$cdmg = 5;
}
$zchakra = $zchakra-$cdmg;
if($zchakra <= 0){
$zchakra = 0;
}
$sql="UPDATE ".$szwo." SET chakra ='$zchakra' WHERE id = '".$sziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$sql="UPDATE ".$szwo." SET hp ='$zhp' WHERE id = '".$sziel."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} //treffer
else{ //kein treffer
$treffer2 = 0;
}
$array[0] = $treffer2;
$array[1] = $zhp;
$array[2] = $dmg;
$array[3] = $cdmg;
mysqli_close($con);
return $array;
}
function zaktion($spieler,$swo,$schakra,$spus){
include 'serverdaten.php';
//11 Aoe
//10 - Heilung
//7 - debuffs
//6 - powerup
//5 - summon
//3 - bunshin
//1 - schaden
$snpcs = 0;
$kid = getwert($spieler,$swo,"kampfid","id");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
besitzer,
bwo
FROM
npcs
WHERE besitzer="'.$spieler.'" AND bwo="'.$swo.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$snpcs = 1;
}
$result->close(); $db->close();
$sjutsus = getwert($spieler,$swo,"jutsus","id");
$spowerup = getwert($spieler,$swo,"powerup","id");
$steam = getwert($spieler,$swo,"team","id");
$smchakra = getwert($spieler,$swo,"mchakra","id");
$skraft = getwert($spieler,$swo,"kr","id");
$sintl = getwert($spieler,$swo,"intl","id");
$schrk = getwert($spieler,$swo,"chrk","id");
//jutsugeb
$array = explode(";", trim($spowerup));
$count = 0;
while(isset($array[$count])){   
$jgeb = getwert($array[$count],"jutsus","jutsugeb","id");
if($jgeb != ''){
$sjutsus = $jgeb;
}
$count++;
}
$array = explode(";", trim($sjutsus));
$count = 0;
while(isset($array[$count])){   
$jart = getwert($array[$count],"jutsus","art","id");
if($jart == 11){
if($s11 == ""){
$s11 = $array[$count];
}
else{
$s11 = $s11.';'.$array[$count];
}
}
if($jart == 10){
if($s10 == ""){
$s10 = $array[$count];
}
else{
$s10 = $s10.';'.$array[$count];
}
}
if($jart == 7){
if($s7 == ""){
$s7 = $array[$count];
}
else{
$s7 = $s7.';'.$array[$count];
}
}
if($jart == 6){
if($s6 == ""){
$s6 = $array[$count];
}
else{
$s6 = $s6.';'.$array[$count];
}
}
if($jart == 5){
if($s5 == ""){
$s5 = $array[$count];
}
else{
$s5 = $s5.';'.$array[$count];
}
}
if($jart == 3){
if($s3 == ""){
$s3 = $array[$count];
}
else{
$s3 = $s3.';'.$array[$count];
}
}
if($jart == 1){
if($s1 == ""){
$s1 = $array[$count];
}
else{
$s1 = $s1.';'.$array[$count];
}
}
$count++;
}
//11 Aoe
//10 - Heilung
//7 - debuffs
//6 - powerup
//5 - summon
//3 - bunshin
//1 - schaden
//Kein PU und Hat PU , mache PU
if($attacke == ""&&$schakra != 0&&$spowerup == ""&&$s6 != ""){
$array = explode(";", trim($s6));
$count = 0;
while(isset($array[$count])){   
$jchakra = getwert($array[$count],"jutsus","chakra","id");
if($jchakra < $schakra){
$attacke = $array[$count];
$ziel = $spieler;
$zwo = $swo;
$schadd = 0;
}
$count++;
}
}
//mache Beschw?rung
if($attacke == ""&&$schakra != 0&&$s5 != ""&&$snpcs == 0){
$jchakra = getwert($s5,"jutsus","chakra","id");
$jchakra2 = $jchakra+300;
$jchakra3 = $jchakra+150;
$jchakra4 = $jchakra+1400;
$jchakra5 = $jchakra+800;
$puben = getwert($array[$count],"jutsus","puben","id");
$geht = 1;
if($puben != ""){
$pua = explode("@", trim($puben));
$pcount = 0;
$geht = 0;
while($pua[$pcount] != ""){
$count2 = 0;
$array2 = explode(";", trim($spowerup));
while($array2[$count2] != ""){
if($array2[$count2] == $pua[$pcount]){
$geht = 1;
break;
}
$count2++;
}
if($geht == 1)
  break;
$pcount++;
}
}
if($jchakra < $schakra&&$geht == 1){
$attacke = $s5;
$ziel = $spieler;
$zwo = $swo;
if($schakra > $jchakra4){
$schadd = 1400;
}
elseif($schakra > $jchakra5){
$schadd = 800;
}
elseif($schakra > $jchakra2){
$schadd = 300;
}
elseif($schakra > $jchakra3){
$schadd = 150;
}
else{
$schadd = 0;
}
}
}
//mache Bunshins
if($attacke == ""&&$schakra != 0&&$s3 != ""&&$snpcs == 0){

$array = explode(";", trim($s3));
$count = 0;
while(isset($array[$count])){   
$jchakra = getwert($array[$count],"jutsus","chakra","id");
$puben = getwert($array[$count],"jutsus","puben","id");
$geht = 1;
if($puben != ""){
$pua = explode("@", trim($puben));
$pcount = 0;
$geht = 0;
while($pua[$pcount] != ""){
$count2 = 0;
$array2 = explode(";", trim($spowerup));
while($array2[$count2] != ""){
if($array2[$count2] == $pua[$pcount]){
$geht = 1;
break;
}
$count2++;
}
if($geht == 1)
  break;
$pcount++;
}
}
if($jchakra < $schakra&&$geht == 1){
$count2 = $count+1;
if($array[$count2] != ""){
$attacke = $array[$count];
break;
}
else{
$attacke = $array[$count];
}
}
$count++;
}
$jchakra2 = $jchakra*3;
$jchakra3 = $jchakra*2;
if($schakra > $jchakra){
$ziel = $spieler;
$zwo = $swo;
if($schakra > $jchakra2){
$schadd = $jchakra*2;
}
elseif($schakra > $jchakra3){
$schadd = $jchakra*3;
}
else{
$schadd = 0;
}
}
}


if($attacke == ""&&$schakra != 0&&$s7 != ""){
//Debuff
$zrand = rand(1,2);
if($zrand == 1){
$array = explode(";", trim($s7));
$count = 0;
while(isset($array[$count])){   
$jchakra = getwert($array[$count],"jutsus","chakra","id");
$puben = getwert($array[$count],"jutsus","puben","id");
$geht = 1;
if($puben != ""){
$pua = explode("@", trim($puben));
$pcount = 0;
$geht = 0;
while($pua[$pcount] != ""){
$count2 = 0;
$array2 = explode(";", trim($spowerup));
while($array2[$count2] != ""){
if($array2[$count2] == $pua[$pcount]){
$geht = 1;
break;
}
$count2++;
}
if($geht == 1)
  break;
$pcount++;
}
}
if($jchakra < $schakra&&$geht == 1){
$count2 = $count+1;
if($array[$count2] != ""){
$attacke = $array[$count];
break;
}
else{
$attacke = $array[$count];
}
}
$count++;
}
$zrand = rand(1,2);
if($zrand == 1){
$wo = 'charaktere';
$such = 'team ';
$order = '';
}
else{
$wo = 'npcs';
$such = 'team,gradgerufen ';
$order = 'AND gradgerufen="0"';
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
debuff,
hp,
id,
'.$such.'
FROM '.$wo.' WHERE kampfid="'.$kid.'" AND team != "'.$steam.'" AND hp != "0" '.$order.' ORDER BY hp ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == ""){
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
$geht = 1;
while($darray[$dcount] != ""){
$dbuff = explode(";", trim($darray[$dcount]));
if($dbuff[0] == $attacke){
$geht = 0;
}
$dcount++;
}
if($geht == 1){
$ziel = $row['id'];
$zwo = $wo;
}
}
}
$result->close(); $db->close();
if($ziel == ""){
if($wo == "npcs"){
$wo = "charaktere";
$such = 'team ';
$order = '';
}
else{
$wo = "npcs";
$such = 'team,gradgerufen ';
$order = 'AND gradgerufen="0"';
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
debuff,
hp,
id,
'.$such.'
FROM '.$wo.' WHERE kampfid="'.$kid.'" AND team != "'.$steam.'" AND hp != "0" '.$order.' ORDER BY hp ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == ""){
 $darray = explode("@", trim($row['debuff']));
$dcount = 0;
$geht = 1;
while($darray[$dcount] != ""){
$dbuff = explode(";", trim($darray[$dcount]));
if($dbuff[0] == $attacke){
$geht = 0;
}
$dcount++;
}
if($geht == 1){
$ziel = $row['id'];
$zwo = $wo;
}
}
}
$result->close(); $db->close();
if($ziel == ""){
$attacke = "";
$zwo = "";
}
}

}
}

if($attacke == ""&&$schakra != 0&&$s11 != ""){
//Aoe
$zrand = rand(1,10);
if($zrand <= 8){
$arrayOrdered = array();
$array = explode(";", trim($s11));
$count = 0;
while(isset($array[$count]))
{   
  $jtyp = getwert($array[$count],"jutsus","typ","id");
  if($skraft > $schrk && $skraft > $sintl && $jtyp == 'Taijutsu')
  {
    array_unshift($arrayOrdered, $array[$count]);
  }
  else if($schrk > $skraft && $schrk > $sintl && $jtyp == 'Ninjutsu')
  {
    array_unshift($arrayOrdered, $array[$count]);
  }
  else if($sintl > $skraft && $sintl > $schrk && $jtyp == 'Genjutsu')
  {
    array_unshift($arrayOrdered, $array[$count]);
  }
  else
  {
    array_push($arrayOrdered, $array[$count]);
  }
  ++$count;
}
$count = 0;
while(isset($arrayOrdered[$count])){   
$jchakra = getwert($arrayOrdered[$count],"jutsus","chakra","id");
$puben = getwert($arrayOrdered[$count],"jutsus","puben","id");
$geht = 1;
if($puben != ""){
$pua = explode("@", trim($puben));
$pcount = 0;
$geht = 0;
while($pua[$pcount] != ""){
$count2 = 0;
$array2 = explode(";", trim($spowerup));
while($array2[$count2] != ""){
if($array2[$count2] == $pua[$pcount]){
$geht = 1;
break;
}
$count2++;
}
if($geht == 1)
  break;
$pcount++;
}
}
if($jchakra < $schakra&&$geht == 1){
$count2 = $count+1;
if($arrayOrdered[$count2] != ""){
$attacke = $arrayOrdered[$count];
break;
}
else{
$attacke = $arrayOrdered[$count];
}
}
$count++;
}
$ziel = $spieler;
$zwo = $swo;

$schakra2 = $schakra-$jchakra;
if($schakra2 > 0)
{
$prozent = (($schakra2/$smchakra)*10);
$schadd = rand(0,$prozent) * $jChakra;
if($schadd > $schakra2)
  $schadd = $schakra2;
}
else
  $schadd = 0;
}
}
if($attacke == ""&&$schakra != 0&&$s10 != ""){
//Heil
$array = explode(";", trim($s10));
$count = 0;
while(isset($array[$count])){   
$jchakra = getwert($array[$count],"jutsus","chakra","id");
$puben = getwert($array[$count],"jutsus","puben","id");
$geht = 1;
if($puben != ""){
$pua = explode("@", trim($puben));
$pcount = 0;
$geht = 0;
while($pua[$pcount] != ""){
$count2 = 0;
$array2 = explode(";", trim($spowerup));
while($array2[$count2] != ""){
if($array2[$count2] == $pua[$pcount]){
$geht = 1;
break;
}
$count2++;
}
if($geht == 1)
  break;
$pcount++;
}
}
if($jchakra < $schakra&&$geht == 1){
$count2 = $count+1;
if($array[$count2] != ""){
$attacke = $array[$count];
break;
}
else{
$attacke = $array[$count];
}
}
$count++;
}
  
$schakra2 = $schakra-$jchakra;
if($schakra2 > 0)
{
$prozent = (($schakra2/$smchakra)*10);
$schadd = rand(0,$prozent) * $jChakra;
if($schadd > $schakra2)
  $schadd = $schakra2;
}
else
  $schadd = 0;
  
$zrand = rand(1,5);
if($zrand == 1){
$zrand = rand(1,2);
if($zrand == 1){
$wo = "charaktere";
}
else{
$wo = "npcs";
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
hp,
id,
mhp,
team
FROM
'.$wo.'
WHERE kampfid="'.$kid.'" AND team = "'.$steam.'" AND hp !="0" AND hp != mhp
ORDER BY
hp
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == ""){
$ziel = $row['id'];
$zwo = $wo;
}
}
$result->close(); $db->close();
if($ziel == ""){
if($wo == "charaktere"){
$wo = "npcs";
}
else{
$wo = "charaktere";
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
hp,
id,
mhp,
team
FROM
'.$wo.'
WHERE kampfid="'.$kid.'" AND team = "'.$steam.'" AND hp !="0" AND hp != mhp
ORDER BY
hp
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == ""){
$ziel = $row['id'];
$zwo = $wo;
}
}
$result->close(); $db->close();
}

}
}
if($attacke == ""){
//Schaden
$arrayOrdered = array();
$array = explode(";", trim($s1));
$count = 0;
while(isset($array[$count]))
{   
  $jtyp = getwert($array[$count],"jutsus","typ","id");
  if($skraft > $schrk && $skraft > $sintl && $jtyp == 'Taijutsu')
  {
    array_unshift($arrayOrdered, $array[$count]);
  }
  else if($schrk > $skraft && $schrk > $sintl && $jtyp == 'Ninjutsu')
  {
    array_unshift($arrayOrdered, $array[$count]);
  }
  else if($sintl > $skraft && $sintl > $schrk && $jtyp == 'Genjutsu')
  {
    array_unshift($arrayOrdered, $array[$count]);
  }
  else
  {
    array_push($arrayOrdered, $array[$count]);
  }
  ++$count;
}
$count = 0;
while(isset($arrayOrdered[$count])){   
$jchakra = getwert($arrayOrdered[$count],"jutsus","chakra","id");
$puben = getwert($arrayOrdered[$count],"jutsus","puben","id");
$geht = 1;
if($puben != ""){
$pua = explode("@", trim($puben));
$pcount = 0;
$geht = 0;
while($pua[$pcount] != ""){
$count2 = 0;
$array2 = explode(";", trim($spowerup));
while($array2[$count2] != ""){
if($array2[$count2] == $pua[$pcount]){
$geht = 1;
break;
}
$count2++;
}
if($geht == 1)
  break;
$pcount++;
}
}
if($jchakra <= $schakra&&$geht == 1){
$count2 = $count+1;
if($arrayOrdered[$count2] != ""){
$attacke = $arrayOrdered[$count];
break;
}
else{
$attacke = $arrayOrdered[$count];
}
}
$count++;
}

$schakra2 = $schakra-$jchakra;
if($schakra2 > 0)
{
$prozent = (($schakra2/$smchakra)*10);
$schadd = rand(0,$prozent) * $jChakra;
if($schadd > $schakra2)
  $schadd = $schakra2;
}
else
  $schadd = 0;
  
if($attacke == ""){
$attacke = "1";
}
$zrand = rand(1,2);
if($zrand == 1){
$wo = "charaktere";
$such = 'team ';
$order = '';
}
else{
$wo = "npcs";
$such = 'team,gradgerufen ';
$order = 'AND gradgerufen="0"';
}
  
$ziel = '';
$zwo = '';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
hp,
id,
mhp,
name,
'.$such.'
FROM
'.$wo.'
WHERE kampfid="'.$kid.'" AND team != "'.$steam.'" AND hp !="0" '.$order.'
ORDER BY
hp
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == '')
{
$ziel = $row['id'];
$zwo = $wo;
}
}
$result->close(); $db->close();
if($ziel == ''){
if($wo == "charaktere"){
$wo = "npcs";
$such = 'team,gradgerufen ';
$order = 'AND gradgerufen="0"';
}
else{
$wo = "charaktere";
$such = 'team ';
$order = '';
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
kampfid,
hp,
id,
mhp,
'.$such.'
FROM
'.$wo.'
WHERE kampfid="'.$kid.'" AND team != "'.$steam.'" AND hp !="0" '.$order.'
ORDER BY
hp
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($ziel == ''){
$ziel = $row['id'];
$zwo = $wo;
}
}
$result->close(); $db->close();
}

}
if($zwo == ''){
$zwo = $swo;
}
if($ziel == ''){
$ziel = $spieler;
}
$array[0] = $zwo;
$array[1] = $ziel;
$array[2] = $attacke;
$array[3] = $schadd;
return $array;
}

function aktion($ukid){
$ende = getwert($ukid,"fights","ende","id");
if($ende == 0){

// mache f?r alle eine aktion
// ?berpr?fe wer lebt
// wenn lebt , neue runde
// wenn nur ein team lebt , ende
include 'serverdaten.php';
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
kaktion
FROM
charaktere
WHERE kampfid="'.$ukid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$kspieler = 0;
$kakt = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kspieler++;
if($row['kaktion'] != ""){
$kakt++;
}
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
kaktion
FROM
npcs
WHERE kampfid="'.$ukid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kspieler++;
if($row['kaktion'] != ""){
$kakt++;
}
}
$result->close(); $db->close();
if($kakt == $kspieler){
//Berechne Reihenfolge
$versteckt = 100;
$spieler = reihenfolge($ukid,$versteckt);
$count = 0;
$bcount = 0;
//Arbeite die Reihenfolge ab
while($spieler[$count] != ""){
$tottext = '';
$count2 = $count+$versteckt;
$swo = $spieler[$count2];
$shp = getwert($spieler[$count],$swo,"hp","id");
$schakra = getwert($spieler[$count],$swo,"chakra","id");
$smchakra = getwert($spieler[$count],$swo,"mchakra","id");
$sattacke = getwert($spieler[$count],$swo,"kaktion","id");
//Wenn er auch lebt
$kick = 0;
if($sattacke != "Besiegt"&&$sattacke != ''){
$schadd = "";
$schadd = getwert($spieler[$count],$swo,"kchadd","id");
$sziel = getwert($spieler[$count],$swo,"kziel","id");
$steam = getwert($spieler[$count],$swo,"team","id");
$spus = getwert($spieler[$count],$swo,"powerup","id");
if($sattacke != 'Kombi'){
if($sattacke != 'aufgeben'){
if($sattacke != "Kick"){
if($sziel == "Zufall"){
$array = zaktion($spieler[$count],$swo,$schakra,$spu);
$szwo = $array[0];
$sziel = $array[1];
$sattacke = $array[2];
$schadd = $array[3];
}
else{
$szwo = getwert($spieler[$count],$swo,"kzwo","id");
}
$zteam = getwert($sziel,$szwo,"team","id");
$zhp = getwert($sziel,$szwo,"hp","id");
if($szwo == "npcs"){
$zidn = getwert($sziel,$szwo,"name","id");
}
else{
$zidn = $sziel;
}
if($swo == "npcs"){
$zidu = getwert($spieler[$count],$swo,"name","id");
}
else{
$zidu = $spieler[$count];
}
$jart = getwert($sattacke,"jutsus","art","id");
if($zhp != 0||$jart == 11||$jart == 14||$jart == 12||$jart == 9||$jart == 6||$jart == 5||$jart == 3){
//Werteauslesen des Jutsus
$jdmg = getwert($sattacke,"jutsus","dmg","id");
$jcdmg = getwert($sattacke,"jutsus","cdmg","id");
$jtreffer = getwert($sattacke,"jutsus","treffer","id");
$jtyp = getwert($sattacke,"jutsus","typ","id");
$jchakra = getwert($sattacke,"jutsus","chakra","id");
$jelement = getwert($sattacke,"jutsus","element","id");
$prozent = substr($jchakra, -1);
if($prozent == "%"){
$jchakra = substr($jchakra, 0,-1);
$jchakra = (($smchakra*$jchakra)/100);
}
$bchakra = $jchakra;
//Jutsuarten
mysqli_close($con);
if($spus != ""){
$pus = explode(";", trim($spus));
$pcount = 0;
$puchrk = 0;
while($pus[$pcount] != ""){
$puchr = getwert($pus[$pcount],"jutsus","chakra","id");
$puchrk = $puchrk+$puchr;
$pcount++;
}
$jchakra = $jchakra+$puchrk;
}
$hde = 0;
$dchakra = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
debuff
FROM
charaktere
WHERE kampfid="'.$ukid.'" AND debuff != ""
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$dus = explode("@", trim($row['debuff']));
$dcount = 0;
while($dus[$dcount] != ""){
$dus2 = explode(";", trim($dus[$dcount]));
if($dus2[1] == $spieler[$count]&&$dus2[2] == $swo){
$hde = 1;
$duchr = getwert($dus2[0],"jutsus","chakra","id");
$dchakra = $dchakra+$duchr;
}
$dcount++;
}
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
debuff
FROM
npcs
WHERE kampfid="'.$ukid.'" AND debuff != ""
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$dus = explode("@", trim($row['debuff']));
$dcount = 0;
while($dus[$dcount] != ""){
$dus2 = explode(";", trim($dus[$dcount]));
if($dus2[1] == $spieler[$count]&&$dus2[2] == $swo){
$hde = 1;
$duchr = getwert($dus2[0],"jutsus","chakra","id");
$dchakra = $dchakra+$duchr;
}
$dcount++;
}
}
$result->close(); $db->close();
if($hde == 1){
$jchakra = $jchakra+$dchakra;
}
$jchrweg = 1;
if($sziel == $spieler[$count]&&$swo == $szwo&&$jart != 11){
$jtreffer = 1000;
}
$ianzahl = 0;
$cdmg = 0;
$wetter = getwert($ukid,"fights","wetter","id");
if($jart == 16){
$array = jart16($jdmg,$jtreffer,$jtyp,$schadd,$spieler[$count],$swo);
$treffer2 = $array[0];
$zhp = $zhp;
$dmg = $array[1];
$ianzahl = $array[2];
}
if($jart == 11){
//Mehrere Gegner
if($wetter == "Regen"){
if($jelement == "Suiton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Katon"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Gewitter"){
if($jelement == "Raiton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Doton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Hitze"){
if($jelement == "Katon"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Fuuton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Sturm"){
if($jelement == "Fuuton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Raiton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Erdrutsch"){
if($jelement == "Doton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Suiton"){
$jdmg = $jdmg-0.05;
}
}
$array = jart11($jdmg,$jtreffer,$jtyp,$schadd,$spieler[$count],$swo);
$treffer2 = $array[0];
$zhp = $zhp;
$dmg = $array[1];
$ianzahl = $array[2];
$aoetote = $array[3]; //ID@WO;ID@WO
}
if($jart == 15){
$partner = getwert($spieler[$count],$swo,"kombipartner","id");
$pwo = getwert($spieler[$count],$swo,"kombipartnerw","id");
//Schaden Kombination
$nziel = jart2($sziel,$spieler[$count],$swo,$szwo);
if($nziel){
$sziel = $nziel[0];
$szwo = $nziel[1];
$zhp = $nziel[2];
$zidn = $nziel[3];
$zteam = $nziel[4];
$jtreffer = 1000;
}
if($wetter == "Regen"){
if($jelement == "Suiton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Katon"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Gewitter"){
if($jelement == "Raiton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Doton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Hitze"){
if($jelement == "Katon"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Fuuton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Sturm"){
if($jelement == "Fuuton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Raiton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Erdrutsch"){
if($jelement == "Doton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Suiton"){
$jdmg = $jdmg-0.05;
}
}
$schadd = 0;
$array = jart15($jdmg,$jcdmg,$jtreffer,$jtyp,$sziel,$schadd,$szwo,$zhp,$spieler[$count],$swo,$partner,$pwo);
$treffer2 = $array[0];
$zhp = $array[1];
$dmg = $array[2];
$cdmg = $array[3];
} //jutsuart 15 -> Kombi
if($jart == 14){
//Powerup - Beschw?rung weg
$treffer2 = jart14($sattacke,$jdmg,$spieler[$count],$swo);
$zhp = $zhp;
$dmg = 0;
if($treffer2 == 0){
$jchrweg = 0;
}

}
if($jart == 13){
//Spezial
if($jdmg == 2&&$sziel == $spieler[$count]&&$szwo == $swo){
$jtreffer = 1000;
}
$array = jart13($jtreffer,$jdmg,$sziel,$szwo,$zhp,$spieler[$count],$swo,$schadd,$bchakra);
$treffer2 = $array[0];
$zhp = $array[1];
$ianzahl = $array[2];
$dmg = 0;
}
if($jart == 10||$jart == 12){
//Heilung
if($jart == 12){
$zhp = $shp;
$sziel = $spieler[$count];
$szwo = $swo;
}
$array = jart10($jdmg,$jtyp,$sziel,$schadd,$szwo,$zhp,$spieler[$count],$swo);
$treffer2 = $array[0];
$zhp = $array[1];
$dmg = $array[2];
}
if($jart == 9){
//Item PU
$treffer2 = jart9($sattacke,$jdmg,$spieler[$count],$swo);
$zhp = $zhp;
$dmg = 0;
}
if($jart == 8){
//Item werfen
$nziel = jart2($sziel,$spieler[$count],$swo,$szwo);
if($nziel){
$sziel = $nziel[0];
$szwo = $nziel[1];
$zhp = $nziel[2];
$zidn = $nziel[3];
$zteam = $nziel[4];
$jtreffer = 1000;
}
if($wetter == "Regen"){
if($jelement == "Suiton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Katon"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Gewitter"){
if($jelement == "Raiton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Doton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Hitze"){
if($jelement == "Katon"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Fuuton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Sturm"){
if($jelement == "Fuuton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Raiton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Erdrutsch"){
if($jelement == "Doton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Suiton"){
$jdmg = $jdmg-0.05;
}
}
$array = jart8($jdmg,$jtreffer,$jtyp,$sziel,$schadd,$szwo,$zhp,$spieler[$count],$swo);
$schadd = 0;
$treffer2 = $array[0];
$zhp = $array[1];
$dmg = $array[2];
$ianzahl = $array[3];
} //jutsuart 8 -> item werfen , ein spieler
if($jart == 7){
//Debuffs
$nziel = jart2($sziel,$spieler[$count],$swo,$szwo);
if($nziel){
$sziel = $nziel[0];
$szwo = $nziel[1];
$zhp = $nziel[2];
$zidn = $nziel[3];
$zteam = $nziel[4];
$jtreffer = 1000;
}
$treffer2 = jart7($sattacke,$jtreffer,$sziel,$szwo,$spieler[$count],$swo);
$zhp = $zhp;
$dmg = 0;
if($treffer2 == 2){
$jchrweg = 0;
}
}
if($jart == 6){
//Powerup
$treffer2 = jart6($sattacke,$jdmg,$spieler[$count],$swo);
$zhp = $zhp;
$dmg = 0;
if($treffer2 == 0){
$jchrweg = 0;
}

}
if($jart == 5){
//Summon/Hund/Puppen rufen
$array = jart5($jdmg,$bchakra,$schadd,$spieler[$count],$swo);
$treffer2 = $array[0];
$zhp = $zhp;
$ianzahl = $array[1];

}
if($jart == 4){
//Henge
$treffer2 = jart4($szwo,$sziel,$spieler[$count],$swo,$jdmg);
$zhp = $zhp;
$dmg = 0;
}
if($jart == 3){
//Bunshin
$array = jart3($jdmg,$bchakra,$schadd,$spieler[$count],$swo);
$treffer2 = $array[0];
$zhp = $zhp;
$ianzahl = $array[1];

}
if($jart == 2){
//Verteidigen
$treffer2 = 1;
$zhp = $zhp;
$dmg = 0;
}
if($jart == 1){
//Schaden normal
$nziel = jart2($sziel,$spieler[$count],$swo,$szwo);
if($nziel){
$sziel = $nziel[0];
$szwo = $nziel[1];
$zhp = $nziel[2];
$zidn = $nziel[3];
$zteam = $nziel[4];
$jtreffer = 1000;
}
if($wetter == "Regen"){
if($jelement == "Suiton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Katon"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Gewitter"){
if($jelement == "Raiton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Doton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Hitze"){
if($jelement == "Katon"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Fuuton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Sturm"){
if($jelement == "Fuuton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Raiton"){
$jdmg = $jdmg-0.05;
}
}
if($wetter == "Erdrutsch"){
if($jelement == "Doton"){
$jdmg = $jdmg+0.05;
}
if($jelement == "Suiton"){
$jdmg = $jdmg-0.05;
}
}
$array = jart1($jdmg,$jcdmg,$jtreffer,$jtyp,$sziel,$schadd,$szwo,$zhp,$spieler[$count],$swo);
$treffer2 = $array[0];
$zhp = $array[1];
$dmg = $array[2];
$cdmg = $array[3];
} //jutsuart 1 -> normaler schaden , nin/gen/tai , ein spieler
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
text,
dodge
FROM
jutsus
where id="'.$sattacke.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($treffer2 == 2){
$itext = 'uteam user</font> deaktiviert das sjutsu, das auf gteam gegner</font> liegt.';
}
if($treffer2 == 1){
$itext = $row['text'];
}
if($treffer2 == 0){
$itext = $row['dodge'];
}
}
$result->close(); $db->close();
$schakra = getwert($spieler[$count],$swo,"chakra","id");
if($jart != 15){
if($schadd != 0){
$schakra = $schakra-$schadd;
}
if($jchakra != 0&&$jchrweg == 1){
$schakra = $schakra-$jchakra;
}
if($schakra < 0){
$schakra = 0;
}
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE ".$swo." SET chakra ='$schakra' WHERE id = '".$spieler[$count]."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($zhp == 0){
if($jart != 11&&$jart != 14&&$jart != 12&&$jart != 9&&$jart != 6&&$jart != 5&&$jart != 3){
$tottext = 'gteam gegner</font> ist besiegt.<br>';
}
}
else{
if($jart != 11){
$tottext = '';
}
else{
$tarray = explode(";", trim($aoetote));
$tcount = 0;
while($tarray[$tcount] != ''){
$tarray2 = explode("@", trim($tarray[$tcount]));
$tname = getwert($tarray2[0],$tarray2[1],"name","id");
$tteam = getwert($tarray2[0],$tarray2[1],"team","id");

//Teamfarben
if($tteam == 1){
$tfarbe = "#0000ff";
}
if($tteam == 2){
$tfarbe = "#ff0000";
}
if($tteam == 3){
$tfarbe = "#00ff00";
}
if($tteam == 4){
$tfarbe = "#ffcc00";
}
if($tteam == 5){
$tfarbe = "#00e8b2";
}
if($tteam == 6){
$tfarbe = "#ff00ff";
}
if($tteam == 7){
$tfarbe = "#8B4513";
}
if($tteam == 8){
$tfarbe = "#5829ad";
}
if($tteam == 9){
$tfarbe = "#FF6EB4";
}
if($tteam == 10){
$tfarbe = "#FF7F00";
}
$tfarbe = '<font color="'.$tfarbe.'">';
$tottext = $tottext.''.$tfarbe.' '.$tname.'</font> ist besiegt.<br>';
$tcount++;
}
}
}
} //zhp != 0
else{ //zhp == 0 , gegner Tot
$itext = "uteam user</font> will gteam gegner</font> angreifen, gteam gegner</font> ist jedoch bereits besiegt.";
}
}
else{
if($swo == "npcs"){
$zidu = getwert($spieler[$count],$swo,"name","id");
}
else{
$zidu = $spieler[$count];
}
$itext = "uteam user</font> wurde gekickt , weil uteam user</font> keine Aktion getätigt hat.";
$sql="UPDATE ".$swo." SET hp ='0',kaktion ='Besiegt' WHERE id = '".$spieler[$count]."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
else{
$itext = "uteam user</font> hat aufgegeben.";
$sql="UPDATE ".$swo." SET hp ='0',kaktion ='Besiegt' WHERE id = '".$spieler[$count]."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$beides++;
if($beides == 2){
$beides = 0;
}
$text = logbearbeitung($sattacke,$spieler[$count],$swo,$sziel,$szwo,$itext,$tottext,$beides,$dmg,$ianzahl,$cdmg,$partner,$pwo);
if($text2 == ""){
$text2 = $text;
}
else{
$text2 = $text.' '.$text2;
}
}
} //Man selber ist lebend
$count++;
} //whileschleife , reihenfolge
$krunde = getwert($ukid,"fights","runde","id");
//?berpr?fe ob alle leben



//mache NPC aktionen , falls die ?berhaupt noch leben

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
hp,
team
FROM
charaktere
WHERE kampfid="'.$ukid.'" AND hp !="0"
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$tteam = 0;
$lebt = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($tteam == 0){
$tteam = $row['team'];
}
if($tteam != $row['team']){
$lebt = 1;
}
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
hp,
team,
besitzer
FROM
npcs
WHERE kampfid="'.$ukid.'" AND hp !="0" AND besitzer = "0"
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($tteam == 0){
$tteam = $row['team'];
}
if($tteam != $row['team']){
$lebt = 1;
}
}
$result->close(); $db->close();
$kart = getwert($ukid,"fights","art","id");

if($lebt == 0){
$teamg = $tteam;
$ende = getwert($ukid,"fights","ende","id");
if($ende == 0){
//Kampfende

if($kart != 'Spaß'){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kampfid,
ip,
name
FROM
charaktere
WHERE kampfid="'.$ukid.'"
ORDER BY
ip';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);
$ipuser = '';
$modlog = getwert(1,"game","modlog","id");
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($uip != $row['ip'])
{
$uip = $row['ip'];
$ipuser = $row['id'];
}
else{
$mtext = '<b>'.$zeit.'</b>;'.$ipuser.';hatte die selbe IP wie <a href="user.php?id='.$row['id'].'">'.$row['name'].'</a> in einem <a href="log.php?kid='.$ukid.'">'.$kart.'-Kampf</a>.';
if($modlog == ""){
$modlog = $mtext;
}
else{
$modlog = $mtext.'@'.$modlog;
}
}
}
$result->close(); $db->close();
$sql="UPDATE game SET modlog ='$modlog' LIMIT 1";
mysqli_query($con, $sql);
}
$sql="UPDATE fights SET  ende='1' WHERE id = '".$ukid."' Limit 1";
mysqli_query($con, $sql);
if($kart == "Eroberung"||$kart == "Bijuu"){
$krieghat = 0;
$sql="UPDATE krieg SET kampf ='0' WHERE kampf = '".$ukid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($kart == "Mission"){
$kmissi = getwert($ukid,"fights","mission","id");
}

if($kart == "NPC"){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
besitzer,
name
FROM
npcs
WHERE kampfid="'.$ukid.'" AND besitzer = "0" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$npcgegner = getwert($row['name'],"npc","id","name");
}
$result->close(); $db->close();
}

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
id,
shp,
schakra,
hp,
mhp,
chakra,
mchakra,
team,
name,
kbild,
mkr,
mwid,
mtmp,
mgnk,
mchrk,
mintl,
mission,
dorf,
kwo,
siege,
niederlagen,
quotient,
powerup
FROM
charaktere
WHERE kampfid="'.$ukid.'"
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$spielerende = "";
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false

if($spielerende == ""){
$tteam = $row['team'];
$spielerende = $row['id'];
}
else{
if($tteam != $row['team']){
$tteam = $row['team'];
$spielerende = $spielerende.' vs ';
$spielerende = $spielerende.$row['id'];

}
else{
$spielerende = $spielerende.' '.$row['id'];
}
}
$sql="UPDATE charaktere SET kido ='$ukid' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($row['powerup'] != ""){
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$hpinc = 0;
$chakrainc = 0;
while($pus[$pcount] != ""){
$puart = getwert($pus[$pcount],"jutsus","art","id");
if($puart == 6||$puart == 14){
$jdmg = getwert($pus[$pcount],"jutsus","dmg","id");
}
if($puart == 9){
$puitem = getwert($pus[$pcount],"jutsus","dmg","id");
$jdmg = getwert($puitem,"item","werte","name");
}
$pwerte = explode(";", trim($jdmg));
if($pwerte[0] != 0){
$hpinc = $hpinc+$pwerte[0];
}
if($pwerte[1] != 0){
$chakrainc = $chakrainc+$pwerte[1];
}

$pcount++;
}
}
if($row['shp'] != 0){
$sql="UPDATE charaktere SET  hp='".$row['shp']."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
if($hpinc != 0){
$hpadd = $row['hp'];
$uwertm = $row['mhp'];
$uwd = $uwertm*($hpinc/100);
$hpadd = $hpadd-$uwd;
if($hpadd < 0){
$hpadd = 0;
}
$sql="UPDATE charaktere SET  hp='".$hpadd."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
if($row['hp'] >= $row['mhp']){
$sql="UPDATE charaktere SET  hp='".$row['mhp']."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
if($row['schakra'] != 0){
$sql="UPDATE charaktere SET  chakra='".$row['schakra']."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
if($chakrainc != 0){
$chradd = $row['chakra'];
$uwertm = $row['mchakra'];
$uwd = $uwertm*($chakrainc/100);
$chradd = $chradd-$uwd;
if($chradd < 0){
$chradd = 0;
}
$sql="UPDATE charaktere SET  chakra='".$chradd."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
if($row['chakra'] >= $row['mchakra']){
$sql="UPDATE charaktere SET  chakra='".$row['mchakra']."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
if($teamg != 0){
if($kart == "NPC"){
if($row['team'] == $teamg){
$sql="UPDATE charaktere SET  npcwin='".$npcgegner."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($kart == "Eroberung"&&$krieghat == 0||$kart == 'Bijuu'&&$krieghat == 0){
$kwo = $row['kwo'];
if($row['team'] == $teamg){
if($row['dorf'] == 'kein'){
$nerobert = '';
$windorf = 'kein';
}
else{
$nerobert = $row['dorf'];
$windorf = $row['dorf'];
}
if($kart == 'Eroberung'){
$rdorf = getwert($row['kwo'],"krieg","dorf","id");
if($rdorf == 0){
$sql="UPDATE krieg SET erobert ='$nerobert' WHERE id = '".$row['kwo']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
$krieghat = 1;
}

}
if($kart == "Wertung"){
if($row['team'] == $teamg){
$siege = $row['siege']+1;
if($row['niederlagen'] != 0){
$quotient = $siege/$row['niederlagen'];
}
else{
$quotient = $siege;
}
$sql="UPDATE charaktere SET siege ='$siege' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$niederlagen = $row['niederlagen']+1;
if($row['siege'] != 0){
$quotient = $row['siege']/$niederlagen;
}
else{
$quotient = 0;
}
$sql="UPDATE charaktere SET niederlagen ='$niederlagen' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$sql="UPDATE charaktere SET quotient ='$quotient' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

}
if($kart == "Turnier"){
if($row['team'] == $teamg){
mysqli_close($con);
turnierset($row['id']);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
}
}
if($row['team'] == $teamg&&$kart == "Mission"&&$row['mission'] == $kmissi){
mysqli_close($con);
mission($row['id']);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
}
if($row['team'] == $teamg&&$kart == "Reise"){
mysqli_close($con);
reise($row['id']);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
}
if($row['team'] == $teamg){
$sql="UPDATE charaktere SET kwas ='1' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$sql="UPDATE charaktere SET kwas ='2' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
else{
$sql="UPDATE charaktere SET kwas ='3' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

}
$sql="UPDATE charaktere SET
shp='0',
schakra='0',
kampfid='0',
kchadd='0',
kzwo='',
kziel='',
kkbild='".$row['kbild']."',
kname='".$row['name']."',
summonused='',
powerup='',
debuff='',
kaktion='',
kombipartner='0',
kombipartnerw='',
chrk='".$row['mchrk']."',
intl='".$row['mintl']."',
gnk='".$row['mgnk']."',
tmp='".$row['mtmp']."',
wid='".$row['mwid']."',
kr='".$row['mkr']."',
ktargetwo='',
lchakra='0',
ktarget='0',
team='0',
itempus='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE items SET  kbenutzt='0' WHERE besitzer = '".$row['id']."' AND kbenutzt != '0'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE summon SET  deaktiv='0' WHERE besitzer = '".$row['id']."' AND deaktiv != '0'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close(); $db->close();
if($kart == 'Eroberung'||$kart == 'Bijuu'){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
if($kart == 'Bijuu'){
$sql = 'SELECT
id,
dorf,
kwo,
kido
FROM
charaktere
WHERE kwo="'.$kwo.'" AND dorf !="'.$windorf.'" AND kido="'.$ukid.'"';
}
else{
$sql = 'SELECT
id,
dorf,
kwo
FROM
charaktere
WHERE kwo="'.$kwo.'" AND dorf !="'.$windorf.'"';
}
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$wally = getwert($windorf,"orte","ally","id");
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$winally = explode(';',trim($wally));
$w = 0;
$wally = false;
while($winally[$w] != ''){
if($winally[$w] == $row['dorf']){
$wally = true;
}
$w++;
}
if(!$wally){
$rorte = getwert($row['kwo'],"krieg","rorte","id");
$r = 0;
$geht = true;
$ro = explode(';',trim($rorte));
while($ro[$r] != ''&&$geht){
$ally = false;
$rero = getwert($ro[$r],"krieg","erobert","id");
$rally = getwert($rero,"orte","ally","id");
$ra = explode(';',trim($rally));
$rac = 0;
while($ra[$rac] != ''){
if($ra[$rac] == $row['dorf']){
$ally = true;
}
$rac++;
}
if($rero == $row['dorf']||$row['dorf'] == 'kein'&&$rero == 0||$ally == true){
$geht = false;
$dwo = $ro[$r];
}
$r++;
}
if($geht){
if($row['dorf'] != 'kein'){
$dwo = getwert($row['dorf'],"krieg","id","dorf");
}
else{
$dwo = getwert(13,"krieg","id","dorf");
}
}
$sql="UPDATE charaktere SET kwo ='$dwo',kriegaktion='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
$result->close();
$db->close();
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
id,
name,
team,
besitzer,
npcid,
hp,
mhp,
chakra,
mchakra
FROM
npcs
WHERE kampfid="'.$ukid.'"
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['besitzer'] == 0){
if($spielerende == ""){
$tteam = $row['team'];
$spielerende = $row['id'];
}
else{
if($tteam != $row['team']){
$tteam = $row['team'];
$spielerende = $spielerende.' vs ';
$spielerende = $spielerende.$row['name'];

}
else{
$spielerende = $spielerende.' '.$row['name'];
}
}
}
else{
if($kart != 'NPC'&&$kart != 'Wertung'&&$kart != "Spaß"&&$kart != "Turnier"&&$row['npcid'] != "0"){
if($row['hp'] >= $row['mhp']){
$sql="UPDATE summon SET  hp='".$row['mhp']."' WHERE id = '".$row['npcid']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$sql="UPDATE summon SET  hp='".$row['hp']."' WHERE id = '".$row['npcid']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($row['chakra'] >= $row['mchakra']){
$sql="UPDATE summon SET  chakra='".$row['mchakra']."' WHERE id = '".$row['npcid']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$sql="UPDATE summon SET  chakra='".$row['chakra']."' WHERE id = '".$row['npcid']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
$sql="DELETE FROM npcs WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close(); $db->close();

$sql="UPDATE fights SET  spieler='$spielerende' WHERE id = '".$ukid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
} //nur ein team lebt

else{
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
id,
name,
kbild,
team,
powerup,
mhp,
hp,
mchakra,
chakra,
mkr,
kr,
mtmp,
tmp,
mintl,
intl,
mchrk,
chrk,
mgnk,
gnk,
mwid,
wid,
dstats,
debuff,
kaktion
FROM
charaktere
WHERE kampfid="'.$ukid.'"
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['hp'] != 0){
$hpadd = $row['hp'];
$chradd = $row['chakra'];
$kradd = $row['kr'];
$tmpadd = $row['tmp'];
$intladd = $row['intl'];
$gnkadd = $row['gnk'];
$chrkadd = $row['chrk'];
$widadd = $row['wid'];
if($row['dstats'] != ""){
$dstats = explode(";", trim($row['dstats']));
if($dstats[0] != 0){
$kradd = $kradd+$dstats[0];
}
if($dstats[1] != 0){
$tmpadd = $tmpadd+$dstats[1];
}
if($dstats[2] != 0){
$intladd = $intladd+$dstats[2];
}
if($dstats[3] != 0){
$gnkadd = $gnkadd+$dstats[3];
}
if($dstats[4] != 0){
$chrkadd = $chrkadd+$dstats[4];
}
if($dstats[5] != 0){
$widadd = $widadd+$dstats[5];
}

$sql="UPDATE charaktere SET  dstats='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($row['powerup'] != ""){
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$hpinc = 0;
$chakrainc = 0;
$krinc = 0;
$tmpinc = 0;
$intlinc = 0;
$gnkinc = 0;
$chrkinc = 0;
$widinc = 0;
$pukosten = 0;
while($pus[$pcount] != ""){
$pkost = getwert($pus[$pcount],"jutsus","chakra","id");
$pukosten = $pukosten+$pkost;
$puart = getwert($pus[$pcount],"jutsus","art","id");
if($puart == 6||$puart == 14){
$jdmg = getwert($pus[$pcount],"jutsus","dmg","id");
}
if($puart == 9){
$puitem = getwert($pus[$pcount],"jutsus","dmg","id");
$jdmg = getwert($puitem,"item","werte","name");
}
$pwerte = explode(";", trim($jdmg));
if($pwerte[0] != 0){
$hpinc = $hpinc+$pwerte[0];
}
if($pwerte[1] != 0){
$chakrainc = $chakrainc+$pwerte[1];
}
if($pwerte[2] != 0){
$krinc = $krinc+$pwerte[2];
}
if($pwerte[3] != 0){
$tmpinc = $tmpinc+$pwerte[3];
}
if($pwerte[4] != 0){
$intlinc = $intlinc+$pwerte[4];
}
if($pwerte[5] != 0){
$gnkinc = $gnkinc+$pwerte[5];
}
if($pwerte[6] != 0){
$chrkinc = $chrkinc+$pwerte[6];
}
if($pwerte[7] != 0){
$widinc = $widinc+$pwerte[7];
}

$pcount++;
}
if($row['chakra'] == 0&&$pukosten != 0){
if($hpinc != 0){
$uwertm = $row['mhp'];
$uwd = $uwertm*($hpinc/100);
$hpadd = $hpadd-$uwd;
if($hpadd < 1){
$hpadd = 1;
}
}
if($chakrainc != 0){
$uwertm = $row['mchakra'];
$uwd = $uwertm*($chakrainc/100);
$chradd = $chradd-$uwd;
}
if($krinc != 0){
$uwertm = $row['mkr'];
$uwd = $uwertm*($krinc/100);
$kradd = $kradd-$uwd;
}
if($tmpinc != 0){
$uwertm = $row['mtmp'];
$uwd = $uwertm*($tmpinc/100);
$tmpadd = $tmpadd-$uwd;
}
if($intlinc != 0){
$uwertm = $row['mintl'];
$uwd = $uwertm*($intlinc/100);
$intladd = $intladd-$uwd;
}
if($gnkinc != 0){
$uwertm = $row['mgnk'];
$uwd = $uwertm*($gnkinc/100);
$gnkadd = $gnkadd-$uwd;
}
if($chrkinc != 0){
$uwertm = $row['mchrk'];
$uwd = $uwertm*($chrkinc/100);
$chrkadd = $chrkadd-$uwd;
}
if($widinc != 0){
$uwertm = $row['mwid'];
$uwd = $uwertm*($widinc/100);
$widadd = $widadd-$uwd;
}

$sql="UPDATE charaktere SET  powerup='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE summon SET  deaktiv='0' WHERE besitzer = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}



if($row['kaktion'] != 'Zufall'){
$sql="UPDATE charaktere SET  kaktion='',lkaktion ='$zeit',kombipartner='0',kombipartnerw='0' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($row['debuff'] != ""){
$debuffs = explode("@", trim($row['debuff']));
$dcount = 0;
$ndebuffs = "";
while($debuffs[$dcount] != ""){
$debuffs2 = explode(";", trim($debuffs[$dcount]));
$dcchr = getwert($debuffs2[1],$debuffs2[2],"chakra","id");
$dchp = getwert($debuffs2[1],$debuffs2[2],"hp","id");
if($dcchr != 0&&$dchp != 0){
if($ndebuffs == ""){
$ndebuffs = $debuffs2[0].';'.$debuffs2[1].';'.$debuffs2[2];
}
else{
$ndebuffs = $ndebuffs.'@'.$debuffs2[0].';'.$debuffs2[1].';'.$debuffs2[2];
}
}
$dcount++;
}
$sql="UPDATE charaktere SET  debuff='$ndebuffs' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($ndebuffs != ""){
$debuffs = explode("@", trim($ndebuffs));
$krinc = 0;
$tmpinc = 0;
$intlinc = 0;
$gnkinc = 0;
$chrkinc = 0;
$widinc = 0;
$dcount = 0;
while($debuffs[$dcount] != ""){
$debuffs2 = explode(";", trim($debuffs[$dcount]));
$djutsu = $debuffs2[0];
$dcaster = $debuffs2[1];
$dwo = $debuffs2[2];
$djart = getwert($djutsu,"jutsus","typ","id");
$dwerte = getwert($djutsu,"jutsus","dmg","id");
$dwert = explode(";", trim($dwerte));
if($djart == "Taijutsu"){
//Kraft
$datk = getwert($dcaster,$dwo,"kr","id");
}
if($djart == "Genjutsu"){
//Intelligenz
$datk = getwert($dcaster,$dwo,"intl","id");
}
if($djart == "Ninjutsu"){
//Chakrakontrolle
$datk = getwert($dcaster,$dwo,"chrk","id");
}
if($dwert[0] != 0){
$krinc = $krinc+$dwert[0];
}
if($dwert[1] != 0){
$tmpinc = $tmpinc+$dwert[1];
}
if($dwert[2] != 0){
$intlinc = $intlinc+$dwert[2];
}
if($dwert[3] != 0){
$gnkinc = $gnkinc+$dwert[3];
}
if($dwert[4] != 0){
$chrkinc = $chrkinc+$dwert[4];
}
if($dwert[5] != 0){
$widinc = $widinc+$dwert[5];
}


$dcount++;
}
$krsteig = 0;
$tmpsteig = 0;
$intlsteig = 0;
$gnksteig = 0;
$chrksteig = 0;
$widsteig = 0;
$dgeht = 0;
$dsteig = 0;
if($krinc != 0){
//Angriff * (Multi/100) - Widerstand * (Multi/200) = Debuff
$dsteig = round($datk*($krinc/100))-round($widadd*($krinc/200));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $kradd;
$kradd = $kradd-$dsteig;
if($kradd <= 1){
$kradd = 1;
}
$awert = $awert-$kradd;
$krsteig = $krsteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($tmpinc != 0){
$dsteig = round($datk*($tmpinc/100))-round($widadd*($tmpinc/200));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $tmpadd;
$tmpadd = $tmpadd-$dsteig;
if($tmpadd <= 1){
$tmpadd = 1;
}
$awert = $awert-$tmpadd;
$tmpsteig = $tmpsteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($intlinc != 0){
$dsteig = round($datk*($intlinc/100))-round($widadd*($intlinc/200));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $intladd;
$intladd = $intladd-$dsteig;
if($intladd <= 1){
$intladd = 1;
}
$awert = $awert-$intladd;
$intlsteig = $intlsteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($gnkinc != 0){
$dsteig = round($datk*($gnkinc/100))-round($widadd*($gnkinc/200));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $gnkadd;
$gnkadd = $gnkadd-$dsteig;
if($gnkadd <= 1){
$gnkadd = 1;
}
$awert = $awert-$gnkadd;
$gnksteig = $gnksteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($chrkinc != 0){
$dsteig = round($datk*($chrkinc/100))-round($widadd*($chrkinc/200));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $chrkadd;
$chrkadd = $chrkadd-$dsteig;
if($chrkadd <= 1){
$chrkadd = 1;
}
$awert = $awert-$chrkadd;
$chrksteig = $chrksteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($widinc != 0){
$dsteig = round($datk*($widinc/100))-round($widadd*($widinc/200));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $widadd;
$widadd = $widadd-$dsteig;
if($widadd <= 1){
$widadd = 1;
}
$awert = $awert-$widadd;
$widsteig = $widsteig+$awert;
$dgeht = 1;
}
if($dgeht == 1){
$ndstats = $krsteig.';'.$tmpsteig.';'.$intlsteig.';'.$gnksteig.';'.$chrksteig.';'.$widsteig;
$sql="UPDATE charaktere SET  dstats='$ndstats' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
if($hpadd != $row['hp']){
if($hpadd <= 0){
$hpadd = 0;
}
$sql="UPDATE charaktere SET  hp='$hpadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($chradd != $row['chakra']){
if($chradd <= 0){
$chradd = 0;
}
$sql="UPDATE charaktere SET  chakra='$chradd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($kradd != $row['kr']){
if($kradd <= 1){
$kradd = 1;
}
$sql="UPDATE charaktere SET  kr='$kradd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($tmpadd != $row['tmp']){
if($tmpadd <= 1){
$tmpadd = 1;
}
$sql="UPDATE charaktere SET  tmp='$tmpadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($intladd != $row['intl']){
if($intladd <= 1){
$intladd = 1;
}
$sql="UPDATE charaktere SET  intl='$intladd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($gnkadd != $row['gnk']){
if($gnkadd <= 1){
$gnkadd = 1;
}
$sql="UPDATE charaktere SET  gnk='$gnkadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($chrkadd != $row['chrk']){
if($chrkadd <= 1){
$chrkadd = 1;
}
$sql="UPDATE charaktere SET  chrk='$chrkadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($widadd != $row['wid']){
if($widadd <= 1){
$widadd = 1;
}
$sql="UPDATE charaktere SET  wid='$widadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
else{
if($row['powerup'] != ""){
$sql="UPDATE charaktere SET  powerup='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($row['debuff'] != ""){
$sql="UPDATE charaktere SET  debuff='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$sql="UPDATE charaktere SET  kaktion='Besiegt',kname='".$row['name']."',kkbild='".$row['kbild']."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

}
if($row['kaktion'] != 'Zufall')
{
$sql="UPDATE charaktere SET  kziel='',kzwo='',kchadd='0' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}

}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
id,
team,
besitzer,
bwo,
npcid,
name,
kbild,
powerup,
mhp,
hp,
mchakra,
chakra,
mkr,
kr,
mtmp,
tmp,
mintl,
intl,
mchrk,
chrk,
mgnk,
gnk,
mwid,
wid,
debuff,
dstats,
gradgerufen,
kaktion
FROM
npcs
WHERE kampfid="'.$ukid.'"
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['hp'] == 0){
if($row['besitzer'] == 0){
if($row['powerup'] != ""){
$sql="UPDATE npcs SET  powerup='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($row['debuff'] != ""){
$sql="UPDATE npcs SET  debuff='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}


$sql="UPDATE npcs SET  kaktion='Besiegt',kname='".$row['name']."',kkbild='".$row['kbild']."' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$sql="DELETE FROM npcs WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($kart != 'NPC'&&$kart != 'Wertung'&&$kart != "Spaß"&&$kart != "Turnier"&&$row['npcid'] != 0){
$sql="UPDATE summon SET  hp='".$row['hp']."',chakra='".$row['chakra']."' WHERE id = '".$row['npcid']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
else{
$hpadd = $row['hp'];
$chradd = $row['chakra'];
$kradd = $row['kr'];
$tmpadd = $row['tmp'];
$intladd = $row['intl'];
$gnkadd = $row['gnk'];
$chrkadd = $row['chrk'];
$widadd = $row['wid'];
if($row['dstats'] != ""){
$dstats = explode(";", trim($row['dstats']));
if($dstats[0] != 0){
$kradd = $kradd+$dstats[0];
}
if($dstats[1] != 0){
$tmpadd = $tmpadd+$dstats[1];
}
if($dstats[2] != 0){
$intladd = $intladd+$dstats[2];
}
if($dstats[3] != 0){
$gnkadd = $gnkadd+$dstats[3];
}
if($dstats[4] != 0){
$chrkadd = $chrkadd+$dstats[4];
}
if($dstats[5] != 0){
$widadd = $widadd+$dstats[5];
}
}
if($row['chakra'] == 0){
if($row['powerup'] != ""){
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$hpinc = 0;
$chakrainc = 0;
$krinc = 0;
$tmpinc = 0;
$intlinc = 0;
$gnkinc = 0;
$chrkinc = 0;
$widinc = 0;
while($pus[$pcount] != ""){
$puart = getwert($pus[$pcount],"jutsus","art","id");
if($puart == 6||$puart == 14){
$jdmg = getwert($pus[$pcount],"jutsus","dmg","id");
}
if($puart == 9){
$puitem = getwert($pus[$pcount],"jutsus","dmg","id");
$jdmg = getwert($puitem,"item","werte","name");
}
$pwerte = explode(";", trim($jdmg));
if($pwerte[0] != 0){
$hpinc = $hpinc+$pwerte[0];
}
if($pwerte[1] != 0){
$chakrainc = $chakrainc+$pwerte[1];
}
if($pwerte[2] != 0){
$krinc = $krinc+$pwerte[2];
}
if($pwerte[3] != 0){
$tmpinc = $tmpinc+$pwerte[3];
}
if($pwerte[4] != 0){
$intlinc = $intlinc+$pwerte[4];
}
if($pwerte[5] != 0){
$gnkinc = $gnkinc+$pwerte[5];
}
if($pwerte[6] != 0){
$chrkinc = $chrkinc+$pwerte[6];
}
if($pwerte[7] != 0){
$widinc = $widinc+$pwerte[7];
}

$pcount++;
}
if($hpinc != 0){
$uwertm = $row['mhp'];
$uwd = $uwertm*($hpinc/100);
$hpadd = $hpadd-$uwd;
if($hpadd < 1){
$hpadd = 1;
}
}
if($chakrainc != 0){
$uwertm = $row['mchakra'];
$uwd = $uwertm*($chakrainc/100);
$chradd = $chradd-$uwd;
}
if($krinc != 0){
$uwertm = $row['mkr'];
$uwd = $uwertm*($krinc/100);
$kradd = $kradd-$uwd;
}
if($tmpinc != 0){
$uwertm = $row['mtmp'];
$uwd = $uwertm*($tmpinc/100);
$tmpadd = $tmpadd-$uwd;
}
if($intlinc != 0){
$uwertm = $row['mintl'];
$uwd = $uwertm*($intlinc/100);
$intladd = $intladd-$uwd;
}
if($gnkinc != 0){
$uwertm = $row['mgnk'];
$uwd = $uwertm*($gnkinc/100);
$gnkadd = $gnkadd-$uwd;
}
if($chrkinc != 0){
$uwertm = $row['mchrk'];
$uwd = $uwertm*($chrkinc/100);
$chrkadd = $chrkadd-$uwd;
}
if($widinc != 0){
$uwertm = $row['mwid'];
$uwd = $uwertm*($widinc/100);
$widadd = $widadd-$uwd;
}

$sql="UPDATE npcs SET  powerup='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}


}
if($row['debuff'] != ""){
$debuffs = explode("@", trim($row['debuff']));
$dcount = 0;
$ndebuffs = "";
while($debuffs[$dcount] != ""){
$debuffs2 = explode(";", trim($debuffs[$dcount]));
$dcchr = getwert($debuffs2[1],$debuffs2[2],"chakra","id");
$dchp = getwert($debuffs2[1],$debuffs2[2],"hp","id");
if($dcchr != 0&&$dchp != 0){
if($ndebuffs == ""){
$ndebuffs = $debuffs2[0].';'.$debuffs2[1].';'.$debuffs2[2];
}
else{
$ndebuffs = $ndebuffs.'@'.$debuffs2[0].';'.$debuffs2[1].';'.$debuffs2[2];
}
}
$dcount++;
}
$sql="UPDATE npcs SET  debuff='$ndebuffs' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($ndebuffs != ""){
$debuffs = explode("@", trim($ndebuffs));
$krinc = 0;
$tmpinc = 0;
$intlinc = 0;
$gnkinc = 0;
$chrkinc = 0;
$widinc = 0;
$dcount = 0;
while($debuffs[$dcount] != ""){
$debuffs2 = explode(";", trim($debuffs[$dcount]));
$djutsu = $debuffs2[0];
$dcaster = $debuffs2[1];
$dwo = $debuffs2[2];
$djart = getwert($djutsu,"jutsus","typ","id");
$dwerte = getwert($djutsu,"jutsus","dmg","id");
$dwert = explode(";", trim($dwerte));
if($djart == "Taijutsu"){
//Kraft
$datk = getwert($dcaster,$dwo,"kr","id");
}
if($djart == "Genjutsu"){
//Intelligenz
$datk = getwert($dcaster,$dwo,"intl","id");
}
if($djart == "Ninjutsu"){
//Chakrakontrolle
$datk = getwert($dcaster,$dwo,"chrk","id");
}
if($dwert[0] != 0){
$krinc = $krinc+$dwert[0];
}
if($dwert[1] != 0){
$tmpinc = $tmpinc+$dwert[1];
}
if($dwert[2] != 0){
$intlinc = $intlinc+$dwert[2];
}
if($dwert[3] != 0){
$gnkinc = $gnkinc+$dwert[3];
}
if($dwert[4] != 0){
$chrkinc = $chrkinc+$dwert[4];
}
if($dwert[5] != 0){
$widinc = $widinc+$dwert[5];
}


$dcount++;
}
$krsteig = 0;
$tmpsteig = 0;
$intlsteig = 0;
$gnksteig = 0;
$chrksteig = 0;
$widsteig = 0;
$dgeht = 0;
$dsteig = 0;
if($krinc != 0){
$dsteig = round(($datk-$widadd)*($krinc/100));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $kradd;
$kradd = $kradd-$dsteig;
if($kradd <= 1){
$kradd = 1;
}
$awert = $awert-$kradd;
$krsteig = $krsteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($tmpinc != 0){
$dsteig = round(($datk-$widadd)*($tmpinc/100));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $tmpadd;
$tmpadd = $tmpadd-$dsteig;
if($tmpadd <= 1){
$tmpadd = 1;
}
$awert = $awert-$tmpadd;
$tmpsteig = $tmpsteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($intlinc != 0){
$dsteig = round(($datk-$widadd)*($intlinc/100));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $intladd;
$intladd = $intladd-$dsteig;
if($intladd <= 1){
$intladd = 1;
}
$awert = $awert-$intladd;
$intlsteig = $intlsteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($gnkinc != 0){
$dsteig = round(($datk-$widadd)*($gnkinc/100));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $gnkadd;
$gnkadd = $gnkadd-$dsteig;
if($gnkadd <= 1){
$gnkadd = 1;
}
$awert = $awert-$gnkadd;
$gnksteig = $gnksteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($chrkinc != 0){
$dsteig = round(($datk-$widadd)*($chrkinc/100));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $chrkadd;
$chrkadd = $chrkadd-$dsteig;
if($chrkadd <= 1){
$chrkadd = 1;
}
$awert = $awert-$chrkadd;
$chrksteig = $chrksteig+$awert;
$dgeht = 1;
}
$dsteig = 0;
if($widinc != 0){
$dsteig = round(($datk-$widadd)*($widinc/100));
if($dsteig <= 10){
$dsteig = 10;
}
$awert = $widadd;
$widadd = $widadd-$dsteig;
if($widadd <= 1){
$widadd = 1;
}
$awert = $awert-$widadd;
$widsteig = $widsteig+$awert;
$dgeht = 1;
}
if($dgeht == 1){
$ndstats = $krsteig.';'.$tmpsteig.';'.$intlsteig.';'.$gnksteig.';'.$chrksteig.';'.$widsteig;
$sql="UPDATE npcs SET  dstats='$ndstats' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
if($hpadd != $row['hp']){
if($hpadd <= 0){
$hpadd = 0;
}
$sql="UPDATE npcs SET  hp='$hpadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($chradd != $row['chakra']){
if($chradd <= 0){
$chradd = 0;
}
$sql="UPDATE npcs SET  chakra='$chradd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($kradd != $row['kr']){
if($kradd <= 1){
$kradd = 1;
}
$sql="UPDATE npcs SET  kr='$kradd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($tmpadd != $row['tmp']){
if($tmpadd <= 1){
$tmpadd = 1;
}
$sql="UPDATE npcs SET  tmp='$tmpadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($intladd != $row['intl']){
if($intladd <= 1){
$intladd = 1;
}
$sql="UPDATE npcs SET  intl='$intladd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($gnkadd != $row['gnk']){
if($gnkadd <= 1){
$gnkadd = 1;
}
$sql="UPDATE npcs SET  gnk='$gnkadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($chrkadd != $row['chrk']){
if($chrkadd <= 1){
$chrkadd = 1;
}
$sql="UPDATE npcs SET  chrk='$chrkadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($widadd != $row['wid']){
if($widadd <= 1){
$widadd = 1;
}
$sql="UPDATE npcs SET  wid='$widadd' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($row['gradgerufen'] == 1){
$sql="UPDATE npcs SET gradgerufen='0' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($row['besitzer'] != 0){
$bhp = getwert($row['besitzer'],$row['bwo'],"hp","id");
if($bhp != 0){
if($row['bwo'] == "charaktere"){
if($row['kaktion'] != 'Zufall'){
$sql="UPDATE npcs SET kchadd='0',kaktion='',kziel='',kzwo='',kombipartner='0',kombipartnerw='0' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
else{
$sql="DELETE FROM npcs WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($kart != 'NPC'&&$kart != 'Wertung'&&$kart != "Spaß"&&$row['npcid'] != 0){
$sql="UPDATE npc SET  hp='".$row['hp']."',chakra='".$row['chakra']."' WHERE id = '".$row['npcid']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
}


}
$result->close(); $db->close();
} //zwei teams lebt noch
 //schreibe Runde dazu
$krunde = getwert($ukid,"fights","runde","id");
$klog = getwert($ukid,"fights","log","id");
if($lebt == 1){
$text2 = '<center><h2>Runde '.$krunde.'</h2>'.$text2.'</center>';
}
else{
if($teamg == 1){
$farbe = '<font color="#0000ff">';
}
if($teamg == 2){
$farbe = '<font color="#ff0000">';
}
if($teamg == 3){
$farbe = '<font color="#00ff00">';
}
if($teamg == 4){
$farbe = '<font color="#ffcc00">';
}
if($teamg == 5){
$farbe = '<font color="#00e8b2">';
}
if($teamg == 6){
$farbe = '<font color="#ff00ff">';
}
if($teamg == 7){
$farbe ='<font color="#8B4513">';
}
if($teamg == 8){
$farbe = '<font color="#5829ad">';
}
if($teamg == 9){
$farbe ='<font color="#FF6EB4">';
}
if($teamg == 10){
$farbe = '<font color="#FF7F00">';
}
if($teamg != 0){
$text3 = $farbe.' Team '.$teamg.'</font> hat gewonnen!';
}
else{
$text3 = 'Unentschieden!';

}
$text2 = '<center><h2>Runde '.$krunde.'</h2>'.$text3.'<br>'.$text2.'</center>';
}
$krunde = $krunde+1;
//speichere Log
if($klog == ""){
$klog = $text2;
}
else{
$klog = $text2.' '.$klog;
}
$sql="UPDATE fights SET  runde='$krunde',log='$klog' WHERE id = '".$ukid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

} //alle spieler haben eine aktion gemacht
mysqli_close($con);
}
}
function reihenfolge($kid,$versteckt){
include 'serverdaten.php';
$count = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kampfid,
hp,
tmp,
kaktion
FROM
charaktere
WHERE kampfid="'.$kid.'" AND hp != "0"
ORDER BY
tmp DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$jart = getwert($row['kaktion'],"jutsus","art","id");
if($jart == 13){
$spieler[$count] = $row['id'];
$count2 = $count+$versteckt;
$spieler[$count2] = "charaktere";
$count++;
}
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kampfid,
hp,
tmp,
kaktion
FROM
npcs
WHERE kampfid="'.$kid.'" AND hp != "0"
ORDER BY
tmp DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$jart = getwert($row['kaktion'],"jutsus","art","id");
if($jart == 13){
$spieler[$count] = $row['id'];
$count2 = $count+$versteckt;
$spieler[$count2] = "npcs";
$count++;
}
}
$result->close(); $db->close();
//Zuerst die Jutsus die jart == 0 , also individuell sind
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kampfid,
hp,
tmp,
kaktion
FROM
charaktere
WHERE kampfid="'.$kid.'" AND hp != "0"
ORDER BY
tmp DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$jart = getwert($row['kaktion'],"jutsus","art","id");
if($jart == 2||$jart == 6||$jart == 9||$jart == 10||$jart == 12||$jart == 14){
$spieler[$count] = $row['id'];
$count2 = $count+$versteckt;
$spieler[$count2] = "charaktere";
$count++;
}
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kampfid,
hp,
tmp,
kaktion
FROM
npcs
WHERE kampfid="'.$kid.'" AND hp != "0"
ORDER BY
tmp DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$jart = getwert($row['kaktion'],"jutsus","art","id");
if($jart == 2||$jart == 6||$jart == 9||$jart == 10||$jart == 12||$jart == 14){
$spieler[$count] = $row['id'];
$count2 = $count+$versteckt;
$spieler[$count2] = "npcs";
$count++;
}
}
$result->close(); $db->close();
//Individuelle jutsus zuende
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}

$sql = 'SELECT
id,
kampfid,
hp,
tmp,
kaktion
FROM
charaktere
WHERE kampfid="'.$kid.'" AND hp != "0"
ORDER BY
tmp DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$jart = getwert($row['kaktion'],"jutsus","art","id");
if($jart != 2&&$jart != 6&&$jart != 9&&$jart != 10&&$jart != 12&&$jart != 13&&$jart != 14){
$spieler[$count] = $row['id'];
$count2 = $count+$versteckt;
$spieler[$count2] = "charaktere";
$count++;
}
}
$result->close(); $db->close();


$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kampfid,
hp,
tmp,
kaktion
FROM
npcs
WHERE kampfid="'.$kid.'" AND hp != "0"
ORDER BY
tmp DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$jart = getwert($row['kaktion'],"jutsus","art","id");
if($jart != 2&&$jart != 6&&$jart != 9&&$jart != 10&&$jart != 12&&$jart != 13&&$jart != 14){
$spieler[$count] = $row['id'];
$count2 = $count+$versteckt;
$spieler[$count2] = "npcs";
$count++;
}
}
$result->close(); $db->close();

return $spieler;
}

?>