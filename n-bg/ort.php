<?php
include 'inc/incoben.php';    
if(logged_in()){
$umissi = getwert(session_id(),"charaktere","mission","session");
$uwo = getwert(session_id(),"charaktere","mwo","session");
$ort = getwert(session_id(),"charaktere","ort","session");            
$urank = getwert(session_id(),"charaktere","rank","session");       
$dorf = getwert(session_id(),"charaktere","dorf","session");     
$aktion = $_GET['aktion'];        
$reisenpc = getwert(session_id(),"charaktere","reisenpc","session");      
$reiseitem = getwert(session_id(),"charaktere","reiseitem","session");         
$kin = getwert(session_id(),"charaktere","kin","session");           
$bijuu = getwert(session_id(),"charaktere","bijuu","session"); 
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
rank,
dorf
FROM
charaktere
WHERE dorf = "'.$ort.'" AND rank = "kage" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$mkage = $row['id'];
}
$result->close();$db->close();
if($aktion == 'schleichen'&&$urank == 'nuke-nin'){  
if($kin == 0||$bijuu != ''){
if($_POST['check'] == 'check'){
if($mkage == ''){ 
if($umissi == "0"){
$uort = getwert(session_id(),"charaktere","ort","session");    
$uorg = getwert(session_id(),"charaktere","org","session"); 
if($uorg == 0){     
$ortw = getwert($ort,"orte","was","id"); 
if($ortw == 'dorf'&&$ort != 13){         
$ulevel = getwert(session_id(),"charaktere","level","session");     
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
if($ulevel < 20){
$nrank = 'genin';
}
else{
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "Chuninweste" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$hatweste = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$hatweste = 1;
}
$result->close();$db->close(); 
if($ulevel < 30){
if($hatweste == 1){
$nrank = 'chuunin';
}
else{
$nrank = 'genin';
}
}
else{
if($ulevel < 50){
$nrank = 'chuunin';
}
else{
$nrank = 'jounin';
}
}
}
 $sql="UPDATE charaktere SET rank ='$nrank',mmissi ='0',dorf ='$ort' WHERE id = '".$uid."' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }   
      $sql="UPDATE items SET bild ='bilder/items/stirnband.png',name ='Stirnband' WHERE besitzer = '".$uid."' AND name='Nuke Stirnband' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      }  
      $sql="DELETE FROM items WHERE besitzer = '".$uid."' AND name='Nuke-Nin Mantel' LIMIT 1";
      if (!mysqli_query($con, $sql))
      {
      die('Error: ' . mysqli_error($con));
      } 
      $error = 'Du bist dem Dorf beigetreten.';
      mysqli_close($con);
}
else{
$error = 'Du musst dich in einem Dorf befinden.';
}
}
else{
$error = 'Du musst zuerst deine Organisation verlassen.';
}
}
else{
$error = "Auf einer Mission kannst du nicht zum Dorfninja werden.";
}
}
}
}
else{
$error = 'Du musst zunächst den Krieg verlassen.';
}
}
if($aktion == "nuke"){    
if($kin == 0||$bijuu != ''){
$org = getwert(session_id(),"charaktere","org","session");
if($org == '0'){  
if($urank != "student"&&$urank != "nuke-nin"){
if($umissi == "0"){  
if($_POST['check'] == 'check'){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET rank ='nuke-nin',dorf ='kein',oapply ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
$sql="UPDATE items SET bild ='bilder/items/nheadband.png',name ='Nuke Stirnband' WHERE besitzer = '".$uid."' AND name='Stirnband' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
$sql="DELETE FROM items WHERE besitzer = '".$uid."' AND name='Anbu Rüstung' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$sql="DELETE FROM items WHERE besitzer = '".$uid."' AND name='Kage Umhang' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
if($urank == "genin"){
$krimi = 0;
}     
if($urank == "chuunin"){
$krimi = 250;
}     
if($urank == "jounin"){
$krimi = 500;
}    
if($urank == "anbu"){
$krimi = 750;
}     
if($urank == "kage"){
$krimi = 1000;
}  
$urank = 'nuke-nin';   
$sql="UPDATE charaktere SET mmissi ='$krimi' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
mysqli_close($con); 
$error = "Du bist nun ein Nuke-Nin.";
}
}
else{
$error = "Auf einer Mission kannst du nicht zum Nuke-Nin werden.";
}
}
}
else{
$error = 'Du musst zuerst dein Team verlassen.';
}
}
else{
$error = 'Du musst zunächst den Krieg verlassen.';
}
}
if($aktion == "weg"){
if($reisenpc != 0||$reiseitem != 0){                       
$uid = getwert(session_id(),"charaktere","id","session"); 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET reisenpc ='0',reiseitem ='0',reiseianzahl ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}    
mysqli_close($con); 
$error = "Du bist weggegangen.";
}
}
if($aktion == 'nehmen'){ 
if($reiseitem != 0){
$anzahl = getwert(session_id(),"charaktere","reiseianzahl","session");
 $db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
shop,
preis,
beschreibung,
bild,
werte,
typ,
anlegbar
FROM
item
WHERE id = "'.$reiseitem.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 1;
$iname = $row['name'];
$iwerte = $row['werte'];
$ibild = $row['bild'];
$ityp = $row['typ'];
$ianlegbar = $row['anlegbar'];
}
$result->close();$db->close();
$slots = checkslots($uid);
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
angelegt
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$iname.'" AND anzahl != "99" AND angelegt = ""
ORDER BY
name,
besitzer
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$gibt = 0;
//BEISPIEL: 1 Item 99 , 1 Item 97 , 1 Item 20 = 81
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gibt = 1;
$tint = $tint+(99-$row['anzahl']);
}
$result->close();$db->close();
if($gibt == 0){ //Item gibt es nicht
if($slots[1] != 0){
//Neues Item erstellen    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO items(
`name`,
bild,   
besitzer,
typ,
anlegbar,
anzahl)
VALUES
('$iname',
'$ibild',  
'$uid',
'$ityp',
'$ianlegbar',
'$anzahl')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
$sql="UPDATE charaktere SET reiseitem ='0',reiseianzahl ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
mysqli_close($con); 
$error = 'Du hast das Item genommen.';
}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}

}
else{
$geht = 1;
//item 1 97 , item 2 98 , also 3 
if($tint < $anzahl){  
if($slots[1] == 0){
$geht = 0;
}
}
if($geht == 1){
//Ersmal bei allen anderen items das addieren    
  
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
angelegt
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$iname.'" AND anzahl != "99" AND angelegt = ""
ORDER BY
name,
besitzer
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
//BEISPIEL: 1 Item 99 , 1 Item 97 , 1 Item 20 , kaufe 10
$nanzahl = $row['anzahl']+$anzahl; //bei 97+10 = 107
if($nanzahl > 99){
$anzahl = $nanzahl-99; //nunoch 77
$nanzahl = 99;
}
else{
$anzahl = 0;
}
$sql="UPDATE items SET anzahl ='$nanzahl' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close();$db->close();
if($anzahl != 0){  
$sql="INSERT INTO items(
`name`,
bild,   
besitzer,
typ,
anlegbar,
anzahl)
VALUES
('$iname',
'$ibild',  
'$uid',
'$ityp',
'$ianlegbar',
'$anzahl')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}     
$sql="UPDATE charaktere SET reiseitem ='0',reiseianzahl ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}        
$error = 'Du hast das Item genommen.';
mysqli_close($con); 

}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}

}
}
}
if($aktion == "vertrag"){     
$rvertrag = getwert($reisenpc,"npc","vgemacht","id");
$vertrag = $_POST['vertrag'];
if($rvertrag == $vertrag){
$uvertrag = getwert(session_id(),"charaktere","vertrag","session");  
$uclan = getwert(session_id(),"charaktere","clan","session");
if($uclan != "kumo"&&$uclan != "frosch"&&$uclan != "schlange"&&$uclan != 'ishoku sharingan'&&$uclan != 'kamizuru'){                                        
$uid = getwert(session_id(),"charaktere","id","session"); 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="UPDATE charaktere SET vertrag ='$vertrag' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
mysqli_close($con); 
$error = "Du hast den Vertrag unterschrieben.";
}
else{
$error = "Diesen Vertrag kannst du nicht ändern.";
}
}
else{
$error = "Dieser NPC bietet diesen Vertrag nicht an.";
}
}
if($aktion == "kaufen"){
$iid = $_POST['iid'];
$anzahl = $_POST['anzahl'];       
$ritems = getwert($reisenpc,"npc","items","id");
$count = 0;
$geht = 0;
$array = explode(";", trim($ritems));
while(isset($array[$count])){   
if($array[$count] == $iid){
$geht = 1;
}
$count++;
}
if($geht == 1){
if($anzahl > 0&&$anzahl <= 10){
$uryo = getwert(session_id(),"charaktere","ryo","session"); 
$uid = getwert(session_id(),"charaktere","id","session"); 
$slots = checkslots($uid);     
$kanzahl = $anzahl;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
shop,
preis,
beschreibung,
bild,
werte,
typ,
anlegbar
FROM
item
WHERE id = "'.$iid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$geht = 1;
$preis = $anzahl*$row['preis'];
$iname = $row['name'];
$iwerte = $row['werte'];
$ibild = $row['bild'];
$ityp = $row['typ'];
$ianlegbar = $row['anlegbar'];
}
$result->close();$db->close();
if($geht == 1){
$nuryo = $uryo-$preis;
if($nuryo >= 0){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
angelegt
FROM
items          
WHERE besitzer = "'.$uid.'" AND name = "'.$iname.'" AND anzahl != "99" AND angelegt = ""
ORDER BY
name,
besitzer
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$gibt = 0;
//BEISPIEL: 1 Item 99 , 1 Item 97 , 1 Item 20 = 81
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gibt = 1;
$tint = $tint+(99-$row['anzahl']);
}
$result->close();$db->close();
if($gibt == 0){ //Item gibt es nicht
if($slots[1] != 0){
//Neues Item erstellen    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO items(
`name`,
bild,   
besitzer,
typ,
anlegbar,
anzahl)
VALUES
('$iname',
'$ibild',  
'$uid',
'$ityp',
'$ianlegbar',
'$anzahl')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}     
$sql="UPDATE charaktere SET ryo ='$nuryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
mysqli_close($con); 
$error = 'Du hast '.$iname.' '.$kanzahl.'x gekauft.';
}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}

}
else{
$geht = 1;
//item 1 97 , item 2 98 , also 3 
if($tint < $anzahl){  
if($slots[1] == 0){
$geht = 0;
}
}
if($geht == 1){
//Ersmal bei allen anderen items das addieren    
  
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
angelegt
FROM
items     
WHERE besitzer = "'.$uid.'" AND name = "'.$iname.'" AND anzahl != "99" AND angelegt = ""
ORDER BY
name,
besitzer
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
//BEISPIEL: 1 Item 99 , 1 Item 97 , 1 Item 20 , kaufe 10
$nanzahl = $row['anzahl']+$anzahl; //bei 97+10 = 107
if($nanzahl > 99){
$anzahl = $nanzahl-99; //nunoch 77
$nanzahl = 99;
}
else{
$anzahl = 0;
}
$sql="UPDATE items SET anzahl ='$nanzahl' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$result->close();$db->close();
if($anzahl != 0){  
$sql="INSERT INTO items(
`name`,
bild,   
besitzer,
typ,
anlegbar,
anzahl)
VALUES
('$iname',
'$ibild',  
'$uid',
'$ityp',
'$ianlegbar',
'$anzahl')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}        
$sql="UPDATE charaktere SET ryo ='$nuryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$error = 'Du hast '.$iname.' '.$kanzahl.'x gekauft.';
mysqli_close($con); 

}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}
}
}
else{
$error = 'Du hast nicht genügend Ryo.';
}
}

}
else{
$error = 'Du kannst soviele nicht gleichzeitig kaufen.';
}
}
}
if($aktion == "lern"){   
$uaktion = getwert(session_id(),"charaktere","aktion","session");
if($uaktion == ""){
$jutsu = $_GET['jutsu'];
$rjutsus = getwert($reisenpc,"npc","jutsus","id");
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");    
$uclan = getwert(session_id(),"charaktere","clan","session");
$uelemente = getwert(session_id(),"charaktere","elemente","session");      
$ulevel = getwert(session_id(),"charaktere","level","session");
$count = 0;
$c3 = 0;
$array = explode(";", trim($rjutsus));
while(isset($array[$count])){   
$count2 = 0; 
if($array[$count] != 1&&$array[$count] != 2){
$geht = 1;       
}
else{
$geht = 0;
}
$array2 = explode(";", trim($ujutsus));
while(isset($array2[$count2])){   
if($array[$count] == $array2[$count2]){
$geht = 0;
}
$count2++;
}
if($geht == 1){
if($array[$count] == $jutsu){
$jreq = getwert($array[$count],"jutsus","req","id");  
$jelement = getwert($array[$count],"jutsus","element","id");  
$jclan = getwert($array[$count],"jutsus","clan","id");      
$jutsuben = getwert($array[$count],"jutsus","jutsuben","id");   
$jutsulevel = getwert($array[$count],"jutsus","level","id");   
$geht = 1;   
$geht2 = 1;  
if($jutsulevel != 0){
if($ulevel < $jutsulevel){
$geht = $geht-1;   
$geht2 = 0;     
$error = $error.'<br>Du musst mindestens auf Level '.$jutsulevel.' sein.';
}
}
if($jutsuben != "0"){
$geht = $geht-1;
$jut = explode(";", trim($ujutsus));
$count2 = 0;             
while(isset($jut[$count2])){   
if($jut[$count2] == $jutsuben){
$geht = $geht+1;
}
$count2++;
}
if($geht <= 0){     
$jbenn = getwert($jutsuben,"jutsus","name","id");     
$error = $error.'<br>Du benötigst das Jutsu '.$jbenn.'.';
}
}         
if($jelement != ""){
$geht = $geht-1;
$ele = explode(";", trim($uelemente));
$count2 = 0;
while(isset($ele[$count2])){   
if($ele[$count2] == $jelement){
$geht = $geht+1;
}
$count2++;
}
if($geht <= 0){
$error = $error.'<br>Du benötigst das '.$jelement.' Element.';
}
} 
if($geht < 0){
$geht = 0;
}
if($jclan != ""&&$uclan != $jclan){
$geht = 0;
$error = $error.'<br>Dies ist ein Bluterbenjutsu. Du kannst es nicht lernen.';
}  
$req = explode(";", trim($jreq));
$hrp = $req[0];      
$uhp = getwert(session_id(),"charaktere","mhp","session");
if($uhp < $hrp){
$geht = 0;                   
$error = $error.'<br>Du benötigst '.$hrp.' HP.';
}
$rchr = $req[1]; 
$uchr = getwert(session_id(),"charaktere","mchakra","session");  
if($uchr < $rchr){
$geht = 0;            
$error = $error.'<br>Du benötigst '.$rchr.' Chakra.';
}
$rkr = $req[2]; 
$ukr = getwert(session_id(),"charaktere","mkr","session"); 
if($ukr < $rkr){
$geht = 0;                                
$error = $error.'<br>Du benötigst '.$rkr.' Kraft.';
}
$rint = $req[3]; 
$uint = getwert(session_id(),"charaktere","mintl","session");  
if($uint < $rint){
$geht = 0;                                       
$error = $error.'<br>Du benötigst '.$rint.' Intelligenz.';
}
$rchrk = $req[4]; 
$uchrk = getwert(session_id(),"charaktere","mchrk","session"); 
if($uchrk < $rchrk){
$geht = 0;                    
$error = $error.'<br>Du benötigst '.$rchrk.' Chakrakontrolle.';
}
$rtmp = $req[5];
$utmp = getwert(session_id(),"charaktere","mtmp","session"); 
if($utmp < $rtmp){
$geht = 0;          
$error = $error.'<br>Du benötigst '.$rtmp.' Tempo.';
}
$rgnk = $req[6]; 
$ugnk = getwert(session_id(),"charaktere","mgnk","session"); 
if($ugnk < $rgnk){
$geht = 0;             
$error = $error.'<br>Du benötigst '.$rgnk.' Genauigkeit.';
}
$rwid = $req[7]; 
$uwid = getwert(session_id(),"charaktere","mwid","session"); 
if($uwid < $rwid){
$geht = 0;
$error = $error.'<br>Du benötigst '.$rwid.' Widerstand.';
}
$hatitem = 0;              
$jitem = getwert($jutsu,"jutsus","item","id");  
if($jitem == ""){
$hatitem = 1;
}
else{
$array2 = explode(";", trim($jitem));
$count2 = 0;
while(isset($array2[$count2])){    
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$array2[$count2].'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['angelegt'] == 'LHand'||$row['angelegt'] == 'RHand'||$row['angelegt'] == 'LHand&RHand'){
$hatitem = 1;
}
}
$result->close();  
$count2++;
}
} 
if($hatitem == 0){
$geht = 0;
$error = $error.'<br>Du hast nicht das benötigte Item angelegt.';
}
if($geht == 1){
//Lern
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));       
$uid = getwert(session_id(),"charaktere","id","session");    
$dauer = getwert($array[$count],"jutsus","dauer","id");     
$jname = getwert($array[$count],"jutsus","name","id");               
$uaktion = $jname.' lernen';          
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);    
$sql="UPDATE charaktere SET aktion ='$uaktion',aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}         
mysqli_close($con); 
$error = 'Du lernst nun '.$jname.'.';
}  
}
}
$count++;
}
}
else{
$error = "Du tust bereits etwas.";
}

}
if($aktion == "missi"){
$uid = getwert(session_id(),"charaktere","id","session");    
// Build POST request:
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_secret = '6LdMP7kUAAAAAPPjqniyH1IXcw2U8mCI2pF_s7Pm';
$recaptcha_response = $_POST['g-recaptcha-response'];
// Make and decode POST request:
$recaptcha = file_get_contents($recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$recaptcha_response);
$recaptcha = json_decode($recaptcha);
if($recaptcha && $recaptcha->success)
{
  $account->UpdateRecaptcha($recaptcha);
  if(false && $recaptcha->score < 0.7)
  {
    $uname = getwert(session_id(),"charaktere","name","session");
    $betreff = 'Recaptcha '.$uname;
    $pmtext = $uname.' ('.$uid.') hatte eine Score von '.$recaptcha->score.' bei der Mission';
    $zeit2 = time();
    $zeit = date("YmdHis",$zeit2);
    $anid = 1;
    $senderid = 0;
    $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
    mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
    $sql="INSERT INTO pms(
    `id`,`an`,`von`,`betreff`,`text`,`date`)
    VALUES
    ('".uniqid()."',
    '$anid',
    '$senderid',
    '$betreff',
    '$pmtext',
    '$zeit')";
    if (!mysqli_query($con, $sql))
    {
    die('Error: ' . mysqli_error($con));
    }  
    mysqli_close($con); 
  }
}
  
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
missions
WHERE id = "'.$umissi.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;
$count = 0;
$istda = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$array = explode("@", trim($row['wo']));  
$array2 = explode("$", trim($array[$uwo]));  
while(isset($array2[$count])){    
if($array2[$count] == $ort){
$istda = 1;
}
$count++;
}
if($istda == 1){
$array = explode("@", trim($row['was']));
$was = $array[$uwo];
$array = explode("@", trim($row['art']));
$art = $array[$uwo];
if($art == 1){
$geht = 1;
}
if($art == 2){
$geht = 1;
}   
if($art == 4){
$geht = 1;
}
}
else{
$error = "Du bist am falschen Ort.";
}
}
$result->close();
$db->close();
if($geht == 1){
if($art == 1){        
$uid = getwert(session_id(),"charaktere","id","session");
mission($uid);
$error = "Unterhaltung beendet.";
}

if($art == 2){
$uhp = getwert(session_id(),"charaktere","hp","session");
$ukid = getwert(session_id(),"charaktere","kampfid","session");
if($uhp > 0&&$ukid == 0){   
$count = 0;  
$team[1] = 1;
$teams = 1;
$array = explode("vs", trim($was));
//BauervsHamtaro;Hamtaro

while(isset($array[$count])){         
$count2 = 0;   
if($array[$count] != 0){
$count3 = $count+1;     
$array2 = explode(";", trim($array[$count]));
while(isset($array2[$count2])){    
$count2++;   
$team[$count3]++;
}
if($count3 != 1){
$teams = $teams.';'.$count3;
}
}
$count++;
}

$count = 1;
while(isset($team[$count])){    
$kmode = $kmode.$team[$count];
$count2 = $count+1;
if($team[$count2] != ""){
$kmode = $kmode.'vs';
}
$count++;
}       
$kname = getwert($umissi,"missions","name","id");    
$uid = getwert(session_id(),"charaktere","id","session");
ausruest($uid);
$owetter = getwert($ort,"orte","wetter","id");
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
mission,
wetter)
VALUES
('$kname',
'$kmode',
'1',
'$teams',
'Mission',
'0',
'1',
'',
'$ort',
'$umissi',
'$owetter')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                            
$kid = mysqli_insert_id($con);     
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);     
$uname = getwert(session_id(),"charaktere","name","session"); 
$ubild = getwert(session_id(),"charaktere","kbild","session");
$sql="UPDATE charaktere SET 
kampfid ='$kid',
lkaktion ='$zeit',
kname ='$uname',
powerup='',
dstats='',
debuff='',
kkbild ='$ubild',
team='1'            
 WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
  
$count = 0;   
$count3 = 0;
$array = explode("vs", trim($was));
while(isset($array[$count])){         
$count2 = 0;   
$array2 = explode(";", trim($array[$count]));
while(isset($array2[$count2])){    
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
npc';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['id'] == $array2[$count2]){ 
$nteam = $count+1;   
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
$vertrag = $row['vgemacht']; 
$npcid = $row['id'];

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
}
$result->close();
$db->close();
$count2++;
}
$count++;
}
$error = 'Kampf wurde gestartet.<br><a href="fight.php">Klick mich</a><br>';
}
else{
if($uhp == 0){
$error = $error."Deine HP ist zu niedrig.<br>";
}
if($ukid != 0){
$error = $error."Du bist schon in ein Kampf.<br>";
}
}

}
if($art == 4){     
$uaktion = getwert(session_id(),"charaktere","aktion","session");  
if($uaktion == ""){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
$array = explode(";", trim($was));
$dauer = $array[1];
$uid = getwert(session_id(),"charaktere","id","session"); 
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                           
$sql="UPDATE charaktere SET aktion ='Mission',aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}        
mysqli_close($con);
$error = 'Du führst nun die Mission aus.';
}
else{
$error = "Du tust bereits etwas.";
}
}
}

}
}
if(logged_in()){
include 'inc/design1.php';
include 'inc/bbcode.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}

//Missionscheck
$umissi = getwert(session_id(),"charaktere","mission","session");
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
missions
WHERE id = "'.$umissi.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$is = 0;
$count = 0;                   
$istda = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$array = explode("@", trim($row['wo']));  
$array2 = explode("$", trim($array[$uwo]));  
while(isset($array2[$count])){    
if($array2[$count] == $ort){
$istda = 1;
}
$count++;
}
if($istda == 1){
$array = explode("@", trim($row['was']));
$was = $array[$uwo];
$array = explode("@", trim($row['art']));
$art = $array[$uwo];
$array = explode("@", trim($row['aufgabe']));  
$aufgabe = $array[$uwo];       
if($art == 1){
$is = 1;
//Gespräch
$array = explode(";", trim($was));
$npc = $array[0];
$ntext = $array[1];
echo '<center><table class="table" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder" colspan="2">';
$nname = getwert($npc,"npc","name","id");
echo 'Gespräch: <a href="user.php?id='.$nname.'">'.$nname.'</a>';
echo '</td>';
echo '</tr>';

$nbild = getwert($npc,"npc","bild","id");
echo '<tr><td class="shadow tdborder"><img src="'.$nbild.'"></img></td>';
echo '<td class="shadow tdborder">';
echo $bbcode->parse ($ntext);
echo '</td></tr>';
echo '<tr><td height="30px" colspan="2">';
?>
  <div id="captcha_text">
    Lade ...
  </div>
<?php
echo '<form method="post" id="captcha" style="display:none" action="ort.php?aktion=missi"><input class="button" name="login" id="login" value="Weiter" type="submit"></form>';
echo '<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
  <input type="hidden" name="action" value="validate_captcha">';
echo '</form>';
echo '</td></tr>';
echo '</table><br>';

}
if($art == 2){       
$is = 1;
//Kampf
//BauervsHamtaro;Hamtaro
echo '<center><table class="table" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">';
echo 'Kampf: ';
$uid = getwert(session_id(),"charaktere","id","session");
echo '<a href="user.php?id='.$uid.'">Du</a> ';
$array = explode("vs", trim($was));
$count = 0;
$hat = 0;
//0vs2vs2;2vs2
while(isset($array[$count])){   
$count2 = 0;
if($count == 1)
 $hat = 1;
$array2 = explode(";", trim($array[$count]));
while(isset($array2[$count2])){    
if($array2[$count2] != 0){
if($hat == 0){     
$hat = 1;
echo ' , ';
}
$nname = getwert($array2[$count2],"npc","name","id");
echo '<a href="user.php?id='.$nname.'">'.$nname.'</a>';
}
$count2++;
if($array2[$count2] != ""){
echo ' , ';
}
}
$count3 = $count+1;
if($array[$count3] != ""){
echo ' vs ';
}
$count++;
}
echo '</td>';
echo '</tr>';
echo '<tr><td height="110px">';
$ubild = getwert(session_id(),"charaktere","kbild","session");
if($ubild == ""){
$ubild = "bilder/nokpic.png";
}
echo '<img width="100px" height="100px" src="'.$ubild.'"></img> ';

$array = explode("vs", trim($was));
$count = 0;
while(isset($array[$count])){   
$count2 = 0;
$array2 = explode(";", trim($array[$count]));
while(isset($array2[$count2])){    
if($array2[$count2] != 0){
$nbild = getwert($array2[$count2],"npc","kbild","id");
echo '<img width="100px" height="100px" src="'.$nbild.'"></img> ';
}
$count2++;

}
$count3 = $count+1;
if($array[$count3] != ""){
echo ' vs ';
}
$count++;
}

echo '</td></tr>';
echo '<tr><td class="shadow tdborder">';
echo $bbcode->parse ($ntext);
echo '</td></tr>';
echo '<tr><td height="30px">';
  ?>
  <div id="captcha_text">
    Lade ...
  </div>
<?php
echo '<form method="post" id="captcha" style="display:none" action="ort.php?aktion=missi"><input class="button" name="login" id="login" value="Kampf starten" type="submit">';
echo '<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
  <input type="hidden" name="action" value="validate_captcha">';
echo '</form>';
echo '</td></tr>';
echo '</table><br>';

}
if($art == 4){
$is = 1;
//Warten
$array = explode(";", trim($was));
$npc = $array[0];       
$dauer = $array[1];
$ntext = $array[2];
echo '<center><table class="table" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder" colspan="2">';
echo $aufgabe;
echo '</td>';
echo '</tr>';
$nbild = getwert($npc,"npc","bild","id");
echo '<tr><td class="shadow tdborder"><img src="'.$nbild.'"></img></td>';
echo '<td class="shadow tdborder">';
echo $bbcode->parse ($ntext);
echo '<br><br>';
echo 'Dauer: ';
$hours = floor($dauer/60);  
$minutes = $dauer-($hours*60);
if($hours != 0)
{
  echo $hours;
  if($hours == 1)
    echo ' Stunde';
  else
    echo ' Stunden';
}
  echo ' ';
if($minutes != 0)
{
  echo $minutes;
  if($minutes == 1)
    echo ' Minute';
  else
    echo ' Minuten';
}
echo '</td></tr>';
echo '<tr><td height="30px" colspan="2">';
?>
  <div id="captcha_text">
    Lade ...
  </div>
<?php
echo '<form method="post" id="captcha" style="display:none" action="ort.php?aktion=missi"><input class="button" name="login" id="login" value="Weiter" type="submit">';
echo '<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
  <input type="hidden" name="action" value="validate_captcha">';
echo '</form>';
echo '</td></tr>';
echo '</table><br>';



}
}
}
$result->close();
$db->close();          
if($is == 0){
$reisenpc = getwert(session_id(),"charaktere","reisenpc","session");   
$reiseitem = getwert(session_id(),"charaktere","reiseitem","session");
if($reiseitem != 0){             
$ritema = getwert(session_id(),"charaktere","reiseianzahl","session");   
$rbild = getwert($reiseitem,"item","bild","id");
echo '<center>';
echo '<div class="slot" style="position:relative;">';                  
echo '<div style="position:absolute; z-index:0; width:50px; height:50px; background:url('.$rbild.');"></div>';  
echo '<div style="position:absolute; z-index:1; left:2px; top:30px;">'; 
echo '<b>'.$ritema.'x</b>';  
echo '</div>';                                                                     
$ibesch = getwert($reiseitem,"item","beschreibung","id");
echo '<a class="sinfo">';    
echo '<div style="position:absolute; z-index:0; width:50px; height:50px;">'; 
$iwerte = getwert($reiseitem,"item","werte","id");      
if($row['typ'] == 1){                                  
$array = explode(";", trim($iwerte));
$ihph = $array[0];
$ichakrak = $array[1];
$ibesch = $ibesch.'<br>Heilt ';
if($ihph != 0){         
$ibesch = $ibesch.$ihph.' HP';
if($ichakrak != 0){      
$ibesch = $ibesch.' und '.$ichakrak.' Chakra';
}
}
else{  
$ibesch = $ibesch.$ichakrak.' Chakra';
}
$ibesch = $ibesch.'.';
}
if($row['typ'] == 3){                                  
$array = explode(";", trim($iwerte));
$ikr = $array[0];
$iint = $array[1];
$ichrk = $array[2];
$itmp = $array[3];
$ignk = $array[4];   
$iwid = $array[5];
$islots = $array[6];
if($ikr != 0){
$ibesch = $ibesch.'<br>Erhöht Kraft um '.$ikr.'.';
}
if($iint != 0){
$ibesch = $ibesch.'<br>Erhöht Intelligenz um '.$iint.'.';
}
if($ichrk != 0){
$ibesch = $ibesch.'<br>Erhöht Chakrakontrolle um '.$ichrk.'.';
}
if($itmp != 0){
$ibesch = $ibesch.'<br>Erhöht Tempo um '.$itmp.'.';
}
if($ignk != 0){
$ibesch = $ibesch.'<br>Erhöht Genauigkeit um '.$ignk.'.';
}
if($iwid != 0){
$ibesch = $ibesch.'<br>Erhöht Widerstand um '.$iwid.'.';
} 
if($islots != 0){
$ibesch = $ibesch.'<br>Erhöht Slots um '.$islots.'.';
}
}
echo '<span class="spanitem">'.$ibesch.'</span>';
echo '</div>';             
echo '</a>';    
echo '</div>';    
echo '</center>';           
$itemn = getwert($reiseitem,"item","name","id");   
echo '<br>Du hast '.$ritema.'x '.$itemn.' gefunden.';  
echo '<br><br><form method="post" action="ort.php?aktion=nehmen">';
echo '<input class="button" name="login" id="login" value="Items nehmen" type="submit"></form>';      
echo '<br><form method="post" action="ort.php?aktion=weg">';    
echo '<input class="button" name="join" id="login" value="liegen lassen" type="submit">';
echo '</form>';
}
elseif($reisenpc != 0){                   
$rname = getwert($reisenpc,"npc","name","id");
$rbild = getwert($reisenpc,"npc","bild","id");
echo '<center><table class="table "><tr><td class="tdborder tdbg" colspan="2">'.ucwords($rname).'</td></tr>';
echo '<tr><td><img src="'.$rbild.'"></img></td>'; 
echo '<td>';  
//Vertrag       
$rvertrag = getwert($reisenpc,"npc","vgemacht","id");
if($rvertrag != ""){
$vertrag = getwert(session_id(),"charaktere","vertrag","session"); 
$uclan = getwert(session_id(),"charaktere","clan","session"); 
if($uclan != "kumo"&&$uclan != "frosch"&&$uclan != "schlange"){   
echo '<h3>Vertrag</h3>';
echo '<br>';
echo 'Ich biete dir an, einen Vertrag mit den <b>';
if($rvertrag == "schnecke"){
echo 'Schnecken';
}
if($rvertrag == "schlange"){
echo 'Schlangen';
}
if($rvertrag == "frosch"){
echo 'Fröschen';
}       
if($rvertrag == "krähe"){
echo 'Krähen';
}        
if($rvertrag == "dämon"){
echo 'Dämonen';
}        
if($rvertrag == "falke"){
echo 'Falken';
}               
if($rvertrag == "hai"){
echo 'Haie';
}     
if($rvertrag == "affe"){
echo 'Affen';
}             
if($rvertrag == "eule"){
echo 'Eulen';
}         
if($rvertrag == "salamander"){
echo 'Salamandern';
}
echo '</b> einzugehen.';   
echo '<br><form method="post" action="ort.php?aktion=vertrag">';
echo '<input type="hidden" value="'.$rvertrag.'" name="vertrag">'; 
echo '<input class="button" name="login" id="login" value="unterschreiben" type="submit"></form>';
}
echo '<br><br>';
}
//Jutsus lernen
$rjutsus = getwert($reisenpc,"npc","jutsus","id");
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");         
$uclan = getwert(session_id(),"charaktere","clan","session");
$uelemente = getwert(session_id(),"charaktere","elemente","session");       
$ulevel = getwert(session_id(),"charaktere","level","session");     
$jutsus = array();
$count = 0;
$c3 = 0;
$hatjutsus == 0;
$array = explode(";", trim($rjutsus));
while(isset($array[$count])){   
$count2 = 0;       
$geht = 1;                  
$jlehr = getwert($array[$count],"jutsus","lehrbar","id");   
$jelement = getwert($array[$count],"jutsus","element","id");  
$jclan = getwert($array[$count],"jutsus","clan","id");  
$jutsuben = getwert($array[$count],"jutsus","jutsuben","id");      
$jutsulevel = getwert($array[$count],"jutsus","level","id");   
if($jclan != ""&&$uclan != $jclan){
$geht = 0;
}
if($jlehr == 1){
$hatjutsus = 1;
}
else{
$geht = 0;
}
$array2 = explode(";", trim($ujutsus));
while(isset($array2[$count2])){    
if($array[$count] == $array2[$count2]){
$geht = 0;
}
$count2++;
}
if($geht == 1){      
$jreq = getwert($array[$count],"jutsus","req","id");   
$req = explode(";", trim($jreq));                    
$geht = 1;
if($jutsuben != "0"){
$geht = $geht-1;
$jut = explode(";", trim($ujutsus));
$count2 = 0;
while(isset($jut[$count2])){    
if($jut[$count2] == $jutsuben){
$geht = $geht+1;
}
$count2++;
}
}       
if($jutsulevel != 0){
if($ulevel < $jutsulevel){
$geht = $geht-1;
}
}
if($jelement != ""){
$geht = $geht-1;
$ele = explode(";", trim($uelemente));
$count2 = 0;
while(isset($ele[$count2])){    
if($ele[$count2] == $jelement){
$geht = $geht+1;
}
$count2++;
}
}
if($geht < 0){
$geht = 0;
}
$hrp = $req[0];      
$uhp = getwert(session_id(),"charaktere","mhp","session");
if($uhp < $hrp){
$geht = 0;
}
$rchr = $req[1]; 
$uchr = getwert(session_id(),"charaktere","mchakra","session");  
if($uchr < $rchr){
$geht = 0;
}
$rkr = $req[2]; 
$ukr = getwert(session_id(),"charaktere","mkr","session"); 
if($ukr < $rkr){
$geht = 0;
}
$rint = $req[3]; 
$uint = getwert(session_id(),"charaktere","mintl","session");  
if($uint < $rint){
$geht = 0;
}
$rchrk = $req[4]; 
$uchrk = getwert(session_id(),"charaktere","mchrk","session"); 
if($uchrk < $rchrk){
$geht = 0;
}
$rtmp = $req[5];
$utmp = getwert(session_id(),"charaktere","mtmp","session"); 
if($utmp < $rtmp){
$geht = 0;
}
$rgnk = $req[6]; 
$ugnk = getwert(session_id(),"charaktere","mgnk","session"); 
if($ugnk < $rgnk){
$geht = 0;
}
$rwid = $req[7]; 
$uwid = getwert(session_id(),"charaktere","mwid","session"); 
if($uwid < $rwid){
$geht = 0;
}
$hatitem = 0;      
$jitem = getwert($array[$count],"jutsus","item","id");  
if($jitem == ""){
$hatitem = 1;
}
else{            
$array2 = explode(";", trim($jitem));
$count2 = 0;
while(isset($array2[$count2])){         
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$array2[$count2].'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['angelegt'] == 'LHand'||$row['angelegt'] == 'RHand'||$row['angelegt'] == 'LHand&RHand'){
$hatitem = 1;
}
}
$result->close();  
$count2++;
}
} 
if($hatitem == 0){
$geht = 0;
}
if($geht == 1){
$jutsus[$c3] = $array[$count];    
$jgeht[$c3] = 1;
$c3++;
}
else{   
$jutsus[$c3] = $array[$count];    
$jgeht[$c3] = 0;
$c3++;

}
}
$count++;
}
if($hatjutsus == 1){
echo '<h3>Jutsus</h3><br>';
echo 'Diese Jutsus lehre ich:<br><br>';   
if($jutsus[0] != ""){
$count = 0;
while(isset($jutsus[$count])){     
$jname = getwert($jutsus[$count],"jutsus","name","id");   
$jbild = getwert($jutsus[$count],"jutsus","bild","id");     
$jlevel = getwert($jutsus[$count],"jutsus","level","id");  
if($jgeht[$count] == 1){
echo '<a class="sinfo" href="ort.php?aktion=lern&jutsu='.$jutsus[$count].'"><img src="bilder/jutsus/'.strtolower($jbild).'a.png" width="50px" height="50px"></img><span class="spanmap">'.$jname.'</span></a> ';
}
else{
if($ulevel < $jlevel){
$jname = $jname.'<br>Level '.$jlevel.' benötigt';
}
$jreq = getwert($jutsus[$count],"jutsus","req","id"); 
$req = explode(";", trim($jreq));
$hrp = $req[0];      
$uhp = getwert(session_id(),"charaktere","mhp","session");
if($uhp < $hrp){           
$jname = $jname.'<br>'.$hrp.' HP.';
}
$rchr = $req[1]; 
$uchr = getwert(session_id(),"charaktere","mchakra","session");  
if($uchr < $rchr){ 
$jname = $jname.'<br>'.$rchr.' Chakra.';
}
$rkr = $req[2]; 
$ukr = getwert(session_id(),"charaktere","mkr","session"); 
if($ukr < $rkr){                     
$jname = $jname.'<br>'.$rkr.' Kraft.';
}
$rint = $req[3]; 
$uint = getwert(session_id(),"charaktere","mintl","session");  
if($uint < $rint){                             
$jname = $jname.'<br>'.$rint.' Intelligenz.';
}
$rchrk = $req[4]; 
$uchrk = getwert(session_id(),"charaktere","mchrk","session"); 
if($uchrk < $rchrk){        
$jname = $jname.'<br>'.$rchrk.' Chakrakontrolle.';
}
$rtmp = $req[5];
$utmp = getwert(session_id(),"charaktere","mtmp","session"); 
if($utmp < $rtmp){
$jname = $jname.'<br>'.$rtmp.' Tempo.';
}
$rgnk = $req[6]; 
$ugnk = getwert(session_id(),"charaktere","mgnk","session"); 
if($ugnk < $rgnk){   
$jname = $jname.'<br>'.$rgnk.' Genauigkeit.';
}
$rwid = $req[7]; 
$uwid = getwert(session_id(),"charaktere","mwid","session"); 
if($uwid < $rwid){
$jname = $jname.'<br>'.$rwid.' Widerstand.';
}
echo '<a class="sinfo" href="ort.php?aktion=lern&jutsu='.$jutsus[$count].'"><img src="bilder/jutsus/'.strtolower($jbild).'.png" width="50px" height="50px"></img><span class="spanmap">'.$jname.'</span></a> ';
}
$count++;
}
}
else{
echo '<b class="shadow">Ich habe dir schon alles beigebracht, was ich kann.</b>';
}
echo '<br><br>';
}

