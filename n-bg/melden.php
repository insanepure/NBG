<?php
include 'inc/incoben.php';
if(logged_in()){
$admin = getwert(session_id(),"charaktere","admin","session");
$uid = getwert(session_id(),"charaktere","id","session");
$page = $_GET['page'];
$aktion = $_GET['aktion'];
if($admin != 0){        
$zeit2 = time();
$zeit = date("d-m-Y H:i:s",$zeit2);
if($aktion == "edit"){
$id = $_GET['id'];
$was = getwert($id,"meldungen","status","id");
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($was == "Wartet"){
$sql="UPDATE meldungen SET status ='In Bearbeitung' WHERE id='".$id."' LIMIT 1"; 
$text = '<b>'.$zeit.'</b>;'.$uid.';setzte den Status von Meldung <b>#'.$id.'</b> auf <b>In Bearbeitung</b>';
}
if($was == "In Bearbeitung"){
$sql="UPDATE meldungen SET status ='Abgeschlossen' WHERE id='".$id."' LIMIT 1";    
$text = '<b>'.$zeit.'</b>;'.$uid.';setzte den Status von Meldung <b>#'.$id.'</b> auf <b>Abgeschlossen</b>';
}
if($was == "Abgeschlossen"){
$sql="UPDATE meldungen SET status ='Wartet' WHERE id='".$id."' LIMIT 1";  
$text = '<b>'.$zeit.'</b>;'.$uid.';setzte den Status von Meldung <b>#'.$id.'</b> auf <b>Wartet</b>';
}
mysqli_query($con, $sql);  
$modlog = getwert(1,"game","modlog","id");
if($modlog == ""){
$modlog = $text;
}
else{
$modlog = $text.'@'.$modlog;
}    
$sql="UPDATE game SET modlog ='$modlog' LIMIT 1";  
mysqli_query($con, $sql);  
mysqli_close($con);
$error = "Meldung wurde erfolgreich verändert.<br>";
}
if($aktion == "delete"){
$id = $_GET['id'];
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="DELETE FROM meldungen WHERE id='".$id."' LIMIT 1";
mysqli_query($con, $sql);                                   
$text = '<b>'.$zeit.'</b>;'.$uid.';hat die Meldung <b>#'.$id.'</b> gelöscht.';
$modlog = getwert(1,"game","modlog","id");
if($modlog == ""){
$modlog = $text;
}
else{
$modlog = $text.'@'.$modlog;
}    
$sql="UPDATE game SET modlog ='$modlog' LIMIT 1";  
mysqli_query($con, $sql);
mysqli_close($con);
$error = "Meldung wurde erfolgreich gelöscht.<br>";
}
}
if($aktion == "contact"){     
$betreff = real_escape_string($_POST['betreff']);    
$pmtext = real_escape_string($_POST['pmtext']);      
if($betreff != ""){
if($pmtext != ""){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO meldungen(
`user`,`datum`,`betreff`,`text`,`status`)
VALUES
('$uid',
'$zeit',
'$betreff',
'$pmtext',
'Wartet')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = "Meldung wurde erfolgreich gesendet.<br>";
}
else{
$error ="Du hast keinen Text angegeben.";
}
}
else{
$error = "Du hast keinen Betreff angegeben.";
}
}
}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
echo '<h2 class="shadow">Support</h2>';
echo '<br>';
echo '<a href="melden.php?page=contact">Kontaktieren</a>';
echo '<br>';
echo '<br>';
if($page == "see"){
$id = $_GET['id']; 
if(is_numeric($id)){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
user,
betreff,
status,
text,
datum
FROM
meldungen
WHERE id = "'.$id.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['user'] == $uid||$admin != 0){         
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">';
$uname = getwert($row['user'],"charaktere","name","id");
$tid = $row['user'];
echo 'User: <b><a href="user.php?id='.$row['user'].'">'.$uname.'</a></b>';
echo '</td>';
echo '<td class="tdbg tdborder">';
$betreff = $row['betreff'];
echo 'Betreff: <b>'.$row['betreff'].'</b>';
echo '</td>';
$zeit2 = $row['datum'];
$jahr = substr($zeit2 ,0 , 4);
$monat = substr($zeit2 ,5 ,2);
$tag = substr($zeit2 ,8 ,2);
$stunde = substr($zeit2 ,11 ,2);
$minute = substr($zeit2 ,14 ,2);
$uhrzeit = "$tag.$monat.$jahr um $stunde:$minute Uhr";   
echo '<td class="tdbg tdborder">';
echo 'Datum: <b>'.$uhrzeit.'</b>';   
echo '</td>';  
echo '<td class="tdbg tdborder">';
if($row['status'] == "Wartet"){
echo 'Status: <b><font color="dd2222">'.$row['status'].'</font></b>';
}
if($row['status'] == "In Bearbeitung"){
echo 'Status: <b><font color="ff4422">'.$row['status'].'</font></b>';
}
if($row['status'] == "Abgeschlossen"){
echo 'Status: <b><font color="22bb22">'.$row['status'].'</font></b>';
}
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="4" rowspan="1">';
include 'inc/bbcode.php';
echo $bbcode->parse ($row['text']);
echo '</td>';
echo '</tr>';
echo '</table>';

}
}
$result->close(); $db->close();
echo '<br>';
if($admin != 0){
echo '<table width="100%" cellspacing="0">';
echo '<tr>';
echo '<td>';
echo '<form method="post" action="melden.php?aktion=edit&id='.$id.'">';
echo '<input class="button" name="login" id="login" value="Status ändern" type="submit">';
echo '</form>';
echo '</td>';   
echo '<td>';
echo '<form method="post" action="pms.php?page=schreiben&an='.$tid.'&betreff='.$betreff.'">';
echo '<input class="button" name="login" id="login" value="Antworten" type="submit">';
echo '</form>';
echo '</td>';
echo '<td>';
echo '<form method="post" action="melden.php?aktion=delete&id='.$id.'">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit">';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '</table>';
}            
}
echo '<br>';

}
if($page == "contact"){
echo '<form method="post" action="melden.php?aktion=contact"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="betreff" value="Betreff" size="15" maxlength="30" type="text">';
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
if($page == ""){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
user,
betreff,
status,
datum
FROM
meldungen
WHERE
user = "'.$uid.'" AND status = "In Bearbeitung"
OR
user = "'.$uid.'" AND status = "Wartet"
ORDER by
status,
id';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">';
echo 'Betreff';
echo '</td>';     
echo '<td class="tdbg tdborder">';
echo 'Datum';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Status';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo '</td>';
echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr>';
echo '<td>';
echo '<b>'.$row['betreff'].'</b>';
echo '</td>';
$zeit2 = $row['datum'];
$jahr = substr($zeit2 ,0 , 4);
$monat = substr($zeit2 ,5 ,2);
$tag = substr($zeit2 ,8 ,2);
$stunde = substr($zeit2 ,11 ,2);
$minute = substr($zeit2 ,14 ,2);
$uhrzeit = "$tag.$monat.$jahr um $stunde:$minute Uhr";     
echo '<td>';
echo '<b>'.$uhrzeit.'</b>';   
echo '</td>';   
echo '<td>';
if($row['status'] == "Wartet"){
echo '<b><BLINK>Status: <font color="dd2222">'.$row['status'].'</BLINK></font></b>';
}
if($row['status'] == "In Bearbeitung"){
echo '<b>Status: <font color="ff4422">'.$row['status'].'</font></b>';
}
if($row['status'] == "Abgeschlossen"){
echo '<b><font color="22bb22">'.$row['status'].'</font></b>';
}
echo '</td>';
echo '<td><b><a href="melden.php?page=see&id='.$row['id'].'">anschauen</a></b>';
echo '</td>';
echo '</tr>';

}
$result->close(); $db->close();
echo '</table>';
echo '<br>';
 $db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) 
{
  die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
    SELECT
    id,
    session,
    name,
    admin
    FROM
      charaktere
      WHERE admin != "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
              }       
              echo '<h3>Team</h3><br>';   
  echo '<table class="table2" width="100%" cellspacing="0">';  
  echo '<tr>';      
  echo '<td class="tdbg">';  
  echo 'Name';
  echo '</td>';   
  echo '<td class="tdbg">';  
  echo 'Adminrang';
  echo '</td>'; 
  echo '<td class="tdbg">';  
  echo '</td>';     
  echo '<td class="tdbg">';  
  echo '</td>';
  echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false     
  echo '<tr>';
  echo '<td class="tdborder2">';                 
  echo '<a href="user.php?id='.$row['id'].'">'.$row['name'].'</a>';  
  echo '</td>';    
  echo '<td class="tdborder2">';   
  if($row['admin'] == 1){
echo '<font color="#ff0000"><b>Moderator</b></font>';
}
if($row['admin'] == 2){
echo '<font color="#ff0000"><b>Super Moderator</b></font>';
}
if($row['admin'] == 3){
echo '<font color="#0066ff"><b>Admin</b></font>';
}
  echo '</td>'; 
  echo '<td class="tdborder2">';   
  if($row['session'] != NULL){
    echo '<font color="#00ff00"><b>Online</b></font>';
  }    
  else{       
    echo '<font color="#ff0000"><b>Offline</b></font>';
  }
  echo '</td>';    
  echo '<td class="tdborder2">';
  echo '<div class="light2">';
  echo '<a href="pms.php?page=schreiben&an='.$row['id'].'" border="0"><img src="bilder/design/mail.png" width="25px" height="25px" border="0"></img></a>';
  echo '</div>';
  echo '</td>';      
  echo '</tr>';  
  }
