<?php
include 'inc/incoben.php';
if(logged_in()){   
$ulevel = getwert(session_id(),"charaktere","level","session");      
$uid = getwert(session_id(),"charaktere","id","session");         
$ort = getwert(session_id(),"charaktere","ort","session");       
$ortw = getwert($ort,"orte","was","id"); 
if($ulevel >= 10){
if($ortw == 'dorf'||$ort == 13||$ort == 52){
$aktion = $_GET['aktion'];
if($aktion == 'back'){
$itemid = $_GET['itemid'];  
$ibesitzer = getwert($itemid,"markt","besitzer","id");    
if($ibesitzer == $uid){
$anzahl = round($_POST['anzahl']);   
if($anzahl >= 1){         
$item = getwert($itemid,"markt","name","id");    
if($anzahl <= 99){  
$ianzahl = getwert($itemid,"markt","anzahl","id");  
if($ianzahl >= $anzahl){
$slots = checkslots($uid); 
$ganzahl = $anzahl;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt,
anzahl,
bild
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$item.'" AND anzahl != "99" AND angelegt = ""
ORDER by
name';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$gibt = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gibt = 1;    
$tint = $tint+(99-$row['anzahl']);
}
$result->close();$db->close(); 

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
WHERE name = "'.$item.'" Limit 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$iname = $row['name'];
$iwerte = $row['werte'];
$ibild = $row['bild'];
$ityp = $row['typ'];
$ianlegbar = $row['anlegbar'];
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
if($ganzahl == $ianzahl){
$sql="DELETE FROM markt WHERE id = '".$itemid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$ianzahl = $ianzahl-$ganzahl;
$sql="UPDATE markt SET anzahl ='$ianzahl' WHERE id = '".$itemid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
mysqli_close($con); 
$error = 'Du hast '.$iname.' '.$ganzahl.'x zurückgenommen.';
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
WHERE besitzer = "'.$uid.'" AND name = "'.$item.'" AND anzahl != "99" AND angelegt = ""
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
if($ganzahl == $ianzahl){
$sql="DELETE FROM markt WHERE id = '".$itemid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$ianzahl = $ianzahl-$ganzahl;
$sql="UPDATE markt SET anzahl ='$ianzahl' WHERE id = '".$itemid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$error = 'Du hast '.$iname.' '.$ganzahl.'x zurückgenommen.';
mysqli_close($con); 
}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}
}
}
}
}
}
}
if($aktion == 'kaufen'){     
$item = $_GET['item'];
$itemid = $_GET['itemidb']; 
$ilevel = getwert($itemid,"markt","level","id");  
$iname = getwert($itemid,"markt","name","id");    
if($iname == $item&&$ulevel >= $ilevel){
$anzahl = round($_POST['anzahl']);   
if($anzahl >= 1){
$ipw = getwert($itemid,"markt","pw","id");        
$ibesitzer = getwert($itemid,"markt","besitzer","id");   
if($ibesitzer != $uid){  
if($ipw == $_POST['pw']){
if($anzahl <= 99){
$ianzahl = getwert($itemid,"markt","anzahl","id");  
if($ianzahl >= $anzahl){      
$uryo = getwert(session_id(),"charaktere","ryo","session");
$kpreis = getwert($itemid,"markt","preis","id");  

$ipreis = $kpreis*$anzahl;
if($uryo >= $ipreis){
$ganzahl = $anzahl;         
$slots = checkslots($uid);   
$bryo = getwert($ibesitzer,"charaktere","ryo","id");
$nryo = $uryo-$ipreis;
$bryo = $bryo+$ipreis;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt,
anzahl,
bild
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$item.'" AND anzahl != "99" AND angelegt = ""
ORDER by
name';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$gibt = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$gibt = 1;    
$tint = $tint+(99-$row['anzahl']);
}
$result->close();$db->close();
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
WHERE name = "'.$item.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$iname = $row['name'];
$iwerte = $row['werte'];
$ibild = $row['bild'];
$ityp = $row['typ'];
$ianlegbar = $row['anlegbar'];
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
if($ganzahl == $ianzahl){
$sql="DELETE FROM markt WHERE id = '".$itemid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$ianzahl = $ianzahl-$ganzahl;
$sql="UPDATE markt SET anzahl ='$ianzahl' WHERE id = '".$itemid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$sql="UPDATE charaktere SET ryo ='$nryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$sql="UPDATE charaktere SET ryo ='$bryo' WHERE id = '".$ibesitzer."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                 
$uip = getwert($uid,"charaktere","ip","id");
$iip = getwert($ibesitzer,"charaktere","ip","id");     
$ibesitzern = getwert($ibesitzer,"charaktere","name","id");   
$zeit2 = time();
$zeit = date("d.m.Y H:i:s",$zeit2);
$text = '<b>'.$zeit.'</b>;'.$uid.';hat '.$ganzahl.'x '.$item.' für '.$kpreis.' Ryo pro Stück von <a href="user.php?id='.$ibesitzer.'">'.$ibesitzern.'</a> gekauft.';
$handellog = getwert(1,"game","handellog","id");
if($handellog == ""){
$handellog = $text;
}
else{
$handellog = $text.'@'.$handellog;
}    
$sql="UPDATE game SET handellog ='$handellog' LIMIT 1";  
mysqli_query($con, $sql); 
if($uip == $iip){
$text = '<b>'.$zeit.'</b>;'.$uid.';hatte beim Kauf eines Items die selbe IP wie <a href="user.php?id='.$ibesitzer.'">'.$ibesitzern.'</a>.';
$modlog = getwert(1,"game","modlog","id");
if($modlog == ""){
$modlog = $text;
}
else{
$modlog = $text.'@'.$modlog;
}    
$sql="UPDATE game SET modlog ='$modlog' LIMIT 1";  
mysqli_query($con, $sql);  
}
mysqli_close($con); 
$error = 'Du hast '.$iname.' '.$ganzahl.'x gekauft.';
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
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
  
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
WHERE besitzer = "'.$uid.'" AND name = "'.$item.'" AND anzahl != "99" AND angelegt = ""
ORDER BY
name,
besitzer
ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
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
$sql="UPDATE charaktere SET ryo ='$nryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
$sql="UPDATE charaktere SET ryo ='$bryo' WHERE id = '".$ibesitzer."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}  
if($ganzahl == $ianzahl){
$sql="DELETE FROM markt WHERE id = '".$itemid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$ianzahl = $ianzahl-$ganzahl;
$sql="UPDATE markt SET anzahl ='$ianzahl' WHERE id = '".$itemid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
}
$error = 'Du hast '.$iname.' '.$ganzahl.'x gekauft.';
mysqli_close($con); 
}
else{
$error = 'Du hast nicht genügend Platz im Inventar.';
}
}
}
}
}
}
else{
$error ='Dieses Passwort ist falsch.';
}
}
}
}
}
if($aktion == 'verkaufen'){
$item = $_GET['item'];
$anzahl = round($_POST['anzahl']);   
if($anzahl >= 1){
$preis = $_POST['preis'];      
$passwort = $_POST['pw'];
if(is_numeric($preis)){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt,
anzahl,
bild
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$item.'" AND angelegt = ""
ORDER by
name';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$ianzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$ianzahl = $ianzahl+$row['anzahl'];
}
$result->close();$db->close();
if($ianzahl >= $anzahl){         
$ganzahl = $anzahl;
$ipreis = getwert($item,"item","preis","name");      
if($ipreis >= $preis&&$preis >= ($ipreis/2)){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
angelegt,
anzahl,
bild
FROM
items
WHERE besitzer = "'.$uid.'" AND name = "'.$item.'" AND angelegt = ""
ORDER by
name';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}              
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false 
$hanzahl = $row['anzahl']-$anzahl;
$anzahl = $anzahl-$row['anzahl'];
if($anzahl <= 0){
$anzahl = 0;
}
if($hanzahl <= 0){
$sql="DELETE FROM items WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$sql="UPDATE items SET anzahl ='$hanzahl' WHERE id = '".$row['id']."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
}
$result->close();$db->close();    
$ilevel = getwert($item,"item","level","name");    
$sql="INSERT INTO markt(
name,
level,   
preis,
anzahl,
besitzer,
pw)
VALUES
('$item',
'$ilevel',  
'$preis',
'$ganzahl',
'$uid',
'$passwort')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
$error = 'Du hast '.$ganzahl.' '.$item.' auf den Markt gestellt.';
}
else{
$error = 'Dieser Preis ist nicht möglich. Er muss zwischen '.($ipreis/2).' und '.$ipreis.' liegen.';
}
}
else{
$error = 'Du hast nicht genügend Items.';
}
}
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
//Code
$shop = $_GET['shop'];       
$page = $_GET['page'];
echo '<h3>Marktplatz</h3>';   
if($ulevel >= 10){
if($ortw == 'dorf'||$ort == 13||$ort == 52){
if($page == ''){
if($shop == ''){
echo '<table width="100%">';
echo '<tr>';
echo '<td width="50%" height="100px">';
echo '<center><a href="markt.php?shop=waffe"><div class="slot"><img src="bilder/items/shuriken.png"></div>Waffen</a></center>';
echo '</td>'; 
echo '<td width="50%" height="100px">';   
echo '<center><a href="markt.php?shop=heil"><div class="slot"><img src="bilder/items/schwach_chakra.png"></div>Essen</a></center>';
echo '</td>'; 
echo '</tr><tr>'; 
echo '<td width="100%" height="100px" colspan="2"><a href="markt.php?page=verwaltung">Items verwalten</a></td>';
echo '</tr><tr>'; 
echo '<td width="100%" height="100px" colspan="2">';                                                           
echo '<center><a href="markt.php?shop=kleidung"><div class="slot"><img src="bilder/items/dickejacke.png"></div>Kleidungen</a></center>';
echo '</td>'; 
//echo '<td width="50%" height="100px">';           
//echo '<center><div class="slot"><img src="bilder/items/karasu.png"></div>Menschliche Puppen<br>Edo Tensei (kommt noch)</center>';
//echo '</td>';
echo '</tr>';
echo '</table>';
//echo '<a href="markt.php?page=puppen">Puppen</a><br>';
}
elseif($shop == 'waffe'||$shop == 'heil'||$shop == 'kleidung'){
$item = $_GET['item'];
if($item == ''){
echo '<table width="100%">';
echo '<tr>';
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
anlegbar,
level,
inshop
FROM
item
WHERE shop = "'.$shop.'" AND preis != "0" AND level <= "'.$ulevel.'"
ORDER by
preis,
werte';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$count = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$count++;
echo '<td width="50px" height="50px">';
$slots--;                                    
echo '<div class="slot" style="position:relative;">';                  
echo '<div style="position:absolute; z-index:0; width:50px; height:50px; background:url('.$row['bild'].');"></div>';  
echo '<div style="position:absolute; z-index:1; left:2px; top:30px;">'; 
$angebote = angebote($row['name']);
echo '<b class="shadow">'.$angebote.'x</b>';  
echo '</div>';                                                                     
$ibesch = getwert($row['name'],"item","beschreibung","name");
echo '<a class="sinfo" href="markt.php?shop='.$shop.'&item='.$row['name'].'">';    
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
$result->close();$db->close();
echo '</tr></table>';     
echo '<br>';
echo '<a href="markt.php">Zurück</a>';
}
else{            
$was = $_GET['was'];
if($was == 'set'){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt,
anzahl,
bild
FROM
items 
WHERE besitzer = "'.$uid.'" AND name = "'.$item.'" AND angelegt = ""
ORDER by
name';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$anzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$anzahl = $anzahl+$row['anzahl'];
$bild = $row['bild'];
}
$result->close();$db->close();
if($anzahl != 0){
echo '<br><h3>'.$item.'</h3><br>';
echo '<center><div class="slot"><img src="'.$bild.'"></div>';
echo 'Anzahl: '.$anzahl.'<br><br>';     
echo '<form method="post" action="markt.php?shop='.$shop.'&item='.$item.'&aktion=verkaufen">';
echo '<div class="auswahl2"> <select class="text" name="anzahl">';           
$tempint = 0;  
while($tempint < $anzahl){
$tempint++;
echo '<option value="'.$tempint.'">'.$tempint.'</option>';
}  
echo '</select></div><br>';                  
echo 'Preis<div class="eingabe1">';
echo '<input class="eingabe2" name="preis" value="" size="15" maxlength="30" type="text">';
echo '</div><br>';              
echo 'Passwort<div class="eingabe1">';
echo '<input class="eingabe2" name="pw" value="" size="15" maxlength="30" type="text">';
echo '</div><br>';
echo '<input class="button" name="login" id="login" value="verkaufen" type="submit"></form></center>';

}
else{
echo 'Du hast dieses Item nicht.';
}
echo '<br>';                      
echo '<a href="markt.php?shop='.$shop.'&item='.$item.'">Zurück</a>';     
}
else{ 
$itemid = $_GET['itemid'];
if($itemid == ''){ 
echo '<a href="markt.php?shop='.$shop.'&item='.$item.'&was=set">Verkaufen</a>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
level,
preis,
anzahl,
besitzer,
pw
FROM
markt
WHERE name = "'.$item.'" AND level <= "'.$ulevel.'"
ORDER BY
preis';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">Besitzer</td>'; 
echo '<td class="tdbg tdborder">Preis</td>'; 
echo '<td class="tdbg tdborder">Anzahl</td>'; 
echo '<td class="tdbg tdborder">Passwort</td>'; 
echo '<td class="tdbg tdborder"></td>';
echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr>';
echo '<td>';            
$vname = getwert($row['besitzer'],"charaktere","name","id");    
echo '<a href="user.php?id='.$row['besitzer'].'">'.$vname.'</a>';
echo '</td>';
echo '<td>';
echo $row['preis'];
echo '</td>';   
echo '<td>';
echo $row['anzahl'];
echo '</td>';       
echo '<td>';
if($row['pw']){
echo 'Ja';
}
else{
echo 'Nein';
}
echo '</td>';
echo '<td>';
echo '<a href="markt.php?shop='.$shop.'&item='.$item.'&itemid='.$row['id'].'">Kaufen</a>';
echo '</td>';
echo '</tr>';
}
$result->close();$db->close();  
echo '</table>';                          
echo '<br>';                      
echo '<a href="markt.php?shop='.$shop.'">Zurück</a>';  
}
else{                
$iname = getwert($itemid,"markt","name","id");      
$ilevel = getwert($itemid,"markt","level","id");   
if($iname == $item&&$ulevel >= $ilevel){
echo '<br><h3>'.$item.'</h3><br>';    
$ibild = getwert($item,"item","bild","name");         
echo '<center><div class="slot"><img src="'.$ibild.'"></div>';    
$ibesitzer = getwert($itemid,"markt","besitzer","id"); 
$vname = getwert($ibesitzer,"charaktere","name","id");   
echo 'Besitzer: <a href="user.php?id='.$ibesitzer.'">'.$vname.'</a><br>';
$ianzahl = getwert($itemid,"markt","anzahl","id");   
echo 'Anzahl: '.$ianzahl.'<br>';                    
$ipreis = getwert($itemid,"markt","preis","id");    
echo 'Preis: '.$ipreis.'<br>';                    
echo '<form method="post" action="markt.php?shop='.$shop.'&item='.$item.'&itemidb='.$itemid.'&aktion=kaufen">';
echo '<div class="auswahl2"> <select class="text" name="anzahl">';           
$tempint = 0;  
while($tempint < $ianzahl&&$tempint < 99){
$tempint++;
echo '<option value="'.$tempint.'">'.$tempint.'</option>';
}  
echo '</select></div><br>';        

$ipw = getwert($itemid,"markt","pw","id");  
if($ipw != ''){ 
echo '<div class="eingabe1">';
echo '<input class="eingabe2" name="pw" value="Passwort" size="15" maxlength="30" type="text">';
echo '</div><br>';
}
echo '<input class="button" name="login" id="login" value="kaufen" type="submit"></form></center>';
}
echo '<br>';                      
echo '<a href="markt.php?shop='.$shop.'&item='.$item.'">Zurück</a>';    
}      
}                                 
} 
}
}
else{
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
preis,
anzahl,
besitzer,
pw
FROM
markt
WHERE besitzer = "'.$uid.'"
ORDER BY
preis';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">Name</td>'; 
echo '<td class="tdbg tdborder">Preis</td>'; 
echo '<td class="tdbg tdborder">Anzahl</td>'; 
echo '<td class="tdbg tdborder">Passwort</td>'; 
echo '<td class="tdbg tdborder"></td>';
echo '</tr>';
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr>';
echo '<td>';             
echo $row['name'];
echo '</td>';
echo '<td>';
echo $row['preis'];
echo '</td>';   
echo '<td>';
echo $row['anzahl'];
echo '</td>';       
echo '<td>';
echo $row['pw'];
echo '</td>';
echo '<td width="260px">';
echo '<form method="post" action="markt.php?page=verwalten&itemid='.$row['id'].'&aktion=back">';
echo '<table><tr><td>';
echo '<div class="auswahl2"> <select class="text" name="anzahl">';           
$tempint = 0;  
while($tempint < $row['anzahl']&&$tempint < 99){
$tempint++;
echo '<option value="'.$tempint.'">'.$tempint.'</option>';
}  
echo '</select></div>';     
echo '<input class="button2" name="login" id="login" value="zurücknehmen" type="submit"></form>';
echo '</td></tr></table>';
echo '</td>';
echo '</tr>';
}
$result->close();$db->close();  
echo '</table>';                  
echo '<br>';                      
echo '<a href="markt.php">Zurück</a>';    
}
}
else{
echo 'Der Marktplatz ist nur in einem Dorf verfügbar.';
}
}else{
echo 'Der Marktplatz ist erst ab Level 10 verfügbar.';
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