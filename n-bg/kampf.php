<?php
include 'inc/incoben.php';
if(logged_in()){
$page = $_GET['page'];
$aktion = $_GET['aktion'];
$userid = getwert(session_id(),"charaktere","id","session");
$kampfid = getwert(session_id(),"charaktere","kampfid","session"); 
$admin = getwert(session_id(),"charaktere","admin","session");     
$ort = getwert(session_id(),"charaktere","ort","session");      
$hp = getwert(session_id(),"charaktere","hp","session");
if($page == "erstellen"&&$kampfid != 0){
$error = $error."Du bist schon in ein Kampf.<br>";
}                          
if($aktion == "beitreten"){
if($kampfid == 0){
if($hp != 0){
$kid = real_escape_string($_GET['kid']);
if(is_numeric($kid)){
$kpw = real_escape_string($_POST['pw']);
$array = explode(" ", trim($_POST['join']));
if($array[0] == "Team"&&$array[2] == "beitreten"){
$kteam = $array[1];
}                   
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
begin,
offen,
mode,
pw,
teams,
art,
ort,
wetter
FROM
fights
WHERE id = "'.$kid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 1;
$kwetter = $row['wetter'];
if($row['offen'] == 0){
//Wenn Kampf nicht offen ist
$geht = 0;
$error = $error."Der Kampf ist nicht beitretbar.<br>";
}
//Wenn PW falsch ist
if($row['pw'] != ""&&$kpw != $row['pw']){
$geht = 0;
$error = $error."Falsches Passwort.<br>";
}
if($row['ort'] != $ort&&$row['art'] != "Spaß"){
$geht = 0;
$error = $error."Du befindest dich nicht am selben Ort.<br>";
}
//überprüfe spieler im Team
$count = 0;
$array = explode(";", trim($row['teams']));
while(isset($array[$count])){   
$spieler = checkteam($array[$count],$row['id']);
$count2 = 0;
while($spieler[$count2] != ""){
$count2++;
}
$tempteam = $count+1;
$spimteam[$tempteam] = $count2; // SpielerimTeam[Team] = Anzahl
$count++;
}
$kart = $row['art'];
//überprüfe modus
// 1vs2 array[0] = 1 array[1] = 2
$array = explode("vs", trim($row['mode']));
$count = 0;
$voll = 1;
while(isset($array[$count])){   
$tempteam = $count+1;
$mode[$tempteam] = $array[$count];
$count++;
}
if($mode[$kteam] <= $spimteam[$kteam]){
$geht = 0;
$error = $error."Das Team ist voll.<br>";
}
if($mode[$kteam] == ""){
$geht = 0;
$error = $error."Dieses Team gibt es in dem Modus nicht.<br>";
}
}
$result->close(); $db->close(); 
if($geht == 1){
$spimteam[$kteam] = $spimteam[$kteam]+1;
$count = 1;
$voll = 1;
while($mode[$count] != ""){
if($mode[$count] != $spimteam[$count]){
$voll = 0;
}
$count++;
}
ausruest($userid);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$error = $error."Du bist den Kampf beigetreten.<br>";
$sql="UPDATE charaktere SET kampfid ='$kid',team ='$kteam' WHERE id = '".$userid."' LIMIT 1";
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
hp,
chakra,
kampfid,
name,
kbild
FROM
charaktere
WHERE kampfid = "'.$kid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;     
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false

$sql="UPDATE charaktere SET 
kkbild ='".$row['kbild']."',
powerup ='',
dstats ='',
debuff ='',
kname ='".$row['name']."',
kaktion ='',
lkaktion ='$zeit',
kziel ='',
kchadd ='0' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
          
if($kart == "Spaß"){
$hp = $row['hp'];
$sql="UPDATE charaktere SET shp ='$hp' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$chakra = $row['chakra'];
$sql="UPDATE charaktere SET schakra ='$chakra' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}

}
$result->close(); $db->close(); 
if($voll == 1){
$error = $error."Kampf wurde gestartet.<br>";
if($kwetter == 'Zufall'){
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
}
$sql="UPDATE fights SET begin ='1',offen ='0',wetter ='$kwetter' WHERE id = '".$kid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
} 
mysqli_close($con); 
}
}
}
else{
$error = 'Du hast keine HP.';
}
}
else{
$error = $error."Du bist schon in einem Kampf.<br>";
}
}
             
