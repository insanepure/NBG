<?php
include 'inc/incoben.php';
// Hier kommen Skripts hin die vorm Laden ausgeführt werden
if(logged_in()){             
$ort = getwert(session_id(),"charaktere","ort","session");    
$urank = getwert(session_id(),"charaktere","rank","session");  
$ulevel = getwert(session_id(),"charaktere","level","session");       
$turnier = getwert(session_id(),"charaktere","turnier","session");  
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
chuunin,
chuunintid,
id,
name
FROM
orte
WHERE chuunin != "0" AND chuunin != "4" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$chuunino = $row['id'];       
$chuuninon = $row['name'];
$chuuninp = $row['chuunin'];   
$chuunintid = $row['chuunintid'];   
}
$result->close();
$db->close(); 
if($urank == "genin"&&$ulevel >= 20){

if($chuuninp == 2){
$aktion = $_GET['aktion'];
$wahl = $_POST['wahl'];
$bestanden = 0;
if($aktion == "lfrage2"){
if($wahl == "gehen"){
$bestanden = 1;
}
}   
if($aktion == "lfrage1"){
if($wahl == "bleiben"){
$bestanden = 1;
}
}
if($bestanden == 1){   
if($turnier == "0"){
$tid = $chuunintid;
$uhp = getwert(session_id(),"charaktere","hp","session");  
if($uhp > 0){      
$two = getwert($tid,"turnier","ort","id");  
if($two == $ort){       
$tzeit = getwert($tid,"turnier","start","id");    
$tzeit = strtotime($tzeit);
if($tzeit >= time()){    
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
WHERE turnier = "'.$tid.'"
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
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));          
$uid = getwert(session_id(),"charaktere","id","session");  
$sql="UPDATE charaktere SET turnier ='$tid',two ='$uwo',trunde ='1' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                        
$teilnehmer = getwert($tid,"turnier","teilnehmer","id");    
$teilnehmer = $teilnehmer+1;
$sql="UPDATE turnier SET teilnehmer ='$teilnehmer' WHERE id = '".$tid."'";
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
('$tid',
'$uid',  
'1',
'$uwo')"; 
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}
mysqli_close($con); 
$error = 'Turnier beigetreten.';
}
else{
echo 'Das Turnier hat schon begonnen.';  
$bestanden = 0;
}
}
}
else{
$error = 'Du hast keine HP mehr.';  
$bestanden = 0;
}
}
else{
$error = 'Du bist schon in einem Turnier.';
$bestanden = 0;
}
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
//Hier kommt der Code hin    
echo '<h2 class="shadow">Chuunin Prüfung</h2>';
if($urank == "genin"&&$ulevel >= 20){
if($chuuninp != 0){
if($chuunino == $ort){
if($chuuninp == 1){
echo 'Die Chuunin Prüfung findet immer am Mittwoch, Freitag und Sonntag von 15Uhr bis 20Uhr statt.<br/>';
echo 'Der Austragungsort der nächsten Prüfung ist '.ucwords($chuuninon).'gakure.';
}
if($chuuninp == 2){
$page = $_GET['page'];       
echo '<h3>Der schriftliche Test</h3>';    
if($aktion == "lfrage2"||$aktion == "lfrage1"){
echo '<br>';
if($bestanden == 1){
echo '<img src="bilder/design/bestanden.png"></img>';
echo '<br>Du wurdest für das Turnier eingetragen.<br> Heil dich und sei in keinem Kampf, wenn das Turnier startet!';
}          
else{
echo '<img src="bilder/design/durchgefallen.png"></img>';
}
}
else{
if($turnier == "0"){
if($page == ""){        
echo '<form method="post" action="chuunin.php?page=lfrage">';
echo 'Du bekommst ein Zettel. Auf den Zettel stehen neun Fragen. Nachdem du den Zettel abgibst, wirst du in einem zweiten Raum gebracht, wo du einzelnt eine letzte Frage beantworten musst.';
  
echo '<center><br><table class="table">';
echo '<tr>';
echo '<td colspan="3" cellspacing="0" class="tdborder">';    
echo 'Du befindest dich auf einer wichtigen Mission. Während der Mission wird ein Teamkamerad verletzt. <br>Was machst du?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder"><input type="radio" name="1" value="a"> Aufgeben</td>';  
echo '<td class="tdborder"><input type="radio" name="1" value="b"> Weitermachen</td>'; 
echo '<td class="tdborder"><input type="radio" name="1" value="c"> Warten bis er versorgt wird</td>';
echo '</tr>';    
echo '<tr>';
echo '<td class="tdborder" colspan="3">';    
echo 'Dein Dorf befindet sich im Krieg mit einem anderen Dorf. Du wurdest zugeteilt, die Bewohner zu einen sicheren Ort zu bringen.<br> Wo bringst du sie hin?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder"><input type="radio" name="2" value="a"> Aus dem Dorf</td>';  
echo '<td class="tdborder"><input type="radio" name="2" value="b"> Zum Kage Haus</td>'; 
echo '<td class="tdborder"><input type="radio" name="2" value="c"> Zu einem sicheren Ort im Dorf</td>';
echo '</tr>';   
echo '<tr>';
echo '<td class="tdborder" colspan="3">';    
echo 'Du siehst auf 30° einen Spiegel. im Spiegel wird ein feindlicher Ninja reflektiert, der zu den Spiegel den Rücken gewand hat.<br>In welchem Winkel musst du ein Kunai werfen, um den Ninja zu treffen?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder"><input type="radio" name="3" value="a"> 30°</td>';  
echo '<td class="tdborder"><input type="radio" name="3" value="b"> 60°</td>'; 
echo '<td class="tdborder"><input type="radio" name="3" value="c"> 90°</td>';
echo '</tr>';   
echo '<tr>';
echo '<td class="tdborder" colspan="3">';    
echo 'Ein komischer Mann hat dir erzählt, er hatte eine Bombe im Dorf versteckt. Du sollst es dem Kage ausrichten. Was tust du?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder"><input type="radio" name="4" value="a"> Es dem Kage ausrichten</td>';  
echo '<td class="tdborder"><input type="radio" name="4" value="b"> Dorfbewohner evakuieren</td>'; 
echo '<td class="tdborder"><input type="radio" name="4" value="c"> Mann umbringen</td>';
echo '</tr>';   
echo '<tr>';
echo '<td class="tdborder" colspan="3">';    
echo 'Du hast 10 Shuriken und 5 Kunai in der Seitentasche. Du wirfst jeweils die Hälfte der Shuriken auf zwei Gegner. 1/5 der Kunai wirfst du auf einen der Gegner. 2/5 der Kunai wirfst du auf den dritten Gegner.<br>Wieviele Waffen hast du geworfen?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder"><input type="radio" name="5" value="a"> 10</td>';  
echo '<td class="tdborder"><input type="radio" name="5" value="b"> 8</td>'; 
echo '<td class="tdborder"><input type="radio" name="5" value="c"> 13</td>';
echo '</tr>';   
echo '<tr>';
echo '<td class="tdborder" colspan="3">';    
echo 'Dir wird 10000 Ryo ausgezahlt. Du sollst das Geld auf dein Team verteilen. Dein Team besteht aus einem Chuunin, zwei Genin und dir, ein Chuunin. <br>Wie verteilst du das Geld?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder"><input type="radio" name="6" value="a"> Die Chuunin erhalten mehr</td>';  
echo '<td class="tdborder"><input type="radio" name="6" value="b"> Alle bekommen gleich</td>'; 
echo '<td class="tdborder"><input type="radio" name="6" value="c"> Ich bekomme mehr, da ich der Teamführer bin</td>';
echo '</tr>';     
echo '<tr>';
echo '<td class="tdborder" colspan="3">';    
echo 'Du befindest dich in einem Haus. über dir befindet sich ein weiterer Raum. Durch Schritte weißt du, dass sich im Raum über dir feindliche Ninjas befinden.<br>Wieviele Kunai mit Briefbomben musst du werfen, damit du effektiv alle Gegner triffst, dich aber nicht verletzt?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder"><input type="radio" name="7" value="a"> Ein Kunai</td>';  
echo '<td class="tdborder"><input type="radio" name="7" value="b"> Fünf Kunai</td>'; 
echo '<td class="tdborder"><input type="radio" name="7" value="c"> Drei Kunai</td>';
echo '</tr>';        
echo '<tr>';
echo '<td class="tdborder" colspan="3">';    
echo 'Dein Gegner besitzt das Doton Element. Du besitzt das Raiton Element. <br>Wie hoch musst du in einem Jutsu das Chakra ansetzen, damit du den Gegner effektiv schaden machst, während er sich mit einen Doton Jutsu schützt?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder"><input type="radio" name="8" value="a"> Mehr als der Gegner</td>';  
echo '<td class="tdborder"><input type="radio" name="8" value="b"> Gleichviel wie der Gegner</td>'; 
echo '<td class="tdborder"><input type="radio" name="8" value="c"> Weniger als der Gegner</td>';
echo '</tr>';   
echo '<tr>';
echo '<td class="tdborder" colspan="3">';    
echo 'Du wirfst ein Kunai auf den Gegner. Die Bahn des Kunais beschreibt eine Parabel (-0.2x²+1x). Die Entfernung zum Gegner beträgt 500m. Wann ist der Kunai an seiner höhsten Stelle?';    
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td><input type="radio" name="9" value="a"> 250m</td>';  
echo '<td><input type="radio" name="9" value="b"> 300m</td>'; 
echo '<td><input type="radio" name="9" value="c"> 350m</td>';
echo '</tr>'; 
echo '</table>';     
echo '<br>';
echo '<input class="button" name="login" id="login" value="abgeben" type="submit">';
echo '</center></form>';
}
else{
$zufall = rand(1,2);   
echo '<center><br><table class="table">';                                                                            
echo '<tr><td class="tdbg tdborder">Bevor du die letzte Frage beantworten kannst, kannst du ausssuchen, ob du gehst oder bleibst.</td></tr>';
//Anime/Manga: fragen beantworten , letzte Frage: bleibt man oder geht, geht -> nochmal neu antreten , bleibt -> beim versagen nie mehr teilnehmen , ähnlichkeit zu einer mission
echo '<tr><td>';
if($zufall == 1){
echo 'Wenn du gehst, verliert dein komplettes Team, ihr könnt also an dieser Prüfung nie mehr teilnehmen.
<br> Wenn du die Frage jedoch falsch beantwortest, wird dein komplettes Team nie mehr an irgendeiner Mission teilnehmen können.';   
echo '</td></tr><tr><td class="tdborder tdbg"><form method="post" action="chuunin.php?aktion=lfrage1">';    
echo '<table width="100%"><tr>';
echo '<td><input class="button" name="wahl" id="login" value="gehen" type="submit"></td>';  
echo '<td><input class="button" name="wahl" id="login" value="bleiben" type="submit"></td>'; //richtig  
echo '</form></tr></table>';
//bleiben
}
if($zufall == 2){
echo 'Wenn du gehst, verliert dein komplettes Team, ihr könnt die Prüfung jedoch beim nächsten Mal wiederholen.
<br> Wenn du die Frage jedoch falsch beantwortest, wird dein komplettes Team nie mehr an irgendeiner Mission teilnehmen können.';
echo '</td></tr><tr><td class="tdborder tdbg"><form method="post" action="chuunin.php?aktion=lfrage2">';    
echo '<table width="100%"><tr>';
echo '<td><input class="button" name="wahl" id="login" value="gehen" type="submit"></td>';       //richtig
echo '<td><input class="button" name="wahl" id="login" value="bleiben" type="submit"></td>';   
echo '</form></tr></table>';
//gehen
}
echo '</td></tr></table>';
}
}
else{
echo '<br>Du bist in einem Turnier. Warte, bis es startet.';
}
}
}
}
else{
if($chuuninp == 1){
echo 'Die Chuunin Prüfung findet immer am Mittwoch, Freitag und Sonntag von 15Uhr bis 20Uhr statt.<br/>';
echo 'Der Austragungsort der nächsten Prüfung ist '.ucwords($chuuninon).'gakure.';
}    
if($chuuninp == 2){
echo 'Die schriftliche Prüfung findet gerade in '.ucwords($chuuninon).'gakure statt. Sie geht von 15Uhr bis 18Uhr.';
}   
if($chuuninp == 3){
echo 'Das Turnier findet gerade in '.ucwords($chuuninon).'gakure statt. Es geht von 18Uhr bis 20Uhr.';
}
}
}
}
else{
echo 'Die Chuunin Prüfung findet immer am Mittwoch, Freitag und Sonntag von 15Uhr bis 20Uhr statt.<br/>';
echo 'Der Austragungsort der nächsten Prüfung ist '.ucwords($chuuninon).'gakure.';
}
//Hier kommt der Code hin
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