<?php
include 'inc/incoben.php';
if(logged_in()){     
$admin = getwert(session_id(),"charaktere","admin","session");  
$uid = getwert(session_id(),"charaktere","id","session");
if($admin != 0){   
$aktion = $_GET['aktion'];   
if($aktion == "mainset"){    
$chara = $_GET['chara'];    
$radmin = getwert($chara,"charaktere","admin","id"); 
$rname = getwert($chara,"charaktere","name","id"); 
if($radmin < 2){  
$mainacc = $_POST['mainacc'];  
if(is_numeric($chara)&&is_numeric($mainacc))
{
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET main='".$mainacc."' WHERE id = '".$chara."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);
$text = '<b>'.$zeit.'</b>;'.$uid.';hat den Hauptaccount von <a href="user.php?id='.$chara.'"><b>'.$rname.'</b></a> auf <b>'.$mainacc.'</b> geändert.';
$modlog = getwert(1,"game","modlog","id");
if($modlog == ""){
$modlog = $text;
}
else{
$modlog = $text.'@'.$modlog;
}    
$sql="UPDATE game SET modlog ='$modlog' LIMIT 1";  
mysqli_query($con, $sql);   
$error = 'Der Hauptaccount von '.$rname.' wurde geändert.'; 
mysqli_close($con); 
}
}
}
if($aktion == "rename"){
$ruser = $_POST['ruser'];      
$rename = $_POST['rename'];
if($rename != ""&&$ruser != ""){  
$rname = getwert($ruser,"charaktere","name","id"); 
$geht = 1;   
if(!sonderzeichen($rename)){
$geht = 0;
$error = $error."Es befinden sich Sonderzeichen im Namen.<br>";
}
if(!namencheck($rename)){
$geht = 0;
$error = $error."Der Namen hat unzulässige Wörter im Namen.<br>";
} 
if($geht == 1){  
$radmin = getwert($ruser,"charaktere","admin","name"); 
if($radmin < 2){  

$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET kname ='$rename',name ='$rename' WHERE id = '".$ruser."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);
$text = '<b>'.$zeit.'</b>;'.$uid.';hat den Namen von <a href="user.php?id='.$ruser.'"><b>'.$rname.'</b></a> auf <b>'.$rename.'</b> geändert.';
$modlog = getwert(1,"game","modlog","id");
if($modlog == ""){
$modlog = $text;
}
else{
$modlog = $text.'@'.$modlog;
}    
$sql="UPDATE game SET modlog ='$modlog' LIMIT 1";  
mysqli_query($con, $sql);   
$error = $rname.' wurde umbenannt.'; 
mysqli_close($con); 
}
}
}
else{
$error = "Du hast keinen Text angegeben.";
}
}


}
}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
if($admin != 0){
echo '<h2 class="shadow">Mod Menü</h2>';   
echo '<br>'; 
$page = $_GET['page'];
if($page == "rename"){
$ruser = $_GET['ruser'];  
if($ruser){    
$rename = getwert($ruser,"charaktere","name","id"); 
} 
else{
$rename = 'Neuer Name';
}
echo '<form method="post" action="mod.php?aktion=rename"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    charaktere
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="ruser" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {
echo'<option value="';
echo $row['id'];  
if($row['id'] == $ruser){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name']; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';
echo '</td>';
echo '<tr align=center>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="rename" value="'.$rename.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="Namen ändern" type="submit">';
echo '</td>';
echo '</tr>';
echo '</table></form><br>';

}
if($page == "oldchat"){
include '../chat/inc/serverdaten.php';   
      $db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      user,
      text,
      date,
      art,
      wo,
      zeigen,
      wid,
      an,
      raum      
      FROM
      oldposts
      ORDER BY
      date DESC';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }
      $count = 1;
      echo '<table class="table" style="text-align:left;" cellspacing="0" width="100%" height="100%">';
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false     
      if($row['art'] == 3&&$admin == 3||$row['art'] != 3){
      if(strtolower($row['raum']) == 'nbg'||$admin == 3){     
      echo '<tr>';
      $jahr = substr($row['date'] ,0 , 4); 
      $monat = substr($row['date'] ,5 ,2); 
      $tag = substr($row['date'] ,8 ,2);   
      $stunde = substr($row['date'] ,11 ,2);
      $minute = substr($row['date'] ,14 ,2);     
      $time = "$stunde:$minute";  
      if($count == 1){             
      echo '<td class="tdborder" width="60px">';
      echo $row['raum'];
      echo '</td>';
      echo '<td class="tdborder" width="50px">';
      echo $time;
      echo '</td>';
      echo '<td class="tdborder">';
      $count = 2;
      }
      elseif($count == 2){          
      echo '<td class="tdbg tdborder" width="60px">';
      echo $row['raum'];
      echo '</td>';
      echo '<td class="tdbg tdborder" width="50px">';
      echo $time;
      echo '</td>';
      echo '<td class="tdbg tdborder">';
      $count = 1;
      }            
      if($row['zeigen'] == 0){
      echo '<strike>';
      }    
      if($row['art'] == 1){         
      echo '<b><a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a></b>: '; 
      echo utf8_decode($row['text']);    
      }
      if($row['art'] == 2){
      echo '<font color="#00bb00">*<b>'.'<a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a>'.'</b> '.utf8_decode($row['text']).'*</font>';   
      }       
      if($row['art'] == 3){         
      echo '<font color="#00bbbb"><b>'.'<a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a>'.'</b> flästert an <b>'.$row['an'].'</b>: ';    
      echo utf8_decode($row['text']).'</font>';  
      }
      if($row['art'] == 4){
      echo '<font color="#aa0000">*<b>'.'<a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a>'.'</b> '.utf8_decode($row['text']).' *</font>';  
      }  
      if($row['art'] == 5){
      echo '<font color="#225599">*<b>'.'<a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a>'.'</b> '.$row['text'].'*</font>';   
      }       
      if($row['zeigen'] == 0){
      echo '</strike>';
      }    
      echo '</td>';
      echo '</tr>';   
      }
      }
      }
      $result->close();   
      $db->close(); 
      echo '<tr></tr></table>';

}
if($page == "chat"){
include '../chat/inc/serverdaten.php';   
      $db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      user,
      text,
      date,
      art,
      wo,
      zeigen,
      wid,
      an,
      raum      
      FROM
      posts
      ORDER BY
      date DESC';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }
      $count = 1;
      echo '<table class="table" style="text-align:left;" cellspacing="0" width="100%" height="100%">';
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false     
      if($row['art'] == 3&&$admin == 3||$row['art'] != 3){
      if(strtolower($row['raum']) == 'nbg'||$admin == 3){     
      echo '<tr>';
      $jahr = substr($row['date'] ,0 , 4); 
      $monat = substr($row['date'] ,5 ,2); 
      $tag = substr($row['date'] ,8 ,2);   
      $stunde = substr($row['date'] ,11 ,2);
      $minute = substr($row['date'] ,14 ,2);     
      $time = "$stunde:$minute";  
      if($count == 1){             
      echo '<td class="tdborder" width="60px">';
      echo $row['raum'];
      echo '</td>';
      echo '<td class="tdborder" width="50px">';
      echo $time;
      echo '</td>';
      echo '<td class="tdborder">';
      $count = 2;
      }
      elseif($count == 2){          
      echo '<td class="tdbg tdborder" width="60px">';
      echo $row['raum'];
      echo '</td>';
      echo '<td class="tdbg tdborder" width="50px">';
      echo $time;
      echo '</td>';
      echo '<td class="tdbg tdborder">';
      $count = 1;
      }            
      if($row['zeigen'] == 0){
      echo '<strike>';
      }    
      if($row['art'] == 1){         
      echo '<b><a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a></b>: '; 
      echo utf8_decode($row['text']);    
      }
      if($row['art'] == 2){
      echo '<font color="#00bb00">*<b>'.'<a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a>'.'</b> '.utf8_decode($row['text']).'*</font>';   
      }       
      if($row['art'] == 3){         
      echo '<font color="#00bbbb"><b>'.'<a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a>'.'</b> flästert an <b>'.$row['an'].'</b>: ';    
      echo utf8_decode($row['text']).'</font>';  
      }
      if($row['art'] == 4){
      echo '<font color="#aa0000">*<b>'.'<a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a>'.'</b> '.utf8_decode($row['text']).' *</font>';  
      }  
      if($row['art'] == 5){
      echo '<font color="#225599">*<b>'.'<a href="?p=profil&id='.$row['wid'].'">'.$row['user'].'</a>'.'</b> '.$row['text'].'*</font>';   
      }       
      if($row['zeigen'] == 0){
      echo '</strike>';
      }    
      echo '</td>';
      echo '</tr>';   
      }
      }
      }
      $result->close();   
      $db->close(); 
      echo '<tr></tr></table>';

}
if($page == 'mainset')
{
$muser = $_REQUEST['muser'];  
if($muser){
$multiname = getwert($muser,"charaktere","name","id"); 
$mainacc = getwert($muser,"charaktere","main","id"); 
echo '<br><h3>'.$multiname.'</h3><br>';  
echo '<form method="post" action="mod.php?aktion=mainset&chara='.$muser.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="mainacc" value="'.$mainacc.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="Main ändern" type="submit">';
echo '</td>';
echo '</tr>';
echo '</table></form><br>';

}

}
if($page == "multicheck"){
?>
<h2>
  MultiCheck
</h2>
<form method="GET" action="mod.php?page=multicheck">
  <input type="hidden" name="page" value="multicheck">
  <div class="eingabe3">
<input class="eingabe4" type="text" name="chara" placeholder="Charaktername" size="15" maxlength="50" type="text">
      </div>
  <div class="eingabe3">
<input class="eingabe4" type="text" name="score" placeholder="Mindestscore" size="15" maxlength="50" type="text">
      </div>
<input class="button" type="submit" style="width:50%" value="Überprüfen">
</form>
<?php
if(isset($_GET['chara']))
{
  $score = $_GET['score'];
  if(!is_numeric($score))
    $score = 0;
  
  $result = LoginTracker::CheckCharacter($accountDB, $_GET['chara'], 'nbg', $score);
  ?>
  <br/>
  <hr>
  Alle Multis von <?php echo $_GET['chara']; ?>:<br/><br/>
  <?php
  echo $result;
}
}
if($page == 'multi'){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
ip
FROM
charaktere
ORDER BY id';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td width="80px" class="tdbg tdborder">';
echo 'ID';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Name';
echo '</td>';   
echo '<td class="tdbg tdborder">';
echo 'Multis';
echo '</td>'; 
echo '</tr>';
$multisa = 0;
$multischeck = '';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false    
$multic = getanzahl($row['ip'],"charaktere","ip",1);  
if($multic > 1){      
$count = 0;
$geht = 1;
while($multischeck[$count] != ''){
if($multischeck[$count] == $row['id']){
$geht = 0;
}
$count++;
}
if($geht == 1){
$multischeck[$multisa] = $row['id']; 
$multisa++;  
echo '<tr>';   
echo '<td class="tdborder">';
echo $row['id'];
echo '</td>'; 
echo '<td class="tdborder">';
echo '<a href="user.php?id='.$row['id'].'">'.$row['name'].'</a>';
echo '</td>';  
echo '<td class="tdborder">';  
$sql2 = '
SELECT
id,
name,
ip
FROM
charaktere
WHERE ip="'.$row['ip'].'" AND id != "'.$row['id'].'"';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}     
$check = 0;
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false  
$multischeck[$multisa] = $row2['id']; 
$multisa++;  
if($check == 1){
echo ', ';
} 
else{
$check = 1;
} 
echo '<a href="user.php?id='.$row2['id'].'">'.$row2['name'].'</a>';
}   
$result2->close();
echo '</td>';      
echo '</tr>';
}
}
}
$result->close(); $db->close(); 
echo '</table>';
}
if($page == 'handellog'){ 
$handellog = getwert(1,"game","handellog","id");
if($handellog != ""){  
$seite = $_GET['seite'];
if($seite == ""){
$seite = 1;
}                          
$platz = 0;
$ps = 20;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
echo '<table class="table2" width="100%" cellspacing="0">';
$array = explode("@", trim($handellog));
$count = 0;
$platz = 0;
while(isset($array[$count])){     
$platz++;
if($platz >= $von&&$platz <= $bis){ 
$array2 = explode(";", trim($array[$count]));  
$name = getwert($array2[1],"charaktere","name","id"); 
echo '<tr>';
echo '<td>';
echo $array2[0];    
echo '</td>';   
echo '<td>';
echo '<a href="user.php?id='.$array2[1].'">'.$name.'</a>';   
echo ' ';
echo $array2[2];   
echo '</td>';   
echo '</tr>';   
}
$count++;
}
echo '</table>'; 
$count = 1;
$anzahl = $platz;
if($platz > $ps){
while($platz > 0){
$platz = $platz-$ps;
echo '<a href="mod.php?page=handellog&seite='.$count.'">'.$count.'</a> ';
$count++;
}
}
if($anzahl != 1){
echo '<br>'.$anzahl.' Einträge im Log.';
}
else{    
echo '<br>'.$anzahl.' Eintrag im Log.';
}
}
}
if($page == ""){
echo '<table width="100%">';
echo '<tr height="50px">';                                   
echo '<td>';
echo '<b><a href="mod.php?page=chat">Chatlog</a></b>'; 
echo '</td>';                                
echo '<td>';
echo '<b><a href="mod.php?page=rename">Umbenennen</a></b>'; 
echo '</td>';                             
echo '<td>';
echo '<b><a href="mod.php?page=multicheck">Multicheck</a></b>'; 
echo '</td>';    
echo '</tr>';   
echo '<tr height="50px">';                                   
echo '<td>';    
echo '<b><a href="mod.php?page=oldchat">Chatlog vom Vortag</a></b>';  
echo '</td>';      
echo '<td>';    
echo '<b><a href="mod.php?page=handellog">Handelslog</a></b>';  
echo '</td>';                               
echo '<td>';
echo '<b><a href="mod.php?page=multi">Multiliste</a></b>'; 
echo '</td>';  
echo '</tr>';
echo '</table>';
echo '<br>'; 
echo '<br>';   
$modlog = getwert(1,"game","modlog","id");
if($modlog != ""){  
$seite = $_GET['seite'];
if($seite == ""){
$seite = 1;
}                          
$platz = 0;
$ps = 20;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
echo '<table class="table2" width="100%" cellspacing="0">';
$array = explode("@", trim($modlog));
$count = 0;
$platz = 0;
while(isset($array[$count])){     
$platz++;
if($platz >= $von&&$platz <= $bis){ 
$array2 = explode(";", trim($array[$count]));    
$name = getwert($array2[1],"charaktere","name","id");
echo '<tr>';
echo '<td>';
echo $array2[0];    
echo '</td>';   
echo '<td>';
echo '<a href="user.php?id='.$array2[1].'">'.$name.'</a>';   
echo ' ';
echo $array2[2];   
echo '</td>';   
echo '</tr>';  
}
$count++;
}
echo '</table>'; 
$count = 1;
$anzahl = $platz;
if($platz > $ps){
while($platz > 0){
$platz = $platz-$ps;
echo '<a href="mod.php?&seite='.$count.'">'.$count.'</a> ';
$count++;
}
}
if($anzahl != 1){
echo '<br>'.$anzahl.' Einträge im Log.';
}
else{    
echo '<br>'.$anzahl.' Eintrag im Log.';
}
}

}
else{
echo '<br>';
echo '<a href="mod.php">Zurück</a>';
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