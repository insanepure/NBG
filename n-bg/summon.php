<?php
include 'inc/incoben.php';
if(logged_in()){
$uid = getwert(session_id(),"charaktere","id","session");
$uclan = getwert(session_id(),"charaktere","clan","session");
$ukid = getwert(session_id(),"charaktere","kampfid","session");
$aktion = $_GET['aktion'];
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");
$array = explode(";", trim($ujutsus));
$count = 0;
$edo = 0;
while($array[$count] != ''){
if($array[$count] == 406){
$edo = 1;
}
$count++;
}
if($ukid == 0){
if($uclan == "inuzuka"||$uclan == "jiongu"||$uclan == 'kugutsu'||$uclan == 'admin'||$uclan == 'sakon'||$edo == 1){
$summon = $_GET['summon'];
if($summon != ""&&is_numeric($summon)){
$sbesitzer = getwert($summon,"summon","besitzer","id");
if($sbesitzer == $uid){
if($aktion == "stats"){
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
$ustats = getwert($summon,"summon","statspunkte","id");
$werte = $kraft+$wid+$int+$chrk+$tmp+$gnk+$hp+$chakra;
if($werte <= $ustats){
$ustats = $ustats-$werte;
if($uclan == 'kugutsu'||$edo == 1){
$sname = getwert($summon,"summon","name","id");
$nname = getwert($summon,"npc","name","name");
if($nname == ''){
$maxkr = 6000;
$maxhp = 100000;
$maxchakra = 75000;
$maxwid = 7500;
$maxtmp = 7500;
$maxintl = 6000;
$maxchrk = 6000;
$maxgnk = 7500;
}
else{
$maxkr = 10000;
$maxhp = 100000;
$maxchakra = 100000;
$maxwid = 10000;
$maxtmp = 10000;
$maxintl = 10000;
$maxchrk = 10000;
$maxgnk = 10000;
}
}
else{
$maxkr = 10000;
$maxhp = 100000;
$maxchakra = 100000;
$maxwid = 10000;
$maxtmp = 10000;
$maxintl = 10000;
$maxchrk = 10000;
$maxgnk = 10000;
}
$mwert = $maxkr+$maxhp+$maxchakra+$maxwid+$maxtmp+$maxchrk+$maxintl;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($chakra != 0){
$uwert = getwert($summon,"summon","mchakra","id");
$uwert2 = getwert($summon,"summon","chakra","id");
$nwert = ($chakra*10)+$uwert;
if($nwert > $maxchakra){
$ustats = $ustats+(($nwert-$maxchakra)/10);
$nwert = $maxchakra;
}
$nplus = $nwert-$uwert;
$nwert2 = $uwert2+$nplus;
if($nwert2 > $maxchakra){
$nwert2 = $maxchakra;
}
$sql="UPDATE summon SET mchakra ='$nwert',chakra ='$nwert2' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($hp != 0){
$uwert = getwert($summon,"summon","mhp","id");
$uwert2 = getwert($summon,"summon","hp","id");
$nwert = ($hp*10)+$uwert;
if($nwert > $maxhp){
$ustats = $ustats+(($nwert-$maxhp)/10);
$nwert = $maxhp;
}
$nplus = $nwert-$uwert;
$nwert2 = $uwert2+$nplus;
if($nwert2 > $maxhp){
$nwert2 = $maxhp;
}
$sql="UPDATE summon SET mhp ='$nwert',hp ='$nwert2' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($kraft != 0){
$uwert = getwert($summon,"summon","kr","id");
$nwert = $kraft+$uwert;
if($nwert > $maxkr){
$ustats = $ustats+($nwert-$maxkr);
$nwert = $maxkr;
}
$sql="UPDATE summon SET kr ='$nwert' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($wid != 0){
$uwert = getwert($summon,"summon","wid","id");
$nwert = $wid+$uwert;
if($nwert > $maxwid){
$ustats = $ustats+($nwert-$maxwid);
$nwert = $maxwid;
}
$sql="UPDATE summon SET wid ='$nwert' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($int != 0){
$uwert = getwert($summon,"summon","intl","id");
$nwert = $int+$uwert;
if($nwert > $maxintl){
$ustats = $ustats+($nwert-$maxintl);
$nwert = $maxintl;
}
$sql="UPDATE summon SET intl ='$nwert' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($chrk != 0){
$uwert = getwert($summon,"summon","chrk","id");
$nwert = $chrk+$uwert;
if($nwert > $maxchrk){
$ustats = $ustats+($nwert-$maxchrk);
$nwert = $maxchrk;
}
$sql="UPDATE summon SET chrk ='$nwert' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($tmp != 0){
$uwert = getwert($summon,"summon","tmp","id");
$nwert = $tmp+$uwert;
if($nwert > $maxtmp){
$ustats = $ustats+($nwert-$maxtmp);
$nwert = $maxtmp;
}
$sql="UPDATE summon SET tmp ='$nwert' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($gnk != 0){
$uwert = getwert($summon,"summon","gnk","id");
$nwert = $gnk+$uwert;
if($nwert > $maxgnk){
$ustats = $ustats+($nwert-$maxgnk);
$nwert = $maxgnk;
}
$sql="UPDATE summon SET gnk ='$nwert' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$uwert2 = 0;
$uwert = getwert($summon,"summon","mhp","id");
$uwert2 = $uwert+$uwert2;
$uwert = getwert($summon,"summon","mchakra","id");
$uwert2 = $uwert+$uwert2;
$uwert = getwert($summon,"summon","kr","id");
$uwert2 = $uwert+$uwert2;
$uwert = getwert($summon,"summon","wid","id");
$uwert2 = $uwert+$uwert2;
$uwert = getwert($summon,"summon","tmp","id");
$uwert2 = $uwert+$uwert2;
$uwert = getwert($summon,"summon","chrk","id");
$uwert2 = $uwert+$uwert2;
$uwert = getwert($summon,"summon","intl","id");
$uwert2 = $uwert+$uwert2;
$uwert = getwert($summon,"summon","gnk","id");
$uwert2 = $uwert+$uwert2;
if($uwert2 >= $mwert){
$ustats = 0;
}
$sql="UPDATE summon SET statspunkte ='$ustats' WHERE id = '".$summon."' LIMIT 1";
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
if($aktion == "abbrechen"){
if($_POST['check'] == 'Ja'){
$saktion = getwert($summon,"summon","aktion","id");
if($saktion != ""){
$aktiond = getwert($summon,"summon","aktiond","id");
$aktions = getwert($summon,"summon","aktions","id");
if($saktion == 'Spezialtraining')
{
  $umhp = getwert(session_id(),"charaktere","mhp","session");
  $umchakra = getwert(session_id(),"charaktere","mchakra","session");
  $umkr = getwert(session_id(),"charaktere","mkr","session");
  $umintl = getwert(session_id(),"charaktere","mintl","session");
  $umchrk = getwert(session_id(),"charaktere","mchrk","session");
  $umgnk = getwert(session_id(),"charaktere","mgnk","session");
  $umwid = getwert(session_id(),"charaktere","mwid","session");
  $umtmp = getwert(session_id(),"charaktere","mtmp","session");
  $umstats = getwert(session_id(),"charaktere","statspunkte","session");
  
  $aktiond = getwert($summon,"summon","aktiond","id"); 
  $statspunkte = getwert($summon,"summon","statspunkte","id"); 
  $zeit = time();
  $zeit2 = strtotime($aktions);
  $zeit3 = $zeit-$zeit2;
  $zeit3 = $zeit3/3600;
  $hours = floor($zeit3);
  for($i =0; $i < $hours; ++$i)
  {
    $smhp = getwert($summon,"summon","mhp","id");
    $smchakra = getwert($summon,"summon","mchakra","id");
    $smkr = getwert($summon,"summon","kr","id");
    $smintl = getwert($summon,"summon","intl","id");
    $smchrk = getwert($summon,"summon","chrk","id");
    $smgnk = getwert($summon,"summon","gnk","id");
    $smwid = getwert($summon,"summon","wid","id");
    $smtmp = getwert($summon,"summon","tmp","id");
    $maxStats = 80000;
    $ustats = ($umhp/10)+($umchakra/10)+$umkr+$umintl+$umchrk+$umgnk+$umwid+$smtmp + $umstats;
    $sstats = ($smhp/10)+($smchakra/10)+$smkr+$smintl+$smchrk+$smgnk+$smwid+$smtmp + $statspunkte;
    $statsGain = floor(($ustats - $sstats)/10);
    if($statsGain < 1) $statsGain = 1; 
    $statspunkte = $statspunkte + $statsGain;
    
    $sstats = ($smhp/10)+($smchakra/10)+$smkr+$smintl+$smchrk+$smgnk+$smwid+$smtmp + $statspunkte;
    if($sstats > $maxStats) 
    {
      $statsDiff = $sstats-$maxStats;
      $statspunkte = $statspunkte - $statsDiff;
    }
  }
  
  $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
  mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
  $sql="UPDATE summon SET statspunkte ='$statspunkte' WHERE id = '".$summon."' LIMIT 1";
  if (!mysqli_query($con, $sql))
  {
  die('Error: ' . mysqli_error($con));
  }    
  mysqli_close($con);  
}
else if($saktion == "Erholen"||$saktion == 'Reparieren'){
$uhp = getwert($summon,"summon","hp","id");
$umhp = getwert($summon,"summon","mhp","id");
$uchakra = getwert($summon,"summon","chakra","id");
$umchakra = getwert($summon,"summon","mchakra","id");
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
$sql="UPDATE summon SET hp ='$uhp',chakra ='$uchakra' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}
$trainieren = substr($saktion,-10);
if($trainieren == "trainieren"||$trainieren == "verbessern"){
$wert = substr($saktion,0,-11);
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
if($uclan == 'kugutsu'||$edo == 1){
$sname = getwert($summon,"summon","name","id");
$nname = getwert($summon,"npc","name","name");
if($nname == ''){
if($wert == 'kr'){
$maxwert = 6000;
}
elseif($wert == 'hp'){
$maxwert = 100000;
}
elseif($wert == 'chakra'){
$maxwert = 75000;
}
elseif($wert == 'wid'){
$maxwert = 7500;
}
elseif($wert == 'tmp'){
$maxwert = 7500;
}
elseif($wert == 'gnk'){
$maxwert = 7500;
}
elseif($wert == 'intl'){
$maxwert = 6000;
}
elseif($wert == 'chrk'){
$maxwert = 6000;
}
}
else{
if($wert == 'hp'||$wert == 'chakra'){
$maxwert = 100000;
}
else{
$maxwert = 10000;
}
}
}
else{
if($wert == 'hp'||$wert == 'chakra'){
$maxwert = 100000;
}
else{
$maxwert = 10000;
}
}
$uwert = getwert($summon,"summon",$wert,"id");
if($wert == "hp"||$wert == "chakra"){
$uwertm = getwert($summon,"summon","m$wert","id");
}
$zeit = time();
$zeit2 = strtotime($aktions);
$zeit3 = $zeit-$zeit2;
$zeit3 = floor($zeit3/60);
if($wert == "hp"||$wert == "chakra"){
$nwert = $uwert+(floor($zeit3/60)*10);
if($nwert > $maxwert){
$nwert = $maxwert;
}
$nwertm = $uwertm+(floor($zeit3/60)*10);
if($nwertm > $maxwert){
$nwertm = $maxwert;
}
}
else{
$nwert = $uwert+floor($zeit3/60);
if($nwert > $maxwert){
$nwert = $maxwert;
}
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE summon SET $wert ='$nwert' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($wert == "hp"||$wert == "chakra"){
$sql="UPDATE summon SET m$wert ='$nwertm' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
mysqli_close($con);

}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE summon SET aktion ='',aktiond ='0' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = "Aktion abgebrochen.";
}
}

}
if($aktion == "training"){
$saktion = getwert($summon,"summon","aktion","id");
if($saktion == ""){
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
if($wert == "hp"||$wert == "chakra"){
$uwertm = getwert($summon,"summon","m$wert","id");
}
else{
$uwertm = getwert($summon,"summon","$wert","id");
}
if($uwertm < 10000&&$was != "Chakra"&&$was != "HP"||$uwertm < 100000&&$was == "Chakra"||$uwertm < 100000&&$was == "HP"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($uclan != 'kugutsu'){
$sql="UPDATE summon SET aktion ='$was trainieren' WHERE id = '".$summon."' LIMIT 1";
}
else{
$sql="UPDATE summon SET aktion ='$was verbessern' WHERE id = '".$summon."' LIMIT 1";
}
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$sql="UPDATE summon SET aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
if($uclan == 'inuzuka'||$uclan == 'admin'){
$error = "Dein Hund trainiert nun ".$was.'!';
}
if($uclan == 'jiongu'){
$error = "Dein Herz trainiert nun ".$was.'!';
}
if($uclan == 'kugutsu'){
$error = "Du verbesserst deine Puppe in ".$was.'!';
}
if($uclan == 'sakon'){
$error = 'Dein Bruder trainiert nun '.$was.'!';
}
if($edo == 1){
$error = 'Deine Leiche trainiert nun '.$was.'!';
}
}
else{
$error = "Du kannst das nicht noch mehr trainieren.";
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
if($uclan == 'inuzuka'||$uclan == 'admin'){
$error = "Dein Hund tut bereits etwas.";
}
if($uclan == 'jiongu'){
$error = "Dein Herz tut bereits etwas.";
}
if($uclan == 'kugutsu'){
$error = "Du arbeitest schon an der Puppe.";
}
if($uclan == 'sakon'){
$error = 'Dein Bruder tut schon etwas.';
}
if($edo == 1){
$error = 'Deine Leiche tut schon etwas.';
}
}
}
/*else if($aktion == "specialtrain" && ($uclan == 'inuzuka' || $uclan == 'sakon' || $uclan == 'jiongu' || $uclan == 'admin')){
$saktion = getwert($summon,"summon","aktion","id");
if($saktion == ""){
$dauer = $_POST['dauer'];
if($dauer < 1){
$dauer = 1;
}
if($dauer > 336){
$dauer = 336;
}
if(is_numeric($dauer)){
$dauer = $dauer*60;
  
$umhp = getwert($summon,"summon","mhp","id");
$umchakra = getwert($summon,"summon","mchakra","id");
$umkr = getwert($summon,"summon","kr","id");
$umintl = getwert($summon,"summon","intl","id");
$umchrk = getwert($summon,"summon","chrk","id");
$umgnk = getwert($summon,"summon","gnk","id");
$umwid = getwert($summon,"summon","wid","id");
$umtmp = getwert($summon,"summon","tmp","id");
$maxStats = 80000;
$ustats = ($umhp/10)+($umchakra/10)+$umkr+$umintl+$umchrk+$umgnk+$umwid+$umtmp;
if($ustats < $maxStats){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE summon SET aktion ='Spezialtraining' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$sql="UPDATE summon SET aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
if($uclan == 'inuzuka'||$uclan == 'admin'){
$error = "Dein Hund macht nun ein Spezialtraining.";
}
if($uclan == 'jiongu'){
$error = "Dein Herz macht nun ein Spezialtraining.";
}
if($uclan == 'sakon'){
$error = "Dein Bruder macht nun ein Spezialtraining.";
}
}
else{
$error = "Du kannst das nicht noch mehr trainieren.";
}
}
else{
$error = "Für die Dauer wurde keine gültige Zeit angegeben.";
}
}
else{
if($uclan == 'inuzuka'||$uclan == 'admin'){
$error = "Dein Hund tut bereits etwas.";
}
if($uclan == 'jiongu'){
$error = "Dein Herz tut bereits etwas.";
}
if($uclan == 'sakon'){
$error = 'Dein Bruder tut schon etwas.';
}
}
}
if($aktion == "statsreset" && ($uclan == 'inuzuka' || $uclan == 'sakon' || $uclan == 'jiongu' || $uclan == 'admin')){

  
$umhp = getwert($summon,"summon","mhp","id");
$umchakra = getwert($summon,"summon","mchakra","id");
$umkr = getwert($summon,"summon","kr","id");
$umintl = getwert($summon,"summon","intl","id");
$umchrk = getwert($summon,"summon","chrk","id");
$umgnk = getwert($summon,"summon","gnk","id");
$umwid = getwert($summon,"summon","wid","id");
$umtmp = getwert($summon,"summon","tmp","id");
$ustats = ($umhp/10)+($umchakra/10)+$umkr+$umintl+$umchrk+$umgnk+$umwid+$umtmp;
$ustats = $ustats - 80;
  
$cost = $ustats*10;
$uryo = getwert(session_id(),"charaktere","ryo","session");
$nryo = $uryo-$cost;
if($nryo >= 0){

$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE summon SET statspunkte=statspunkte+".$ustats.",hp ='100',mhp='100',chakra='100', mchakra='100', kr='10', 
intl='10', chrk='10', gnk='10', wid='10', tmp='10' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE charaktere SET ryo ='$nryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = 'Du hast die Stats zurückgesetzt.';
}
else{
$error = 'Du hast nicht genügend Ryo.';
}
}*/
if($aktion == "heil"){
$saktion = getwert($summon,"summon","aktion","id");
if($saktion == ""){
$dauer = 60;

$smhp = getwert($summon,"summon","mhp","id");
$shp = getwert($summon,"summon","hp","id");
$smchakra = getwert($summon,"summon","mchakra","id");
$schakra = getwert($summon,"summon","chakra","id");
$hk = ($smhp-$shp)+($smchakra-$schakra);
$uryo = getwert(session_id(),"charaktere","ryo","session");
$nryo = $uryo-$hk;
if($hk != 0){
if($nryo >= 0){

$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($uclan != 'kugutsu'){
$sql="UPDATE summon SET aktion ='Heilen' WHERE id = '".$summon."' LIMIT 1";
}
else{
$sql="UPDATE summon SET aktion ='Reperatur' WHERE id = '".$summon."' LIMIT 1";
}
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$sql="UPDATE summon SET aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE charaktere SET ryo ='$nryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
if($uclan == 'inuzuka'||$uclan == 'admin'){
$error = "Du gibst deinen Hund bei einem Heiler ab.";
}
if($uclan == 'jiongu'){
$error = "Du gibst dein Herz bei einem Heiler ab.";
}
if($uclan == 'kugutsu'){
$error = "Du lässt deine Puppe reparieren.";
}
if($uclan == 'sakon'){
$error = 'Dein Bruder geht ins Krankenhaus.';
}
if($edo == 1){
$error = 'Deine Leiche erhält neue DNA.';
}
}
else{
$error = 'Du hast nicht genügend Ryo.';
}
}


}
else{
if($uclan == 'inuzuka'||$uclan == 'admin'){
$error = "Dein Hund tut bereits etwas.";
}
if($uclan == 'jiongu'){
$error = "Dein Herz tut bereits etwas.";
}
if($uclan == 'kugutsu'){
$error = "Du arbeitest schon an der Puppe.";
}
if($uclan == 'sakon'){
$error = 'Dein Bruder tut schon etwas';
}
if($edo == 1){
$error = 'Deine Leiche tut schon etwas.';
}
}
}
}
if($aktion == "erholen"){
$saktion = getwert($summon,"summon","aktion","id");
if($saktion == ""){
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
if($uclan != 'kugutsu'){
$sql="UPDATE summon SET aktion ='Erholen' WHERE id = '".$summon."' LIMIT 1";
}
else{
$sql="UPDATE summon SET aktion ='Reparieren' WHERE id = '".$summon."' LIMIT 1";
}
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$sql="UPDATE summon SET aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
if($uclan == 'inuzuka'||$uclan == 'admin'){
$error = "Dein Hund erholt sich nun.";
}
if($uclan == 'jiongu'){
$error = "Dein Herz erholt sich nun.";
}
if($uclan == 'kugutsu'){
$error = "Du reparierst deine Puppe.";
}
if($uclan == 'sakon'){
$error = 'Dein Bruder erholt sich nun.';
}
if($edo == 1){
$error = 'Deine Leiche regeneriert sich.';
}


}
}
else{
if($uclan == 'inuzuka'||$uclan == 'admin'){
$error = "Dein Hund tut bereits etwas.";
}
if($uclan == 'jiongu'){
$error = "Dein Herz tut bereits etwas.";
}
if($uclan == 'kugutsu'){
$error = "Du arbeitest schon an der Puppe.";
}
if($uclan == 'sakon'){
$error = 'Dein Bruder tut schon etwas.';
}
if($edo == 1){
$error = 'Deine Leiche tut schon etwas.';
}
}
}
}
}
if($uclan == 'inuzuka'||$uclan == 'admin'||$uclan == 'sakon'){
$summon = $_GET['summon'];
if($aktion == "daten"){
$name = $_POST['name'];
if($uclan == 'inuzuka'){
if($name == ""){
$name = "Hund";
}
$sname = getwert($summon,"summon","name","id");
}
if(isset($_POST['bild']) && $_FILES['file_upload']['name'] != ''){
$bild = getwert($summon,"summon","bild","id");
$imgHandler = new ImageHandler('userdata/summonbild/');
$result = $imgHandler->Upload($_FILES['file_upload'], $nbild, 550, 600);
switch($result)
{
  case -1:
    $message = 'Die Datei ist zu groß.';
    break;
  case -2:
    $message = 'Die Datei ist ungültig.';
    break;
  case -3:
    $message = 'Es ist nur jpg, jpeg und png erlaubt.';
    break;
  case -4:
    $message = 'Es gab ein Problem beim generieren des Namens.';
    break;
  case -5:
    $message = 'Es gab ein Problem beim hochladen.';
    break;
}
if($result >= 0){
$sbild = $nbild;
}
else{
$error = $error.$message.'<br/>';
$sbild = $bild;
}
}  
if(isset($_POST['kbild']) && $_FILES['file_upload2']['name'] != ''){
$kbild = getwert($summon,"summon","kbild","id");
$imgHandler = new ImageHandler('userdata/summonkampfbild/');
$result = $imgHandler->Upload($_FILES['file_upload2'], $nkbild, 100, 100);
switch($result)
{
  case -1:
    $message = 'Die Datei ist zu groß.';
    break;
  case -2:
    $message = 'Die Datei ist ungültig.';
    break;
  case -3:
    $message = 'Es ist nur jpg, jpeg und png erlaubt.';
    break;
  case -4:
    $message = 'Es gab ein Problem beim generieren des Namens.';
    break;
  case -5:
    $message = 'Es gab ein Problem beim hochladen.';
    break;
}
if($result >= 0){
$skbild = $nkbild;
}
else{
$error = $error.$message.'<br/>';
$skbild = $kbild;
}
}  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($uclan == 'inuzuka'||$uclan == 'admin'||$uclan == 'sakon'){
if($sname != $name){
$geht = 1;
if($name != "Hund"&&$name != "Wolf"&&$uclan == 'inuzuka'||$uclan != 'inuzuka'){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name
FROM
charaktere
WHERE name LIKE "'.$name.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 0;
$error = $error."Dieser Name existiert schon.<br>";
}
$result->close(); $db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer
FROM
summon
WHERE name LIKE "'.$name.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$bclan = getwert($row['besitzer'],"charaktere","clan","id");
if($bclan == "inuzuka"){
$geht = 0;
$error = $error."Dieser Name existiert schon.<br>";
}
}
$result->close(); $db->close();
if(!sonderzeichen($name)){
$geht = 0;
$error = $error."Es befinden sich Sonderzeichen im Namen.<br>";
}
if(!namencheck($name)){
$geht = 0;
$error = $error."Der Name hat unzulässige Wörter im Namen.<br>";
}
}
if($geht == 1){
$sql="UPDATE summon SET name ='$name' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$error = $error."Der Name wurde geändert.<br>";
}
}
}
if($bild != $sbild){
$sql="UPDATE summon SET bild ='$sbild' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$error = $error."Das Bild wurde geändert.<br>";

}
if($kbild != $skbild){
$sql="UPDATE summon SET kbild ='$skbild' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$error = $error."Das Kampfbild wurde geändert.<br>";

}
mysqli_close($con);
}
}

$summon = $_GET['summon'];
if($summon != ""){
$sbesitzer = getwert($summon,"summon","besitzer","id");
if($sbesitzer == $uid){
if($uclan == "kugutsu"){
if($aktion == "verkaufen"){
$ukid = getwert(session_id(),"charaktere","kampfid","session");
if($ukid == 0){
$check = $_POST['check'];
if($check == "check"){
$sname = getwert($summon,"summon","name","id");
$iid = getwert($sname,"item","id","name");
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($iid != 0){
$error = "Du hast die Puppe $sname verkauft.";
$ipreis = getwert($iid,"item","preis","id");
$ipreis = $ipreis/2;
$uryo = getwert(session_id(),"charaktere","ryo","session");
$uryo = $uryo+$ipreis;
$sql="UPDATE charaktere SET ryo ='$uryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$error = "Du hast die Puppe $sname zerstört.";
}
$sql="DELETE FROM summon WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$summon = "";
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
}
if($edo == 1){
if($aktion == "delete"){
$ukid = getwert(session_id(),"charaktere","kampfid","session");
if($ukid == 0){
$check = $_POST['check'];
if($check == "check"){
$sname = getwert($summon,"summon","name","id");
$iid = getwert($sname,"item","id","name");
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$error = "Du hast die Leiche $sname zerstört.";
$sql="DELETE FROM summon WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$summon = "";
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
}
if($aktion == "reihe"){
$reihe = $_GET['reihe'];
if($reihe == 1||$reihe == 2||$reihe == 3){
$sreihe = getwert($summon,"summon","reihenfolge","id");
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
reihenfolge,
besitzer
FROM
summon
WHERE
besitzer = "'.$uid.'" AND reihenfolge = "'.$reihe.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$sql="UPDATE summon SET reihenfolge ='$sreihe' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close(); $db->close();
$sql="UPDATE summon SET reihenfolge ='$reihe' WHERE id = '".$summon."' LIMIT 1";
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
else{
$error = 'Du kannst dies in einen Kampf nicht tun.';
}
}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
if($summon != ""&&$sbesitzer == $uid){
if($_GET['page'] == ''){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
kbild,
bild,
hp,
mhp,
chakra,
mchakra,
kr,
intl,
tmp,
gnk,
chrk,
wid,
reihenfolge,
jutsus,
statspunkte
FROM
summon
WHERE besitzer= "'.$uid.'" and id = "'.$summon.'"
ORDER BY
reihenfolge DESC
LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<table class="table2" width="100%">';
echo '<tr>';
echo '<td class="tdbr" width="400px">';
if($row['bild'] == ""){
$bild = "bilder/design/nopic.png";
}
else{
$bild = $row['bild'];
}
echo '<img src="'.$bild.'"></img>';
echo '</td>';
echo '<td>';
echo '<table width="100%">';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>HP</b><br>HP ist ein Wert, der angibt, wieviel du aushalten kannst.'";
echo ')" onMouseout="hidetext()">HP:</b></td>';
echo '<td width="25%" class="shadow">'.$row['hp'].'/'.$row['mhp'];
echo '</td>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Chakra</b><br>Chakra beschreibt deine mentale Energie, die du für Jutsus benötigt.'";
echo ')" onMouseout="hidetext()">Chakra:</b></td>';
echo '<td width="25%" class="shadow">'.$row['chakra'].'/'.$row['mchakra'];
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Kraft</b><br>Kraft beschreibt die Stärke der Taijutsus.'";
echo ')" onMouseout="hidetext()">Kraft:</b></td>';
echo '<td width="25%" class="shadow">'.$row['kr'];
echo '</td>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Tempo</b><br>Tempo beschreibt deine Schnelligkeit. Umso mehr Tempo du hast , umso größer ist die Chance , dass der Angriff des Gegners nicht trifft.'";
echo ')" onMouseout="hidetext()">Tempo:</b></td>';
echo '<td width="25%" class="shadow">'.$row['tmp'];
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Intelligenz</b><br>Intelligenz beschreibt die Stärke der Genjutsus.'";
echo ')" onMouseout="hidetext()">Intelligenz:</b></td>';
echo '<td width="25%" class="shadow">'.$row['intl'];
echo '</td>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Genauigkeit</b><br>Genauigkeit beschreibt die Konzentration auf den Gegner und gibt an, wie genau man zielt.'";
echo ')" onMouseout="hidetext()">Genauigkeit:</b></td>';
echo '<td width="25%" class="shadow">'.$row['gnk'];
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Chakrakontrolle</b><br>Chakrakontrolle beschreibt die Stärke der Ninjutsus.'";
echo ')" onMouseout="hidetext()">Chakrakontrolle:</b></td>';
echo '<td width="25%" class="shadow">'.$row['chrk'];
echo '</td>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Widerstand</b><br>Widerstand beschreibt die mentale sowie die körperliche Stärke und gibt an, wie viel ich körperlich bzw mental aushalte.'";
echo ')" onMouseout="hidetext()">Widerstand:</b></td>';
echo '<td width="25%" class="shadow">'.$row['wid'];
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="25%"><b class="shadowh" onMouseover="showtext(';
echo "'<b>Reihenfolge</b><br>Die Reihenfolge, in der die einzelnen Beschwörungen gerufen werden.'";
echo ')" onMouseout="hidetext()">Reihenfolge:</b></td>';
echo '<td>';
echo '<table width="100%"><tr>';
if($row['reihenfolge'] == 1){
echo '<td>';
echo '<div class="sone"><a href="#"></a></div>';
echo '</td>';
}
else{
echo '<td>';
echo '<div class="sonen"><a href="summon.php?summon='.$summon.'&aktion=reihe&reihe=1"></a></div>';
echo '</td>';
}
if($row['reihenfolge'] == 2){
echo '<td>';
echo '<div class="stwo"><a href="#"></a></div>';
echo '</td>';
}
else{
echo '<td>';
echo '<div class="stwon"><a href="summon.php?summon='.$summon.'&aktion=reihe&reihe=2"></a></div>';
echo '</td>';
}
if($row['reihenfolge'] == 3){
echo '<td>';
echo '<div class="sthree"><a href="#"></a></div>';
echo '</td>';
}
else{
echo '<td>';
echo '<div class="sthreen"><a href="summon.php?summon='.$summon.'&aktion=reihe&reihe=3"></a></div>';
echo '</td>';
}
echo '</tr>';
echo '</table>';
echo '</tr><tr>';
echo '<td colspan="4">';
$array = explode(";", trim($row['jutsus']));
$count = 0;
$count2 = 0;
echo '<table width="100%">';
echo '<tr>';
while(isset($array[$count])){   
$jname = getwert($array[$count],"jutsus","name","id");
$jbild = getwert($array[$count],"jutsus","bild","id");
echo '<td>';
echo '<a class="sinfo" href="#"><img border="0" src="bilder/jutsus/'.strtolower($jbild).'a.png" width="50px" height="50px"></img><span class="spanmap">'.$jname.'</span></a>';
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
$saktion = getwert($summon,"summon","aktion","id");
if($saktion != ""){
$saktions = getwert($summon,"summon","aktions","id");
$saktiond = getwert($summon,"summon","aktiond","id");
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($saktions);
$test3 = $test2-$test;
$test4 = ($saktiond*60)-$test3;
$cID = $cID+1;
echo '<b>'.$saktion.'</b><br>';
echo 'Dauer: <b id="cID'.$cID.'">';
echo " Init<script>countdown($test4,'cID$cID');</script></b><br>";
echo '<form method="post" action="summon.php?&summon='.$summon.'&aktion=abbrechen"><input type="checkbox" name="check" value="Ja"> <input class="button2" name="login" id="login" value="Aktion abbrechen" type="submit"></form>';

}
echo '</td>';
echo '</tr>';
echo '</table>';
if($row['statspunkte'] != "0"){
echo '<p class="shadow">Du kannst noch <b>'.$row['statspunkte'].'</b> Statspunkte verteilen. Tu dies <a href="summon.php?summon='.$summon.'&page=stats">hier</a>.</p><br>';
}
echo '</td>';
echo '</tr>';
echo '</table>';
}
$result->close();$db->close();
echo '<table width="100%">';
echo '<tr>';
echo '<td width="50%">';
if($uclan == "inuzuka"||$uclan == 'admin'||$uclan == 'sakon'){
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=daten" enctype="multipart/form-data"><center>';
echo 'Name:<div class="eingabe1">';
$sname = getwert($summon,"summon","name","id");
echo '<input class="eingabe2" name="name" id="name" value="'.$sname.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo 'Bild (Max 550x600):<br/>';
echo '<input type="file" name="file_upload" /><input type="hidden" name="bild"/><br/>';
echo 'Kampfbild (Max 100x100):<br/>';
echo '<input type="file" name="file_upload2" /><input type="hidden" name="kbild"/><br/>';
echo '</div>';
echo '<br>';
echo '</center><input class="button" name="login" id="login" value="ändern" type="submit">';
echo '</form>';
echo '</td>';
}
else{
if($uclan == "kugutsu"){
$sname = getwert($summon,"summon","name","id");
$iid = getwert($sname,"item","id","name");
if($iid != 0){
$ipreis = getwert($iid,"item","preis","id");
$ipreis = $ipreis/2;
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=verkaufen">';
echo '<center>';
echo '<input class="cursor" type="checkbox" name="check" value="check"> Sicher?';
echo '</center><input class="button" name="login" id="login" value="Verkaufspreis: '.$ipreis.'Ryo" type="submit">';
echo '</form>';
}
else{
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=verkaufen">';
echo '<center>';
echo '<input class="cursor" type="checkbox" name="check" value="check"> Sicher?';
echo '</center><input class="button" name="login" id="login" value="zerstören" type="submit">';
echo '</form>';
}
echo '</td>';
}
if($edo == 1){
$sname = getwert($summon,"summon","name","id");
$iid = getwert($sname,"item","id","name");
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=delete">';
echo '<center>';
echo '<input class="cursor" type="checkbox" name="check" value="check"> Sicher?';
echo '</center><input class="button" name="login" id="login" value="zerstören" type="submit">';
echo '</form>';
echo '</td>';
}
}
if($uclan == "inuzuka"||$uclan == 'jiongu'||$uclan == 'kugutsu'||$uclan == 'admin'||$uclan == 'sakon'||$edo == 1){
echo '</td>';
echo '<td width="50%">';
if($uclan == "inuzuka"||$uclan == 'jiongu'||$uclan == 'admin'||$uclan == 'sakon'){
echo '<h3>Erholen</h3>';
echo '(10% HP und Chakra pro Stunde)';
}
if($uclan == 'kugutsu'){
echo '<h3>Reparieren</h3>';
echo '(10% HP und Chakra pro Stunde)';
}
if($edo == 1){
echo '<h3>Regenerieren</h3>';
echo '(10% HP und Chakra pro Stunde)';
}
echo '<br>';
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=erholen">';
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
if($uclan == "inuzuka"||$uclan == 'jiongu'||$uclan == 'admin'||$uclan == 'sakon'){
echo '<input class="button" name="login" id="login" value="erholen" type="submit">';
}
if($uclan == 'kugutsu'){
echo '<input class="button" name="login" id="login" value="reparieren" type="submit">';
}
if($edo == 1){
echo '<input class="button" name="login" id="login" value="regenerieren" type="submit">';
}
echo '</form>';
echo '<br>';
if($uclan == "inuzuka"||$uclan == 'jiongu'||$uclan == 'admin'||$uclan == 'sakon'||$edo == 1){
echo '<h3>Trainieren</h3>';
}
if($uclan == 'kugutsu'){
echo '<h3>Aufrüstung</h3>';
}
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=training">';
echo '<table width="100%">';
echo '<tr>';
echo '<td align="center">';
echo '<div class="auswahl">';
echo '<select name="was">';
echo '<option value="HP">HP</option>';
echo '<option value="Chakra">Chakra</option>';
echo '<option value="Kraft">Kraft</option>';
echo '<option value="Tempo">Tempo</option>';
echo '<option value="Intelligenz">Intelligenz</option>';
echo '<option value="Genauigkeit">Genauigkeit</option>';
echo '<option value="Chakrakontrolle">Chakrakontrolle</option>';
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
if($uclan == "inuzuka"||$uclan == 'jiongu'||$uclan == 'admin'||$uclan == 'sakon'||$edo == 1){
echo '<input class="button" name="login" id="login" value="trainieren" type="submit">';
}
if($uclan == 'kugutsu'){
echo '<input class="button" name="login" id="login" value="aufrüsten" type="submit">';
}
echo '</form>';
echo '</td>';
echo '</tr>';
if($uclan == "inuzuka"||$uclan == 'jiongu'||$uclan == 'sakon'||$uclan == 'admin'){
  
$umhp = getwert(session_id(),"charaktere","mhp","session");
$umchakra = getwert(session_id(),"charaktere","mchakra","session");
$umkr = getwert(session_id(),"charaktere","mkr","session");
$umintl = getwert(session_id(),"charaktere","mintl","session");
$umchrk = getwert(session_id(),"charaktere","mchrk","session");
$umgnk = getwert(session_id(),"charaktere","mgnk","session");
$umwid = getwert(session_id(),"charaktere","mwid","session");
$umtmp = getwert(session_id(),"charaktere","mtmp","session");
$umstats = getwert(session_id(),"charaktere","statspunkte","session");
  
$smhp = getwert($summon,"summon","mhp","id");
$smchakra = getwert($summon,"summon","mchakra","id");
$smkr = getwert($summon,"summon","kr","id");
$smintl = getwert($summon,"summon","intl","id");
$smchrk = getwert($summon,"summon","chrk","id");
$smgnk = getwert($summon,"summon","gnk","id");
$smwid = getwert($summon,"summon","wid","id");
$smtmp = getwert($summon,"summon","tmp","id");
$statspunkte = getwert($summon,"summon","statspunkte","id"); 
$maxStats = 80000;
$ustats = ($umhp/10)+($umchakra/10)+$umkr+$umintl+$umchrk+$umgnk+$umwid+$smtmp + $umstats;
$sstats = ($smhp/10)+($smchakra/10)+$smkr+$smintl+$smchrk+$smgnk+$smwid+$smtmp + $statspunkte;
/*
echo '<tr>';
echo '<td>';
echo '<h3>Stats Zurücksetzen</h3>';
$ryoStats = $sstats-80 - $statspunkte;
$ryoCost = $ryoStats*10;
echo 'Das kostet dich '.$ryoCost.' Ryo.<br/>';
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=statsreset">';
echo '<input class="button" name="login" id="login" value="Zurücksetzen" type="submit">';
echo '</form>';
  
echo '</td>';
echo '<td>';
echo '<table width="100%">';
echo '<tr><td align="center">';

 echo '<h3>Spezialtraining</h3>';  
  

$statsWin = floor(($ustats - $sstats)/10);
if($statsWin < 1) $statsWin = 1; 
echo 'Erhöht die Stats um <b>'.$statsWin.' Stats</b>. <br/>Dies ist abhängig der Differenz der Statspunkte von dir und der Beschwörung.<br/>';
echo 'Die Differenz wird jede Stunde neuberechnet.<br/>';
echo '</td></tr>';
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=specialtrain">';
echo '<tr><td align="center">';
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
echo '</td></tr>';
echo '<tr><td align="center">';
echo '<input class="button" name="login" id="login" value="trainieren" type="submit">';
echo '</td></tr>';
echo '</form>';
echo '</table>';
echo '</td>';  
echo '</tr>';
*/
}
echo '</table><br/>';
  
  
$smhp = getwert($summon,"summon","mhp","id");
$shp = getwert($summon,"summon","hp","id");
$smchakra = getwert($summon,"summon","mchakra","id");
$schakra = getwert($summon,"summon","chakra","id");
$hk = ($smhp-$shp)+($smchakra-$schakra);
if($uclan == 'kugutsu'){
  echo '<h3>Reparatur</h3>';
}
else if($edo == 1){
  echo '<h3>DNA Reparieren</h3>';
}
else
{
  echo '<h3>Heiler</h3>';
}
echo '(Dauer: eine Stunde , Kosten: '.$hk.' Ryo)';
echo '<br>';
echo '<form method="post" action="summon.php?summon='.$summon.'&aktion=heil">';
echo '<input class="button" name="login" id="login" value="abgeben" type="submit">';
echo '</form>';
echo '<br/>';
  
}
echo '<div id="textdiv" class="shadow"></div>';
}
else{
$ustats = getwert($summon,"summon","statspunkte","id");
echo '<p class="shadow">Du hast insgesamt <b id="zahl2">'.$ustats.'</b> Punkte.<br> Du kannst noch <b id="zahl">'.$ustats.'</b> Punkte verteilen.<br></p>';
echo '<div class="relativ statswahl">';
echo '<form method="post" action="summon.php?&summon='.$summon.'&aktion=stats">';
echo '<div class="werte" style="left:100px; top:0px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
$mhp = getwert($summon,"summon","mhp","id");
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
$mchakra = getwert($summon,"summon","mchakra","id");
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
$mkr = getwert($summon,"summon","kr","id");
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
$mwid = getwert($summon,"summon","wid","id");
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
$mintl = getwert($summon,"summon","intl","id");
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
$mchrk = getwert($summon,"summon","chrk","id");
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
$mtmp = getwert($summon,"summon","tmp","id");
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
$mgnk = getwert($summon,"summon","gnk","id");
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
echo '<br><a href="summon.php">Zurück</a>';
}
else{
echo '<table width="100%">';
echo '<tr>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
kbild,
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
echo '<td align="center">';
echo '<div style="position:relative; height:100px; width:100px;">';
echo '<div class="srand" style="position:absolute; z-index:0;">';
echo '<a class="sinfo" href="summon.php?summon='.$row['id'].'">';
if($row['reihenfolge'] != 0){
echo '<div class="';
if($row['reihenfolge'] == 1){
echo 'one';
}
if($row['reihenfolge'] == 2){
echo 'two';
}
if($row['reihenfolge'] == 3){
echo 'three';
}
echo '" style="position:absolute; z-index:6;"></div>';
}
echo '<div style="position:absolute; z-index:5; width:100px; height:100px;">';
if($row['kbild'] == ""){
$kbild = "bilder/design/nokpic.png";
}
else{
$kbild = $row['kbild'];
}
echo '<img src="'.$kbild.'" width="100px" height="100px"></img>';
echo '</div>';
echo '<span class="spanmenu">'.$row['name'];
echo '</span>';
echo '</a>';
echo '</div>';
echo '</div>';
echo '</td>';
$sanzahl++;
if($sanzahl == 5){
echo '</tr><tr>';
}
}
$result->close();$db->close();
echo '</tr></table>';
if($sanzahl == 0){
if($uclan == "kugutsu"){
$error = 'Du hast keine Puppe.';
}
if($uclan == "inuzuka"||$uclan == 'admin'){
$error = 'Du hast kein Hund.';
}
if($uclan == "jiongu"){
$error = 'Du hast keine Herzen.';
}
if($uclan == "sakon"){
$error = 'Dein Bruder schläft noch.';
}
if($edo == 1){
$error = 'Du hast keine Leichen.';
}
}
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