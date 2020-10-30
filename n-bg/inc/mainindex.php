<?php
if(!logged_in())
{
  ?>
<br/>
<a href="login.php">Login</a> | <a href="register.php">Registrierung</a><br/>
<br/>
<?php
}
include 'inc/bbcode.php'; 
if($page == ""){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
title,
autor,
date,
text
FROM
news
ORDER BY
id
DESC
LIMIT
2';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder" colspan="1" rowspan="1" width=120px height=100px>';
echo '<div class="newsbild">';
$autorkbild = getwert($row['autor'],"charaktere","kbild","id");   
if($autorkbild == ""){
$autorkbild = "bilder/nokpic.png";
}
echo '<img src="'.$autorkbild.'" width=100px height=100px></img>';
echo '</div>';
echo '</td>';
echo '<td class="tdbg tdborder newsleft">';
echo '<b>Titel:</b> '.$row['title'];
echo '<br>';
$autor = getwert($row['autor'],"charaktere","name","id");
echo '<b>Autor:</b> <a href="user.php?id='.$row['autor'].'">'.$autor.'</a>';
echo '<br>';
$zeit2 = $row['date'];
$jahr = substr($zeit2 ,0 , 4);
$monat = substr($zeit2 ,5 ,2);
$tag = substr($zeit2 ,8 ,2);
$stunde = substr($zeit2 ,11 ,2);
$minute = substr($zeit2 ,14 ,2);
$uhrzeit = "$tag.$monat.$jahr um $stunde:$minute Uhr";
echo "<b>Datum:</b> $uhrzeit</b>";
echo '</tr>';
echo '<tr>';
echo '<td class="tdborder" colspan="2" rowspan="1">';
echo $bbcode->parse ($row['text']);
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td colspan="2" rowspan="1" class="tdborder tdbg">';
echo '<a href="index.php?page=kommentare&nid='.$row['id'].'">';
$komanzahl = getanzahl($row['id'],"kommentare","news","1");
echo $komanzahl;
if($komanzahl == 1){
echo ' Kommentar';
}
else{
echo ' Kommentare';
}
echo '</a></td>';
echo '</tr>';
echo '</table>';
echo '<br>';
}
$result->close(); $db->close(); 
}
else{        
if(is_numeric($newsid)){
if($existiert == 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
news,
autor,
text,
date
FROM
kommentare
WHERE news = '.real_escape_string($newsid).'
ORDER BY
date
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table2" width="100%" cellspacing="0">';
$count = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false    
if($row['news'] == $newsid){    
echo '<tr >';        
if($count == 0)
{
echo '<td width="150px">';
}
else
{
echo '<td width="150px" class="tdborder">';
}
$autor = getwert($row['autor'],"charaktere","name","id");
if($autor != ""){
echo '<a href="user.php?id='.$row['autor'].'">'.$autor.'</a>: ';
}
else{
echo 'NoUser: ';
}
echo '</td>';
if($count == 0)
{
echo '<td align="left">';
}
else
{
echo '<td align="left" class="tdborder">';
}
echo $row['text'];
echo '</td>';
if($count == 0)
{
echo '<td width="200px">';
}
else
{
echo '<td width="200px" class="tdborder">';
}
$zeit2 = $row['date'];
$jahr = substr($zeit2 ,0 , 4);
$monat = substr($zeit2 ,5 ,2);
$tag = substr($zeit2 ,8 ,2);
$stunde = substr($zeit2 ,11 ,2);
$minute = substr($zeit2 ,14 ,2);
$uhrzeit = "$tag.$monat.$jahr um $stunde:$minute Uhr";
echo $uhrzeit;
echo '</td>';
echo '</tr>';   
if($count == 0){
$count = 1;
}    
}
}
$result->close(); $db->close(); 
echo '</table>';
echo '<br>';
echo '<table width="100%">';
echo '<tr>';
echo '<form method="post" action="index.php?page=kommentare&nid='.$newsid.'&aktion=kommentieren">
<td align=center>
<div class="textfield2">
<textarea class="textfield" name="ktext" maxlength="300000">
</textarea>
</div>
</td>';
echo '</tr>';
echo '<tr>';
echo '<td align=center>
<input class="button" name="login" id="login" value="Kommentieren" type="submit">
</form>';
echo '</tr>';
echo '</table>';
echo '<br>';
}
}
echo '<a href="index.php">Zurück</a>';
}
?>