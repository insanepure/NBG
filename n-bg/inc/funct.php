<?php   
//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;

function SendMail($email, $topic, $message)
{
  $sender   = "noreply@n-bg.de";

  $content = file_get_contents('mail.php');
  $content = str_replace("{0}", $topic, $content);
  $content = str_replace("{1}", $message, $content);

  
// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Set who the message is to be sent from
$mail->setFrom($sender, 'NBG - das Naruto Browsergame');
//Set an alternative reply-to address
$mail->addReplyTo($sender, 'NBG - das Naruto Browsergame');
//Set who the message is to be sent to
$mail->addAddress($email, 'User');
//Set the subject line
$mail->Subject = $topic;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($content);
//Replace the plain text body with one created manually
$mail->AltBody = $message;

if($mail->send())
{
  return true;
}
else
{
  echo $mail->ErrorInfo;
  return false;
}
  
//send the message, check for errors
//if (!$mail->send()) {
//    echo 'Mailer Error: '. $mail->ErrorInfo;
//} else {
//    echo 'Message sent!';
//}
  
}

function real_escape_string($unescaped) 
{
  $replacements = array(
     "\x00"=>'\x00',
     "\n"=>'\n',
     "\r"=>'\r',
     "\\"=>'\\\\',
     "'"=>"\'",
     '"'=>'\"',
     "\x1a"=>'\x1a'
  );
  return strtr($unescaped,$replacements);
}
function checkevent(){   
include 'serverdaten.php'; 
//Mein Kater hat mir geholfen!! xDD     
$date = date("d.m.Y",time());
$date = explode('.',$date);
$tag = $date[0];
$monat = $date[1];
$jahr = $date[2];
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
start,
end,
id
FROM
events';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$start = $row['start'].'.'.$jahr;
$end = $row['end'].'.'.$jahr;
$start = strtotime($start);
$end = strtotime($end);
if($start <= time()&&$end >= time())
{
return $row['id'];
}
}
$result->close();$db->close();
}
function teambewerbung($org){  
$check = '';
$check = getwert($org,"charaktere","name","oapply");   
if($check){
return 'jo';
}
}
function teamkampfleave($org,$uid){      
include 'serverdaten.php';      
$teamkampf = getwert($org,"org","teamkampf","id");   
if($teamkampf != ''){
//NPC@User;User;User       
$array = explode("@", trim($teamkampf)); 
$users = explode(";", trim($array[1]));  
$count = 0;
$newteam = '';
$anzahl = 0;
while($users[$count] != ''){
if($users[$count] != $uid){
if($newteam == ''){
$newteam = $users[$count];
$anzahl++;
}
else{
$newteam = $newteam.';'.$users[$count];  
$anzahl++;
}
}
$count++;
}
if($anzahl != 0){
$newteamkampf = $array[0].'@'.$newteam;
}
else{
$newteamkampf = '';
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$sql="UPDATE org SET teamkampf='".$newteamkampf."' WHERE id='".$org."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));  
} 
mysqli_close($con);
}
}
function checkhatitem($item){       
include 'serverdaten.php';      
$uid = getwert(session_id(),"charaktere","id","session");   
$hatitem = 0;
if($item == ""){
$hatitem = 1;
}
else{   
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
id,
besitzer,
angelegt
FROM
items
WHERE besitzer="'.$uid.'" AND name="'.$item.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['angelegt'] == 'LHand'||$row['angelegt'] == 'RHand'||$row['angelegt'] == 'LHand&RHand'){
$hatitem = 1;
}
}
$result->close();  
}
return $hatitem; 
}
function get_real_ip()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }
    $ip = hash('sha256', 'itsa'.$ip.'ip');
    
    return $ip;
}
function angebote($item)
{
include 'serverdaten.php';  
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name
FROM
markt
where name="'.$item.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}     
$anzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$anzahl++;
}
$result->close(); $db->close();
return $anzahl;
}
function supporton()
{
include 'serverdaten.php';  
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
session,
admin
FROM
charaktere
WHERE session != "" AND admin != "0"
ORDER BY
two ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}           
$anzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$anzahl++;
}
$result->close(); $db->close();
return $anzahl;
}
function turnierset($uid){  
include 'serverdaten.php';        
$turnier = getwert($uid,"charaktere","turnier","id");   
$trunde = getwert($uid,"charaktere","trunde","id");    
$two = getwert($uid,"charaktere","two","id");       
$urunde = $trunde+1;    

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
where turnier = "'.$turnier.'" AND trunde = "'.$trunde.'" AND two = "'.$two.'" AND id != '.$uid.'
ORDER BY
two ASC
LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gegner = $row['id'];
}
$result->close(); $db->close();           
if($two%2){
$uwo = ($two+1)/2;
}
else{
$uwo = $two/2;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$arunde = $urunde-1;
$sql="UPDATE turnierstats SET was ='2' WHERE spieler = '".$uid."' AND runde = '$arunde' AND turnier='$turnier' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));  
} 
$sql="UPDATE charaktere SET trunde ='$urunde',two ='$uwo' WHERE id = '".$uid."' LIMIT 1";
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
'$uid',  
'$urunde',
'$uwo')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
if($gegner != ""){
$sql="UPDATE charaktere SET turnier ='0',two ='0',trunde ='0' WHERE id = '".$gegner."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));  
}
$sql="UPDATE turnierstats SET was ='1' WHERE spieler = '".$gegner."' AND runde = '$arunde' AND turnier='$turnier' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));  
} 
}
mysqli_close($con);

}
function chato($wo){  
include '../chat/inc/serverdaten.php';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT id FROM user WHERE raum="NBG"'; 
$result = $db->query($sql);
$on = $result->num_rows;
$result->close(); $db->close();  
return $on;
}
function levelup($uid,$exp){  
include 'serverdaten.php';      
$uexp = getwert($uid,"charaktere","exp","id");  
$mexp = getwert($uid,"charaktere","mexp","id");  
$ulevel = getwert($uid,"charaktere","level","id"); 
$ustats = getwert($uid,"charaktere","statspunkte","id"); 
$nexp = $uexp+$exp;    
$statsgain = 0;

      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
while($nexp >= $mexp){ 
if($ulevel != 70){
$nexp = $nexp-$mexp;      
$ulevel = $ulevel+1; 
$tempint = ($ulevel)/10;
$tempint = ceil($tempint);
$tempint =$tempint*10;
$mexp = $mexp+$tempint;                        
$ustats = $ustats+round(10*$ulevel);
$statsgain = $statsgain + round(10*$ulevel);
if($ulevel == 70){
$nexp = 0;
}     
            
$uclan = getwert($uid,"charaktere","clan","id"); 
$urank = getwert($uid,"charaktere","rank","id"); 
if($urank == 'genin'){
if($ulevel >= 30){
 $sql="UPDATE charaktere SET rank ='chuunin' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du wurdest zum Chuunin befördert.';
$betreff = 'Beförderung';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($uclan == "kugutsu"){
if($ulevel == 30||$ulevel == 40){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du hast Post von einer unbekannten Person bekommen. Treffe dich mit ihr in der Windwüste.';
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
} 
if($uclan == "jiongu"){
if($ulevel == 20||$ulevel == 30||$ulevel == 40){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du solltest dich auf den Weg machen ein neues Herz zu holen. Gehe dazu zum Totbaumwald.';
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
} 
if($uclan == "inuzuka"){
if($ulevel == 15||$ulevel == 30){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Ein Clanmitglied erwartet dich im Wald.';
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}               
if($uclan == "schlange"||$uclan == "frosch"){  
if($ulevel == 40){

$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
if($uclan == "schlange"){
$text = 'Manda erwartet dich am Bergpass.';
}                           
if($uclan == "frosch"){
$text = 'Gamabunta erwartet dich im Wald.';
}
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($uclan == "senninka"||$uclan == "hozuki"||$uclan == "kurama"||$uclan == 'jashin'){  
if($ulevel == 40||$ulevel == 20&&$uclan == "senninka"||$ulevel == 20&&$uclan == 'jashin'){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
if($uclan != 'jashin'){
$text = 'Man erwartet dich in einem Dorf.';
}
else{
$text = 'Man erwartet dich im Totbaumwald.';
}
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($uclan == 'jinchuuriki modoki'){
if($ulevel == 15||$ulevel == 20||$ulevel == 25||$ulevel == 30||$ulevel == 40){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du wirst am Bergpass erwartet.';
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($uclan == 'roku pasu'){
if($ulevel == 30){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du wirst auf der Tenchi Brücke erwartet.';
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($uclan == 'ishoku sharingan'){
if($ulevel == 20||$ulevel == 30||$ulevel == 35){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du wirst in Tanzaku erwartet.';
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}           
$ukbutton = getwert($uid,"charaktere","kbutton","id"); 
$ujutsus = getwert($uid,"charaktere","jutsus","id");   
$array = explode(";", trim($ujutsus)); 
$count = 0;
$shari2 = 0;
$shari3 = 0;
while(isset($array[$count])){   
if($array[$count] == 371){
$shari2 = 1;
}
if($array[$count] == 372){
$shari3 = 1;
}
$count++;
}
if($ulevel >= 30&&$shari2 == 1&&$shari3 == 0){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du hast das Sharingan 3 erlernt.';
$betreff = 'Neues Jutsu';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$array = explode(";", trim($ujutsus)); 
$count = 0;
$njutsus = "";
while(isset($array[$count])){   
if($array[$count] == "371"){
$array[$count] = "372";
}
if($njutsus == ""){
$njutsus = $array[$count];
}
else{
$njutsus = $njutsus.';'.$array[$count];
}
$count++;
}
$array = explode(";", trim($ukbutton)); 
$count = 0;
$nkbutton = "";
while(isset($array[$count])){   
if($array[$count] == "371"){
$array[$count] = "372";
}
if($nkbutton == ""){
$nkbutton = $array[$count];
}
else{
$nkbutton = $nkbutton.';'.$array[$count];
}
$count++;
}     $sql="UPDATE charaktere SET jutsus ='$njutsus',kbutton ='$nkbutton' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      } 
}
if($ulevel >= 20&&$shari2 == 0&&$shari3 == 0){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du hast das Sharingan 2 erlernt.';
$betreff = 'Neues Jutsu';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$array = explode(";", trim($ujutsus)); 
$count = 0;
$njutsus = "";
while(isset($array[$count])){   
if($array[$count] == "370"){
$array[$count] = "371";
}
if($njutsus == ""){
$njutsus = $array[$count];
}
else{
$njutsus = $njutsus.';'.$array[$count];
}
$count++;
}
$array = explode(";", trim($ukbutton)); 
$count = 0;
$nkbutton = "";
while(isset($array[$count])){   
if($array[$count] == "370"){
$array[$count] = "371";
}
if($nkbutton == ""){
$nkbutton = $array[$count];
}
else{
$nkbutton = $nkbutton.';'.$array[$count];
}
$count++;
}  $sql="UPDATE charaktere SET jutsus ='$njutsus',kbutton ='$nkbutton' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      } 
}
}
if($uclan == "uchiha"){  
if($ulevel == 40){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Ein Clanmitglied erwartet dich im Wald.';
$betreff = 'Clanmission';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($ulevel == 10||$ulevel == 20||$ulevel == 30){   
$ukbutton = getwert($uid,"charaktere","kbutton","id"); 
$ujutsus = getwert($uid,"charaktere","jutsus","id"); 
if($ulevel == 10){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du hast das Sharingan 1 erlernt.';
$betreff = 'Neues Jutsu';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$njutsus = $ujutsus.';24';
$array = explode(";", trim($ukbutton)); 
$count = 0;
while(isset($array[$count])){   
$count++;
}
if($count < 10){
$nkbutton = $ukbutton.';24';
}
else{
$nkbutton = $ukbutton;
}
}
if($ulevel == 20){  
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Dein Sharingan 1 hat sich zu einem Sharingan 2 weiterentwickelt.';
$betreff = 'Neues Jutsu';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$array = explode(";", trim($ujutsus)); 
$count = 0;
$njutsus = "";
while(isset($array[$count])){   
if($array[$count] == "24"){
$array[$count] = "10";
}
if($njutsus == ""){
$njutsus = $array[$count];
}
else{
$njutsus = $njutsus.';'.$array[$count];
}
$count++;
}
$array = explode(";", trim($ukbutton)); 
$count = 0;
$nkbutton = "";
while(isset($array[$count])){   
if($array[$count] == "24"){
$array[$count] = "10";
}
if($nkbutton == ""){
$nkbutton = $array[$count];
}
else{
$nkbutton = $nkbutton.';'.$array[$count];
}
$count++;
}
}
if($ulevel == 30){ 
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Dein Sharingan 2 hat sich zu einem Sharingan 3 weiterentwickelt.';
$betreff = 'Neues Jutsu';
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',  
'$uid',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$array = explode(";", trim($ujutsus)); 
$count = 0;
$njutsus = "";
while(isset($array[$count])){   
if($array[$count] == "10"){
$array[$count] = "27";
}
if($njutsus == ""){
$njutsus = $array[$count];
}
else{
$njutsus = $njutsus.';'.$array[$count];
}
$count++;
}
$array = explode(";", trim($ukbutton)); 
$count = 0;
$nkbutton = "";
while(isset($array[$count])){   
if($array[$count] == "10"){
$array[$count] = "27";
}
if($nkbutton == ""){
$nkbutton = $array[$count];
}
else{
$nkbutton = $nkbutton.';'.$array[$count];
}
$count++;
}
}

 $sql="UPDATE charaktere SET jutsus ='$njutsus',kbutton ='$nkbutton' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }  
      } 
      }
}
else{
$nexp = 0;
}
}
      $sql="UPDATE charaktere SET level ='$ulevel',exp ='$nexp',mexp ='$mexp',statspunkte ='$ustats' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }   
        $sql="UPDATE summon SET statspunkte = statspunkte+$statsgain WHERE besitzer = '".$uid."'";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }   
      mysqli_close($con); 
}
function ausruest($uid){   
include 'serverdaten.php';   
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
function checkslots($uid){   
include 'serverdaten.php';   
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
typ,
angelegt
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$slotsb = 0;
$slotsa = 20;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['angelegt'] == ""){     
$slotsb++;
}                  
elseif($row['angelegt'] != ""){ 
if($row['typ'] == 3){     
$iwerte = getwert($row['name'],"item","werte","name");                         
$array = explode(";", trim($iwerte));
$islots = $array[6];
if($islots != 0){
$slotsa = $slotsa+$islots;
}
}
}
}
$result->close();$db->close();
$slots[0] = $slotsa;
$slots[1] = $slotsa-$slotsb;
if($slots[1] < 0){
$slots[1] = 0;
}
//$slots[0] = gesamt
//$slots[1] = freie
return $slots;
}
function reise($uid){     
include 'serverdaten.php';       
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
      $rwo = getwert($uid,"charaktere","rwo","id");
      $rweg = getwert($uid,"charaktere","rweg","id");
      $ort = getwert($uid,"charaktere","ort","id");
      $odauer = getwert($ort,"orte","rdauer","id");   
      if($rweg == "weiter"){
      $rwo = $rwo+1; 
      }
      if($rweg == "back"){
      $rwo = $rwo-1; 
      }              
      if($rwo <= 0&&$rweg == "back"){                                  
      $reise = getwert($uid,"charaktere","reise","id");       
      $array = explode(";", trim($reise)); 
      $ort = $array[0];  
      $sql="UPDATE charaktere SET rweg ='',reise ='',ort ='$ort',rwo ='0' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }          
      mysqli_close($con); 
      
      }                  
      elseif($rwo == $odauer&&$rweg == "weiter"){                                             
      $reise = getwert($uid,"charaktere","reise","id");       
      $array = explode(";", trim($reise)); 
      $ort = $array[1];  
      $sql="UPDATE charaktere SET rweg ='',ort ='$ort',rwo ='0',reise ='' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      } 
      //Mission            
      $umissi = getwert($uid,"charaktere","mission","id");   
$uwo = getwert(session_id(),"charaktere","mwo","session");
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
      punkte
      FROM
      missions
      WHERe id="'.$umissi.'" LIMIT 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }
      $count = 0;
      $istda = 0;
      $geht = 0;
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
      $array = explode("@", trim($row['wo']));  
      $array2 = explode("$", trim($array[$uwo]));  
      while($array2[$count] != ""){
      if($array2[$count] == $ort){
      $istda = 1;
      }
      $count++;
      }
      if($istda == 1){
      $array = explode("@", trim($row['was']));
      $was = $array[$uwo];
      $array = explode("@", trim($row['art']));
      $art = $array[$uwo];
      if($art == 3){
      $geht = 1;
      }
      }
      }
      $result->close();  
      mysqli_close($con);      
      if($geht == 1){      
      mission($uid);
      }
      
      
      } 
      else{ 
      $sql="UPDATE charaktere SET rwo ='$rwo' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));   
      mysqli_close($con); 
      } 
      }
      
}   
function saktion($saktion,$summon,$uclan,$edo){
include 'serverdaten.php';  
$geht = 1;         
//trainieren
$trainieren = substr($saktion,-10);
if($trainieren == "trainieren"||$trainieren == 'verbessern'){           
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
if($wert == "Widerstand"){
$wert = 'wid';
} 
$uwert = getwert($summon,"summon",$wert,"id");     
$aktiond = getwert($summon,"summon","aktiond","id"); 
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
if($wert == "hp"||$wert == "chakra"){    
$uwertm = getwert($summon,"summon","m$wert","id");   
$nwert = $uwert+(floor($aktiond/60)*10);
if($nwert > $maxwert){
$nwert = $maxwert;
}
$nwertm = $uwertm+(floor($aktiond/60)*10);
if($nwertm > $maxwert){
$nwertm = $maxwert;
}
}
else{
$nwert = $uwert+floor($aktiond/60);  
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
  $hours = floor($aktiond/60);
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
else if($saktion == "Reperatur"||$saktion == 'Heilen'){    
$umhp = getwert($summon,"summon","mhp","id"); 
$umchakra = getwert($summon,"summon","mchakra","id");    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
$sql="UPDATE summon SET hp ='$umhp',chakra ='$umchakra' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con);  
}
if($saktion == "Erholen"||$saktion == 'Reparieren'){    
$aktiond = getwert($summon,"summon","aktiond","id");  
$aktiond = $aktiond/60;
$uhp = getwert($summon,"summon","hp","id");    
$umhp = getwert($summon,"summon","mhp","id"); 
$uchakra = getwert($summon,"summon","chakra","id");    
$umchakra = getwert($summon,"summon","mchakra","id");    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
if($uhp < $umhp){
$nhp = ($umhp/10)*$aktiond;
$nhp = round($nhp);
$uhp = $uhp+$nhp;
if($uhp > $umhp){
$uhp = $umhp;
}
$sql="UPDATE summon SET hp ='$uhp' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}
if($uchakra < $umchakra){
$nchakra = ($umchakra/10)*$aktiond;  
$nchakra = round($nchakra);  
$uchakra = $uchakra+$nchakra;
if($uchakra > $umchakra){
$uchakra = $umchakra;
}
$sql="UPDATE summon SET chakra ='$uchakra' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}
mysqli_close($con);  
}
if($geht == 1){  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
$sql="UPDATE summon SET aktion ='',aktiond ='0' WHERE id = '".$summon."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
mysqli_close($con); 
}
}

function uaktion($uaktion){    
include 'serverdaten.php';  
$geht = 1;                            
$uid = getwert(session_id(),"charaktere","id","session");      
$ukid = getwert(session_id(),"charaktere","kampfid","session");  
if($ukid == 0){
if($uaktion == "Krankenhausbesuch"){          
$umhp = getwert(session_id(),"charaktere","mhp","session"); 
$umchakra = getwert(session_id(),"charaktere","mchakra","session"); 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
$sql="UPDATE charaktere SET hp ='$umhp',chakra ='$umchakra' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
mysqli_close($con); 
}
if($uaktion == "Mission"){  
mission($uid);
}
if($uaktion == "Entspannen"){    
$aktiond = getwert(session_id(),"charaktere","aktiond","session");  
$aktiond = $aktiond/60;
$uhp = getwert(session_id(),"charaktere","hp","session");    
$umhp = getwert(session_id(),"charaktere","mhp","session"); 
$uchakra = getwert(session_id(),"charaktere","chakra","session");    
$umchakra = getwert(session_id(),"charaktere","mchakra","session");    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
if($uhp < $umhp){
$nhp = ($umhp/10)*$aktiond;
$nhp = round($nhp);
$uhp = $uhp+$nhp;
if($uhp > $umhp){
$uhp = $umhp;
}
$sql="UPDATE charaktere SET hp ='$uhp' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}
if($uchakra < $umchakra){
$nchakra = ($umchakra/10)*$aktiond;  
$nchakra = round($nchakra);  
$uchakra = $uchakra+$nchakra;
if($uchakra > $umchakra){
$uchakra = $umchakra;
}
$sql="UPDATE charaktere SET chakra ='$uchakra' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}
mysqli_close($con);  
}
//trainieren
$trainieren = substr($uaktion,-10);
if($trainieren == "trainieren"){           
$wert = substr($uaktion,0,-11); 
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
$uwert = getwert(session_id(),"charaktere",$wert,"session");    
$uwertm = getwert(session_id(),"charaktere","m$wert","session");    
$aktiond = getwert(session_id(),"charaktere","aktiond","session"); 
if($wert == "hp"||$wert == "chakra"){
$nwert = $uwert+(floor($aktiond/60)*10);
if($nwert > 100000){
$nwert = 100000;
}
$nwertm = $uwertm+(floor($aktiond/60)*10);
if($nwertm > 100000){
$nwertm = 100000;
}
}
else{
$nwert = $uwert+floor($aktiond/60);  
if($nwert > 10000){
$nwert = 10000;
}
$nwertm = $uwertm+floor($aktiond/60);
if($nwertm > 10000){
$nwertm = 10000;
}
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET $wert ='$nwert',m$wert ='$nwertm' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
mysqli_close($con); 
}
//lernen
$lern = substr($uaktion,-6);
if($lern == "lernen"){           
$jutsu = substr($uaktion,0,-7);
if($jutsu == "Katon"||$jutsu == "Raiton"||$jutsu == "Doton"||$jutsu == "Fuuton"||$jutsu == "Suiton"){
$uelemente = getwert(session_id(),"charaktere","elemente","session"); 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($uelemente == ""){
$nelemente = $jutsu;
}
else{
$nelemente = $uelemente.';'.$jutsu;
}
$sql="UPDATE charaktere SET elemente ='$nelemente' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");  
$ukbutton = getwert(session_id(),"charaktere","kbutton","session"); 
$jid = getwert($jutsu,"jutsus","id","name");
$array = explode(";", trim($ukbutton));
$anzahl = 0;
while($array[$anzahl] != ""){
$anzahl++;
}      
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$njutsus = $ujutsus.';'.$jid;  
$sql="UPDATE charaktere SET jutsus ='$njutsus' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
if($anzahl < 10){
$nkbutton = $ukbutton.';'.$jid;
$sql="UPDATE charaktere SET kbutton ='$nkbutton' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 

}     
}
mysqli_close($con); 
}
     
if($uaktion == 'Direkte Reise'){          
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
      $reise = getwert($uid,"charaktere","reise","id");       
      $array = explode(";", trim($reise)); 
      $ort = $array[1];  
      $sql="UPDATE charaktere SET ort ='$ort',rwo ='0',reise ='',rweg ='' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      } 
      //Mission            
      $umissi = getwert($uid,"charaktere","mission","id");   
$uwo = getwert(session_id(),"charaktere","mwo","session");
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
      punkte
      FROM
      missions
      WHERE id="'.$umissi.'" LIMIT 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }
      $count = 0;
      $istda = 0;
      $geht = 0;
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
      $array = explode("@", trim($row['wo']));  
      $array2 = explode("$", trim($array[$uwo]));  
      while($array2[$count] != ""){
      if($array2[$count] == $ort){
      $istda = 1;
      }
      $count++;
      }
      if($istda == 1){
      $array = explode("@", trim($row['was']));
      $was = $array[$uwo];
      $array = explode("@", trim($row['art']));
      $art = $array[$uwo];
      if($art == 3){
      $geht = 1;
      }
      }
      }
      $result->close();  
      mysqli_close($con);      
      if($geht == 1){      
      mission($uid);
      }
$geht = 1;           
}
if($uaktion == "Leichter Weg"||$uaktion == "Normaler Weg"||$uaktion == "Harter Weg"){
//Zufall = 1 -> Gegner
//Zufall = 2 -> NPC
//Zufall = 3 -> Nichts
//ZUfall = 4 -> Items
if($uaktion == "Leichter Weg"){    
$geht = 1;                                                 
$rweg = getwert(session_id(),"charaktere","rweg","session");                     
$rwo = getwert(session_id(),"charaktere","rwo","session");    
if($rweg == "back"&&$rwo == 0){
$zufall = 3;
}
else{                
$zufall = rand(2,8);  
if($zufall >= 5){
$zufall = 3;
}  
}
} 
if($uaktion == "Normaler Weg"||$uaktion == "Harter Weg"){      
$uhp = getwert(session_id(),"charaktere","hp","session"); 
if($uhp == 0){
$geht = 0;
}
if($uaktion == "Normaler Weg"){
$zufall = rand(1,2);      
if($zufall == 1){
$gegner = rand(1,3);
}
else{   
$zufall = rand(2,6);
if($zufall >= 5){
$zufall = 3;
}
}  
}
if($uaktion == "Harter Weg"){
$zufall = 1;      
$gegner = rand(2,5);  
}                
if($geht == 1){
if($zufall == 1){
//Kampf   
$count = 0;
while($count != $gegner){
if($uaktion == "Normaler Weg"){   
$zufall = rand(1,5);    
if($zufall == 1){
$gname[$count] = "56"; //Katze ID
}         
if($zufall == 2){
$gname[$count] = "2"; //Bandit ID
}                    
if($zufall == 3){
$gname[$count] = "63"; //Hund ID
}          
if($zufall == 4){
$gname[$count] = "85"; //Ninja ID
}                
if($zufall == 5){
$gname[$count] = "79"; //Spion ID
}  
}
if($uaktion == "Harter Weg"){   
$zufall = rand(1,7);                 
if($zufall == 1){
$gname[$count] = "79"; //Spion ID
}             
if($zufall == 2){
$gname[$count] = "118"; //Bandit führer ID
}                    
if($zufall == 3){
$gname[$count] = "97"; //Wolf ID
}    
if($zufall == 4){
$gname[$count] = "117"; //Banditen Anführer ID
}
if($zufall == 5){
$gname[$count] = "119"; //Juin Monster ID
}
if($zufall == 6){
$gname[$count] = "78"; //A-Rank-Killer ID
}  
if($zufall == 7){
$gname[$count] = "84"; //B Krieger ID
}
}
$count++;
}
$kmode = '1vs'.$gegner;   
$teams = '1;2';
$kname = "Überfall";  
$ort = getwert(session_id(),"charaktere","ort","session");    
$uid = getwert(session_id(),"charaktere","id","session");
ausruest($uid);
$owetter = getwert($ort,"orte","wetter","id");
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
'Reise',
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
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);        
$uname = getwert(session_id(),"charaktere","name","session");   
$ubild = getwert(session_id(),"charaktere","kbild","session");
$sql="UPDATE charaktere SET team ='1',debuff ='',powerup ='',dstats ='',kkbild ='$ubild',kname ='$uname',lkaktion ='$zeit',kampfid ='$kid',reisenpc ='0',reiseitem ='0',reiseianzahl ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                    
$count = 0;
while($count != $gegner){
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
WHERE id="'.$gname[$count].'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$nteam = 2;   
$npc = $row['name'];
$nkr = $row['kr'];
$nhp = $row['hp'];
$nchakra = $row['chakra'];
$nwid = $row['wid'];
$ntmp = $row['tmp'];
$ngnk = $row['gnk'];
$nintl = $row['intl'];
$nchrk = $row['chrk'];
$nkbild = $row['kbild'];
$njutsus = $row['jutsus'];
$vertag = $row['vgemacht'];

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
$result->close();
$db->close();
$count++;
} 
mysqli_close($con);
$zufall = 0;
}  

}
}
if($geht == 1){

if($zufall == 2){  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));      
$zufall = rand(1,8);
if($zufall < 5&&$zufall >= 1){     
$zufall = rand(1,4);  
if($zufall == 1){
$sql="UPDATE charaktere SET reisenpc ='19' WHERE id = '".$uid."' LIMIT 1";
}   
if($zufall == 2){
$sql="UPDATE charaktere SET reisenpc ='98' WHERE id = '".$uid."' LIMIT 1";
}        
if($zufall == 3){
$sql="UPDATE charaktere SET reisenpc ='102' WHERE id = '".$uid."' LIMIT 1";
}        
if($zufall == 4){
$sql="UPDATE charaktere SET reisenpc ='101' WHERE id = '".$uid."' LIMIT 1";
}     
}
if($zufall >= 5){     
$zufall = rand(1,10);
if($zufall == 1){
$sql="UPDATE charaktere SET reisenpc ='14' WHERE id = '".$uid."' LIMIT 1";
}
if($zufall == 2){
$sql="UPDATE charaktere SET reisenpc ='44' WHERE id = '".$uid."' LIMIT 1";
}
if($zufall == 3){
$sql="UPDATE charaktere SET reisenpc ='45' WHERE id = '".$uid."' LIMIT 1";
} 
if($zufall == 4){
$sql="UPDATE charaktere SET reisenpc ='146' WHERE id = '".$uid."' LIMIT 1";
}   
if($zufall == 5){
$sql="UPDATE charaktere SET reisenpc ='152' WHERE id = '".$uid."' LIMIT 1";
}   
if($zufall == 6){
$sql="UPDATE charaktere SET reisenpc ='158' WHERE id = '".$uid."' LIMIT 1";
} 
if($zufall == 7){
$sql="UPDATE charaktere SET reisenpc ='164' WHERE id = '".$uid."' LIMIT 1";
}  
if($zufall == 8){
$sql="UPDATE charaktere SET reisenpc ='170' WHERE id = '".$uid."' LIMIT 1";
}     
if($zufall == 9){
$sql="UPDATE charaktere SET reisenpc ='176' WHERE id = '".$uid."' LIMIT 1";
}   
if($zufall == 10){
$sql="UPDATE charaktere SET reisenpc ='182' WHERE id = '".$uid."' LIMIT 1";
}
}
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }  
mysqli_close($con);   
reise($uid);        
$zufall = 0;
}
elseif($zufall == 3){  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="UPDATE charaktere SET reisenpc ='0',reiseitem ='0',reiseianzahl ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }    
mysqli_close($con);  
reise($uid);  
$zufall = 0;
} 
elseif($zufall == 4){  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));                              
$ulevel = getwert(session_id(),"charaktere","level","session");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
level,
preis,
name
FROM
item
WHERE inshop != "0" AND level <= "'.$ulevel.'" AND shop != "puppe"
ORDER BY
level DESC,
preis DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$wert1 = 0.0;
$item = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
if($item == 0){  
$zufall = rand(1,30);
if($zufall == 1){
$item = $row['id']; 
if($wert1 >= 2){    
$itema = rand(1,round($wert1));
}
else{
$itema = 1;
}
}
else{
if($wert1 < 10){
$zufall2 = rand(1,2);
$wert1 = $wert1+($zufall2/10);
}
}
}
}                                                      
$result->close(); $db->close(); 
if($item != 0){
$sql="UPDATE charaktere SET reisenpc ='0',reiseitem ='$item',reiseianzahl ='$itema' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
}
else{
$sql="UPDATE charaktere SET reisenpc ='0',reiseitem ='0',reiseianzahl ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }   
} 
mysqli_close($con);  
reise($uid);  
$zufall = 0; 
} 
}
}
if($geht == 1){
if($uaktion == "Leichter Weg"||$uaktion == "Normaler Weg"||$uaktion == "Harter Weg"||$uaktion == "Direkte Reise"||$uaktion == "Mission"){
$missi = getwert($uid,"charaktere","mission","id");      
$ulevel = getwert($uid,"charaktere","level","id");
if($missi != 0&&$ulevel == 70){
$aktiond = getwert($uid,"charaktere","aktiond","id");  
$izeit = getwert($uid,"charaktere","izeit","id");
$izeit = $izeit+$aktiond;     
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
$sql="UPDATE charaktere SET izeit='$izeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
mysqli_close($con);
}
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
$sql="UPDATE charaktere SET aktion ='',aktiond ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      } 
mysqli_close($con); 
}
}
}


function mission($uid){  
include 'serverdaten.php';       
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
      $uwo = getwert($uid,"charaktere","mwo","id");
      $uwo = $uwo+1;   
      $sql="UPDATE charaktere SET mwo ='$uwo' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      } 
      mysqli_close($con); 

}
function did($session){
include 'serverdaten.php';
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere
SET did=$zeit
WHERE session='".$session."' LIMIT 1";
mysqli_query($con, $sql);         
mysqli_close($con); 
}
function checkteam($team,$kampfid){
include 'serverdaten.php';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
kampfid,
team
FROM
charaktere
WHERE kampfid="'.$kampfid.'" AND team = "'.$team.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$count = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['kampfid'] == $kampfid&&$row['team'] == $team){
$spieler[$count] = $row['id'];
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
name,
kampfid,
team,
besitzer
FROM
npcs
WHERE kampfid="'.$kampfid.'" AND team = "'.$team.'" AND besitzer=0';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['kampfid'] == $kampfid&&$row['team'] == $team&&$row['besitzer'] == 0){
$spieler[$count] = $row['name'];
$count++;
}
}
$result->close(); $db->close(); 
return $spieler;
}
function friends($userid){
include 'serverdaten.php';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
an,
von,
accept
FROM
freunde
WHERE
an="'.$userid.'"
OR
von = "'.$userid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$wert[0] = 0;
$wert[1] = 0;                                                         
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
if($row['accept'] == 1){
if($row['an'] != $userid){
$online = getwert($row['an'],"charaktere","session","id");
if($online != NULL){
$wert[0] = $wert[0]+1;
}
}
if($row['von'] != $userid){
$online = getwert($row['von'],"charaktere","session","id");
if($online != NULL){
$wert[0] = $wert[0]+1;
}
}
}
elseif($row['an'] == $userid){
$wert[1] = 1;                 
}
}
$result->close(); $db->close();  
return $wert;
}
function mails($userid){
include 'serverdaten.php';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
an,
von,
betreff,
gelesen,
delete1
FROM
pms
WHERE an = "'.$userid.'" AND delete1=0 AND gelesen=0';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$wert = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$wert++;
}
$result->close(); $db->close(); 
return $wert;
}
//wert - womit man sucht , Tabelle die man sucht , wert den man will , womit man sucht
function getwert($id,$tabelle,$was,$was2){
include 'serverdaten.php';    
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
function getonline(){
include 'serverdaten.php';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
session
FROM
charaktere
WHERE session != NULL
ORDER BY id DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$anzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$anzahl++;
}
$result->close(); $db->close(); 
return $anzahl;
} //getanzahl
function getanzahl($id,$tabelle,$wert2,$was){    
include 'serverdaten.php';                           
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
function namencheck2($name){ //nachrichten
$name = strtolower($name);
$count = 0;
$banned[$count] = "hure";
$count = $count+1;
$banned[$count] = "bastard";
$count = $count+1;
$banned[$count] = "arsch";
$count = $count+1;
$banned[$count] = "loch";
$count = $count+1;
$banned[$count] = "schwuchtel";
$count = $count+1;
$banned[$count] = "homo";
$count = $count+1;
$banned[$count] = "azzlack";
$count = $count+1;
$banned[$count] = "scheiß";
$count = $count+1;  
$banned[$count] = "schwanz";
$count = $count+1;  
$banned[$count] = "lutscher";
$count = $count+1;   
$banned[$count] = "penis";
$count = $count+1;      
$banned[$count] = "opfer";
$count = $count+1;        
$banned[$count] = "noob";
$count = $count+1;      
$banned[$count] = "fotze";
$count = $count+1;    
$banned[$count] = "schlampe";
$count = $count+1;    
$banned[$count] = "nutte";
$count = $count+1;   
$banned[$count] = "fick";
$count = $count+1;         
$banned[$count] = "nama";
$count = $count+1;      
$banned[$count] = "mania";
$count = $count+1;       
$banned[$count] = "x.naruto";
$count = $count+1;  
$banned[$count] = " ";
$count2 = 0;
while($count2 != $count){
if(preg_match("/".$banned[$count2]."/",$name))
{
if($bannedw == ""){
$bannedw = ucwords($banned[$count2]);
}
else{
$bannedw = $bannedw.' '.ucwords($banned[$count2]);
}
}
$count2++;
}   
if($bannedw)
{
return $bannedw;
}
} //namecheck
function namencheck($name){  //Registrierung
$geht = 1;
$name = strtolower($name);
$count = 0;
$banned[$count] = "admin";
$count = $count+1;
$banned[$count] = "hure";
$count = $count+1;
$banned[$count] = "bastard";
$count = $count+1;
$banned[$count] = "arsch";
$count = $count+1;
$banned[$count] = "loch";
$count = $count+1;
$banned[$count] = "schwuchtel";
$count = $count+1;
$banned[$count] = "homo";
$count = $count+1;
$banned[$count] = "moderator";
$count = $count+1;
$banned[$count] = "azzlack";
$count = $count+1;
$banned[$count] = "system";
$count = $count+1;
$banned[$count] = "charakter";
$count = $count+1;
$banned[$count] = "account";
$count = $count+1;
$banned[$count] = "email";
$count = $count+1;
$banned[$count] = "NoUser";
$count = $count+1;  
$banned[$count] = "scheiß";
$count = $count+1;  
$banned[$count] = "schwanz";
$count = $count+1;  
$banned[$count] = "lutscher";
$count = $count+1;   
$banned[$count] = "penis";
$count = $count+1;      
$banned[$count] = "opfer";
$count = $count+1;  ;       
$banned[$count] = "noob";
$count = $count+1;   
$banned[$count] = "fotze";
$count = $count+1;    
$banned[$count] = "schlampe";
$count = $count+1;       
$banned[$count] = "nutte";
$count = $count+1;   
$banned[$count] = "fick";
$count = $count+1;
$banned[$count] = " ";
$count2 = 0;
while($count2 != $count){
if(preg_match("/".$banned[$count2]."/",$name))
{
$geht = 0;
}
$count2++;
}
return $geht;
} //namecheck
function sonderzeichen2($name){
$länge = strlen($name);
$count = 0;
$buchstabe = array();
$buchstabe2 = array();
$geht = array();
$zeichenkette = "äüöÄÜÖ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-:.,ß?_!^)(*\/=[]' ".'"';
$länge2 = strlen($zeichenkette);
while($count != $länge){
$buchstabe[$count] = substr($name , $count , 1);
$count++;
}
$count = 0;
while($count != $länge2){
$buchstabe2[$count] = substr($zeichenkette , $count , 1);
$count++;
}
$count = 0;
$count2 = 0;
$bannedw = "";
while($count != $länge){
$geht[$count] = 0;
$count2 = 0;
while($count2 != $länge2){
if($buchstabe[$count] == $buchstabe2[$count2]){
$geht[$count] = 1;
}
$count2++;
}
$count++;
}
$count = 0;
$gehtnicht = 1;
while($count != $länge){
if($geht[$count] == 0){
if($bannedw == ""){
$bannedw = ucwords($buchstabe[$count]);
}
else{
$bannedw = $bannedw.' '.ucwords($buchstabe[$count]);
}
}
$count++;
}
return $bannedw;
} //sonderzeichen
function sonderzeichen($name){
$länge = strlen($name);
$count = 0;
$buchstabe = array();
$buchstabe2 = array();
$geht = array();
$zeichenkette = "äüöÄÜÖ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-:.,ß?_!^)(*\/=[]' ".'"';
$länge2 = strlen($zeichenkette);
while($count != $länge){
$buchstabe[$count] = substr($name , $count , 1);
$count++;
}
$count = 0;
while($count != $länge2){
$buchstabe2[$count] = substr($zeichenkette , $count , 1);
$count++;
}
$count = 0;
$count2 = 0;
while($count != $länge){
$geht[$count] = 0;
$count2 = 0;
while($count2 != $länge2){
if($buchstabe[$count] == $buchstabe2[$count2]){
$geht[$count] = 1;
}
$count2++;
}
$count++;
}
$count = 0;
$gehtnicht = 1;
while($count != $länge){
if($geht[$count] == 0){
$gehtnicht = 0;
}
$count++;
}
return $gehtnicht;
} //sonderzeichen
?>