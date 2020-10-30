<?php
include 'inc/incoben.php';    
if(logged_in()){
$aktion = $_GET['aktion'];               
if($aktion == "edit"){   
     
$userid = getwert(session_id(),"charaktere","id","session");
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
if($_POST['theme']){              
$youtubecheck = substr($_POST['theme'], 0, 32);   
if($youtubecheck == 'https://www.youtube.com/watch?v='){   
$theme = substr($_POST['theme'], 0, 43);       
$sql="UPDATE charaktere SET theme ='$theme' WHERE id = '".$userid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$error = $error.'Dies ist kein gültiges Youtubevideo. Bitte das Format "https://www.youtube.com/watch?v=" einhalten!<br>';
}
}
else{
$sql="UPDATE charaktere SET theme ='' WHERE id = '".$userid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
if(isset($_POST['bild']) && $_FILES['file_upload']['name'] != ''){
$imgHandler = new ImageHandler('userdata/profilbild/');
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
$sql="UPDATE charaktere SET bild ='$bild' WHERE id = '".$userid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$error = $error.$message.'<br/>';
}
}
if(isset($_POST['kbild']) && $_FILES['file_upload2']['name'] != ''){
$imgHandler = new ImageHandler('userdata/kampfbild/');
$result = $imgHandler->Upload($_FILES['file_upload2'], $kbild, 100, 100);
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
$sql="UPDATE charaktere SET kbild ='$kbild' WHERE id = '".$userid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$error = $error.$message.'<br/>';
}
}

if($_POST['ptext']){
$ptext = real_escape_string($_POST['ptext']);
$sql="UPDATE charaktere SET ptext ='$ptext' WHERE id = '".$userid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}
else{
$sql="UPDATE charaktere SET ptext ='' WHERE id = '".$userid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}

mysqli_close($con);
}

}
if(logged_in()){
include 'inc/design1.php';
include 'inc/bbcode.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                              
$admin = getwert(session_id(),"charaktere","admin","session");   
$uid = getwert(session_id(),"charaktere","id","session");     
$uautoplay = getwert(session_id(),"charaktere","autoplay","session");
echo '<table class="table2" width="100%" cellspacing="0">';
echo '<tr>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
level,
rank,
dorf,
session,
bild,
clan,
ptext,
geschlecht,
admin,
exp,
mmissi,
org,
bijuu,
theme,
ip,
siege,
niederlagen,
platz,
main
FROM
charaktere
WHERE session = "'.session_id().'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$platz = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$exist = 1;
echo '<td class="tdbr" width="400px">';
if($row['bild'] == ""){   
echo '<img src="bilder/design/nopic.png"></img>';
}else{
echo '<img src="'.$row['bild'].'"></img>';
}
$ptext = $row['ptext']; 
$ptheme = $row['theme'];
$uname = $row['name'];
echo '</td>';
echo '<td valign="top">';
echo '<table class="shadow" width="100%">';
echo '<tr>';
echo '<td width="50%"><b>Name:</b></td> <td width="50%">'.$row['name'].'</td>';   
echo '</tr>';
echo '<tr>';
echo '<td width="50%"><b>Level:</b></td> <td width="50%">'.$row['level'].'</td>';  
echo '</tr>';
echo '<tr>';
echo '<td width="50%"><b>Platz:</b></td> <td width="50%">'.$row['platz'].'</td>';         
echo '</tr>';
echo '<tr>';
if($row['rank'] == 'kage'){  
$tdorf = getwert($row['dorf'],"orte","name","id"); 
if($tdorf == 'konoha'){
$rank = 'Hokage';
}
elseif($tdorf == 'kiri'){
$rank = 'Mizukage';
}  
elseif($tdorf == 'suna'){
$rank = 'Kazekage';
}                
elseif($tdorf == 'iwa'){
$rank = 'Tsuchikage';
}                  
elseif($tdorf == 'kumo'){
$rank = 'Raikage';
}               
elseif($tdorf == 'oto'){
$rank = 'Nekage';
}              
elseif($tdorf == 'ame'){
$rank = 'Ukage';
}             
elseif($tdorf == 'kusa'){
$rank = 'Sokage';
}              
elseif($tdorf == 'taki'){
$rank = 'Takikage';
}                
else{
$rank = 'Kage';
}
echo '<td width="50%"><b>Rang:</b></td> <td width="50%">'.$rank.'</td>';
}
elseif($row['rank'] == 'nuke-nin'){      
if($row['level'] >= 60){
$rank = 'S-Rang Nuke-Nin';
}
if($row['level'] >= 50&&$row['level'] < 60){
$rank = 'A-Rang Nuke-Nin';
}
if($row['level'] >= 30&&$row['level'] < 50){
$rank = 'B-Rang Nuke-Nin';
}
if($row['level'] >= 10&&$row['level'] < 30){
$rank = 'C-Rang Nuke-Nin';
}
if($row['level'] < 10){
$rank = 'D-Rang Nuke-Nin';
}       
echo '<td width="50%"><b>Rang:</b></td> <td width="50%">'.$rank.'</td>';   
} 
else{
echo '<td width="50%"><b>Rang:</b></td> <td width="50%">'.ucwords($row['rank']).'</td>';   
}
echo '</tr>';
echo '<tr>';                
if($row['dorf'] != 'kein'){    
$tdorf = getwert($row['dorf'],"orte","name","id"); 
}
else{
$tdorf = $row['dorf'];
}
echo '<td width="50%"><b>Dorf:</b></td> <td width="50%">'.ucwords($tdorf).'</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="50%"><b>Bluterbe:</b></td> <td width="50%">'.ucwords($row['clan']).'</td>';  
echo '</tr>';        
echo '<tr>'; 
if($row['geschlecht'] == "männlich"){
$color = "#00469c";
}
if($row['geschlecht'] == "weiblich"){
$color = "#a400f9";
}
echo '<td width="50%"><b>Geschlecht:</b></td> <td width="50%"><font color="'.$color.'">'.ucfirst($row['geschlecht']).'</font></td>';     
echo '</tr>';    
echo '<tr>'; 
if($row['bijuu'] != ""){    
echo '<tr>'; 
echo '<td width="50%"><b>Bijuu:</b></td><td width="50%"><a border="0" href="user.php?id='.$row['bijuu'].'"><img width="50px" height="45px" src="bilder/krieg/'.$row['bijuu'].'.gif"></img></a></td>';     
echo '</tr>'; 
}
if($row['org'] != "0"){     
echo '<tr>'; 
$oname = getwert($row['org'],"org","name","id");            
echo '<td width="50%"><b>Org/Team:</b></td> <td width="50%"><a href="org.php?page=see&org='.$row['org'].'">'.$oname.'</td></td>';  
echo '</tr>';  
}               
echo '<tr>';          
echo '<td width="50%"><b>S/N:</b></td> <td width="50%">'.$row['siege'].' / '.$row['niederlagen'].'</td>';  
echo '</tr>';                                                                                                                       
if($row['admin'] != 0){    
echo '<tr>'; 
echo '<td width="100%" colspan="2">';
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
echo '</tr>';         
}                          
echo '<tr>';      
echo '<td width="100%" colspan="2">';                  
if($row['session'] != NULL){
echo '<font color="#00ff00"><b>Online</b></font>';
}
else{
echo '<font color="#ff0000"><b>Offline</b></font>';
}  
echo '</td>';
echo '</tr>';
echo '</table>';  
}
$result->close(); $db->close(); 
echo '<br>';
echo '<center><table>';
echo '<tr>';
echo '<td>';
echo '<div class="light">';
echo '<a href="pms.php?page=schreiben&an='.$uid.'" border="0"><img src="bilder/design/mail.png" width="40px" height="40px" border="0"></img></a>';
echo '</div>';
echo '</td>';        
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
WHERE an = "'.$uid.'" AND von = "'.$userid.'" OR von = "'.$uid.'" AND an = "'.$userid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 1;
}
$result->close(); $db->close();      
echo '<td>';
echo '<div class="light">';
if($geht == 0){                                                                                
echo '<a href="friends.php?aktion=anfragen&fid='.$uid.'"><img src="bilder/design/friend.png" width="40px" height="40px" border="0"></img></a>';
}
else{
echo '<img src="bilder/design/friend2.png" width="40px" height="40px" border="0"></img>';
}            
echo '</div>';
echo '</td>';   
echo '<td>';
echo '<div class="light">';
echo '<a href="friends.php?aktion=ignorier&fid='.$uid.'"><img src="bilder/design/sperren.png" width="40px" height="40px" border="0"></img></a>';
echo '</div>';
echo '</td>';  
echo '</tr>'; 
if($admin != 0){  
echo '<tr>';           
echo '<td>';
echo '<div class="light">';
echo '<a href="mod.php?page=rename&ruser='.$uid.'"><img src="bilder/design/rename.png" width="40px" height="40px" border="0"></img></a>';
echo '</div>';
echo '</td>';  
echo '<td>';
echo '<div class="light">';
echo '<a href="mod.php?page=mainset&muser='.$uid.'"><img src="bilder/design/multi.png" width="40px" height="40px" border="0"></img></a>';
echo '</div>';
echo '</td>';
echo '</tr>';
}
if($admin == 3){          
echo '<tr><td>';   
echo '<div class="light">';
echo '<a href="admin.php?page=rundmail&an='.$uname.'"><img src="bilder/design/rundmail.png" width="40px" height="40px" border="0"></img></a>'; 
echo '</div>';
echo '</td>';     
echo '<td>';  
echo '<div class="light">';
echo '<a href="admin.php?page=edit&was=charaktere&id='.$uid.'"><img src="bilder/design/edit.png" width="40px" height="40px" border="0"></img></a>';
echo '</div>';
echo '</td>';    
echo '<td>';
echo '<div class="light">';
echo '<a href="admin.php?aktion=aktion&wer='.$uid.'"><img src="bilder/design/aktion.png" width="40px" height="40px" border="0"></img></a>';
echo '</div>';
echo '</td>';
echo '<td>';
echo '<div class="light">';
echo '<a href="admin.php?aktion=login&wer='.$uid.'"><img src="bilder/design/login.png" width="40px" height="40px" border="0"></img></a>'; 
echo '</div>';
echo '</td>';
echo '<td>';
echo '<div class="light">';
echo '<a href="admin.php?page=turnieradd&uid='.$uid.'"><img src="bilder/design/friend.png" width="40px" height="40px" border="0"></img></a>'; 
echo '</div>';
echo '</td></tr>';
}         
echo '</tr></table>';
if($ptheme != ""){    
$theme = substr($ptheme, -11); 
if($uautoplay)
  $theme = $theme.'?autoplay=1';
echo '<iframe width="150" height="100" src="https://www.youtube-nocookie.com/embed/'.$theme.'" frameborder="0" allow="accelerometer; ';
if($uautoplay)
  echo 'autoplay; ';
echo 'encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
}
if($ptext != ""){
echo '<tr>';
echo '<td colspan="2" rowspan="2" class="tdbo">';
echo '<table width="100%" class="tblfixed"><tr><td class="tdoh" align="left">';   
echo $bbcode->parse ($ptext);
echo '</td></tr></table></center>';
echo '</td>';  
echo '</tr>';   
}
echo '</table>';
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
wetter
FROM
fights
ORDER BY
id DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
$count2 = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['ende'] == 1){   
$array = explode(" ", trim($row['spieler']));  
$count = 0;
$drin = 0;
while($array[$count] != ''){      
if($array[$count] == $uid){
$drin = 1;
}
$count++;
}       
if($drin == 1&&$count2 != 3){ 
$count2++;    
echo '<tr>';                      
echo '<td>'.$row['id'].'</td>';
echo '<td>'.$row['name'].'</td>';
echo '<td>';
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
echo '<br>So sehen dich andere User, achte darauf , dass alles ordentlich aussieht!<br>';
echo '<form method="post" action="profil.php?aktion=edit" enctype="multipart/form-data">';
echo '<table width="100%" class="shadow">';
echo '<tr>';
echo '<td align="center" width="345px"><b>Bild (Max: 550 Breite 600 Höhe)</b></td>';
echo '<td align="left">';       
echo '<input type="file" name="file_upload" /><input type="hidden" name="bild"/>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center"  width="345px"><b>Kampf (Max: 100 Breite 100 Höhe)</b></td>';
echo '<td align="left">';       
echo '<input type="file" name="file_upload2" /><input type="hidden" name="kbild"/>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center" width="345px"><b>Theme (Youtubelink)</b></td>';
echo '<td align="left">';         
$theme = getwert(session_id(),"charaktere","theme","session");
echo '<div class="eingabe3">
<input class="eingabe4" name="theme" value="'.$theme.'" size="15" maxlength="50" type="text">
      </div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center" colspan="2" rowspan="1">';
echo '<div class="textfield2">
<textarea class="textfield" name="ptext" maxlength="300000">'.$ptext.'</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<input class="button" name="login" id="login" value="ändern" type="submit"></form>';
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