//Jutsulern ende

//item kaufen

$ritems = getwert($reisenpc,"npc","items","id");
if($ritems != ""){
echo '<h3>Items</h3><br>';
echo '<b>Folgende Items biete ich an:</b><br><br>';  
echo '<table width="100%" cellspacing="0">';
$count = 0;
$it = explode(";", trim($ritems));
while(isset($it[$count])){     
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
shop,
preis,
beschreibung,
bild,
typ,
werte
FROM
item
WHERE id = "'.$it[$count].'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr>';
echo '<td>'.$row['name'].'</td>';
echo '<td><img src="'.$row['bild'].'"></img></td>'; 
echo '<td>'.$row['preis'].' Ryo</td>';         
$ibesch = $row['beschreibung'];       
if($row['typ'] == 1){                                  
$array = explode(";", trim($row['werte']));
$ihph = $array[0];
$ichakrak = $array[1];
$ibesch = $ibesch.'<br>Heilt ';
if($ihph != 0){         
$ibesch = $ibesch.$ihph.' HP';
if($ichakrak != 0){      
$ibesch = $ibesch.' und '.$ichakrak.' Chakra';
}
}
else{  
$ibesch = $ibesch.$ichakrak.' Chakra';
}
$ibesch = $ibesch.'.';
}
if($row['typ'] == 3){                                  
$array = explode(";", trim($row['werte']));
$ikr = $array[0];
$iint = $array[1];
$ichrk = $array[2];
$itmp = $array[3];
$ignk = $array[4];
$iwid = $array[5];
if($ikr != 0){
$ibesch = $ibesch.'<br>Erhöht Kraft um '.$ikr.'.';
}
if($iint != 0){
$ibesch = $ibesch.'<br>Erhöht Intelligenz um '.$iint.'.';
}
if($ichrk != 0){
$ibesch = $ibesch.'<br>Erhöht Chakrakontrolle um '.$ichrk.'.';
}
if($itmp != 0){
$ibesch = $ibesch.'<br>Erhöht Tempo um '.$itmp.'.';
}
if($ignk != 0){
$ibesch = $ibesch.'<br>Erhöht Genauigkeit um '.$ignk.'.';
}
if($iwid != 0){
$ibesch = $ibesch.'<br>Erhöht Widerstand um '.$iwid.'.';
}
}
echo '<td>'.$ibesch.'</td>';
echo '<td>';
echo '<form method="post" action="ort.php?aktion=kaufen">
<input type="hidden" value="'.$row['id'].'" name="iid"> 
<center><div class="auswahl2"> <select class="text" name="anzahl">';           
$tempint = 0;  
while($tempint < 10){
$tempint++;
echo '<option value="'.$tempint.'">'.$tempint.'';
echo '</option>';   
}  
echo '</select></div></center>'; 
echo '<input class="button" type="submit" value="kaufen"></form>'; 
echo '</td>';
echo '</tr>';
}
$result->close();$db->close();
$count++;
}
echo '</table>';
}
echo '</td></tr>';
echo '<tr><td colspan="2">';  
echo '<form method="post" action="ort.php?aktion=weg">';    
echo '<input class="button" name="join" id="login" value="weggehen" type="submit">';
echo '</form>';
echo '</td></tr>';
echo '</table></center><br>';

}
else{
$ort = getwert(session_id(),"charaktere","ort","session");        
$owas = getwert($ort,"orte","was","id");                                                        
$owetter = getwert($ort,"orte","wetter","id");  
if($owas != "reise"){      
$ortn = getwert($ort,"orte","name","id");                                                         
$ortb = getwert($ort,"orte","bild","id");                                                     
$ortbe = getwert($ort,"orte","beschreibung","id");  
}
else{   
$ortn = "Reise";                                                         
$ortb = "bilder/orte/reise.png";                                                     
$ortbe = "Ein schöner Reiseweg.";  

}

echo '<center><table class="table"><tr><td class="tdborder tdbg" colspan="2">'.ucwords($ortn).'</td></tr>';
echo '<tr><td>
<img src="'.$ortb.'"></img>
<div class="shadow" style="width:100px; height:100px; background:url(bilder/wetter/'.$owetter.'.png);"><br><br>'.$owetter.'</div>  

<br>
</td>'; 
echo '<td>';
echo $bbcode->parse ($ortbe);
echo '</td></tr>';  
echo '</table></center>';
if($urank != "student"&&$urank != "nuke-nin"){
echo '<br>';                 
echo '<b>Du kannst dein Dorf verlassen und ein Nuke-Nin werden.<br> Als Nuke-Nin kannst du nicht mehr ein Ninja eines Dorfes sein.</b>';       
echo '<br>';         
echo '<br>';                         
echo '<form method="post" action="ort.php?aktion=nuke">';   
echo '<input class="cursor" type="checkbox" name="check" value="check"> Sicher?<br>'; 
echo '<input class="button" name="join" id="login" value="Dorf verlassen" type="submit">';
echo '</form>';
}
elseif($urank == 'nuke-nin'&&$owas == 'dorf'&&$ort != 13){ 
if($mkage == ''){
echo '<br>';                 
echo '<b>Es befindet sich kein Kage im Dorf. <br>Du kannst dich zurück in das Dorf schleichen, um wieder ein Dorfninja zu werden.</b>';       
echo '<br>';         
echo '<br>';                         
echo '<form method="post" action="ort.php?aktion=schleichen">';   
echo '<input class="cursor" type="checkbox" name="check" value="check"> Sicher?<br>'; 
echo '<input class="button" name="join" id="login" value="Ins Dorf schleichen" type="submit">';
echo '</form>';
}
}
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