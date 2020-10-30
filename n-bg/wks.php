<?php
include 'inc/incoben.php';
if(logged_in()){     
$aktion = $_GET['aktion']; 
      $db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      session,
      siege,
      niederlagen,
      quotient,
      wksucht,
      wks,
      kampfid,
      hp,
      id
      FROM
      charaktere
      WHERE session="'.session_id().'" LIMIT 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false 
      $siege = $row['siege'];   
      $niederlagen = $row['niederlagen']; 
      $quotient = $row['quotient'];     
      $wksucht = $row['wksucht'];
      $wks = $row['wks'];
      $ukid = $row['kampfid']; 
      $uhp = $row['hp'];      
      $uid = $row['id'];
      }
      $result->close();    
      $db->close();   
if($aktion == 'suchen'){
if($wksucht == 1){
$wksucht = 0;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
$sql="UPDATE charaktere SET wksucht ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = 'Du suchst nun keinen Kampf mehr.';
}
else{
if($wks < 4){      
if($uhp != 0){      
if($ukid == 0){    
$wksucht = 1;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
$sql="UPDATE charaktere SET wksucht ='1' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);  
$error = 'Du wartest auf einen Gegner.';
}
else{
$error = 'In einem Kampf kannst du nicht suchen.';
}
}
else{
$error = 'Du hats nicht genügend HP.';
}
}
}
}
if($aktion == 'kampf'){
if($wks < 4){
if($uhp != 0){      
if($ukid == 0){
$gegner = 0;
      $db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      wksucht,
      hp,
      kampfid
      FROM
      charaktere
      WHERE wksucht="1" AND hp != "0" AND kampfid = "0" AND id != "'.$uid.'"
      LIMIT 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false 
      $gegner = $row['id'];
      }
      $result->close();    
      $db->close();   
if($gegner == 0){
$error = 'Es sucht momentan niemand nach einem Kampf, der für einen Kampf bereit ist.';
}
else{
ausruest($uid);   
ausruest($gegner);
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
('Wertungskampf',
'1vs1',
'1',
'1;2',
'Wertung',
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
$wks = $wks+1;          
$uname = getwert(session_id(),"charaktere","name","session"); 
$ubild = getwert(session_id(),"charaktere","kbild","session");  
$hp = getwert(session_id(),"charaktere","hp","session");    
$chakra = getwert(session_id(),"charaktere","chakra","session");
$sql="UPDATE charaktere SET 
kampfid ='$kid',
wksucht ='0',
wks ='$wks',
lkaktion ='$zeit',
kname ='$uname',
powerup='',
dstats='',
debuff='',
kkbild ='$ubild',
team='1',
shp ='$hp',
schakra ='$chakra'
 WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
      
$gwks = getwert($gegner,"charaktere","wks","id");     
$gwks = $gwks+1;
$gname = getwert($gegner,"charaktere","name","id");  
$gbild = getwert($gegner,"charaktere","kbild","id");
$ghp = getwert($gegner,"charaktere","hp","id");      
$gchakra = getwert($gegner,"charaktere","chakra","id");
$sql="UPDATE charaktere SET 
kampfid ='$kid',
wksucht ='0',
wks ='$gwks',
lkaktion ='$zeit',
kname ='$gname',
powerup='',
dstats='',
debuff='',
kkbild ='$gbild',
team='2',
shp ='$ghp',
schakra ='$gchakra'
 WHERE id = '".$gegner."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                                           
$error = 'Kampf wurde gestartet.';
}
}
else{
$error = 'Du bist bereits in einem Kampf.';
}
}
else{
$error = 'Du hast zuwenig HP.';
}
}
else{
$error = 'Du kannst nur vier Wertungskämpfe am Tag machen.';
}
}

}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                                           
//Hier kommt der Code hin
echo '<h3>Wertungskämpfe</h3>';  
$quotient = getwert(session_id(),"charaktere","quotient","session");
//Hier kommt der Code hin
echo '<br>';
echo '<b class="shadow">Deine Siege</b>:  '.$siege.'<br>';   
echo '<b class="shadow">Deine Niederlagen</b>:  '.$niederlagen.'<br>'; 
echo '<br>';                  
echo '<b class="shadow">Dein Quotient</b>:  '.$quotient.'<br>';
echo '<b class="shadow">Heutige Kämpfe</b>:  '.$wks.'<br>';     
echo '<br>';
      $db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      wksucht,
      hp,
      kampfid,
      session
      FROM
      charaktere
      WHERE wksucht="1" AND hp != "0" AND kampfid = "0"';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }
      $sucher = 0;
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false 
      $sucher++;
      }
      $result->close();    
      $db->close();  
if($sucher == 1){
echo 'Es sucht gerade eine Person nach einem Kampf.';
}
elseif($sucher == 0){
echo 'Es sucht gerade niemand nach einen Kampf.';
}                                             
else{   
echo 'Es suchen gerade '.$sucher.' Personen nach einem Kampf.';
}
echo '<br>';
echo '<br>';  
if($wks < 4){
echo '<a href="wks.php?aktion=suchen">';      
if($wksucht == 0){
echo 'Kampf suchen';
}
else{
echo 'Suche stoppen';
}     
echo '</a>';
echo '<br>';
if($sucher != 0){
if($wksucht == 0||$wksucht == 1&&$sucher != 1){
echo '<a href="wks.php?aktion=kampf">';
echo 'Kampf starten';
echo '</a>';
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