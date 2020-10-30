<?php
  include 'inc/incoben.php';      
  if(logged_in()){
$userid = getwert(session_id(),"charaktere","id","session");  
$aktion = $_GET['aktion'];
$fid = real_escape_string($_GET['fid']);
if($aktion == 'ignorier'){    
if($userid != $fid){
$fadmin = getwert($fid,"charaktere","admin","id");  
if($fadmin == 0){
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
      WHERE user="'.$userid.'" AND ignoriert = "'.$fid.'"Limit 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }         
      $geht = 1;        
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
      $geht = 0;
      }
      $result->close();     
    $db->close();
    
if($geht == 1){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO ignoriert(
`user`,`ignoriert`) 
VALUES
('$userid',
'$fid')";
if (!mysqli_query($con, $sql))
  {
  die('Error: ' . mysqli_error($con));
  } 
mysqli_close($con); 
  $error = "Du hast den User nun ignoriert.";  
}
else{
$error = 'Du hast diesen User schon ignoriert.';
}
}
else{
$error = 'Support Mitglieder können nicht ignoriert werden.';
}
}
else{
$error = 'Du kannst dich nicht selbst ignorieren.';
}
}   
if($aktion == 'idelete'){
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
      WHERE user="'.$userid.'" AND ignoriert = "'.$fid.'"Limit 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }         
      $geht = 0;        
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
      $geht = 1;
      $flid = $row['id'];
      }
      $result->close();     
    $db->close();
    
if($geht == 1){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
			$sql="DELETE FROM ignoriert WHERE id = '".$flid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }    
mysqli_close($con); 
  $error = "Du ignorierst den User nicht mehr.<br>";  
}
else{
$error = 'Dieser User ist von dir nicht ignoriert.';
}
}
if($aktion == "annehmen"){    
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
    an = "'.$fid.'" AND von = "'.$userid.'"
    OR
    von = "'.$fid.'" AND an ="'.$userid.'"
    Limit 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }         
      $geht = 0;        
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
      $flid = $row['id'];
      $accept = $row['accept'];
      $geht = 1;
      }
      $result->close();     
$db->close();
if($geht == 1){
if(!$accept){  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE freunde SET accept ='1' WHERE id = '".$flid."' Limit 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
mysqli_close($con);                                             
    $fname = getwert($fid,"charaktere","name","id");    
    $error = $error."Du hast die Freundschaft mit $fname angenommen.<br>";


}
else{
$error = $error."Ihr seid schon Freunde.<br>";
}  
}
else{     
$error = $error."Es besteht keine Anfrage.<br>";

}
}
if($aktion == "ablehnen"||$aktion == "back"||$aktion == "delete"){    
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
    an = "'.$fid.'" AND von = "'.$userid.'"
    OR
    von = "'.$fid.'" AND an = "'.$userid.'"
    Limit 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }         
      $geht = 0;        
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
      $flid = $row['id'];
      $geht = 1;
      }
      $result->close();     
$db->close();
if($geht == 1){       
    $fname = getwert($fid,"charaktere","name","id");         
if($aktion == "ablehnen"){       
$error = $error."Du hast die Anfrage von $fname abgelehnt.<br>";
}
if($aktion == "back"){
$error = $error."Du hast die Anfrage an $fname zurückgenommen.<br>";
}
if($aktion == "delete"){       
$error = $error."Du hast die Freundschaft mit $fname beendet.<br>";

}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));             
			$sql="DELETE FROM freunde WHERE id = '".$flid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }    
