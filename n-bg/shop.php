<?php
include 'inc/incoben.php';
if(logged_in()){
$shop = $_GET['shop'];    
$page = $_GET['page'];                             
$aktion = $_GET['aktion'];            
$uryo = getwert(session_id(),"charaktere","ryo","session"); 
$uid = getwert(session_id(),"charaktere","id","session");   
$uclan = getwert(session_id(),"charaktere","clan","session"); 
$ukid = getwert(session_id(),"charaktere","kampfid","session"); 
$ulevel = getwert(session_id(),"charaktere","level","session"); 
$ort = getwert(session_id(),"charaktere","ort","session"); 
$shops = getwert($ort,"orte","shops","id"); 
$array = explode(";", trim($shops));   
$count = 0;
$gibts = 0;
while(isset($array[$count])){
if($array[$count] == $shop){
$gibts = 1;
}
$count++;
} 
if($gibts == 1){
if($ukid == 0){
if($aktion == "verkaufen"){                     
$iid = $_POST['iid'];
if(is_numeric($iid)){
$anzahl = round($_POST['anzahl']);   
if($anzahl >= 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
besitzer,
name,
anzahl,
angelegt
FROM
items
WHERE id = "'.$iid.'" and besitzer = "'.$uid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$geht = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['angelegt'] == ""){
$geht = 1;
}
else{     
$geht = 2;
}
$hatanzahl = $row['anzahl'];
$iname = $row['name'];      
$preis = getwert($row['name'],"item","preis","name"); 
if($preis != 0){
$preis = $preis/2;
}
}
$result->close();$db->close();
if($geht == 1){
if($anzahl <= $hatanzahl){
if($preis != 0){
$preis = $anzahl*$preis;     
$uryo = $uryo+$preis;
$neuanzahl = $hatanzahl-$anzahl;    
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));   
if($neuanzahl == 0){   
$sql="DELETE FROM items WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
else{
$sql="UPDATE items SET anzahl ='$neuanzahl' WHERE id = '".$iid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
}    
$sql="UPDATE charaktere SET ryo ='$uryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
$error = 'Du hast '.$iname.' '.$anzahl.'x verkauft.';
mysqli_close($con); 
}
else{
$error = "Dieses Item ist nicht verkaufbar.";
}
}
else{
$error = "Du kannst soviele nicht verkaufen.";
}
}
else{
if($geht == 0){
$error = "Dieses Item gehört nicht dir!";
}
if($geht == 2){
$error = "Dieses Item ist angelegt und kann daher nicht verkauft werden.";
}
}
}
}
}
if($aktion == "kaufen"){
$iid = $_POST['iid'];    
if(is_numeric($iid)){
$anzahl = round($_POST['anzahl']);   
if($anzahl >= 1&&$anzahl <= 99){ 
if($shop == "puppe"){  
$urank = getwert(session_id(),"charaktere","rank","session"); 
if($uclan == "kugutsu"&&$urank != 'student'){
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
inshop,
ort
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
$iwerte = $row['werte'];  
$iname = $row['name'];     
$ilevel = $row['level'];
$inshop = $row['inshop'];  
$iort = $row['ort'];
}
$result->close();$db->close();
if($geht == 1){ 
if($ort == $iort||$iort == 0){
if($inshop == 1&&$preis != 0){
if($ulevel >= $ilevel){
$nuryo = $uryo-$preis;
if($nuryo >= 0){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
besitzer,
reihenfolge
FROM
summon
WHERE besitzer = "'.$uid.'" 
ORDER BY
reihenfolge
LIMIT 10';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$sanzahl = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
$sanzahl++;
}
$result->close();$db->close();
$sanzahl = $sanzahl+$anzahl;
if($sanzahl <= 10){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$count = 0;
$rgeht = 1;
if($reihenfolge > 3){
$rgeht = 0;
$reihenfolge = 4;
}
while($count != $anzahl){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
besitzer,
reihenfolge
FROM
summon   
WHERE besitzer = "'.$uid.'" 
ORDER BY
reihenfolge
LIMIT 10';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$reihenfolge = 1;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
if($row['reihenfolge'] == 1&&$reihenfolge == 1){
$reihenfolge = 2;
}  
if($row['reihenfolge'] == 2&&$reihenfolge == 2){
$reihenfolge = 3;
}
if($row['reihenfolge'] == 3&&$reihenfolge == 3){
$reihenfolge = 4;
}
}
$result->close();$db->close();
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
mhp,
mchakra,
mkr,
mintl,
mtmp,
mgnk,
mchrk,
mwid,
statspunkte
FROM
charaktere   
WHERE id = "'.$uid.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false  
$ustats = ($row['mhp']/10)+($row['mchakra']/10)+$row['mkr']+$row['mintl']+$row['mgnk']+$row['mchrk']+$row['mtmp']+$row['mwid']+$row['statspunkte'];  
}
$result->close();$db->close();
$ustats = $ustats-80;
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
jutsus,
kbild,
bild,
geschlecht,
kaufstats
FROM
npc
WHERE name = "'.$iwerte.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false 
$sql="INSERT INTO summon(
name,
hp,     
mhp,   
chakra, 
mchakra,
kr,      
tmp,
gnk,
intl,
chrk,
wid,
jutsus,
kbild,
bild,  
reihenfolge,
statspunkte, 
besitzer,
geschlecht)
VALUES
('".$row['name']."',
'100',    
'100',  
'100',    
'100',  
'10', 
'10',   
'10', 
'10', 
'10',  
'10', 
'".$row['jutsus']."',  
'".$row['kbild']."', 
'".$row['bild']."', 
'$reihenfolge',   
'$ustats',     
'$uid',
'".$row['geschlecht']."')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
} 
}
$result->close();$db->close();
$count++;
}
    
$sql="UPDATE charaktere SET ryo ='$nuryo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
mysqli_close($con); 
$error = 'Du hast '.$iname.' '.$anzahl.'x gekauft.';

}
else{
$error = 'Du kannst nicht mehr Puppen haben.';
}

}
else{
$error = 'Du hast nicht genügend Ryo.';
}
}
else{
$error = 'Dein Level ist zu niedrig.';
}
}
}
else{
$error = 'Du kannst dieses Item an diesen Ort nicht kaufen.';
}
}
}
else{
$error = 'Nur Ninjas vom Kugutsu Clan dürfen hier einkaufen, sobald sie keine Studenten mehr sind.';
}
}
else{
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
anlegbar,
level,
ort
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
$ilevel = $row['level'];    
$iort = $row['ort'];
}
$result->close();$db->close();
if($geht == 1){
if($iort == 0||$iort == $ort){
if($ulevel >= $ilevel){
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
else{
$error = 'Dein Level ist zu niedrig.';
}
}
else{
$error = 'Du kannst dieses Item an diesen Ort nicht kaufen.';
}
}
}
}
else{
$error = 'Du kannst soviele nicht gleichzeitig kaufen.';
}
}
}
}
else{
$error = 'Du kannst das im Kampf nicht tun.';
} 
}
else{
$error = "Dieser Laden existiert nicht in diesen Ort.";
}   
}                    

