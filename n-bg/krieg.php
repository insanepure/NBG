<?php
include 'inc/incoben.php';              
$kin = getwert(session_id(),"charaktere","kin","session"); 
$ukid = getwert(session_id(),"charaktere","kampfid","session");    
$uaktion = getwert(session_id(),"charaktere","kriegaktion","session");      
$ukriegkampf = getwert(session_id(),"charaktere","kriegkampf","session");  
$uid = getwert(session_id(),"charaktere","id","session");       
$udorf = getwert(session_id(),"charaktere","dorf","session");  
$urank = getwert(session_id(),"charaktere","rank","session");  
$aktion = $_GET['aktion'];
if($kin){        
$udorf = getwert(session_id(),"charaktere","dorf","session");      
$uhp = getwert(session_id(),"charaktere","hp","session");  
$kwo = getwert(session_id(),"charaktere","kwo","session");   
                                      
if($aktion == "kabbrechen"){          
$uaktion = getwert(session_id(),"charaktere","kriegaktion","session"); 
if($_POST['check'] == 'Ja'){
if($uaktion == "Krieg reisen"){          
$ukid = getwert(session_id(),"charaktere","kampfid","session");  
if($ukid == 0){}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="UPDATE charaktere SET kriegaktion ='', kriegaktiond ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
mysqli_close($con); 
$error = "Aktion abgebrochen.";
}
}
}                        
if($aktion == 'kriegkampf'){ 
if($ukid == 0&&$uhp != 0){    
if($ukriegkampf == 0){
$kriegkampf = getwert($kwo,"kriegkampf","id","kwo");  
if($kriegkampf != 0){ 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="UPDATE charaktere SET kriegkampf ='$kriegkampf' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
mysqli_close($con); 
$error = "Kriegkampf beigetreten.";
}
}
else{
$error = 'Du bist schon im Kriegskampf drin.';
}
}
}
if($aktion == 'bijuu'){ 
if($ukid == 0){                    
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
dorf,
kin,
kwo
FROM
charaktere
WHERE kin="1" AND kwo="'.$kwo.'" AND kriegaktion != ""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
$geht = 1;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
if($kriegaktion == 'Bijuukampf'||$kriegaktion == 'Jinchuurikikampf'){
$geht = 0;
$error = 'An diesen Ort wird bald ein Kampf entstehen.';
}
}
$result->close();$db->close();
$kcheck = getwert($kwo,"kriegkampf","id","kwo"); 
if($kcheck != 0){
$geht = 0;
$error = 'Es ist gerade ein Kampf offen.';
}
if($geht){      
$rkampf = getwert($kwo,"krieg","kampf","id");   
$rbijuu = getwert($kwo,"krieg","bijuu","id"); 
if($rbijuu != ''){
if($rkampf == 0){      
$uhp = getwert(session_id(),"charaktere","hp","session");      
if($uhp != 0){           
if($uaktion == ''){                             
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");   
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                         
$sql="UPDATE charaktere SET kriegaktion ='Bijuukampf',kriegaktiond ='30',kriegaktions ='$zeit',kriegwer='$rbijuu' WHERE id = '".$uid."' LIMIT 1";
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
dorf,
kwo,
kin
FROM
charaktere
WHERE kwo="'.$kwo.'" AND kin="1"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
$an = $row['id'];
$text = 'Der Bijuu wird angegriffen! Es verbleibt eine halbe Stunde bis der Kampf beginnt! ';
$betreff = 'Krieg';
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
$result->close();$db->close();
mysqli_close($con);

}
else{
$error = 'Du tust bereits etwas.';
}


}
else{
$error = 'Du hast keine HP mehr.';
}
}
else{
$error = 'Es besteht schon ein Kampf.';
} 
}
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
if($aktion == 'jinch'){ 
if($ukid == 0){                    
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
dorf,
kin,
kwo
FROM
charaktere
WHERE kin="1" AND kwo="'.$kwo.'" AND kriegaktion != ""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
$geht = 1;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
if($kriegaktion == 'Bijuukampf'||$kriegaktion == 'Jinchuurikikampf'){
$geht = 0;
$error = 'An diesen Ort wird bald ein Kampf entstehen.';
}
}
$result->close();$db->close();
$kcheck = getwert($kwo,"kriegkampf","id","kwo"); 
if($kcheck != 0){
$geht = 0;
$error = 'Es ist gerade ein Kampf offen.';
}
if($geht){      
$rkampf = getwert($kwo,"krieg","kampf","id");   
if($rkampf == 0){      
$uhp = getwert(session_id(),"charaktere","hp","session");      
if($uhp != 0){           
if($uaktion == ''){    
$jid = $_GET['jid']; 
$jhp = getwert($jid,"charaktere","hp","id");      
$jkwo = getwert($jid,"charaktere","kwo","id");        
$jname = getwert($jid,"charaktere","name","id");    
$jkid = getwert($jid,"charaktere","kampfid","id");    
$jdorf = getwert($jid,"charaktere","dorf","id");  
$rerobert = getwert($kwo,"krieg","erobert","id");  
$uallys = getwert($udorf,"orte","ally","id");                                                
$array = explode(";", trim($uallys));
$count = 0;
while($array[$count] != ''){
if($array[$count] == $rerobert){
$rerobert = $udorf;
}
$count++;
} 
$geht = true;
if($udorf != $jdorf)
{
$gally = getwert($udorf,"orte","ally","id");                                                      
$array = explode(";", trim($gally));
$count = 0;
while($array[$count] != ''){
if($array[$count] == $jdorf){
$geht = false;
}
$count++;
} 
}
else
{
  $geht = false;
}
if($geht&&$jdorf != $udorf){
if($jkwo == $kwo){   
if($jkid == 0){                         
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");   
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                         
$sql="UPDATE charaktere SET kriegaktion ='Jinchuurikikampf',kriegaktiond ='30',kriegaktions ='$zeit',kriegwer='$jid' WHERE id = '".$uid."' LIMIT 1";
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
dorf,
kwo,
kin
FROM
charaktere
WHERE kwo="'.$kwo.'" AND kin="1"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
$an = $row['id'];
$text = 'Der Jinchuuriki '.$jname.' wird angegriffen! Es verbleibt eine halbe Stunde bis der Kampf beginnt!';
$betreff = 'Krieg';
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
$result->close();$db->close();
mysqli_close($con);
}
else{
$error = 'Der Jinchuuriki befindet sich im Kampf.';
}

}
}
else{
$error = 'Du kannst ihn vom selben Dorf nicht angreifen!';
}
}
else{
$error = 'Du tust bereits etwas.';
}


}
else{
$error = 'Du hast keine HP mehr.';
}
}
else{
$error = 'Es besteht schon ein Kampf.';
} 
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
/*
if($aktion == 'jinch'){   
if($ukid == 0){          
$rkampf = getwert($kwo,"krieg","kampf","id");   
if($rkampf == 0){        
if($uhp != 0){           
if($uaktion == ''){  
$jid = $_GET['jid']; 
$jhp = getwert($jid,"charaktere","hp","id");      
$jkwo = getwert($jid,"charaktere","kwo","id");  
$jkid = getwert($jid,"charaktere","kampfid","id");    
$jdorf = getwert($jid,"charaktere","dorf","id");  
$rerobert = getwert($kwo,"krieg","erobert","id");  
$uallys = getwert($udorf,"orte","ally","id");                                                
$array = explode(";", trim($uallys));
$count = 0;
while($array[$count] != ''){
if($array[$count] == $rerobert){
$rerobert = $udorf;
}
$count++;
} 
if($rerobert != $udorf){
if($jkwo == $kwo){   
if($jkid == 0){
$kmode = '1vs1';   
$teams = '1;2';
$kname = "Bijuukampf";  
$ort = '0';    
ausruest($uid);    
ausruest($jid);
$owetter = getwert($kwo,"krieg","wetter","id");
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
'Bijuu',
'0',
'1',
'',
'$ort',
'$owetter')";       
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$kid = mysql_insert_id();
$sql="UPDATE krieg SET kampf ='$kid' WHERE id = '".$kwo."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }                
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);   
$uname = getwert(session_id(),"charaktere","name","session");   
$jname = getwert($jid,"charaktere","name","id");            
$ubild = getwert(session_id(),"charaktere","kbild","session"); 
$jbild = getwert($jid,"charaktere","kbild","id");
$sql="UPDATE charaktere SET team ='1',kkbild ='$ubild',kampfid ='$kid',lkaktion ='$zeit',kname ='$uname',powerup ='',dstats ='',debuff ='' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
if($jhp == 0){
$jhp = 1;
}
$sql="UPDATE charaktere SET hp='$jhp',team ='2',kkbild ='$jbild',kampfid ='$kid',lkaktion ='$zeit',kname ='$jname',powerup ='',dstats ='',debuff ='' WHERE id = '".$jid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}               
}
else{
$error = 'Der Jinchuuriki befindet sich im Kampf.';
}

}
}
else{
$error = 'Du kannst ihn vom selben Dorf nicht angreifen!';
}
}
else{
$error = 'Du tust bereits etwas.';
}


}
else{
$error = 'Du hast keine HP mehr.';
}
}
else{
$error = 'Es besteht schon ein Kampf.';
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
if($aktion == 'bijuu'){ 
if($ukid == 0){          
$rkampf = getwert($kwo,"krieg","kampf","id");   
$rbijuu = getwert($kwo,"krieg","bijuu","id"); 
if($rbijuu != ''){
if($rkampf == 0){        
if($uhp != 0){           
if($uaktion == ''){                             
$kmode = '1vs1';   
$teams = '1;2';
$kname = "Bijuukampf";  
$ort = '0';    
ausruest($uid);
$owetter = getwert($kwo,"krieg","wetter","id");
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
'Bijuu',
'0',
'1',
'',
'$ort',
'$owetter')";       
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$kid = mysql_insert_id();
$sql="UPDATE krieg SET kampf ='$kid' WHERE id = '".$kwo."' LIMIT 1";
if (!mysqli_query($con, $sql))
      {
die('Error: ' . mysqli_error($con));
      }             
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);  
$uname = getwert(session_id(),"charaktere","name","session");      
$ubild = getwert(session_id(),"charaktere","kbild","session");
$sql="UPDATE charaktere SET team ='1',kkbild ='$ubild',debuff ='',dstats ='',powerup ='',kampfid ='$kid',lkaktion ='$zeit',kname ='$uname' WHERE id = '".$uid."' LIMIT 1";
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
WHERE name="'.$rbijuu.'" LIMIT 1';
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
mysqli_close($con);

}
else{
$error = 'Du tust bereits etwas.';
}


}
else{
$error = 'Du hast keine HP mehr.';
}
}
else{
$error = 'Es besteht schon ein Kampf.';
}
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
*/
if($aktion == 'kampf'){ 
if($ukid == 0){      
$rkampf = getwert($kwo,"krieg","kampf","id"); 
if($rkampf != 0){                             
$uhp = getwert(session_id(),"charaktere","hp","session");  
$udorf = getwert(session_id(),"charaktere","dorf","session");
if($uhp != 0){           
if($uaktion == ''){  
//ermittel Team  
$kaart = getwert($rkampf,"fights","art","id");    
$kmode = getwert($rkampf,"fights","mode","id");   
$kteams = getwert($rkampf,"fights","teams","id");   
$kname = getwert($rkampf,"fights","name","id"); 
//Zunächst gehe die bisherigen Kämpfer durch
$uteam = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
dorf,
team,
kampfid
FROM
charaktere
WHERE kampfid="'.$rkampf.'"
ORDER BY
team';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['dorf'] == $udorf){
$uteam = $row['team'];
}
else{ 
$uallys = getwert($udorf,"orte","ally","id");                                                 
$array = explode(";", trim($uallys));
$count = 0;
while($array[$count] != ''){  
if($array[$count] == $row['dorf']){
$uteam = $row['team'];
}
$count++;
} 
}
}
$result->close();  
$db->close(); 
if($uteam == 0){
//Die vorhandenen Spieler sind alles Feinde      
$rerobert = getwert($kwo,"krieg","erobert","id");
$uallys = getwert($udorf,"orte","ally","id");                                                
$array = explode(";", trim($uallys));
$count = 0;
if($rerobert != $udorf){
//Eroberer des Ortes gehören nicht zum Dorf
while($array[$count] != ''){
if($array[$count] == $rerobert){
$rerobert = $udorf;  //Eroberer des Ortes sind Freunde, tu so als wäre es das eigene Dorf
$array[$count+1] = '';
}
$count++;
}
}

if($kaart == 'Eroberung'){
if($udorf == $rerobert||$rerobert == 0&&$udorf == 'kein'){ 
if($kname == 'Patrouillie'){
$uteam = 1;
}
else{
$uteam = 2;
}
}
} 
}    
if($uteam == 0)
{
//Erstelle neues Team
$kmode = $kmode.'vs1';        
$array = explode(";", trim($kteams));
$count = 0;
while($array[$count] != ''){
$count++;
}
$uteam = $array[$count-1]+1;
$kteams = $kteams.';'.$uteam;
}
else{
$array = explode("vs", trim($kmode));
$count = 0;
$kmode = '';
while($array[$count] != ''){
if($count == $uteam-1)
{
$array[$count]+= 1;
}
if($kmode == ''){
$kmode = $array[$count];
}
else{
$kmode = $kmode.'vs'.$array[$count];
}
$count++;
}
}

$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE fights SET teams ='$kteams' WHERE id = '".$rkampf."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$sql="UPDATE fights SET mode ='$kmode' WHERE id = '".$rkampf."' LIMIT 1";
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
charaktere
WHERE id="'.$uid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$sql="UPDATE charaktere SET kampfid ='$rkampf',team ='$uteam',kchadd ='0',kziel ='',lkaktion ='$zeit',kaktion ='',kname ='".$row['name']."',kkbild ='".$row['kbild']."',powerup ='',dstats ='',debuff ='' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}
$result->close(); $db->close();    
mysqli_close($con);
}
else{
$error = 'Du tust bereits etwas.';
}


}
else{
$error = 'Du hast keine HP mehr.';
}
}
else{
$error = 'Es ist grad kein Kampf offen.';
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
if($aktion == 'patrollieren'){ 
if($ukid == 0){                    
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
dorf,
kin,
kriegaktion,
kwo
FROM
charaktere
WHERE kin="1" AND kwo="'.$kwo.'" AND kriegaktion != ""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
$geht = 1;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
if($row['kriegaktion'] == 'Krieg erobern'||$row['kriegaktion'] == 'Krieg patrollieren'){
$geht = 0;
$error = 'An diesen Ort wird bald ein Kampf entstehen.';
}
}
$result->close();$db->close();
$kcheck = getwert($kwo,"kriegkampf","id","kwo"); 
if($kcheck != 0){
$geht = 0;
$error = 'Es ist gerade ein Kampf offen.';
}
if($geht){      
$rerobert = getwert($kwo,"krieg","erobert","id");     
$udorf = getwert(session_id(),"charaktere","dorf","session");      
$uallys = getwert($udorf,"orte","ally","id");                                                      
$array = explode(";", trim($uallys));
$count = 0;
while($array[$count] != ''){
if($array[$count] == $rerobert){
$rerobert = $udorf;
}
$count++;
} 
$rkampf = getwert($kwo,"krieg","kampf","id");          
if($rkampf == 0){  
if($rerobert == $udorf||$urank == 'nuke-nin'&&$rerobert == 0){      
$uhp = getwert(session_id(),"charaktere","hp","session");      
if($uhp != 0){           
if($uaktion == ''){                             
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");   
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                         
$sql="UPDATE charaktere SET kriegaktion ='Krieg patrollieren',kriegaktiond ='60',kriegaktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
if($rerobert == 0){
$rerobert = 'kein';
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
dorf,
kwo,
kin
FROM
charaktere
WHERE kwo="'.$kwo.'" AND kin="1"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
$an = $row['id'];
$text = 'Der Ort Nr.'.$kwo.' wird patrolliert! Es verbleibt eine Stunde bis der Kampf beginnt! ';
$betreff = 'Krieg';
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
$result->close();$db->close();
mysqli_close($con);

}
else{
$error = 'Du tust bereits etwas.';
}


}
else{
$error = 'Du hast keine HP mehr.';
}
}
}
else{
$error = 'Es besteht schon ein Kampf.';
} 
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
if($aktion == 'erobern'){      
if($ukid == 0){          
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
dorf,
kin,
kriegaktion,
kwo
FROM
charaktere
WHERE kin="1" AND kwo="'.$kwo.'" AND kriegaktion != ""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
$geht = 1;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
if($row['kriegaktion'] == 'Krieg erobern'||$row['kriegaktion'] == 'Krieg patrollieren'){
$geht = 0;
$error = 'An diesen Ort wird bald ein Kampf entstehen.';
}
}
$result->close();$db->close();
$kcheck = getwert($kwo,"kriegkampf","id","kwo"); 
if($kcheck != 0){
$geht = 0;
$error = 'Es ist gerade ein Kampf offen.';
}
if($geht){
$rdorf = getwert($kwo,"krieg","dorf","id");   
if($rdorf == 0){                      
$rerobert = getwert($kwo,"krieg","erobert","id");  
$udorf = getwert(session_id(),"charaktere","dorf","session");      
$uallys = getwert($udorf,"orte","ally","id");                                                      
$array = explode(";", trim($uallys));
$count = 0;
while($array[$count] != ''){
if($array[$count] == $rerobert){
$rerobert = $udorf;
}
$count++;
} 
$rkampf = getwert($kwo,"krieg","kampf","id");          
if($rkampf == 0){  
if($rerobert != $udorf&&$urank != 'nuke-nin'||$urank == 'nuke-nin'&&$rerobert != 0||$rerobert == 0&&$urank != 'nuke-nin'){       ;  
$uhp = getwert(session_id(),"charaktere","hp","session");      
if($uhp != 0){           
if($uaktion == ''){                             
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");   
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                         
$sql="UPDATE charaktere SET kriegaktion ='Krieg erobern',kriegaktiond ='60',kriegaktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
if($rerobert == 0){
$rerobert = 'kein';
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
dorf,
kin,
kwo
FROM
charaktere
WHERE kin="1" AND dorf ="'.$rerobert.'" OR kin="1" and kwo="'.$kwo.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
$an = $row['id'];
$text = 'Der Ort Nr.'.$kwo.' wird angegriffen! Es verbleibt eine Stunde bis der Kampf beginnt! ';
$betreff = 'Krieg';
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
$result->close();$db->close();
mysqli_close($con);

}
else{
$error = 'Du tust bereits etwas.';
}


}
else{
$error = 'Du hast keine HP mehr.';
}
}
}
else{
$error = 'Es besteht schon ein Kampf.';
}  
}
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
if($aktion == 'bewegen'){       
$rid = $_GET['rid'];
if(is_numeric($rid)){
$rhin = getwert($kwo,"krieg","rorte","id");  
$array = explode(";", trim($rhin)); 
$count = 0;
$geht = 0;
while($array[$count] != ''){
if($rid == $array[$count]){
$geht = 1;
}
$count++;
}
if($geht == 1){                    
$uorte = getwert($kwo,"krieg","erobert","id");      
$udorf = getwert(session_id(),"charaktere","dorf","session");      
$rerobert = getwert($rid,"krieg","erobert","id");     
$rallys = getwert($rerobert,"orte","ally","id");                                                                                    
$array = explode(";", trim($rallys));
$count = 0;       
if($rerobert != $udorf)
{                                               
$rallys = getwert($rerobert,"orte","ally","id");                                                                                    
$array = explode(";", trim($rallys));        
while($array[$count] != ''){
if($array[$count] == $udorf){
$uorte = $udorf;
}
$count++;
} 
$ally = false;    
$count = 0;        
$rallys = getwert($uorte,"orte","ally","id");                                                                                 
$array = explode(";", trim($rallys));             
while($array[$count] != ''){
if($array[$count] == $udorf){
$uorte = $udorf;
}
$count++;
}  
}
else
{
  $uorte = $rerobert;
}      
$kdorf = getwert($kwo,"krieg","dorf","id");   
$uhp = getwert(session_id(),"charaktere","hp","session");    
if($uorte == $udorf||$uorte == 0&&$udorf == 'kein'||$kdorf != 0){
if($rid != $kwo){
if($uhp != 0){           
if($uaktion == ''){                             
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$uid = getwert(session_id(),"charaktere","id","session");     
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                       
$sql="UPDATE charaktere SET kriegaktion ='Krieg reisen',kriegaktiond ='30',kwob ='$rid',kriegaktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}           
mysqli_close($con);
}
else{
$error = 'Du tust bereits etwas.';
}


}
else{
$error = 'Du hast keine HP mehr.';
}
}
else{
$error = 'Du kannst hier nicht hinreisen.';
}
}
else{
$error = 'Dieser Tätigkeit ist ungültig.';
} 
}
}
}                                             
if($aktion == 'leave' && $_POST['check']){   
if($ukid == 0){   
if($uaktion == ''){                                          
$ubijuu = getwert(session_id(),"charaktere","bijuu","session");  
if($ubijuu == ''){
$uid = getwert(session_id(),"charaktere","id","session");  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET kin ='0',kwo ='0',kriegaktion='' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$kin = 0;
$kwo = 0;
mysqli_close($con);
}
else{
$error = 'Als Jinchuuriki kannst du den Krieg nicht verlassen.';
}
}
else{
$error = 'Du kannst den Krieg nicht verlassen, während du eine Aktion machst.';
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
} 
}
else{
if($aktion == 'join'){   
if($ukid == 0){          
$uaktion = getwert(session_id(),"charaktere","kriegaktion","session");      
if($uaktion == ''){   
$uid = getwert(session_id(),"charaktere","id","session");  
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$umain = getwert(session_id(),"charaktere","main","session");  
$sql = 'SELECT id FROM charaktere WHERE main="'.$umain.'" and kin="1"';
$result = mysqli_query($con, $sql) or die(mysqli_error($con));   
$anzahl = mysqli_num_rows($result);
if($anzahl == 0){
if($udorf == 'kein'){
$udorf = 13;
} 
$dwo = getwert($udorf,"krieg","id","dorf"); 
$sql="UPDATE charaktere SET kin ='1',kwo ='$dwo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$kwo = $dwo;
$kin = 1;
mysqli_close($con);
}
else{
$error = 'Es befinden sich schon Multis von dir im Krieg.';
}
}
else{
$error = 'Du kannst den Krieg nicht beitreten, während du eine Aktion machst.';
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
}
}
}
if(logged_in()){
include 'inc/header.php';  
$page = $_GET['page'];
$uaktion = getwert(session_id(),"charaktere","kriegaktion","session");       
$ukdata = getwert(session_id(),"charaktere","kdata","session");  
if($ukdata == 1){       
$ukampf = getwert(session_id(),"charaktere","kampfid","session");     
if($ukampf != 0){
echo '<center><div class="kdaten">';
echo '<br><h2>Kampf</h2>';
echo 'Du befindest dich im Kampf.<br>';
echo '<a href="fight.php">Zum Kampf</a>';         
echo '</div></center>';
}
elseif($uaktion != ''){            
echo '<center><div class="kdaten">';
echo '<br><h2>Aktion</h2>';         
$uaktions = getwert(session_id(),"charaktere","kriegaktions","session");  
$aktiond = getwert(session_id(),"charaktere","kriegaktiond","session");  
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($uaktions); 
$test3 = $test2-$test;
$test4 = ($aktiond*60)-$test3;
$cID = $cID+1;
echo '<b>'.$uaktion.'</b><br>';
echo 'Dauer: <b id="cID'.$cID.'">';
echo " Init<script>countdown($test4,'cID$cID');</script></b><br>";
  if($uaktion != 'Krieg erobern'&&$uaktion != 'Krieg patrollieren')
  {
  echo '<form method="post" action="krieg.php?aktion=kabbrechen"><input type="checkbox" name="check" value="Ja"> <input class="button2" name="login" id="login" value="Aktion abbrechen" type="submit"></form>';
  }
echo '</div></center>';

}
}
if($kin == 0||$page=='aktion'||$error != ''){         
echo '<div class="tutbg">';
echo '<table width="100%" height="100%"><tr><td width="30%"></td><td width="40%" align="center"><div class="kjoin">';  
if($error != ''){
echo '<br><br><h2>Meldung</h3><br>'.$error.'<br>';        
echo '<br><a class="atut" href="krieg.php">Zurück</a><br>';
}
else{ 
if($kin == 0){
echo '<br><br><br><h2>Krieg</h2>';
echo '<br>Willst du dem Krieg beitreten?<br>';
echo '<br><a class="atut" href="krieg.php?aktion=join">Krieg beitreten</a><br>';  
echo '<br><a class="atut" href="index.php">Zurück</a><br>';
}
elseif($page == 'aktion'){
if($page == 'aktion'){    
$rid = $_GET['rid'];
if(is_numeric($rid)){    
//überprüfe den Ort an den wir stehen
$udorf = getwert(session_id(),"charaktere","dorf","session");     
$uorte = getwert($kwo,"krieg","erobert","id"); //Owner des Ortes  
$kallys = getwert($uorte,"orte","ally","id"); //Eigene Verbündete  
$array = explode(";", trim($kallys));
$count = 0;
$oally = false;
if($uorte != $udorf&&$udorf != 'kein'||$udorf == 'kein'&&$uorte != 0)
{         
//Gehe die eigenen Verbündete durch
while($array[$count] != ''){
if($array[$count] == $udorf){
$oally = true; //Ist verbündet mit dem Ort auf den man sich befindet
}
$count++;
} 
}
else
{
  $oally = true;
}
//überprüfe den Ort wo wir hinreisen wollen
$kdorf = getwert($kwo,"krieg","dorf","id");   
$rerobert = getwert($rid,"krieg","erobert","id");   
$ually = getwert($udorf,"orte","ally","id");                                                      
$array = explode(";", trim($ually));
$count = 0;
$rally = false;
if($rerobert != $udorf&&$udorf != 'kein'||$udorf == 'kein'&&$rerobert != 0)
{       
while($array[$count] != ''){
if($array[$count] == $rerobert){
$rally = true; //Reise ort ist verbündet
}
$count++;
} 
}
else
{
  $rally = true;
}
//oally = Sind wir verbündet mit dem Ort auf den wir uns befinden?
//rally = Sind wir verbündet mit dem Ort wo wir hinreisen wollen?
$rdorf = getwert($rid,"krieg","dorf","id");  
$rbijuu = getwert($rid,"krieg","bijuu","id");  
$rkampf = getwert($rid,"krieg","kampf","id");  
$kriegkampf = getwert($rid,"kriegkampf","id","kwo");    
echo '<br><h2>Aktionen</h2>';
$nachricht = 0;
if($kriegkampf != 0&&$kwo == $rid){
echo 'Ein Kampf startet beim nächsten 5 Minuten-Abschnitt.<br>';
echo '<a href="krieg.php?aktion=kriegkampf">Beitreten</a>';
$nachricht = 1;
}
else if($rkampf != 0&&$kwo == $rid){
echo '<br><a class="atut" href="krieg.php?aktion=kampf">Offenen Kampf beitreten</a><br>';     
echo '<br><a class="atut" href="log.php?kid='.$rkampf.'">Offenen Kampf betrachten</a><br>'; 
$nachricht = 1;  
}
else{
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kin,
kwo,
kriegaktion,
kriegaktiond, 
kriegaktions
FROM
charaktere
WHERE kin="1" AND kwo="'.$rid.'" AND kriegaktion != ""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}  
$geht = 1;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
if($row['kriegaktion'] == 'Krieg erobern'||$row['kriegaktion'] == 'Krieg patrollieren'||$row['kriegaktion'] == 'Bijuukampf'||$row['kriegaktion'] == 'Jinchuurikikampf'){ 
$test = strtotime($row['kriegaktions']); 
$test3 = time()-$test;
$test4 = ($row['kriegaktiond']*60)-$test3;
$cID = $cID+1;
if($row['kriegaktion'] == 'Krieg erobern'){
echo 'Eroberungskampf';
}            
elseif($row['kriegaktion'] == 'Krieg patrollieren'){
echo 'Patrouillie';
}         
elseif($row['kriegaktion'] == 'Bijuukampf'){
echo 'Bijuukampf';
}        
elseif($row['kriegaktion'] == 'Jinchuurikikampf'){
echo 'Jinchuurikikampf';
}
echo ' startet in: <b id="cID'.$cID.'">';
echo " Init<script>countdown($test4,'cID$cID');</script></b><br>";
$nachricht = 1;  
}
}
$result->close();$db->close();
if($kwo == $rid&&$rdorf == 0){
if($rally == false&&$urank != 'nuke-nin'||$urank == 'nuke-nin'&&$rerobert != 0||$rerobert == 0&&$urank != 'nuke-nin'){          
echo '<br><a class="atut" href="krieg.php?aktion=erobern">Ort erobern</a><br>';     
$nachricht = 1;  
}
}
if($kwo == $rid){
if($rally||$urank == 'nuke-nin'&&$rerobert == 0){
echo '<br><a class="atut" href="krieg.php?aktion=patrollieren">Ort patrouillieren</a><br>';     
$nachricht = 1;  
}
if($rbijuu != ''){          
echo '<br><a class="atut" href="krieg.php?aktion=bijuu">Bijuukampf starten</a><br>';   
$nachricht = 1;  
}       
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
bijuu,
kwo,dorf                                            
FROM
charaktere
WHERE bijuu != "" AND kwo="'.$rid.'" LIMIT 9';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}                                   
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['id'] != $uid){
$geht = true;
if($row['dorf'] != $udorf)
{
//Wenn man selber nicht ally ist dann greif an    
$ually = getwert($udorf,"orte","ally","id");                                                      
$array = explode(";", trim($ually));
$count = 0;
while($array[$count] != ''){
if($array[$count] == $row['dorf']){
$geht = false;
}
$count++;
} 
}
else
  $geht = false;
if($geht&&$row['dorf'] != $udorf)
{
echo '<a class="atut" href="krieg.php?aktion=jinch&jid='.$row['id'].'">Gegen den Jinchuuriki '.$row['name'].' kämpfen</a><br>';    
$nachricht = 1;     
}
}
}
$result->close();
$db->close();       
}
if($rid != $kwo){
if($rally||$oally||$kdorf != 0){
echo '<br><a class="atut" href="krieg.php?aktion=bewegen&rid='.$rid.'">Zum Ort bewegen</a><br>';     
$nachricht = 1;  
}
}
}
if($nachricht == 0){
echo '<br>Du kannst hier nichts tun.<br>';
}
}
}
echo '<br><a class="atut" href="krieg.php">Zurück</a><br>';
} 
}
echo '</div></td><td width="30%"></td></tr></table>';
echo '</div>';
} 
?>
<center>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<ins class="adsbygoogle"
     style="display:inline-block;width:963px;height:90px"
     data-ad-client="ca-pub-7145796878009968"
     data-ad-slot="6601247425"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<?php
//if($account->Get('id') != 1)
if(false)
{
  ?>
  <!-- ADC Rota 202959 PRE BK 728x90 -->
  <script type="text/javascript" language="Javascript" src="https://bk.adcocktail.com/pre_bk_rota.php?format=728x90&uid=89196&wsid=202959"></script>
  <!-- ADC Rota 202959 PRE BK 728x90 -->
  <?php
}
?>
  </center>
<?php
echo '<center><div class="kmap"><div class="kwege">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
x,
y,
dorf,
erobert,
bijuu,
wetter,
kampf
FROM
krieg';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}          
$mapc = getwert(session_id(),"charaktere","mapc","session");  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
if($row['erobert'] == 0 || $row['erobert'] == 13){
$farbe = 'nuke';
}
else{
$farbe = getwert($row['erobert'],"orte","name","id");
}
$text = 'Nummer #'.$row['id'].'<br>';  
if($row['dorf'])
{       
$dorfn = getwert($row['dorf'],"orte","name","id");     
$text = $text.'Dorf: '.ucwords($dorfn).'<br>'; 
}     
if($row['erobert'])
{                                            
$dorfe = getwert($row['erobert'],"orte","name","id");            
$text = $text.'Erobert von: '.ucwords($dorfe).'<br>'; 
}     
$text = $text.'Wetter: '.$row['wetter'].'<br>';   
if($row['bijuu'])
{
$text = $text.'Bijuu: '.$row['bijuu'].'<br>';
}
$sql2 = 'SELECT
id,
bijuu,
kwo,
name                                            
FROM
charaktere
WHERE bijuu != "" AND kwo="'.$row['id'].'" LIMIT 9';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
$text = $text.'Jinchuuriki: '.$row2['name'].'<br>';
}
$result2->close();
echo '<div class="mdorf2" style="position:absolute; left:'.$row['x'].'px; top:'.$row['y'].'px; z-index:4;"><a href="krieg.php?page=aktion&rid='.$row['id'].'" class="sinfo"><span class="spanmap">'.$text.'</span></a></div>';   
if($row['dorf'] == 0){
echo '<div class="kdorf" style="background:url(../bilder/krieg/'.$farbe.'ort.png); position:absolute; left:'.$row['x'].'px; top:'.$row['y'].'px; z-index:1;"></div>';   
}
else{
echo '<div class="kdorf" style="background:url(../bilder/krieg/'.$farbe.'dorf.png); position:absolute; left:'.$row['x'].'px; top:'.$row['y'].'px; z-index:1;"></div>';   
}
if($kwo == $row['id']){
echo '<div class="mchar'.$mapc.'" style="position:absolute; left:'.$row['x'].'px; top:'.$row['y'].'px; z-index:3;"></div>';
}                     
if($row['kampf'] != 0){  
echo '<div class="mamissi" style="position:absolute; left:'.$row['x'].'px; top:'.$row['y'].'px; z-index:2;"></div>';
}
if($row['bijuu']){
echo '<div style="position:absolute; left:'.($row['x']-10).'px; top:'.($row['y']-15).'px; z-index:0; width:50px; height:50px;"><img src="bilder/krieg/'.$row['bijuu'].'.gif" width="50px" height="42px"></img></div>'; 
}
$sql2 = 'SELECT
id,
bijuu,
kwo                                            
FROM
charaktere
WHERE bijuu != "" AND kwo="'.$row['id'].'" LIMIT 9';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<div style="position:absolute; left:'.($row['x']-10).'px; top:'.($row['y']-15).'px; z-index:0; width:50px; height:50px;"><img src="bilder/krieg/'.$row2['bijuu'].'.gif" width="50px" height="42px"></img></div>';    
}
$result2->close();
}
$result->close(); $db->close();
echo '</div></div><br>';
  
echo '<form method="post" action="krieg.php?aktion=leave">';
echo '<input class="cursor" type="checkbox" name="check" value="check"> Willst du den Krieg wirklich verlassen?';
echo '<br/><input class="button2" name="login" id="login" value="Verlassen" type="submit"></form>';
echo '<br> <br><a href="index.php">Zurück</a></center>';
echo '<div style="height:150px;"></div>';

}
//nicht eingeloggt , zeige Loginfenster
else{                          
include 'inc/design3.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
include 'inc/mainindex.php';   
include 'inc/design2.php';
}
?>