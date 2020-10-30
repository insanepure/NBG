<?php
include 'inc/incoben.php';
if(logged_in()){
include 'inc/design1.php';
}
else{
include 'inc/design3.php';
}
echo '<br><h3>Statistiken</h3><br>';
echo '<table class="table" width="100%">';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Clans</h3></td></tr>';
echo '<tr>';
$td = 0;
$dorf['kein'] = 0;
$db = @new mysqli($host, $user, $pw, $datenbank); 
if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
    clan,
    level,
    dorf,
    rank,
    name,
    vertrag
FROM
    charaktere
      ORDER BY 
    clan DESC';
$result = $db->query($sql);
if (!$result) {
    die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}                        
$cclan = "";  
$rang['genin'] = 0;
$rang['chuunin'] = 0;   
$rang['jounin'] = 0;
$rang['anbu'] = 0; 
$rang['kage'] = 0;
while ($row = $result->fetch_assoc() ) {  
if($row['clan'] != 'admin'){
$uclan = $row['clan'];      
$clan[$uclan] = $clan[$uclan]+1;    
if($cclan != $uclan){  
if($cclan != ""){
$td++;
echo '<td>Es gibt '.$clan[$cclan].' '.ucwords($cclan).' Mitglieder.</td>';
if($td == 2){
echo '</tr><tr>';
$td = 0;
}
}
$cclan = $uclan;
}
$urang = $row['rank'];    
$rang[$urang] = $rang[$urang]+1;
$udorf = $row['dorf'];
$dorf[$udorf] = $dorf[$udorf]+1;
}
}                 
$result->close(); $db->close();  
$td++;
echo '<td>Es gibt '.$clan[$cclan].' '.ucwords($cclan).' Mitglieder.</td>';
if($td == 2){
echo '</tr><tr>';
$td = 0;
}
echo '</tr><tr><td class="tdbg tdborder" colspan="2"><h3>Dörfer</h3></td></tr>';
echo '<tr>';
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
while ($row = $result->fetch_assoc() ) {  
$did = $row['id'];
if($row['was'] == 'dorf'&&$dorf[$did] != 0){   
$td++;
echo '<td>Es gibt '.$dorf[$did].' '.ucwords($row['name']).'-Ninjas.</td>';
if($td == 2){
echo '</tr><tr>';
$td = 0;
}
}
}                 
$result->close(); $db->close();    
echo '<td>Es gibt '.$dorf['kein'].' Nuke-Ninjas.</td>';
echo '</tr><tr><td class="tdbg tdborder" colspan="2"><h3>Ränge</h3></td></tr>';
echo '<td>Es gibt '.$rang['student'].' Studenten.</td>';  
echo '<td>Es gibt '.$rang['genin'].' Genin.</td>';
echo '</tr><tr>';
echo '<td>Es gibt '.$rang['chuunin'].' Chuunin.</td>';  
echo '<td>Es gibt '.$rang['jounin'].' Jounin.</td>';
echo '</tr><tr>';
echo '<td>Es gibt '.$rang['anbu'].' Anbu.</td>';  
echo '<td>Es gibt '.$rang['kage'].' Kage.</td>';
echo '</tr><tr>';
echo '<tr>';
echo '</tr>';
echo '</table>';
if(!logged_in()){
echo '<br><a href="index.php">Zurück</a>';
}
include 'inc/design2.php'; ?>