if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
if($gibts == 1&&$shop == "heil"||$gibts == 1&&$shop == "waffe"||$gibts == 1&&$shop == "kleidung"||$gibts == 1&&$shop == "puppe"){      
$ortw = getwert($ort,"orte","was","id"); 
if($shop == "heil"){
if($ortw == "dorf"){
echo '<h3>Apotheke</h3>';
}
else{    
echo '<h3>Apotheker</h3>';
}
}
if($shop == "waffe"){
if($ortw == "dorf"){
echo '<h3>Waffenladen</h3>';
}
else{    
echo '<h3>Waffenhändler</h3>';
}
}
if($shop == "kleidung"){
if($ortw == "dorf"){
echo '<h3>Kleidungsladen</h3>';
}
else{    
echo '<h3>Kleidungshändler</h3>';
}
}     
if($shop == "puppe"){  
if($ortw == "dorf"){
echo '<h3>Puppenladen</h3>';
}
else{    
echo '<h3>Puppenhändler</h3>';
}

}
echo '<br>';
echo '<a href="shop.php?shop='.$shop.'">Kaufen</a> ';
echo ' <a href="shop.php?shop='.$shop.'&page=verkaufen">Verkaufen</a>'; 
echo '<br>';
echo '<br>';
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td width="100px" class="tdbg tdborder">';
echo 'Name';
echo '</td>';
echo '<td width="50px" class="tdbg tdborder">';
echo 'Bild';
echo '</td>';   
echo '<td class="tdbg tdborder">';
echo 'Preis';
echo '</td>';   
if($page == ""){ 
echo '<td width="40px" class="tdbg tdborder">';
echo 'Level';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Beschreibung';
echo '</td>';
}
echo '<td width="200px" class="tdbg tdborder">';
echo '</td>';
echo '</tr>';
if($page == ""){
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
werte,
level,
inshop,
ort
FROM
item
WHERE shop = "'.$shop.'" AND preis != "0" AND inshop = "1"
ORDER BY
level,
preis,
name';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['ort'] == $ort||$row['ort'] == 0){
echo '<tr height="80px">';
echo '<td class="tdborder">'.$row['name'].'</td>';
echo '<td class="tdborder"><img src="'.$row['bild'].'"></img></td>'; 
echo '<td class="tdborder">'.$row['preis'].' Ryo</td>';                  
echo '<td class="tdborder">'.$row['level'].'</td>';         
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
echo '<td class="tdborder">'.$ibesch.'</td>';
echo '<td class="tdborder">';
echo '<form method="post" action="shop.php?shop='.$shop.'&aktion=kaufen">
<input type="hidden" value="'.$row['id'].'" name="iid"> 
<center><div class="auswahl2"> <select class="text" name="anzahl">';           
$tempint = 0;  
while($tempint < 99){
$tempint++;
echo '<option value="'.$tempint.'">'.$tempint.'</option>';
}  
echo '</select></div></center>'; 

      echo '<div style="height:2px;"></div><input class="button" type="submit" value="kaufen"></form>'; 
echo '</td>';
echo '</tr>';
}
}
$result->close();$db->close();
}
if($page == "verkaufen"){   
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer,
bild,
anzahl,
angelegt
FROM
items
WHERE besitzer = "'.$uid.'" AND angelegt = ""';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$preis = getwert($row['name'],"item","preis","name"); 
if($preis != 0){    
$preis = $preis/2;
echo '<tr>';
echo '<td>'.$row['name'].'</td>';
echo '<td><img src="'.$row['bild'].'"></img></td>';     
echo '<td>'.$preis.' Ryo</td>';
echo '<td>';
echo '<form method="post" action="shop.php?shop='.$shop.'&page=verkaufen&aktion=verkaufen">
<input type="hidden" value="'.$row['id'].'" name="iid"> 
<center><div class="auswahl2"> <select class="text" name="anzahl">';           
$tempint = 0;  
while($tempint < $row['anzahl']){
$tempint++;
echo '<option value="'.$tempint.'">'.$tempint.'</option>';
}  
echo '</select></div></center>'; 

      echo '<input class="button" type="submit" value="Verkaufen"></form>'; 
echo '</td>';
echo '</tr>';
}
}
$result->close();$db->close();
}
echo '</table>';
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