mysqli_close($con); 

 
}
else{          
if($aktion == "ablehnen"||$aktion == "back"){       
$error = $error."Es besteht keine Anfrage.<br>";
}
if($aktion == "delete"){        
$error = $error."Es besteht keine Freundschaft.<br>";

}

}
}
if($aktion == "anfragen"){              
if($fid != $userid){
$existiert = getwert($fid,"charaktere","name","id"); 
if($existiert != ""){
$db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      an,
      von
FROM
    freunde
    WHERE
    an = "'.$fid.'" AND von = "'.$userid.'"
    OR
    von = "'.$fid.'" AND an = "'.$userid.'"
    Limit 1';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }                               
      $istschon = 0;
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
      $istschon = 1;
      }
      $result->close();  
$db->close();

if($istschon != 0){
$error = $error."Ihr seid schon Freunde oder eine Einladung wurde schon gesendet.<br>";
}
else{
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO freunde(
`an`,`von`,`accept`) 
VALUES
('$fid',
'$userid',
'0')";
if (!mysqli_query($con, $sql))
  {
  die('Error: ' . mysqli_error($con));
  } 
mysqli_close($con); 
  $error = $error."Freundeseinladung wurde gesendet.<br>";  
}
}
else{
$error = $error."Dieser User existiert nicht.<br>";
}
}
else{
$error = $error."Du kannst dich nicht selber zum Freund hinzufügen.<br>";
}
}
}
?>  
<?php
if(logged_in()){
include 'inc/design1.php';       
if($error != ""){  
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>'; 
}
 $db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) 
{
  die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
    SELECT
      id,
      an,
      von,
      accept
    FROM
      freunde
      WHERE
      an = "'.$userid.'" AND accept = "1"
      OR
      von = "'.$userid.'" AND accept = "1"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
              }       
              echo '<h3>Freunde</h3><br>';   
  echo '<table class="table2" width="100%" cellspacing="0">';  
  echo '<tr>';      
  echo '<td class="tdbg">';  
  echo 'Name';
  echo '</td>';   
  echo '<td class="tdbg">';  
  echo 'Level';
  echo '</td>'; 
  echo '<td class="tdbg">';  
  echo '</td>';     
  echo '<td class="tdbg">';  
  echo '</td>';
  echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false     
  if($userid != $row['an']){
  $freund = $row['an'];
  }
  if($userid != $row['von']){
  $freund = $row['von'];
  }
  echo '<tr>';
  echo '<td class="tdborder2">';                
  $fname = getwert($freund,"charaktere","name","id");    
  echo '<a href="user.php?id='.$freund.'">'.$fname.'</a>';  
  echo '</td>';    
  echo '<td class="tdborder2">';   
  $flevel = getwert($freund,"charaktere","level","id");    
  echo $flevel;
  echo '</td>'; 
  echo '<td class="tdborder2">';   
  $online = getwert($freund,"charaktere","session","id"); 
  if($online != NULL){
    echo '<font color="#00ff00"><b>Online</b></font>';
  }    
  else{       
    echo '<font color="#ff0000"><b>Offline</b></font>';
  }
  echo '</td>';    
  echo '<td class="tdborder2">';
  echo '<table><tr>';
  echo '<td><div class="light2">';
  echo '<a href="pms.php?page=schreiben&an='.$freund.'" border="0"><img src="bilder/design/mail.png" width="25px" height="25px" border="0"></img></a>';
  echo '</div></td>';           
  echo '<td><div class="light2">';
  echo '<a href="friends.php?aktion=delete&fid='.$freund.'"><img src="bilder/design/delete.png" width="25px" height="25px" border="0"></img></a>';      
  echo '</div></td>';  
  echo '</tr></table>';             
  echo '</td>';
  echo '</tr>';  
  }
$result->close();  
$db->close(); 
  echo '</table>';  
 $db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) 
{
  die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
    SELECT
      id,
      an,
      von,
      accept
    FROM
      freunde
      WHERE
      an = "'.$userid.'" AND accept = "0"
      OR
      von = "'.$userid.'" AND accept = "0"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
              }       
              echo '<br><h3>Anfragen</h3><br>';   
  echo '<table class="table2" width="100%" cellspacing="0">';  
  echo '<tr>';      
  echo '<td class="tdbg">';  
  echo 'Name';
  echo '</td>';   
  echo '<td class="tdbg">';  
  echo '</td>';     
  echo '<td class="tdbg">';  
  echo '</td>';
  echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false       
  if($userid != $row['an']){
  $freund = $row['an'];
  }
  if($userid != $row['von']){
  $freund = $row['von'];
  }
  echo '<tr>';
  echo '<td class="tdborder2">';          
  $fname = getwert($freund,"charaktere","name","id");    
  echo '<a href="user.php?id='.$freund.'">'.$fname.'</a>';  
  echo '</td>';   
  echo '<td class="tdborder2">';    
  $online = getwert($freund,"charaktere","session","id"); 
  if($online != NULL){
    echo '<font color="#00ff00"><b>Online</b></font>';
  }    
  else{       
    echo '<font color="#ff0000"><b>Offline</b></font>';
  }
  echo '</td>';  
  echo '<td class="tdborder2">';
  if($userid == $row['an']){
  echo '<a href="friends.php?aktion=annehmen&fid='.$freund.'">annehmen</a> / <a href="friends.php?aktion=ablehnen&fid='.$freund.'">ablehnen</a>';
  }    
  if($userid == $row['von']){
  echo '<a href="friends.php?aktion=back&fid='.$freund.'">zurücknehmen</a>';
  }        
  echo '</td>';
  echo '</tr>';  
  }
$result->close();  
$db->close(); 
  echo '</table><br>';  
   $db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) 
{
  die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
    SELECT
      id,
      user,
      ignoriert
    FROM
      ignoriert
      WHERE
      user = "'.$userid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
              }       
              echo '<h3>Ignoriert</h3><br>';   
  echo '<table class="table2" width="100%" cellspacing="0">';  
  echo '<tr>';      
  echo '<td class="tdbg">';  
  echo 'Name';
  echo '</td>';      
  echo '<td class="tdbg">';  
  echo '</td>';
  echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false     
  echo '<tr>';
  echo '<td class="tdborder2">';                
  $iname = getwert($row['ignoriert'],"charaktere","name","id");    
  echo '<a href="user.php?id='.$row['ignoriert'].'">'.$iname.'</a>';  
  echo '</td>';    
  echo '<td class="tdborder2">';
  echo '<table><tr>';         
  echo '<td><div class="light2">';
  echo '<a href="friends.php?aktion=idelete&fid='.$row['ignoriert'].'"><img src="bilder/design/delete.png" width="25px" height="25px" border="0"></img></a>';      
  echo '</div></td>';  
  echo '</tr></table>';             
  echo '</td>';
  echo '</tr>';  
  }
$result->close();  
$db->close(); 
  echo '</table>';  
}
//nicht eingeloggt , zeige Loginfenster
else{                                 
include 'inc/design3.php'; 
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';  
}
include 'inc/mainindex.php';   
}
include 'inc/design2.php';   ?>