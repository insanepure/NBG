<?php
include 'inc/incoben.php';
// Hier kommen Skripts hin die vorm Laden ausgeführt werden
if(logged_in()){

$admin = getwert(session_id(),"charaktere","admin","session");   
$uid = getwert(session_id(),"charaktere","id","session");
if($admin == 3){
$page = $_GET['page'];   
$aktion = $_GET['aktion'];   
if($aktion == 'turnieradd'){
$chara = $_POST['chara'];
$turnier = $_POST['turnier'];   
$hp = getwert($chara,"charaktere","hp","id");    
if($hp > 0){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
turnier,
two
FROM
charaktere
WHERE turnier ="'.$turnier.'"
ORDER BY
two ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$two = 1;
$tcount = 0;
$tspieler = 0;
$uwo = 0;
//1 , 1 , 2 , 3 , 3
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($uwo == 0){
$tspieler++;  
if($two != $row['two']&&$tspieler != 2){
$uwo = $two;
}
elseif($two == $row['two']&&$tspieler==2){   
$tspieler = 0;
$two = $two+1;
}
elseif($tspieler==2){
$uwo = $two;
}
}
}
$result->close(); $db->close();
if($uwo == 0){
$uwo = $two;
}                     
$teilnehmer = getwert($turnier,"turnier","teilnehmer","id");    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET turnier ='$turnier',two ='$uwo',trunde ='1' WHERE id = '".$chara."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
$teilnehmer = $teilnehmer+1;
$sql="UPDATE turnier SET teilnehmer ='$teilnehmer' WHERE id = '".$turnier."' LIMIT 1";
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
'$chara',  
'1',
'$uwo')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con); 
$error = 'Zum Turnier hinzugefügt.';
}
else{
$error = 'Der User hat 0 HP!';
} 

}
if($aktion == 'info'){
$text = $_POST['text'];   
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));     
$sql="UPDATE charaktere SET gameinfo ='$text'";  
mysqli_query($con, $sql);                                     
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);
$text = '<b>'.$zeit.'</b>;'.$uid.';hat eine Gameinfo geschrieben.';   
$error = 'Gameinfo wurde geschrieben.';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog == ""){
$adminlog = $text;
}
else{
$adminlog = $text.'@'.$adminlog;
}    
$sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
mysqli_query($con, $sql);   
mysqli_close($con); 
}
if($aktion == "edit"){  
$id = $_POST['id'];
$was = $_GET['was'];
if($was != ""){       
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
  $zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);
      $query = "select * from $was";
      $result=mysqli_query($con, $query);    
      $anzahlspalten = mysqli_num_fields($result);
      $i = 0;   
      while($i < $anzahlspalten) {    
      $properties = mysqli_fetch_field_direct($result, $i);
      $lol = is_object($properties) ? $properties->name : null;
      $datenwert[$i] = $lol;
      $daten[$i] = $_POST[$lol];
          $i++ ;
      }  
      if($id== ""){
      // neu erstellen
      $sql = "INSERT INTO `$was`(";     

      $query = "select * from $was";
      $result=mysqli_query($con, $query);   
      $anzahlspalten = mysqli_num_fields($result);   
      $i = 0;         
      while($i < $anzahlspalten) {    
      $properties = mysqli_fetch_field_direct($result, $i);
      $lol = is_object($properties) ? $properties->name : null;
      if($i == $anzahlspalten-1){   
      $sql = $sql."`$lol`)";
      }
      else{
      $sql = $sql."`$lol`,";
      }
          $i++ ;
      }       
$sql= $sql."VALUES
(";      
$sql = $sql."NULL,";

      $tempid = $daten[0];
      $count = 1;      
      $datenanzahl = $anzahlspalten;
      $last = $daten[$datenanzahl];
      while($count < $datenanzahl){   
      $tempdaten = $daten[$count];    
      $tempdaten2 = $datenwert[$count];     
      if($was == "missions"){
      if($tempdaten2 == "was"){
       
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.'@'.$tempdaten[$count2];
        }
        $daten2 = "";
        $daten2 = $_POST['was'.$count2];
        if($daten2 != ""){
        $t2 = $t2.';'.$daten2;
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      if($tempdaten2 == "aufgabe"||$tempdaten2 == "art"||$tempdaten2 == "wo"||$tempdaten2 == "art"||$tempdaten2 == "abeschr"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.'@'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }        
      if($was == "orte"){
      if($tempdaten2 == "reiseorte"||$tempdaten2 == "shops"||$tempdaten2 == "lehrer"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }
      if($was == "jutsus"){
      if($tempdaten2 == "dmg"||$tempdaten2 == "req"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }
      if($was == "item"){
      if($tempdaten2 == "werte"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }          
      if($was == "summon"){
      if($tempdaten2 == "jutsus"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
        }
      }      
      if($was == "npc"){
      if($tempdaten2 == "jutsus"||$tempdaten2 == "items"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
        }
      }       
      if($was == "npcs"){
      if($tempdaten2 == "jutsus"||$tempdaten2 == "powerup"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
        }
      }
      if($was == "charaktere"){
      if($tempdaten2 == "jutsus"||$tempdaten2 == "elemente"||$tempdaten2 == "kbutton"||$tempdaten2 == "powerup"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
        }
      }
if($count == $datenanzahl-1){      
$sql = $sql."'".$tempdaten."');";

}
else{
$sql = $sql."'".$tempdaten."',";
}
      $count++;
      }              
if (!mysqli_query($con, $sql))
  {
  die('Error: ' . mysqli_error($con));
  }
$text = '<b>'.$zeit.'</b>;'.$uid.';hat in <b>'.$was.'</b> eine neue ID erstellt.';   
$error = 'Du hast in '.$was.' eine neue ID erstellt.';
      }
      else{
      //editieren     
      $tempid = $daten[0];
      $count = 0;                      
      while($count < $anzahlspalten){  
      $tempdaten = $daten[$count];    
      $tempdaten2 = $datenwert[$count];    
      if($was == "missions"){
      if($tempdaten2 == "was"){
       
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.'@'.$tempdaten[$count2];
        }
        $daten2 = "";
        $daten2 = $_POST['was'.$count2];
        if($daten2 != ""){
        $t2 = $t2.';'.$daten2;
        }
        $count2++;
        }           
        $tempdaten = $t2;
      }
      if($tempdaten2 == "aufgabe"||$tempdaten2 == "art"||$tempdaten2 == "wo"||$tempdaten2 == "art"||$tempdaten2 == "abeschr"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.'@'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }       
      if($was == "orte"){
      if($tempdaten2 == "reiseorte"||$tempdaten2 == "shops"||$tempdaten2 == "lehrer"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }   
      if($was == "jutsus"){
      if($tempdaten2 == "dmg"||$tempdaten2 == "req"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }               
      if($was == "summon"){
      if($tempdaten2 == "jutsus"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
        }
      } 
      if($was == "item"){
      if($tempdaten2 == "werte"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }                    
      if($was == "npc"){
      if($tempdaten2 == "jutsus"||$tempdaten2 == "items"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
        }
      }
      if($was == "npcs"){
      if($tempdaten2 == "jutsus"||$tempdaten2 == "powerup"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
        }
      }
      if($was == "charaktere"){
      if($tempdaten2 == "jutsus"||$tempdaten2 == "elemente"||$tempdaten2 == "kbutton"||$tempdaten2 == "powerup"){
       $count2 = 0;
        $t2 = "";
        while($tempdaten[$count2] != ""){
        if($t2 == ""){
        $t2 = $tempdaten[$count2];
        }
        else{ 
        $t2 = $t2.';'.$tempdaten[$count2];
        }
        $count2++;
        }
        $tempdaten = $t2;
      }
      }
      
    $t3 = getwert($tempid,$was,$tempdaten2,"id");
        
    if($t3 != $tempdaten)
    {
       $sql="UPDATE $was SET $tempdaten2 ='$tempdaten' WHERE id='".$tempid."' LIMIT 1";
      mysqli_query($con, $sql); 
      $text = '<b>'.$zeit.'</b>;'.$uid.';hat in <b>'.$was.'</b> die ID <b>'.$id.'</b> den Wert <b>'.$tempdaten2.'</b> von <b>'.$t3.'</b> zu <b>'.$tempdaten.'</b> bearbeitet.'; 
      
      $adminlog = getwert(1,"game","adminlog","id");
      if($adminlog == ""){
      $adminlog = $text;
      }
      else{
      $adminlog = $text.'@'.$adminlog;
      }    
      $sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
      mysqli_query($con, $sql);  
      }
      $count++;
      }
$error = 'Du hast in '.$was.' die ID '.$id.' bearbeitet.';  
}       
mysqli_close($con); 

}
}


if($aktion == "delete"){
$id = $_POST['id'];
$was = $_GET['was'];
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($was == "charaktere"){
$sql="DELETE FROM freunde WHERE an = '".$id."' OR von = '".$id."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}             
$sql="DELETE FROM ignoriert WHERE user = '".$id."' OR ignoriert = '".$id."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$sql="DELETE FROM summon WHERE besitzer = '".$id."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM items WHERE besitzer = '".$id."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM markt WHERE besitzer = '".$id."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="DELETE FROM charaktere WHERE id = '".$id."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{   
$sql="DELETE FROM $was WHERE id = '".$id."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}

}
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);
$text = '<b>'.$zeit.'</b>;'.$uid.';hat in <b>'.$was.'</b> die ID <b>'.$id.'</b> gelöscht.';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog == ""){
$adminlog = $text;
}
else{
$adminlog = $text.'@'.$adminlog;
}    
$sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
mysqli_query($con, $sql);   
$error = 'Du hast in '.$was.' die ID '.$id.' gelöscht.';
mysqli_close($con); 
}
if($aktion == "kampf"){
$kampf = $_GET['kampf'];      
$ukid = getwert(session_id(),"charaktere","kampfid","session");
$uhp = getwert(session_id(),"charaktere","hp","session");
if($uhp != 0){
if($ukid == 0){
$array = explode(" ", trim($_POST['join']));
if($array[0] == "Team"&&$array[2] == "beitreten"){
$kteam = $array[1];
}
if($kampf != ""){
if($kteam != ""){     
$kmode = getwert($kampf,"fights","mode","id");  
$kart = getwert($kampf,"fights","art","id");  
$array = explode("vs", trim($kmode));
$count = 0;
$nmode = "";
while(isset($array[$count])){   
$c2 = $count+1;
if($c2 == $kteam){
$array[$count] = $array[$count]+1;
}
if($nmode == ""){
$nmode = $array[$count];
}
else{
$nmode = $nmode.'vs'.$array[$count];
}
$count++;
}          
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE fights SET mode ='$nmode' WHERE id = '".$kampf."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$sql="UPDATE charaktere SET kampfid ='$kampf' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="UPDATE charaktere SET team ='$kteam' WHERE id = '".$uid."' LIMIT 1";
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
charaktere';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['id'] == $uid){
$sql="UPDATE charaktere SET kchadd ='0',lkaktion ='$zeit',kziel ='',kaktion ='',kname ='".$row['name']."',kkbild ='".$row['kbild']."',powerup ='',dstats ='',debuff ='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
          
if($kart == "Spaß"){
$hp = $row['hp'];   
$chakra = $row['chakra'];
$sql="UPDATE charaktere SET shp ='$hp',schakra ='$chakra' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}

}
}
$result->close(); $db->close();    
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);  
$text = '<b>'.$zeit.'</b>;'.$uid.';ist dem Kampf <b>'.$kampf.'</b> beigetreten.';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog == ""){
$adminlog = $text;
}
else{
$adminlog = $text.'@'.$adminlog;
}    
$sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
mysqli_query($con, $sql);   
$error = 'Du bist dem Kampf '.$kampf.' beigetreten.';
mysqli_close($con); 

}
else{
$error = "Du hast kein Team ausgeWühlt.";
}

}
else{
$error = "Du hast keinen Kampf angegeben.";
}
}
else{
$error = "Du befindet dich schon im Kampf.";
}
}
else{
$error = "Du hast 0 HP und kannst daher den Kampf nicht beitreten.";
}
}
if($aktion == "rundmail"){      
$ann = $_POST['an'];            
$betreff = $_POST['betreff'];
if($betreff != ""){
$text = $_POST['pmtext'];
if($text != ""){
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
if($ann != ""&&$ann != "Alle"&&$ann != "alle"){    
$an = getwert($ann,"charaktere","id","name");   
if($an != ""){ 
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',
'$an',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{
$error = "Diesen User gibt es nicht.";
}  
}
else{       
$ann = "alle User";  
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id
FROM
    charaktere 
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {     
$an = $row['id'];
$sql="INSERT INTO pms(
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',
'$an',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}                 
$result->close(); $db->close();  
}
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);  
$text = '<b>'.$zeit.'</b>;'.$uid.';hat eine Rundmail an <b>'.$ann.'</b> gesendet.';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog == ""){
$adminlog = $text;
}
else{
$adminlog = $text.'@'.$adminlog;
}    
$sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
mysqli_query($con, $sql);   
mysqli_close($con); 
$error = "Rundmail wurde erfolgreich gesendet.";
}
else{
$error = "Du hast keinen Text angegeben.";
}
}
else{
$error = "Du hast keinen Betreff angegeben.";
}
}
if($aktion == "reise"){
$wo = $_REQUEST['wo'];
if($wo != ""){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET ort ='$wo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
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
      missions';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }
      $geht = 0;
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
      if($row['id'] == $umissi){
      $array = explode("@", trim($row['wo']));
      if($array[$uwo] == $wo){
      $array = explode("@", trim($row['was']));
      $was = $array[$uwo];
      $array = explode("@", trim($row['art']));
      $art = $array[$uwo];
      if($art == 3){
      $geht = 1;
      }
      }
      }
      }
      $result->close();    
      if($geht == 1){   
      mysqli_close($con);  
      mission($uid);   
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
      }
      
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);  
$oname = getwert($wo,"orte","name","id"); 
$text = '<b>'.$zeit.'</b>;'.$uid.';ist zum Ort <b>'.$oname.'</b> gereist.';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog == ""){
$adminlog = $text;
}
else{
$adminlog = $text.'@'.$adminlog;
}    
$sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
mysqli_query($con, $sql);   
$error = 'Du bist zum Ort '.$oname.' gereist.';
mysqli_close($con); 
}
else{
$error = "Dieser Ort existiert nicht.";
}
}
if($aktion == "aktion"){
$wer = $_REQUEST['wer'];
if($wer != ""){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET aktions ='0',kriegaktions='0' WHERE id = '".$wer."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);  
$wuser = getwert($wer,"charaktere","name","id"); 
$text = '<b>'.$zeit.'</b>;'.$uid.';hat die Aktion von <b>'.$wuser.'</b> beendet.';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog == ""){
$adminlog = $text;
}
else{
$adminlog = $text.'@'.$adminlog;
}    
$sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
mysqli_query($con, $sql);   
$error = 'Du hast die Aktion von '.$wuser.' beendet.';
mysqli_close($con); 
}
else{
$error = "Du hast keinen User angegeben.";
}
}
if($aktion == "login"){
$wer = $_REQUEST['wer'];
if($wer != ""){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET adminin ='1' WHERE id = '".$wer."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                                       
$sql="UPDATE charaktere SET adminin ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="UPDATE charaktere SET session =NULL WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="UPDATE charaktere SET session ='".session_id()."' WHERE id = '".$wer."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);  
$wuser = getwert($wer,"charaktere","name","id"); 
$text = '<b>'.$zeit.'</b>;'.$uid.';hat sich bei <b>'.$wuser.'</b> eingeloggt.';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog == ""){
$adminlog = $text;
}
else{
$adminlog = $text.'@'.$adminlog;
}    
$sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
mysqli_query($con, $sql);   
$error = 'Du hast dich bei User '.$wuser.' eingeloggt.';
mysqli_close($con); 
}
else{
$error = "Du hast keinen User angegeben.";
}
}         
if($aktion == "email"){
$an = $_POST['an'];
if($an != ""){
$betreff = $_POST['betreff'];
if($betreff != ""){
$text = $_POST['pmtext'];
if($text != '')
{
if(SendMail($an,$betreff, $text))
{
  $error = "E-mail wurde versendet.";
}

$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);  
$text = '<b>'.$zeit.'</b>;'.$uid.';hat eine E-mail gesendet.';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog == ""){
$adminlog = $text;
}
else{
$adminlog = $text.'@'.$adminlog;
}    
$sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
mysqli_query($con, $sql);   
mysqli_close($con); 
}
else{
$error = "Du hast keinen Text angegeben.";
}
}
else{
$error = "Du hast keinen Betreff angegeben.";
}
}
else{
$error = "Du hast keinen Addressaten angegeben.";
}
}
}
}
?>
<?php //lädt jetzt erst das Design
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}

