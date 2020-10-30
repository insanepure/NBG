<?php
if(logged_in())
{
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
hp,
mhp,
chakra,
mchakra,
level,
rank,
dorf,
Session,
kbild,
ryo,
clan,
ort,
mission,
mwo,
reise,
exp,
mexp,
mmissi,
admin,
platz
FROM
charaktere
WHERE session = "'.session_id().'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$platz = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<table class="omtable shadow">';
echo '<tr >';               
echo '<td width="5px"></td>';
echo '<td width="55px">';
echo '<div class="hoch">';
echo '<a href="user.php?id='.$row['id'].'">';
if($row['kbild'] != ""){
echo '<img src="'.$row['kbild'].'" width="50px" height="50px" border="0"></img>';
}
else{
echo '<img src="bilder/design/nokpic.png" width="50px" height="50px" border="0"></img>';
}
echo '</a>';
echo '</div>';
echo '</td>';
echo '<td width="110px">';  
echo '<div class="hoch">';
echo '<div class="bar">';
echo '<div class="hp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'px">';
echo '<div class="barcenter">';
echo $row['hp'].'/'.$row['mhp'];
echo '</div>';
echo '</div>';
echo '</div>';
echo '<div class="bar">';
echo '<div class="chakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;  
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'px">';
echo '<div class="barcenter">';
echo $row['chakra'].'/'.$row['mchakra'];
echo '</div>';
echo '</div>';
echo '</div>';
echo '<div class="bar">';
echo '<div class="exp" style="width:';
if($row['level'] != 70){
$prozent = $row['exp']/$row['mexp'];
$prozent = $prozent*100;  
if($prozent >= 100){
$prozent = 100;
}
}
else{
$prozent = 100;
}
echo $prozent.'px">';
echo '<div class="barcenter">';   
if($row['level'] != 70){
echo $row['exp'].'/'.$row['mexp'];   
}
else{
echo 'Maximal';
}
echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</td>';
echo '<td width="100px">';    
echo '<div class="hoch">';
echo 'Level: '.$row['level'];
echo '<br>';
echo 'Platz: '.$row['platz'];     
echo '</td>';
echo '<td width="140px">';    
echo '<div class="hoch">';   
echo 'Name: <a href="user.php?id='.$row['id'].'">'.$row['name'].'</a>';     
echo '<br>';   
echo 'Ryo: '.$row['ryo'];    
echo '</div>';
echo '</td>';
echo '<td width="170px">';   
echo '<div class="hoch">';
echo 'Bluterbe: '.ucwords($row['clan']);    
echo '<br>';
if($row['rank'] == 'kage'){  
$tdorf = getwert($row['dorf'],"orte","name","id"); 
if($tdorf == 'konoha'){
$rank = 'Hokage';
}
elseif($tdorf == 'kiri'){
$rank = 'Mizukage';
}  
elseif($tdorf == 'suna'){
$rank = 'Kazekage';
}                
elseif($tdorf == 'iwa'){
$rank = 'Tsuchikage';
}                  
elseif($tdorf == 'kumo'){
$rank = 'Raikage';
}               
elseif($tdorf == 'oto'){
$rank = 'Nekage';
}              
elseif($tdorf == 'ame'){
$rank = 'Ukage';
}             
elseif($tdorf == 'kusa'){
$rank = 'Sokage';
}              
elseif($tdorf == 'taki'){
$rank = 'Takikage';
}                
else{
$rank = 'Kage';
}
echo 'Rang: '.$rank;  
}
elseif($row['rank'] == 'nuke-nin'){      
if($row['level'] >= 60){
$rank = 'S-Rang Nuke-Nin';
}
if($row['level'] >= 50&&$row['level'] < 60){
$rank = 'A-Rang Nuke-Nin';
}
if($row['level'] >= 30&&$row['level'] < 50){
$rank = 'B-Rang Nuke-Nin';
}
if($row['level'] >= 20&&$row['level'] < 30){
$rank = 'C-Rang Nuke-Nin';
}
if($row['level'] < 20){
$rank = 'D-Rang Nuke-Nin';
}      
echo 'Rang: '.$rank;  
} 
else{
echo 'Rang: '.ucwords($row['rank']);  
}
echo '</div>';
echo '</td>';
echo '<td width="200px">';    
echo '<div class="hoch">';    
if($row['dorf'] != 'kein'){    
$tdorf = getwert($row['dorf'],"orte","name","id"); 
echo 'Dorf: <a href="reisen.php?ziel='.$row['dorf'].'">'.ucwords($tdorf); 
}
else{
echo 'Dorf: Kein';
}
echo '</a>'; 
echo '<br>';
echo 'Ort: ';             
  
if($row['reise'] == ""){  
$tort = getwert($row['ort'],"orte","name","id");  
echo '<a href="reisen.php?ziel='.$row['ort'].'">';    
echo ucwords($tort);
echo '</a>';
}
else{              
$array = explode(";", trim($row['reise']));         
$tort = getwert($array[1],"orte","name","id");    
echo 'Weg nach <a href="reisen.php?ziel='.$array[1].'">'.ucwords($tort);  
echo '</a>';
}

echo '<br>'; 
if($row['mission'] != 0){   
echo '<b>';
$mwo = $row['mwo'];   
$maufgaben = getwert($row['mission'],"missions","aufgabe","id");  
$array = explode("@", trim($maufgaben));         
echo 'Mission: <BLINK><a class="blink" href="missions.php">';
if($array[$mwo] == ""){
echo 'Mission abgeben';                                      
}
else{
echo $array[$mwo];
}
echo '</a>';
}
echo '</div>';
echo '</BLINK></b>';  
echo '</div>';
echo '</td>';          
echo '<td>';    
echo '</td>';         
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="pms.php" class="sinfo">';  
echo '<center>';
echo '<div class="mail">';
echo '</div>';
echo '<div id="oid">';
$mails = mails($row['id']);
if($mails == 0){
echo "($mails)";
}else{
echo "<BLINK><b>($mails)</b></BLINK>";
}
echo '</div>';
echo '<span class="spanmenu">Nachrichten</span>';   
echo '</center>';
echo '</a>';
echo '</div>';
echo '</td>';
echo '<td width="60px">';
echo '<div class="ombutton">';  
echo '<a href="friends.php" class="sinfo">';      
echo '<center>';
echo '<div class="friend">';
echo '</div>';
echo '<div id="oid">';
$friends = friends($row['id']);
if($friends[1] == 0){
echo "(".$friends[0].")";
}
else{
echo "<BLINK><b>(".$friends[0].")</b></BLINK>";
}
echo '</div>';   
echo '<span class="spanmenu">Freunde</span>';  
echo '</center>';
echo '</a>';
echo '</div>';
echo '</td>';    
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="online.php" class="sinfo">';      
echo '<center>';
echo '<div class="online">';
echo '</div>';
echo '<div id="oid">';
$online = getanzahl(NULL,"charaktere","session","2");
echo '('.$online.')';
echo '</div>';     
echo '<span class="spanmenu">Online</span>';   
echo '</center>';
echo '</a>';
echo '</div>';
echo '</td>';
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="list.php" class="sinfo">';   
echo '<center>';
echo '<div class="list">';
echo '</div>';
echo '<div id="oid">';
$useranzahl = getanzahl($row['id'],"charaktere","id","0");
echo '('.$useranzahl.')';
echo '</div>';     
echo '<span class="spanmenu">Listen</span>';   
echo '</center>';
echo '</a>';
echo '</div>';
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="index.php" class="sinfo">';      
echo '<center>';
echo '<div class="news">';
echo '</div>';    
echo '<span class="spanmenu">Neuigkeiten</span>';
echo '</center>';
echo '</a>';
echo '</div>';
echo '</td>';
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="info.php" class="sinfo">';     
echo '<center>';
echo '<div class="info">';
echo '</div>';    
echo '<span class="spanmenu">Infos</span>';
echo '</center>';
echo '</a>';
echo '</div>';
echo '</td>';
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="info.php?page=partner" class="sinfo">';    
echo '<center>';
echo '<div class="forum">';
echo '</div>';           
echo '<span class="spanmenu">Partner</span>';   
echo '</center>';
echo '</a>';
echo '</div>';       
echo '</td>';
  ?>
<td width="60px">
<div class="ombutton">
<a href="#" class="sinfo" onClick="window.open('chat.php','Chat','height=540,width=1150'); return false;">
<center>
<div class="chat">
</div>     
<div class="oid">
<?php
  $count = Chat::GetUserCount($accountDB);
  echo '('.$count.')';
?>
</div>           
<span class="spanmenu">Chat</span>   
</center>
</a></noscript> 
</div>       
</td>
<?php
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="https://discord.gg/PUC5MwT" target="_blank" class="sinfo">';     
echo '<center>';
echo '<div class="discord">';
echo '</div>';           
echo '<span class="spanmenu">Discord</span>';   
echo '</center>';
echo '</a>';
echo '</div>';       
echo '</td>';
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="https://db-bg.de/" target="_blank" class="sinfo">';     
echo '<center>';
echo '<div class="dbbg">';
echo '</div>';           
echo '<span class="spanmenu">DB-BG</span>';   
echo '</center>';
echo '</a>';
echo '</div>';       
echo '</td>';
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="melden.php" class="sinfo">';      
echo '<center>';
echo '<div class="support">';
echo '</div>';    
echo '<div id="oid">';
if($row['admin'] != 0){
$supporta = getanzahl("Wartet","meldungen","status","1");
if($supporta == 0){
echo "(".$supporta.")";
}
else{
echo "<BLINK><b>(".$supporta.")</b></BLINK>";
}
}
else{ 
$supporta = supporton(); 
if($supporta == ""){
$supporta = 0;
}
echo "(".$supporta.")";
}
echo '</div>';  
echo '<span class="spanmenu">Support</span>';
echo '</center>';
echo '</a>';
echo '</div>';
echo '</td>';
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="settings.php" class="sinfo">';   
echo '<center>';
echo '<div class="settings">';
echo '</div>';    
echo '<span class="spanmenu">Einstellungen</span>';   
echo '</center>';
echo '</a>';
echo '</div>';
echo '</td>';
echo '<td width="60px">';
echo '<div class="ombutton">';
echo '<a href="main_login.php?aktion=charlogout" class="sinfo">';    
echo '<center>';
echo '<div class="logout">';
echo '</div>';
echo '<span class="spanmenu2">Logout</span>';    
echo '</center>';
echo '</a>';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
}
$result->close(); $db->close(); 
}
else
{
  ?>
<table class="omtable shadow">
  <tr>
<td align="center">
<table>
<?php
$t = 0;
$anzahl = 8;          
$drin = "";
while($t < 6){    
$weiter = 0;   
while($weiter == 0){  
$weiter = 1;   
$z = rand(1,$anzahl);   
$count = 0;
while($drin[$count] != ""){
if($drin[$count] == $z){
$weiter = 0;
}
$count++;
}
}
$drin[$t] = $z;      
echo '<td><a href="bilder/screens/screen0'.$z.'.png" target="_blank"><img height="50px" width="100px" src="bilder/screens/screen0'.$z.'.png" border="0"></a>';
$t++;   
}

?>
</table>
</td>
    <td></td>
<td width="60px">
<div class="ombutton">
<a href="online.php" class="sinfo">    
<center>
<div class="online">
</div>
<div id="oid">
<?php
$online = getanzahl(NULL,"charaktere","session","2");
echo '('.$online.')';
?>
</div>     
<span class="spanmenu">Online</span>   
</center>
</a>
</div>
</td>
<td width="60px">
<div class="ombutton">
<a href="list.php" class="sinfo">   
<center>
<div class="list">
</div>
<div id="oid">
<?php
$anzahl = getanzahl($row['id'],"charaktere","id","0");
echo '('.$anzahl.')';
?>
</div>     
<span class="spanmenu">Listen</span>   
</center>
</a>
</div>
<td width="60px">
<div class="ombutton">
<a href="index.php" class="sinfo">      
<center>
<div class="news">
</div>    
<span class="spanmenu">Neuigkeiten</span>
</center>
</a>
</div>
</td>
<td width="60px">
<div class="ombutton">
<a href="info.php" class="sinfo">     
<center>
<div class="info">
</div>    
<span class="spanmenu">Infos</span>
</center>
</a>
</div>
</td>
<td width="60px">
<div class="ombutton">
<a href="info.php?page=partner" class="sinfo">     
<center>
<div class="forum">
</div>           
<span class="spanmenu">Partner</span>   
</center>
</a>
</div>       
</td>
<td width="60px">
<div class="ombutton">
<a href="https://discord.gg/PUC5MwT" target="_blank" class="sinfo">     
<center>
<div class="discord">
</div>           
<span class="spanmenu">Discord</span>   
</center>
</a>
</div>       
</td>
<td width="60px">
<div class="ombutton">
<a href="https://db-bg.de/" target="_blank" class="sinfo">     
<center>
<div class="dbbg">
</div>           
<span class="spanmenu">DB-BG</span>   
</center>
</a>
</div>       
</td>
<td width="60px">
<div class="ombutton">  
<?php
if($logged)
{
  ?>
  <a href="main_login.php?aktion=logout" class="sinfo">
<center>
<div class="logout">
</div>           
<span class="spanmenu">Logout</span>   
</center>
</a>
  <?php
}
else
{
  ?>
  <a href="login.php" class="sinfo">     
<center>
<div class="logout">
</div>           
<span class="spanmenu">Login</span>   
</center>
</a>
  <?php
}
?>

</div>       
</td>
<td width="60px">      
</td>
</tr>
</table>
  <?php
}
?>