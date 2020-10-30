<?php
include 'inc/incoben.php';
$reg = getwert(1,"game","reg","id"); 
$register = 0;   
if($reg == ""){
if(!logged_in())
{        
require_once('inc/recaptchalib.php'); // reCAPTCHA Library
$pubkey = "6LfBZt8SAAAAAD1M685qoyUL7MNurAcS97plUoQ-"; // Public API Key
$privkey = "6LfBZt8SAAAAAB_VMb1Q_IE3gJP7HiPy-Rr-DmTE"; // Private API Key
if($logged && $charaCreationActive){
// Hier kommen Skripts hin die vorm Laden ausgeführt werden
// Lade Daten
$dorf = $_REQUEST['dorf'];
$clan = $_REQUEST['clan'];
$gender = $_GET['gender'];
$chara = $_POST['chara'];  
$chara = str_replace(" ", '', $chara); 
$geht = 0;                  
$werte = $_GET['werte']; 
if($werte == ""){
$kraft = $_POST['kraft']; 
$wid = $_POST['wid'];  
$int = $_POST['int'];  
$chrk = $_POST['chrk'];  
$tmp = $_POST['tmp'];  
$gnk = $_POST['gnk'];  
$werte = $kraft+$wid+$int+$chrk+$tmp+$gnk;
}
else{    
$array = explode(";", trim($werte));
$kraft = $array[0];    
$wid = $array[1];
$int = $array[2];
$chrk = $array[3];
$tmp = $array[4];
$gnk = $array[5];  
$werte = $kraft+$wid+$int+$chrk+$tmp+$gnk;
}
// Setze den Acc und Charakternamen entsprechend
$leer = 1;
while($leer == 1){
$leerzeichen = substr($chara,-1);
if($leerzeichen == " "){
$length = strlen($chara );
$chara = substr($chara,0,$length-1);
}  
else{
$leer = 0;
}
}
//Überprüfung
if($dorf == ""||$dorf != "konoha"&&$dorf != "kusa"&&$dorf != "suna"&&$dorf != "taki"&&$dorf != "kiri"&&$dorf != "ame"&&$dorf != "kumo"&&$dorf != "oto"&&$dorf != "iwa"){
$error = "Bitte wähle ein Dorf.<br>";
}
else{
if($clan == ""||$dorf == "konoha"&&$clan !='kurama'&&$clan != 'yamanaka'&&$clan != "normal"&&$clan != "mokuton"&&$clan != "akimichi"&&$clan != "nara"&&$clan != "inuzuka"&&$clan != "tai"||$dorf == "oto"&&$clan !='sakon'&&$clan !='senninka'&&$clan != "normal"&&$clan != "kaguya"&&$clan != "uchiha"&&$clan != "shouton"&&$clan != "kumo"&&$clan != "mokuton"||$dorf == "iwa"&&$clan !='kamizuru'&&$clan !='kurama'&&$clan != "normal"&&$clan != "akimichi"&&$clan != "aburame"&&$clan != "hyuuga"&&$clan != "jiton"&&$clan != "inuzuka"||$dorf == "ame"&&$clan !='hozuki'&&$clan !='yamanaka'&&$clan != "normal"&&$clan != "kaguya"&&$clan != "yuki"&&$clan != "shouton"&&$clan != "youton"&&$clan != "kugutsu"||$dorf == "kiri"&&$clan !='senninka'&&$clan !='hozuki'&&$clan != "normal"&&$clan != "yuki"&&$clan != "youton"&&$clan != "kaguya"&&$clan != "nara"&&$clan != "kugutsu"||$dorf == "taki"&&$clan !='hozuki'&&$clan !='kamizuru'&&$clan != "normal"&&$clan != "yuki"&&$clan != "mokuton"&&$clan != "shouton"&&$clan != "uchiha"&&$clan != "inuzuka"||$dorf == "suna"&&$clan !='sakon'&&$clan !='senninka'&&$clan != "normal"&&$clan != "sand"&&$clan != "jiton"&&$clan != "kugutsu"&&$clan != "kumo"&&$clan != "hyuuga"||$dorf == "kusa"&&$clan !='kamizuru'&&$clan !='kurama'&&$clan != "normal"&&$clan != "mokuton"&&$clan != "aburame"&&$clan != "inuzuka"&&$clan != "nara"&&$clan != "tai"||$clan != "youton"&&$clan != "kumo"&&$clan != "shouton"&&$clan != "jiton"&&$clan != "nara"&&$clan != "akimichi"&&$clan != "inuzuka"&&$clan != "hyuuga"&&$clan != "sand"&&$clan != "uchiha"&&$clan != "normal"&&$clan != "mokuton"&&$clan != "yuki"&&$clan != "kugutsu"&&$clan != "tai"&&$clan != "aburame"&&$clan != "kaguya"&&$clan !='kurama'&&$clan !='senninka'&&$clan !='hozuki'&&$clan !='kamizuru'&&$clan !='sakon'&&$clan !='yamanaka'){
$error = "Bitte wähle ein Clan.<br>";
}
else{
if($gender != "boy"&&$gender != "girl"){
$error = "Bitte wähle ein Geschlecht.<br>";
}
else{
if($werte == ""||$werte != "90"||$kraft > "20"||$kraft < "10"||$wid > "20"||$wid < "10"||$int > "20"||$int < "10"||$gnk > "20"||$gnk < "10"||$tmp > "20"||$tmp < "10"||$chrk > "20"||$chrk < "10"||$clan == "tai"&&$int != "10"||$clan == "tai"&&$chrk != "10"){               
$error = "Bitte wähle deine Startwerte aus.<br>";
if($werte != ""){
if($werte != "90"){       
$error = $error."Die Werte müssen zusammen 90 ergeben.<br>";
}
if($kraft > "20"||$kraft < "10"){      
$error = $error."Kraft darf nicht größer als 20 oder kleiner als 10 sein.<br>";
}
if($wid > "20"||$wid < "10"){      
$error = $error."Widerstand darf nicht größer als 20 oder kleiner als 10 sein.<br>";
}
if($clan == "tai"){
if($int != "10"){
$error = $error.'Intelligenz muss als Tai 10 betragen!<br>';
}
} 
if($int > "20"||$int < "10"){     
$error = $error."Intelligenz darf nicht größer als 20 oder kleiner als 10 sein.<br>";
}

if($clan == "tai"){
if($chrk != "10"){
$error = $error.'Chakrakontrolle muss als Tai 10 betragen!<br>';
}      
} 
if($chrk > "20"||$chrk < "10"){    
$error = $error."Chakrakontrolle darf nicht größer als 20 oder kleiner als 10 sein.<br>";
}
if($tmp > "20"||$tmp < "10"){      
$error = $error."Tempo darf nicht größer als 20 oder kleiner als 10 sein.<br>";
}
if($gnk > "20"||$gnk < "10"){      
$error = $error."Genauigkeit darf nicht größer als 20 oder kleiner als 10 sein.<br>";
}
}
}
else{
$geht = 1;
if(!sonderzeichen($chara)){
$geht = 0;
$error = $error."Es befinden sich Sonderzeichen im Charakternamen.<br>";
}
if(!namencheck($chara)){
$geht = 0;
$error = $error."Der Charaktername hat unzulässige Wörter im Namen.<br>";
}          
$zustimmen = $_POST['zustimmen'];
if($zustimmen != "Ja"){
$geht = 0;
$error = $error."Du musst die Regeln akzeptieren.<br>";
}
//Fehlermeldungen ende
if($geht == 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name
FROM
charaktere
WHERE name LIKE "'.$chara.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if(strtolower($chara) == strtolower($row['name'])){
$geht = 0;
$error = $error."Dieser Charakternamen existiert schon.<br>";
}
}
$result->close(); $db->close(); 
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
besitzer
FROM
summon
WHERE name LIKE "'.$chara.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false     
$bclan = getwert($row['besitzer'],"charaktere","clan","id");  
if($bclan == "inuzuka"){
$geht = 0;
$error = $error."Dieser Charakternamen existiert schon.<br>";
}
}
$result->close(); $db->close(); 
if($chara == '')
{
$geht = 0;
$error = $error."Du hast keinen Charakternamen angeben.<br>";
}
if($geht == 1){
//Setze Daten fest
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$hp = 100;
$chakra = 100;
$ryo = 1000;
$level = 1;   
$mexp = 100;
$elemente = "";
$vertrag = "";
if($clan == "uchiha"){
$elemente = "Katon";
}              
if($clan == "hozuki"){
$elemente = "Suiton";
}       
if($clan == "yuki"){
$elemente = "Suiton;Fuuton";
}           
if($clan == "youton"){
$elemente = "Katon;Doton";
}          
if($clan == "mokuton"){
$elemente = "Suiton;Doton";
}          
if($clan == "kumo"){
$vertrag = "spinne";
}           
if($clan == "kamizuru"){
$vertrag = "bienen";
}
$jutsus = "1;2;3";
if($clan != "tai")
{
  $jutsus = $jutsus.';456;457';
}
$rank = "student";
if($gender == "boy"){
$gender2 = "männlich";
$mapc = "1";
}
if($gender == "girl"){
$gender2 = "weiblich";  
$mapc = "2";
}         
$dorf2 = getwert($dorf,"orte","id","name");  
$richtige_ip = get_real_ip();

$geht = 1;                
$zeit2 = time();
$zeit = date("Y-m-d H:i:s",$zeit2);
$test2 = strtotime($zeit);          
if($geht == 1){
//Datenbank verbindung
//Schreibe daten rein
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
$sql="INSERT INTO charaktere(
`name`,
`hp`,
`mhp`,
`chakra`,
`mchakra`,
`level`,  
`mexp`,
`clan`,
`dorf`,
`ort`,
`rank`,
`geschlecht`,
`ryo`,
`kr`,
`mkr`,
`intl`,
`mintl`,
`chrk`,
`mchrk`,
`tmp`,
`mtmp`,
`gnk`,
`mgnk`,
`wid`,
`mwid`,
`jutsus`,
`kbutton`,
`anmeldedatum`,
`mapc`,        
`elemente`,
`vertrag`,   
`cstory`,    
`story`,     
`kdata`,       
`autoplay`,    
`main`, 
`chat`)
VALUES
('$chara',
'$hp',
'$hp',
'$chakra',
'$chakra',
'$level',   
'$mexp',
'$clan',
'$dorf2',
'$dorf2',
'$rank',
'$gender2',
'$ryo',
'$kraft',
'$kraft',
'$int',
'$int',
'$chrk',
'$chrk',
'$tmp',
'$tmp',
'$gnk',
'$gnk',
'$wid',
'$wid',
'$jutsus',
'$jutsus',
'$zeit',
'$mapc',    
'$elemente',
'$vertrag', 
'1',         
'1',       
'1',     
'1',   
'".$account->Get('id')."', 
'0')";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}            
$userid = mysqli_insert_id($con);
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id
FROM
charaktere
ORDER BY
level DESC,
exp DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$platz = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$platz++;
if($row['id'] == $userid){
$uplatz = $platz;
}
}
$result->close();
$db->close();
$sql="UPDATE charaktere
SET ip='$richtige_ip',platz='$uplatz'
WHERE id='".$userid."' LIMIT 1";
mysqli_query($con, $sql); 
mysqli_close($con);  
$register = 1;
  
$error = 'Du wurdest erfolgreich registriert.<br>Du wirst gleich zum Spiel weitergeleitet.<br>';  
header("refresh: 5; url=main_login.php");
  
$email = $account->Get('email'); 
$topic = 'Charakter bei NBG';
$content ='Du hast dich beim <a href="https://v1.n-bg.de/">Naruto Browsergame</a> angemeldet.<br>           
Dein Charakter heißt: <b>'.$chara.'</b><br>';
if($gender == "boy"){
$text = $text.'Du bist ein <b>Shinobi</b>.<br>';
}
if($gender == "girl"){
$text = $text.'Du bist eine <b>Kunoichi</b>.<br>';
}
$text = $text.'
Dein Clan/Bluterbe: <b>'.ucfirst($clan).'</b><br> 
Kraft: <b>'.$kraft.'</b><br> 
Intelligenz: <b>'.$int.'</b><br> 
Chakrakontrolle: <b>'.$chrk.'</b><br> 
Tempo: <b>'.$tmp.'</b><br> 
Genauigkeit: <b>'.$gnk.'</b><br> 
Widerstand: <b>'.$wid.'</b><br>
Wir wünschen dir dabei viel Spaß!<br>';
  
if(SendMail($email,$topic, $content))
{
  $error = 'Es wurde eine Mail an deiner E-Mail Addresse gesendet. Schau auch im Spam-Ordner nach.';
}
else
{
  $error = 'Es gab einen Fehler beim Senden der E-Mail. Bitte frage im Discord nach.';
}
  
}

}
}
}
}
}
}
}
else{
$error = 'Du muss dich noch einloggen.';
}
}
}
?>
<?php include 'inc/design3.php'; ?>
<?php
if($reg == ""&&!logged_in()){
$quiz = $_GET['quiz'];          
if($register == 0){
if($dorf == ""||$dorf != "konoha"&&$dorf != "kusa"&&$dorf != "suna"&&$dorf != "taki"&&$dorf != "kiri"&&$dorf != "ame"&&$dorf != "kumo"&&$dorf != "oto"&&$dorf != "iwa"){
if($quiz == 4){  
$a = $_POST['a']; 
echo '<h2 class="shadow">Quiz Ergenis</h2>';   
echo '<img src="bilder/reg/'.$a.'.png"></img>';
echo '<br>';           
echo 'Zu dir passt <b class="shadow">'.ucwords($a).'</b>!';
echo '<br>';
echo '<form method="post" action="charregister.php?dorf='.$a.'">'; 
echo '<input class="button" name="login" id="login" value="weiter" type="submit"></form>';      
echo '<br>';    
echo '<a href="charregister.php">Zurück</a>';
}
if($quiz == 3){  
$a = $_POST['a'];
//Mut = Konoha , Kusa
//Vorsicht = Taki, Oto
echo '<h2 class="shadow">Quiz Frage #3</h2>';     
echo 'Was isst du von dem angegebenem Essen lieber?';    
echo '<form method="post" action="charregister.php?quiz=4">'; 
echo '<table width="100%">';
echo '<tr>';
echo '<td align="center">';
echo'<center><div class="auswahl">';
echo '<select name="a" class="Auswahl" size="1">'; 
if($a == "Mut"){        
echo'<option value="konoha">Nudelsuppe</option>';  
echo'<option value="Kusa">Pilzsuppe</option>';       
}                 
if($a == "Vorsicht"){        
echo'<option value="taki">Früchte</option>';  
echo'<option value="oto">Reis</option>';       
}     
echo '</select>'; 
echo '</div>';        
echo '</td>';
echo '</tr>';  
echo '<tr>';
echo '<td align="center">';
echo '<input class="button" name="login" id="login" value="weiter" type="submit"></form>';       
echo '</td>';
echo '</tr>';  
echo '</table>';
echo '<br>';    
echo '<a href="charregister.php?quiz=1">Zurück</a>';

}
if($quiz == 2){
$a = $_POST['a'];
//Wald = Konoha, Kusa , Taki , Oto
//Bergen = Iwa , Kumo
//See = Ame, Taki 
//Wüste = Suna , Iwa
//Meer = Kiri, Ame
echo '<h2 class="shadow">Quiz Frage #2</h2>';    
if($a == "Wald"){        
echo 'Vor dir ist eine dir unbekannte Situation, wie verhältst du dich?';   
echo '<form method="post" action="charregister.php?quiz=3">'; 
}         
if($a == "Bergen"){        
echo 'Magst du eine starke Verteidigung oder eine schnelle Bewegung?';  
echo '<form method="post" action="charregister.php?quiz=4">'; 
}           
if($a == "See"){        
echo 'Magst du kalte Gegenden?';   
echo '<form method="post" action="charregister.php?quiz=4">'; 
}           
if($a == "Meer"){        
echo 'Magst du Regen oder Nebel?';     
echo '<form method="post" action="charregister.php?quiz=4">'; 
}            
if($a == "Wüste"){        
echo 'Magst du steile Klippen oder eine flache Ebene?'; 
echo '<form method="post" action="charregister.php?quiz=4">'; 
} 
echo '<table width="100%">';
echo '<tr>';
echo '<td align="center">';
echo'<center><div class="auswahl">';
echo '<select name="a" class="Auswahl" size="1">'; 
if($a == "Wald"){        
echo'<option value="Mut">Keinen Rückzieher machen.</option>';  
echo'<option value="Vorsicht">Langsam voran tasten.</option>';       
}                 
if($a == "Bergen"){        
echo'<option value="iwa">Eine starke Verteidigung</option>';  
echo'<option value="kumo">Eine schnelle Bewegung</option>';       
}                   
if($a == "Meer"){        
echo'<option value="kiri">Nebel</option>';  
echo'<option value="ame">Regen</option>';       
}                
if($a == "Wüste"){        
echo'<option value="suna">flache Ebene</option>';  
echo'<option value="iwa">steile Klippe</option>';       
}            
if($a == "See"){        
echo'<option value="ame">Ich bevorzuge kalte Orte.</option>';  
echo'<option value="taki">Ich bevorzuge warme Orte.</option>';       
}     
echo '</select>'; 
echo '</div>';        
echo '</td>';
echo '</tr>';  
echo '<tr>';
echo '<td align="center">';
echo '<input class="button" name="login" id="login" value="weiter" type="submit"></form>';       
echo '</td>';
echo '</tr>';  
echo '</table>';
echo '<br>';   
echo '<a href="charregister.php?quiz=1">Zurück</a>';
}
if($quiz == 1){
echo '<h2 class="shadow">Quiz Frage #1</h2>';
echo 'An welchem Ort bist du lieber?';    
echo '<form method="post" action="charregister.php?quiz=2">';
echo '<table width="100%">';
echo '<tr>';
echo '<td align="center">';
echo'<center><div class="auswahl">';
echo '<select name="a" class="Auswahl" size="1">';                
echo'<option value="Wald">Im Wald</option>';                  
echo'<option value="Meer">Am Meer</option>';                
echo'<option value="Bergen">In den Bergen</option>';         
echo'<option value="Wüste">In der Wüste</option>';         
echo'<option value="See">Am See</option>';    
echo '</select>'; 
echo '</div>';        
echo '</td>';
echo '</tr>';  
echo '<tr>';
echo '<td align="center">';
echo '<input class="button" name="login" id="login" value="weiter" type="submit"></form>';       
echo '</td>';
echo '</tr>';  
echo '</table>';
echo '<br>';                          
echo '<a href="charregister.php">Zurück</a>';
}
if($quiz == ""){                                   
echo 'Du kannst dich nicht entscheiden? <a href="charregister.php?quiz=1">Quiz starten</a><br>';
echo '<div class="relativ dorfwahl">';
echo '<div class="konoha">';
echo '<a href="charregister.php?dorf=konoha" onMouseover="showtext(';
echo "'<b>Konohagakure</b><br>Konohagakure liegt im Reich des Feuers.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="kusa">';
echo '<a href="charregister.php?dorf=kusa" onMouseover="showtext(';
echo "'<b>Kusagakure</b><br>Kusagakure liegt im Land des Grases.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="suna">';
echo '<a href="charregister.php?dorf=suna" onMouseover="showtext(';
echo "'<b>Sunagakure</b><br>Sunagakure liegt im Reich des Windes.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="taki">';
echo '<a href="charregister.php?dorf=taki" onMouseover="showtext(';
echo "'<b>Takigakure</b><br>Takigakure liegt im Land der Wasserfälle.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="kiri">';
echo '<a href="charregister.php?dorf=kiri" onMouseover="showtext(';
echo "'<b>Kirigakure</b><br>Kirigakure liegt im 	Reich des Wassers.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="ame">';
echo '<a href="charregister.php?dorf=ame" onMouseover="showtext(';
echo "'<b>Amegakure</b><br>Amegakure liegt im Land des Regens.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="kumo">';
echo '<a href="charregister.php?dorf=kumo" onMouseover="showtext(';
echo "'<b>Kumogakure</b><br>Kumogakure liegt im Reich des Blitzes.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="oto">';
echo '<a href="charregister.php?dorf=oto" onMouseover="showtext(';
echo "'<b>Otogakure</b><br>Otogakure liegt im Land der Reisfelder.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="iwa">';
echo '<a href="charregister.php?dorf=iwa" onMouseover="showtext(';
echo "'<b>Iwagakure</b><br>Iwagakure liegt im Reich der Erde.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '</div>';
echo '<div id="textdiv" class="shadow" style="margin-top:200px;">'.$error.'</div>';                          
echo '<a href="index.php">Zurück</a>'; 
}                                       
}
else{
if($clan == ""||$dorf == "konoha"&&$clan !='kurama'&&$clan != 'yamanaka'&&$clan != "normal"&&$clan != "mokuton"&&$clan != "akimichi"&&$clan != "nara"&&$clan != "inuzuka"&&$clan != "tai"||$dorf == "oto"&&$clan !='sakon'&&$clan !='senninka'&&$clan != "normal"&&$clan != "kaguya"&&$clan != "uchiha"&&$clan != "shouton"&&$clan != "kumo"&&$clan != "mokuton"||$dorf == "iwa"&&$clan !='kamizuru'&&$clan !='kurama'&&$clan != "normal"&&$clan != "akimichi"&&$clan != "aburame"&&$clan != "hyuuga"&&$clan != "jiton"&&$clan != "inuzuka"||$dorf == "ame"&&$clan !='hozuki'&&$clan !='yamanaka'&&$clan != "normal"&&$clan != "kaguya"&&$clan != "yuki"&&$clan != "shouton"&&$clan != "youton"&&$clan != "kugutsu"||$dorf == "kiri"&&$clan !='senninka'&&$clan !='hozuki'&&$clan != "normal"&&$clan != "yuki"&&$clan != "youton"&&$clan != "kaguya"&&$clan != "nara"&&$clan != "kugutsu"||$dorf == "taki"&&$clan !='hozuki'&&$clan !='kamizuru'&&$clan != "normal"&&$clan != "yuki"&&$clan != "mokuton"&&$clan != "shouton"&&$clan != "uchiha"&&$clan != "inuzuka"||$dorf == "suna"&&$clan !='sakon'&&$clan !='senninka'&&$clan != "normal"&&$clan != "sand"&&$clan != "jiton"&&$clan != "kugutsu"&&$clan != "kumo"&&$clan != "hyuuga"||$dorf == "kusa"&&$clan !='kamizuru'&&$clan !='kurama'&&$clan != "normal"&&$clan != "mokuton"&&$clan != "aburame"&&$clan != "inuzuka"&&$clan != "nara"&&$clan != "tai"||$clan != "youton"&&$clan != "kumo"&&$clan != "shouton"&&$clan != "jiton"&&$clan != "nara"&&$clan != "akimichi"&&$clan != "inuzuka"&&$clan != "hyuuga"&&$clan != "sand"&&$clan != "uchiha"&&$clan != "normal"&&$clan != "mokuton"&&$clan != "yuki"&&$clan != "kugutsu"&&$clan != "tai"&&$clan != "aburame"&&$clan != "kaguya"&&$clan !='kurama'&&$clan !='senninka'&&$clan !='hozuki'&&$clan !='kamizuru'&&$clan !='sakon'&&$clan !='yamanaka'){
if($clan == ""||$clan != "normal"){
if($quiz == 4){  
$a = $_POST['a'];
$a2 = $a; 
if($a == "kumo"){
$a2 = 'kumos';
}
echo '<h2 class="shadow">Quiz Ergebnis</h2>';   
echo '<img src="bilder/reg/'.$a.'.png"></img>';
echo '<br>';           
echo 'Zu dir passt <b class="shadow">'.ucwords($a).'</b>!';
echo '<br>';
echo '<form method="post" action="charregister.php?dorf='.$dorf.'&clan='.$a.'">'; 
echo '<input class="button" name="login" id="login" value="weiter" type="submit"></form>';      
echo '<br>';    
echo '<a href="charregister.php?dorf='.$dorf.'">Zurück</a>';
}
if($quiz == 3){
$a = $_POST['a']; 
//konoha - Nah - akimichi/inuzuka , Fern - nara/inuzuka  Nin - mokuton/normal , Tai - tai/normal
//kumo - Nah - hyuuga/normal , Fern - kumo/normal - Verbrennen - uchiha/youton , Einsperren - youton/shouton
//kusa - Nah - inuzuka/aburame , fern - aburame/nara - Nin - normal/mokuton , tai tai/normal
//ame - Ninj - yuki/shouton , Waffen - yuki/kugutsu - Nin - youton/normal , tai kaguya/normal
//iwa - Mehrere - aburame/jiton , Einer - jiton/inuzuka , Körper - normal/akimichi , Händen - normal/hyuuga
//oto - Ja - Kaguya/Kumo Nein - Kumo/Shouton - Leiten - normal/mokuton , Leiten lassen - uchiha/normal
//suna - Nah - normal/hyuuga , Fern - normal/kumo - Ja - sand/jiton , Nein - sand/kugutsu
//kiri - Familie - yuki/nara , Allein - yuki/youton - Nah - normal/kaguya , Fern - normal/kugutsu
//taki - Verbunden - yuki/mokuton , Nicht verbunden - mokuton/shouton -  Familie - uchiha/inuzuka , Allein - uchiha/normal
echo '<h2 class="shadow">Quiz Frage #3</h2>';     
if($dorf == "konoha"){
if($a == "Nah"){
echo 'Hast du einen Partner oder bist du alleine?'; 
}               
if($a == "Fern"){
echo 'Hast du einen Partner oder bist du alleine?'; 
}  
if($a == "Nin"){
echo 'Bist du etwas besonderes oder bist du normal?'; 
} 
if($a == "Tai"){
echo 'Bist du etwas besonderes?';
} 
} 
if($dorf == "kumo"){
if($a == "Nah"){
echo 'Bist du etwas besonderes?'; 
}               
if($a == "Fern"){
echo 'Bist du etwas besonderes oder bist du normal?'; 
}  
if($a == "Verbrennen"){
echo 'Hast du eine Familie hinter dir oder bist du allein?'; 
} 
if($a == "Einsperren"){
echo 'Magst du die Wärme oder die Kälte?'; 
} 
}  
if($dorf == "kusa"){
if($a == "Nah"){
echo 'Hast du ein Partner oder mehrere?'; 
}               
if($a == "Fern"){
echo 'Hast du  Partner oder bist du alleine?'; 
}  
if($a == "Nin"){
echo 'Bist du etwas besonderes oder normal?'; 
} 
if($a == "Tai"){
echo 'Bist du etwas besonderes?'; 
} 
}  
if($dorf == "ame"){
if($a == "Ninj"){
echo 'Fühlst du dich zum Wasser hingezogen?'; 
}               
if($a == "Waffen"){
echo 'Sind deine Waffen klein oder groß?'; 
}  
if($a == "Nin"){
echo 'Magst du sehr warme Orte?'; 
} 
if($a == "Tai"){
echo 'Bist du etwas besonderes?'; 
} 
}    
if($dorf == "iwa"){
if($a == "Mehrere"){
echo 'Ist dein Partner lebendig?'; 
}               
if($a == "Einer"){
echo 'Ist dein Partner lebendig?'; 
}  
if($a == "Körper"){
echo 'Bist du etwas besonderes?'; 
} 
if($a == "Händen"){
echo 'Bist du etwas besonderes?'; 
} 
} 
if($dorf == "oto"){
if($a == "Ja"){
echo 'Bist du mehr im Nahkampf oder mehr im Fernkampf aktiv?'; 
}               
if($a == "Nein"){
echo 'Magst du mehr Taijutsus oder mehr Ninjutsus?'; 
}  
if($a == "Leiten"){
echo 'Lässt du einen Feind am Leben oder tötest du ihn?'; 
} 
if($a == "Leiten lassen"){
echo 'Bist du besonders oder normal??'; 
} 
} 
if($dorf == "suna"){
if($a == "Nah"){
echo 'Bist du besonders oder normal?'; 
}               
if($a == "Fern"){
echo 'Bist du besonders oder normal?'; 
}  
if($a == "Ja"){
echo 'Bist du mehr offensiv oder mehr defensiv?'; 
} 
if($a == "Nein"){
echo 'Benutzt du Waffen oder Ninjutsu zum kämpfen?'; 
} 
}  
if($dorf == "kiri"){
if($a == "Familie"){
echo 'Magst du mehr das Licht oder mehr die Dunkelheit?'; 
}               
if($a == "Allein"){
echo 'Magst du die Wärme oder die Kälte?'; 
}  
if($a == "Nah"){
echo 'Bist du besonders oder normal?'; 
} 
if($a == "Fern"){
echo 'Benutzt du Waffen zum kämpfen?'; 
} 
}
if($dorf == "taki"){
if($a == "Verbunden"){
echo 'Bist du für Wärme oder für Kälte?'; 
}               
if($a == "Nicht verbunden"){
echo 'Bist du für Wärme oder für Kälte?'; 
}  
if($a == "Familie"){
echo 'Hast du einen Partner oder bist du allein?'; 
} 
if($a == "Allein"){
echo 'Hast du berühmte Vorfahren?'; 
} 
}
echo '<form method="post" action="charregister.php?dorf='.$dorf.'&quiz=4">';
echo '<table width="100%">';
echo '<tr>';
echo '<td align="center">';
echo'<center><div class="auswahl">';
echo '<select name="a" class="Auswahl" size="1">'; 
if($dorf == "konoha"){
if($a == "Nah"){
echo'<option value="akimichi">Alleine</option>'; 
echo'<option value="inuzuka">Partner</option>';
}               
if($a == "Fern"){
echo'<option value="nara">Alleine</option>'; 
echo'<option value="inuzuka">Partner</option>';
}  
if($a == "Nin"){
echo'<option value="mokuton">Besonders</option>'; 
echo'<option value="normal">Normal</option>'; 
} 
if($a == "Tai"){
echo'<option value="tai">Besonders</option>'; 
echo'<option value="normal">Normal</option>'; 
} 
} 
if($dorf == "kumo"){
if($a == "Nah"){
echo'<option value="hyuuga">Besonders</option>'; 
echo'<option value="normal">Normal</option>';
}               
if($a == "Fern"){
echo'<option value="kumo">Besonders</option>'; 
echo'<option value="normal">Normal</option>';
}  
if($a == "Verbrennen"){
echo'<option value="youton">Allein</option>'; 
echo'<option value="uchiha">Familie</option>';
} 
if($a == "Einsperren"){
echo'<option value="youton">Wärme</option>'; 
echo'<option value="shouton">Kälte</option>';
} 
}  
if($dorf == "kusa"){
if($a == "Nah"){
echo'<option value="inuzuka">Ein Partner</option>'; 
echo'<option value="aburame">Mehrere Partner</option>';
}               
if($a == "Fern"){
echo'<option value="nara">Alleine</option>'; 
echo'<option value="aburame">Partner</option>';
}  
if($a == "Nin"){
echo'<option value="mokuton">Besonders</option>'; 
echo'<option value="normal">Normal</option>';
} 
if($a == "Tai"){
echo'<option value="tai">Besonders</option>'; 
echo'<option value="normal">Normal</option>';
} 
} 
if($dorf == "ame"){   
if($a == "Ninj"){
echo'<option value="yuki">Hingezogen</option>'; 
echo'<option value="shouton">Nicht hingezogen</option>';   
}    
if($a == "Waffen"){
echo'<option value="yuki">klein</option>'; 
echo'<option value="kugutsu">groß</option>';    
}         
if($a == "Nin"){
echo'<option value="youton">Sehr warm</option>'; 
echo'<option value="normal">Normal</option>';     
}
if($a == "Tai"){
echo'<option value="kaguya">Besonders</option>'; 
echo'<option value="normal">Normal</option>';      
}
} 
if($dorf == "iwa"){   
if($a == "Mehrere"){
echo'<option value="aburame">Lebendig</option>'; 
echo'<option value="jiton">Nicht lebendig</option>';   
}    
if($a == "Einer"){
echo'<option value="jiton">Nicht lebendig</option>'; 
echo'<option value="inuzuka">Lebendig</option>';    
}         
if($a == "Körper"){
echo'<option value="normal">Normal</option>'; 
echo'<option value="akimichi">Besonders</option>';     
}
if($a == "Händen"){
echo'<option value="normal">Normal</option>'; 
echo'<option value="hyuuga">Besonders</option>';      
}
} 
if($dorf == "oto"){   
if($a == "Ja"){
echo'<option value="kaguya">Nahkampf</option>'; 
echo'<option value="kumo">Fernkampf</option>';   
}    
if($a == "Nein"){
echo'<option value="kumo">Taijutsu</option>'; 
echo'<option value="shouton">Ninjutsu</option>';    
}         
if($a == "Leiten"){
echo'<option value="mokuton">Leben</option>'; 
echo'<option value="normal">Töten</option>';     
}
if($a == "Leiten lassen"){
echo'<option value="uchiha">besonders</option>'; 
echo'<option value="normal">normal</option>';      
}
} 
if($dorf == "suna"){   
if($a == "Nah"){
echo'<option value="hyuuga">Besonders</option>'; 
echo'<option value="normal">Normal</option>';   
}    
if($a == "Fern"){
echo'<option value="kumo">Besonders</option>'; 
echo'<option value="normal">Normal</option>';    
}         
if($a == "Ja"){
echo'<option value="jiton">Offensiv</option>'; 
echo'<option value="sand">Defensiv</option>';     
}
if($a == "Nein"){
echo'<option value="jiton">Ninjutsu</option>'; 
echo'<option value="kugutsu">Waffen</option>';      
}
}  
if($dorf == "kiri"){   
if($a == "Familie"){
echo'<option value="nara">Dunkelheit</option>'; 
echo'<option value="yuki">Licht</option>';   
}    
if($a == "Allein"){
echo'<option value="youton">Wärme</option>'; 
echo'<option value="yuki">Kälte</option>';   
}         
if($a == "Nah"){
echo'<option value="kaguya">Besonders</option>'; 
echo'<option value="normal">Normal</option>';     
}
if($a == "Fern"){
echo'<option value="kugutsu">Waffen</option>'; 
echo'<option value="normal">Alles</option>';     
}
} 
if($dorf == "taki"){   
if($a == "Verbunden"){
echo'<option value="mokuton">Wärme</option>'; 
echo'<option value="yuki">Kälte</option>';   
}    
if($a == "Nicht verbunden"){
echo'<option value="mokuton">Wärme</option>'; 
echo'<option value="shouton">Kälte</option>';   
}         
if($a == "Familie"){
echo'<option value="inuzuka">Partner</option>'; 
echo'<option value="uchiha">Allein</option>';     
}
if($a == "Allein"){
echo'<option value="normal">Keine berühmten Vorfahren</option>'; 
echo'<option value="uchiha">Berühmte Vorfahren</option>';     
}
}                                 
echo '</select>'; 
echo '</div>';        
echo '</td>';
echo '</tr>';  
echo '<tr>';
echo '<td align="center">';
echo '<input class="button" name="login" id="login" value="weiter" type="submit"></form>';       
echo '</td>';
echo '</tr>';  
echo '</table>';
echo '<br>';  
echo '<a href="charregister.php?dorf='.$dorf.'&quiz=1">Zurück</a>';
}
if($quiz == 2){                     
$a = $_POST['a'];
//konoha - Hilfe - akimichi/nara/inuzuka , kämpfen - normal/mokuton/tai
//kumo - Tai hyuuga/normal/kumo - Nin uchiha/youton/shouton      
//kusa - Hilfe aburame/inuzuka/nara - kämpfen normal/mokuton/tai
//ame - Fern - yuki/shouton/kugutsu , Nah - normal/kaguya/youton
//iwa - zusamm aburame/jiton/inuzuka - allein - normal/akimichi/hyuuga
//oto - Loyal Kaguya/Kumo/Shouton - Nicht Loyal normal/uchiha/mokuton
//suna - Ja normal/kumo/hyuuga - Nein sand/jiton/kugutsu
//kiri - Nin yuki/youton/nara- Tai normal/kaguya/kugutsu
//taki - Nin yuki/mokuton/shouton - Tai normal/uchiha/inuzuka  
echo '<h2 class="shadow">Quiz Frage #2</h2>';        

if($dorf == "taki"){
if($a == "Nin"){
echo 'Fühlst du dich zum Wasser verbunden?'; 
}           
if($a == "Tai"){
echo 'Hast du eine Familie die hinter dir steht oder bist du allein?'; 
} 
} 
if($dorf == "kiri"){
if($a == "Nin"){
echo 'Hast du eine starke Familie hinter dir oder bist du alleine?'; 
}           
if($a == "Tai"){
echo 'Bist du denn mehr der Fern- oder der Nahkämpfer?'; 
} 
} 
if($dorf == "suna"){
if($a == "Ja"){
echo 'Deine Eltern sind also immigriert. Waren deine Eltern denn mehr Nah- oder Fernkämpfer?'; 
}           
if($a == "Nein"){
echo 'Du lebst also schon lange mit deinen Eltern in Sunagakure. Hat eine hohe Persönlichkeit mal ein Familienmitglied von dir trainiert?'; 
} 
}   
if($dorf == "oto"){
if($a == "Loyal"){
echo 'Du bist deinem Anführer also loyal. Würdest du ihm sogar in den Tod folgen?'; 
}           
if($a == "Nicht Loyal"){
echo 'Du würdest also eher dein Leben retten als das Leben deines Anführers.<br>Stell dir nun vor du bist auf einer Mission.<br> Leitest du sie, oder wird sie von jemand anderen geleitet?'; 
} 
} 
if($dorf == "iwa"){
if($a == "Zusamm"){
echo 'Besteht dein Partner aus Mehreren oder ist es nur Einer?'; 
}           
if($a == "Allein"){
echo 'Du greifst deine Gegner also allein an. Womit greifst du hauptsächlich an?'; 
} 
}
if($dorf == "ame"){
if($a == "Fern"){
echo 'Du greifst deine Gegner also aus der Ferne an. Doch womit greifst du sie an?'; 
}           
if($a == "Nah"){
echo 'Du greifst deine Gegner also vom Nahen an. Doch womit greifst du an?'; 
} 
}
if($dorf == "kusa"){
if($a == "Hilfe"){
echo 'Der Kampf ist im vollen Gange. Doch wie greifst du an, von der Ferne oder vom Nahen?'; 
}           
if($a == "kämpfen"){
echo 'Du kämpfst also alleine gegen die männer. Womit greifst du an?'; 
} 
} 
if($dorf == "kumo"){
if($a == "Tai"){
echo 'Du greifst die Ninjas also mit Taijutsu an. Nach einiger Zeit überlegst du dir, im Nahkampf zu bleiben oder in den Fernkampf zu gehen.'; 
}           
if($a == "Nin"){
echo 'Nachdem du einige Ninjutsus auf den Gegner angewandt hast überlegst du dir einen finalen Move. Wie sieht er aus?'; 
} 
} 
if($dorf == "konoha"){
if($a == "Hilfe"){
echo 'Der Kampf ist im vollen Gange. Doch wie greifst du an, von der Ferne oder vom Nahen?'; 
}           
if($a == "kämpfen"){
echo 'Du kämpfst also alleine gegen die männer. Womit greifst du an?'; 
} 
}   
echo '<form method="post" action="charregister.php?dorf='.$dorf.'&quiz=3">';
echo '<table width="100%">';
echo '<tr>';
echo '<td align="center">';
echo'<center><div class="auswahl">';
echo '<select name="a" class="Auswahl" size="1">'; 
if($dorf == "taki"){   
if($a == "Nin"){
echo'<option value="Verbunden">Verbunden zum Wasser</option>'; 
echo'<option value="Nicht verbunden">Nicht verbunden</option>';   
}          
if($a == "Tai"){
echo'<option value="Familie">Familie</option>'; 
echo'<option value="Allein">Allein</option>';       
}
}               

if($dorf == "kiri"){
if($a == "Nin"){
echo'<option value="Familie">Familie</option>'; 
echo'<option value="Allein">Allein</option>';   
}          
if($a == "Tai"){
echo'<option value="Nah">Nahkampf</option>'; 
echo'<option value="Fern">Fernkampf</option>';     
}
}      
if($dorf == "suna"){
if($a == "Ja"){
echo'<option value="Nah">Nahkampf</option>'; 
echo'<option value="Fern">Fernkampf</option>';   
}          
if($a == "Nein"){
echo'<option value="Ja">Ja</option>'; 
echo'<option value="Nein">Nein</option>';   
}
}  
if($dorf == "oto"){
if($a == "Loyal"){
echo'<option value="Ja">Ja</option>'; 
echo'<option value="Nein">Nein</option>';   
}          
if($a == "Nicht Loyal"){
echo'<option value="Leiten">Leiten</option>'; 
echo'<option value="Leiten lassen">Leiten lassen</option>';   
}
}  
if($dorf == "iwa"){
if($a == "Zusamm"){
echo'<option value="Mehrere">Mehrere</option>'; 
echo'<option value="Einer">Einer</option>';   
}          
if($a == "Allein"){
echo'<option value="Körper">Ganzen Körper</option>'; 
echo'<option value="Händen">Händen</option>';   
}
}     
if($dorf == "ame"){
if($a == "Fern"){
echo'<option value="Ninj">Ninjutsu</option>'; 
echo'<option value="Waffen">Waffen</option>';   
}          
if($a == "Nah"){
echo'<option value="Nin">Ninjutsu</option>'; 
echo'<option value="Tai">Taijutsu</option>';   
}
}
if($dorf == "kusa"){
if($a == "Hilfe"){
echo'<option value="Nah">Nahkampf</option>'; 
echo'<option value="Fern">Fernkampf</option>';   
}          
if($a == "kämpfen"){
echo'<option value="Nin">Ninjutsu</option>'; 
echo'<option value="Tai">Taijutsu</option>';   
}
}
if($dorf == "kumo"){
if($a == "Tai"){
echo'<option value="Nah">Nahkampf</option>'; 
echo'<option value="Fern">Fernkampf</option>';   
}          
if($a == "Nin"){
echo'<option value="Verbrennen">Gegner verbrennen</option>'; 
echo'<option value="Einsperren">Gegner einsperren</option>';   
}
}
//konoha - Nah - akimichi/inuzuka , Fern - nara/inuzuka  Nin - mokuton/normal , Tai - tai/normal
//kumo - Nah - hyuuga/normal , Fern - kumo/normal - Verbrennen - uchiha/youton , Einsperren - youton/shouton
//kusa - Nah - inuzuka/aburame , fern - aburame/nara - Nin - normal/mokuton , tai tai/normal
//ame - Nin - yuki/shouton , Waffen - yuki/kugutsu - Nin - youton/normal , tai kaguya/normal
//iwa - Mehrere - aburame/jiton , Einer - jiton/inutuka , Körper - normal/akimichi , Händen - normal/hyuuga
//oto - Ja - Kaguya/Kumo Nein - Kumo/Shouton - Leiten - normal/mokuton , Leiten lassen - uchiha/normal
//suna - Nah - normal/hyuuga , Fern - normal/kumo - Ja - sand/jiton , Nein - sand/kugutsu
//kiri - Familie - yuki/nara , Allein - yuki/youton - Nah - normal/kaguya , Fern - normal/kugutsu
//taki - Verbunden - yuki/mokuton , Nicht verbunden - mokuton/shouton -  Familie - uchiha/inuzuka , Allein - uchiha/normal
if($dorf == "konoha"){
if($a == "Hilfe"){
echo'<option value="Nah">Nahkampf</option>'; 
echo'<option value="Fern">Fernkampf</option>';   
}          
if($a == "kämpfen"){
echo'<option value="Nin">Ninjutsu</option>'; 
echo'<option value="Tai">Taijutsu</option>';   
}
}                            
echo '</select>'; 
echo '</div>';        
echo '</td>';
echo '</tr>';  
echo '<tr>';
echo '<td align="center">';
echo '<input class="button" name="login" id="login" value="weiter" type="submit"></form>';       
echo '</td>';
echo '</tr>';  
echo '</table>';
echo '<br>';  
echo '<a href="charregister.php?dorf='.$dorf.'&quiz=1">Zurück</a>';

}
if($quiz == 1){
//konoha - normal/mokuton/akimichi/nara/inuzuka/tai
//kumo - normal/hyuuga/youton/uchiha/kumo/shouton      
//kusa - normal/mokuton/aburame/inuzuka/nara/tai
//ame - normal/kaguya/yuki/shouton/youton/kugutsu
//iwa - normal/akimichi/aburame/hyuuga/jiton/inuzuka
//oto - normal/kaguya/uchiha/shouton/mokuton/kumo
//suna - normal/sand/jiton/kugutsu/kumo/hyuuga
//kiri - normal/yuki/youton/kaguya/nara/kugutsu
//taki - normal/yuki/mokuton/shouton/uchiha/inuzuka
echo '<h2 class="shadow">Quiz Frage #1</h2>';
if($dorf == "konoha"){
echo 'Du läufst eines Tages in Konoha umher und bist in einer Seitengasse.<br>Fremde männer kommen auf dich zu und sie sehen angriffsbereit aus. Was tust du?';  
}  
if($dorf == "kumo"||$dorf == "kiri"||$dorf == "taki"){
echo 'Du triffst auf feindliche Ninjas. Wie wehrst du dich?';  
}      
if($dorf == "kusa"){
echo 'Du läufst eines Tages in Kusa umher und bist in einer Seitengasse.<br>Fremde männer kommen auf dich zu und sie sehen angriffsbereit aus. Was tust du?';  
}      
if($dorf == "ame"){
echo 'Du wirst von einem feindlichen Ninja angegriffen, was tust du?';  
}     
if($dorf == "iwa"){
echo 'kämpfst du alleine oder mit mehreren zusammen?';  
}   
if($dorf == "oto"){
echo 'Bist du deinem Anführer loyal?';  
}  
if($dorf == "suna"){
echo 'Sind deine Eltern aus einem anderen Land nach Suna gezogen?';  
}    
echo '<form method="post" action="charregister.php?dorf='.$dorf.'&quiz=2">';
echo '<table width="100%">';
echo '<tr>';
echo '<td align="center">';
echo'<center><div class="auswahl">';
echo '<select name="a" class="Auswahl" size="1">';  
if($dorf == "konoha"||$dorf == "kusa"){
echo'<option value="Hilfe">Nach Hilfe rufen</option>'; 
echo'<option value="kämpfen">kämpfen</option>';   
}       
if($dorf == "ame"){
echo'<option value="Fern">Von der Ferne angreifen</option>'; 
echo'<option value="Nah">Im Nahkampf angreifen</option>';   
}       
if($dorf == "iwa"){
echo'<option value="Allein">Alleine</option>'; 
echo'<option value="Zusamm">Zusammen</option>';   
}      
if($dorf == "oto"){
echo'<option value="Loyal">Loyal</option>'; 
echo'<option value="Nicht Loyal">Nicht Loyal</option>';   
}         
if($dorf == "suna"){
echo'<option value="Ja">Ja</option>'; 
echo'<option value="Nein">Nein</option>';   
} 
if($dorf == "kumo"||$dorf == "kiri"||$dorf == "taki"){
echo'<option value="Nin">Mit Nin/Genjutsu</option>'; 
echo'<option value="Tai">Mit Taijutsu</option>';   
}                        
echo '</select>'; 
echo '</div>';        
echo '</td>';
echo '</tr>';  
echo '<tr>';
echo '<td align="center">';
echo '<input class="button" name="login" id="login" value="weiter" type="submit"></form>';       
echo '</td>';
echo '</tr>';  
echo '</table>';
echo '<br>';  
echo '<a href="charregister.php?dorf='.$dorf.'">Zurück</a>';
}
if($quiz == ""){                                   
echo 'Du kannst dich nicht entscheiden? <a href="charregister.php?dorf='.$dorf.'&quiz=1">Quiz starten</a><br>';
echo '<div class="relativ clanwahl">';
if($dorf == "konoha"){  
$blut[0] = "normal";
$blut[1] = "mokuton";    
$blut[2] = "akimichi";
$blut[3] = "nara";  
$blut[4] = "inuzuka";
$blut[5] = "tai";    
$blut[6] = "kurama";   
$blut[7] = "yamanaka";
}
if($dorf == "kumo"){  
$blut[0] = "normal";
$blut[1] = "hyuuga";    
$blut[2] = "youton";
$blut[3] = "uchiha";  
$blut[4] = "kumo";
$blut[5] = "shouton";   
$blut[6] = "sakon";   
$blut[7] = "yamanaka";
}    
if($dorf == "kusa"){  
$blut[0] = "normal";
$blut[1] = "mokuton";    
$blut[2] = "aburame";
$blut[3] = "inuzuka";  
$blut[4] = "nara";
$blut[5] = "tai";  
$blut[6] = "kamizuru";   
$blut[7] = "kurama";
}       
if($dorf == "ame"){  
$blut[0] = "normal";
$blut[1] = "kaguya";    
$blut[2] = "yuki";
$blut[3] = "shouton";  
$blut[4] = "youton";
$blut[5] = "kugutsu";
$blut[6] = "hozuki";   
$blut[7] = "yamanaka";
}    
if($dorf == "iwa"){  
$blut[0] = "normal";
$blut[1] = "akimichi";    
$blut[2] = "aburame";
$blut[3] = "hyuuga";  
$blut[4] = "jiton";
$blut[5] = "inuzuka"; 
$blut[6] = "kamizuru";   
$blut[7] = "kurama";
}        
if($dorf == "oto"){  
$blut[0] = "normal";
$blut[1] = "kaguya";    
$blut[2] = "uchiha";
$blut[3] = "shouton";  
$blut[4] = "mokuton";
$blut[5] = "kumo";  
$blut[6] = "sakon";   
$blut[7] = "senninka";
}        
if($dorf == "suna"){  
$blut[0] = "normal";
$blut[1] = "sand";    
$blut[2] = "jiton";
$blut[3] = "kugutsu";  
$blut[4] = "kumo";
$blut[5] = "hyuuga";  
$blut[6] = "sakon";   
$blut[7] = "senninka";
}           
if($dorf == "kiri"){  
$blut[0] = "normal";
$blut[1] = "yuki";    
$blut[2] = "youton";
$blut[3] = "kaguya";  
$blut[4] = "nara";
$blut[5] = "kugutsu"; 
$blut[6] = "senninka";   
$blut[7] = "hozuki";
} 
if($dorf == "taki"){  
$blut[0] = "normal";
$blut[1] = "yuki";    
$blut[2] = "mokuton";
$blut[3] = "shouton";  
$blut[4] = "uchiha";
$blut[5] = "inuzuka";  
$blut[6] = "hozuki";   
$blut[7] = "kamizuru";
} 
echo '<table width="100%">';
echo '<tr height="200px">';
$count = 0;
while($count != 8){
if($count == 4){
echo '</tr><tr height="200px">';
}
if($blut[$count] == "mokuton"){
echo '<td align="center">';
echo '<div class="mokuton">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=mokuton" onMouseover="showtext(';
echo "'<b>Mokuton</b><br>Du kannst das Doton und das Suiton Element verbinden.<br> Dadurch kannst du Leben erschaffen.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';  
}
if($blut[$count] == "akimichi"){
echo '<td align="center">';
echo '<div class="akimichi">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=akimichi" onMouseover="showtext(';
echo "'<b>Akimichi</b><br>Du gehörst dem Akimichi-Clan an!<br>Deine Jutsus basieren auf dein Gewicht..'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>'; 
}
if($blut[$count] == "yuki"){
echo '<td align="center">';
echo '<div class="yuki">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=yuki" onMouseover="showtext(';
echo "'<b>Yuki</b><br>Du gehörst dem Yuki-Clan an!<br>Du kannst seit deiner Geburt das Suiton und Fuuton Element verbinden.'";
echo ')" onMouseout="hidetext()"></a> ';    
echo '</div>';
echo '</td>';
}
if($blut[$count] == "jiton"){
echo '<td align="center">';
echo '<div class="jiton">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=jiton" onMouseover="showtext(';
echo "'<b>Jiton</b><br>Du kannst Magnetfelder entstehen lassen und somit deinen Eisensand bewegen.'";
echo ')" onMouseout="hidetext()"></a> ';   
echo '</div>';
echo '</td>';
}
if($blut[$count] == "sand"){
echo '<td align="center">';
echo '<div class="sand">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=sand" onMouseover="showtext(';
echo "'<b>Sand</b><br>Du hast gelernt, Sand nach deinem Willen zu kontrollieren.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}   
if($blut[$count] == "shouton"){
echo '<td align="center">';
echo '<div class="shouton">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=shouton" onMouseover="showtext(';
echo "'<b>Shouton</b><br>Du kannst aus allen lebendigen Objekten Kristalle wachsen lassen.'";
echo ')" onMouseout="hidetext()"></a> '; 
echo '</div>';
echo '</td>';
}
if($blut[$count] == "kugutsu"){
echo '<td align="center">';
echo '<div class="kugutsu">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=kugutsu" onMouseover="showtext(';
echo "'<b>Kugutsu</b><br>Du hast gelernt, wie man Puppen zusammenbaut und mit ihnen kämpft.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '</td>';
}
if($blut[$count] == "inuzuka"){
echo '<td align="center">';
echo '<div class="inuzuka">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=inuzuka" onMouseover="showtext(';
echo "'<b>Inuzuka</b><br>Du gehörst dem Inuzuka-Clan an!<br>Ihr pflegt ein enges Band zu euren Hunden und Wölfen.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}
if($blut[$count] == "kaguya"){
echo '<td align="center">';
echo '<div class="kaguya">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=kaguya" onMouseover="showtext(';
echo "'<b>Kaguya</b><br>Du gehörst dem Kaguya-Clan an!<br>Du kannst deine Knochen manipulieren.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}
if($blut[$count] == "youton"){
echo '<td align="center">';
echo '<div class="youton">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=youton" onMouseover="showtext(';
echo "'<b>Youton</b><br>Du kannst das Katon und das Doton Element verbinden.<br> Dadurch kannst du Lava erzeugen.'";
echo ')" onMouseout="hidetext()"></a> '; 
echo '</div>';
echo '</td>';
}
if($blut[$count] == "normal"){
echo '<td align="center">';
echo '<div class="normal">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=normal" onMouseover="showtext(';
echo "'<b>Normal</b><br>Du bist normal. Du kannst im späteren Verlauf dich spezialisieren.'";
echo ')" onMouseout="hidetext()"></a> '; 
echo '</div>';
echo '</td>';
}
if($blut[$count] == "hyuuga"){
echo '<td align="center">';
echo '<div class="hyuuga">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=hyuuga" onMouseover="showtext(';
echo "'<b>Hyuuga</b><br>Du gehörst zum Hyuuga-Clan.<br> Du beherrschst das mächtige Byakugan.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}
if($blut[$count] == "tai"){
echo '<td align="center">';
echo '<div class="tai">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=tai" onMouseover="showtext(';
echo "'<b>Tai</b><br>Du kannst weder Ninjutsu noch Genjutsu.<br> Daher hast du dich auf Taijutsu spezialisiert.'";
echo ')" onMouseout="hidetext()"></a> '; 
echo '</div>';
echo '</td>';
}
if($blut[$count] == "uchiha"){
echo '<td align="center">';
echo '<div class="uchiha">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=uchiha" onMouseover="showtext(';
echo "'<b>Uchiha</b><br>Du gehörst zum Uchiha-Clan.<br> Du kannst das mächtige Sharingan lernen.'";
echo ')" onMouseout="hidetext()"></a> '; 
echo '</div>';
echo '</td>';
}
if($blut[$count] == "aburame"){
echo '<td align="center">';
echo '<div class="aburame">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=aburame" onMouseover="showtext(';
echo "'<b>Aburame</b><br>Du gehörst zum Aburame-Clan.<br> In dir leben Käfer die du kontrollieren kannst.'";
echo ')" onMouseout="hidetext()"></a> '; 
echo '</div>';
echo '</td>';
}         
if($blut[$count] == "nara"){
echo '<td align="center">';
echo '<div class="nara">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=nara" onMouseover="showtext(';
echo "'<b>Nara</b><br>Du gehörst zum Nara-Clan.<br> Du kannst deinen Schatten nach deinem Willen kontrollieren.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}
if($blut[$count] == "kumo"){
echo '<td align="center">';
echo '<div class="kumos">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=kumo" onMouseover="showtext(';
echo "'<b>Kumo</b><br>Du bist mit den Spinnen sehr vertraut und kannst Spinnennetze weben.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}
if($blut[$count] == "kurama"){
echo '<td align="center">';
echo '<div class="kurama">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=kurama" onMouseover="showtext(';
echo "'<b>Kurama</b><br>Du bist mit dem Umgang mit Genjutsus vertraut und kannst besondere Genjutsus wirken.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}   
if($blut[$count] == "yamanaka"){
echo '<td align="center">';
echo '<div class="yamanaka">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=yamanaka" onMouseover="showtext(';
echo "'<b>Yamanaka</b><br>Du kannst in den Körper deiner Feinde gehen und diese kontrollieren.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}   
if($blut[$count] == "sakon"){
echo '<td align="center">';
echo '<div class="sakon">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=sakon" onMouseover="showtext(';
echo "'<b>Sakon</b><br>Du besitzt einen Zwilling der mit dir kämpft.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}      
if($blut[$count] == "hozuki"){
echo '<td align="center">';
echo '<div class="hozuki">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=hozuki" onMouseover="showtext(';
echo "'<b>Hozuki</b><br>Du kannst mächtige Suiton Jutsus ausführen.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}    
if($blut[$count] == "kamizuru"){
echo '<td align="center">';
echo '<div class="kamizuru">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=kamizuru" onMouseover="showtext(';
echo "'<b>Kamizuru</b><br>Du kannst Jutsus mit Bienen zusammen anwenden.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}    
if($blut[$count] == "senninka"){
echo '<td align="center">';
echo '<div class="senninkac">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan=senninka" onMouseover="showtext(';
echo "'<b>Senninka</b><br>Du kannst Naturchakra beeinflussen und kontrollieren.'";
echo ')" onMouseout="hidetext()"></a> ';  
echo '</div>';
echo '</td>';
}
$count++;
}
echo '</tr></table>'; 
echo '</div>';
echo '<div id="textdiv" style="margin-top:5px;" class="shadow">'.$error.'</div>';  
echo '<a href="charregister.php">Zurück</a>';   
}
}
}
else{
if($gender == ""||$gender !="boy"&&$gender !="girl"){
echo '<div class="relativ dorfwahl">';
echo '<div class="girl">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan='.$clan.'&gender=girl" onMouseover="showtext(';
echo "'<b>Kunoichi</b><br>Du bist eine Kunoichi.<br>Du bist ein weiblicher Ninja.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '<div class="boy">';
echo '<a href="charregister.php?dorf='.$dorf.'&clan='.$clan.'&gender=boy" onMouseover="showtext(';
echo "'<b>Shinobi</b><br>Du bist ein Shinobi.<br>Du bist ein männlicher Ninja.'";
echo ')" onMouseout="hidetext()"></a> ';
echo '</div>';
echo '</div>';
echo '<div id="textdiv" class="shadow">'.$error.'</div>';
echo '<a href="charregister.php?dorf='.$dorf.'">Zurück</a>';
}
else{
if($werte == ""||$werte != "90"||$kraft > "20"||$kraft < "10"||$wid > "20"||$wid < "10"||$int > "20"||$int < "10"||$gnk > "20"||$gnk < "10"||$tmp > "20"||$tmp < "10"||$chrk > "20"||$chrk < "10"||$clan == "tai"&&$int != "10"||$clan == "tai"&&$chrk != "10"){               
echo '<p class="shadow">Du hast noch <b id="zahl">30</b> Punkte zu verteilen.<br></p>';
echo '<div class="relativ statswahl">';              
echo '<form method="post" action="charregister.php?dorf='.$dorf.'&clan='.$clan.'&gender='.$gender.'">';
echo '<div class="werte" style="left:100px; top:0px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Kraft</b><br>Kraft beschreibt die Stärke der Taijutsus.'";
echo ')" onMouseout="hidetext()">Kraft:</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="kraft" name="kraft" value="10" size="2" maxlength="2" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';
echo '<div class="werte" style="left:360px; top:0px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Widerstand</b><br>Widerstand beschreibt die mentale sowie die körperliche Stärke und gibt an, wie viel ich körperlich bzw mental aushalte.'";
echo ')" onMouseout="hidetext()">Widerstand:</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="wid" name="wid" value="10" size="2" maxlength="2" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>'; 
echo '<div class="werte" style="left:100px; top:40px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Intelligenz</b><br>Intelligenz beschreibt die Stärke der Genjutsus.'";
echo ')" onMouseout="hidetext()">Intelligenz:</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="int" name="int" value="10" size="2" maxlength="2" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';  
echo '<div class="werte" style="left:360px; top:40px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Chakrakontrolle</b><br>Chakrakontrolle beschreibt die Stärke der Ninjutsus.'";
echo ')" onMouseout="hidetext()">Chakrakontrolle:</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="chrk" name="chrk" value="10" size="2" maxlength="2" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';  
echo '<div class="werte" style="left:100px; top:80px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Tempo</b><br>Tempo beschreibt deine Schnelligkeit. Umso mehr Tempo du hast , umso größer ist die Chance , dass der Angriff des Gegners nicht trifft.'";
echo ')" onMouseout="hidetext()">Tempo:</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="tmp" name="tmp" value="10" size="2" maxlength="2" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';  
echo '<div class="werte" style="left:360px; top:80px;">
<table class="space">
<tr>
<td width="120px" align=right><b class="shadowh" onMouseover="showtext(';
echo "'<b>Genauigkeit</b><br>Genauigkeit beschreibt die Konzentration auf den Gegner und gibt an, wie genau man zielt.'";
echo ')" onMouseout="hidetext()">Genauigkeit:</b></td>
<td width="30px">
<div class="eingabe5">
<input class="eingabe6" id="gnk" name="gnk" value="10" size="2" maxlength="2" type="text">
</div>
</td>
</tr>
</table>';
echo '</div>';  
echo '<div class="werte" style="left: 320px; top:140px;">
<input type="submit" value="weiter" id="login" name="login" class="button2"/>    
</form>';
echo '</div>';                                                  
echo '<div class="werte" style="left:270px; top:0px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown('."'incr','kraft'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown('."'decr','kraft'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                               
echo '<div class="werte" style="left:530px; top:00px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown('."'incr','wid'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown('."'decr','wid'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                     
echo '<div class="werte" style="left:270px; top:40px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown('."'incr','int'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown('."'decr','int'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                          
echo '<div class="werte" style="left:530px; top:40px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown('."'incr','chrk'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown('."'decr','chrk'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                       
echo '<div class="werte" style="left:270px; top:80px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown('."'incr','tmp'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown('."'decr','tmp'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>';                                          
echo '<div class="werte" style="left:530px; top:80px;">
<table class="space">
<tr>
<td width="30px">
<input type="submit" value="+" id="login" name="login" onclick="updown('."'incr','gnk'".');" class="button3"/>
</td>
<td width="30px">
<input type="submit" value="-" id="login" name="login" onclick="updown('."'decr','gnk'".');" class="button3"/>
</td> 
</tr>
</table>';
echo '</div>'; 
echo '</div></p>';
echo '<div id="textdiv" class="shadow">'.$error.'</div>
<br>';
echo '<a href="charregister.php?dorf='.$dorf.'&clan='.$clan.'">Zurück</a>';
}
else{
echo '<center><table>';
echo '<tr>';
echo '<td align=center>';
echo '<img src="bilder/reg/'.$dorf.'.png"></img>';
echo '</td>';               
echo '<td align=center>';
$clan2 = $clan;
if($clan == "kumo"){
$clan2 = "kumos";
}
echo '<img src="bilder/reg/'.$clan2.'.png" width="100px" height="100px"></img>';   
echo '</td>';   
echo '<td align=center>';
echo '<img src="bilder/reg/'.$gender.'.png"></img>';  
echo '</td>'; 
echo '<td class="shadow" align=center>';
echo '<table width=100%>';             
echo '<tr>';
echo '<td>';
echo '<b>Kraft:</b>'; 
echo '</td>';
echo '<td>';
echo $kraft; 
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<b>Widerstand:</b>'; 
echo '</td>';
echo '<td>';
echo $wid; 
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<b>Intelligenz:</b>'; 
echo '</td>';
echo '<td>';
echo $int; 
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<b>Chakrakontrolle:</b>'; 
echo '</td>';
echo '<td>';
echo $chrk; 
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<b>Tempo:</b>'; 
echo '</td>';
echo '<td>';
echo $tmp; 
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<b>Genauigkeit:</b>'; 
echo '</td>';
echo '<td>';
echo $gnk; 
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';
echo '</table></center>';
echo '<br>';            
$werte2 = $kraft.';'.$wid.';'.$int.';'.$chrk.';'.$tmp.';'.$gnk;
echo '<form method="post" action="charregister.php?dorf='.$dorf.'&clan='.$clan.'&gender='.$gender.'&werte='.$werte2.'">
<table class="space" width="100%" height="300px">         
<tr>
<td width=300px align=right>Charaktername:</td>
<td>
<div class="eingabe1">
<input class="eingabe2" name="chara" value="Charaktername" onfocus="this.value='."''".'" size="15" maxlength="20" type="text">
</div>    
</td>
</tr>
<tr>
<td width=300px align=right><a href="info.php?page=regeln" target="_blank">Regeln</a></td>
<td align="left"">
<input type="checkbox" name="zustimmen" value="Ja">Ich akzeptiere die Regeln<br>
</td>
</tr> 
<tr>
<td width=600px align="center" colspan="2">
<center>'.recaptcha_get_html($pubkey, $verify->error).'</center> 
</td>  
</tr>
<tr>
<td width=600px align="center" colspan="3">
<input class="button" name="login" id="login" value="registrieren" type="submit">
</form></td>
</tr>
</table>';  
echo '<div id="textdiv2" class="shadow">'.$error.'</div>';
echo '<br>';
echo '<a href="charregister.php?dorf='.$dorf.'&clan='.$clan.'&gender='.$gender.'">Zurück</a>';
}
}
}
}
}
else{
echo '<div id="textdiv" class="shadow">'.$error.'</div>';                          
echo '<a href="index.php">Zurück</a>'; 
}
}
elseif($reg != ""){
echo '<br><div id="textdiv2" class="shadow">'.$reg.'</div>';
echo '<a href="index.php">Zurück</a>';
} 
?>
<br>
<?php include 'inc/design2.php'; ?>