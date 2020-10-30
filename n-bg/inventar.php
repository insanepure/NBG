<?php
include 'inc/incoben.php';
if(logged_in()){                 
$uid = getwert(session_id(),"charaktere","id","session");
$ugender = getwert(session_id(),"charaktere","geschlecht","session");      
$ukid = getwert(session_id(),"charaktere","kampfid","session");
$was = $_GET['was'];                        
$iid = real_escape_string($_GET['iid']);
if($was == "use"||$was == "deuse"){
if($ukid == 0){                           
$ibesitzer = getwert($iid,"items","besitzer","id"); 
if($ibesitzer != 0){
if($ibesitzer == $uid){
$ityp = getwert($iid,"items","typ","id"); 
$ianzahl = getwert($iid,"items","anzahl","id"); 
//Typ 1 - benutzen    
//Typ 2 - werf
//Typ 3 - anlegen
if($was == "deuse"){
if($ityp == 3){     
$iangelegt = getwert($iid,"items","angelegt","id");
if($iangelegt != ""){                                   
$iname = getwert($iid,"items","name","id");  
$iwerte = getwert($iname,"item","werte","name");          
$iwertes = explode(";", trim($iwerte));    
$islots = $iwertes[6];
$geht = 1;
if($islots != 0){
$geht = 0;
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="UPDATE items SET angelegt ='' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
$slots = checkslots($uid);
if($slots[1] != 0){ 
$geht = 1;
}
$sql="UPDATE items SET angelegt ='$iangelegt' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
mysqli_close($con);   
}   
if($geht == 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
angelegt,
besitzer,
anlegbar,
name,
anzahl
FROM
items
WHERE besitzer="'.$uid.'" AND name = "'.$iname.'" AND anzahl != "99" AND angelegt = ""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$nanzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$nanzahl = $row['anzahl']+1;
$nid = $row['id'];
}
$result->close(); $db->close();   
if($nanzahl == 0){
$slots = checkslots($uid);
if($slots[1] != 0){ 
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="UPDATE items SET angelegt ='' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
$error = "Du hast das Item abgelegt.";
mysqli_close($con); 
}
else{
$error = 'Du hast nicht genügend Slots.';
}
}
else{      
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
$sql="UPDATE items SET anzahl ='$nanzahl' WHERE id = '".$nid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
$sql="DELETE FROM items WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
mysqli_close($con);      
}
$error = "Du hast das Item abgelegt.";
}
else{
$error = 'Du hast nicht genügend Slots.';
}
}
else{
$error = "Dieses Item ist nicht angelegt.";
}
}
}
elseif($was == "use"){
if($ityp == 6){        
$ulevel = getwert(session_id(),"charaktere","level","session");     
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
werte,
name,
bild,
typ,
anlegbar,
level,shop
FROM
item
WHERE inshop="1" AND level <="'.$ulevel.'" AND shop != "puppe"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$hatitem = false;     
$zufall2 = rand(1,10);
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($zufall2 != 1){
$zufall = rand(1,10);
if($zufall == 1&&$hatitem == false){
$hatitem = true;
$anzahl = 1;
$iname = $row['name'];
$iwerte = $row['werte'];
$ibild = $row['bild'];
$ityp = $row['typ'];
$ianlegbar = $row['anlegbar'];  
}
}
}
$result->close();
$db->close();
if($hatitem == true){  
$slots = checkslots($uid);     
$kanzahl = $anzahl;
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
ASC
LIMIT 1';
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
$ianzahl = $ianzahl-1;
if($ianzahl == 0){    
$sql="DELETE FROM items WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{ 
$sql="UPDATE items SET anzahl ='$ianzahl' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$error = 'Du hast '.$iname.' '.$kanzahl.'x erhalten!';
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
$ianzahl = $ianzahl-1;
if($ianzahl == 0){    
$sql="DELETE FROM items WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{ 
$sql="UPDATE items SET anzahl ='$ianzahl' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$error = 'Du hast '.$iname.' '.$kanzahl.'x erhalten!';
mysqli_close($con); 

}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}
}
}
else{$ianzahl = $ianzahl-1;
if($ianzahl == 0){    
$sql="DELETE FROM items WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{ 
$sql="UPDATE items SET anzahl ='$ianzahl' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$error = 'Du hast kein Item erhalten!';
}
}
elseif($ityp == 3){     
$ianlegbar = getwert($iid,"items","anlegbar","id");           
$ianlegbar2 = explode(";", trim($ianlegbar));    
if($ianlegbar2[1] != ""){
$geht = 2;
$gehtwo = $ianlegbar2[0];
}
else{     
$geht = 1;
$gehtwo = $ianlegbar;
}       
$ianlegbar3 = explode("&", trim($ianlegbar));
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
angelegt,
besitzer,
anlegbar
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false

if($ianlegbar3[1] != ""){
//Muss bei beiden hin
if($ianlegbar3[0] == $row['angelegt']||$ianlegbar3[1] == $row['angelegt']||$ianlegbar == $row['angelegt']){
$geht = 0;
}
}
else{
if($ianlegbar2[1] != ""){
if($row['angelegt'] == $ianlegbar2[0].'&'.$ianlegbar2[1]){
$geht = 0;
}
else{
if($ianlegbar2[0] == $row['angelegt']){
$geht = $geht-1;      
$gehtwo = $ianlegbar2[1];
}
if($ianlegbar2[1] == $row['angelegt']){    
$geht = $geht-1;
$gehtwo = $ianlegbar2[0];
}
}

}
else{         
$tanlegbar = explode("&", trim($row['angelegt']));
if($ianlegbar == $tanlegbar[0]||$ianlegbar == $tanlegbar[1]){
$geht = 0;
}
else{
if($row['angelegt'] == $ianlegbar){
$geht = 0;
}
}
}

}

}
$result->close();
$db->close();
if($geht != 0){   
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
if($ianzahl == 1){ 
$sql="UPDATE items SET angelegt ='$gehtwo' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}      
}
else{
$nanzahl = $ianzahl-1; 
$sql="UPDATE items SET anzahl ='$nanzahl' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}        
$iname = getwert($iid,"items","name","id"); 
$ibild = getwert($iid,"items","bild","id");     
$iwerte = getwert($iname,"item","werte","name");   
$sql="INSERT INTO items(
`name`,
bild,   
besitzer,
typ,
anlegbar,
anzahl,
angelegt)
VALUES
('$iname',
'$ibild',  
'$uid',
'$ityp',
'$ianlegbar',
'1',
'$gehtwo')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
$error = "Du hast das Item angelegt.";
mysqli_close($con); 
}


else{
$error = "Du kannst das Item nicht anlegen, da dort schon etwas angelegt wurde.";
}
}  
elseif($ityp == 1){        
$iname = getwert($iid,"items","name","id");  
$iwerte = getwert($iname,"item","werte","name");              
$array = explode(";", trim($iwerte));
$ihp = $array[0];
$ichakra = $array[1]; 
$uhp = getwert(session_id(),"charaktere","hp","session");
$umhp = getwert(session_id(),"charaktere","mhp","session");
$uchakra = getwert(session_id(),"charaktere","chakra","session");
$umchakra = getwert(session_id(),"charaktere","mchakra","session");
$geht = 0;
if($ihp != 0){
$geht = $geht+1;
if($uhp == $umhp){
$geht = $geht-1;
}
else{
$nhp = $uhp+$ihp;
if($nhp > $umhp){
$nhp = $umhp;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
$sql="UPDATE charaktere SET hp ='$nhp' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con); 
}
}
if($ichakra != 0){
$geht = $geht+1;
if($uchakra == $umchakra){
$geht = $geht-1;
}
else{
$nchakra = $uchakra+$ichakra;
if($nchakra > $umchakra){
$nchakra = $umchakra;
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
$sql="UPDATE charaktere SET chakra ='$nchakra' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con); 
}
}
if($geht == 0){
$error = "Du bist schon voll geheilt.";
}
else{
$error = "Du wurdest geheilt.";  
$nanzahl = $ianzahl-1;    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
if($nanzahl == 0){    
$sql="DELETE FROM items WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
else{ 
$sql="UPDATE items SET anzahl ='$nanzahl' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
mysqli_close($con);
}
}
}

}
else{
$error = "Dieses Item gehört dir nicht.";
}
}
else{
$error = "Dieses Item existiert nicht.";
}
}
else{
$error = "Du kannst in einem Kampf kein Item benutzen.";
}
}
}
if(logged_in()){     
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
echo '<h3>Inventar</h3><center>';  
if($ugender == "männlich"){
echo '<div class="male">';
}
if($ugender == "weiblich"){
echo '<div class="female">';     
}                 
echo '<div class="slot" style="position:absolute; left:89px; top:28px;">'; // Kopf      
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'Kopf' == $tanlegbar[0] || isset($tanlegbar[1]) && 'Kopf' == $tanlegbar[1]){    
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:2; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Kopf 
echo '<div class="slot" style="position:absolute; left:149px; top:28px;">'; // Auge      
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'Auge' == $tanlegbar[0] || isset($tanlegbar[1]) && 'Auge' == $tanlegbar[1]){    
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:2; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Auge   

echo '<div class="slot" style="position:absolute; left:119px; top:111px;">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'Brust' == $tanlegbar[0] || isset($tanlegbar[1]) && 'Brust' == $tanlegbar[1]){    
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:2; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Brust  
echo '<div class="slot" style="position:absolute; left:240px; top:88px;">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'Rücken' == $tanlegbar[0] || isset($tanlegbar[1]) && 'Rücken' == $tanlegbar[1]){   
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:3; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Rücken                   
echo '<div class="slot" style="position:absolute; left:52px; top:164px;">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'RHand' == $tanlegbar[0] || isset($tanlegbar[1]) && 'RHand' == $tanlegbar[1]){                 
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:3; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Rechte Hand (von ihm aus) 
echo '<div class="slot" style="position:absolute; left:185px; top:164px;">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'LHand' == $tanlegbar[0] || isset($tanlegbar[1]) && 'LHand' == $tanlegbar[1]){    
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:3; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Linke Hand (von ihm aus)  
echo '<div class="slot" style="position:absolute; left:119px; top:232px;">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'Hose' == $tanlegbar[0] || isset($tanlegbar[1]) && 'Hose' == $tanlegbar[1]){    
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:3; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Hose    
echo '<div class="slot" style="position:absolute; left:240px; top:239px;">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'Hintern' == $tanlegbar[0] || isset($tanlegbar[1]) && 'Hintern' == $tanlegbar[1]){    
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:3; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Hintern 
echo '<div class="slot" style="position:absolute; left:119px; top:332px;">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'Beine' == $tanlegbar[0] || isset($tanlegbar[1]) && 'Beine' == $tanlegbar[1]){    
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:3; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Beine 
echo '<div class="slot" style="position:absolute; left:119px; top:412px;">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anlegbar,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false   
$tanlegbar = explode("&", trim($row['angelegt']));
if(isset($tanlegbar[0]) && 'Schuhe' == $tanlegbar[0] || isset($tanlegbar[1]) && 'Schuhe' == $tanlegbar[1]){    
echo '<div style="position:absolute; z-index:1; width:50px; height:50px; background:url('.$row['bild'].');"></div>';                                                                        
echo '<a class ="sinfo" href="inventar.php?was=deuse&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:3; width:50px; height:50px;">';                    
$ibesch = getwert($row['name'],"item","beschreibung","name");        
if($row['typ'] == 3){                             
$iwerte = getwert($row['name'],"item","werte","name");   
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
} 
}
$result->close(); 
echo '</div>'; //Schuhe 
echo '</div>';
echo '</center>';
$slots = checkslots($uid);
$slots = $slots[0];
$count = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
anzahl,
bild,
angelegt,
typ
FROM
items
WHERE besitzer="'.$uid.'" AND angelegt = ""
ORDER BY
name,
id
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table width="100%">';
echo '<tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$count++;
echo '<td width="50px" height="50px">';
$slots--;                                    
echo '<div class="slot" style="position:relative;">';                  
echo '<div style="position:absolute; z-index:0; width:50px; height:50px; background:url('.$row['bild'].');"></div>';  
echo '<div style="position:absolute; z-index:1; left:2px; top:30px;">'; 
echo '<b>'.$row['anzahl'].'x</b>';  
echo '</div>';                                                                     
$ibesch = getwert($row['name'],"item","beschreibung","name");
echo '<a class="sinfo" href="inventar.php?was=use&iid='.$row['id'].'">';    
echo '<div style="position:absolute; z-index:0; width:50px; height:50px;">';  
$iwerte = getwert($row['name'],"item","werte","name");      
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
echo '</td>';
if($count == 10){
echo '</tr><tr>';
$count = 0;
}
}
$result->close();
while($slots != 0){
$slots--;
$count++;
echo '<td width="50px" height="50px"><div class="slot"></div></td>';   
if($count == 10){
echo '</tr><tr>';
$count = 0;
}
}
echo '</tr></table>';
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