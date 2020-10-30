<?php
include_once 'inc/incoben.php';
$aktion = $_GET['aktion'];
$page = $_GET['page'];
$newsid = $_GET['nid'];
                          
if(logged_in()){
if($aktion == "back"){   
$uid = getwert(session_id(),"charaktere","id","session");  
$tutorial = getwert(session_id(),"charaktere","tutorial","session"); 
if($tutorial != 0&&$tutorial != 30){
$tutorial = $tutorial-1;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere
SET tutorial='$tutorial'
WHERE id=".$uid." Limit 1";
mysqli_query($con, $sql);
mysqli_close($con);
}
}
if($aktion == "info"){   
$uid = getwert(session_id(),"charaktere","id","session");  
$gameinfo = getwert(session_id(),"charaktere","gameinfo","session");       
if($gameinfo != ''){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere
SET gameinfo=''
WHERE id=".$uid." Limit 1";
mysqli_query($con, $sql);
mysqli_close($con);
}
}
if($aktion == "weiter"){   
$uid = getwert(session_id(),"charaktere","id","session");  
$tutorial = getwert(session_id(),"charaktere","tutorial","session");       
if($tutorial != 30){
$tutorial = $tutorial+1;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere
SET tutorial='$tutorial'
WHERE id=".$uid." Limit 1";
mysqli_query($con, $sql);
mysqli_close($con);
}
}
if($aktion == "skip"){   
$uid = getwert(session_id(),"charaktere","id","session");  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere
SET tutorial='30'
WHERE id=".$uid." Limit 1";
mysqli_query($con, $sql);
mysqli_close($con);
}
}
if($page == "kommentare"){
if(is_numeric($newsid)){
$existiert = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id
FROM
news
WHERE id='.$newsid.' LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$existiert = 1;
}
$result->close();    
$db->close();
if($existiert == 1){
if($aktion == "kommentieren" && logged_in()){
$ktext = real_escape_string($_POST['ktext']);
$geht = 1;
if(!namencheck($ktext)){
$geht = 0;
$error = $error."Der Text enthält unzulässige Wörter.<br>";
}
if($ktext == ""){
$geht = 0;
$error = $error."Du hast keinen Text angegegeben.<br>";
}
if($geht == 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
session
FROM
charaktere
WHERE
session="'.session_id().'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$autorid = $row['id'];
}
$result->close();  
$db->close();
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO kommentare(
`news`,`autor`,`text`,`date`)
VALUES
('$newsid',
'$autorid',
'$ktext',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}
}
}
else{
$error = $error."Dieser Newsberricht existiert nicht.<br>";
}
}
}
if(logged_in()){
include 'inc/design1.php';
}
else
{
include 'inc/design3.php';
}
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
include 'inc/mainindex.php';
include 'inc/design2.php'; ?>