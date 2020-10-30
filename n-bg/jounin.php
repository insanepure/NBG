<?php
include 'inc/incoben.php';
if(logged_in()){   
$uort = getwert(session_id(),"charaktere","ort","session");    
$urank = getwert(session_id(),"charaktere","rank","session");       
$ulevel = getwert(session_id(),"charaktere","level","session");   
$udorf = getwert(session_id(),"charaktere","dorf","session");     
$kageturnier = getwert($udorf,"orte","kagetid","id");  
$aktion = $_GET['aktion'];                                                  
if($uort == 13&&$urank == 'nuke-nin'&&$ulevel >= 60&&$aktion == 'nuke'){
$nukep = 1;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer
FROM
items
WHERE besitzer="'.$uid.'" AND name = "Nuke-Nin Mantel" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$nukep = 0;
}
$result->close();
$db->close(); 
if($nukep == 1){    
$uhp = getwert(session_id(),"charaktere","hp","session");   
if($uhp != 0){          
$mission = getwert(session_id(),"charaktere","mission","session");   
if($mission == "0"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));      
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET mission ='250',mwo ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}           
mysqli_close($con); 
$error = '<a href="ort.php">Hier geht es weiter</a>';
}
else{
$error = 'Du machst bereits eine Mission.';
}

}
else{
$error = 'Du hast nicht genügend HP.';
}                                    

}
}
if($udorf == $uort && ($urank == "anbu" || $urank == 'jounin') && $aktion == "kage"&&$kageturnier != 0){ 
        
$uhp = getwert(session_id(),"charaktere","hp","session");    
$uturnier = getwert(session_id(),"charaktere","turnier","session"); 
if($uhp != 0){
if($uturnier == 0){    
$tzeit = getwert($kageturnier,"turnier","start","id");    
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
WHERE turnier = "'.$kageturnier.'"
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
$sql="UPDATE charaktere SET turnier ='$kageturnier',two ='$uwo',trunde ='1' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                            
$teilnehmer = getwert($kageturnier,"turnier","teilnehmer","id");    
$teilnehmer = $teilnehmer+1;
$sql="UPDATE turnier SET teilnehmer ='$teilnehmer' WHERE id = '".$kageturnier."' LIMIT 1";
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
('$kageturnier',
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
$error = 'Das Turnier hat schon begonnen.';  
}
} 
else{
$error = 'Du bist schon in einem Turnier.';  
}
}
else{
$error = 'Du hast zuwenig HP.';
}

}
if($udorf == $uort&&$urank == "jounin"&&$ulevel >= 60&&$aktion == "anbu"){ 
$mission = getwert(session_id(),"charaktere","mission","session");   
if($mission == "0"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));      
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET mission ='230',mwo ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}           
mysqli_close($con); 
$error = '<a href="ort.php">Hier geht es weiter</a>';
}
else{
$error = "Du bist bereits auf einer Mission.";
}

}  
if($udorf == $uort&&$urank == "chuunin"&&$ulevel >= 50&&$aktion == "jounin"){ 
$mission = getwert(session_id(),"charaktere","mission","session");   
if($mission == "0"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));      
$uid = getwert(session_id(),"charaktere","id","session");
$sql="UPDATE charaktere SET mission ='229',mwo ='0' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}         
mysqli_close($con); 
$error = '<a href="ort.php">Hier geht es weiter</a>';
}
else{
$error = "Du bist bereits auf einer Mission.";
}

}

}
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                                           
//Hier kommt der Code hin
if($uort == 13&&$urank == 'nuke-nin'&&$ulevel >= 60){
$nukep = 1;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer
FROM
items
WHERE besitzer="'.$uid.'" AND name = "Nuke-Nin Mantel" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$nukep = 0;
}
$result->close();
$db->close(); 
if($nukep == 1){
echo '<h3>Nuke Prüfung</h3>';
echo 'Du siehst ein Ninja und er deutet auf einen geheimen Raum.<br><a href="jounin.php?aktion=nuke">In den Raum gehen.</a>';
}
}
if($udorf == $uort && ( $urank == "anbu" || $urank == 'jounin') && $kageturnier != 0){
echo '<h3>Kage Turnier</h3>';
echo 'Das Kage Turnier findet statt und du hast dich als erfolgreicher Ninja bewährt.<br><a href="jounin.php?aktion=kage">Am Turnier teilnehmen.</a>';
//Hier kommt der Code hin
}
if($udorf == $uort&&$urank == "jounin"&&$ulevel >= 60){
echo '<h3>Anbu Prüfung</h3>';
echo 'Du betrittst das Kage Haus und läufst zum Missionsraum.<br>Dein Lehrer erwartet dich dort.<br><a href="jounin.php?aktion=anbu">Mit dem Lehrer reden</a>';
//Hier kommt der Code hin
}
if($udorf == $uort&&$urank == "chuunin"&&$ulevel >= 50){
echo '<h3>Jounin Prüfung</h3>';
echo 'Du betrittst das Kage Haus und läufst zum Missionsraum.<br>Dein Lehrer erwartet dich dort.<br><a href="jounin.php?aktion=jounin">Mit dem Lehrer reden</a>';
//Hier kommt der Code hin
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