$admin = getwert(session_id(),"charaktere","admin","session");   
if($admin == 3){
echo '<h3>Admin Menü</h3><br>'; 
$page = $_GET['page'];      
if($page == ""){
echo '<table class="table2" width="100%" height="100%">';           
echo '<tr height="30px">';
echo '<td>';            
echo '<a href="admin.php?page=email">E-mail versenden</a>'; 
echo '</td>';
echo '<td>';                                                 
echo '<a href="admin.php?page=rundmail">Rundmail senden</a>';        
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';
echo '<a href="admin.php?page=login">In User einloggen</a>';  
echo '</td>';
echo '<td>';                                                 
echo '<a href="admin.php?page=kampf">Kampf beitreten</a>';      
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=aktion">Aktion vom User beenden</a>';  
echo '</td>';
echo '<td>';
echo '<a href="admin.php?page=reise">Zum Ort reisen</a>';  
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=news">News bearbeiten</a>';  
echo '</td>';
echo '<td>';   
echo '<a href="admin.php?page=edit&was=charaktere">Charaktere bearbeiten</a>'; 
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=fights">Kämpfe bearbeiten</a>';  
echo '</td>';
echo '<td>';   
echo '<a href="admin.php?page=edit&was=freunde">Freunde bearbeiten</a>'; 
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=game">Gamedaten bearbeiten</a>';  
echo '</td>';
echo '<td>';   
echo '<a href="admin.php?page=edit&was=item">Itemdaten bearbeiten</a>'; 
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=items">Useritems bearbeiten</a>';  
echo '</td>';
echo '<td>';   
echo '<a href="admin.php?page=edit&was=jutsus">Jutsus bearbeiten</a>'; 
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=kommentare">Kommentare bearbeiten</a>';  
echo '</td>';
echo '<td>';   
echo '<a href="admin.php?page=edit&was=meldungen">Meldungen bearbeiten</a>'; 
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=missions">Missionen bearbeiten</a>';  
echo '</td>';
echo '<td>';        
echo '<a href="admin.php?page=edit&was=npcs">Kampf-NPC bearbeiten</a>';  
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=npc">NPCs bearbeiten</a>';  
echo '</td>';
echo '<td>';        
echo '<a href="admin.php?page=edit&was=orte">Orte bearbeiten</a>';  
echo '</td>';
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=pms">Private Nachrichten bearbeiten</a>';  
echo '</td>';     
echo '<td>';  
echo '<a href="admin.php?page=edit&was=summon">Beschwörungen bearbeiten</a>';  
echo '</td>';
echo '</tr>'; 
echo '</tr>';
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=markt">Markt bearbeiten</a>';  
echo '</td>';     
echo '<td>';  
echo '<a href="admin.php?page=edit&was=org">Org/Teams bearbeiten</a>';  
echo '</td>';
echo '</tr>'; 
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=turnier">Turniere bearbeiten</a><br>';    
echo '<a href="admin.php?page=edit&was=turnierstats">Turnierstats bearbeiten</a>';  
echo '</td>';    
echo '<td>';  
echo '<a href="admin.php?page=missions&update=0">Missionen ansehen</a><br>';    
echo '</td>';       
echo '</tr>';   
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=krieg">Krieg bearbeiten</a>';  
echo '</td>';          
echo '<td>';  
echo '<a href="admin.php?page=gameinfo">Gameinfo schreiben</a>';  
echo '</td>';     
echo '</tr>';  
echo '<tr height="30px">';
echo '<td>';  
echo '<a href="admin.php?page=edit&was=events">Events bearbeiten</a>';  
echo '</td>';       
echo '<td>';  
echo '<a href="admin.php?page=edit&was=ignoriert">Ignorierte bearbeiten</a>';  
echo '</td>';  
echo '</tr>';
echo '<tr>';  
echo '<td>';  
echo '<a href="admin.php?page=edit&was=kriegkampf">KriegKämpfe bearbeiten</a>';  
echo '</td>';  
echo '<td>';  
echo '<a href="admin.php?page=turnieradd">Turnierteilnehmer hinzufügen</a>';  
echo '</td>';  
echo '</tr>';
echo '</table>';    
echo '<br>';
echo '<br>';
$adminlog = getwert(1,"game","adminlog","id");
if($adminlog != ""){  
$seite = $_GET['seite'];
if($seite == ""){
$seite = 1;
}                          
$platz = 0;
$ps = 20;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
echo '<table class="table2" width="100%" cellspacing="0">';
$array = explode("@", trim($adminlog));
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
if($array2[3] != ""){
echo ';'.$array2[3];
} 
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
echo '<a href="admin.php?&seite='.$count.'">'.$count.'</a> ';
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
if($page == 'turnieradd'){
echo '<center><form method="post" action="admin.php?aktion=turnieradd">';
echo '<table>';
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
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<tr><td>User</td><td><div class="auswahl">';
echo '<select name="chara" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $_GET['uid']){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select></div></td></tr>';
echo '<tr>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    turnier
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<tr><td>Turnier</td><td><div class="auswahl">';
echo '<select name="turnier" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
echo '">';          
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select></div></td></tr>';       
echo '</table><input class="button" name="login" id="login" value="adden" type="submit"></form></center>';
}
if($page == "gameinfo"){        
echo '<center><form method="post" action="admin.php?aktion=info">';
echo '<div class="textfield2"><textarea class="textfield" name="text" maxlength="300000">';
echo '</textarea></div>';   
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form></center>';
}
if($page == "missions"){
$update = $_GET['update'];
 
$db = @new mysqli($host, $user, $pw, $datenbank);
      if (mysqli_connect_errno()) {
      die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = 'SELECT
      id,
      name,
      art,
      rank,
      was,
      wo,
      exp,
      ryo,
      mrank,
      dwert
FROM
    missions
    WHERE rank != "clan" AND rank !="story" AND rank != "" AND rank != "event"
    ORDER BY
    id';
      $result = $db->query($sql);
      if (!$result) {
      die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }               
      echo '<table>';
      $anzahl = 0;
      if($update == 1){
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));           
} 
      while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
      if($anzahl < 0){
      $anzahl++;
      }
      else{
      $art = explode("@", trim($row['art']));   
      $wo = explode("@", trim($row['wo']));   
      $was = explode("@", trim($row['was']));
      $count = 0;
      $ndauer = 0;      
      $realdauer = 0;               
      $realdauer2 = 0;    
      if($row['rank'] == "event"){
      $inc = 2.5;   
      $durch = 1;
      $gdurch = 10;
      }          
      if($row['rank'] == "d" || $row['mrank'] == "d"){
      $inc = 2;   
      $durch = 10;  
      $gdurch = 10;
      }         
      if($row['rank'] == "c" || $row['mrank'] == "c"){
      $inc = 4;  
      $durch = 8;  
      $gdurch = 20;
      }         
      if($row['rank'] == "b" || $row['mrank'] == "b"){
      $inc = 6;  
      $durch = 6;
      $gdurch = 30;
      }         
      if($row['rank'] == "a" || $row['mrank'] == "a"){
      $inc = 8; 
      $durch = 4;  
      $gdurch = 40;
      }         
      if($row['rank'] == "s" || $row['mrank'] == "s"){
      $inc = 10;  
      $durch = 3;   
      $gdurch = 80;
      }                  
      $mal = 2;         
      $feindstats = 0;     
      echo '<tr>';                        
      echo '<td width="100px">';
      while($art[$count] != ""){   
      if($art[$count] == 3||$art[$count] == 4||$art[$count] == 2){    
      $dauer = 0;    
      $rdauer = 0;   
      $do = 0;             
      if($art[$count] == 2){
      $gegnerdata = explode("vs", trim($was[$count]));
      $gegnerdata = $gegnerdata[1];   
      $gegner = explode(";", trim($gegnerdata));                
      $count2 = 0;
      $gkraft = 0;
      while($gegner[$count2] != ""){
      $kraft = getwert($gegner[$count2],"npc","kr","id");
      $gkraft = $gkraft+$kraft;
      $count2++;
      }   
      $dauer = ceil($gkraft/$count2/$gdurch);
      $feindstats = $feindstats+$dauer;
      }
      if($art[$count] == 4){   
      $dauer = explode(";", trim($was[$count]));
      $dauer = $dauer[1];                       
      }
      if($art[$count] == 3){
      $count2 = $count-1;   
      $ort = $wo[$count2];
      $ort2 = $was[$count];
      $sort = "$ort;$ort2";  
      $rdauer = getwert($sort,"orte","rdauer","name");
      if($rdauer == 0){   
      $sort = "$ort2;$ort";     
      $rdauer = getwert($sort,"orte","rdauer","name");
      }                         
      $realdauer2 = $realdauer2+$rdauer;              
      if($rdauer != ""){
      $rdauer = $rdauer*$durch*$mal;
      }    
      }      
      $realdauer = $realdauer+$ndauer; 
      $do = $ndauer+$dauer+(($rdauer/$durch)*15);   
      $ndauer = $ndauer+$dauer+$rdauer;    
      }
      $count++;
      }                                         
      $realdauer2 = $realdauer2*$durch*$mal;              
      $inc2 = $inc-$row['dwert'];
      $inc = $inc+$row['dwert'];
      $ndauer2 = ($ndauer/15);   
      $ndauer3 = floor($ndauer2*$inc);   
      $ndauer4 = floor($ndauer2*$inc2);     
      $ryo = $ndauer4*100;
      echo '<td width="100px">';
      echo '('.$row['id'].')';
      echo '</td>';              
      echo '<td width="100px">';
      echo $row['name'];
      echo '</td>';             
      echo '<td width="100px">';
      echo 'Rank: '.$row['rank'];
      echo '</td>';                     
      echo '<td width="100px">';
      echo 'Dauer: '.$ndauer.' ('.$do.')';
      echo '</td>';                    
      echo '<td width="100px">';
      echo '('.$realdauer.')';        
      echo '('.$realdauer2.')';
      echo '</td>';                    
      echo '<td width="100px">';
      echo 'EXP: '.$ndauer3;
      echo '</td>';                    
      echo '<td width="100px">';
      echo '('.$row['exp'].')';
      echo '</td>';                  
      echo '<td width="100px">';
      echo 'Ryo: '.$ryo;
      echo '</td>';                   
      echo '<td width="100px">';
      echo '('.$row['ryo'].')';
      echo '</td>';            
      echo '<td width="100px">';
      echo '('.$feindstats.')';
      echo '</td>';                   
      echo '<td width="200px">';
      echo 'Wo: '.$wo[0];
      echo '</td>';        
      if($update == 1){
     $sql="UPDATE missions SET ryo ='$ryo' WHERE id = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                    
      $sql="UPDATE missions SET exp ='$ndauer3' WHERE id = '".$row['id']."'";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                  
      }
      echo '</tr>';
      }
      }
      $result->close();   
$db->close();    
      if($update == 1){         
mysqli_close($con); 
}
echo '</table>';
}
if($page == "edit"){
$was = $_GET['was'];  
$id = $_REQUEST['id'];
if($id == ""){   
if($was == "krieg"){
$wert = 'dorf';
}           
if($was == "meldungen"){
$wert = 'user';
}  
if($was == "kommentare"){
$wert = 'news';
}  
if($was == "game"){
$wert = 'tag';
}  
if($was == "freunde"){
$wert = 'an';
}    
if($was == "ignoriert"){
$wert = 'user';
}  
if($was == "pms"){
$wert = 'betreff';
}
if($was == "news"){
$wert = 'title';
}  
if($was == "turnierstats"){
$wert = 'spieler';
}    
if($was == "kriegkampf"){
$wert = 'id';
}

if($was == 'events'||$was == "markt"||$was == "turnier"||$was == "org"||$was == "orte"||$was == "charaktere"||$was == "fights"||$was == "item"||$was == "items"||$was == "jutsus"||$was == "missions"||$was == "summon"||$was == "npc"||$was == "npcs"){
$wert = 'name';
}
echo '<form method="post" action="admin.php?page=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    '.$wert.'
FROM
    '.$was.'
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="id" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];
echo '">';        
if($was == "freunde"){   
$name = getwert($row['an'],"charaktere","name","id");   
$von = getwert($row['id'],"freunde","von","id"); 
$name2 = getwert($von,"charaktere","name","id"); 
echo $name.' '.$name2.' ('.$row['id'].')'; 
} 
else{    
echo $row[$wert].' ('.$row['id'].')'; 
}
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="editieren" type="submit"></form>';
echo '</td>';
echo '</tr>';
echo '</tr>';
echo '<tr align=center>';  
echo '<form method="post" action="admin.php?page=edit&was='.$was.'&id=neu">';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="erstellen" type="submit"></form>';
echo '</td>';
echo '</tr>';
echo '</table><br>';   
}
else{
if($id == "neu"){
$id = "";
}   
if($was == 'kriegkampf'){   
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>'; 
echo '<td>Art</td>';
echo '<td>';
if($id != ""){
$art = getwert($id,"kriegkampf","art","id"); 
}
else{
$art = "Normal";
}
echo'<div class="auswahl">';
echo '<select name="art" class="Auswahl" size="1">'; 
echo '<option value="Normal"';
if($art == "Normal"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Normal'; 
echo '</option>'; 
echo '<option value="Spaß"';
if($art == "Spaß"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Spaß'; 
echo '</option>';  
echo '<option value="Mission"';
if($art == "Mission"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Mission'; 
echo '</option>';   
echo '<option value="Eroberung"';
if($art == "Eroberung"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Eroberung'; 
echo '</option>'; 
echo '<option value="Bijuu"';
if($art == "Bijuu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Bijuu'; 
echo '</option>';   
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';   
echo '<td>kwo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kwo = getwert($id,"kriegkampf","kwo","id"); 
}
else{
$kwo = "0";
}
echo '<input class="eingabe2" name="kwo" value="'.$kwo.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Dorf</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name,
    was
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="dorf" class="Auswahl" size="1">';     
if($id != ""){
$dorf = getwert($id,"kriegkampf","dorf","id"); 
}
else{
$dorf = 'kein'; 
}
while ($row = $result->fetch_assoc() ) {    
if($row['was'] == "dorf"&&$row['name'] != "versteck"){ 
echo'<option value="';
echo $row['id'];
if($row['id'] == $dorf){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}
}                 
$result->close(); $db->close();  
echo'<option value="';
echo 'kein';
if($dorf == 'kein'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Nuke'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';  

}
if($was == 'events'){   
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';           
echo '<td>Name</td>';
echo '<td>';              
if($id != ""){
$name = getwert($id,"events","name","id"); 
}
else{  
$name = "";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';           
echo '<td>Start</td>';
echo '<td>';  
if($id != ""){
$start = getwert($id,"events","start","id"); 
}
else{  
$start = "01.01";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="start" value="'.$start.'" size="15" maxlength="10" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';                
echo '<td>End</td>';
echo '<td>'; 
if($id != ""){
$end = getwert($id,"events","end","id"); 
}
else{  
$end = "01.02";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="end" value="'.$end.'" size="15" maxlength="10" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';              
echo '<td>Map</td>';
echo '<td>';       
if($id != ""){
$map = getwert($id,"events","map","id"); 
}
else{  
$map = "1";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="map" value="'.$map.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';  

}
if($was == 'turnierstats'){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';      
echo '<tr align=center>'; 
echo '<td>Turnier</td>';
echo '<td>';  
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    turnier
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="turnier" class="Auswahl" size="1">';     
if($id != ""){
$turnier = getwert($id,"turnierstats","turnier","id"); 
}
else{
$turnier = "0"; 
}               
echo '<option value="">';
echo 'Kein Turnier'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $turnier){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Spieler</td>';
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
echo '<select name="spieler" class="Auswahl" size="1">';     
if($id != ""){
$spieler = getwert($id,"turnierstats","spieler","id"); 
}
else{
$spieler = ""; 
}               
echo '<option value="">';
echo 'Keiner'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $spieler){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Runde</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$runde = getwert($id,"turnierstats","runde","id"); 
}
else{  
$runde = "0";
}
echo '<input class="eingabe2" name="runde" value="'.$runde.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Block</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$block = getwert($id,"turnierstats","block","id"); 
}
else{  
$block = "0";
}
echo '<input class="eingabe2" name="block" value="'.$block.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Was</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$was = getwert($id,"turnierstats","was","id"); 
}
else{  
$was = "0";
}
echo '<input class="eingabe2" name="was" value="'.$was.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';  
}  
if($was == 'markt'){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"markt","name","id"); 
}
else{  
$name = "";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Level</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$level = getwert($id,"markt","level","id"); 
}
else{  
$level = "0";
}
echo '<input class="eingabe2" name="level" value="'.$level.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Preis</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$preis = getwert($id,"markt","preis","id"); 
}
else{  
$preis = "0";
}
echo '<input class="eingabe2" name="preis" value="'.$preis.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Anzahl</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$anzahl = getwert($id,"markt","anzahl","id"); 
}
else{  
$anzahl = "0";
}
echo '<input class="eingabe2" name="anzahl" value="'.$anzahl.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>'; 
echo '<td>Besitzer</td>';
echo '<td>';    
if($bwo == ""){
$bwo = "charaktere";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    '.$bwo.'
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="besitzer" class="Auswahl" size="1">';     
if($id != ""){
$besitzer = getwert($id,"markt","besitzer","id"); 
}
else{
$besitzer = ""; 
}               
echo '<option value="">';
echo 'Keiner'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $besitzer){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>PW</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$passw = getwert($id,"markt","pw","id"); 
}
else{  
$passw = "";
}
echo '<input class="eingabe2" name="pw" value="'.$passw.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';  
}
if($was == "org"){   
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"org","name","id"); 
}
else{  
$name = "";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Bild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$bild = getwert($id,"org","bild","id"); 
}
else{  
$bild = "";
}
echo '<input class="eingabe4" name="bild" value="'.$bild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Theme</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$theme = getwert($id,"org","theme","id"); 
}
else{
$theme = "";
}
echo '<input class="eingabe2" name="theme" value="'.$theme.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>rank</td>';
echo '<td>';
if($id != ""){
$rank = getwert($id,"org","rank","id"); 
}
else{
$rank = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="rank" maxlength="300000">';
echo $rank;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Text</td>';
echo '<td>';
if($id != ""){
$text = getwert($id,"org","text","id"); 
}
else{
$text = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="text" maxlength="300000">';
echo $text;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Punkte</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$punkte = getwert($id,"org","punkte","id"); 
}
else{
$punkte = "0";
}
echo '<input class="eingabe2" name="punkte" value="'.$punkte.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';     
echo '<td>Teamkampf</td>';
echo '<td>';
if($id != ""){
$teamkampf = getwert($id,"org","teamkampf","id"); 
}
else{
$teamkampf = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="teamkampf" maxlength="300000">';
echo $teamkampf;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';   
}                   
/*if($was == "kommentare"){   
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';  

}  */                  
if($was == "pms"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';   
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>'; 
echo '<td>An</td>';
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
echo '<select name="an" class="Auswahl" size="1">';     
if($id != ""){
$an = getwert($id,"pms","an","id"); 
}
else{
$an = ""; 
}               
echo '<option value="System">';
echo 'System'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $an){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';       
echo '<tr align=center>'; 
echo '<td>Von</td>';
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
echo '<select name="von" class="Auswahl" size="1">';     
if($id != ""){
$von = getwert($id,"pms","von","id"); 
}
else{
$von = ""; 
}               
echo '<option value="System">';
echo 'System'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $von){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>text</td>';
echo '<td>';
if($id != ""){
$text = getwert($id,"pms","text","id"); 
}
else{
$text = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="text" maxlength="300000">';
echo $text;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Datum</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$date = getwert($id,"pms","date","id"); 
}
else{
$date = time(); 
$date = date("Y-m-d H:i:s",$date);
}
echo '<input class="eingabe2" name="date" value="'.$date.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Gelesen</td>';
echo '<td>';        
echo'<div class="auswahl">';
echo '<select name="gelesen" class="Auswahl" size="1">';     
if($id != ""){
$gelesen = getwert($id,"pms","gelesen","id"); 
}
else{
$gelesen = "1"; 
}              
echo'<option value="';
echo '1';
if($gelesen == "1"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Gelesen'; 
echo '</option>'; 
echo'<option value="';
echo '0';
if($gelesen == "0"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Ungelesen'; 
echo '</option>';    
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';      
echo '<td>Betreff</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$betreff = getwert($id,"pms","betreff","id"); 
}
else{
$betreff = "";
}
echo '<input class="eingabe2" name="betreff" value="'.$betreff.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Delete1 (An)</td>';
echo '<td>';
echo '<div class="eingabe5">'; 
if($id != ""){
$delete1 = getwert($id,"pms","delete1","id"); 
}
else{  
$delete1 = "0";
}
echo '<input class="eingabe6" name="delete1" value="'.$delete1.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';     
echo '<td>Delete2 (Von)</td>';
echo '<td>';
echo '<div class="eingabe5">'; 
if($id != ""){
$delete2 = getwert($id,"pms","delete2","id"); 
}
else{  
$delete2 = "0";
}
echo '<input class="eingabe6" name="delete2" value="'.$delete2.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';
}
if($was == "orte"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';   
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';         
echo '<tr align=center>';      
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"orte","name","id"); 
}
else{
$name = "Name";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';      
echo '<td>Top</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$top = getwert($id,"orte","t","id"); 
}
else{
$top = "0";
}
echo '<input class="eingabe2" name="t" value="'.$top.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';      
echo '<td>Left</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$left = getwert($id,"orte","l","id"); 
}
else{
$left = "0";
}
echo '<input class="eingabe2" name="l" value="'.$left.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>'; 
echo '<td>Ortart</td>';
echo '<td>';           
if($id != ""){
$was = getwert($id,"orte","was","id"); 
}
else{
$was = "dorf";
}
echo'<div class="auswahl">';
echo '<select name="was" class="Auswahl" size="1">';   
echo '<option value="dorf';
if($was == "dorf"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Dorf'; 
echo '</option>'; 
echo '<option value="ort';
if($was == "ort"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Ort'; 
echo '</option>'; 
echo '<option value="reise';
if($was == "reise"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Reise'; 
echo '</option>';  
echo '<option value="versteckt';
if($was == "versteckt"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Versteckt'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align="center">';
echo '<td>Reiseorte</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$reiseorte = getwert($id,"orte","reiseorte","id"); 
}
else{
$reiseorte = "";
}                                           
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    orte
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($tint == 5){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($reiseorte));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}
echo $row['name'];
echo '<br>';
echo '<input type="checkbox" name="reiseorte[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';      
echo '<td>Bild</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$bild = getwert($id,"orte","bild","id"); 
}
else{
$bild = "Bild";
}
echo '<input class="eingabe2" name="bild" value="'.$bild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Beschreibung</td>';
echo '<td>';
if($id != ""){
$beschreibung = getwert($id,"orte","beschreibung","id"); 
}
else{
$beschreibung = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="beschreibung" maxlength="300000">';
echo $beschreibung;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align="center">';
echo '<td>Shops</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$shops = getwert($id,"orte","shops","id"); 
}
else{
$shops = "";
}                 
$shops2 = "heil;waffe;puppe;kleidung;kh";   
$array2 = explode(";", trim($shops2));
$count2 = 0;
while($array2[$count2] != ""){
if($tint == 5){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($shops));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $array2[$count2]){
$hat = 1;
}
$count++;
}
echo $array2[$count2];
echo '<br>';
echo '<input type="checkbox" name="shops[]" value="'.$array2[$count2].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
$count2++;
}
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';  

echo '<tr align="center">';
echo '<td>Lehrer</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$lehrer = getwert($id,"orte","lehrer","id"); 
}
else{
$lehrer = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    kbild,
    name
FROM
    npc
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($tint == 5){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($lehrer));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}
                
echo '<a class="sinfo">';  
echo '<span class="spanmap">'.$row['name'].'</span>';         
echo '<img src="'.$row['kbild'].'" width="50px" height="50px"></img>';
echo '</a>';
echo '<br>';
echo '<input type="checkbox" name="lehrer[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Art</td>';
echo '<td>';           
if($id != ""){
$art = getwert($id,"orte","art","id"); 
}
else{
$art = "Wald";
}
echo'<div class="auswahl">';
echo '<select name="art" class="Auswahl" size="1">';   
echo '<option value="Wald';
if($art == "Wald"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Wald'; 
echo '</option>'; 
echo '<option value="Berge';
if($art == "Berge"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Berge'; 
echo '</option>';  
echo '<option value="Wüste';
if($art == "Wüste"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Wüste'; 
echo '</option>'; 
echo '<option value="Meer';
if($art == "Meer"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Meer'; 
echo '</option>';  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Wetter</td>';
echo '<td>';           
if($id != ""){
$wetter = getwert($id,"orte","wetter","id"); 
}
else{
$wetter = "Sonne";
}
echo'<div class="auswahl">';
echo '<select name="wetter" class="Auswahl" size="1">';   
echo '<option value="Sonne';
if($wetter == "Sonne"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Sonne'; 
echo '</option>'; 
echo '<option value="Regen';
if($wetter == "Regen"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Regen'; 
echo '</option>'; 
echo '<option value="Gewitter';
if($wetter == "Gewitter"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Gewitter'; 
echo '</option>'; 
echo '<option value="Sturm';
if($wetter == "Sturm"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Sturm'; 
echo '</option>'; 
echo '<option value="Hitze';
if($wetter == "Hitze"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Hitze'; 
echo '</option>';   
echo '<option value="Erdrutsch';
if($wetter == "Erdrutsch"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Erdrutsch';                                                              
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';      
echo '<td>Reisedauer</td>';
echo '<td>';
echo '<div class="eingabe5">'; 
if($id != ""){
$rdauer = getwert($id,"orte","rdauer","id"); 
}
else{
$rdauer = "1";
}
echo '<input class="eingabe6" name="rdauer" value="'.$rdauer.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';  
echo '</tr>';     
echo '<tr align=center>';      
echo '<td>Chuunin</td>';
echo '<td>';
echo '<div class="eingabe5">'; 
if($id != ""){
$chuunin = getwert($id,"orte","chuunin","id"); 
}
else{
$chuunin = "0";
}
echo '<input class="eingabe6" name="chuunin" value="'.$chuunin.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';  
echo '</tr>';       
echo '<tr align=center>';      
echo '<td>Genin</td>';
echo '<td>';
echo '<div class="eingabe5">'; 
if($id != ""){
$genin = getwert($id,"orte","genin","id"); 
}
else{
$genin = "0";
}
echo '<input class="eingabe6" name="genin" value="'.$genin.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';  
echo '</tr>';     
echo '<tr align=center>';      
echo '<td>Chuunin Turnier</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chuunintid = getwert($id,"orte","chuunintid","id"); 
}
else{
$chuunintid = "0";
}
echo '<input class="eingabe2" name="chuunintid" value="'.$chuunintid.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';      
echo '<td>Kage Turnier</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kagetid = getwert($id,"orte","kagetid","id"); 
}
else{
$kagetid = "0";
}
echo '<input class="eingabe2" name="kagetid" value="'.$kagetid.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';      
echo '<td>Nuke</td>';
echo '<td>';
echo '<div class="eingabe5">'; 
if($id != ""){
$nuke = getwert($id,"orte","nuke","id"); 
}
else{
$nuke = "0";
}
echo '<input class="eingabe6" name="nuke" value="'.$nuke.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Nukeinvites</td>';
echo '<td>';
if($id != ""){
$nukeinvite = getwert($id,"orte","nukeinvite","id"); 
}
else{
$nukeinvite = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="nukeinvite" maxlength="300000">';
echo $nukeinvite;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';              
echo '<td>Map</td>';
echo '<td>';       
if($id != ""){
$map = getwert($id,"orte","map","id"); 
}
else{  
$map = "1";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="map" value="'.$map.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';       
echo '<tr align=center>';     
echo '<td>Ally</td>';
echo '<td>';
if($id != ""){
$ally = getwert($id,"orte","ally","id"); 
}
else{
$ally = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="ally" maxlength="300000">';
echo $ally;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';
}
if($was =="summon"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';   
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';         
echo '<tr align=center>';      
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"summon","name","id"); 
}
else{
$name = "Name";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Besitzer</td>';
echo '<td>';    
if($bwo == ""){
$bwo = "charaktere";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    '.$bwo.'
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="besitzer" class="Auswahl" size="1">';     
if($id != ""){
$besitzer = getwert($id,"summon","besitzer","id"); 
}
else{
$besitzer = ""; 
}               
echo '<option value="">';
echo 'Keiner'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $besitzer){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>HP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$hp = getwert($id,"summon","hp","id"); 
}
else{
$hp = 100;
}
echo '<input class="eingabe2" name="hp" value="'.$hp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>MHP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mhp = getwert($id,"summon","mhp","id"); 
}
else{
$mhp = 100;
}
echo '<input class="eingabe2" name="mhp" value="'.$mhp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Chakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chakra = getwert($id,"summon","chakra","id"); 
}
else{
$chakra = 100;
}
echo '<input class="eingabe2" name="chakra" value="'.$chakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>MChakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mchakra = getwert($id,"summon","mchakra","id"); 
}
else{
$mchakra = 100;
}
echo '<input class="eingabe2" name="mchakra" value="'.$mchakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';      
echo '<td>Kraft</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kr = getwert($id,"summon","kr","id"); 
}
else{
$kr = "10";
}
echo '<input class="eingabe2" name="kr" value="'.$kr.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td>Intelligenz</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$intl = getwert($id,"summon","intl","id"); 
}
else{
$intl = "10";
}
echo '<input class="eingabe2" name="intl" value="'.$intl.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Chakrakontrolle</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chrk = getwert($id,"summon","chrk","id"); 
}
else{
$chrk = "10";
}
echo '<input class="eingabe2" name="chrk" value="'.$chrk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Tempo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$tmp = getwert($id,"summon","tmp","id"); 
}
else{
$tmp = "10";
}
echo '<input class="eingabe2" name="tmp" value="'.$tmp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Genauigkeit</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$gnk = getwert($id,"summon","gnk","id"); 
}
else{
$gnk = "10";
}
echo '<input class="eingabe2" name="gnk" value="'.$gnk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Widerstand</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$wid = getwert($id,"summon","wid","id"); 
}
else{
$wid = "10";
}
echo '<input class="eingabe2" name="wid" value="'.$wid.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align="center">';
echo '<td>Jutsus</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$jutsus = getwert($id,"summon","jutsus","id"); 
}
else{
$jutsus = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    bild,
    name
FROM
    jutsus
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($tint == 6){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($jutsus));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}                        
echo '<a class="sinfo">';  
echo '<span class="spanmap">'.$row['name'].'</span>';   
if($hat == 1){          
echo '<img src="bilder/jutsus/'.$row['bild'].'h.png" width="60px" height="60px"></img>';
}
if($hat == 0){
echo '<img src="bilder/jutsus/'.$row['bild'].'.png" width="50px" height="50px"></img>';
}         
echo '</a>';
echo '<br>';
echo '<input type="checkbox" name="jutsus[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';        
echo '<td>Kampfbild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$kbild = getwert($id,"summon","kbild","id"); 
}
else{
$kbild = "KampfBild";
}
echo '<input class="eingabe4" name="kbild" value="'.$kbild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>Bild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$bild = getwert($id,"summon","bild","id"); 
}
else{
$bild = "Bild";
}
echo '<input class="eingabe4" name="bild" value="'.$bild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Geschlecht</td>';
echo '<td>';
if($id != ""){
$geschlecht = getwert($id,"summon","geschlecht","id"); 
}
else{
$geschlecht = "männlich";
}
echo'<div class="auswahl">';
echo '<select name="geschlecht" class="Auswahl" size="1">'; 
echo '<option value="männlich"';
if($geschlecht == "männlich"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'männlich'; 
echo '</option>'; 
echo '<option value="weiblich"';
if($geschlecht == "weiblich"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Weiblich'; 
echo '</option>';                     
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';       
echo '<td>Reihenfolge</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$reihenfolge = getwert($id,"summon","reihenfolge","id"); 
}
else{
$reihenfolge = "0";
}
echo '<input class="eingabe2" name="reihenfolge" value="'.$reihenfolge.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';      
echo '<tr align=center>';       
echo '<td>Aktion</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$aktion = getwert($id,"summon","aktion","id"); 
}
else{
$aktion = "";
}
echo '<input class="eingabe4" name="aktion" value="'.$aktion.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Aktionstart</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$aktions = getwert($id,"summon","aktions","id"); 
}
else{
$aktions = time(); 
$aktions = date("Y-m-d H:i:s",$aktions);
}
echo '<input class="eingabe2" name="aktions" value="'.$aktions.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Aktiondauer</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$aktiond = getwert($id,"summon","aktiond","id"); 
}
else{
$aktiond = "0";
}
echo '<input class="eingabe2" name="aktiond" value="'.$aktiond.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';          
echo '<tr align=center>';    
echo '<td>deaktiv</td>';
echo '<td>';
if($id != ""){
$deaktiv = getwert($id,"summon","deaktiv","id"); 
}
else{
$deaktiv = "0";
}
echo'<div class="auswahl">';
echo '<select name="deaktiv" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($deaktiv == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Deaktiviert'; 
echo '</option>'; 
echo '<option value="1"';
if($deaktiv == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aktiviert'; 
echo '</option>';                      
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';   
echo '<td>Statspunkte</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$statspunkte = getwert($id,"summon","statspunkte","id"); 
}
else{
$statspunkte = "0";
}
echo '<input class="eingabe2" name="statspunkte" value="'.$statspunkte.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was == "npc"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';   
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';         
echo '<tr align=center>';      
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"npc","name","id"); 
}
else{
$name = "Name";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>HP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$hp = getwert($id,"npc","hp","id"); 
}
else{
$hp = 100;
}
echo '<input class="eingabe2" name="hp" value="'.$hp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>MHP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mhp = getwert($id,"npc","mhp","id"); 
}
else{
$mhp = 100;
}
echo '<input class="eingabe2" name="mhp" value="'.$mhp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Chakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chakra = getwert($id,"npc","chakra","id"); 
}
else{
$chakra = 100;
}
echo '<input class="eingabe2" name="chakra" value="'.$chakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>MChakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mchakra = getwert($id,"npc","mchakra","id"); 
}
else{
$mchakra = 100;
}
echo '<input class="eingabe2" name="mchakra" value="'.$mchakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';      
echo '<td>Kraft</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kr = getwert($id,"npc","kr","id"); 
}
else{
$kr = "10";
}
echo '<input class="eingabe2" name="kr" value="'.$kr.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td>Intelligenz</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$intl = getwert($id,"npc","intl","id"); 
}
else{
$intl = "10";
}
echo '<input class="eingabe2" name="intl" value="'.$intl.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Chakrakontrolle</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chrk = getwert($id,"npc","chrk","id"); 
}
else{
$chrk = "10";
}
echo '<input class="eingabe2" name="chrk" value="'.$chrk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Tempo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$tmp = getwert($id,"npc","tmp","id"); 
}
else{
$tmp = "10";
}
echo '<input class="eingabe2" name="tmp" value="'.$tmp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Genauigkeit</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$gnk = getwert($id,"npc","gnk","id"); 
}
else{
$gnk = "10";
}
echo '<input class="eingabe2" name="gnk" value="'.$gnk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Widerstand</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$wid = getwert($id,"npc","wid","id"); 
}
else{
$wid = "10";
}
echo '<input class="eingabe2" name="wid" value="'.$wid.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align="center">';
echo '<td>Jutsus</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$jutsus = getwert($id,"npc","jutsus","id"); 
}
else{
$jutsus = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    bild,
    name
FROM
    jutsus
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($tint == 6){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($jutsus));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}   
echo '<a class="sinfo">';   
echo '<span class="spanmap">'.$row['name'].'</span>';   
if($hat == 1){
echo '<img src="bilder/jutsus/'.$row['bild'].'h.png" width="60px" height="60px"></img>';
}
if($hat == 0){
echo '<img src="bilder/jutsus/'.$row['bild'].'.png" width="50px" height="50px"></img>';
}         
echo '</a>';
echo '<br>';
echo '<input type="checkbox" name="jutsus[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';   
echo '<tr align="center">';
echo '<td>Angebotene Items</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$items = getwert($id,"npc","items","id"); 
}
else{
$items = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    bild
FROM
    item
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($tint == 6){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($items));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}
echo '<img src="'.$row['bild'].'" width="50px" height="50px"></img>';
echo '<br>';
echo '<input type="checkbox" name="items[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>Kampfbild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$kbild = getwert($id,"npc","kbild","id"); 
}
else{
$kbild = "KampfBild";
}
echo '<input class="eingabe4" name="kbild" value="'.$kbild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>Bild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$bild = getwert($id,"npc","bild","id"); 
}
else{
$bild = "Bild";
}
echo '<input class="eingabe4" name="bild" value="'.$bild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Geschlecht</td>';
echo '<td>';
if($id != ""){
$geschlecht = getwert($id,"npc","geschlecht","id"); 
}
else{
$geschlecht = "männlich";
}
echo'<div class="auswahl">';
echo '<select name="geschlecht" class="Auswahl" size="1">'; 
echo '<option value="männlich"';
if($geschlecht == "männlich"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'männlich'; 
echo '</option>'; 
echo '<option value="weiblich"';
if($geschlecht == "weiblich"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Weiblich'; 
echo '</option>';                     
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';    
echo '<td>Vertrag</td>';
echo '<td>';
if($id != ""){
$vertrag = getwert($id,"npc","vertrag","id"); 
}
else{
$vertrag = "";
}
echo'<div class="auswahl">';
echo '<select name="vertrag" class="Auswahl" size="1">'; 
echo '<option value=""';
if($vertrag == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Kein Vertrag '; 
echo '</option>';             
echo '<option value="spinne"';
if($vertrag == "spinne"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Spinne'; 
echo '</option>'; 
echo '<option value="frosch"';
if($vertrag == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>'; 
echo '<option value="schlange"';
if($vertrag == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>';
echo '<option value="schnecke"';
if($vertrag == "schnecke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schnecke'; 
echo '</option>'; 
echo '<option value="eule"';
if($vertrag == "eule"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Eule'; 
echo '</option>';    
echo '<option value="dämon"';
if($vertrag == "dämon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'dämonen'; 
echo '</option>';  
echo '<option value="krähe"';
if($vertrag == "krähe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'krähen'; 
echo '</option>';  
echo '<option value="affe"';
if($vertrag == "affe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Affen'; 
echo '</option>';  
echo '<option value="hai"';
if($vertrag == "hai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Haie'; 
echo '</option>';  
echo '<option value="falke"';
if($vertrag == "falke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Falken'; 
echo '</option>';   
echo '<option value="salamander"';
if($vertrag == "salamander"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Salamander'; 
echo '</option>';  
echo '<option value="ninken"';
if($vertrag == "ninken"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ninken'; 
echo '</option>';   
echo '<option value="bienen"';
if($vertrag == "bienen"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Bienen'; 
echo '</option>';         
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';       
echo '<td>Vertrag Chakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$vchakra = getwert($id,"npc","vchakra","id"); 
}
else{
$vchakra = "0";
}
echo '<input class="eingabe2" name="vchakra" value="'.$vchakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';    
echo '<td>Macht Vertrag</td>';
echo '<td>';
if($id != ""){
$vgemacht = getwert($id,"npc","vgemacht","id"); 
}
else{
$vgemacht = "";
}
echo'<div class="auswahl">';
echo '<select name="vgemacht" class="Auswahl" size="1">'; 
echo '<option value=""';
if($vgemacht == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Kein Vertrag '; 
echo '</option>';           
echo '<option value="spinne"';
if($vgemacht == "spinne"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Spinne'; 
echo '</option>'; 
echo '<option value="frosch"';
if($vgemacht == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>'; 
echo '<option value="schlange"';
if($vgemacht == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>';
echo '<option value="schnecke"';
if($vgemacht == "schnecke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schnecke'; 
echo '</option>';  
echo '<option value="eule"';
if($vgemacht == "eule"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Eule'; 
echo '</option>';    
echo '<option value="dämon"';
if($vgemacht == "dämon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'dämonen'; 
echo '</option>';  
echo '<option value="krähe"';
if($vgemacht == "krähe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'krähen'; 
echo '</option>';  
echo '<option value="affe"';
if($vgemacht == "affe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Affen'; 
echo '</option>';  
echo '<option value="hai"';
if($vgemacht == "hai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Haie'; 
echo '</option>';  
echo '<option value="falke"';
if($vgemacht == "falke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Falken'; 
echo '</option>';   
echo '<option value="salamander"';
if($vgemacht == "salamander"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Salamander'; 
echo '</option>';   
echo '<option value="ninken"';
if($vertrag == "ninken"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ninken'; 
echo '</option>';   
echo '<option value="bienen"';
if($vertrag == "bienen"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Bienen'; 
echo '</option>';                      
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';    
echo '<td>Element</td>';
echo '<td>';
if($id != ""){
$element = getwert($id,"npc","element","id"); 
}
else{
$element = "";
}
echo'<div class="auswahl">';
echo '<select name="element" class="Auswahl" size="1">'; 
echo '<option value=""';
if($element == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Kein Element '; 
echo '</option>';           
echo '<option value="Katon"';
if($element == "Katon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Katon'; 
echo '</option>';     
echo '<option value="Suiton"';
if($element == "Suiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Suiton'; 
echo '</option>';      
echo '<option value="Raiton"';
if($element == "Raiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Raiton'; 
echo '</option>';    
echo '<option value="Fuuton"';
if($element == "Fuuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Fuuton'; 
echo '</option>';    
echo '<option value="Doton"';
if($element == "Doton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Doton'; 
echo '</option>';                    
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  

echo '<tr align=center>';      
echo '<td>Clan</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$clan = getwert($id,"npc","clan","id"); 
}
else{
$clan = "";
}
echo'<div class="auswahl">';
echo '<select name="clan" class="Auswahl" size="1">';   
echo '<option value=""';
if($clan == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein'; 
echo '</option>';
echo '<option value="normal"';
if($clan == "normal"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Normal'; 
echo '</option>';
echo '<option value="kumo"';
if($clan == "kumo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kumo'; 
echo '</option>'; 
echo '<option value="uchiha"';
if($clan == "uchiha"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Uchiha'; 
echo '</option>'; 
echo '<option value="hyuuga"';
if($clan == "hyuuga"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hyuuga'; 
echo '</option>';    
echo '<option value="aburame"';
if($clan == "aburame"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aburame'; 
echo '</option>'; 
echo '<option value="akimichi"';
if($clan == "akimichi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Akimichi'; 
echo '</option>'; 
echo '<option value="inuzuka"';
if($clan == "inuzuka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Inuzuka'; 
echo '</option>';
echo '<option value="kaguya"';
if($clan == "kaguya"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kaguya'; 
echo '</option>'; 
echo '<option value="kugutsu"';
if($clan == "kugutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kugutsu'; 
echo '</option>'; 
echo '<option value="mokuton"';
if($clan == "mokuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Mokuton'; 
echo '</option>'; 
echo '<option value="yuki"';
if($clan == "yuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yuki'; 
echo '</option>'; 
echo '<option value="sand"';
if($clan == "sand"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sand'; 
echo '</option>'; 
echo '<option value="tai"';
if($clan == "tai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Tai'; 
echo '</option>'; 
echo '<option value="youton"';
if($clan == "youton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Youton'; 
echo '</option>';
echo '<option value="nara"';
if($clan == "nara"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nara'; 
echo '</option>';
echo '<option value="shouton"';
if($clan == "shouton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Shouton'; 
echo '</option>';  
echo '<option value="jiton"';
if($clan == "jiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiton'; 
echo '</option>'; 
echo '<option value="iryonin"';
if($clan == "iryonin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Iryonin'; 
echo '</option>';  
echo '<option value="sumi"';
if($clan == "sumi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sumi'; 
echo '</option>'; 
echo '<option value="kami"';
if($clan == "kami"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kami'; 
echo '</option>';
echo '<option value="schlange"';
if($clan == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>'; 
echo '<option value="frosch"';
if($clan == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';  
echo '<option value="puroresu"';
if($clan == "puroresu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puroresu'; 
echo '</option>';  
echo '<option value="buki"';
if($clan == "buki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Buki'; 
echo '</option>'; 
echo '<option value="jiongu"';
if($clan == "jiongu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiongu'; 
echo '</option>';   
echo '<option value="kibaku nendo"';
if($clan == "kibaku nendo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kibaku Nendo'; 
echo '</option>';     
echo '<option value="kengou"';
if($clan == "kengou"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kengou'; 
echo '</option>';
echo '<option value="sakon"';
if($clan == "sakon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sakon'; 
echo '</option>'; 
echo '<option value="senninka"';
if($clan == "senninka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Senninka'; 
echo '</option>';
echo '<option value="hozuki"';
if($clan == "hozuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hozuki'; 
echo '</option>';   
echo '<option value="kamizuru"';
if($clan == "kamizuru"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kamizuru'; 
echo '</option>';  
echo '<option value="kurama"';
if($clan == "kurama"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kurama'; 
echo '</option>'; 
echo '<option value="yamanaka"';
if($clan == "yamanaka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yamanaka'; 
echo '</option>';  
echo '<option value="ishoku sharingan"';
if($clan == "ishoku sharingan"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ishoku Sharingan'; 
echo '</option>';      
echo '<option value="utakata"';
if($clan == "utakata"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Utakata'; 
echo '</option>';  
echo '<option value="jinchuuriki modoki"';
if($clan == "jinchuuriki modoki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jinchuuriki Modoki'; 
echo '</option>';  
echo '<option value="jashin"';
if($clan == "jashin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jashin'; 
echo '</option>';   
echo '<option value="roku pasu"';
if($clan == "roku pasu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Roku Pasu'; 
echo '</option>'; 
echo '<option value="jinton"';
if($clan == "jinton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'jinton'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';       
echo '<td>NPCKampf</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$npckampf = getwert($id,"npc","npckampf","id"); 
}
else{
$npckampf = "0";
}
echo '<input class="eingabe2" name="npckampf" value="'.$npckampf.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';       
echo '<td>NPCStats</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$npcstats = getwert($id,"npc","npcstats","id"); 
}
else{
$npcstats = "0";
}
echo '<input class="eingabe2" name="npcstats" value="'.$npcstats.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';       
echo '<td>NPCPlus</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$npcplus = getwert($id,"npc","npcplus","id"); 
}
else{
$npcplus = "0";
}
echo '<input class="eingabe2" name="npcplus" value="'.$npcplus.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Itemgewinn</td>';
echo '<td>';  
if($id != ""){
$itemgewinn = getwert($id,"npc","itemgewinn","id"); 
}
else{
$itemgewinn = "0";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    item
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="itemgewinn" class="Auswahl" size="1">';  
echo '<option value="0">Kein Item</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $itemgewinn){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';       
echo '<td>Itemchance</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$itemchance = getwert($id,"npc","itemchance","id"); 
}
else{
$itemchance = "0";
}
echo '<input class="eingabe2" name="itemchance" value="'.$itemchance.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>NextNPC</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    npc
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="npcnext" class="Auswahl" size="1">';     
if($id != ""){
$npcnext = getwert($id,"npc","npcnext","id"); 
}
else{
$npcnext = 0; 
}
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $npcnext){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo'<option value="';
echo '0';
if($npcnext == 0){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kein NPC'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>NPCLevel</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$npclevel = getwert($id,"npc","npclevel","id"); 
}
else{
$npclevel = "0";
}
echo '<input class="eingabe2" name="npclevel" value="'.$npclevel.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';       
echo '<td>NPCName</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$npcname = getwert($id,"npc","npcname","id"); 
}
else{
$npcname = "";
}
echo '<input class="eingabe2" name="npcname" value="'.$npcname.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Kaufstats</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kaufstats = getwert($id,"npc","kaufstats","id"); 
}
else{
$kaufstats = "0";
}
echo '<input class="eingabe2" name="kaufstats" value="'.$kaufstats.'" size="15" maxlength="11" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Event</td>';
echo '<td>';  
if($id != ""){
$event = getwert($id,"npc","event","id"); 
}
else{
$event = "";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    events
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="event" class="Auswahl" size="1">';  
echo'<option value="0';
if("0" == $event){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo 'Kein Event'; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $event){
echo '" selected>'; 
}
else{     
echo '">'; 

}          
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was =="npcs"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';   
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';         
echo '<tr align=center>';      
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"npcs","name","id"); 
}
else{
$name = "Name";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Kampfname</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kname = getwert($id,"npcs","kname","id"); 
}
else{
$kname = "Kampfname";
}
echo '<input class="eingabe2" name="kname" value="'.$kname.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';

echo '<tr align=center>';    
echo '<td>Bwo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$bwo = getwert($id,"npcs","bwo","id"); 
}
echo '<input class="eingabe2" name="bwo" value="'.$bwo.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Besitzer</td>';
echo '<td>';    
if($bwo == ""){
$bwo = "charaktere";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    '.$bwo.'
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="besitzer" class="Auswahl" size="1">';     
if($id != ""){
$besitzer = getwert($id,"npcs","besitzer","id"); 
}
else{
$besitzer = ""; 
}               
echo '<option value="">';
echo 'Keiner'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $besitzer){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>HP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$hp = getwert($id,"npcs","hp","id"); 
}
else{
$hp = 100;
}
echo '<input class="eingabe2" name="hp" value="'.$hp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>MHP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mhp = getwert($id,"npcs","mhp","id"); 
}
else{
$mhp = 100;
}
echo '<input class="eingabe2" name="mhp" value="'.$mhp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Chakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chakra = getwert($id,"npcs","chakra","id"); 
}
else{
$chakra = 100;
}
echo '<input class="eingabe2" name="chakra" value="'.$chakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>MChakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mchakra = getwert($id,"npcs","mchakra","id"); 
}
else{
$mchakra = 100;
}
echo '<input class="eingabe2" name="mchakra" value="'.$mchakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';      
echo '<td>Kraft</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kr = getwert($id,"npcs","kr","id"); 
}
else{
$kr = "10";
}
echo '<input class="eingabe2" name="kr" value="'.$kr.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>MKraft</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mkr = getwert($id,"npcs","mkr","id"); 
}
else{
$mkr = "10";
}
echo '<input class="eingabe2" name="mkr" value="'.$mkr.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td>Intelligenz</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$intl = getwert($id,"npcs","intl","id"); 
}
else{
$intl = "10";
}
echo '<input class="eingabe2" name="intl" value="'.$intl.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MIntelligenz</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mintl = getwert($id,"npcs","mintl","id"); 
}
else{
$mintl = "10";
}
echo '<input class="eingabe2" name="mintl" value="'.$mintl.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Chakrakontrolle</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chrk = getwert($id,"npcs","chrk","id"); 
}
else{
$chrk = "10";
}
echo '<input class="eingabe2" name="chrk" value="'.$chrk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MChakrakontrolle</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mchrk = getwert($id,"npcs","mchrk","id"); 
}
else{
$mchrk = "10";
}
echo '<input class="eingabe2" name="mchrk" value="'.$mchrk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Tempo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$tmp = getwert($id,"npcs","tmp","id"); 
}
else{
$tmp = "10";
}
echo '<input class="eingabe2" name="tmp" value="'.$tmp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MTempo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mtmp = getwert($id,"npcs","mtmp","id"); 
}
else{
$mtmp = "10";
}
echo '<input class="eingabe2" name="mtmp" value="'.$mtmp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Genauigkeit</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$gnk = getwert($id,"npcs","gnk","id"); 
}
else{
$gnk = "10";
}
echo '<input class="eingabe2" name="gnk" value="'.$gnk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MGenauigkeit</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mgnk = getwert($id,"npcs","mgnk","id"); 
}
else{
$mgnk = "10";
}
echo '<input class="eingabe2" name="mgnk" value="'.$mgnk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Widerstand</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$wid = getwert($id,"npcs","wid","id"); 
}
else{
$wid = "10";
}
echo '<input class="eingabe2" name="wid" value="'.$wid.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MWiderstand</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mwid = getwert($id,"npcs","mwid","id"); 
}
else{
$mwid = "10";
}
echo '<input class="eingabe2" name="mwid" value="'.$mwid.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align="center">';
echo '<td>Jutsus</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$jutsus = getwert($id,"npcs","jutsus","id"); 
}
else{
$jutsus = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    bild,
    name
FROM
    jutsus
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($tint == 6){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($jutsus));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}   
echo '<a class="sinfo">';  
echo '<span class="spanmap">'.$row['name'].'</span>';   
if($hat == 1){
echo '<img src="bilder/jutsus/'.$row['bild'].'h.png" width="60px" height="60px"></img>';
}
if($hat == 0){
echo '<img src="bilder/jutsus/'.$row['bild'].'.png" width="50px" height="50px"></img>';
}         
echo '</a>';       
echo '<br>';
echo '<input type="checkbox" name="jutsus[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>Kampfbild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$kbild = getwert($id,"npcs","kbild","id"); 
}
else{
$kbild = "KampfBild";
}
echo '<input class="eingabe4" name="kbild" value="'.$kbild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>kkBild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$kkbild = getwert($id,"npcs","kkbild","id"); 
}
else{
$kkbild = "KampfKampfBild";
}
echo '<input class="eingabe4" name="kkbild" value="'.$kkbild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Geschlecht</td>';
echo '<td>';
if($id != ""){
$geschlecht = getwert($id,"npcs","geschlecht","id"); 
}
else{
$geschlecht = "männlich";
}
echo'<div class="auswahl">';
echo '<select name="geschlecht" class="Auswahl" size="1">'; 
echo '<option value="männlich"';
if($geschlecht == "männlich"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'männlich'; 
echo '</option>'; 
echo '<option value="weiblich"';
if($geschlecht == "weiblich"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Weiblich'; 
echo '</option>';                     
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Kampf Aktion</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    jutsus
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kaktion" class="Auswahl" size="1">';     
if($id != ""){
$kaktion = getwert($id,"npcs","kaktion","id"); 
}
else{
$kaktion = ""; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';       
echo'<option value="';
echo 'Zufall';
if($kaktion == "Zufall"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Zufall'; 
echo '</option>';   
echo'<option value="';
echo 'Besiegt';
if($kaktion == "Besiegt"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Besiegt'; 
echo '</option>';     
echo'<option value="';
echo 'Kombi';
if($kaktion == "Kombi"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kombi'; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kaktion){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>'; 
echo '<td>Kampfid</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    fights
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kampfid" class="Auswahl" size="1">';     
if($id != ""){
$kampfid = getwert($id,"npcs","kampfid","id"); 
}
else{
$kampfid = "0"; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kampfid){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';       
echo '<td>Team (Kampf)</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$team = getwert($id,"npcs","team","id"); 
}
else{
$team = "0";
}
echo '<input class="eingabe2" name="team" value="'.$team.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Kampf Ziel</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kziel = getwert($id,"npcs","kziel","id"); 
}
else{
$kziel = "0";
}
echo '<input class="eingabe2" name="kziel" value="'.$kziel.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';       
echo '<td>Kampf Chakra add</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kchadd = getwert($id,"npcs","kchadd","id"); 
}
else{
$kchadd = "0";
}
echo '<input class="eingabe2" name="kchadd" value="'.$kchadd.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';       
echo '<td>Kampf Ziel wo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kzwo = getwert($id,"npcs","kzwo","id"); 
}
else{
$kzwo = "npcs";
}
echo '<input class="eingabe2" name="kzwo" value="'.$kzwo.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>'; 
echo '<td>NPCid</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    npc
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="npcid" class="Auswahl" size="1">';     
if($id != ""){
$npcid = getwert($id,"npcs","npcid","id"); 
}
else{
$npcid = "1"; 
}                    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $npcid){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';    
echo '<td>Vertrag</td>';
echo '<td>';
if($id != ""){
$vertrag = getwert($id,"npcs","vertrag","id"); 
}
else{
$vertrag = "";
}
echo'<div class="auswahl">';
echo '<select name="vertrag" class="Auswahl" size="1">'; 
echo '<option value=""';
if($vertrag == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Kein Vertrag '; 
echo '</option>'; 
echo '<option value="frosch"';
if($vertrag == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';       
echo '<option value="spinne"';
if($vertrag == "spinne"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Spinne'; 
echo '</option>'; 
echo '<option value="schlange"';
if($vertrag == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>';
echo '<option value="schnecke"';
if($vertrag == "schnecke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schnecke'; 
echo '</option>'; 
echo '<option value="eule"';
if($vertrag == "eule"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Eule'; 
echo '</option>';    
echo '<option value="dämon"';
if($vertrag == "dämon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'dämonen'; 
echo '</option>';  
echo '<option value="krähe"';
if($vertrag == "krähe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'krähen'; 
echo '</option>';  
echo '<option value="affe"';
if($vertrag == "affe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Affen'; 
echo '</option>';  
echo '<option value="hai"';
if($vertrag == "hai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Haie'; 
echo '</option>';  
echo '<option value="falke"';
if($vertrag == "falke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Falken'; 
echo '</option>';   
echo '<option value="salamander"';
if($vertrag == "salamander"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Salamander'; 
echo '</option>'; 
echo '<option value="ninken"';
if($vertrag == "ninken"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ninken'; 
echo '</option>';   
echo '<option value="bienen"';
if($vertrag == "bienen"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Bienen'; 
echo '</option>';                      
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>LastkAktion</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$lkaktion = getwert($id,"npcs","lkaktion","id"); 
}
else{
$lkaktion = time(); 
$lkaktion = date("Y-m-d H:i:s",$lkaktion);
}
echo '<input class="eingabe2" name="lkaktion" value="'.$lkaktion.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align="center">';
echo '<td>Powerup</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$powerup = getwert($id,"npcs","powerup","id"); 
}
else{
$powerup = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    bild,
    art,
    name
FROM
    jutsus
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($row['art'] == 6||$row['art'] == 9){  
if($tint == 6){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($powerup));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}    
echo '<a class="sinfo">';  
echo '<span class="spanmap">'.$row['name'].'</span>';   
if($hat == 1){
echo '<img src="bilder/jutsus/'.$row['bild'].'h.png" width="60px" height="60px"></img>';
}
if($hat == 0){
echo '<img src="bilder/jutsus/'.$row['bild'].'.png" width="50px" height="50px"></img>';
}         
echo '</a>';
echo '<br>';
echo '<input type="checkbox" name="powerup[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Debuff</td>';
echo '<td>';
if($id != ""){
$debuff = getwert($id,"npcs","debuff","id"); 
}
else{
$debuff = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="debuff" maxlength="300000">';
echo $debuff;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';       
echo '<td>Dstats 0;0;0;0;0;0 (KR-WID)</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$dstats = getwert($id,"npcs","dstats","id"); 
}
else{
$dstats = "";
}
echo '<input class="eingabe2" name="dstats" value="'.$dstats.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Last Chakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$lchakra = getwert($id,"npcs","lchakra","id"); 
}
else{
$lchakra = "";
}
echo '<input class="eingabe2" name="lchakra" value="'.$lchakra.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Einmalig</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$einmalig = getwert($id,"npcs","einmalig","id"); 
}
else{
$einmalig = "0";
}
echo '<input class="eingabe2" name="einmalig" value="'.$einmalig.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';     
echo '<td>Summonused</td>';
echo '<td>';
if($summonused != ""){
$summonused = getwert($id,"npcs","summonused","id"); 
}
else{
$summonused = ""; 
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="summonused" maxlength="300000">';
echo $summonused;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';   
echo '<td>gradgerufen</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$gradgerufen = getwert($id,"npcs","gradgerufen","id"); 
}
else{
$gradgerufen = "0";
}
echo '<input class="eingabe2" name="gradgerufen" value="'.$gradgerufen.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';       
echo '<td>Kombipartner</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kombipartner = getwert($id,"npcs","kombipartner","id"); 
}
else{
$kombipartner = "0";
}
echo '<input class="eingabe2" name="kombipartner" value="'.$kombipartner.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Kombipartnerwo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kombipartnerw = getwert($id,"npcs","kombipartnerw","id"); 
}
else{
$kombipartnerw = "npcs";
}
echo '<input class="eingabe2" name="kombipartnerw" value="'.$kombipartnerw.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was == "missions"){
$punkte = $_REQUEST['punkte'];    
if($punkte == ""){
if($id != ""){
$punkte = getwert($id,"missions","punkte","id"); 
}
if($punkte == "0"){
$punkte = 1;
}
}
if($punkte == ""){    
echo '<form method="post" action="admin.php?page=edit&was='.$was.'&id=neu"><table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>Punkte</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="punkte" value="" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</table><br>';  
}
else{        
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table border="1" width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';     
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"missions","name","id"); 
}
else{
$name = "";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';     
echo '<td>Aufgabe</td>';
echo '<td>';
if($id != ""){
$aufgabe = getwert($id,"missions","aufgabe","id"); 
}
else{
$aufgabe = "";
}
$count = 0;   
$array = explode("@", trim($aufgabe));
echo '<table width="100%">';
while($count == 0||$count < $punkte){  
echo '<tr align=center><td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="aufgabe[]" value="'.$array[$count].'" size="15" maxlength="20" type="text">';
echo '</div>';
echo '</td></tr>';
$count++;
}
echo '</table>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';     
echo '<td>Art</td>';
echo '<td>';
if($id != ""){
$art = getwert($id,"missions","art","id"); 
}
else{
$art = "1";
}
$count = 0;   
$array = explode("@", trim($art));    
echo '<table width="100%">';
while($count == 0||$count < $punkte){  
echo '<tr align=center><td>';
echo'<div class="auswahl">';
echo '<select name="art[]" class="Auswahl" size="1">'; 
echo '<option value="1"';
if($array[$count] == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Reden'; 
echo '</option>';  
echo '<option value="2"';
if($array[$count] == "2"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kampf'; 
echo '</option>'; 
echo '<option value="3"';
if($array[$count] == "3"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Reisen'; 
echo '</option>';   
echo '<option value="4"';
if($array[$count] == "4"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Warten'; 
echo '</option>';
echo '</select>';
echo '</div>'; 
echo '</td>';
echo '</tr>';
$count++;
}            
echo '</table>'; 
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Was</td>';
echo '<td>';
if($id != ""){
$was2 = getwert($id,"missions","was","id"); 
}
else{
$was2 = "1";
}
$count = 0;   
$array = explode("@", trim($was2));  
$array2 = explode("@", trim($art));           
echo '<table width="100%">';
while($count == 0||$count < $punkte){  
echo '<tr align=center><td>';
if($array2[$count] == "1"){     
$array3 = explode(";", trim($array[$count]));  
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    npc
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="was[]" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $array3[0]){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close(); 
echo '</select>';
echo '</div>';
echo '<div class="textfield2"><textarea class="textfield" name="was'.$count.'" maxlength="300000">';
echo $array3[1];
echo '</textarea>
</div>';
}
if($array2[$count] == "2"){
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="was[]" value="'.$array[$count].'" size="15" maxlength="30" type="text">';
echo '</div>';
}
if($array2[$count] == "3"){
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="was[]" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $array[$count]){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close(); 
echo '</select>';
echo '</div>'; 
}
if($array2[$count] == "4"){     
$array3 = explode(";", trim($array[$count])); 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    npc
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="was[]" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $array3[0]){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close(); 
echo '</select>';
echo '</div>'; 
echo '<div class="textfield2"><textarea class="textfield" name="was'.$count.'" maxlength="300000">';
echo $array3[1].';'.$array3[2];
echo '</textarea>
</div>';
} 
$count++;   
echo '</td></tr>';
}  
          
echo '</table>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';        
echo '<td>Ryo</td>';
echo '<td>';   
if($id != ""){
$ryo = getwert($id,"missions","ryo","id"); 
}
else{
$ryo = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="ryo" value="'.$ryo.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';        
echo '<td>EXP</td>';
echo '<td>';   
if($id != ""){
$exp = getwert($id,"missions","exp","id"); 
}
else{
$exp = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="exp" value="'.$exp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';      
echo '<td>Bluterbe</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$bluterbe = getwert($id,"missions","bluterbe","id"); 
}
else{
$bluterbe = "";
}
echo'<div class="auswahl">';
echo '<select name="bluterbe" class="Auswahl" size="1">';   
echo '<option value=""';
if($bluterbe == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein'; 
echo '</option>';
echo '<option value="normal"';
if($bluterbe == "normal"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Normal'; 
echo '</option>';
echo '<option value="kumo"';
if($bluterbe == "kumo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kumo'; 
echo '</option>'; 
echo '<option value="uchiha"';
if($bluterbe == "uchiha"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Uchiha'; 
echo '</option>'; 
echo '<option value="hyuuga"';
if($bluterbe == "hyuuga"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hyuuga'; 
echo '</option>';  
echo '<option value="aburame"';
if($bluterbe == "aburame"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aburame'; 
echo '</option>'; 
echo '<option value="akimichi"';
if($bluterbe == "akimichi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Akimichi'; 
echo '</option>'; 
echo '<option value="inuzuka"';
if($bluterbe == "inuzuka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Inuzuka'; 
echo '</option>';
echo '<option value="kaguya"';
if($bluterbe == "kaguya"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kaguya'; 
echo '</option>'; 
echo '<option value="kugutsu"';
if($bluterbe == "kugutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kugutsu'; 
echo '</option>'; 
echo '<option value="mokuton"';
if($bluterbe == "mokuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Mokuton'; 
echo '</option>'; 
echo '<option value="yuki"';
if($bluterbe == "yuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yuki'; 
echo '</option>'; 
echo '<option value="sand"';
if($bluterbe == "sand"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sand'; 
echo '</option>'; 
echo '<option value="tai"';
if($bluterbe == "tai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Tai'; 
echo '</option>'; 
echo '<option value="youton"';
if($bluterbe == "youton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Youton'; 
echo '</option>';
echo '<option value="nara"';
if($bluterbe == "nara"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nara'; 
echo '</option>';
echo '<option value="shouton"';
if($bluterbe == "shouton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Shouton'; 
echo '</option>';   
echo '<option value="jiton"';
if($clan == "jiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiton'; 
echo '</option>'; 
echo '<option value="iryonin"';
if($bluterbe == "iryonin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Iryonin'; 
echo '</option>';  
echo '<option value="sumi"';
if($bluterbe == "sumi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sumi'; 
echo '</option>'; 
echo '<option value="kami"';
if($bluterbe == "kami"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kami'; 
echo '</option>';
echo '<option value="schlange"';
if($bluterbe == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>'; 
echo '<option value="frosch"';
if($bluterbe == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';   
echo '<option value="puroresu"';
if($bluterbe == "puroresu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puroresu'; 
echo '</option>';  
echo '<option value="buki"';
if($bluterbe == "buki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Buki'; 
echo '</option>'; 
echo '<option value="jiongu"';
if($bluterbe == "jiongu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiongu'; 
echo '</option>';   
echo '<option value="kibaku nendo"';
if($bluterbe == "kibaku nendo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kibaku Nendo'; 
echo '</option>';       
echo '<option value="kengou"';
if($bluterbe == "kengou"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kengou'; 
echo '</option>'; 
echo '<option value="sakon"';
if($bluterbe == "sakon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sakon'; 
echo '</option>'; 
echo '<option value="senninka"';
if($bluterbe == "senninka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Senninka'; 
echo '</option>';
echo '<option value="hozuki"';
if($bluterbe == "hozuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hozuki'; 
echo '</option>';   
echo '<option value="kamizuru"';
if($bluterbe == "kamizuru"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kamizuru'; 
echo '</option>';  
echo '<option value="kurama"';
if($bluterbe == "kurama"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kurama'; 
echo '</option>'; 
echo '<option value="yamanaka"';
if($bluterbe == "yamanaka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yamanaka'; 
echo '</option>';  
echo '<option value="ishoku sharingan"';
if($bluterbe == "ishoku sharingan"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ishoku Sharingan'; 
echo '</option>';      
echo '<option value="utakata"';
if($bluterbe == "utakata"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Utakata'; 
echo '</option>';  
echo '<option value="jinchuuriki modoki"';
if($bluterbe == "jinchuuriki modoki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jinchuuriki Modoki'; 
echo '</option>';  
echo '<option value="jashin"';
if($bluterbe == "jashin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jashin'; 
echo '</option>';   
echo '<option value="roku pasu"';
if($bluterbe == "roku pasu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Roku Pasu'; 
echo '</option>'; 
echo '<option value="jinton"';
if($bluterbe == "jinton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'jinton'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';    
echo '<td>Vertrag</td>';
echo '<td>';
if($id != ""){
$vertrag = getwert($id,"missions","vertrag","id"); 
}
else{
$vertrag = "";
}
echo'<div class="auswahl">';
echo '<select name="vertrag" class="Auswahl" size="1">'; 
echo '<option value=""';
if($vertrag == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Kein Vertrag '; 
echo '</option>'; 
echo '<option value="frosch"';
if($vertrag == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';       
echo '<option value="spinne"';
if($vertrag == "spinne"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Spinne'; 
echo '</option>'; 
echo '<option value="schlange"';
if($vertrag == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>';
echo '<option value="schnecke"';
if($vertrag == "schnecke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schnecke'; 
echo '</option>'; 
echo '<option value="eule"';
if($vertrag == "eule"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Eule'; 
echo '</option>';    
echo '<option value="dämon"';
if($vertrag == "dämon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'dämonen'; 
echo '</option>';  
echo '<option value="krähe"';
if($vertrag == "krähe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'krähen'; 
echo '</option>';  
echo '<option value="affe"';
if($vertrag == "affe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Affen'; 
echo '</option>';  
echo '<option value="hai"';
if($vertrag == "hai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Haie'; 
echo '</option>';  
echo '<option value="falke"';
if($vertrag == "falke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Falken'; 
echo '</option>';   
echo '<option value="salamander"';
if($vertrag == "salamander"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Salamander'; 
echo '</option>'; 
echo '<option value="ninken"';
if($vertrag == "ninken"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ninken'; 
echo '</option>';   
echo '<option value="bienen"';
if($vertrag == "bienen"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Bienen'; 
echo '</option>';                       
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';

echo '<tr align=center>';    
echo '<td>Element</td>';
echo '<td>';
if($id != ""){
$element = getwert($id,"missions","element","id"); 
}
else{
$element = "";
}
echo'<div class="auswahl">';
echo '<select name="element" class="Auswahl" size="1">'; 
echo '<option value=""';
if($element == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Kein Element '; 
echo '</option>';           
echo '<option value="Katon"';
if($element == "Katon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Katon'; 
echo '</option>';     
echo '<option value="Suiton"';
if($element == "Suiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Suiton'; 
echo '</option>';      
echo '<option value="Raiton"';
if($element == "Raiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Raiton'; 
echo '</option>';    
echo '<option value="Fuuton"';
if($element == "Fuuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Fuuton'; 
echo '</option>';    
echo '<option value="Doton"';
if($element == "Doton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Doton'; 
echo '</option>';                    
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';   
echo '<td>Summon</td>';
echo '<td>';  
if($id != ""){
$summon = getwert($id,"missions","summon","id"); 
}
else{
$summon = "0";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    npc
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="summon" class="Auswahl" size="1">';  
echo '<option value="0">Kein Summon</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $summon){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Item</td>';
echo '<td>';  
if($id != ""){
$item = getwert($id,"missions","item","id"); 
}
else{
$item = "0";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    item
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="item" class="Auswahl" size="1">';  
echo '<option value="0">Kein Item</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $item){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>Itemanzahl</td>';
echo '<td>';   
if($id != ""){
$itemanzahl = getwert($id,"missions","itemanzahl","id"); 
}
else{
$itemanzahl = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="itemanzahl" value="'.$itemanzahl.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';      
echo '<td>Clan</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$clan = getwert($id,"missions","clan","id"); 
}
else{
$clan = "";
}
echo'<div class="auswahl">';
echo '<select name="clan" class="Auswahl" size="1">';   
echo '<option value=""';
if($clan == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein'; 
echo '</option>';
echo '<option value="normal"';
if($clan == "normal"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Normal'; 
echo '</option>';
echo '<option value="kumo"';
if($clan == "kumo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kumo'; 
echo '</option>'; 
echo '<option value="uchiha"';
if($clan == "uchiha"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Uchiha'; 
echo '</option>'; 
echo '<option value="hyuuga"';
if($clan == "hyuuga"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hyuuga'; 
echo '</option>';  
echo '<option value="aburame"';
if($clan == "aburame"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aburame'; 
echo '</option>'; 
echo '<option value="akimichi"';
if($clan == "akimichi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Akimichi'; 
echo '</option>'; 
echo '<option value="inuzuka"';
if($clan == "inuzuka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Inuzuka'; 
echo '</option>';
echo '<option value="kaguya"';
if($clan == "kaguya"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kaguya'; 
echo '</option>'; 
echo '<option value="kugutsu"';
if($clan == "kugutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kugutsu'; 
echo '</option>'; 
echo '<option value="mokuton"';
if($clan == "mokuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Mokuton'; 
echo '</option>'; 
echo '<option value="yuki"';
if($clan == "yuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yuki'; 
echo '</option>'; 
echo '<option value="sand"';
if($clan == "sand"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sand'; 
echo '</option>'; 
echo '<option value="tai"';
if($clan == "tai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Tai'; 
echo '</option>'; 
echo '<option value="youton"';
if($clan == "youton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Youton'; 
echo '</option>';
echo '<option value="nara"';
if($clan == "nara"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nara'; 
echo '</option>';
echo '<option value="shouton"';
if($clan == "shouton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Shouton'; 
echo '</option>';   
echo '<option value="jiton"';
if($clan == "jiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiton'; 
echo '</option>'; 
echo '<option value="iryonin"';
if($clan == "iryonin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Iryonin'; 
echo '</option>';  
echo '<option value="sumi"';
if($clan == "sumi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sumi'; 
echo '</option>'; 
echo '<option value="kami"';
if($clan == "kami"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kami'; 
echo '</option>';
echo '<option value="schlange"';
if($clan == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>'; 
echo '<option value="frosch"';
if($clan == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';  
echo '<option value="puroresu"';
if($clan == "puroresu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puroresu'; 
echo '</option>';  
echo '<option value="buki"';
if($clan == "buki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Buki'; 
echo '</option>'; 
echo '<option value="jiongu"';
if($clan == "jiongu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiongu'; 
echo '</option>';   
echo '<option value="kibaku nendo"';
if($clan == "kibaku nendo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kibaku Nendo'; 
echo '</option>';     
echo '<option value="kengou"';
if($clan == "kengou"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kengou'; 
echo '</option>';

echo '<option value="sakon"';
if($clan == "sakon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sakon'; 
echo '</option>'; 
echo '<option value="senninka"';
if($clan == "senninka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Senninka'; 
echo '</option>';
echo '<option value="hozuki"';
if($clan == "hozuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hozuki'; 
echo '</option>';   
echo '<option value="kamizuru"';
if($clan == "kamizuru"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kamizuru'; 
echo '</option>';  
echo '<option value="kurama"';
if($clan == "kurama"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kurama'; 
echo '</option>'; 
echo '<option value="yamanaka"';
if($clan == "yamanaka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yamanaka'; 
echo '</option>';  
echo '<option value="ishoku sharingan"';
if($clan == "ishoku sharingan"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ishoku Sharingan'; 
echo '</option>';      
echo '<option value="utakata"';
if($clan == "utakata"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Utakata'; 
echo '</option>';  
echo '<option value="jinchuuriki modoki"';
if($clan == "jinchuuriki modoki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jinchuuriki Modoki'; 
echo '</option>';  
echo '<option value="jashin"';
if($clan == "jashin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jashin'; 
echo '</option>';   
echo '<option value="roku pasu"';
if($clan == "roku pasu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Roku Pasu'; 
echo '</option>';   
echo '<option value="jinton"';
if($clan == "jinton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'jinton'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Story</td>';
echo '<td>';   
if($id != ""){
$story = getwert($id,"missions","story","id"); 
}
else{
$story = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="story" value="'.$story.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>Level</td>';
echo '<td>';   
if($id != ""){
$level = getwert($id,"missions","level","id"); 
}
else{
$level = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="level" value="'.$level.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Jutsu</td>';
echo '<td>';  
if($id != ""){
$jutsu = getwert($id,"missions","jutsu","id"); 
}
else{
$jutsu = "0";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    jutsus
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="jutsu" class="Auswahl" size="1">';  
echo '<option value="0">Kein Jutsu</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $jutsu){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Ersetztes Jutsu</td>';
echo '<td>';  
if($id != ""){
$jutsue = getwert($id,"missions","jutsue","id"); 
}
else{
$jutsue = "0";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    jutsus
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="jutsue" class="Auswahl" size="1">';  
echo '<option value="">Kein Jutsu</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $jutsue){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Wohin</td>';
echo '<td>';  
if($id != ""){
$wohin = getwert($id,"missions","wohin","id"); 
}
else{
$wohin = "0";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="wohin" class="Auswahl" size="1">';    
echo '<option value="0">Nirgendwohin</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $wohin){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Wo</td>';
echo '<td>';
if($id != ""){
$wo = getwert($id,"missions","wo","id"); 
}
else{
$wo = "1";
}
$count = 0;   
$array = explode("@", trim($wo));    
echo '<table width="100%">';
while($count == 0||$count < $punkte){  

echo '<tr align=center>';     
echo '<td>';
echo '<div class="eingabe1">'; 
echo '<input class="eingabe2" name="wo[]" value="'.$array[$count].'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
$count++;
}             
echo '</table>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Rank</td>';
echo '<td>';
if($id != ""){
$rank = getwert($id,"missions","rank","id"); 
}
else{
$rank = "d";
}   
echo'<div class="auswahl">';
echo '<select name="rank" class="Auswahl" size="1">'; 
echo '<option value=""';
if($rank == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein Rank'; 
echo '</option>'; 
echo '<option value="d"';
if($rank == "d"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'D'; 
echo '</option>';  
echo '<option value="c"';
if($rank == "c"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'C'; 
echo '</option>'; 
echo '<option value="b"';
if($rank == "b"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'B'; 
echo '</option>'; 
echo '<option value="a"';
if($rank == "a"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'A'; 
echo '</option>'; 
echo '<option value="s"';
if($rank == "s"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'S'; 
echo '</option>'; 
echo '<option value="m"';
if($rank == "m"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'M';
echo '</option>'; 
echo '<option value="story"';
if($rank == "story"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Story'; 
echo '</option>';  
echo '<option value="clan"';
if($rank == "clan"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Clan'; 
echo '</option>';   
echo '<option value="event"';
if($rank == "event"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Event'; 
echo '</option>';
echo '</select>';
echo '</div>';   
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>MWert</td>';
echo '<td>';
if($id != ""){
$rank = getwert($id,"missions","mwert","id"); 
}
else{
$rank = "d";
}   
echo'<div class="auswahl">';
echo '<select name="mwert" class="Auswahl" size="1">'; 
echo '<option value=""';
if($rank == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein Rank'; 
echo '</option>'; 
echo '<option value="d"';
if($rank == "d"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'D'; 
echo '</option>';  
echo '<option value="c"';
if($rank == "c"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'C'; 
echo '</option>'; 
echo '<option value="b"';
if($rank == "b"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'B'; 
echo '</option>'; 
echo '<option value="a"';
if($rank == "a"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'A'; 
echo '</option>'; 
echo '<option value="s"';
if($rank == "s"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'S'; 
echo '</option>'; 
echo '<option value="m"';
if($rank == "m"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'M';
echo '</option>'; 
echo '<option value="story"';
if($rank == "story"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Story'; 
echo '</option>';  
echo '<option value="clan"';
if($rank == "clan"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Clan'; 
echo '</option>';   
echo '<option value="event"';
if($rank == "event"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Event'; 
echo '</option>';
echo '</select>';
echo '</div>';   
echo '</td>';
echo '</tr>';       
echo '<tr align=center>';     
echo '<td>Nuke Rank</td>';
echo '<td>';
if($id != ""){
$mrank = getwert($id,"missions","mrank","id"); 
}
else{
$mrank = "";
}
echo '<div class="eingabe1">'; 
echo '<input class="eingabe2" name="mrank" value="'.$mrank.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Rank Belohnung</td>';
echo '<td>';
if($id != ""){
$grank = getwert($id,"missions","grank","id"); 
}
else{
$grank = "";
}
echo'<div class="auswahl">';
echo '<select name="grank" class="Auswahl" size="1">';
echo '<option value=""';
if($grank == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein Rank'; 
echo '</option>';  
echo '<option value="student"';
if($grank == "student"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Student'; 
echo '</option>'; 
echo '<option value="genin"';
if($grank == "genin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Genin'; 
echo '</option>';  
echo '<option value="chuunin"';
if($grank == "chuunin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Chuunin'; 
echo '</option>'; 
echo '<option value="jounin"';
if($grank == "jounin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jounin'; 
echo '</option>';  
echo '<option value="anbu"';
if($grank == "anbu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Anbu'; 
echo '</option>'; 
echo '<option value="kage"';
if($grank == "kage"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kage'; 
echo '</option>';
echo '<option value="nuke-nin"';
if($grank == "nuke-nin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nuke-nin'; 
echo '</option>';  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Punkte</td>';
echo '<td>';
if($id != ""){
$punkte = getwert($id,"missions","punkte","id"); 
}
else{
$punkte = "";
}
echo '<div class="eingabe1">'; 
echo '<input class="eingabe2" name="punkte" value="'.$punkte.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Beschreibung</td>';
echo '<td>';
if($id != ""){
$beschreibung = getwert($id,"missions","beschreibung","id"); 
}
else{
$beschreibung = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="beschreibung" maxlength="300000">';
echo $beschreibung;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Abeschreibung</td>';
echo '<td>';
if($id != ""){
$abeschr = getwert($id,"missions","abeschr","id"); 
}
else{
$abeschr = "";
}
$count = 0;   
$array = explode("@", trim($abeschr));    
echo '<table width="100%">';
while($count == 0||$count < $punkte){  
echo '<tr align=center><td>';   
echo '</div>';
echo '<div class="textfield2">
<textarea class="textfield" name="abeschr[]" maxlength="300000">';
echo $array[$count];
echo '</textarea>
</div>';
echo '</td></tr>';
$count++;
}             
echo '</table>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';     
echo '<td>Positiv: Mehr EXP<br>
Negativ: Mehr Ryo</td>';
echo '<td>';
if($id != ""){
$dwert = getwert($id,"missions","dwert","id"); 
}
else{
$dwert = 0;
}
echo '<div class="eingabe1">'; 
echo '<input class="eingabe2" name="dwert" value="'.$dwert.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';   
echo '<td>Item benötigt</td>';
echo '<td>';  
if($id != ""){
$itemb = getwert($id,"missions","itemb","id"); 
}
else{
$itemb = "";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    item
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="itemb" class="Auswahl" size="1">';  
echo'<option value="';
if("" == $itemb){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo 'Kein Item'; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['name'];  
if($row['name'] == $itemb){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Event</td>';
echo '<td>';  
if($id != ""){
$event = getwert($id,"missions","event","id"); 
}
else{
$event = "";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    events
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="event" class="Auswahl" size="1">';  
echo'<option value="0';
if("0" == $event){
echo '" selected>'; 
}
else{     
echo '">'; 

}             
echo 'Kein Event'; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $event){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 

}
}
if($was == "meldungen"){   
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';       
echo '<tr align=center>';     
echo '<td>Datum</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$datum = getwert($id,"meldungen","datum","id"); 
}
else{
$datum = time(); 
$datum = date("Y-m-d H:i:s",$date);
}
echo '<input class="eingabe2" name="datum" value="'.$datum.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>User</td>';
echo '<td>';  
if($id != ""){
$usera = getwert($id,"meldungen","user","id"); 
}
else{
$usera = "1";
}
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
echo '<select name="user" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $usera){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Betreff</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$betreff = getwert($id,"meldungen","betreff","id"); 
}
else{
$betreff = "";
}
echo '<input class="eingabe2" name="betreff" value="'.$betreff.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Text</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="text" maxlength="300000">';
if($id != ""){
$text = getwert($id,"meldungen","text","id"); 
}
else{
$text = "";
}
echo $text;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td>Status</td>';
echo '<td>';
if($id != ""){
$status = getwert($id,"meldungen","status","id"); 
}
else{
$status = "Wartet";
}
echo'<div class="auswahl">';
echo '<select name="status" class="Auswahl" size="1">'; 
echo '<option value="Wartet"';
if($status == "Wartet"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Wartet'; 
echo '</option>';  
echo '<option value="In Bearbeitung"';
if($status == "In Bearbeitung"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'In Bearbeitung'; 
echo '</option>';  
echo '<option value="Abgeschlossen"';
if($status == "Abgeschlossen"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Abgeschlossen'; 
echo '</option>';   
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';  

}  
if($was == "kommentare"){   
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';   
echo '<td>News</td>';
echo '<td>';  
if($id != ""){
$news = getwert($id,"kommentare","news","id"); 
}
else{
$news = "1";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    title
FROM
    news
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="news" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $news){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['title'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Autor</td>';
echo '<td>';  
if($id != ""){
$autor = getwert($id,"kommentare","autor","id"); 
}
else{
$autor = "1";
}
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
echo '<select name="autor" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $autor){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Text</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="text" maxlength="300000">';
if($id != ""){
$text = getwert($id,"kommentare","text","id"); 
}
else{
$text = "";
}
echo $text;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Datum</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$date = getwert($id,"kommentare","date","id"); 
}
else{
$date = time(); 
$date = date("Y-m-d H:i:s",$date);
}
echo '<input class="eingabe2" name="date" value="'.$date.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';  

}  
if($was == "jutsus"){     
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';
echo '<td>Typ</td>';
echo '<td>';
if($id != ""){
$typ = getwert($id,"jutsus","typ","id"); 
}
else{
$typ = "Taijutsu";
}
echo'<div class="auswahl">';
echo '<select name="typ" class="Auswahl" size="1">'; 
echo '<option value="Taijutsu"';
if($typ == "Taijutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Taijutsu'; 
echo '</option>'; 
echo '<option value="Ninjutsu"';
if($typ == "Ninjutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ninjutsu'; 
echo '</option>';
echo '<option value="Genjutsu"';
if($typ == "Genjutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Genjutsu'; 
echo '</option>'; 
echo '<option value="Powerup"';
if($typ == "Powerup"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Powerup'; 
echo '</option>';  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Name</td>';
echo '<td>';              
if($id != ""){
$name = getwert($id,"jutsus","name","id"); 
}
else{
$name = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="name" value="'.$name.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Art</td>';
echo '<td>';
if($id != ""){
$art = getwert($id,"jutsus","art","id"); 
}
else{
$art = "1";
}
echo'<div class="auswahl">';
echo '<select name="art" class="Auswahl" size="1">'; 
echo '<option value="1"';
if($art == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schaden'; 
echo '</option>'; 
echo '<option value="2"';
if($art == "2"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Verteidigung'; 
echo '</option>';   
echo '<option value="3"';
if($art == "3"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Bunshin'; 
echo '</option>';  
echo '<option value="4"';
if($art == "4"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Henge'; 
echo '</option>'; 
echo '<option value="5"';
if($art == "5"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Rufen'; 
echo '</option>';      
echo '<option value="6"';
if($art == "6"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Powerup'; 
echo '</option>'; 
echo '<option value="7"';
if($art == "7"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Debuff';  
echo '</option>';       
echo '<option value="8"';
if($art == "8"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Item werfen'; 
echo '</option>';   
echo '<option value="9"';
if($art == "9"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Item Powerup'; 
echo '</option>'; 
echo '<option value="10"';
if($art == "10"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Heilung'; 
echo '</option>'; 
echo '<option value="11"';
if($art == "11"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'AOE'; 
echo '</option>';  
echo '<option value="12"';
if($art == "12"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Heilung (self)'; 
echo '</option>';
echo '<option value="13"';
if($art == "13"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Spezial'; 
echo '</option>';   
echo '<option value="14"';
if($art == "14"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Powerup (Hund/Herz)'; 
echo '</option>';  
echo '<option value="15"';
if($art == "15"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kombination'; 
echo '</option>';
echo '<option value="16"';
if($art == "16"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Heilung (mehrere)'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';           
echo '<tr align=center>';        
echo '<td>Damage<br>HP/DMG;CHAKRA;KR;TMP<br>INTL;GNK;CHRK;WID</td>';
echo '<td>';              
if($id != ""){
$dmg = getwert($id,"jutsus","dmg","id"); 
}
else{
$dmg = "HP/DMG;CHAKRA;KR;TMP;INTL;GNK;CHRK;WID";
}                               
$count = 0;
$array = explode(";", trim($dmg));
while($array[$count] != ""||$count == 0){
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="dmg[]" value="'.$array[$count].'" size="15" maxlength="15" type="text">';
echo '</div>';
$count++;
}
echo '</td>';
echo '</tr>';       
echo '<tr align=center>';        
echo '<td>Chakrasteal</td>';
echo '<td>';              
if($id != ""){
$cdmg = getwert($id,"jutsus","cdmg","id"); 
}
else{
$cdmg = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="cdmg" value="'.$cdmg.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';        
echo '<td>Treffer</td>';
echo '<td>';              
if($id != ""){
$treffer = getwert($id,"jutsus","treffer","id"); 
}
else{
$treffer = "1.00";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="treffer" value="'.$treffer.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Text</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="text" maxlength="300000">';
if($id != ""){
$text = getwert($id,"jutsus","text","id"); 
}
else{
$text = "";
}
echo $text;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Ausweichen</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="dodge" maxlength="300000">';
if($id != ""){
$dodge = getwert($id,"jutsus","dodge","id"); 
}
else{
$dodge = "";
}
echo $dodge;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Bild</td>';
echo '<td>';              
if($id != ""){
$bild = getwert($id,"jutsus","bild","id"); 
}
else{
$bild = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="bild" value="'.$bild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>Chakra</td>';
echo '<td>';              
if($id != ""){
$chakra = getwert($id,"jutsus","chakra","id"); 
}
else{
$chakra = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="chakra" value="'.$chakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';        
echo '<td>Benötigt<br>HP;Chakra;KR;INTL<br>CHRK;TMP;GNK;WID</td>';
echo '<td>';              
if($id != ""){
$req = getwert($id,"jutsus","req","id"); 
}
else{
$req = "HP/DMG;CHAKRA;KR;INTL;CHRK;TMP;GNK;WID";
}                               
$count = 0;
$array = explode(";", trim($req));
while($array[$count] != ""||$count == 0){
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="req[]" value="'.$array[$count].'" size="15" maxlength="15" type="text">';
echo '</div>';
$count++;
}
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Item benötigt</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="item" maxlength="300000">';
if($id != ""){
$item = getwert($id,"jutsus","item","id"); 
}
else{
$item = "";
}
echo $item;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Jutsu benötigt</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    jutsus
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="jutsuben" class="Auswahl" size="1">';     
if($id != ""){
$jutsuben = getwert($id,"jutsus","jutsuben","id"); 
}
else{
$jutsuben = ""; 
}                    
echo'<option value="0'; 
if($jutsuben == "0"){
echo '" selected>';            
}
else{
echo '">';
}
echo ' Kein '; 
echo '</option>';  
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $jutsuben){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Dauer</td>';
echo '<td>';              
if($id != ""){
$dauer = getwert($id,"jutsus","dauer","id"); 
}
else{
$dauer = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="dauer" value="'.$dauer.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Element</td>';
echo '<td>';
if($id != ""){
$element = getwert($id,"jutsus","element","id"); 
}
else{
$element = "";
}
echo'<div class="auswahl">';
echo '<select name="element" class="Auswahl" size="1">'; 
echo '<option value=""';
if($element == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein Element'; 
echo '</option>'; 
echo '<option value="Suiton"';
if($element == "Suiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Suiton'; 
echo '</option>'; 
echo '<option value="Fuuton"';
if($element == "Fuuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Fuuton'; 
echo '</option>';
echo '<option value="Katon"';
if($element == "Katon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Katon'; 
echo '</option>'; 
echo '<option value="Doton"';
if($element == "Doton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Doton'; 
echo '</option>'; 
echo '<option value="Raiton"';
if($element == "Raiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Raiton'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Lernbar</td>';
echo '<td>';
if($id != ""){
$lehrbar = getwert($id,"jutsus","lehrbar","id"); 
}
else{
$lehrbar = "0";
}
echo'<div class="auswahl">';
echo '<select name="lehrbar" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($lehrbar == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nicht lernbar'; 
echo '</option>'; 
echo '<option value="1"';
if($lehrbar == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Lernbar'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';      
echo '<td>Clan</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$clan = getwert($id,"jutsus","clan","id"); 
}
else{
$clan = "";
}
echo'<div class="auswahl">';
echo '<select name="clan" class="Auswahl" size="1">';   
echo '<option value=""';
if($clan == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein'; 
echo '</option>';
echo '<option value="normal"';
if($clan == "normal"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Normal'; 
echo '</option>';
echo '<option value="kumo"';
if($clan == "kumo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kumo'; 
echo '</option>'; 
echo '<option value="uchiha"';
if($clan == "uchiha"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Uchiha'; 
echo '</option>'; 
echo '<option value="hyuuga"';
if($clan == "hyuuga"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hyuuga'; 
echo '</option>';   
echo '<option value="aburame"';
if($clan == "aburame"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aburame'; 
echo '</option>'; 
echo '<option value="akimichi"';
if($clan == "akimichi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Akimichi'; 
echo '</option>'; 
echo '<option value="inuzuka"';
if($clan == "inuzuka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Inuzuka'; 
echo '</option>';
echo '<option value="kaguya"';
if($clan == "kaguya"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kaguya'; 
echo '</option>'; 
echo '<option value="kugutsu"';
if($clan == "kugutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kugutsu'; 
echo '</option>'; 
echo '<option value="mokuton"';
if($clan == "mokuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Mokuton'; 
echo '</option>'; 
echo '<option value="yuki"';
if($clan == "yuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yuki'; 
echo '</option>'; 
echo '<option value="sand"';
if($clan == "sand"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sand'; 
echo '</option>'; 
echo '<option value="tai"';
if($clan == "tai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Tai'; 
echo '</option>'; 
echo '<option value="youton"';
if($clan == "youton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Youton'; 
echo '</option>';
echo '<option value="nara"';
if($clan == "nara"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nara'; 
echo '</option>';
echo '<option value="shouton"';
if($clan == "shouton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Shouton'; 
echo '</option>'; 
echo '<option value="jiton"';
if($clan == "jiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiton'; 
echo '</option>'; 
echo '<option value="iryonin"';
if($clan == "iryonin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Iryonin'; 
echo '</option>';  
echo '<option value="sumi"';
if($clan == "sumi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sumi'; 
echo '</option>'; 
echo '<option value="kami"';
if($clan == "kami"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kami'; 
echo '</option>';
echo '<option value="schlange"';
if($clan == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>'; 
echo '<option value="frosch"';
if($clan == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';  
echo '<option value="puroresu"';
if($clan == "puroresu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puroresu'; 
echo '</option>';  
echo '<option value="buki"';
if($clan == "buki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Buki'; 
echo '</option>'; 
echo '<option value="jiongu"';
if($clan == "jiongu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiongu'; 
echo '</option>';   
echo '<option value="kibaku nendo"';
if($clan == "kibaku nendo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kibaku Nendo'; 
echo '</option>';     
echo '<option value="kengou"';
if($clan == "kengou"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kengou'; 
echo '</option>';

echo '<option value="sakon"';
if($clan == "sakon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sakon'; 
echo '</option>'; 
echo '<option value="senninka"';
if($clan == "senninka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Senninka'; 
echo '</option>';
echo '<option value="hozuki"';
if($clan == "hozuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hozuki'; 
echo '</option>';   
echo '<option value="kamizuru"';
if($clan == "kamizuru"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kamizuru'; 
echo '</option>';  
echo '<option value="kurama"';
if($clan == "kurama"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kurama'; 
echo '</option>'; 
echo '<option value="yamanaka"';
if($clan == "yamanaka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yamanaka'; 
echo '</option>';  
echo '<option value="ishoku sharingan"';
if($clan == "ishoku sharingan"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ishoku Sharingan'; 
echo '</option>';      
echo '<option value="utakata"';
if($clan == "utakata"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Utakata'; 
echo '</option>';  
echo '<option value="jinchuuriki modoki"';
if($clan == "jinchuuriki modoki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jinchuuriki Modoki'; 
echo '</option>';  
echo '<option value="jashin"';
if($clan == "jashin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jashin'; 
echo '</option>';   
echo '<option value="roku pasu"';
if($clan == "roku pasu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Roku Pasu'; 
echo '</option>'; 
echo '<option value="jinton"';
if($clan == "jinton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'jinton'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>PUcheck</td>';
echo '<td>';
if($id != ""){
$pucheck = getwert($id,"jutsus","pucheck","id"); 
}
else{
$pucheck = "0";
}
echo'<div class="auswahl">';
echo '<select name="pucheck" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($pucheck == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein PU'; 
echo '</option>'; 
echo '<option value="1"';
if($pucheck == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'kombinierbar'; 
echo '</option>';   
echo '<option value="2"';
if($pucheck == "2"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'kombinierbar beschränkt'; 
echo '</option>';   
echo '<option value="3"';
if($pucheck == "3"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'einzel'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>PU benötigt</td>';
echo '<td>';              
if($id != ""){
$puben = getwert($id,"jutsus","puben","id"); 
}
else{
$puben = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="puben" value="'.$puben.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>Gibt Jutsu</td>';
echo '<td>';              
if($id != ""){
$jutsugeb = getwert($id,"jutsus","jutsugeb","id"); 
}
else{
$jutsugeb = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="jutsugeb" value="'.$jutsugeb.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Level</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$level = getwert($id,"jutsus","level","id"); 
}
else{  
$level = "0";
}
echo '<input class="eingabe2" name="level" value="'.$level.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Kombipartner</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    jutsus
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kombipartner" class="Auswahl" size="1">';     
if($id != ""){
$kombipartner = getwert($id,"jutsus","kombipartner","id"); 
}
else{
$kombipartner = ""; 
}                    
echo'<option value="0'; 
if($kombipartner == "0"){
echo '" selected>';            
}
else{
echo '">';
}
echo ' Kein '; 
echo '</option>';  
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kombipartner){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Kombineu</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    jutsus
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kombineu" class="Auswahl" size="1">';     
if($id != ""){
$kombineu = getwert($id,"jutsus","kombineu","id"); 
}
else{
$kombineu = ""; 
}                    
echo'<option value="0'; 
if($kombineu == "0"){
echo '" selected>';            
}
else{
echo '">';
}
echo ' Kein '; 
echo '</option>';  
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kombineu){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Display</td>';
echo '<td>';
if($id != ""){
$sichtbar = getwert($id,"jutsus","sichtbar","id"); 
}
else{
$sichtbar = "0";
}
echo'<div class="auswahl">';
echo '<select name="sichtbar" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($sichtbar == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nicht Sichtbar'; 
echo '</option>'; 
echo '<option value="1"';
if($sichtbar == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sichtbar'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>';        
}
if($was == "items"){ 
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>Name</td>';
echo '<td>';              
if($id != ""){
$name = getwert($id,"items","name","id"); 
}
else{
$name = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="name" value="'.$name.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Bild</td>';
echo '<td>';              
if($id != ""){
$bild = getwert($id,"items","bild","id"); 
}
else{
$bild = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="bild" value="'.$bild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';   
echo '<td>Besitzer</td>';
echo '<td>';  
if($id != ""){
$besitzer = getwert($id,"items","besitzer","id"); 
}
else{
$besitzer = "";
}
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
echo '<select name="besitzer" class="Auswahl" size="1">';  
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $besitzer){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Typ</td>';
echo '<td>';
if($id != ""){
$typ = getwert($id,"items","typ","id"); 
}
else{
$typ = "1";
}
echo'<div class="auswahl">';
echo '<select name="typ" class="Auswahl" size="1">'; 
echo '<option value="1"';
if($typ == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Heilung'; 
echo '</option>'; 
echo '<option value="2"';
if($typ == "2"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Werfbar'; 
echo '</option>';
echo '<option value="3"';
if($typ == "3"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Anlegbar'; 
echo '</option>';
echo '<option value="4"';
if($typ == "4"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Powerup'; 
echo '</option>';  
echo '<option value="5"';
if($typ == "5"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puppe'; 
echo '</option>'; 
echo '<option value="6"';
if($typ == "6"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'überraschung'; 
echo '</option>';  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</tr>';  
echo '<tr align=center>';        
echo '<td>Anlegbar</td>';
echo '<td>';              
if($id != ""){
$anlegbar = getwert($id,"items","anlegbar","id"); 
}
else{
$anlegbar = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="anlegbar" value="'.$anlegbar.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Angelegt</td>';
echo '<td>';              
if($id != ""){
$angelegt = getwert($id,"items","angelegt","id"); 
}
else{
$angelegt = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="angelegt" value="'.$angelegt.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Anzahl</td>';
echo '<td>';              
if($id != ""){
$anzahl = getwert($id,"items","anzahl","id"); 
}
else{
$anzahl = "1";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="anzahl" value="'.$anzahl.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';        
echo '<td>Kampf benutzt</td>';
echo '<td>';              
if($id != ""){
$kbenutzt = getwert($id,"items","kbenutzt","id"); 
}
else{
$kbenutzt = "1";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="kbenutzt" value="'.$kbenutzt.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was == "item"){ 
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>Name</td>';
echo '<td>';              
if($id != ""){
$name = getwert($id,"item","name","id"); 
}
else{
$name = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="name" value="'.$name.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Bild</td>';
echo '<td>';              
if($id != ""){
$bild = getwert($id,"item","bild","id"); 
}
else{
$bild = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="bild" value="'.$bild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Typ</td>';
echo '<td>';
if($id != ""){
$typ = getwert($id,"item","typ","id"); 
}
else{
$typ = "1";
}
echo'<div class="auswahl">';
echo '<select name="typ" class="Auswahl" size="1">'; 
echo '<option value="1"';
if($typ == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Heilung'; 
echo '</option>'; 
echo '<option value="2"';
if($typ == "2"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Werfbar'; 
echo '</option>';
echo '<option value="3"';
if($typ == "3"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Anlegbar'; 
echo '</option>';
echo '<option value="4"';
if($typ == "4"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Powerup'; 
echo '</option>'; 
echo '<option value="5"';
if($typ == "5"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puppe'; 
echo '</option>';   
echo '<option value="6"';
if($typ == "6"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'überraschung'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
if($typ == "1"){
echo '<td>HP<br>Chakra</td>';
}                 
elseif($typ == "2"){
echo '<td>Schaden</td>';
}                  
elseif($typ == "3"){
echo '<td>Kraft<br>Intelligenz<br>Chakrakontrolle<br>Tempo<br>Genauigkeit<br>Widerstand<br>Slots</td>';
}                 
elseif($typ == "4"){
echo '<td>HP<br>Chakra<br>Kraft<br>Intelligenz<br>Chakrakontrolle<br>Tempo<br>Genauigkeit<br>Widerstand</td>';
}                 
elseif($typ == "5"){
echo '<td>NPCname</td>';
}               
elseif($typ == "6"){
echo '<td>Items<br>(oder alle)</td>';
}
echo '<td>';              
if($id != ""){
$werte = getwert($id,"item","werte","id"); 
}
else{
$werte = "HP/DMG;CHAKRA;KR;TMP;INTL;GNK;CHRK;WID";
}                               
$count = 0;
$array = explode(";", trim($werte));
while($array[$count] != ""||$count == 0){
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="werte[]" value="'.$array[$count].'" size="15" maxlength="15" type="text">';
echo '</div>';
$count++;
}
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>Shop</td>';
echo '<td>';
if($id != ""){
$shop = getwert($id,"item","shop","id"); 
}
else{
$shop = "heil";
}
echo'<div class="auswahl">';
echo '<select name="shop" class="Auswahl" size="1">';          
echo '<option value=""';
if($shop == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein Laden'; 
echo '</option>'; 
echo '<option value="heil"';
if($shop == "heil"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Apotheke'; 
echo '</option>'; 
echo '<option value="waffe"';
if($shop == "waffe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Waffenladen'; 
echo '</option>';
echo '<option value="kleidung"';
if($shop == "kleidung"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kleidungsladen'; 
echo '</option>';   
echo '<option value="puppe"';
if($shop == "puppe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puppenladen'; 
echo '</option>';   
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Preis</td>';
echo '<td>';              
if($id != ""){
$preis = getwert($id,"item","preis","id"); 
}
else{
$preis = "";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="preis" value="'.$preis.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Anlegbar</td>';
echo '<td>';              
if($id != ""){
$anlegbar = getwert($id,"item","anlegbar","id"); 
}
else{
$anlegbar = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="anlegbar" value="'.$anlegbar.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Beschreibung</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="beschreibung" maxlength="300000">';
if($id != ""){
$beschreibung = getwert($id,"item","beschreibung","id"); 
}
else{
$beschreibung = "";
}
echo $beschreibung;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';        
echo '<td>Level</td>';
echo '<td>';              
if($id != ""){
$level = getwert($id,"item","level","id"); 
}
else{
$level = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="level" value="'.$level.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';        
echo '<td>In Shop</td>';
echo '<td>';              
if($id != ""){
$inshop = getwert($id,"item","inshop","id"); 
}
else{
$inshop = "0";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="inshop" value="'.$inshop.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';   
echo '<td>Ort</td>';
echo '<td>';       
echo'<div class="auswahl">';
echo '<select name="ort" class="Auswahl" size="1">'; 
if($id != ""){
$ort = getwert($id,"item","ort","id"); 
}
else{
$ort = "0";
}
echo'<option value="';
if($row['id'] == $ort){
echo '" selected>'; 
}
else{     
echo '">';  
echo 'Kein Ort'; 
echo '</option>';

}   
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $ort){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';   
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was == "game"){ 
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';        
echo '<td>onoff</td>';
echo '<td>';              
if($id != ""){
$onoff = getwert($id,"game","onoff","id"); 
}
else{
$onoff = "";
}
echo '<div class="eingabe3">';
echo '<input class="eingabe4" name="onoff" value="'.$onoff.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>tag</td>';
echo '<td>';              
if($id != ""){
$tag = getwert($id,"game","tag","id"); 
}
else{
$tag = "1";
}
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="tag" value="'.$tag.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Modlog</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="modlog" maxlength="300000">';
if($id != ""){
$modlog = getwert($id,"game","modlog","id"); 
}
else{
$modlog = "";
}
echo $modlog;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Adminlog</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="adminlog" maxlength="300000">';
if($id != ""){
$adminlog = getwert($id,"game","adminlog","id"); 
}
else{
$adminlog = "";
}
echo $adminlog;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Handellog</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="handellog" maxlength="300000">';
if($id != ""){
$handellog = getwert($id,"game","handellog","id"); 
}
else{
$handellog = "";
}
echo $handellog;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Registrierung</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="reg" maxlength="300000">';
if($id != ""){
$reg = getwert($id,"game","reg","id"); 
}
else{
$reg = "";
}
echo $reg;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was == "ignoriert"){  
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';   
echo '<td>user</td>';
echo '<td>';  
if($id != ""){
$user2 = getwert($id,"ignoriert","user","id"); 
}
else{
$user2 = "1";
}
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
echo '<select name="user" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $user2){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>ignoriert</td>';
echo '<td>';  
if($id != ""){
$ignoriert = getwert($id,"ignoriert","ignoriert","id"); 
}
else{
$ignoriert = "1";
}
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
echo '<select name="ignoriert" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $ignoriert){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was == "freunde"){  
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';   
echo '<td>An</td>';
echo '<td>';  
if($id != ""){
$an = getwert($id,"freunde","an","id"); 
}
else{
$an = "1";
}
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
echo '<select name="an" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $an){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Von</td>';
echo '<td>';  
if($id != ""){
$von = getwert($id,"freunde","von","id"); 
}
else{
$von = "1";
}
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
echo '<select name="von" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $von){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Akzeptiert</td>';
echo '<td>';
if($id != ""){
$accept = getwert($id,"freunde","accept","id"); 
}
else{
$accept = "0";
}
echo'<div class="auswahl">';
echo '<select name="accept" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($accept == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nicht akzeptiert'; 
echo '</option>'; 
echo '<option value="1"';
if($accept == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Akzeptiert'; 
echo '</option>';    
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was == "fights"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"fights","name","id"); 
}
else{
$name = "";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Runde</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$runde = getwert($id,"fights","runde","id"); 
}
else{
$runde = "1";
}
echo '<input class="eingabe2" name="runde" value="'.$runde.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';     
echo '<td>Teams</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$teams = getwert($id,"fights","teams","id"); 
}
else{
$teams = "1;2";
}
echo '<input class="eingabe2" name="teams" value="'.$teams.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Offen</td>';
echo '<td>';
if($id != ""){
$offen = getwert($id,"fights","offen","id"); 
}
else{
$offen = "0";
}
echo'<div class="auswahl">';
echo '<select name="rank" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($offen == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein Beitritt'; 
echo '</option>'; 
echo '<option value="1"';
if($offen == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Beitritt'; 
echo '</option>';    
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Ende</td>';
echo '<td>';
if($id != ""){
$ende = getwert($id,"fights","ende","id"); 
}
else{
$ende = "0";
}
echo'<div class="auswahl">';
echo '<select name="ende" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($ende == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein Ende'; 
echo '</option>'; 
echo '<option value="1"';
if($ende == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ende'; 
echo '</option>';    
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Mode</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mode = getwert($id,"fights","mode","id"); 
}
else{
$mode = "1vs1";
}
echo '<input class="eingabe2" name="mode" value="'.$mode.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>'; 
echo '<td>Begin</td>';
echo '<td>';
if($id != ""){
$begin = getwert($id,"fights","begin","id"); 
}
else{
$begin = "0";
}
echo'<div class="auswahl">';
echo '<select name="begin" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($begin == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nicht begonnen'; 
echo '</option>'; 
echo '<option value="1"';
if($begin == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Begonnen'; 
echo '</option>';    
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';    

echo '<tr align=center>'; 
echo '<td>Art</td>';
echo '<td>';
if($id != ""){
$art = getwert($id,"fights","art","id"); 
}
else{
$art = "Normal";
}
echo'<div class="auswahl">';
echo '<select name="art" class="Auswahl" size="1">'; 
echo '<option value="Normal"';
if($art == "Normal"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Normal'; 
echo '</option>'; 
echo '<option value="Spaß"';
if($art == "Spaß"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Spaß'; 
echo '</option>';  
echo '<option value="Mission"';
if($art == "Mission"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Mission'; 
echo '</option>';   
echo '<option value="Eroberung"';
if($art == "Eroberung"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Eroberung'; 
echo '</option>'; 
echo '<option value="Bijuu"';
if($art == "Bijuu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Bijuu'; 
echo '</option>';   
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Passwort</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$pass = getwert($id,"fights","pw","id"); 
}
else{
$pass = "";
}
echo '<input class="eingabe2" name="pw" value="'.$pass.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';      
echo '<tr align=center>'; 
echo '<td>Log</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="log" maxlength="300000">';

if($id != ""){
$log = getwert($id,"fights","log","id"); 
}
else{
$log = "";
}
echo $log;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Spieler</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="spieler" maxlength="300000">';

if($id != ""){
$spieler = getwert($id,"fights","spieler","id"); 
}
else{
$spieler = "";
}
echo $spieler;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';   
echo '<td>Ort</td>';
echo '<td>';  
if($id != ""){
$ort = getwert($id,"fights","ort","id"); 
}
else{
$ort = "1";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="ort" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $ort){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Mission</td>';
echo '<td>';  
if($id != ""){
$mission = getwert($id,"fights","mission","id"); 
}
else{
$mission = "";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    missions
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="mission" class="Auswahl" size="1">';  
echo'<option value="';
echo '">';
echo ' Keine '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $mission){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Wetter</td>';
echo '<td>';
if($id != ""){
$wetter = getwert($id,"fights","wetter","id"); 
}
else{
$wetter = "Sonne";
}
echo'<div class="auswahl">';
echo '<select name="wetter" class="Auswahl" size="1">'; 
echo '<option value="Sonne"';
if($wetter == "Sonne"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sonne'; 
echo '</option>'; 
echo '<option value="Regen"';
if($wetter == "Regen"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Regen'; 
echo '</option>'; 
echo '<option value="Gewitter"';
if($wetter == "Gewitter"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Gewitter'; 
echo '</option>'; 
echo '<option value="Hitze"';
if($wetter == "Hitze"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hitze'; 
echo '</option>'; 
echo '<option value="Sturm"';
if($wetter == "Sturm"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sturm'; 
echo '</option>'; 
echo '<option value="Erdrutsch"';
if($wetter == "Erdrutsch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Erdrutsch'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';         
echo '<tr align=center>';     
echo '<td>Regeln</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$regeln = getwert($id,"fights","regeln","id"); 
}
else{
$regeln = "";
}
echo '<input class="eingabe2" name="regeln" value="'.$regeln.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 

}
if($was =="charaktere"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';   
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';      
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"charaktere","name","id"); 
}
else{
$name = "Name";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Kampfname</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kname = getwert($id,"charaktere","kname","id"); 
}
else{
$kname = "Kampfname";
}
echo '<input class="eingabe2" name="kname" value="'.$kname.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Level</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$level = getwert($id,"charaktere","level","id"); 
}
else{
$level = "1";
}
echo '<input class="eingabe2" name="level" value="'.$level.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';    
echo '<td>Platz</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$platz = getwert($id,"charaktere","platz","id"); 
}
else{
$platz = "0";
}
echo '<input class="eingabe2" name="platz" value="'.$platz.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';      
echo '<td>Clan</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$clan = getwert($id,"charaktere","clan","id"); 
}
else{
$clan = "Clan";
}
echo'<div class="auswahl">';
echo '<select name="clan" class="Auswahl" size="1">'; 
echo '<option value="normal"';
if($clan == "normal"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Normal'; 
echo '</option>';
echo '<option value="kumo"';
if($clan == "kumo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kumo'; 
echo '</option>'; 
echo '<option value="uchiha"';
if($clan == "uchiha"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Uchiha'; 
echo '</option>'; 
echo '<option value="hyuuga"';
if($clan == "hyuuga"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hyuuga'; 
echo '</option>';  
echo '<option value="aburame"';
if($clan == "aburame"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aburame'; 
echo '</option>'; 
echo '<option value="akimichi"';
if($clan == "akimichi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Akimichi'; 
echo '</option>'; 
echo '<option value="inuzuka"';
if($clan == "inuzuka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Inuzuka'; 
echo '</option>';
echo '<option value="kaguya"';
if($clan == "kaguya"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kaguya'; 
echo '</option>'; 
echo '<option value="kugutsu"';
if($clan == "kugutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kugutsu'; 
echo '</option>'; 
echo '<option value="mokuton"';
if($clan == "mokuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Mokuton'; 
echo '</option>'; 
echo '<option value="yuki"';
if($clan == "yuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yuki'; 
echo '</option>'; 
echo '<option value="sand"';
if($clan == "sand"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sand'; 
echo '</option>'; 
echo '<option value="tai"';
if($clan == "tai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Tai'; 
echo '</option>'; 
echo '<option value="youton"';
if($clan == "youton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Youton'; 
echo '</option>';
echo '<option value="nara"';
if($clan == "nara"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nara'; 
echo '</option>';
echo '<option value="shouton"';
if($clan == "shouton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Shouton'; 
echo '</option>';    
echo '<option value="jiton"';
if($clan == "jiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiton'; 
echo '</option>'; 
echo '<option value="iryonin"';
if($clan == "iryonin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Iryonin'; 
echo '</option>';  
echo '<option value="sumi"';
if($clan == "sumi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sumi'; 
echo '</option>'; 
echo '<option value="kami"';
if($clan == "kami"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kami'; 
echo '</option>';
echo '<option value="schlange"';
if($clan == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>'; 
echo '<option value="frosch"';
if($clan == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';  
echo '<option value="puroresu"';
if($clan == "puroresu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puroresu'; 
echo '</option>';  
echo '<option value="buki"';
if($clan == "buki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Buki'; 
echo '</option>'; 
echo '<option value="jiongu"';
if($clan == "jiongu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiongu'; 
echo '</option>';   
echo '<option value="kibaku nendo"';
if($clan == "kibaku nendo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kibaku Nendo'; 
echo '</option>';     
echo '<option value="kengou"';
if($clan == "kengou"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kengou'; 
echo '</option>';   
echo '<option value="admin"';
if($clan == "admin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Admin'; 
echo '</option>';

echo '<option value="sakon"';
if($clan == "sakon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sakon'; 
echo '</option>'; 
echo '<option value="senninka"';
if($clan == "senninka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Senninka'; 
echo '</option>';
echo '<option value="hozuki"';
if($clan == "hozuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hozuki'; 
echo '</option>';   
echo '<option value="kamizuru"';
if($clan == "kamizuru"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kamizuru'; 
echo '</option>';  
echo '<option value="kurama"';
if($clan == "kurama"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kurama'; 
echo '</option>'; 
echo '<option value="yamanaka"';
if($clan == "yamanaka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yamanaka'; 
echo '</option>';  
echo '<option value="ishoku sharingan"';
if($clan == "ishoku sharingan"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ishoku Sharingan'; 
echo '</option>';      
echo '<option value="utakata"';
if($clan == "utakata"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Utakata'; 
echo '</option>';  
echo '<option value="jinchuuriki modoki"';
if($clan == "jinchuuriki modoki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jinchuuriki Modoki'; 
echo '</option>';  
echo '<option value="jashin"';
if($clan == "jashin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jashin'; 
echo '</option>';   
echo '<option value="roku pasu"';
if($clan == "roku pasu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Roku Pasu'; 
echo '</option>';    
echo '<option value="jinton"';
if($clan == "jinton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'jinton'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Dorf</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name,
    was
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="dorf" class="Auswahl" size="1">';     
if($id != ""){
$dorf = getwert($id,"charaktere","dorf","id"); 
}
else{
$dorf = 1; 
}
while ($row = $result->fetch_assoc() ) {    
if($row['was'] == "dorf"&&$row['name'] != "versteck"||$row['name'] == "Admin Center"){ 
echo'<option value="';
echo $row['id'];
if($row['id'] == $dorf){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}
}                 
$result->close(); $db->close();  
echo'<option value="';
echo 'kein';
if($dorf == "kein"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kein'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Ort</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name,
    was
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="ort" class="Auswahl" size="1">';     
if($id != ""){
$ort = getwert($id,"charaktere","ort","id"); 
}
else{
$ort = 1; 
}
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $ort){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Rank</td>';
echo '<td>';
if($id != ""){
$rank = getwert($id,"charaktere","rank","id"); 
}
else{
$rank = "Student";
}
echo'<div class="auswahl">';
echo '<select name="rank" class="Auswahl" size="1">'; 
echo '<option value="student"';
if($rank == "student"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Student'; 
echo '</option>'; 
echo '<option value="genin"';
if($rank == "genin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Genin'; 
echo '</option>';  
echo '<option value="chuunin"';
if($rank == "chuunin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Chuunin'; 
echo '</option>'; 
echo '<option value="jounin"';
if($rank == "jounin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jounin'; 
echo '</option>';  
echo '<option value="anbu"';
if($rank == "anbu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Anbu'; 
echo '</option>'; 
echo '<option value="kage"';
if($rank == "kage"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kage'; 
echo '</option>';
echo '<option value="nuke-nin"';
if($rank == "nuke-nin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nuke-nin'; 
echo '</option>';
echo '<option value="admin"';
if($rank == "admin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Admin'; 
echo '</option>';  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';         
echo '<tr align=center>';     
echo '<td>Ryo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$ryo = getwert($id,"charaktere","ryo","id"); 
}
else{
$ryo = 10000;
}
echo '<input class="eingabe2" name="ryo" value="'.$ryo.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>Anmeldedatum</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$anmeldedatum = getwert($id,"charaktere","anmeldedatum","id"); 
}
else{
$anmeldedatum = time(); 
$anmeldedatum = date("Y-m-d H:i:s",$anmeldedatum);
}
echo '<input class="eingabe2" name="anmeldedatum" value="'.$anmeldedatum.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>HP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$hp = getwert($id,"charaktere","hp","id"); 
}
else{
$hp = 100;
}
echo '<input class="eingabe2" name="hp" value="'.$hp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>MHP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mhp = getwert($id,"charaktere","mhp","id"); 
}
else{
$mhp = 100;
}
echo '<input class="eingabe2" name="mhp" value="'.$mhp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Chakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chakra = getwert($id,"charaktere","chakra","id"); 
}
else{
$chakra = 100;
}
echo '<input class="eingabe2" name="chakra" value="'.$chakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>MChakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mchakra = getwert($id,"charaktere","mchakra","id"); 
}
else{
$mchakra = 100;
}
echo '<input class="eingabe2" name="mchakra" value="'.$mchakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>EXP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$exp = getwert($id,"charaktere","exp","id"); 
}
else{
$exp = 0;
}
echo '<input class="eingabe2" name="exp" value="'.$exp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>MEXP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mexp = getwert($id,"charaktere","mexp","id"); 
}
else{
$mexp = 100;
}
echo '<input class="eingabe2" name="mexp" value="'.$mexp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Session</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$session = getwert($id,"charaktere","session","id"); 
}
else{
$session = "";
}
echo '<input class="eingabe4" name="session" value="'.$session.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>IP</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$ip = getwert($id,"charaktere","ip","id"); 
}
else{
$ip = "IP";
}
echo '<input class="eingabe2" name="ip" value="'.$ip.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Geschlecht</td>';
echo '<td>';
if($id != ""){
$geschlecht = getwert($id,"charaktere","geschlecht","id"); 
}
else{
$geschlecht = "männlich";
}
echo'<div class="auswahl">';
echo '<select name="geschlecht" class="Auswahl" size="1">'; 
echo '<option value="männlich"';
if($geschlecht == "männlich"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'männlich'; 
echo '</option>'; 
echo '<option value="weiblich"';
if($geschlecht == "weiblich"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Weiblich'; 
echo '</option>';                     
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Bild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$bild = getwert($id,"charaktere","bild","id"); 
}
else{
$bild = "Bild";
}
echo '<input class="eingabe4" name="bild" value="'.$bild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';        
echo '<td>Kampfbild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$kbild = getwert($id,"charaktere","kbild","id"); 
}
else{
$kbild = "KampfBild";
}
echo '<input class="eingabe4" name="kbild" value="'.$kbild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';  
echo '<td>kkBild</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$kkbild = getwert($id,"charaktere","kkbild","id"); 
}
else{
$kkbild = "KampfKampfBild";
}
echo '<input class="eingabe4" name="kkbild" value="'.$kkbild.'" size="15" maxlength="90" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>did</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$did = getwert($id,"charaktere","did","id"); 
}
else{
$did = time(); 
$did = date("Y-m-d H:i:s",$did);
}
echo '<input class="eingabe2" name="did" value="'.$did.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';      
echo '<td>Kraft</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kr = getwert($id,"charaktere","kr","id"); 
}
else{
$kr = "10";
}
echo '<input class="eingabe2" name="kr" value="'.$kr.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>MKraft</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mkr = getwert($id,"charaktere","mkr","id"); 
}
else{
$mkr = "10";
}
echo '<input class="eingabe2" name="mkr" value="'.$mkr.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td>Intelligenz</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$intl = getwert($id,"charaktere","intl","id"); 
}
else{
$intl = "10";
}
echo '<input class="eingabe2" name="intl" value="'.$intl.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MIntelligenz</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mintl = getwert($id,"charaktere","mintl","id"); 
}
else{
$mintl = "10";
}
echo '<input class="eingabe2" name="mintl" value="'.$mintl.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Chakrakontrolle</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$chrk = getwert($id,"charaktere","chrk","id"); 
}
else{
$chrk = "10";
}
echo '<input class="eingabe2" name="chrk" value="'.$chrk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MChakrakontrolle</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mchrk = getwert($id,"charaktere","mchrk","id"); 
}
else{
$mchrk = "10";
}
echo '<input class="eingabe2" name="mchrk" value="'.$mchrk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Tempo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$tmp = getwert($id,"charaktere","tmp","id"); 
}
else{
$tmp = "10";
}
echo '<input class="eingabe2" name="tmp" value="'.$tmp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MTempo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mtmp = getwert($id,"charaktere","mtmp","id"); 
}
else{
$mtmp = "10";
}
echo '<input class="eingabe2" name="mtmp" value="'.$mtmp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Genauigkeit</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$gnk = getwert($id,"charaktere","gnk","id"); 
}
else{
$gnk = "10";
}
echo '<input class="eingabe2" name="gnk" value="'.$gnk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MGenauigkeit</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mgnk = getwert($id,"charaktere","mgnk","id"); 
}
else{
$mgnk = "10";
}
echo '<input class="eingabe2" name="mgnk" value="'.$mgnk.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Widerstand</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$wid = getwert($id,"charaktere","wid","id"); 
}
else{
$wid = "10";
}
echo '<input class="eingabe2" name="wid" value="'.$wid.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>MWiderstand</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mwid = getwert($id,"charaktere","mwid","id"); 
}
else{
$mwid = "10";
}
echo '<input class="eingabe2" name="mwid" value="'.$mwid.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Team (Kampf)</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$team = getwert($id,"charaktere","team","id"); 
}
else{
$team = "0";
}
echo '<input class="eingabe2" name="team" value="'.$team.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Kampfid</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    fights
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kampfid" class="Auswahl" size="1">';     
if($id != ""){
$kampfid = getwert($id,"charaktere","kampfid","id"); 
}
else{
$kampfid = "0"; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kampfid){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Alte Kampfid</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    fights
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kido" class="Auswahl" size="1">';     
if($id != ""){
$kido = getwert($id,"charaktere","kido","id"); 
}
else{
$kido = "0"; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kido){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Kampf Aktion</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    jutsus
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kaktion" class="Auswahl" size="1">';     
if($id != ""){
$kaktion = getwert($id,"charaktere","kaktion","id"); 
}
else{
$kaktion = ""; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';  
echo'<option value="';
echo 'Zufall';
if($kaktion == "Zufall"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Zufall'; 
echo '</option>'; 
echo'<option value="';
echo 'Besiegt';
if($kaktion == "Besiegt"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Besiegt'; 
echo '</option>';     
echo'<option value="';
echo 'Kombi';
if($kaktion == "Kombi"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kombi'; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kaktion){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>LastkAktion</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$lkaktion = getwert($id,"charaktere","lkaktion","id"); 
}
else{
$lkaktion = time(); 
$lkaktion = date("Y-m-d H:i:s",$lkaktion);
}
echo '<input class="eingabe2" name="lkaktion" value="'.$lkaktion.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';       
echo '<tr align=center>';       
echo '<td>Kampf Ziel</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kziel = getwert($id,"charaktere","kziel","id"); 
}
else{
$kziel = "0";
}
echo '<input class="eingabe2" name="kziel" value="'.$kziel.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Kampf Ziel wo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kzwo = getwert($id,"charaktere","kzwo","id"); 
}
else{
$kzwo = "charaktere";
}
echo '<input class="eingabe2" name="kzwo" value="'.$kzwo.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';       
echo '<td>Kampf Chakra add</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kchadd = getwert($id,"charaktere","kchadd","id"); 
}
else{
$kchadd = "0";
}
echo '<input class="eingabe2" name="kchadd" value="'.$kchadd.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';       
echo '<td>Kampf was</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kwas = getwert($id,"charaktere","kwas","id"); 
}
else{
$kwas = "0";
}
echo '<input class="eingabe2" name="kwas" value="'.$kwas.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Kampf Kreuz Ziel</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$ktarget = getwert($id,"charaktere","ktarget","id"); 
}
else{
$ktarget = "0";
}
echo '<input class="eingabe2" name="ktarget" value="'.$ktarget.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Kampf Kreuz Wo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$ktargetwo = getwert($id,"charaktere","ktargetwo","id"); 
}
else{
$ktargetwo = "charaktere";
}
echo '<input class="eingabe2" name="ktargetwo" value="'.$ktargetwo.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Spaßkampfhp</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$shp = getwert($id,"charaktere","shp","id"); 
}
else{
$shp = "0";
}
echo '<input class="eingabe2" name="shp" value="'.$shp.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';  
echo '<td>Spaßkampfchakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$schakra = getwert($id,"charaktere","schakra","id"); 
}
else{
$schakra = "0";
}
echo '<input class="eingabe2" name="schakra" value="'.$schakra.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align="center">';
echo '<td>Jutsus</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$jutsus = getwert($id,"charaktere","jutsus","id"); 
}
else{
$jutsus = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    bild,
    name
FROM
    jutsus
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($tint == 6){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($jutsus));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}   
echo '<a class="sinfo">';  
echo '<span class="spanmap">'.$row['name'].'</span>';   
if($hat == 1){
echo '<img src="bilder/jutsus/'.$row['bild'].'h.png" width="60px" height="60px"></img>';
}
if($hat == 0){
echo '<img src="bilder/jutsus/'.$row['bild'].'.png" width="50px" height="50px"></img>';
}         
echo '</a>';            
echo '<br>';
echo '<input type="checkbox" name="jutsus[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';   
echo '<tr align="center">';
echo '<td>Kampfbutton</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$kbutton = getwert($id,"charaktere","kbutton","id"); 
}
else{
$kbutton = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    bild,
    name
FROM
    jutsus
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($tint == 6){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($kbutton));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}    
echo '<a class="sinfo">';  
echo '<span class="spanmap">'.$row['name'].'</span>';   
if($hat == 1){
echo '<img src="bilder/jutsus/'.$row['bild'].'h.png" width="60px" height="60px"></img>';
}
if($hat == 0){
echo '<img src="bilder/jutsus/'.$row['bild'].'.png" width="50px" height="50px"></img>';
}         
echo '</a>';
echo '<br>';
echo '<input type="checkbox" name="kbutton[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Text</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="ptext" maxlength="300000">';

if($id != ""){
$ptext = getwert($id,"charaktere","ptext","id"); 
}
else{
$ptext = "";
}
echo $ptext;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Design</td>';
echo '<td>';
if($id != ""){
$design = getwert($id,"charaktere","design","id"); 
}
else{
$design = "naruto";
}
echo'<div class="auswahl">';
echo '<select name="design" class="Auswahl" size="1">'; 
echo '<option value="naruto"';
if($design == "naruto"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Naruto'; 
echo '</option>'; 
echo '<option value="sasuke"';
if($design == "sasuke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sasuke'; 
echo '</option>';  
echo '<option value="rocklee"';
if($design == "rocklee"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Rock Lee'; 
echo '</option>';
echo '<option value="akatsuki"';
if($design == "akatsuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Akatsuki'; 
echo '</option>';  
echo '<option value="sakura"';
if($design == "sakura"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sakura'; 
echo '</option>';  
echo '<option value="chidori"';
if($design == "chidori"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Chidori'; 
echo '</option>';
echo '<option value="gaara"';
if($design == "gaara"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Gaara'; 
echo '</option>';  
echo '<option value="kisame"';
if($design == "kisame"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kisame'; 
echo '</option>'; 
echo '<option value="neji"';
if($design == "neji"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Neji'; 
echo '</option>';  
echo '<option value="aburame"';
if($design == "aburame"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aburame'; 
echo '</option>';          
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Mission</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    missions
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="mission" class="Auswahl" size="1">';     
if($id != ""){
$mission = getwert($id,"charaktere","mission","id"); 
}
else{
$mission = ""; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $mission){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Mission wo</td>';
echo '<td>';
if($mission != ""){
$mwo = getwert($id,"charaktere","mwo","id"); 
$mwox = getwert($mission,"missions","punkte","id"); 
}
else{
$mwo = 0;
$mwox = 10;
}                 
echo'<div class="auswahl">';
echo '<select name="mwo" class="Auswahl" size="1">'; 
$count = 0;
while($count <= $mwox){
echo '<option value="'.$count.'"';
if($mwo == $count){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo $count; 
echo '</option>'; 
$count++;
}                
echo '</select>'; 
echo '</div>';      
echo '</td>';
echo '</tr>';         
echo '<tr align=center>'; 
echo '<td>Map Charakter</td>';
echo '<td>';              
if($id != ""){
$mapc = getwert($id,"charaktere","mapc","id"); 
}
else{
$mapc = "1"; 
}   
echo'<div class="auswahl">';
echo '<select name="mapc" class="Auswahl" size="1">'; 
echo '<option value="1"';
if($mapc == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo "Naruto"; 
echo '</option>'; 
echo '<option value="2"';
if($mapc == "2"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo "Sakura"; 
echo '</option>';  
echo '<option value="3"';
if($mapc == "3"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo "Sasuke"; 
echo '</option>'; 
echo '</option>';  
echo '<option value="4"';
if($mapc == "4"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo "Gaara"; 
echo '</option>'; 
echo '</option>';  
echo '<option value="5"';
if($mapc == "5"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo "Kakashi"; 
echo '</option>';  
echo '</option>';  
echo '<option value="6"';
if($mapc == "6"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo "Hinata"; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';      
echo '</td>';
echo '</tr>';
echo '<tr align=center>';       
echo '<td>Reise</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$reise = getwert($id,"charaktere","reise","id"); 
}
else{
$reise = "0";
}
echo '<input class="eingabe4" name="reise" value="'.$reise.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Reise wo</td>';
echo '<td>';
if($reise != ""){
$rwo = getwert($id,"charaktere","rwo","id"); 
$rwox = getwert($ort,"orte","rdauer","id"); 
}
else{
$rwo = 0;
$rwox = 6;
}                 
echo'<div class="auswahl">';
echo '<select name="rwo" class="Auswahl" size="1">'; 
$count = 0;
while($count != $rwox){
echo '<option value="'.$count.'"';
if($rwo == $count){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo $count; 
echo '</option>'; 
$count++;
}                
echo '</select>'; 
echo '</div>';      
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Reise weg</td>';
echo '<td>';
if($id != ""){
$rweg = getwert($id,"charaktere","rweg","id"); 
}
else{
$rweg = "";
}
echo'<div class="auswahl">';
echo '<select name="rweg" class="Auswahl" size="1">'; 
echo '<option value=""';
if($rweg == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Nichts '; 
echo '</option>'; 
echo '<option value="weiter"';
if($rweg == "weiter"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'weiter'; 
echo '</option>'; 
echo '<option value="back"';
if($rweg == "back"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Zurück'; 
echo '</option>';                     
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Reise NPC</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    npc
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="reisenpc" class="Auswahl" size="1">';     
if($id != ""){
$reisenpc = getwert($id,"charaktere","reisenpc","id"); 
}
else{
$reisenpc = "0"; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $reisenpc){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Reise Item</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    item
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="reiseitem" class="Auswahl" size="1">';     
if($id != ""){
$reiseitem = getwert($id,"charaktere","reiseitem","id"); 
}
else{
$reiseitem = "0"; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $reiseitem){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';       
echo '<td>Reise Item Anzahl</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$reiseianzahl = getwert($id,"charaktere","reiseianzahl","id"); 
}
else{
$reiseianzahl = "0";
}
echo '<input class="eingabe4" name="reiseianzahl" value="'.$reiseianzahl.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Aktion</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$aktion = getwert($id,"charaktere","aktion","id"); 
}
else{
$aktion = "";
}
echo '<input class="eingabe4" name="aktion" value="'.$aktion.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Aktionstart</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$aktions = getwert($id,"charaktere","aktions","id"); 
}
else{
$aktions = time(); 
$aktions = date("Y-m-d H:i:s",$aktions);
}
echo '<input class="eingabe2" name="aktions" value="'.$aktions.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Aktiondauer</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$aktiond = getwert($id,"charaktere","aktiond","id"); 
}
else{
$aktiond = "0";
}
echo '<input class="eingabe2" name="aktiond" value="'.$aktiond.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>KriegAktion</td>';
echo '<td>';
echo '<div class="eingabe3">'; 
if($id != ""){
$kriegaktion = getwert($id,"charaktere","kriegaktion","id"); 
}
else{
$kriegaktion = "";
}
echo '<input class="eingabe4" name="kriegaktion" value="'.$kriegaktion.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>KriegAktionstart</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kriegaktions = getwert($id,"charaktere","kriegaktions","id"); 
}
else{
$kriegaktions = time(); 
$kriegaktions = date("Y-m-d H:i:s",$kriegaktions);
}
echo '<input class="eingabe2" name="kriegaktions" value="'.$kriegaktions.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>KriegAktiondauer</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kriegaktiond = getwert($id,"charaktere","kriegaktiond","id"); 
}
else{
$kriegaktiond = "0";
}
echo '<input class="eingabe2" name="kriegaktiond" value="'.$kriegaktiond.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';    
echo '<td>Admin</td>';
echo '<td>';
if($id != ""){
$admin = getwert($id,"charaktere","admin","id"); 
}
else{
$admin = "0";
}
echo'<div class="auswahl">';
echo '<select name="admin" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($admin == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Kein Admin '; 
echo '</option>'; 
echo '<option value="1"';
if($admin == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Moderator'; 
echo '</option>'; 
echo '<option value="2"';
if($admin == "2"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'S-Moderator'; 
echo '</option>';
echo '</option>'; 
echo '<option value="3"';
if($admin == "3"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Admin'; 
echo '</option>';                     
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Vertrag</td>';
echo '<td>';
if($id != ""){
$vertrag = getwert($id,"charaktere","vertrag","id"); 
}
else{
$vertrag = "";
}
echo'<div class="auswahl">';
echo '<select name="vertrag" class="Auswahl" size="1">'; 
echo '<option value=""';
if($vertrag == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo ' Kein Vertrag '; 
echo '</option>'; 
echo '<option value="frosch"';
if($vertrag == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';       
echo '<option value="spinne"';
if($vertrag == "spinne"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Spinne'; 
echo '</option>'; 
echo '<option value="schlange"';
if($vertrag == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>';
echo '<option value="schnecke"';
if($vertrag == "schnecke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schnecke'; 
echo '</option>';
echo '<option value="eule"';
if($vertrag == "eule"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Eule'; 
echo '</option>';    
echo '<option value="dämon"';
if($vertrag == "dämon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'dämonen'; 
echo '</option>';  
echo '<option value="krähe"';
if($vertrag == "krähe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'krähen'; 
echo '</option>';  
echo '<option value="affe"';
if($vertrag == "affe"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Affen'; 
echo '</option>';  
echo '<option value="hai"';
if($vertrag == "hai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Haie'; 
echo '</option>';  
echo '<option value="falke"';
if($vertrag == "falke"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Falken'; 
echo '</option>';   
echo '<option value="salamander"';
if($vertrag == "salamander"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Salamander'; 
echo '</option>'; 
echo '<option value="ninken"';
if($vertrag == "ninken"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ninken'; 
echo '</option>';   
echo '<option value="bienen"';
if($vertrag == "bienen"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Bienen'; 
echo '</option>';                        
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align="center">';
echo '<td>Powerup</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$powerup = getwert($id,"charaktere","powerup","id"); 
}
else{
$powerup = "";
}                 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    bild,
    art,
    name
FROM
    jutsus
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
while ($row = $result->fetch_assoc() ) {      
if($row['art'] == 6||$row['art'] == 9){  
if($tint == 6){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($powerup));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $row['id']){
$hat = 1;
}
$count++;
}    
echo '<a class="sinfo">';  
echo '<span class="spanmap">'.$row['name'].'</span>';   
if($hat == 1){
echo '<img src="bilder/jutsus/'.$row['bild'].'h.png" width="60px" height="60px"></img>';
}
if($hat == 0){
echo '<img src="bilder/jutsus/'.$row['bild'].'.png" width="50px" height="50px"></img>';
}         
echo '</a>';
echo '<br>';
echo '<input type="checkbox" name="powerup[]" value="'.$row['id'].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
}
}                 
$result->close(); $db->close();  
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Debuff</td>';
echo '<td>';
if($id != ""){
$debuff = getwert($id,"charaktere","debuff","id"); 
}
else{
$debuff = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="debuff" maxlength="300000">';
echo $debuff;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';       
echo '<td>Dstats 0;0;0;0;0;0 (KR-WID)</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$dstats = getwert($id,"charaktere","dstats","id"); 
}
else{
$dstats = "";
}
echo '<input class="eingabe2" name="dstats" value="'.$dstats.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';       
echo '<td>Theme</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$theme = getwert($id,"charaktere","theme","id"); 
}
else{
$theme = "";
}
echo '<input class="eingabe2" name="theme" value="'.$theme.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';                 
echo '<tr align=center>';    
echo '<td>Autoplay</td>';
echo '<td>';
if($id != ""){
$autoplay = getwert($id,"charaktere","autoplay","id"); 
}
else{
$autoplay = "0";
}
echo'<div class="auswahl">';
echo '<select name="autoplay" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($autoplay == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Deaktiviert'; 
echo '</option>'; 
echo '<option value="1"';
if($autoplay == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aktiviert'; 
echo '</option>';                      
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';    
echo '<td>Chat</td>';
echo '<td>';
if($id != ""){
$chat = getwert($id,"charaktere","chat","id"); 
}
else{
$chat = "0";
}
echo'<div class="auswahl">';
echo '<select name="chat" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($chat == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Deaktiviert'; 
echo '</option>'; 
echo '<option value="1"';
if($chat == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aktiviert'; 
echo '</option>';                      
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';             
echo '<tr align=center>';    
echo '<td>Admin drin</td>';
echo '<td>';
if($id != ""){
$adminin = getwert($id,"charaktere","adminin","id"); 
}
else{
$adminin = "0";
}
echo'<div class="auswahl">';
echo '<select name="adminin" class="Auswahl" size="1">'; 
echo '<option value="0"';
if($chat == "0"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nicht drin'; 
echo '</option>'; 
echo '<option value="1"';
if($adminin == "1"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'drin'; 
echo '</option>';                      
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align="center">';
echo '<td>Elemente</td>';
echo '<td>';
echo '<table>';
echo '<tr>';
$tint = 0;   
if($id != ""){
$elemente = getwert($id,"charaktere","elemente","id"); 
}
else{
$elemente = "";
}                 
$elemente2 = "Katon;Suiton;Doton;Fuuton;Raiton";   
$array2 = explode(";", trim($elemente2));
$count2 = 0;
while($array2[$count2] != ""){
if($tint == 5){
echo '</tr>';
echo '<tr>';
$tint = 0;
}         
$tint++;
echo '<td>';
$array = explode(";", trim($elemente));
$count = 0;          
$hat = 0;
while(isset($array[$count])){       
if($array[$count] == $array2[$count2]){
$hat = 1;
}
$count++;
}
echo $array2[$count2];
echo '<br>';
echo '<input type="checkbox" name="elemente[]" value="'.$array2[$count2].'"';
if($hat == 1){
echo 'checked';
}
echo ">";
echo '</td>';
$count2++;
}
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';   
echo '<td>Statspunkte</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$statspunkte = getwert($id,"charaktere","statspunkte","id"); 
}
else{
$statspunkte = "0";
}
echo '<input class="eingabe2" name="statspunkte" value="'.$statspunkte.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';      
echo '<tr align=center>';   
echo '<td>Story</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$story = getwert($id,"charaktere","story","id"); 
}
else{
$story = "0";
}
echo '<input class="eingabe2" name="story" value="'.$story.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Clan Story</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$cstory = getwert($id,"charaktere","cstory","id"); 
}
else{
$cstory = "0";
}
echo '<input class="eingabe2" name="cstory" value="'.$cstory.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>D-Missionen</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$dmissi = getwert($id,"charaktere","dmissi","id"); 
}
else{
$dmissi = "";
}
echo '<input class="eingabe2" name="dmissi" value="'.$dmissi.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>C-Missionen</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$cmissi = getwert($id,"charaktere","cmissi","id"); 
}
else{
$cmissi = "";
}
echo '<input class="eingabe2" name="cmissi" value="'.$cmissi.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>B-Missionen</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$bmissi = getwert($id,"charaktere","bmissi","id"); 
}
else{
$bmissi = "";
}
echo '<input class="eingabe2" name="bmissi" value="'.$bmissi.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>A-Missionen</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$amissi = getwert($id,"charaktere","amissi","id"); 
}
else{
$amissi = "";
}
echo '<input class="eingabe2" name="amissi" value="'.$amissi.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>S-Missionen</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$smissi = getwert($id,"charaktere","smissi","id"); 
}
else{
$smissi = "";
}
echo '<input class="eingabe2" name="smissi" value="'.$smissi.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';    
echo '<tr align=center>';   
echo '<td>Kriminalität</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$mmissi = getwert($id,"charaktere","mmissi","id"); 
}
else{
$mmissi = "";
}
echo '<input class="eingabe2" name="mmissi" value="'.$mmissi.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Org/Team</td>';
echo '<td>'; 
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
echo'<div class="auswahl">';
echo '<select name="org" class="Auswahl" size="1">';     
if($id != ""){
$org = getwert($id,"charaktere","org","id"); 
}
else{
$org = ""; 
}               
echo '<option value="0">';
echo 'Leer'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $org){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Orgrank</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$orank = getwert($id,"charaktere","orank","id"); 
}
else{
$orank = "";
}
echo '<input class="eingabe2" name="orank" value="'.$orank.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>oApply</td>';
echo '<td>'; 
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
echo'<div class="auswahl">';
echo '<select name="oapply" class="Auswahl" size="1">';     
if($id != ""){
$oapply = getwert($id,"charaktere","oapply","id"); 
}
else{
$oapply = ""; 
}               
echo '<option value="0">';
echo 'Leer'; 
echo '</option>';    
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $oapply){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>'; 
echo '<td>Turnier</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    turnier
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="turnier" class="Auswahl" size="1">';     
if($id != ""){
$turnier = getwert($id,"charaktere","turnier","id"); 
}
else{
$turnier = ""; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $turnier){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Turnierblock</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$two = getwert($id,"charaktere","two","id"); 
}
else{
$two = "";
}
echo '<input class="eingabe2" name="two" value="'.$two.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Turnierrunde</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$trunde = getwert($id,"charaktere","trunde","id"); 
}
else{
$trunde = "";
}
echo '<input class="eingabe2" name="trunde" value="'.$trunde.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Tutorial</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$tutorial = getwert($id,"charaktere","tutorial","id"); 
}
else{
$tutorial = "0";
}
echo '<input class="eingabe2" name="tutorial" value="'.$tutorial.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>kwo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kwo = getwert($id,"charaktere","kwo","id"); 
}
else{
$kwo = "0";
}
echo '<input class="eingabe2" name="kwo" value="'.$kwo.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>kin</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kin = getwert($id,"charaktere","kin","id"); 
}
else{
$kin = "0";
}
echo '<input class="eingabe2" name="kin" value="'.$kin.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';   
echo '<td>kwob</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kwob = getwert($id,"charaktere","kwob","id"); 
}
else{
$kwob = "0";
}
echo '<input class="eingabe2" name="kwob" value="'.$kwob.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>kdata</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kdata = getwert($id,"charaktere","kdata","id"); 
}
else{
$kdata = "0";
}
echo '<input class="eingabe2" name="kdata" value="'.$kdata.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>'; 
echo '<td>Bijuu</td>';
echo '<td>';     
echo'<div class="auswahl">';
echo '<select name="bijuu" class="Auswahl" size="1">';     
if($id != ""){
$bijuu = getwert($id,"charaktere","bijuu","id"); 
}
else{
$bijuu = ""; 
}                    
echo'<option value="';
echo '">';
echo ' Kein Bjuu '; 
echo '</option>';
echo '<option value="Ichibi" ';
if($bijuu == 'Ichibi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Ichibi';
echo '</option>';        
echo '<option value="Nibi" ';
if($bijuu == 'Nibi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Nibi';
echo '</option>';  
echo '<option value="Sanbi" ';
if($bijuu == 'Sanbi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Sanbi';
echo '</option>';  
echo '<option value="Yonbi" ';
if($bijuu == 'Yonbi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Yonbi';
echo '</option>'; 
echo '<option value="Gobi" ';
if($bijuu == 'Gobi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Gobi';
echo '</option>'; 
echo '<option value="Rokubi" ';
if($bijuu == 'Rokubi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Rokubi';
echo '</option>';  
echo '<option value="Shichibi" ';
if($bijuu == 'Shichibi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Shichibi';
echo '</option>'; 
echo '<option value="Hachibi" ';
if($bijuu == 'Hachibi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Hachibi';
echo '</option>'; 
echo '<option value="Kyuubi" ';
if($bijuu == 'Kyuubi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kyuubi';
echo '</option>';         
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';     
echo '<td>Gameinfo</td>';
echo '<td>';
if($gameinfo != ""){
$gameinfo = getwert($id,"charaktere","gameinfo","id"); 
}
else{
$gameinfo = ""; 
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="gameinfo" maxlength="300000">';
echo $gameinfo;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>Last Chakra</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$lchakra = getwert($id,"charaktere","lchakra","id"); 
}
else{
$lchakra = "";
}
echo '<input class="eingabe2" name="lchakra" value="'.$lchakra.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';     
echo '<td>Item PUs</td>';
echo '<td>';
if($id != ""){
$itempus = getwert($id,"charaktere","itempus","id"); 
}
else{
$itempus = "";
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="itempus" maxlength="300000">';
echo $itempus;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Siege</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$siege = getwert($id,"charaktere","siege","id"); 
}
else{  
$siege = "0";
}
echo '<input class="eingabe2" name="siege" value="'.$siege.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Niederlagen</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$niederlagen = getwert($id,"charaktere","niederlagen","id"); 
}
else{  
$niederlagen = "0";
}
echo '<input class="eingabe2" name="niederlagen" value="'.$niederlagen.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';     
echo '<td>Quotient</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$quotient = getwert($id,"charaktere","quotient","id"); 
}
else{  
$quotient = "0";
}
echo '<input class="eingabe2" name="quotient" value="'.$quotient.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';     
echo '<td>WertungsKämpfe</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$wks = getwert($id,"charaktere","wks","id"); 
}
else{  
$wks = "0";
}
echo '<input class="eingabe2" name="wks" value="'.$wks.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Sucht WK</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$wksucht = getwert($id,"charaktere","wksucht","id"); 
}
else{  
$wksucht = "0";
}
echo '<input class="eingabe2" name="wksucht" value="'.$wksucht.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>NPCwin</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    npc
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="npcwin" class="Auswahl" size="1">';     
if($id != ""){
$npcwin = getwert($id,"charaktere","npcwin","id"); 
}
else{
$npcwin = 0; 
}
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $npcwin){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo'<option value="';
echo '0';
if($npcwin == 0){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kein NPC'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';     
echo '<td>Summonused</td>';
echo '<td>';
if($summonused != ""){
$summonused = getwert($id,"charaktere","summonused","id"); 
}
else{
$summonused = ""; 
}   
echo '</div>'; 
echo '<div class="textfield2">
<textarea class="textfield" name="summonused" maxlength="300000">';
echo $summonused;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';   
echo '<td>npcfights</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$npcfights = getwert($id,"charaktere","npcfights","id"); 
}
else{
$npcfights = "0";
}
echo '<input class="eingabe2" name="npcfights" value="'.$npcfights.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Kombipartner</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kombipartner = getwert($id,"charaktere","kombipartner","id"); 
}
else{
$kombipartner = "0";
}
echo '<input class="eingabe2" name="kombipartner" value="'.$kombipartner.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';       
echo '<td>Kombipartnerwo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kombipartnerw = getwert($id,"charaktere","kombipartnerw","id"); 
}
else{
$kombipartnerw = "charaktere";
}
echo '<input class="eingabe2" name="kombipartnerw" value="'.$kombipartnerw.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';       
echo '<td>IZeit</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$izeit = getwert($id,"charaktere","izeit","id"); 
}
else{
$izeit = 0;
}
echo '<input class="eingabe2" name="izeit" value="'.$izeit.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';       
echo '<td>Hauptaccount</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$main = getwert($id,"charaktere","main","id"); 
}
else{
$main = "0";
}
echo '<input class="eingabe2" name="main" value="'.$main.'" size="15" maxlength="50" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Kriegkampf</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id
FROM
    kriegkampf
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kriegkampf" class="Auswahl" size="1">';     
if($id != ""){
$kriegkampf = getwert($id,"charaktere","kriegkampf","id"); 
}
else{
$kriegkampf = 0; 
}
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kriegkampf){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo'<option value="';
echo '0';
if($kriegkampf == 0){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kein Kampf'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';   
echo '<td>Kriegwer</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$kriegwer = getwert($id,"charaktere","kriegwer","id"); 
}
else{
$kriegwer = "";
}
echo '<input class="eingabe2" name="kriegwer" value="'.$kriegwer.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';    
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was =="krieg"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>X</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$x = getwert($id,"krieg","x","id"); 
}
else{
$x = "0";
}
echo '<input class="eingabe2" name="x" value="'.$x.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';   
echo '<td>Y</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$y = getwert($id,"krieg","y","id"); 
}
else{
$y = "0";
}
echo '<input class="eingabe2" name="y" value="'.$y.'" size="15" maxlength="32" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';     
echo '<td>Erobert</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name,
    was
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="erobert" class="Auswahl" size="1">';     
if($id != ""){
$erobert = getwert($id,"krieg","erobert","id"); 
}
else{
$erobert = 0; 
}
while ($row = $result->fetch_assoc() ) {    
if($row['was'] == "dorf"){ 
echo'<option value="';
echo $row['id'];
if($row['id'] == $erobert){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}
}                 
$result->close(); $db->close();  
echo'<option value="';
echo '0';
if($erobert == 0){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Nicht erobert'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>'; 
echo '<td>Kampf</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    fights
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kampf" class="Auswahl" size="1">';     
if($id != ""){
$kampf = getwert($id,"krieg","kampf","id"); 
}
else{
$kampf = "0"; 
}                    
echo'<option value="';
echo '">';
echo ' Nichts '; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {    
echo'<option value="';
echo $row['id'];
if($row['id'] == $kampf){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';     
echo '<td>Dorf</td>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name,
    was
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="dorf" class="Auswahl" size="1">';     
if($id != ""){
$dorf = getwert($id,"krieg","dorf","id"); 
}
else{
$dorf = 0; 
}
while ($row = $result->fetch_assoc() ) {    
if($row['was'] == "dorf"){ 
echo'<option value="';
echo $row['id'];
if($row['id'] == $dorf){
echo '" selected>';            
}
else{
echo '">';
}
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}
}                 
$result->close(); $db->close();  
echo'<option value="';
echo '0';
if($dorf == 0){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kein'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Wetter</td>';
echo '<td>';           
if($id != ""){
$wetter = getwert($id,"krieg","wetter","id"); 
}
else{
$wetter = "Sonne";
}
echo'<div class="auswahl">';
echo '<select name="wetter" class="Auswahl" size="1">';   
echo '<option value="Sonne';
if($wetter == "Sonne"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Sonne'; 
echo '</option>'; 
echo '<option value="Regen';
if($wetter == "Regen"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Regen'; 
echo '</option>'; 
echo '<option value="Gewitter';
if($wetter == "Gewitter"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Gewitter'; 
echo '</option>'; 
echo '<option value="Sturm';
if($wetter == "Sturm"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Sturm'; 
echo '</option>'; 
echo '<option value="Hitze';
if($wetter == "Hitze"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Hitze'; 
echo '</option>';   
echo '<option value="Erdrutsch';
if($wetter == "Erdrutsch"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Erdrutsch';                                                              
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>'; 
echo '<td>Bijuu</td>';
echo '<td>';     
echo'<div class="auswahl">';
echo '<select name="bijuu" class="Auswahl" size="1">';     
if($id != ""){
$bijuu = getwert($id,"krieg","bijuu","id"); 
}
else{
$bijuu = ""; 
}                    
echo'<option value="';
echo '">';
echo ' Kein Bjuu '; 
echo '</option>';
echo '<option value="Ichibi" ';
if($bijuu == 'Ichibi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Ichibi';
echo '</option>';        
echo '<option value="Nibi" ';
if($bijuu == 'Nibi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Nibi';
echo '</option>';  
echo '<option value="Sanbi" ';
if($bijuu == 'Sanbi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Sanbi';
echo '</option>';  
echo '<option value="Yonbi" ';
if($bijuu == 'Yonbi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Yonbi';
echo '</option>'; 
echo '<option value="Gobi" ';
if($bijuu == 'Gobi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Gobi';
echo '</option>'; 
echo '<option value="Rokubi" ';
if($bijuu == 'Rokubi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Rokubi';
echo '</option>';  
echo '<option value="Shichibi" ';
if($bijuu == 'Shichibi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Shichibi';
echo '</option>'; 
echo '<option value="Hachibi" ';
if($bijuu == 'Hachibi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Hachibi';
echo '</option>'; 
echo '<option value="Kyuubi" ';
if($bijuu == 'Kyuubi'){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kyuubi';
echo '</option>';         
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';   
echo '<tr align=center>';    
echo '<td>rorte</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$rorte = getwert($id,"krieg","rorte","id"); 
}
else{
$rorte = "";
}
echo '<input class="eingabe2" name="rorte" value="'.$rorte.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';    
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was =="turnier"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>'; 
echo '<tr align=center>';    
echo '<td>Name</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$name = getwert($id,"turnier","name","id"); 
}
else{
$name = "";
}
echo '<input class="eingabe2" name="name" value="'.$name.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Start</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$start = getwert($id,"turnier","start","id"); 
}
else{
$start = time(); 
$start = date("Y-m-d H:i:s",$date);
}
echo '<input class="eingabe2" name="start" value="'.$start.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';     
echo '<tr align=center>';     
echo '<td>Teilnehmer</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$teilnehmer = getwert($id,"turnier","teilnehmer","id"); 
}
else{
$teilnehmer = "0";
}
echo '<input class="eingabe2" name="teilnehmer" value="'.$teilnehmer.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Ryo</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$ryo = getwert($id,"turnier","ryo","id"); 
}
else{
$ryo = "0";
}
echo '<input class="eingabe2" name="ryo" value="'.$ryo.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Item</td>';
echo '<td>';  
$item = getwert($id,"turnier","item","id"); 
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    item
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="item" class="Auswahl" size="1">'; 
echo'<option value="';    
echo '">';              
echo 'Keins'; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $item){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Itemanzahl</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$itema = getwert($id,"turnier","itema","id"); 
}
else{
$itema = "0";
}
echo '<input class="eingabe2" name="itema" value="'.$itema.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';

echo '<tr align=center>'; 
echo '<td>Rank</td>';
echo '<td>';
if($id != ""){
$rank = getwert($id,"turnier","rank","id"); 
}
else{
$rank = "Student";
}
echo'<div class="auswahl">';
echo '<select name="rank" class="Auswahl" size="1">'; 
echo '<option value=""';
if($rank == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kein'; 
echo '</option>';
echo '<option value="student"';
if($rank == "student"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Student'; 
echo '</option>'; 
echo '<option value="genin"';
if($rank == "genin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Genin'; 
echo '</option>';  
echo '<option value="chuunin"';
if($rank == "chuunin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Chuunin'; 
echo '</option>'; 
echo '<option value="jounin"';
if($rank == "jounin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jounin'; 
echo '</option>';  
echo '<option value="anbu"';
if($rank == "anbu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Anbu'; 
echo '</option>'; 
echo '<option value="kage"';
if($rank == "kage"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kage'; 
echo '</option>';
echo '<option value="nuke-nin"';
if($rank == "nuke-nin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nuke-nin'; 
echo '</option>';  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';         
echo '<tr align=center>';     
echo '<td>enter</td>';
echo '<td>';
echo '<div class="eingabe5">'; 
if($id != ""){
$enter = getwert($id,"turnier","enter","id"); 
}
else{
$enter = "0";
}
echo '<input class="eingabe6" name="enter" value="'.$enter.'" size="15" maxlength="2" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Ort</td>';
echo '<td>';  
if($id != ""){
$ort = getwert($id,"turnier","ort","id"); 
}
else{
$ort = "1";
}
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="ort" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $ort){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';  
echo '<tr align=center>';   
echo '<td>Finale</td>';
echo '<td>';  
$finale = getwert($id,"turnier","finale","id"); 
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
echo '<select name="finale" class="Auswahl" size="1">'; 
echo'<option value="';    
echo '">';              
echo 'Niemand'; 
echo '</option>';
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $finale){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
if($was =="news"){
echo '<form method="post" action="admin.php?aktion=edit&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';        
echo '<td>ID</td>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="id" value="'.$id.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';     
echo '<td>Datum</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$date = getwert($id,"news","date","id"); 
}
else{
$date = time(); 
$date = date("Y-m-d H:i:s",$date);
}
echo '<input class="eingabe2" name="date" value="'.$date.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';    
echo '<td>Titel</td>';
echo '<td>';
echo '<div class="eingabe1">'; 
if($id != ""){
$title = getwert($id,"news","title","id"); 
}
else{
$title = "Titel";
}
echo '<input class="eingabe2" name="title" value="'.$title.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';   
echo '<td>Autor</td>';
echo '<td>';  
$autor = getwert($id,"news","autor","id"); 
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
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="autor" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];  
if($row['id'] == $autor){
echo '" selected>'; 
}
else{     
echo '">'; 

}           
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>';  
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>'; 
echo '<td>Text</td>';
echo '<td>';
echo '<div class="textfield2">
<textarea class="textfield" name="text" maxlength="300000">';

if($id != ""){
$text = getwert($id,"news","text","id"); 
}
else{
$text = "Text";
}
echo $text;
echo '</textarea>
</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="schreiben" type="submit"></form>';
echo '</td>';
echo '</tr>';     
echo '<form method="post" action="admin.php?aktion=delete&was='.$was.'"> <table width="100%" cellspacing="5px">';
echo '<input type="hidden" value="'.$id.'" name="id" />';      
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="löschen" type="submit"></form>';
echo '</td>';
echo '</tr>'; 
echo '</table><br>'; 
}
}
}
if($page == "rundmail"){      
$an = $_GET['an']; 
if($an == ""){
$an = 'An';
}      
echo '<form method="post" action="admin.php?aktion=rundmail"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="an" value="'.$an.'" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
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
if($page == "kampf"){
$kampf = $_REQUEST['kampf'];
if($kampf == ""){
echo '<form method="post" action="admin.php?page=kampf"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name,
    begin,
    ende
FROM
    fights
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="kampf" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
if($row['ende'] == 0&&$row['begin'] == 1){
echo'<option value="';
echo $row['id'];
echo '">';            
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="Kampf beitreten" type="submit">';
echo '</td>';
echo '</tr>';
echo '</table></form><br>';   
}
else{             
echo '<form method="post" action="admin.php?aktion=kampf&kampf='.$kampf.'">';
$teams = getwert($kampf,"fights","teams","id");  
$mode = getwert($kampf,"fights","mode","id");
$c = 0;
$array = explode(";", trim($teams));
$tanzahl = 0;
while($array[$tanzahl] != ""){
$tanzahl++;
}
while($c != 3&&$tanzahl != 0){  
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';  
//Zeige erst die Teams an
$array = explode(";", trim($teams));
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
$spieler = checkteam($array[$count],$kampf);
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
$array2 = explode("vs", trim($mode));
$count = 4*$c;
$c2 = 0;
while($array2[$count] != ""&&$c2 != 4){
echo '<td height=30px>';
//Wenn das im Mode größer ist als wirkliche spieler im Team
$count2 = $count+1;
echo '<input class="button" name="join" id="login" value="Team '.$count2.' beitreten" type="submit">';
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
}
if($page == "reise"){
echo '<form method="post" action="admin.php?aktion=reise"> <table width="100%" cellspacing="5px">';
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
    orte
      ORDER BY 
    id ASC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="wo" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];
echo '">';            
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="Reisen" type="submit">';
echo '</td>';
echo '</tr>';
echo '</table></form><br>';   
}
if($page == "aktion"){
echo '<form method="post" action="admin.php?aktion=aktion"> <table width="100%" cellspacing="5px">';
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
echo '<select name="wer" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];
echo '">';            
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="Aktion beenden" type="submit">';
echo '</td>';
echo '</tr>';
echo '</table></form><br>';   
}
if($page == "login"){
echo '<form method="post" action="admin.php?aktion=login"> <table width="100%" cellspacing="5px">';
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
echo '<select name="wer" class="Auswahl" size="1">'; 
while ($row = $result->fetch_assoc() ) {     
echo'<option value="';
echo $row['id'];
echo '">';            
echo $row['name'].' ('.$row['id'].')'; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr align=center>';
echo '<td colspan="2" rowspan="1">';
echo '<input class="button" name="login" id="login" value="einloggen" type="submit">';
echo '</td>';
echo '</tr>';
echo '</table></form><br>';   
}
if($page == "email"){
echo '<form method="post" action="admin.php?aktion=email"> <table width="100%" cellspacing="5px">';
echo '<tr align=center>';
echo '<td>';
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="an" value="An" size="15" maxlength="30" type="text">';
echo '</div>';
echo '</td>';
echo '</tr>';
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
if($page != ""){
echo '<br><br><a href="admin.php">Zurück</a>';
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