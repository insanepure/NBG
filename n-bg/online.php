<?php
include 'inc/incoben.php';
if(logged_in()){
include 'inc/design1.php';
}
else{
include 'inc/design3.php';
}
echo '<br><h3>Onlineliste</h3><br>';
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
platz
FROM
charaktere
WHERE session != "NULL"
ORDER by platz';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder">';
echo 'Name';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Level';
echo '</td>'; 
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
echo 'Platz';
echo '</td>';
echo '</tr>';
$platz = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr>';
echo '<td>';
echo '<a href="user.php?id='.$row['id'].'">'.$row['name'].'</a>';
echo '</td>';
echo '<td>';
echo $row['level'];
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
echo $row['platz'];
echo '</td>';  
echo '</tr>';
}
$result->close(); $db->close(); 
echo '</table>';
if(!logged_in()){
echo '<br><a href="index.php">Zurück</a>';
}
include 'inc/design2.php'; ?>