$result->close();  
$db->close(); 
echo '</table>';
echo '<br>';
if($admin != 0){
echo '<h3 class="shadow">Meldungen bearbeiten</h2>';
echo '<br>';
$seite = $_GET['seite'];
if($seite == ""){
$seite = 1;
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
user,
betreff,
status,
datum
FROM
meldungen
ORDER by
status DESC,
id
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';   
echo '<td class="tdbg tdborder">';
echo 'ID';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'User';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Betreff';
echo '</td>';   
echo '<td class="tdbg tdborder">';
echo 'Datum';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Status';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo '</td>';
echo '</tr>';
$platz = 0;
$ps = 20;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$platz++;
if($platz >= $von&&$platz <= $bis){
echo '<tr>';     
echo '<td>';
echo '<b>#'.$row['id'].'</b>';
echo '</td>';
echo '<td>';
$uname = getwert($row['user'],"charaktere","name","id");
echo '<a href="user.php?id='.$row['user'].'">'.$uname.'</a>';
echo '</td>';
echo '<td>';
echo '<b>'.$row['betreff'].'</b>';
echo '</td>';                         
$zeit2 = $row['datum'];
$jahr = substr($zeit2 ,0 , 4);
$monat = substr($zeit2 ,5 ,2);
$tag = substr($zeit2 ,8 ,2);
$stunde = substr($zeit2 ,11 ,2);
$minute = substr($zeit2 ,14 ,2);
$uhrzeit = "$tag.$monat.$jahr um $stunde:$minute Uhr";     
echo '<td>';
echo '<b>'.$uhrzeit.'</b>';   
echo '</td>';                       
echo '<td>';
if($row['status'] == "Wartet"){
echo '<b><BLINK>Status: <font color="dd2222">'.$row['status'].'</BLINK></font></b>';
}
if($row['status'] == "In Bearbeitung"){
echo '<b>Status: <font color="ff4422">'.$row['status'].'</font></b>';
}
if($row['status'] == "Abgeschlossen"){
echo '<b><font color="22bb22">'.$row['status'].'</font></b>';
}
echo '</td>';
echo '<td><b><a href="melden.php?page=see&id='.$row['id'].'">anschauen</a></b>';
echo '</td>';
echo '</tr>';
}
}
$result->close(); $db->close();
echo '</table>';
$count = 1;
$anzahl = $platz;
if($platz > $ps){
while($platz > 0){
$platz = $platz-$ps;
echo '<a href="melden.php?&seite='.$count.'">'.$count.'</a> ';
$count++;
}
}
if($anzahl != 1){
echo '<br>'.$anzahl.' Meldungen';
}
else{    
echo '<br>'.$anzahl.' Meldung';
}
echo '<br>';
}
}
else{
echo '<br>';
echo '<a href="melden.php">Zurück</a>';
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