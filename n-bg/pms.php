<?php
include 'inc/incoben.php';
if(logged_in()){
$page = $_GET['page'];
$aktion = $_GET['aktion'];
$nid = $_GET['nid'];
$wo = $_GET['wo'];
$ansend = real_escape_string($_REQUEST['an']);
$dbutton = $_POST['delete'];
$userid = getwert(session_id(),"charaktere","id","session");
if($page == ""){
$page = "eingang";
}
if($aktion == "melden")
{
if($_POST['checked'] == 'Ja'){
$an = getwert($nid,"pms","an","id"); 
if($an == $userid){                
$uname = getwert(session_id(),"charaktere","name","session");     
$von = getwert($nid,"pms","von","id");        
$vname = getwert($von,"charaktere","name","id");          
$ptext = getwert($nid,"pms","text","id");
$betreff = 'PM MELDUNG';
$pmtext = $uname.' ('.$userid.') hat die PN mit der ID '.$nid.' von '.$vname.' ('.$von.') gemeldet.
Der Inhalt der PN lautet:
'.$ptext;
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO meldungen(
`user`,`datum`,`betreff`,`text`,`status`)
VALUES
('$userid',
'$zeit',
'$betreff',
'$pmtext',
'Wartet')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
$error = $error.'PN wurde erfolgreich gemeldet!';
}
}
}
if($aktion == "senden"){
//Hole Daten                         
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
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
$count = 0;
$array = explode(";", trim($ansend));
while(isset($array[$count])){   
$geht = 1;
$ansend = $array[$count];
$anid = getwert($ansend,"charaktere","id","name");
//überprüfe

if($anid == 0){
$geht = 0;
$error = $error."Der User $ansend existiert nicht.<br>";
}
//Wenn alles geht
if($anid != 0){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      user,
      ignoriert
      FROM
      ignoriert
      WHERE user="'.$anid.'" AND ignoriert = "'.$userid.'"Limit 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }         
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
      $geht = 0;
      $error = $error."Der User $ansend hat dich blockiert.<br>";
      }
      $result->close();     
    $db->close();
}
if($geht == 1){

$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',
'$anid',
'$userid',
'$betreff',
'$ntext',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
mysqli_close($con);  
$error = $error."Nachricht wurde erfolgreich an $ansend gesendet.<br>";
}
$count++;
}
}
}
if($aktion == "set"){
if($dbutton == "Alle löschen"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
if($page == 'eingang'){
$sql = 'SELECT
id,
an,
von,
delete1,
delete2
FROM
pms
WHERE an = "'.$userid.'"';
}
elseif($page == 'ausgang'){
$sql = 'SELECT
id,
an,
von,
delete1,
delete2
FROM
pms
WHERE von = "'.$userid.'"';
}
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($page == 'eingang'){
if($row['delete2'] == 1){
$sql="DELETE FROM pms WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$sql="UPDATE pms SET delete1 ='1' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($page == 'ausgang'){
if($row['delete1'] == 1){
$sql="DELETE FROM pms WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$sql="UPDATE pms SET delete2 ='1' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
$result->close(); $db->close(); 
mysqli_close($con); 
}
if($dbutton == "Markierte gelesen/ungelesen"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$nid = $_REQUEST['msgid'];
$count = 0;
while($nid[$count] != ""){
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
text,
date
FROM
pms
WHERE id = "'.$nid[$count].'" AND an = "'.$userid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 1;
$gelesen = $row['gelesen'];
}
$result->close(); $db->close(); 
if($geht == 1){
if($gelesen == 1){
$sql="UPDATE pms SET gelesen ='0' WHERE id = '".$nid[$count]."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if($gelesen == 0){
$sql="UPDATE pms SET gelesen ='1' WHERE id = '".$nid[$count]."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
$count++;
}
mysqli_close($con); 
}
if($dbutton == "Markierte löschen"||$dbutton == ""){
if($nid == ""){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$nid = $_REQUEST['msgid'];
$count = 0;
while($nid[$count] != ""){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
if($page == 'eingang'){
$sql = 'SELECT
id,
an,
von,
delete1,
delete2
FROM
pms
WHERE id = "'.$nid[$count].'" AND an = "'.$userid.'" LIMIT 1';
}
elseif($page == 'ausgang'){
 $sql = 'SELECT
id,
an,
von,
delete1,
delete2
FROM
pms
WHERE id = "'.$nid[$count].'" AND von = "'.$userid.'" LIMIT 1';
}
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($page == 'eingang'){
if($row['delete2'] == 1){
$sql="DELETE FROM pms WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$sql="UPDATE pms SET delete1 ='1' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($page == 'ausgang'){
if($row['delete1'] == 1){
$sql="DELETE FROM pms WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$sql="UPDATE pms SET delete2 ='1' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
$result->close(); $db->close();
$count++;
}   
mysqli_close($con); 
}
else{             
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
if($page == 'eingang'){
$sql = 'SELECT
id,
an,
von,
delete1,
delete2
FROM
pms
WHERE id = "'.$nid.'" AND an = "'.$userid.'" LIMIT 1';
}
elseif($page == 'ausgang'){
 $sql = 'SELECT
id,
an,
von,
delete1,
delete2
FROM
pms
WHERE id = "'.$nid.'" AND von = "'.$userid.'" LIMIT 1';
}
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($page == 'eingang'){
if($row['delete2'] == 1){
$sql="DELETE FROM pms WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$sql="UPDATE pms SET delete1 ='1' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
if($page == 'ausgang'){
if($row['delete1'] == 1){
$sql="DELETE FROM pms WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$sql="UPDATE pms SET delete2 ='1' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
}
}
$result->close(); $db->close();    
mysqli_close($con); 
}
}
}
if($page == "lesen"){
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
text,
date
FROM
pms
WHERE id = "'.$nid.'" AND an = "'.$userid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gelesen = $row['gelesen'];
$geht = 1;
}
$result->close(); $db->close(); 
if($geht == 1&&$gelesen == 0){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE pms SET gelesen ='1' WHERE id = '".$nid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con); 
}
}
}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
echo '<a href="pms.php?page=eingang">Posteingang</a> <a href="pms.php?page=ausgang">Postausgang</a><br>';
echo '<a href="pms.php?page=schreiben">Nachricht schreiben</a>';
if($page == "schreiben"){
echo '<br>Um Nachrichten an mehrere User zu schreiben trenne ihre Namen durch Semikolon.<br> (BSP: Name1;Name2 )<br>';
echo '<form method="post" action="pms.php?aktion=senden"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
echo '<div class="eingabe1">';
if($ansend != ""){
$an = getwert($ansend,"charaktere","name","id");
echo '<input class="eingabe2" name="an" value="'.$an.'" size="15" maxlength="30" type="text">';
}
else{
echo '<input class="eingabe2" name="an" value="An" size="15" maxlength="30" type="text">';
}
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td>';
echo '<div class="eingabe1">';
$betreff = htmlspecialchars($_GET['betreff']); 
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
$nid = $_GET['id'];
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
text,
date,
delete1,
delete2
FROM
pms
WHERE 
id = "'.$nid.'" AND an = "'.$userid.'" AND delete1 = "0" 
OR
id = "'.$nid.'" AND von = "'.$userid.'" AND delete2 = "0" 
ORDER BY
date DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<center><table class="table tblfixed" width=50% cellspacing="0">';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr>';
echo '<td class="tdbg tdborder">';
echo 'Absender: ';
$von = getwert($row['von'],"charaktere","name","id");
if($von != ""){
echo '<a href="user.php?id='.$row['von'].'">'.$von.'</a>';
}
else{
if($row['von'] == "System"){
echo 'System';
}
else{
echo 'NoUser';
}
}
echo '</td>';
echo '<td class="tdbg tdborder">';
echo "<b>Betreff:</b> ".$row['betreff'];
echo '</td>';
echo '<td class="tdbg tdborder">';
$zeit2 = $row['date'];
$jahr = substr($zeit2 ,0 , 4);
$monat = substr($zeit2 ,5 ,2);
$tag = substr($zeit2 ,8 ,2);
$stunde = substr($zeit2 ,11 ,2);
$minute = substr($zeit2 ,14 ,2);
$uhrzeit = "$tag.$monat.$jahr um $stunde:$minute Uhr";
echo "<b>Datum:</b> $uhrzeit";
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdoh" colspan="3" rowspan="1">';
$text = $row['text'];                  
include 'inc/bbcode.php';
echo $bbcode->parse ($row['text']);
echo '</td>';
echo '</tr>';
}
$result->close(); $db->close(); 
echo '</table></center>';
}
if($page == "lesen"){
include 'inc/bbcode.php';
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
text,
date,
delete1,
delete2
FROM
pms
WHERE 
id = "'.$nid.'" AND an = "'.$userid.'" AND delete1 = "0" 
OR
id = "'.$nid.'" AND von = "'.$userid.'" AND delete2 = "0" 
ORDER BY
date DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table tblfixed" width=100% cellspacing="0">';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr>';
echo '<td class="tdbg tdborder">';
if($row['an'] == $userid){
echo 'Absender: ';
$von = getwert($row['von'],"charaktere","name","id");
if($von != ""){
echo '<a href="user.php?id='.$row['von'].'">'.$von.'</a>';
}
else{
if($row['von'] == "System"){
echo 'System';
}
else{
echo 'NoUser';
}
}
}
else{
echo 'Empfänger: ';       
$an = getwert($row['an'],"charaktere","name","id");                              
if($an != ""){
echo '<a href="user.php?id='.$row['an'].'">'.$an.'</a>';
}
else{
echo 'NoUser';
}
}
echo '</td>';
echo '<td class="tdbg tdborder">';
echo "<b>Betreff:</b> ".$row['betreff'];
echo '</td>';
echo '<td class="tdbg tdborder">';
$zeit2 = $row['date'];
$jahr = substr($zeit2 ,0 , 4);
$monat = substr($zeit2 ,5 ,2);
$tag = substr($zeit2 ,8 ,2);
$stunde = substr($zeit2 ,11 ,2);
$minute = substr($zeit2 ,14 ,2);
$uhrzeit = "$tag.$monat.$jahr um $stunde:$minute Uhr";
echo "<b>Datum:</b> $uhrzeit";
echo '</td>';
echo '</tr>';
echo '<tr>';
if($row['an'] == $userid){
echo '<td class="tdoh tdborder" colspan="3" rowspan="1">';
}
else{
echo '<td class="tdoh" colspan="3" rowspan="1">';
}
$text = $row['text'];
echo $bbcode->parse ($row['text']);
echo '</td>';
echo '</tr>';
if($row['an'] == $userid){
echo '<tr height="40px">';
echo '<td align=center class="tdbg tdborder">';
echo '<form method="post" action="pms.php?page=schreiben&an='.$row['von'].'&betreff='.$row['betreff'].'&id='.$row['id'].'">';         
echo '<input class="button" name="login" id="login" value="antworten" type="submit">';
echo '</form>';
echo '</td>';      
echo '<td align=center class="tdbg tdborder">';
echo '<form method="post" action="pms.php?aktion=melden&nid='.$row['id'].'">';         
echo '<input type="checkbox" name="checked" value="Ja"> <input class="button" name="login" id="login" value="melden" type="submit">';
echo '</form>';
echo '</td>';
echo '<td align=center class="tdbg tdborder">';
echo '<form method="post" action="pms.php?aktion=set&nid='.$row['id'].'">';         
echo '<input class="button" name="login" id="login" value="löschen" type="submit">';
echo '</form>';
echo '</td>';
echo '</tr>';
}
}
$result->close(); $db->close(); 
echo '</table>';
echo '<br>';

}
if($page == "eingang"||$page == 'ausgang'){
if($wo == ""){
$wo = 1;
}
echo '<form method="post" action="pms.php?page='.$page.'&aktion=set">';
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">';
if($page == 'eingang'){
echo 'Von';
}
if($page == 'ausgang'){
echo 'An';
}
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Betreff';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Datum';
echo '</td>';
echo '<td width="100px" class="tdbg tdborder">';
echo '</td>';
echo '<td width="20px" class="tdbg tdborder">';
echo '<input onclick="checkbox('."'msgid[]'".', this)" type="checkbox">';
echo '</td>';
echo '</tr>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
if($page == 'eingang'){
$sql = 'SELECT
id,
an,
von,
betreff,
gelesen,
date,
delete1,
delete2
FROM
pms        
WHERE 
an = "'.$userid.'" AND delete1 = "0" 
ORDER BY
date
DESC';
}
elseif($page == 'ausgang'){
$sql = 'SELECT
id,
an,
von,
betreff,
gelesen,
date,
delete1,
delete2
FROM
pms        
WHERE 
von = "'.$userid.'" AND delete2 = "0" 
ORDER BY
date
DESC';
}
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$anzahl = 0;
$aps = 15;
$min = (($aps*$wo)-($aps-1)); 
$max = $aps*$wo;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$anzahl++;
if($anzahl >= $min && $anzahl <= $max){
echo '<tr>';
echo '<td class="tdborder">';        
if($page == 'eingang'){
$von = getwert($row['von'],"charaktere","name","id");
if($von != ""){
echo '<a href="user.php?id='.$row['von'].'">'.$von.'</a>';
}
else{
if($row['von'] == "System"){
echo 'System';
}
else{
echo 'NoUser';
}
}
}
if($page == 'ausgang'){
$an = getwert($row['an'],"charaktere","name","id");      
if($an != ""){
echo '<a href="user.php?id='.$row['an'].'">'.$an.'</a>';
}
else{
echo 'NoUser';
}
}
echo '</td>';
echo '<td class="tdborder">';
echo '<a href="pms.php?page=lesen&nid='.$row['id'].'">';
if($row['gelesen'] == 0){
echo "<b><blink>".$row['betreff']."</blink></b>";
}
else{
echo $row['betreff'];
}
echo '</a>';
echo '</td>';
echo '<td class="tdborder">';
$zeit2 = $row['date'];
$jahr = substr($zeit2 ,0 , 4);
$monat = substr($zeit2 ,5 ,2);
$tag = substr($zeit2 ,8 ,2);
$stunde = substr($zeit2 ,11 ,2);
$minute = substr($zeit2 ,14 ,2);
$uhrzeit = "$tag.$monat.$jahr um $stunde:$minute Uhr";
echo "$uhrzeit";
echo '<td class="tdborder">';
echo '<a href="pms.php?page=lesen&nid='.$row['id'].'">lesen</a> / ';
echo '<a href="pms.php?page='.$page.'&aktion=set&nid='.$row['id'].'">löschen</a>';
echo '</td>';
echo '<td class="tdborder"><input class="cursor" type="checkbox" name="msgid[]" value="'.$row['id'].'" /></td>';
echo '</tr>';
}
}
$result->close(); $db->close(); 
echo '</table>';
echo '<table class="table" width="100%" cellspacing="3px">';
echo '<tr height="40px">';
echo '<td width="200px" align="center">';
echo '<input class="button" name="delete" id="delete" value="Markierte löschen" type="submit" >';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<input class="button" name="delete" id="delete" value="Markierte gelesen/ungelesen" type="submit" >';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<input class="button" name="delete" id="delete" value="Alle löschen" type="submit">';
echo '</form>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<br>';
if($anzahl > $aps){
$count = 1;
while($anzahl > 0){
echo '<a href="pms.php?page='.$page.'&wo='.$count.'"> '.$count.' </a>';
$anzahl = $anzahl-$aps;
$count++;
}
}
echo '<br>';
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