if($aktion == "verlassen"){
if($kampfid != 0){
$cbegin = getwert($kampfid,"fights","begin","id");
if($cbegin == 0){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
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
where id="'.$userid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false 
      $nkr = $row['mkr']; 
      $ntmp = $row['mtmp'];  
      $nintl = $row['mintl']; 
      $ngnk = $row['mgnk'];  
      $nchrk = $row['mchrk'];   
      $nwid = $row['mwid'];
      $sql="UPDATE charaktere SET 
      kampfid ='0',
      team ='0',
      kr ='$nkr',
      tmp ='$ntmp',
      intl ='$nintl',
      gnk ='$ngnk',
      chrk ='$nchrk',
      wid ='$nwid' WHERE id = '".$userid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }


}
$result->close(); $db->close(); 
$cdrin = 0;
$cdrin = getwert($kampfid,"charaktere","id","kampfid");
if($cdrin == 0){
$sql="DELETE FROM fights WHERE id = '".$kampfid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

mysqli_close($con); 
}
$error = $error."Du hast den Kampf verlassen.<br>";
}
else{
$error = $error."Der Kampf hat schon angefangen.<br>";
}
}
else{
$error = $error."Du bist in keinem Kampf.<br>";
}
}
if($aktion == "erstellen"){ 
if($hp != 0){    
if($kampfid != 0){
$error = $error."Du bist schon in einem Kampf.<br>";
}
else{
$kname = $_POST['name'];
$leerzeichen = substr($kname,-1);
if($leerzeichen == " "){
$length = strlen($kname );
$kname = substr($kname,0,$length-1);
}
$kpw = $_POST['pw'];
$kmode = $_POST['mode'];
$kart = $_POST['art'];
//Fehlerüberprüfung der Eingabe      
$geht = 1;
if($kname == ""){
$error = $error."Du hast keinen Namen angegeben.<br>";
$geht = 0;
}
if(!namencheck($kname)){
$geht = 0;
$error = $error."Der Kampfname beinhaltet unzulässige Wörter.<br>";
}        
if(!sonderzeichen($kname)){
$geht = 0;
$error = $error."Der Kampfname beinhaltet unzulässige Zeichen.<br>";
}
if($kmode == ""){
$error = $error."Du hast keinen Modus angegeben.<br>";
$geht = 0;
}
if($kart != "Spaß"&&$kart != "Normal"){
$error = $error."Diese Kampfart gibt es nicht.<br>";
$geht = 0;
}
//Modus überprüfung     
$array = explode("vs", trim($kmode));
if($array[0] == ""||$array[1] == ""){
$error = $error."Du hast einen ungültigen Modus angegeben.<br>";
$geht = 0;
}         
$spieler = 0;
$teams = 0;
$kmode = "";
$teamnr = 0;    
$count = 0;           
while($array[$teams] != ""){
if($array[$teams] != 0&&is_numeric($array[$teams])){ 
$c = 0; 
while($c != 2){      
$check = substr($array[$teams], $count, 1);  // returns "abcde"  
if(!is_numeric($check)){    
$error = "Du hast einen ungültigen Modus angegeben.<br>";
$geht = 0;
}
$c++;
}
$teamnr = $teamnr+1;
if($kmode == ""){
$kmode = $array[$teams];
$kteam = $teamnr;
}
else{
$kteam = $kteam.';'.$teamnr;
$kmode = $kmode.'vs'.$array[$teams];
}
$team[$teamnr] = $array[$teams];
$spieler = $spieler+$array[$teams];
}
$teams++;
}         
if($teams > 10){
$geht = 0;
$error = $error."Du kannst nicht mehr als 10 Teams eintragen.<br>";
}
if($spieler > 10){
$geht = 0;
$error = $error."Du kannst nicht mehr als 10 Spieler eintragen.<br>";
}
if($teams <= 1){
$geht = 0;
$error = $error."Du musst mindestens zwei Teams eintragen.<br>";
}
if($spieler <= 1){
$geht = 0;
$error = $error."Du musst mindestens zwei Spieler eintragen.<br>";
}
$owetter = $_POST['wetter'];
if($owetter != 'Zufall'&&$owetter != 'Sonne'&&$owetter != 'Regen'&&$owetter != 'Gewitter'&&$owetter != 'Hitze'&&$owetter != 'Erdrutsch'&&$owetter != 'Sturm'){
$geht = 0;        
$error = $error."Dieses Wetter ist nicht möglich.<br>";
}                              
if($_POST['r1c'] == 'check'){
$regeln = $regeln.'1';
}                              
if($_POST['r2c'] == 'check'){
$regeln = $regeln.'2';
}                  
if($_POST['r3c'] == 'check'){
$regeln = $regeln.'3';
}                                
if($_POST['r4c'] == 'check'){
$regeln = $regeln.'4';
}                                  
if($_POST['r5c'] == 'check'){
$regeln = $regeln.'5';
}                                  
if($_POST['r6c'] == 'check'){
$regeln = $regeln.'6';
}                  
if($_POST['r7c'] == 'check'){
$regeln = $regeln.'7';
}                                   
if($_POST['r8c'] == 'check'){
$regeln = $regeln.'8';
}                  
if($_POST['r9c'] == 'check'){
$regeln = $regeln.'9';
}
//setze kmode neuzusammen    
if($geht == 1){
//Alles okay , speichere ab  
ausruest($userid);          
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
regeln,
wetter)
VALUES
('$kname',
'$kmode',  
'1',
'$kteam',
'$kart',
'1',
'0',
'$kpw',
'$ort',  
'$regeln',
'$owetter')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
$kid = mysqli_insert_id($con);     
$sql="UPDATE charaktere SET kampfid ='$kid',team ='1' WHERE id = '".$userid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}             
mysqli_close($con);          
$error = "Kampf wurde erstellt.<br>";
}
}
}
else{
$error = 'Du hast keine HP.';
}
}
}                                   
if(logged_in()){       
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
echo '<h3>Kampf</h3><br>';
$kampfid = getwert(session_id(),"charaktere","kampfid","session");
if($page == ""){
echo '<a href="kampf.php?page=erstellen">Kampf erstellen</a> <a href="kampf.php?page=log">Kampfberichte</a><br>';
echo '<br>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
teams,
mode,     
regeln,
art,
offen,
begin,
pw,
ende,
ort,
wetter
FROM
fights
WHERE ende ="0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td width="100px" class="tdbg tdborder">';
echo 'Name';
echo '</td>';
echo '<td width="100px" class="tdbg tdborder">';
echo 'Teams';
echo '</td>';
echo '<td width="160px" class="tdbg tdborder">';
echo 'Mode';
echo '</td>';    
echo '<td width="75px" class="tdbg tdborder">';
echo 'Regeln';
echo '</td>'; 
echo '<td width="60px" class="tdbg tdborder">';
echo 'Art';
echo '</td>'; 
echo '<td width="60px" class="tdbg tdborder">';
echo 'Wetter';
echo '</td>';
echo '<td width="60px" class="tdbg tdborder">';
echo 'Passwort';
echo '</td>';
echo '<td width="90px" class="tdbg tdborder">';
echo '</td>';             
if($admin == 3){
echo '<td width="40px" class="tdbg tdborder">';
echo '</td>';   
}
echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['ende'] == 0&&$row['ort'] == $ort||$row['ende'] == 0&&$row['art'] == "Wertung"||$row['ende'] == 0&&$row['art'] == "NPC"||$row['ende'] == 0&&$row['art'] == "Turnier"||$row['ende'] == 0&&$row['art'] == "Spaß"||$row['ende'] == 0&&$row['art'] == "Eroberung"||$row['ende'] == 0&&$row['art'] == "Bijuu"){
echo '<tr>';
echo '<td>'.$row['name'].'</td>';
echo '<td>';
$array = explode(";", trim($row['teams']));
$count = 0;
while(isset($array[$count])){   
$spieler = checkteam($array[$count],$row['id']);
$count2 = 0;
while($spieler[$count2] != ""){          
if(is_numeric($spieler[$count2])){
$sname = getwert($spieler[$count2],"charaktere","name","id");
}
else{
$sname = $spieler[$count2];
}
echo '<a href="user.php?id='.$spieler[$count2].'">'.$sname.'</a>';
echo ' ';
$count2++;
}
if($array[$count+1] != ""){
echo ' vs ';
}
$count++;
}
echo '</td>';
$count2 = 0;
echo '<td>';
echo $row['mode'];
echo '</td>';    
echo '<td>';
if($row['regeln'] != 0){    
$count = 0;
while($count != strlen($row['regeln'])){      
$regel = substr($row['regeln'],$count,1); 
if($regel == 1){
echo '<a class="sinfo">1<span class="spanmenu">Keine Verteidigung</span></a>';   
}                 
elseif($regel == 2){
echo '<a class="sinfo">2<span class="spanmenu">Keine Bunshin</span></a>';   
}                
elseif($regel == 3){
echo '<a class="sinfo">3<span class="spanmenu">Keine BeschWörungen</span></a>';   
}               
elseif($regel == 4){
echo '<a class="sinfo">4<span class="spanmenu">Keine Powerups</span></a>';   
}               
elseif($regel == 5){
echo '<a class="sinfo">5<span class="spanmenu">Keine Debuffs</span></a>';   
}                        
elseif($regel == 6){
echo '<a class="sinfo">6<span class="spanmenu">Keine Items</span></a>';   
}                             
elseif($regel == 7){
echo '<a class="sinfo">7<span class="spanmenu">Keine Heilung</span></a>';   
}               
elseif($regel == 8){
echo '<a class="sinfo">8<span class="spanmenu">Keine AOE</span></a>';   
}  
else{
echo '<a class="sinfo">9<span class="spanmenu">Kein Chakrapush</span></a>';   
}
$count++;
}
}
else{
echo 'Keine';
}
echo '</td>'; 
echo '<td>';
echo $row['art'];
echo '</td>'; 
echo '<td>';
echo $row['wetter'];
echo '</td>';
echo '<td>';
if($row['pw'] != ""){
echo '<font color="#3333ff">Ja</font>';
}
else{
echo '<font color="#33ff33">Nein</font>';
}
echo '</td>';
echo '<td>';
if($row['id'] == $kampfid&&$row['begin'] == 0){
echo '<a href="kampf.php?aktion=verlassen">Kampf verlassen</a>';
}
elseif($row['id'] == $kampfid&&$row['begin'] == 1){
echo '<a href="fight.php"><b>Kämpfen</b></a>';
}
elseif($row['id'] != $kampfid){
if($row['offen'] == 1&&$kampfid == 0||$row['offen'] == 0&&$row['begin'] == 0&&$kampfid == 0){
echo '<a href="kampf.php?page=beitreten&kid='.$row['id'].'">Kampf beitreten</a>';
}
else{
echo '<a href="log.php?kid='.$row['id'].'">Kampf zuschauen</a>';
}
}
echo '</td>';
if($admin == 3){
echo '<td>';  
echo '<div class="light">';
echo '<a href="admin.php?page=kampf&kampf='.$row['id'].'"><img src="bilder/design/join.png" width="40px" height="40px" border="0"></img></a>';
echo '</div>';
echo '</td>';
}
echo '</tr>';
}
}
$result->close(); $db->close(); 
echo '</table>';
}
else{
if($page == "log"){  
$kid = $_GET['kid'];
if($kid == ""){                                           
$seite = $_GET['seite'];
if($seite <= 1){
$seite = 1;
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
teams,
mode,
art,
offen,
begin,
pw,
ende,
spieler,
wetter,
regeln
FROM
fights
WHERE ende = "1"
ORDER BY
id DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';     
echo '<td width="50px" class="tdbg tdborder">';
echo 'ID';
echo '</td>';
echo '<td width="100px" class="tdbg tdborder">';
echo 'Name';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Teams';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Mode';
echo '</td>';    
echo '<td width="75px" class="tdbg tdborder">';
echo 'Regeln';
echo '</td>'; 
echo '<td width="60px" class="tdbg tdborder">';
echo 'Art';
echo '</td>'; 
echo '<td width="60px" class="tdbg tdborder">';
echo 'Wetter';
echo '</td>';  
echo '<td width="80px" class="tdbg tdborder">';
echo '</td>';
echo '</tr>';    
$platz = 0;
$ps = 30;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
//Seite 1 , 1-30
//Seite 2 , 31-60
//Seite 3 , 61-90
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['ende'] == 1){                                                       
$platz++;
if($platz >= $von&&$platz <= $bis){
echo '<tr>';                      
echo '<td>'.$row['id'].'</td>';
echo '<td>'.$row['name'].'</td>';
echo '<td>';
$array = explode(" ", trim($row['spieler']));
$count = 0;
while(isset($array[$count])){   
if($array[$count] != "vs"){
if(is_numeric($array[$count])){
$sname = getwert($array[$count],"charaktere","name","id");
}
else{
$sname = $array[$count];
}
if($sname == ""){
echo 'NoUser';
}
else{
echo '<a href="user.php?id='.$array[$count].'">'.$sname.'</a>';
}
}
else{
echo 'vs';
}
echo ' ';
$count++;
}
echo '</td>';
echo '<td>';
echo $row['mode'];
echo '</td>';
echo '<td>';
if($row['regeln'] != 0){    
$count = 0;
while($count != strlen($row['regeln'])){      
$regel = substr($row['regeln'],$count,1); 
if($regel == 1){
echo '<a class="sinfo">1<span class="spanmenu">Keine Verteidigung</span></a>';   
}                 
elseif($regel == 2){
echo '<a class="sinfo">2<span class="spanmenu">Keine Bunshin</span></a>';   
}                
elseif($regel == 3){
echo '<a class="sinfo">3<span class="spanmenu">Keine BeschWörungen</span></a>';   
}               
elseif($regel == 4){
echo '<a class="sinfo">4<span class="spanmenu">Keine Powerups</span></a>';   
}               
elseif($regel == 5){
echo '<a class="sinfo">5<span class="spanmenu">Keine Debuffs</span></a>';   
}                        
elseif($regel == 6){
echo '<a class="sinfo">6<span class="spanmenu">Keine Items</span></a>';   
}                             
elseif($regel == 7){
echo '<a class="sinfo">7<span class="spanmenu">Keine Heilung</span></a>';   
}               
elseif($regel == 8){
echo '<a class="sinfo">8<span class="spanmenu">Keine AOE</span></a>';   
}  
else{
echo '<a class="sinfo">9<span class="spanmenu">Kein Chakrapush</span></a>';   
}
$count++;
}
}
else{
echo 'Keine';
}
echo '</td>';
echo '<td>';
echo $row['art'];
echo '</td>';    
echo '<td>';
echo $row['wetter'];
echo '</td>';
echo '<td>';
echo '<a href="log.php?kid='.$row['id'].'">betrachten</a>';

echo '</td>';
echo '</tr>';
}
}
}
$result->close(); $db->close(); 
echo '</table>';      
$count = 1;
$anzahl = $platz;
if($platz > $ps){
while($platz > 0){
$platz = $platz-$ps;
echo '<a href="kampf.php?page=log&seite='.$count.'">'.$count.'</a> ';
$count++;
}  
} 
}
else{                       
echo '<center><div class="shadow">';
$klog = getwert($kid,"fights","log","id");
echo $klog;       
echo '</div></center>';

}

}
if($page == "beitreten"&&$kampfid == 0){
$kid = $_GET['kid'];  
if(is_numeric($kid)){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
begin,
offen,
mode,
pw,
teams,
ort,
art
FROM
fights
WHERE id = "'.$kid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['offen'] == 0){
$error = $error."Der Kampf hat schon gestartet.<br>";
}
else{
if($row['ort'] == $ort||$row['art'] == "Spaß"){
echo '<center><form method="post" action="kampf.php?aktion=beitreten&kid='.$row['id'].'">';
if($row['pw'] != ""){
echo '<div class="eingabe1">
<input class="eingabe2" name="pw" value="" size="15" maxlength="30" type="password">
</div><br>';
} 
$array = explode(";", trim($row['teams']));
$tanzahl = 0;
while($array[$tanzahl] != ""){
$tanzahl++;
}
while($c != 3&&$tanzahl != 0){ 
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';  
//Zeige erst die Teams an
$array = explode(";", trim($row['teams']));
$c2 = 0;
$count = 4*$c;
while($array[$count] != ""&&$c2 != 4){
echo '<td class="tdbg tdborder">';
echo 'Team '.$array[$count];
echo '</td>';
$count++;
$c2++;
$tanzahl--;
}
echo '</tr>';
echo '<tr>';
//Zeige die Spieler in den Teams
$count = 4*$c;
$c2 = 0;
while($array[$count] != ""&&$c2 != 4){
$spieler = checkteam($array[$count],$row['id']);
$count2 = 0;
$temmpteam = $array[$count]-1;
echo '<td class="tdborder">';
while($spieler[$count2] != ""){
$sname = getwert($spieler[$count2],"charaktere","name","id");
if($sname != ""){
echo '<a href="user.php?id='.$spieler[$count2].'">'.$sname.'</a>';
}
else{
echo '<a href="user.php?id='.$spieler[$count2].'">'.$spieler[$count2].'</a>';
}
echo ' ';
$count2++;
}
$spimteam[$temmpteam] = $count2;
echo '</td>';
$count++;
$c2++;
}
echo '</tr>';
echo '<tr>';
//überprüfe ob das Team frei ist
$array2 = explode("vs", trim($row['mode']));
$count = 4*$c;
$c2 = 0;
while($array2[$count] != ""&&$c2 != 4){
echo '<td height=30px>';
//Wenn das im Mode größer ist als wirkliche spieler im Team
if($array2[$count] > $spimteam[$count]){
$count2 = $count+1;
echo '<input class="button" name="join" id="login" value="Team '.$count2.' beitreten" type="submit">';
}
else{
echo 'Voll';
}
echo '</td>';
$count++;     
$c2++;
}
echo '</tr>';
echo '</table>';
echo '<br>';
$c++;
}  
echo '</form>';
}
else{
$error = "Dieser Kampf ist nicht an den selben Ort wie du.<br>";
}
}
}
$result->close(); $db->close(); 
}
}
if($page == "erstellen"&&$kampfid == 0){
echo '<br>Info: Kampf darf nicht mehr als 10 Spieler haben!<br>';
echo 'Beispiel: 1vs1vs1vs1vs1vs1vs1vs1vs1vs1 <font color="#00ff00">Geht</font><br>';
echo '7vs6 <font color="#ff0000">Geht nicht</font><br>';
echo '4vs2vs4 <font color="#00ff00">Geht</font><br>';
echo '3vs3vs3vs3vs3 <font color="#ff0000">Geht nicht</font><br><center>';
echo '<table class = "space">';
echo '<form method="post" action="kampf.php?aktion=erstellen">';
echo '<tr>';
echo '<td>Kampfname</td>';
echo '<td align=center>
<div class="eingabe1">
<input class="eingabe2" name="name" value="" size="15" maxlength="30" type="text">
</div>
</td>';
echo '</tr>';
echo '<tr>';   
echo '<td>Passwort</td>';
echo '<td align=center>
<div class="eingabe1">
<input class="eingabe2" name="pw" value="" size="15" maxlength="30" type="password">
</div>
</td>';
echo '</tr>';
echo '<tr>';   
echo '<td>Modus</td>';
echo '<td align=center>
<div class="eingabe1">
<input class="eingabe2" name="mode" value="1vs1" size="15" maxlength="40" type="text">
</div>
</td>';
echo '</tr>';
echo '<tr>';  
echo '<td>Kampfart</td>';
echo '<td align=center>
<div class="auswahl">
<select name="art">
<option selected>Spaß</option>
</select>
</div>
</td>';
echo '</tr>';
echo '<tr>';   
echo '<td>Wetter</td>';
echo '<td align=center>
<div class="auswahl">
<select name="wetter">          
<option selected>Zufall</option>  
<option>Sonne</option>  
<option>Regen</option>
<option>Gewitter</option>
<option>Hitze</option>   
<option>Erdrutsch</option> 
<option>Sturm</option>
</select>
</div>
</td>';
echo '</tr>';
echo '<tr>';    
echo '<td>Regeln</td>';
echo '<td align=center>
<a class="sinfo"><input class="cursor" type="checkbox" name="r1c" value="check"><span class="spanmenu">Keine Verteidigung</span></a>   
<a class="sinfo"><input class="cursor" type="checkbox" name="r2c" value="check"><span class="spanmenu">Keine Bunshin</span></a>   
<a class="sinfo"><input class="cursor" type="checkbox" name="r3c" value="check"><span class="spanmenu">Keine BeschWörungen</span></a>   
<a class="sinfo"><input class="cursor" type="checkbox" name="r4c" value="check"><span class="spanmenu">Keine Powerups</span></a>   
<a class="sinfo"><input class="cursor" type="checkbox" name="r5c" value="check"><span class="spanmenu">Keine Debuffs</span></a>   
<a class="sinfo"><input class="cursor" type="checkbox" name="r6c" value="check"><span class="spanmenu">Keine Items</span></a>   
<a class="sinfo"><input class="cursor" type="checkbox" name="r7c" value="check"><span class="spanmenu">Keine Heilung</span></a>   
<a class="sinfo"><input class="cursor" type="checkbox" name="r8c" value="check"><span class="spanmenu">Keine AOE</span></a>   
<a class="sinfo"><input class="cursor" type="checkbox" name="r9c" value="check"><span class="spanmenu">Kein Chakrapush</span></a>   
</td>'; 
echo '</tr>'; 
echo '<tr>';  
echo '<td colspan="2" align=center>
<input class="button" name="create" id="login" value="Erstellen" type="submit">
</td>';
echo '</tr>';
echo '</table></center>';
}
echo '<br><a href="kampf.php">Zurück</a><br>';
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