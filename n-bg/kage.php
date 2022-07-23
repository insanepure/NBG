<?php
include 'inc/incoben.php';
if(logged_in()){   
$uort = getwert(session_id(),"charaktere","ort","session");    
$urank = getwert(session_id(),"charaktere","rank","session");       
$udorf = getwert(session_id(),"charaktere","dorf","session");   
if($uort == $udorf&&$urank == 'kage'){
$aktion = $_GET['aktion'];
if($aktion == 'ally'){        
      $udorfn = getwert($udorf,"orte","name","id");
  $did = $_GET['id'];
  if(is_numeric($did)&&$did != $udorf&&$did != 13){
    $dname = getwert($did,"orte","name","id");  
    if($dname != ''){   
      $ally = getwert($udorf,"orte","ally","id");   
      $array = explode(";", trim($ally));    
      $count = 0;
      $ist = false;
      $nally = "";
      while(isset($array[$count])){    
      if($array[$count] != $did){
        if($nally == ''){
        $nally = $array[$count];
        }
        else{
        $nally = $nally.';'.$array[$count];
        }
      }
      else{
      $ist = true;
      }
      $count++;
      }
      if(!$ist){
      //Ally    
      $error = 'Du hast Frieden mit dem Dorf geschlossen.';
      if($ally == ''){
      $nally = $did;
      }
      else{
      $nally = $ally.';'.$did;
      }   
      $betreff = 'Friedenserklärung';
      $ntext = ucwords($udorfn).'gakure ist euch nun friedlich gesonnt!';
      }
      else{
      $error = 'Du hast Dem Dorf Krieg erklärt!.';       
      $betreff = 'Kriegserklärung';
      $ntext = ucwords($udorfn).'gakure hat euch den Krieg erklärt!';
      }
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con));      
      $db = @new mysqli($host, $user, $pw, $datenbank); 
      if (mysqli_connect_errno()) {
          die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
      }
      $sql = '
      SELECT
      id,
      dorf,
      kin
      FROM
      charaktere
      WHERE dorf = "'.$did.'" AND kin="1"';
      $result = $db->query($sql);
      if (!$result) {
          die ('Etwas stimmte mit dem Query nicht: '.$db->error);
      }  
      $zeit2 = time();
      $zeit = date("YmdHis",$zeit2);
      $count = 0; 
      while ($row = $result->fetch_assoc() ) {       
      $anid = $row['id']; 
      $sql="INSERT INTO pms(
      `id`,`an`,`von`,`betreff`,`text`,`date`)
      VALUES
      ('".uniqid()."',
      '$anid',
      'System',
      '$betreff',
      '$ntext',
      '$zeit')";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }  
      }                 
      $result->close(); $db->close();   
      $sql="UPDATE orte SET ally ='$nally' WHERE id = '".$udorf."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      } 
      mysqli_close($con);
    }
  }
}
if($aktion == 'turnier'){
$tgeld = $_POST['turnierpreis'];      
$tname = real_escape_string($_POST['turniername']);
$geht = 1;
$check = namencheck2($tname);
if($check){
$geht = 0;
$error = $error."Der Name enthält unzulässige Wörter ($check).<br>";
}
if($tname == ""){
$geht = 0;
$error = $error."Du hast keinen Namen angegegeben.<br>";
}  
if(!is_numeric($tgeld)||$tgeld == ''||$tgeld < 0){
$geht = 0;
$error = $error.'Du hast kein gültiges Preisgeld angegeben.';
}           
$uryo = getwert(session_id(),"charaktere","ryo","session");   
if($uryo < $tgeld){
$geht = 0;
$error = $error.'Du hast nicht genügend Ryo.';
}
if($geht == 1){  
$start = time()+(60*60*24);     
$start = date("Y-m-d H:i:s",$start);
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="INSERT INTO turnier(
`name`,
start,   
rank,
item,
itema, 
ort,     
ryo,
enter)
VALUES
('$tname',
'$start',
'',
'',
'',    
'$uort', 
'$tgeld',
'1')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                                                       
$uid = getwert(session_id(),"charaktere","id","session");  
$sql="UPDATE charaktere SET ryo =(ryo-".$tgeld.") WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
mysqli_close($con);
$error = 'Das Turnier wurde erstellt.';
}

}
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
dorf
FROM
charaktere
WHERE dorf = "'.$udorf.'"';
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
if($aktion == 'winvite'){
$nuke = $_GET['nuke'];      
$ninvites = getwert($udorf,"orte","nukeinvite","id");                        
$array = explode(";", trim($ninvites));    
$count = 0;
$nninv = "";
while(isset($array[$count])){      
if($array[$count] != $nuke){
if($nninv == ""){
$nninv = $array[$count];
}
else{
$nninv = $nninv.';'.$array[$count];
}
}
$count++;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE orte SET nukeinvite ='$nninv' WHERE id = '".$udorf."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                 
$nname = getwert($nuke,"charaktere","name","id");    
if($nname == ''){
$nname = 'Gelöschter User';
}
$error = 'Du hast die Einladung von '.$nname.' zurückgenommen.';
mysqli_close($con);

}
if($aktion == 'invite'){
$nuke = $_POST['nuke'];     
$nrank = getwert($nuke,"charaktere","rank","id");  
if($nrank == 'nuke-nin'){      
$ninvites = getwert($udorf,"orte","nukeinvite","id");                        
$array = explode(";", trim($ninvites));    
$count = 0;
$geht = 1;
while(isset($array[$count])){           
if($array[$count] == $nuke){
$geht = 0;
$error = 'Dieser User ist schon eingeladen worden.';
}
$count++;
}
if($geht == 1){
if($ninvites == ''){
$ninvites = $nuke;
}
else{
$ninvites = $ninvites.';'.$nuke;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE orte SET nukeinvite ='$ninvites' WHERE id = '".$udorf."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                 
$nname = getwert($nuke,"charaktere","name","id");   
$dorfn = getwert($udorf,"orte","name","id");   
$error = 'Du hast '.$nname.' im Dorf eingeladen.';
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$text = 'Du wurdest zum Dorf '.$dorfn.' eingeladen.
Wenn du dem Dorf beitreten willst, dann [url=chara.php?dorf='.$udorf.'&aktion=dorfaccept]akzeptiere[/url].
Wenn du dem Dorf nicht beitreten willst, dann [url=chara.php?dorf='.$udorf.'&aktion=dorfdecline]lehne ab[/url].';
$betreff = 'Dorf Einladung';
$sql="INSERT INTO pms(     
`id`,`an`,`von`,`betreff`,`text`,`date`)
VALUES
('".uniqid()."',
'$nuke',
'System',
'$betreff',
'$text',
'$zeit')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con);
}
}
}
}
}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
if($uort == $udorf&&$urank == 'kage'){
echo '<h3>Kage Haus</h3>';
echo '<br>';                                      
$ninvites = getwert($udorf,"orte","nukeinvite","id");   
$ally = getwert($udorf,"orte","ally","id");           
echo '<h3>Diplomatie</h3><br>';     
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdborder tdbg">Dorf</td>';  
echo '<td class="tdborder tdbg">Status</td>'; 
echo '<td class="tdborder tdbg"></td>';
echo '</tr>';                   
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    was,
    name
FROM
    orte
    WHERE was = "dorf" AND name!="versteck" AND id!="'.$udorf.'"';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}         
while ($row = $result->fetch_assoc() ) {  
echo '<tr><td>'.ucwords($row['name']).'gakure</td>';
$a = false;
$count = 0;                      
$array = explode(";", trim($ally)); 
while($array[$count] != ''){
if($array[$count] == $row['id']){
$a = true;
}
$count++;
}   
if($a){
echo '<td>Verbündet</td>';
}
else{
echo '<td>Feinde</td>';
}                   
echo '<td><a href="kage.php?aktion=ally&id='.$row['id'].'">ändern</td>';  
echo '</tr>';
}                 
$result->close(); $db->close(); 
echo '</table>';
echo '<h3>Nuke-Nin einladen</h3><br>';                              
$array = explode(";", trim($ninvites));    
$count = 0;
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdborder tdbg">Name</td>';  
echo '<td class="tdborder tdbg">Einladung</td>';
echo '</tr>';
while(isset($array[$count])){            
$nname = getwert($array[$count],"charaktere","name","id");  
if($nname == ''){
$nname = 'Gelöschter User';
}
echo '<tr><td><a href="user.php?id='.$array[$count].'">'.$nname.'</a></td><td><a href="kage.php?nuke='.$array[$count].'&aktion=winvite">Einladung zurücknehmen</a></td></tr>';
$count++;
}
echo '</table>';

     
echo '<br><center><form method="post" action="kage.php?aktion=invite">';
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name,
    rank
FROM
    charaktere
    WHERE rank = "nuke-nin"
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="nuke" class="Auswahl" size="1">';    
while ($row = $result->fetch_assoc() ) {  
echo'<option value="';
echo $row['id'].'">';
echo $row['name']; 
echo '</option>';
}                 
$result->close(); $db->close();  
echo '</select></div><br>';      
echo '<input class="button" name="login" id="login" value="einladen" type="submit"></form></center>';
echo '<br><h3>Rundmail</h3>';
echo '<form method="post" action="kage.php?aktion=rundmail"> <table width="100%" cellspacing="5px">';
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