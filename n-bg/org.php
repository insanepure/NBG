<?php
include 'inc/incoben.php';
if(logged_in()){ 
//Name;Profil(1);Invite(2);User(3);Rank(4)     
//Leiter;12345@Mitglied
$page = $_GET['page'];   
$aktion = $_GET['aktion'];     
$org = getwert(session_id(),"charaktere","org","session");    
$uran = getwert(session_id(),"charaktere","rank","session");  
$uapply = getwert(session_id(),"charaktere","oapply","session");   
$uautoplay = getwert(session_id(),"charaktere","autoplay","session"); 
if($uran != "student"){
$uid = getwert(session_id(),"charaktere","id","session");
if($org != "0"){    
$orank = getwert($org,"org","rank","id");    
$urank = getwert(session_id(),"charaktere","orank","session");      
$array = explode("@", trim($orank));
$count = 0;
$a = 0;
$geht = 1;
while(isset($array[$count])){      
$array2 = explode(";", trim($array[$count]));  
if($array2[0] == $urank){
$urechte = $array2[1];
}  
$count++;   
if(is_numeric($array2[0])){
$geht = 0;
}
$a++;
}
//Name;Profil(1);Invite(2);User(3);Rank(4);Rundmail(5) 
$r1 = 0;
$r2 = 0;
$r3 = 0;
$r4 = 0;  
$r5 = 0;  
$count = 0;
while($count != 5){      
$check = substr($urechte, $count, 1);  // returns "abcde"  
if($check == '1'){
$r1 = 1;
}         
if($check == '2'){
$r2 = 1;
}        
if($check == '3'){
$r3 = 1;
}       
if($check == '4'){
$r4 = 1;
}       
if($check == '5'){
$r5 = 1;
} 
$count++;
}
if($r5 == 1){
if($aktion == 'rundmail')
{
$betreff = real_escape_string($_POST['betreff']);
$ntext = real_escape_string($_POST['pmtext']);      
$geht = 1;
$check = namencheck2($ntext);
if($check){
$geht = 0;
$error = $error."Der Text enthält unzulässige Wörter ($check).<br>";
}
if($ntext == ""){
$geht = 0;
$error = $error."Du hast keinen Text angegegeben.<br>";
}       
$check2 = namencheck2($betreff);
if($check2){
$geht = 0;
$error = $error."Der Betreff enthält unzulässige Wörter ($check2).<br>";
}
if($betreff == ""){
$geht = 0;
$error = $error."Du hast keinen Betreff angegegeben.<br>";
}
$check3 = sonderzeichen2($betreff);
if($check3 != ""){
$geht = 0;
$error = $error."Der Betreff enthält Sonderzeichen ($check3).<br>";
}           
if($geht == 1){
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
org
FROM
charaktere
WHERE org = "'.$org.'"';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$count = 0;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
while ($row = $result->fetch_assoc() ) {      
$anid = $row['id']; 
$count++;
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',
'$anid',
'$uid',
'$betreff',
'$ntext',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
}                 
$result->close(); $db->close();   
mysqli_close($con);  
$error = $error."Rundmail wurde gesendet.<br>";
}
}
}
if($r2 == 1){
if($aktion == 'accept'){
$aid = $_GET['id'];             
$aid = real_escape_string($aid);  
$aapply = getwert($aid,"charaktere","oapply","id"); 
if($aapply == $org){               
$arank = getwert($aid,"charaktere","rank","id"); 
if($arank == 'nuke-nin'&&$uran == 'nuke-nin'||$arank != 'nuke-nin'&&$uran != 'nuke-nin'){
$aname = getwert($aid,"charaktere","name","id");      
$array = explode("@", trim($orank));     
$array2 = explode(";", trim($array[1]));     
$member = $array2[0];
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="UPDATE charaktere SET oapply ='0',org ='$org',orank ='$member' WHERE id = '".$aid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}           
$error = 'Du hast '.$aname.' angenommen.';
mysqli_close($con);
}
}
}
if($aktion == "decline"){
$aid = $_GET['id'];             
$aid = real_escape_string($aid);  
$aapply = getwert($aid,"charaktere","oapply","id");  
if($aapply == $org){   
$aname = getwert($aid,"charaktere","name","id"); 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="UPDATE charaktere SET oapply ='0' WHERE id = '".$aid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}            
$error = 'Du hast '.$aname.' abgelehnt.';   
mysqli_close($con);
}
}
}
if($aktion == "leave"){   
$array = explode("@", trim($orank));     
$array2 = explode(";", trim($array[0]));     
$leiter = $array2[0];
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
org,
orank
FROM
charaktere
WHERE org = "'.$org.'"
ORDER BY
level DESC,
exp DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}    
$anzahl2 = 0;
$anzahl = 0;
while ($row = $result->fetch_assoc() ) {       
$anzahl++;  
if($row['orank'] == $leiter){
$anzahl2++;
}
}                 
$result->close(); $db->close();          
$oname = getwert($org,"org","name","id");    
teamkampfleave($org,$uid);   
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
if($anzahl == 1){
$sql="UPDATE charaktere SET orank ='',org ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}            
$sql="DELETE FROM org WHERE id = '".$org."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$error = 'Du hast '.$oname.' verlassen.';
}
else{
if($urank == $leiter){
if($anzahl2 >= 2){
$sql="UPDATE charaktere SET orank ='',org ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
$error = 'Du hast '.$oname.' verlassen.';
}
else{
$error = 'Es muss noch einer den Rang '.$leiter.' haben.';
}


}
else{
$sql="UPDATE charaktere SET orank ='',org ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
$error = 'Du hast '.$oname.' verlassen.';
}
}
mysqli_close($con);    
}
if($r3 == 1){
if($aktion == "kick"){  
$muser = $_GET['muser'];     
$muser = real_escape_string($muser);
if($muser != ""){
$array = explode("@", trim($orank));     
$array2 = explode(";", trim($array[0]));     
$leiter = $array2[0];
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
org,
orank
FROM
charaktere
WHERE id = "'.$muser.'" OR org = "'.$org.'"
ORDER BY
level DESC,
exp DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}    
while ($row = $result->fetch_assoc() ) {        
if($row['id'] == $muser){
$marank = $row['orank'];
}  
if($row['org'] == $org){    
if($row['orank'] == $leiter){
$anzahl++;
}
}
}                 
$result->close(); $db->close();
$geht = 1;
if($anzahl < 2&&$marank == $leiter){
$geht = 0;
}
if($geht == 1){                       
teamkampfleave($org,$muser);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET orank ='',org ='0' WHERE id = '".$muser."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}      
mysqli_close($con); 
$error = 'User wurde gekickt.';
}
else{
$error = 'Es muss noch einer den Rang '.$leiter.' haben.';
}
}

}
if($aktion == "medit"){
$muser = $_GET['muser'];     
$muser = real_escape_string($muser);
if($muser != ""){
$mrank = $_POST['rang'];
$array = explode("@", trim($orank));
$count = 0;
$geht = 0;
while(isset($array[$count])){      
$array2 = explode(";", trim($array[$count]));  
if($count == 0){
$leiter = $array2[0];
}
if($array2[0] == $mrank){
$geht = 1;
}  
$count++;  
}
if($geht == 1){
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
org,
orank
FROM
charaktere
WHERE id = "'.$muser.'" OR org = "'.$org.'"
ORDER BY
level DESC,
exp DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}    
while ($row = $result->fetch_assoc() ) {        
if($row['id'] == $muser){
$marank = $row['orank'];
}  
if($row['org'] == $org){    
if($row['orank'] == $leiter){
$anzahl++;
}
}
}                 
$result->close(); $db->close();
if($anzahl < 2&&$marank == $leiter){
$geht = 0;
}
if($geht == 1){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET orank ='$mrank' WHERE id = '".$muser."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con); 
$error = 'Rang erfolgreich geändert.';
}
else{
$error = 'Es muss noch einer den Rang '.$leiter.' haben.';
}
}
else{
$error = 'Dieser Rang existiert nicht.';
}
} 
}
}
if($r4 == 1){
if($aktion == "redit"){  
$rang = $_GET['rang'];      
$rang = real_escape_string($rang);   
$rname = $_POST['rname'];    
$rname = real_escape_string($rname);   
if($rname != ""){
if($rang != "0"){
$r1c = $_POST['r1c'];  
if($r1c == "check"){
$r1c = "1";
} 
$r2c = $_POST['r2c'];
if($r2c == "check"){
$r2c = "2";
}    
$r3c = $_POST['r3c']; 
if($r3c == "check"){
$r3c = "3";
}   
$r4c = $_POST['r4c'];   
if($r4c == "check"){
$r4c = "4";
}  
$r5c = $_POST['r5c'];   
if($r5c == "check"){
$r5c = "5";
}   
}  
$geht = 1;       
$leer = 1;
while($leer == 1){
$leerzeichen = substr($rname,-1);
if($leerzeichen == " "){
$length = strlen($rname );
$rname = substr($rname,0,$length-1);
}  
else{
$leer = 0;
}
}
if($rname != ''){   
if(!namencheck($rname)){
$geht = 0;
$error = $error."Der Name hat unzulässige Wörter im Namen.<br>";
}        
$array = explode("@", trim($orank));
$count = 0;     
$nrang = "";
while(isset($array[$count])){      
$array2 = explode(";", trim($array[$count]));  
if($count == $rang){
$aname = $array2[0];
}
if($array2[0] == $rname&&$rname != $aname){
$geht = 0;
$error = $error."Dieser Name wurde schon belegt.<br>";
}
if($nrang == ""){
if($count == $rang){
$array2[0] = $rname; 
if($rang != "0"){
$array2[1] = $r1c.$r2c.$r3c.$r4c.$r5c;
}
}
$nrang = $array2[0].';'.$array2[1];
}
else{
if($count == $rang){
$array2[0] = $rname; 
if($rang != "0"){
$array2[1] = $r1c.$r2c.$r3c.$r4c.$r5c;
}
}
$nrang = $nrang.'@'.$array2[0].';'.$array2[1];
}
$count++; 
}
if($geht == 1){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE org SET rank ='$nrang' WHERE id = '".$org."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="UPDATE charaktere SET orank ='$rname' WHERE orank = '".$aname."' AND org = '".$org."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con); 
$error = 'Rang erfolgreich geändert.';
}
}
}
}
if($aktion == 'rdel'){
$rang = $_GET['rang'];    
$rang = real_escape_string($rang);   
if($rang != 0&&$rang != 1){      
$array = explode("@", trim($orank));
$count = 0;
$rname = 0;         
$nrang = "";
while(isset($array[$count])){      
$array2 = explode(";", trim($array[$count]));  
if($count == 1){
$member = $array2[0];
}
if($count == $rang){
$rname = $array2[0];
}
else{
if($nrang == ""){
$nrang = $array2[0].';'.$array2[1];
}
else{    
$nrang = $nrang.'@'.$array2[0].';'.$array2[1];
}
}  
$count++;   
}
if($rname != ""){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE org SET rank ='$nrang' WHERE id = '".$org."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="UPDATE charaktere SET orank ='$member' WHERE orank = '".$aname."' AND org = '".$org."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con); 
$error = 'Rang '.$rname.' wurde entfernt.';
}
}
}
if($aktion == "rnew"){
if($geht == 1){
if($a != 15){
$a = $a+1;
$rnew = $orank.'@'.$a;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE org SET rank ='$rnew' WHERE id = '".$org."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}         
mysqli_close($con);  
$error = 'Ein Neuer Rang wurde hinzugefügt.';
}
}
else{
$error = 'Ein Rang ist eine Zahl. Bitte ändere den Namen.';
}
}
}

