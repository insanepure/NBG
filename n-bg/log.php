<?php
include 'inc/incoben.php';
$kid = $_GET['kid'];                   
include 'inc/header.php';
?>
<center>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- NBG Fight -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-7145796878009968"
     data-ad-slot="5089102624"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
</center>
<?php
if($kid != ""&&is_numeric($kid)){   
$kende = getwert($kid,"fights","ende","id");    
if($kende == 0){        
echo '<table class="ktabelle"><tr>';
echo '<td width="25%" valign="top" align="right">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
kaktion,
lkaktion,
kziel,
kzwo,
powerup,
debuff
FROM
charaktere
WHERE kampfid="'.$kid.'" AND team % 2
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}                                                                  
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
echo '<div class="ksob"></div>'; 
echo '<div class="ksmb">';
echo '<table class="kspieler" border=0>';
echo '<tr class="kspieler">';
echo '<td align="center">';
echo $row['kname'];               
if($row['team'] == 1){
echo '<font color="#0000ff">';
}
if($row['team'] == 2){     
echo '<font color="#ff0000">';
}
if($row['team'] == 3){ 
echo '<font color="#00ff00">';
}
if($row['team'] == 4){ 
echo '<font color="#ffcc00">';
}
if($row['team'] == 5){
echo '<font color="#00e8b2">';
}
if($row['team'] == 6){
echo '<font color="#ff00ff">';
}
if($row['team'] == 7){
echo '<font color="#8B4513">';
}
if($row['team'] == 8){   
echo '<font color="#5829ad">';
}
if($row['team'] == 9){
echo '<font color="#FF6EB4">';
}
if($row['team'] == 10){
echo '<font color="#FF7F00">';
} 
echo '<br>Team '.$row['team'];
echo '</font>';
echo '<br>';   
echo '<div style="position:relative; height:75px; width:75px;">';  
echo '<div class="ksbild" style="position:absolute; z-index:2;" >';
echo '<img src="bilder/kampf/ksn.png" border=0></img>';   
echo '</div>';   
if($row['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row['kkbild'].'" width="75px" height="75px"></img>';   
}
else{         
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="75px" height="75px"></img>';   
}  
echo '</div>';
echo '<div class="ksbar" style="margin-bottom:1px">'; 
echo '<div class="kshp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';                 
echo '<div class="ksbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="ksbar">'; 
echo '<div class="kschakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;  
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';         
echo '<div class="ksbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';  
echo '<b class="att">';
if($row['kaktion'] == ""){
echo 'Wählt';
}
else{
echo 'Wartet';
}
echo '</b><br>';         
echo '</td>';              
//PU/DEBUFFS
if($row['powerup'] != ""||$row['debuff'] != ""){   
echo '<td align="center" width="50%">';
echo '<table width="100%">';
echo '<tr>';   
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$pc2 = 0;
while($pus[$pcount] != ""&&$pcount <= 9){ 
$pbild = getwert($pus[$pcount],"jutsus","bild","id");
echo '<td width="50%" align="center">'; 
echo '<div style="position:relative; height:30px; width:30px;">';  
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>'; 
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$pbild.'h.png" width="30px" height="30px"></img>';   
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$pcount++;
}
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
while($darray[$dcount] != ""&&$pcount <= 9){   
$dbuff = explode(";", trim($darray[$dcount]));
$dbild = getwert($dbuff[0],"jutsus","bild","id");
echo '<td width="50%" align="center">'; 
echo '<div style="position:relative; height:30px; width:30px;">';  
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>'; 
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$dbild.'h.png" width="30px" height="30px"></img>';   
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$dcount++;
$pcount++;
}
echo '</tr></table>'; 
}
else{  
echo '<td align="center">';
}
echo '</td>';
echo '</tr>';
echo '<tr class="kspieler">';
echo '<td colspan="2">';
//Beschwörungen
echo '<table width="100%" border="0">';
echo '<tr>';
$sql2 = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
besitzer,
bwo,
kaktion,
kzwo,
kziel
FROM
npcs
WHERE kampfid="'.$kid.'" AND besitzer="'.$row['id'].'" AND bwo="charaktere"
ORDER BY
team,
name
DESC
LIMIT 3';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<td valign="top" align="center">';   
echo '<div style="position:relative; height:50px; width:50px;">';  
echo '<div class="kbbild" style="position:absolute; z-index:2;" >';
echo '<img src="bilder/kampf/kbn.png" border=0></img>';   
echo '</div>';  
if($row2['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row2['kkbild'].'" width="50px" height="50px"></img>';    
}
else{         
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="50px" height="50px"></img>';   
}  
echo '</div>';
echo '<div class="kbbar" style="margin-bottom:1px">'; 
echo '<div class="kbhp" style="width:';
$prozent = $row2['hp']/$row2['mhp'];
$prozent = $prozent*100;       
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';                 
echo '<div class="kbbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="kbbar">'; 
echo '<div class="kbchakra" style="width:';
$prozent = $row2['chakra']/$row2['mchakra'];
$prozent = $prozent*100;   
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';         
echo '<div class="kbbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';     

echo '<b class="att"><center>';
if($row2['kaktion'] == ""){
echo 'Wählt';
}
else{
echo 'Wartet';
}    

echo '</b></center>';
echo '</td>';
}
$result2->close();  
echo '</tr></table>';
echo '</td></tr></table>'; 
echo '</div>';      
echo '<div class="ksub"></div><br>'; 
}
$result->close();  
$db->close(); 
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
kaktion,
lkaktion,
kziel,
kzwo,
besitzer,
powerup,
debuff
FROM
npcs
WHERE kampfid="'.$kid.'" AND team % 2 AND besitzer="0"
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false     
echo '<div class="ksob"></div>'; 
echo '<div class="ksmb">';
echo '<table class="kspieler" border=0>';
echo '<tr class="kspieler">';
echo '<td align="center">';
echo $row['kname'];               
if($row['team'] == 1){
echo '<font color="#0000ff">';
}
if($row['team'] == 2){     
echo '<font color="#ff0000">';
}
if($row['team'] == 3){ 
echo '<font color="#00ff00">';
}
if($row['team'] == 4){ 
echo '<font color="#ffcc00">';
}
if($row['team'] == 5){
echo '<font color="#00e8b2">';
}
if($row['team'] == 6){
echo '<font color="#ff00ff">';
}
if($row['team'] == 7){
echo '<font color="#8B4513">';
}
if($row['team'] == 8){   
echo '<font color="#5829ad">';
}
if($row['team'] == 9){
echo '<font color="#FF6EB4">';
}
if($row['team'] == 10){
echo '<font color="#FF7F00">';
}
echo '<br>Team '.$row['team'];
echo '</font>';
echo '<br>';   
echo '<div style="position:relative; height:75px; width:75px;">';  
echo '<div class="ksbild" style="position:absolute; z-index:2;" >';
echo '<img src="bilder/kampf/ksn.png" border=0></img>';   
echo '</div>'; 
if($row['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row['kkbild'].'" width="75px" height="75px"></img>';    
}
else{         
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="75px" height="75px"></img>';   
}  
echo '</div>';
echo '<div class="ksbar" style="margin-bottom:1px">'; 
echo '<div class="kshp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;  
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';                 
echo '<div class="ksbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="ksbar">'; 
echo '<div class="kschakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;   
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';         
echo '<div class="ksbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';  
echo '<b class="att">';
if($row['kaktion'] == ""){
echo 'Wählt';
}
else{
echo 'Wartet';
}
echo '</b><br>';
echo '</td>';
//PU/DEBUFFS
if($row['powerup'] != ""||$row['debuff'] != ""){   
echo '<td align="center" width="50%">';
echo '<table width="100%">';
echo '<tr>';   
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$pc2 = 0;
while($pus[$pcount] != ""&&$pcount <= 9){ 
$pbild = getwert($pus[$pcount],"jutsus","bild","id");
echo '<td width="50%" align="center">'; 
echo '<div style="position:relative; height:30px; width:30px;">';  
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>'; 
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$pbild.'h.png" width="30px" height="30px"></img>';   
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$pcount++;
}
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
while($darray[$dcount] != ""&&$pcount <= 9){   
$dbuff = explode(";", trim($darray[$dcount]));
$dbild = getwert($dbuff[0],"jutsus","bild","id");
echo '<td width="50%" align="center">'; 
echo '<div style="position:relative; height:30px; width:30px;">';  
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>'; 
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$dbild.'h.png" width="30px" height="30px"></img>';   
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$dcount++;
$pcount++;
}
echo '</tr></table>'; 
}
else{  
echo '<td align="center">';
}
echo '</td>';
echo '</tr>';
echo '<tr class="kspieler">';
echo '<td colspan="2">';
//Beschwörungen
echo '<table width="100%" border="0">';
echo '<tr>';
$sql2 = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
besitzer,
bwo,
kaktion,
kzwo,
kziel
FROM
npcs
WHERE kampfid="'.$kid.'" AND besitzer="'.$row['id'].'" AND bwo="npcs"
ORDER BY
team,
name
DESC
LIMIT 3';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<td valign="top" align="center">';   
echo '<div style="position:relative; height:50px; width:50px;">';  
echo '<div class="kbbild" style="position:absolute; z-index:2;" >';
echo '<img src="bilder/kampf/kbn.png" border=0></img>';   
echo '</div>';    
if($row2['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row2['kkbild'].'" width="50px" height="50px"></img>';    
}
else{         
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="50px" height="50px"></img>';   
}   
echo '</div>';
echo '<div class="kbbar" style="margin-bottom:1px">'; 
echo '<div class="kbhp" style="width:';
$prozent = $row2['hp']/$row2['mhp'];
$prozent = $prozent*100;        
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';                 
echo '<div class="kbbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="kbbar">'; 
echo '<div class="kbchakra" style="width:';
$prozent = $row2['chakra']/$row2['mchakra'];
$prozent = $prozent*100;       
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';         
echo '<div class="kbbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';     

echo '<b class="att"><center>';
if($row2['kaktion'] == ""){
echo 'Wählt';
}
else{
echo 'Wartet';
}

echo '</b></center>';
echo '</td>';
}
$result2->close();  
echo '</tr></table>';
echo '</td></tr></table>'; 
echo '</div>';      
echo '<div class="ksub"></div><br>'; 
}
$result->close();  
$db->close(); 
echo '</td>'; 
echo '<td width="50%" valign="top" align="center">';
echo '<div class="klogo"></div>';
echo '<div class="klogm">';
echo '<div class="klog2 shadow" style="color:#414243">';   
echo '<a href="log.php?kid='.$kid.'">Aktualisieren</a><br>';
$kwetter = getwert($kid,"fights","wetter","id");
echo '<div class="shadow" style="width:100px; height:100px; background:url(bilder/wetter/'.$kwetter.'.png);"><br><br>'.$kwetter.'</div>';
$klog = getwert($kid,"fights","log","id");
echo $klog;               
echo '</div>';
echo '</div>';
echo '<div class="klogu"></div>';  
echo '</td>'; 
echo '<td width="25%" valign="top" align="left">';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
kaktion,
lkaktion,
kziel,
kzwo,
powerup,
debuff
FROM
charaktere
WHERE kampfid="'.$kid.'" AND team % 2 = "0"
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}                                                                         
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false      
echo '<div class="ksob"></div>'; 
echo '<div class="ksmb">';
echo '<table class="kspieler" border=0>';
echo '<tr class="kspieler">';
echo '<td align="center">';
echo $row['kname'];               
if($row['team'] == 1){
echo '<font color="#0000ff">';
}
if($row['team'] == 2){     
echo '<font color="#ff0000">';
}
if($row['team'] == 3){ 
echo '<font color="#00ff00">';
}
if($row['team'] == 4){ 
echo '<font color="#ffcc00">';
}
if($row['team'] == 5){
echo '<font color="#00e8b2">';
}
if($row['team'] == 6){
echo '<font color="#ff00ff">';
}
if($row['team'] == 7){
echo '<font color="#8B4513">';
}
if($row['team'] == 8){   
echo '<font color="#5829ad">';
}
if($row['team'] == 9){
echo '<font color="#FF6EB4">';
}
if($row['team'] == 10){
echo '<font color="#FF7F00">';
} 
echo '<br>Team '.$row['team'];
echo '</font>';
echo '<br>';   
echo '<div style="position:relative; height:75px; width:75px;">';  
echo '<div class="ksbild" style="position:absolute; z-index:2;" >';
echo '<img src="bilder/kampf/ksn.png" border=0></img>';   
echo '</div>';  
if($row['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row['kkbild'].'" width="75px" height="75px"></img>';   
}
else{         
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="75px" height="75px"></img>';   
}  
echo '</div>';
echo '<div class="ksbar" style="margin-bottom:1px">'; 
echo '<div class="kshp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';                 
echo '<div class="ksbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="ksbar">'; 
echo '<div class="kschakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;  
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';         
echo '<div class="ksbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';  
echo '<b class="att">';
if($row['kaktion'] == ""){
echo 'Wählt';
}
else{
echo 'Wartet';
}
echo '</b><br>';         
echo '</td>';              
//PU/DEBUFFS
if($row['powerup'] != ""||$row['debuff'] != ""){   
echo '<td align="center" width="50%">';
echo '<table width="100%">';
echo '<tr>';   
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$pc2 = 0;
while($pus[$pcount] != ""&&$pcount <= 9){ 
$pbild = getwert($pus[$pcount],"jutsus","bild","id");
echo '<td width="50%" align="center">'; 
echo '<div style="position:relative; height:30px; width:30px;">';  
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>'; 
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$pbild.'h.png" width="30px" height="30px"></img>';   
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$pcount++;
}
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
while($darray[$dcount] != ""&&$pcount <= 9){   
$dbuff = explode(";", trim($darray[$dcount]));
$dbild = getwert($dbuff[0],"jutsus","bild","id");
echo '<td width="50%" align="center">'; 
echo '<div style="position:relative; height:30px; width:30px;">';  
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>'; 
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$dbild.'h.png" width="30px" height="30px"></img>';   
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$dcount++;
$pcount++;
}
echo '</tr></table>'; 
}
else{  
echo '<td align="center">';
}
echo '</td>';
echo '</tr>';
echo '<tr class="kspieler">';
echo '<td colspan="2">';
//Beschwörungen
echo '<table width="100%" border="0">';
echo '<tr>';
$sql2 = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
besitzer,
bwo,
kaktion,
kzwo,
kziel
FROM
npcs
WHERE kampfid="'.$kid.'" AND besitzer="'.$row['id'].'" AND bwo="charaktere"
ORDER BY
team,
name
DESC
LIMIT 3';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<td valign="top" align="center">';   
echo '<div style="position:relative; height:50px; width:50px;">';  
echo '<div class="kbbild" style="position:absolute; z-index:2;" >';
echo '<img src="bilder/kampf/kbn.png" border=0></img>';   
echo '</div>';   

if($row2['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row2['kkbild'].'" width="50px" height="50px"></img>';    
}
else{         
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="50px" height="50px"></img>';   
}  
echo '</div>';
echo '<div class="kbbar" style="margin-bottom:1px">'; 
echo '<div class="kbhp" style="width:';
$prozent = $row2['hp']/$row2['mhp'];
$prozent = $prozent*100;       
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';                 
echo '<div class="kbbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="kbbar">'; 
echo '<div class="kbchakra" style="width:';
$prozent = $row2['chakra']/$row2['mchakra'];
$prozent = $prozent*100;   
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';         
echo '<div class="kbbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';     

echo '<b class="att"><center>';
if($row2['kaktion'] == ""){
echo 'Wählt';
}
else{
echo 'Wartet';
}

echo '</b></center>';
echo '</td>';
}
$result2->close();  
echo '</tr></table>';
echo '</td></tr></table>'; 
echo '</div>';      
echo '<div class="ksub"></div><br>'; 
}
$result->close();  
$db->close(); 
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
kaktion,
lkaktion,
kziel,
kzwo,
besitzer,
powerup,
debuff
FROM
npcs
WHERE kampfid="'.$kid.'" AND team %2 = "0" AND besitzer="0"
ORDER BY
team,
name
DESC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false     
echo '<div class="ksob"></div>'; 
echo '<div class="ksmb">';
echo '<table class="kspieler" border=0>';
echo '<tr class="kspieler">';
echo '<td align="center">';
echo $row['kname'];               
if($row['team'] == 1){
echo '<font color="#0000ff">';
}
if($row['team'] == 2){     
echo '<font color="#ff0000">';
}
if($row['team'] == 3){ 
echo '<font color="#00ff00">';
}
if($row['team'] == 4){ 
echo '<font color="#ffcc00">';
}
if($row['team'] == 5){
echo '<font color="#00e8b2">';
}
if($row['team'] == 6){
echo '<font color="#ff00ff">';
}
if($row['team'] == 7){
echo '<font color="#8B4513">';
}
if($row['team'] == 8){   
echo '<font color="#5829ad">';
}
if($row['team'] == 9){
echo '<font color="#FF6EB4">';
}
if($row['team'] == 10){
echo '<font color="#FF7F00">';
}
echo '<br>Team '.$row['team'];
echo '</font>';
echo '<br>';   
echo '<div style="position:relative; height:75px; width:75px;">';  
echo '<div class="ksbild" style="position:absolute; z-index:2;" >';
echo '<img src="bilder/kampf/ksn.png" border=0></img>';   
echo '</div>'; 
if($row['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row['kkbild'].'" width="75px" height="75px"></img>';    
}
else{         
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="75px" height="75px"></img>';   
}  
echo '</div>';
echo '<div class="ksbar" style="margin-bottom:1px">'; 
echo '<div class="kshp" style="width:';
$prozent = $row['hp']/$row['mhp'];
$prozent = $prozent*100;  
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';                 
echo '<div class="ksbc">';
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="ksbar">'; 
echo '<div class="kschakra" style="width:';
$prozent = $row['chakra']/$row['mchakra'];
$prozent = $prozent*100;   
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';         
echo '<div class="ksbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';  
echo '<b class="att">';
if($row['kaktion'] == ""){
echo 'Wählt';
}
else{
echo 'Wartet';
}
echo '</b><br>';
echo '</td>';
//PU/DEBUFFS
if($row['powerup'] != ""||$row['debuff'] != ""){   
echo '<td align="center" width="50%">';
echo '<table width="100%">';
echo '<tr>';   
$pus = explode(";", trim($row['powerup']));
$pcount = 0;
$pc2 = 0;
while($pus[$pcount] != ""&&$pcount <= 9){ 
$pbild = getwert($pus[$pcount],"jutsus","bild","id");
echo '<td width="50%" align="center">'; 
echo '<div style="position:relative; height:30px; width:30px;">';  
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>'; 
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$pbild.'h.png" width="30px" height="30px"></img>';   
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$pcount++;
}
$darray = explode("@", trim($row['debuff']));
$dcount = 0;
while($darray[$dcount] != ""&&$pcount <= 9){   
$dbuff = explode(";", trim($darray[$dcount]));
$dbild = getwert($dbuff[0],"jutsus","bild","id");
echo '<td width="50%" align="center">'; 
echo '<div style="position:relative; height:30px; width:30px;">';  
echo '<div class="kpu" style="position:absolute; z-index:2;">';
echo '</div>'; 
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/jutsus/'.$dbild.'h.png" width="30px" height="30px"></img>';   
echo '</div>';
echo '</td>';
$pc2++;
if($pc2 == 2){
$pc2 = 0;
echo '</tr><tr>';
}
$dcount++;
$pcount++;
}
echo '</tr></table>'; 
}
else{  
echo '<td align="center">';
}
echo '</td>';
echo '</tr>';
echo '<tr class="kspieler">';
echo '<td colspan="2">';
//Beschwörungen
echo '<table width="100%" border="0">';
echo '<tr>';
$sql2 = 'SELECT
id,
kname,
kkbild,
kampfid,
team,
hp,
mhp,
chakra,
mchakra,
besitzer,
bwo,
kaktion,
kzwo,
kziel
FROM
npcs    
WHERE kampfid="'.$kid.'" AND besitzer="'.$row['id'].'" AND bwo="npcs"
ORDER BY
team,
name
DESC
LIMIT 3';
$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
echo '<td valign="top" align="center">';   
echo '<div style="position:relative; height:50px; width:50px;">';  
echo '<div class="kbbild" style="position:absolute; z-index:2;" >';
echo '<img src="bilder/kampf/kbn.png" border=0></img>';   
echo '</div>';       
if($row2['kkbild'] != ""){
echo '<img style="left:0px; position:absolute; z-index:1;" src="'.$row2['kkbild'].'" width="50px" height="50px"></img>';    
}
else{         
echo '<img style="left:0px; position:absolute; z-index:1;" src="bilder/design/nokpic.png" width="50px" height="50px"></img>';   
}   
echo '</div>';
echo '<div class="kbbar" style="margin-bottom:1px">'; 
echo '<div class="kbhp" style="width:';
$prozent = $row2['hp']/$row2['mhp'];
$prozent = $prozent*100;        
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';                 
echo '<div class="kbbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';

echo '<div class="kbbar">'; 
echo '<div class="kbchakra" style="width:';
$prozent = $row2['chakra']/$row2['mchakra'];
$prozent = $prozent*100;       
if($prozent >= 100){
$prozent = 100;
}
echo $prozent.'%">';         
echo '<div class="kbbc">'; ;
echo '</div>';
echo '</div>';
echo '</div>';     

echo '<b class="att"><center>';
if($row2['kaktion'] == ""){
echo 'Wählt';
}
else{
echo 'Wartet'; 
}

echo '</b></center>';
echo '</td>';
}
$result2->close();  
echo '</tr></table>';
echo '</td></tr></table>'; 
echo '</div>';      
echo '<div class="ksub"></div><br>'; 
}
$result->close();  
$db->close(); 
echo '</td>'; 
echo '</tr></table>';
echo '</td></tr></table>';  
}
else{                    
echo '<table class="ktabelle"><tr><td align="center">';
echo '<div class="klogo"></div>';
echo '<div class="klogm">';
echo '<div class="klog2 shadow" style="color:#414243">';    
$kwetter = getwert($kid,"fights","wetter","id");
echo '<div class="shadow" style="width:100px; height:100px; background:url(bilder/wetter/'.$kwetter.'.png);"><br><br>'.$kwetter.'</div>';
$klog = getwert($kid,"fights","log","id");
echo $klog;            
echo '</div>';
echo '</div>';
echo '<div class="klogu"></div>';    
echo '</td></tr></table>';    
}    
}           
echo '<center><br><a href="kampf.php">Zurück</a></center>';
?>
<?php
$time_end = getmicrotime();
$time = round($time_end - $time_start,4);
echo '<center class="footer"><br>Seite in '.$time.' Sekunden generiert</center>'; 
?>