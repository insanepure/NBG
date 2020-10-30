<?php
include 'inc/incoben.php';       
$page = $_GET['page'];
$suche = htmlspecialchars($_GET['suche']); 
if($suche == "Wen suchst du?"){
$suche = "";
}
if(logged_in()){
include 'inc/design1.php';
}
else{
include 'inc/design3.php';
}
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}                                     
$seite = $_GET['seite'];
if($seite <= 1){
$seite = 1;
}
if($page == 'org'){
echo '<br><h3>Org/Teamliste</h3><br>';
}
elseif($page == 'sn'){
echo '<br><h3>Wertungsliste</h3><br>';
}
else{
echo '<br><h3>Userliste</h3><br>';
}           
echo '<a href="list.php">Userliste</a>';
echo '<br>';                      
echo '<a href="list.php?page=org">Org/Teamliste</a>';    
echo '<br>';                               
echo '<a href="list.php?page=sn">Wertungsliste</a>';    
echo '<br>';                                           
echo '<br>';
if($page == "org"){
echo '<form method="GET" action="list.php">';   
echo '<input type="hidden" name="page" value="org">';
}
elseif($page == 'sn'){
echo '<form method="GET" action="list.php">';
echo '<input type="hidden" name="page" value="sn">';
}
else{          
echo '<form method="GET" action="list.php">';
}
echo '<table width="100%" class="shadow">';
echo '<tr>';
echo '<td align="center">';
echo '<div class="eingabe1">';                                                                       
if($suche != ""){
echo '<input class="eingabe2" name="suche" value="'.$suche.'" size="15" maxlength="80" type="text">';
}
else{   
echo '<input class="eingabe2" name="suche" value="Wen suchst du?" size="15" maxlength="80" type="text">';
}
echo '</div>';
echo '</td>';
echo '</tr>';
if($page == ''){
$rank = $_GET['rank'];              
$clan = $_GET['clan'];
$dorf = $_GET['dorf'];
echo '<tr>';
echo '<td align="center">';
echo '<div class="auswahl">';
echo '<select name="clan" class="Auswahl" size="1">';
echo '<option value=""';
if($clan == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Alle'; 
echo '</option>'; 
echo '<option value="normal"';
if($clan == "normal"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Normal'; 
echo '</option>';
echo '<option value="kumo"';
if($clan == "kumo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kumo'; 
echo '</option>'; 
echo '<option value="uchiha"';
if($clan == "uchiha"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Uchiha'; 
echo '</option>'; 
echo '<option value="hyuuga"';
if($clan == "hyuuga"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hyuuga'; 
echo '</option>';  
echo '<option value="aburame"';
if($clan == "aburame"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Aburame'; 
echo '</option>'; 
echo '<option value="akimichi"';
if($clan == "akimichi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Akimichi'; 
echo '</option>'; 
echo '<option value="inuzuka"';
if($clan == "inuzuka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Inuzuka'; 
echo '</option>';
echo '<option value="kaguya"';
if($clan == "kaguya"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kaguya'; 
echo '</option>'; 
echo '<option value="kugutsu"';
if($clan == "kugutsu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kugutsu'; 
echo '</option>'; 
echo '<option value="mokuton"';
if($clan == "mokuton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Mokuton'; 
echo '</option>'; 
echo '<option value="yuki"';
if($clan == "yuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yuki'; 
echo '</option>'; 
echo '<option value="sand"';
if($clan == "sand"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sand'; 
echo '</option>'; 
echo '<option value="tai"';
if($clan == "tai"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Tai'; 
echo '</option>'; 
echo '<option value="youton"';
if($clan == "youton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Youton'; 
echo '</option>';
echo '<option value="nara"';
if($clan == "nara"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nara'; 
echo '</option>';
echo '<option value="shouton"';
if($clan == "shouton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Shouton'; 
echo '</option>';   
echo '<option value="jiton"';
if($clan == "jiton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiton'; 
echo '</option>'; 
echo '<option value="iryonin"';
if($clan == "iryonin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Iryonin'; 
echo '</option>';  
echo '<option value="sumi"';
if($clan == "sumi"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sumi'; 
echo '</option>'; 
echo '<option value="kami"';
if($clan == "kami"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kami'; 
echo '</option>';
echo '<option value="schlange"';
if($clan == "schlange"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Schlange'; 
echo '</option>'; 
echo '<option value="frosch"';
if($clan == "frosch"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Frosch'; 
echo '</option>';  
echo '<option value="puroresu"';
if($clan == "puroresu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Puroresu'; 
echo '</option>';  
echo '<option value="buki"';
if($clan == "buki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Buki'; 
echo '</option>'; 
echo '<option value="jiongu"';
if($clan == "jiongu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jiongu'; 
echo '</option>';   
echo '<option value="kibaku nendo"';
if($clan == "kibaku nendo"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kibaku Nendo'; 
echo '</option>';     
echo '<option value="kengou"';
if($clan == "kengou"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kengou'; 
echo '</option>';
echo '<option value="sakon"';
if($clan == "sakon"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Sakon'; 
echo '</option>'; 
echo '<option value="senninka"';
if($clan == "senninka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Senninka'; 
echo '</option>';
echo '<option value="hozuki"';
if($clan == "hozuki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Hozuki'; 
echo '</option>';   
echo '<option value="kamizuru"';
if($clan == "kamizuru"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kamizuru'; 
echo '</option>';  
echo '<option value="kurama"';
if($clan == "kurama"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kurama'; 
echo '</option>'; 
echo '<option value="yamanaka"';
if($clan == "yamanaka"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Yamanaka'; 
echo '</option>';  
echo '<option value="ishoku sharingan"';
if($clan == "ishoku sharingan"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Ishoku Sharingan'; 
echo '</option>';      
echo '<option value="utakata"';
if($clan == "utakata"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Utakata'; 
echo '</option>';  
echo '<option value="jinchuuriki modoki"';
if($clan == "jinchuuriki modoki"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jinchuuriki Modoki'; 
echo '</option>';  
echo '<option value="jashin"';
if($clan == "jashin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jashin'; 
echo '</option>';   
echo '<option value="roku pasu"';
if($clan == "roku pasu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Roku Pasu'; 
echo '</option>'; 
echo '<option value="jinton"';
if($clan == "jinton"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jinton'; 
echo '</option>'; 
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center">';

$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    id,
    name,
    was
FROM
    orte
      ORDER BY 
    id DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}      
echo'<div class="auswahl">';
echo '<select name="dorf" class="Auswahl" size="1">';
echo'<option value="';
echo '';
if($dorf == ""){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Alle'; 
echo '</option>';     
while ($row = $result->fetch_assoc() ) { 
if($row['was'] == "dorf"&&$row['name'] != "versteck"){ 
echo'<option value="';
echo $row['id'];
if($row['id'] == $dorf){
echo '" selected>';            
}
else{
echo '">';
}
echo ucwords($row['name']); 
echo '</option>';
}
}                 
$result->close(); $db->close();  
echo'<option value="';
echo 'kein';
if($dorf == "kein"){
echo '" selected>';            
}
else{
echo '">';
}
echo 'Kein'; 
echo '</option>';
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center">';
echo'<div class="auswahl">';
echo '<select name="rank" class="Auswahl" size="1">'; 
echo '<option value=""';
if($rank == ""){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Alle'; 
echo '</option>';
echo '<option value="student"';
if($rank == "student"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Student'; 
echo '</option>'; 
echo '<option value="genin"';
if($rank == "genin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Genin'; 
echo '</option>';  
echo '<option value="chuunin"';
if($rank == "chuunin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Chuunin'; 
echo '</option>'; 
echo '<option value="jounin"';
if($rank == "jounin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Jounin'; 
echo '</option>';  
echo '<option value="anbu"';
if($rank == "anbu"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Anbu'; 
echo '</option>'; 
echo '<option value="kage"';
if($rank == "kage"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Kage'; 
echo '</option>';
echo '<option value="nuke-nin"';
if($rank == "nuke-nin"){
echo ' selected>'; 
}
else{     
echo '>'; 
}           
echo 'Nuke-nin'; 
echo '</option>';  
echo '</select>'; 
echo '</div>';
echo '</td>';
echo '</tr>';     
}
echo '</table>';
echo '<input class="button" value="suchen" type="submit"></form><br>';
if($page =="org"){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
punkte
FROM
org
ORDER BY
punkte DESC,
id DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';   
echo '<td class="tdbg tdborder">';
echo 'ID';
echo '</td>'; 
echo '<td class="tdbg tdborder">';
echo 'Name';
echo '</td>';    
echo '<td class="tdbg tdborder">';
echo 'Mitglieder';
echo '</td>'; 
echo '<td class="tdbg tdborder">';
echo 'Punkte';
echo '</td>';   
echo '</tr>';
$platz = 0;
$ps = 30;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
//Seite 1 , 1-30
//Seite 2 , 31-60
//Seite 3 , 61-90
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$platz++;                                                             
if($suche == ""||$suche != ""&&strpos(strtolower($row['name']), strtolower($suche)) !== false){
if($suche == ""&&$platz >= $von&&$platz <= $bis||$suche != ""){
echo '<tr>';
echo '<td>';
echo $platz;
echo '</td>';
echo '<td>';
echo '<a href="org.php?page=see&org='.$row['id'].'">'.$row['name'].'</a>';
echo '</td>';      
echo '<td>';                
$mitglieder = getanzahl($row['id'],"charaktere","org","1");
echo $mitglieder;
echo '</td>'; 
echo '<td>';
echo $row['punkte'];
echo '</td>';        
echo '</tr>';
}
}
}
$result->close(); $db->close(); 
echo '</table>';
}
if($page != 'org'){
if($page == ''){
$order = 'ORDER BY platz ASC';
}
elseif($page == 'sn'){
$order = 'ORDER BY quotient DESC, siege DESC';
}
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
level,
session,
dorf,
rank,
exp,
clan,
mmissi,
org,
quotient,
siege,
niederlagen
FROM
charaktere
'.$order;
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">';
echo 'Platz';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Name';
echo '</td>';    
if($page == ''){
echo '<td class="tdbg tdborder">';
echo 'Bluterbe';
echo '</td>';  
echo '<td class="tdbg tdborder">';
echo 'Dorf';
echo '</td>';  
echo '<td class="tdbg tdborder">';
echo 'Rang';
echo '</td>';   
echo '<td class="tdbg tdborder">';
echo 'Org/Team';
echo '</td>';
echo '<td class="tdbg tdborder">';  
echo 'Level';     
echo '</td>'; 
}
elseif($page == 'sn'){
echo '<td class="tdbg tdborder">';
echo 'Siege';
echo '</td>';  
echo '<td class="tdbg tdborder">';
echo 'Niederlagen';
echo '</td>';  
echo '<td class="tdbg tdborder">';
echo 'Quotient';
echo '</td>';   
}
echo '</td>';  
echo '</tr>';
$platz = 0;
$ps = 30;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
//Seite 1 , 1-30
//Seite 2 , 31-60
//Seite 3 , 61-90
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($page == ''){
if($clan == ""||$row['clan'] == $clan){                                 
if($dorf == ""||$row['dorf'] == $dorf){
if($rank == ""||$row['rank'] == $rank){
$platz++;
if($suche == ""||$suche != ""&&strpos(strtolower($row['name']), strtolower($suche)) !== false){
if($suche == ""&&$platz >= $von&&$platz <= $bis||$suche != ""){
echo '<tr>';
echo '<td>';
echo $platz;
echo '</td>';
echo '<td>';
echo '<a href="user.php?id='.$row['id'].'">'.$row['name'].'</a>';
echo '</td>';      
echo '<td>';
echo ucwords($row['clan']);
echo '</td>';         
if($row['dorf'] != 'kein'){    
$tdorf = getwert($row['dorf'],"orte","name","id");    
echo '<td><a href="reisen.php?ziel='.$row['dorf'].'">'.ucwords($tdorf).'</a></td>';    
}
else{
$tdorf = $row['dorf'];   
echo '<td>'.ucwords($tdorf).'</td>';    
}   
echo '<td>';   
if($row['rank'] == 'kage'){  
$tdorf = getwert($row['dorf'],"orte","name","id"); 
if($tdorf == 'konoha'){
$srank = 'Hokage';
}
elseif($tdorf == 'kiri'){
$srank = 'Mizukage';
}  
elseif($tdorf == 'suna'){
$srank = 'Kazekage';
}                
elseif($tdorf == 'iwa'){
$srank = 'Tsuchikage';
}                  
elseif($tdorf == 'kumo'){
$srank = 'Raikage';
}               
elseif($tdorf == 'oto'){
$srank = 'Nekage';
}              
elseif($tdorf == 'ame'){
$srank = 'Ukage';
}             
elseif($tdorf == 'kusa'){
$srank = 'Sokage';
}              
elseif($tdorf == 'taki'){
$srank = 'Takikage';
}                
else{
$srank = 'Kage';
}
echo $srank; 
}
elseif($row['rank'] == 'nuke-nin'){
if($row['level'] >= 60){
$srank = 'S-Rang Nuke-Nin';
}
if($row['level'] >= 50&&$row['level'] < 60){
$srank = 'A-Rang Nuke-Nin';
}
if($row['level'] >= 30&&$row['level'] < 50){
$srank = 'B-Rang Nuke-Nin';
}
if($row['level'] >= 20&&$row['level'] < 30){
$srank = 'C-Rang Nuke-Nin';
}
if($row['level'] < 20){
$srank = 'D-Rang Nuke-Nin';
}        
echo $srank; 
}
else{   
echo ucwords($row['rank']);      
} 
echo '</td>';  
echo '<td>';
if($row['org'] != "0"){
$oname = getwert($row['org'],"org","name","id"); 
echo '<a href="org.php?page=see&org='.$row['org'].'">'.$oname.'</td>';
}
echo '</td>';
echo '<td>';
echo $row['level'];
echo '</td>';    
echo '</tr>';
}
}
}
}
}
}
elseif($page == 'sn'){    
$platz++;        
if($suche == ""||$suche != ""&&strpos(strtolower($row['name']), strtolower($suche)) !== false){
if($suche == ""&&$platz >= $von&&$platz <= $bis||$suche != ""){
echo '<tr>';
echo '<td>';
echo $platz;
echo '</td>';
echo '<td>';
echo '<a href="user.php?id='.$row['id'].'">'.$row['name'].'</a>';
echo '</td>';      
echo '<td>';
echo $row['siege'];
echo '</td>'; 
echo '<td>';
echo $row['niederlagen'];
echo '</td>';  
echo '<td>';
echo $row['quotient'];
echo '</td>';   
echo '</tr>';
}
}
}
}
$result->close(); $db->close(); 
echo '</table>';
}             
if($suche == ""){
$count = 1;
$anzahl = $platz;
if($platz > $ps){
while($platz > 0){
$platz = $platz-$ps;
if($page == "org"){
echo '<a href="list.php?page=org&seite='.$count.'">'.$count.'</a> ';
}
elseif($page == 'sn'){
echo '<a href="list.php?page=sn&seite='.$count.'">'.$count.'</a> ';
}
else{
echo '<a href="list.php?seite='.$count;
if($clan)
  echo '&clan='.$clan;    
if($dorf)
  echo '&dorf='.$dorf;  
if($rank)
  echo '&rank='.$rank;
echo '">'.$count.'</a> ';
}
$count++;  
}    
echo '<br>Anzahl: '.$anzahl;
}
}

if(!logged_in()){
echo '<br><a href="index.php">Zurück</a>';
}
include 'inc/design2.php'; ?>