if($r1 == 1){
if($aktion == "edit"&&$_POST['login']){ 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($_POST['theme']){              
$youtubecheck = substr($_POST['theme'], 0, 31);   
if($youtubecheck == 'http://www.youtube.com/watch?v='){   
$theme = substr($_POST['theme'], 0, 42);       
$sql="UPDATE org SET theme ='$theme' WHERE id = '".$org."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$error = $error.'Dies ist kein gültiges Youtubevideo. Bitte das Format "http://www.youtube.com/watch?v=" einhalten!<br>';
}
$theme = substr("abcdef", 0, 42);  // returns "abcde"
}
else{
$sql="UPDATE org SET theme ='' WHERE id = '".$org."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if(isset($_POST['bild']) && $_FILES['file_upload']['name'] != ''){
$imgHandler = new ImageHandler('userdata/teambild/');
$result = $imgHandler->Upload($_FILES['file_upload'], $bild, 550, 600);
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
$sql="UPDATE org SET bild ='$bild' WHERE id = '".$org."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$error = $error.$message.'<br/>';
}
}
if($_POST['text']){
$ptext = real_escape_string($_POST['text']);
$sql="UPDATE org SET text ='$ptext' WHERE id = '".$org."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}
else{
$sql="UPDATE org SET text ='' WHERE id = '".$org."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}    
mysqli_close($con);  
$error = $error." Profil wurde geändert.<br>";
}
}
}
else{
if($aktion == "bweg"){
if($uapply != '0'){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
$sql="UPDATE charaktere SET oapply ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
$uapply = '0';
mysqli_close($con); 
$error = 'Du hast deine Bewerbung zurückgezogen.';
}
}
if($aktion == "join"){
$rank = "";
$geht = 1;     
if($uapply != "0"){
$rank = getwert($uapply,"charaktere","rank","org");
if($rank != ""){
if($rank == "nuke-nin"&&$uran == "nuke-nin"||$rank != "nuke-nin"&&$uran != "nuke-nin"){
$geht = 0;
}
}
}
if($geht == 1){
if($uapply == "0"){
$org = $_POST['org'];  
$org = real_escape_string($org);  
if($org != ""&&$org != "0"){ 
$rank = getwert($org,"charaktere","rank","org");  
if($rank == "nuke-nin"&&$uran != "nuke-nin"||$rank != "nuke-nin"&&$uran == "nuke-nin"){
$geht = 0;
}
if($geht == 1){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
$sql="UPDATE charaktere SET oapply ='$org' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con);      
$oname = getwert($org,"org","name","id");
$error = 'Du hast dich bei '.$oname.' beworben.';
$uapply = $org;
}
}
}
else{
$error = 'Du hast dich schon beworben.';
}
}
}
if($aktion == "create"){    
$name = $_POST['name'];     
$geht = 1;
if(!sonderzeichen($name)){
$geht = 0;
$error = $error."Es befinden sich Sonderzeichen im Namen.<br>";

}
if(!namencheck($name)){
$geht = 0;
$error = $error."Der Name hat unzulässige Wörter im Namen.<br>";
}
$leer = 1;
while($leer == 1){
$leerzeichen = substr($name,-1);
if($leerzeichen == " "){
$length = strlen($name );
$name = substr($name,0,$length-1);
}  
else{
$leer = 0;
}
}
if($name != ""&&$geht == 1){  
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name
FROM
org
WHERE name = "'.$name.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if(strtolower($name) == strtolower($row['name'])){
$geht = 0;
$error = $error."Dieser Name existiert schon.<br>";
}
}
$result->close(); $db->close(); 
if($geht == 1){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO org(
`name`,`rank`)
VALUES
('$name',
'Leiter;12345@Mitglied')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                                     
$oid = mysqli_insert_id($con);     
$sql="UPDATE charaktere SET org ='$oid',oapply ='0',orank ='Leiter' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
mysqli_close($con);  
$error = $error." $name wurde erstellt.<br>";
}
}
}
}
}
}
if(logged_in()){
include 'inc/design1.php';   
$org = getwert(session_id(),"charaktere","org","session"); 
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                                           
//Hier kommt der Code hin
if($page == "see"){
$org = $_GET['org'];           
$org = real_escape_string($org);
if(is_numeric($org))
{        
include 'inc/bbcode.php';                  
$oname = getwert($org,"org","name","id"); 
$obild = getwert($org,"org","bild","id"); 
$otext = getwert($org,"org","text","id");  
$otheme = getwert($org,"org","theme","id"); 
echo '<center><table class="table" width="600px">';
echo '<tr>';                   
echo '<tr>';
echo '<td class="tdborder tdbg">'.$oname.'</td>';
echo '</tr>';
echo '<td class="tdborder">';    
if($obild == ""){
$obild = 'bilder/design/nopic.png';
}
echo '<img src="'.$obild.'"></img>';
echo '</td>';
echo '</tr>';   
echo '<tr>';
echo '<td class="tdborder">'; 
if($otheme != ""){    
$theme = substr($otheme, -11);           
echo '<iframe src="http://www.youtube.com/embed/'.$theme.'?hd=0&rel=0&autohide=1&showinfo=0&autoplay='.$uautoplay.'" frameborder="0" width="150" height="100"></iframe>'; 
}
echo '<br>';    
echo $bbcode->parse ($otext);
echo '<br>';
echo '</td>';
echo '</tr>';  
echo '</tr>';   
echo '<tr>';
echo '<td>';     
echo '<center>';      
echo '<br>';
echo '<table width="580px" class="table" cellspacing="0">';
echo '<tr>';                                  
echo '<td class="tdborder tdbg">Platz</td>';
echo '<td class="tdborder tdbg">Name</td>';
echo '<td class="tdborder tdbg">Rank</td>';    
echo '<td class="tdborder tdbg">Clan</td>';
echo '<td class="tdborder tdbg">Level</td>'; 
echo '<td class="tdborder tdbg">Online</td>'; 
echo '</tr>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
level,
orank,
org,
exp,
clan,
platz,
session
FROM
charaktere
WHERE org = "'.$org.'"
ORDER BY platz';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
$platz = 0;
while ($row = $result->fetch_assoc() ) {              
echo '<tr>';                  
echo '<td>'.$row['platz'].'</td>';   
echo '<td><a href="user.php?id='.$row['id'].'">'.$row['name'].'</a></td>';  
echo '<td>'.$row['orank'].'</td>';   
echo '<td>'.ucwords($row['clan']).'</td>';
echo '<td>'.$row['level'].'</td>';   
echo '<td>';
if($row['session'] != NULL){
echo '<font color="#00ff00"><b>Online</b></font>';
}
else{
echo '<font color="#ff0000"><b>Offline</b></font>';
} 
echo '</td>';
echo '</tr>';
}
$result->close(); $db->close();
echo '</table>';
echo '</center>';  
echo '<br>';
echo '</td>';
echo '</tr>';
echo '</table>'; 
echo '</center>';    
}
}
elseif($uran != "student"){ 
if($org != "0"){
$orank = getwert($org,"org","rank","id");    
$urank = getwert(session_id(),"charaktere","orank","session");      
$array = explode("@", trim($orank));
$count = 0;
$a = 0;
$geht = 1;
while(isset($array[$count])){      
$array2 = explode(";", trim($array[$count]));  
if($array2[0] == $urank){
$urechte = $array2[1];
}  
$count++;   
if(is_numeric($array2[0])){
$geht = 0;
}
$a++;
}
//Name;Profil(1);Invite(2);User(3);Rank(4) 
$r1 = 0;
$r2 = 0;
$r3 = 0;
$r4 = 0;   
$r5 = 0;   
$count = 0;
while($count != 5){      
$check = substr($urechte, $count, 1);  // returns "abcde"  
if($check == '1'){
$r1 = 1;
}         
if($check == '2'){
$r2 = 1;
}        
if($check == '3'){
$r3 = 1;
}       
if($check == '4'){
$r4 = 1;
}       
if($check == '5'){
$r5 = 1;
} 
$count++;
}
if($page == "mitglied"){ 
$mid = $_GET['mid'];     
$mid = real_escape_string($mid);   
 echo '<center>'; 
 if($mid != ""&&$r3 == 1){     
   $morg = getwert($mid,"charaktere","org","id"); 
   if($morg == $org){
 echo 'Name: ';             
   $mname = getwert($mid,"charaktere","name","id"); 
   $mrank = getwert($mid,"charaktere","orank","id"); 
echo '<a href="user.php?id='.$mid.'">'.$mname.'</a>';   
echo '<br>';          
echo '<br>';                                       
echo '<form method="post" action="org.php?page=mitglied&aktion=medit&muser='.$mid.'">';   
echo '<div class="auswahl">';  
echo '<select name="rang">';  
$array = explode("@", trim($orank));
$count = 0;
while(isset($array[$count])){      
$array2 = explode(";", trim($array[$count]));
$count++;
if($array2[0] == $mrank){            
echo '<option value="'.$array2[0].'" selected>'.$array2[0].'</option>';   
}
else{              
echo '<option value="'.$array2[0].'">'.$array2[0].'</option>'; 
}
}            
echo '</select>';    
echo '</div>';      
echo '<br>';
echo '<input class="button" name="login" id="login" value="ändern" type="submit"></form>';
echo '<br>';        
if($mid != $uid){        
echo '<form method="post" action="org.php?page=mitglied&aktion=kick&muser='.$mid.'">';    
echo '<input class="button" name="login" id="login" value="kicken" type="submit"></form>';
echo '<br><br>';   
 }    
}
 echo '<a href="org.php?page=mitglied">Zurück</a>';
}
else{
echo '<h3>Mitglieder</h3>';
echo '<table width="600px" class="table" cellspacing="0">';
echo '<tr>';                                  
echo '<td class="tdborder tdbg">Platz</td>';
echo '<td class="tdborder tdbg">Name</td>';
echo '<td class="tdborder tdbg">Rank</td>';    
echo '<td class="tdborder tdbg">Clan</td>';
echo '<td class="tdborder tdbg">Level</td>';  
echo '<td class="tdborder tdbg">Online</td>';  
if($r3 == 1){
echo '<td class="tdborder tdbg"></td>'; 
}
echo '</tr>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
level,
orank,
org,
exp,
clan,
platz,
session
FROM
charaktere
WHERE org = "'.$org.'"
ORDER BY platz';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
$platz = 0;
while ($row = $result->fetch_assoc() ) {        
echo '<tr>';                  
echo '<td>'.$row['platz'].'</td>';   
echo '<td><a href="user.php?id='.$row['id'].'">'.$row['name'].'</a></td>';  
echo '<td>'.$row['orank'].'</td>';   
echo '<td>'.ucwords($row['clan']).'</td>';
echo '<td>'.$row['level'].'</td>';  
echo '<td>';
if($row['session'] != NULL){
echo '<font color="#00ff00"><b>Online</b></font>';
}
else{
echo '<font color="#ff0000"><b>Offline</b></font>';
} 
echo '</td>';     
if($r3 == 1){
echo '<td><a href="org.php?page=mitglied&mid='.$row['id'].'">ändern</a></td>';  
}
echo '</tr>';
}
$result->close(); $db->close();
echo '</table>';
echo '<br>';         
echo '<h3>Ränge</h3>';
echo '<table width="730px" class="table" cellspacing="0">';
echo '<tr>';                                  
echo '<td class="tdborder tdbg" width="200px"> Name </td>';
echo '<td class="tdborder tdbg"> Profil </td>';
echo '<td class="tdborder tdbg"> Anfragen</td>';    
echo '<td class="tdborder tdbg"> User </td>';
echo '<td class="tdborder tdbg"> Ränge </td>';  
echo '<td class="tdborder tdbg"> Rundmail </td>';  
if($r4 == 1){
echo '<td width="150px" class="tdborder tdbg"></td>';  
echo '<td width="50px" class="tdborder tdbg"></td>';  
}
echo '</tr>';
$orank = getwert($org,"org","rank","id");    
$urank = getwert(session_id(),"charaktere","orank","session");      
$array = explode("@", trim($orank));
$count = 0;
while(isset($array[$count])){      
$array2 = explode(";", trim($array[$count]));
if($r4 == 1){
echo '<form method="post" action="org.php?page=mitglied&aktion=redit&rang='.$count.'">';
}
$count2 = 0;
$cr1 = 0;
$cr2 = 0;  
$cr3 = 0;
$cr4 = 0;   
$cr5 = 0;
while($count2 != 5){      
$check = substr($array2[1], $count2, 1);  // returns "abcde"  
if($check == '1'){
$cr1 = 1;
}         
if($check == '2'){
$cr2 = 1;
}        
if($check == '3'){
$cr3 = 1;
}       
if($check == '4'){
$cr4 = 1;
}        
if($check == '5'){
$cr5 = 1;
} 
$count2++;
}
echo '<tr height="30px">';
echo '<td>';
if($r4 == 0){
echo $array2[0];
}
else{        
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="rname" value="'.$array2[0].'" size="15" maxlength="20" type="text">';
echo '</div>';
}
echo '</td>';
echo '<td>';
if($r4 == 0||$count == 0){
if($cr1 == 1){
echo 'Ja';
}
else{
echo 'Nein';
}
}
else{
if($cr1 == 1){
echo '<input class="cursor" type="checkbox" name="r1c" value="check" checked>';
}
else{           
echo '<input class="cursor" type="checkbox" name="r1c" value="check">';
}

}
echo '</td>';  
echo '<td>';
if($r4 == 0||$count == 0){
if($cr2 == 1){
echo 'Ja';
}
else{
echo 'Nein';
}
}
else{
if($cr2 == 1){
echo '<input class="cursor" type="checkbox" name="r2c" value="check" checked>';
}
else{           
echo '<input class="cursor" type="checkbox" name="r2c" value="check">';
}

}
echo '</td>';
echo '<td>';
if($r4 == 0||$count == 0){
if($cr3 == 1){
echo 'Ja';
}
else{
echo 'Nein';
}
}
else{
if($cr3 == 1){
echo '<input class="cursor" type="checkbox" name="r3c" value="check" checked>';
}
else{           
echo '<input class="cursor" type="checkbox" name="r3c" value="check">';
}

}
echo '</td>';  
echo '<td>';
if($r4 == 0||$count == 0){
if($cr4 == 1){
echo 'Ja';
}
else{
echo 'Nein';
}
}
else{
if($cr4 == 1){
echo '<input class="cursor" type="checkbox" name="r4c" value="check" checked>';
}
else{           
echo '<input class="cursor" type="checkbox" name="r4c" value="check">';
}

}
echo '</td>'; 
echo '<td>';
if($r4 == 0||$count == 0){
if($cr5 == 1){
echo 'Ja';
}
else{
echo 'Nein';
}
}
else{
if($cr5 == 1){
echo '<input class="cursor" type="checkbox" name="r5c" value="check" checked>';
}
else{           
echo '<input class="cursor" type="checkbox" name="r5c" value="check">';
}

}
echo '</td>'; 
if($r4 == 1){
echo '<td>';   
echo '<input class="button2" name="login" id="login" value="übernehmen" type="submit"></form>';
echo '</td>';   
echo '<td>';    
if($count != 0&&$count != 1){
echo '<form method="post" action="org.php?page=mitglied&aktion=rdel&rang='.$count.'">';
echo '<input class="button3" name="login" id="login" value="X" type="submit"></form>';
}
echo '</td>'; 
}
echo '</tr>';
$count++;
} 
echo '</table>';  
if($r4 == 1){  
echo '<br>';
echo '<form method="post" action="org.php?page=mitglied&aktion=rnew">';    
echo '<input class="button" name="login" id="login" value="Neuer Rang" type="submit"></form>';
}     
if($r5 == 1){
echo '<br><h3>Rundmail</h3><form method="post" action="org.php?page=mitglied&aktion=rundmail"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
echo '<div class="eingabe1">';
$betreff = $_GET['betreff'];
if($betreff != ""){
echo '<input class="eingabe2" name="betreff" value="RE: '.$betreff.'" size="15" maxlength="30" type="text">';
}
else{
echo '<input class="eingabe2" name="betreff" value="Betreff" size="15" maxlength="30" type="text">';
}
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<div class="textfield2">
<textarea class="textfield" name="pmtext" maxlength="300000"></textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="absenden" type="submit">';
echo '</td>';
echo '</tr>';
echo '</table></form><br>';   
} 
echo '<br>';
echo '<h3>Bewerbungen</h3>';     
echo '<br>';
echo '<table width="600px" class="table" cellspacing="0">';
echo '<tr>';                                  
echo '<td class="tdborder tdbg">Platz</td>';
echo '<td class="tdborder tdbg">Name</td>';
echo '<td class="tdborder tdbg">Clan</td>';
echo '<td class="tdborder tdbg">Level</td>';  
echo '<td class="tdborder tdbg">Online</td>';     
if($r2 == 1){ 
echo '<td class="tdborder tdbg"></td>';      
echo '<td class="tdborder tdbg"></td>';  
}
echo '</tr>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
level,
exp,
oapply,
clan,
rank,
platz,
session
FROM
charaktere
WHERE oapply = "'.$org.'"
ORDER BY
platz';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {        
if($row['rank'] == 'nuke-nin'&&$uran == 'nuke-nin'||$row['rank'] != 'nuke-nin'&&$uran != 'nuke-nin'){       
echo '<tr>';                  
echo '<td>'.$row['platz'].'</td>';   
echo '<td><a href="user.php?id='.$row['id'].'">'.$row['name'].'</a></td>';  
echo '<td>'.ucwords($row['clan']).'</td>';
echo '<td>'.$row['level'].'</td>';   
echo '<td>';
if($row['session'] != NULL){
echo '<font color="#00ff00"><b>Online</b></font>';
}
else{
echo '<font color="#ff0000"><b>Offline</b></font>';
} 
echo '</td>';    
if($r2 == 1){ 
echo '<td><a href="org.php?page=mitglied&aktion=accept&id='.$row['id'].'">annehmen</a></td>';   
echo '<td><a href="org.php?page=mitglied&aktion=decline&id='.$row['id'].'">ablehnen</a></td>';   
}
echo '</tr>';
}
}                 
$result->close(); $db->close();
echo '</table>';
echo '</center>';  
echo '<br>';
echo '<form method="post" action="org.php?page=mitglied&aktion=leave">';    
echo '<input class="button" name="login" id="login" value="Org/Team verlassen" type="submit"></form>';
}
echo '</center>';  
}        

if($page == ""){  
include 'inc/bbcode.php';                  
$oname = getwert($org,"org","name","id"); 
$obild = getwert($org,"org","bild","id"); 
$otext = getwert($org,"org","text","id");  
$otheme = getwert($org,"org","theme","id"); 
echo '<center><table class="table" width="600px">';
echo '<tr>';                   
echo '<tr>';
echo '<td class="tdborder tdbg">'.$oname.'</td>';
echo '</tr>';
echo '<td class="tdborder">';    
if($obild == ""){
$obild = 'bilder/design/nopic.png';
}
echo '<img src="'.$obild.'"></img>';
echo '</td>';
echo '</tr>';   
echo '<tr>';
echo '<td class="tdborder">';    
if($otheme != ""){    
$theme = substr($otheme, -11);           
echo '<iframe src="http://www.youtube.com/embed/'.$theme.'?hd=0&rel=0&autohide=1&showinfo=0&autoplay='.$uautoplay.'" frameborder="0" width="150" height="100"></iframe>'; 
}
echo '<br>';    
echo $bbcode->parse ($otext);
echo '<br>';
echo '</td>';
echo '</tr>';  
echo '</tr>';   
echo '<tr>';
echo '<td>';     
echo '<center>';      
echo '<br>';
echo '<table width="580px" class="table" cellspacing="0">';
echo '<tr>';                                  
echo '<td class="tdborder tdbg">Platz</td>';
echo '<td class="tdborder tdbg">Name</td>';
echo '<td class="tdborder tdbg">Rank</td>';    
echo '<td class="tdborder tdbg">Clan</td>';
echo '<td class="tdborder tdbg">Level</td>';    
echo '<td class="tdborder tdbg">Online</td>'; 
echo '</tr>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
level,
orank,
org,
exp,
clan,
platz,session
FROM
charaktere
where org = "'.$org.'" 
ORDER BY
platz';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {                
echo '<tr>';                  
echo '<td>'.$row['platz'].'</td>';   
echo '<td><a href="user.php?id='.$row['id'].'">'.$row['name'].'</a></td>';  
echo '<td>'.$row['orank'].'</td>';   
echo '<td>'.ucwords($row['clan']).'</td>';
echo '<td>'.$row['level'].'</td>';   
echo '<td>';
if($row['session'] != NULL){
echo '<font color="#00ff00"><b>Online</b></font>';
}
else{
echo '<font color="#ff0000"><b>Offline</b></font>';
} 
echo '</td>';
echo '</tr>';
}                 
$result->close(); $db->close();
echo '</table>';
echo '</center>';  
echo '<br>';
echo '</td>';
echo '</tr>';
echo '</table>'; 
echo '</center>';
echo '<br>';
if($r1 == 1){
echo '<form method="post" action="org.php?aktion=edit" enctype="multipart/form-data">';
echo '<table width="100%" class="shadow">';
echo '<tr>';
echo '<td align="center" width="345px"><b>Bild (Max: 600 Breite 600 Höhe)</b></td>';
echo '<td align="left">';
echo '<input type="file" name="file_upload" /><input type="hidden" name="bild"/>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center" width="345px"><b>Theme (Youtubelink)</b></td>';
echo '<td align="left">';         
echo '<div class="eingabe3">
<input class="eingabe4" name="theme" value="'.$otheme.'" size="15" maxlength="50" type="text">
      </div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center" colspan="2" rowspan="1">';
echo '<div class="textfield2">
<textarea class="textfield" name="text" maxlength="300000">'.$otext.'</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<input class="button" name="login" id="login" value="ändern" type="submit"></form>';
}
}

}
else{
if($page != "join"){
echo '<form method="post" action="org.php?aktion=create">';     
echo '<center>Name:<div class="eingabe1">';
echo '<input class="eingabe2" name="name" id="name" value="" size="15" maxlength="50" type="text">';
echo '</div><br>';
echo '</center><input class="button" name="login" id="login" value="erstellen" type="submit">';
echo '</form>'; 
}
else{
echo '<form method="post" action="org.php?page=join&aktion=join">';     
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    org
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<center><div class="auswahl">';
echo '<select name="org" class="Auswahl" size="1">';   
$geht = 1;
while ($row = $result->fetch_assoc() ) {
$rank = getwert($row['id'],"charaktere","rank","org");
if($uapply == $row['id']){
if($rank == "nuke-nin"&&$uran == "nuke-nin"||$rank != "nuke-nin"&&$uran != "nuke-nin"){
$geht = 0;
$oname = $row['name'];
}
}
if($rank == "nuke-nin"&&$uran == "nuke-nin"||$rank != "nuke-nin"&&$uran != "nuke-nin"){ 
echo'<option value="';
echo $row['id'];
echo '">';
echo $row['name']; 
echo '</option>';
}
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div><br>';
if($geht == 1){
echo '</center><input class="button" name="login" id="login" value="beitreten" type="submit">';
}
echo '</form>'; 
if($geht == 0){
echo 'Du hast dich bei '.$oname.' beworben.Willst du deine <a href="org.php?page=join&aktion=bweg">Bewerbung zurücknehmen</a>?';
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