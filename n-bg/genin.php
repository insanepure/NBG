<?php
include 'inc/incoben.php';
if(logged_in()){           
$urank = getwert(session_id(),"charaktere","rank","session");   
if($urank == "student"){   
$aktion = $_GET['aktion'];               
$uclan = getwert(session_id(),"charaktere","clan","session");       
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");   
$ort = getwert(session_id(),"charaktere","ort","session");   
$genin = getwert($ort,"orte","genin","id"); 
if($genin == 1){
$array = explode(";", trim($ujutsus));
$count = 0; 
$kawa = 0;
$bunshin = 0;       
$henge = 0;
while(isset($array[$count])){            
if($array[$count] == 5){
$henge = 1;
}                   
if($array[$count] == 11){
$bunshin = 1;
}                 
if($array[$count] == 12){
$kawa = 1;                  
}
$count++;
}  
if($aktion == "test"){  
$ulevel = getwert(session_id(),"charaktere","level","session");
$bestanden = 0;   
if($ulevel >= 10){
if($uclan == "tai"){
$bestanden = 1;
}
else{
if($kawa == 1&&$bunshin == 1&&$henge == 1){
$bestanden = 1;
}
}
if($bestanden == 1){    
$uid = getwert(session_id(),"charaktere","id","session"); 
$slots = checkslots($uid);
if($slots[1] != 0){
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
WHERE id ="48"';
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
'1')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}   
$sql="UPDATE charaktere SET rank ='genin' WHERE id = '".$uid."' Limit 1";
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
}

}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
//Hier kommt der Code hin
echo '<h2 class="shadow">Genin Prüfung</h2>';
if($aktion == "test"){
if($bestanden == 1){
echo '<img src="bilder/design/bestanden.png"></img>';
}          
else{
echo '<img src="bilder/design/durchgefallen.png"></img>';
}

}
else if($urank == "student"){
if($genin == 1){

if($aktion == ""){
echo '<table class="table" width="100%"><tr><td class="tdborder tdbg" colspan="2">Akademie Lehrer</td></tr>';
echo '<tr><td width="25%"><img src="bilder/npcs/lehrer.png"></img></td>'; 
echo '<td class="shadow">';
echo 'Damit du bestehst, musst du Level 10 sein.';
if($uclan != "tai"){
echo '<br>Zusätzlich benötigst du folgende Jutsus:<br>';             
if($henge == 1){         
echo '<img src="bilder/jutsus/hengea.png"></img> '; 
}
else{  
echo '<img src="bilder/jutsus/henge.png"></img> '; 
}  
if($bunshin == 1){         
echo '<img src="bilder/jutsus/bunshina.png"></img> '; 
}
else{  
echo '<img src="bilder/jutsus/bunshin.png"></img> '; 
} 
if($kawa == 1){         
echo '<img src="bilder/jutsus/kawarimia.png"></img> '; 
}
else{  
echo '<img src="bilder/jutsus/kawarimi.png"></img> '; 
}          
}
echo '<br>'; 
echo 'Möchtest du dein Talent vorzeigen?';
echo '<br>';                
echo '<br>';
echo '<form method="post" action="genin.php?aktion=test">';    
echo '<input class="button" name="join" id="login" value="Zeigen" type="submit">';
echo '</form>';
echo '</td>';
echo '</tr></table>';
}
}
else{
$error = 'Die Genin Prüfung findet gerade nicht statt.';
}
}
else{
echo 'Du kannst die Genin Prüfung nicht machen, weil du kein Student bist.';
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