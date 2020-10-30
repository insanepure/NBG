<?php  
echo '<h3>User</h3>
<a href="profil.php">Profil</a>
<br>';
$ustats = getwert(session_id(),"charaktere","statspunkte","session");     
$uclan = getwert(session_id(),"charaktere","clan","session");
if($ustats == 0){    
echo '<a href="chara.php">Charakter</a>';
}
else{
echo '<b><BLINK><a class="blink" href="chara.php">Charakter</a></BLINK></b>';
}          
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");       
$array = explode(";", trim($ujutsus));  
$count = 0;
$edo = 0;
while($array[$count] != ''){
if($array[$count] == 406){
$edo = 1;
}
$count++;
}     
if($uclan == "kugutsu"||$uclan == "inuzuka"||$uclan == "jiongu"||$uclan == 'admin'||$uclan == 'sakon'||$edo == 1){  
echo '<br><a href="summon.php">';
if($uclan == "kugutsu"){
echo 'Puppen';
}   
if($uclan == "jiongu"){
echo 'Herzen';
}
if($uclan == "inuzuka"){
echo 'Hunde';
} 
if($uclan == "admin"){
echo 'Tiere';
}   
if($uclan == "sakon"){
echo 'Bruder';
}   
if($edo == 1){
echo 'Leichen';
} 
echo '</a>';
}
echo '<br>
<a href="inventar.php">Inventar</a>
<br>                      
<br>             
<h3>';
$ort = getwert(session_id(),"charaktere","ort","session");
$reise = getwert(session_id(),"charaktere","reise","session");      
$urank = getwert(session_id(),"charaktere","rank","session");     
$udorf = getwert(session_id(),"charaktere","dorf","session"); 
$omap = getwert($ort,"orte","map","id");   
if($reise == ""){   
$tort = getwert($ort,"orte","name","id"); 
echo ucwords($tort); 
}
else{              
$array = explode(";", trim($reise));         
$tort = getwert($array[1],"orte","name","id");    
echo 'Weg nach '.ucwords($tort);
}
echo '</h3>';   

$umissi = getwert(session_id(),"charaktere","mission","session");   
$reisenpc = getwert(session_id(),"charaktere","reisenpc","session");     
$reiseitem = getwert(session_id(),"charaktere","reiseitem","session");     
$geht = 0;
$geht2 = 0;
if($umissi != ""){
$uwo = getwert(session_id(),"charaktere","mwo","session");

$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
wo,
punkte
FROM
missions
where id="'.$umissi.'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$array = explode("@", trim($row['wo']));  
$array2 = explode("$", trim($array[$uwo]));  
$count = 0;
$istda = 0;
while($array2[$count] != ""){
if($array2[$count] == $ort){
$istda = 1;
}
$count++;
}
if($istda == 1){
$geht = 1;
}
elseif($array[$uwo] != ""){
$geht2 = 2;
}
else{   
$count = 0;
$istda = 0;
$array2 = explode("$", trim($array[0]));  
while($array2[$count] != ""){
if($array2[$count] == $ort){
$istda = 1;
}
$count++;
}
if($istda == 1){
$geht2 = 1;
}
}
}
$result->close();
$db->close();     
}
if($reisenpc != 0||$reiseitem != 0){
$geht = 1;
}
if($geht == 1){
echo '<b><BLINK><a class="blink" href="ort.php">Ort</a></BLINK></b>';
}
else{          
echo '<a href="ort.php">Ort</a>';
} 
echo '<br>';

if($geht2 == 1){
echo '<b><BLINK><a class="blink" href="missions.php">Missionen</a></BLINK></b>';
}
else{          
echo '<a href="missions.php">Missionen</a>';
}  
echo '<br>';        
$lehrer = getwert($ort,"orte","lehrer","id"); 
$ortw = getwert($ort,"orte","was","id"); 
if($lehrer != ""){
if($ortw == "dorf"){
echo '<a href="akademie.php">Akademie</a><br>';
}
else{   
echo '<a href="akademie.php">Ausbilder</a><br>';
}
}
if($udorf == $ort&&$urank == 'kage'){
echo '<a href="kage.php">Kage Haus</a><br>';
}
$shops = getwert($ort,"orte","shops","id"); 
$array = explode(";", trim($shops));   
$count = 0;
while(isset($array[$count])){      
if($ortw == "dorf"){         
if($array[$count] == "kh"){
echo '<a href="kh.php">Krankenhaus</a><br>';
}
if($array[$count] == "heil"){
echo '<a href="shop.php?shop=heil">Apotheke</a><br>';
}
if($array[$count] == "waffe"){
echo '<a href="shop.php?shop=waffe">Waffenladen</a><br>';
}
if($array[$count] == "kleidung"){
echo '<a href="shop.php?shop=kleidung">Kleidungsladen</a><br>';
}   
if($array[$count] == "puppe"){
echo '<a href="shop.php?shop=puppe">Puppenladen</a><br>';
}
}
else{            
if($array[$count] == "kh"){
echo '<a href="kh.php">Heiler</a><br>';
}
if($array[$count] == "heil"){
echo '<a href="shop.php?shop=heil">Apotheker</a><br>';
}
if($array[$count] == "waffe"){
echo '<a href="shop.php?shop=waffe">Waffenhändler</a><br>';
}
if($array[$count] == "kleidung"){
echo '<a href="shop.php?shop=kleidung">Kleidungshändler</a><br>';
}    
if($array[$count] == "puppe"){
echo '<a href="shop.php?shop=puppe">Puppenhändler</a><br>';
}
}
$count++;
} 
if($ortw == 'dorf'||$ort == '13'||$ort == '52'){
echo '<a href="markt.php">Marktplatz</a><br>';
}
$ortw = getwert($ort,"orte","was","id"); 
if($ortw == "dorf"){                        
echo '<a href="training.php">Übungsplatz</a>';
}
else{ 
echo '<a href="training.php">Übungsfeld</a>';
}
echo '<br>';
if($geht2 == 2){ 
if($ortw == "reise"){  
echo '<b><BLINK><a class="blink" href="reisen.php">Reisen</a></BLINK></b>';
}
else{            
if($omap == 0){
echo '<b><BLINK><a class="blink" href="map.php">Reisen</a></BLINK></b>';
}
else{
echo '<b><BLINK><a class="blink" href="map.php?map=event">Reisen</a></BLINK></b>';
}
}

}
else{
if($ortw == "reise"){       
echo '<a href="reisen.php">Reisen</a>';
}
else{ 
if($omap == 0){
echo '<a href="map.php">Reisen</a>';
}
else{
echo '<a href="map.php?map=event">Reisen</a>';
}
}
}
echo '<br>';  
echo '<br>';             
$ortw = getwert($ort,"orte","was","id"); 
if($ortw == "dorf"){                      
$ulevel = getwert(session_id(),"charaktere","level","session"); 
$jounin = 0;
$anbu = 0;
$kage = 0;   
$nukep = 0;   
if($ulevel >= 60&&$urank == "nuke-nin"){      
if($ort == 13){              
$uid = getwert(session_id(),"charaktere","id","session"); 
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
where besitzer="'.$uid.'" AND name = "Nuke-Nin Mantel" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$nukep = 0;
}
$result->close();
$db->close(); 
}
}
if($ulevel >= 50&&$urank == "chuunin"){      
$udorf = getwert(session_id(),"charaktere","dorf","session");
if($udorf == $ort){
$jounin = 1;
}
}
if($ulevel >= 60&&$urank == "jounin"){      
$udorf = getwert(session_id(),"charaktere","dorf","session");
if($udorf == $ort){
$anbu = 1;
}
}
if($urank == "anbu" || $urank == 'jounin'){   
$udorf = getwert(session_id(),"charaktere","dorf","session");   
$kageturnier = getwert($udorf,"orte","kagetid","id");
if($udorf == $ort&&$kageturnier != 0){
$kage = 1;
}
}
$genin = 0;  
$genin = getwert($ort,"orte","genin","id"); 
$chuunin = 0;
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
chuunin
FROM
orte
WHERE chuunin != "0" AND chuunin != "4"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$chuunin = 1;
}
$result->close();
$db->close(); 
if($genin != 0||$chuunin != 0||$jounin != 0||$kage != 0||$nukep != 0){
echo '<h3>Prüfungen</h3>';
if($nukep != 0){
echo '<a href="jounin.php">Nuke Prüfung</a>';
echo '<br>';
}
if($kage != 0){
echo '<a href="jounin.php">Kage Turnier</a>';
echo '<br>';
}
if($anbu != 0){
echo '<a href="jounin.php">Anbu Prüfung</a>';
echo '<br>';
} 
if($jounin != 0){
echo '<a href="jounin.php">Jounin Prüfung</a>';
echo '<br>';
}     
if($genin != 0){
echo '<a href="genin.php">Genin Prüfung</a>';
echo '<br>';
}        
if($chuunin != 0){
echo '<a href="chuunin.php">Chuunin Prüfung</a>';
echo '<br>';
}     
echo '<br>';  
}
}
echo '<h3>Kampf</h3>';
$kampfid = getwert(session_id(),"charaktere","kampfid","session");
if($kampfid != 0){
$begin = getwert($kampfid,"fights","begin","id");
if($begin == 1){
echo '<BLINK><b><a class="blink" href="fight.php">Kampf</a></b></BLINK>';   
}
else{
echo '<a href="kampf.php">Kampf</a>';    
}   
}
else{
echo '<a href="kampf.php">Kampf</a>'; 
}                                
echo '<br>';                                    
$turnier = getwert(session_id(),"charaktere","turnier","session");
if($turnier == "0"){
echo '<a href="turnier.php">Turnier</a>';      
}
else{         
$tzeit = getwert($turnier,"turnier","start","id");   
$tzeit = strtotime($tzeit); 
if($tzeit >= time()){      
echo '<a href="turnier.php">Turnier</a>';      

}
else{    
echo '<BLINK><b><a href="turnier.php">Turnier</a></b></BLINK>';   
}
}    
echo '<br><a href="wks.php">Wertung</a>';        
if($urank != "student"){      
$kin = getwert(session_id(),"charaktere","kin","session");    
echo '<br>';          
if($kin == 1){
echo '<BLINK><b><a class="blink" href="krieg.php">Krieg</a></b></BLINK>';   
}
else{
echo '<a href="krieg.php">Krieg</a>'; 
}          
echo '<br>';                        
$npcwin = getwert(session_id(),"charaktere","npcwin","session");
if($npcwin != 0){
echo '<BLINK><b><a class="blink" href="npc.php">NPC</a></b></BLINK>';   
}
else{
echo '<a href="npc.php">NPC</a>'; 
}  
}             
echo '<br>';                      
echo '<br>';     
$urank = getwert(session_id(),"charaktere","rank","session");
if($urank != "student"){
if($urank == "nuke-nin"){   
echo '<h3>Organisation</h3>';   
}  
else{
echo '<h3>Team</h3>';  
}                               
$org = getwert(session_id(),"charaktere","org","session");
if($org == "0"){   
echo '<a href="org.php?page=create">Erstellen</a>';                          
echo '<br>';                        
echo '<a href="org.php?page=join">Beitreten</a>';                
echo '<br>';  

}
else{
echo '<a href="org.php">Profil</a>';                          
echo '<br>';        
$oapply = getwert($org,"charaktere","name","oapply");
if($oapply){      
echo '<BLINK><b><a class="blink" href="org.php?page=mitglied">Mitglieder</a></b></BLINK>';   
}
else{
echo '<a href="org.php?page=mitglied">Mitglieder</a>'; 
}     
echo '<br>';  
}                            
}      
$admin = getwert(session_id(),"charaktere","admin","session");  
if($admin != 0){          
echo '<br>';  
echo '<h3>Support</h3>';                
echo '<a href="mod.php">Mod Menü</a>';
echo '<br>';                                                             
}
if($admin == 3){                          
echo '<a href="admin.php">Admin Menü</a>';
echo '<br>';                                                            
}        
echo '<br>';                              
$uaktion = getwert(session_id(),"charaktere","aktion","session");
if($uaktion != ""){     
$uaktions = getwert(session_id(),"charaktere","aktions","session");  
$aktiond = getwert(session_id(),"charaktere","aktiond","session");  
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($uaktions); 
$test3 = $test2-$test;
$test4 = ($aktiond*60)-$test3;
$cID = $cID+1;
echo '<b>'.$uaktion.'</b><br>';
echo 'Dauer: <b id="cID'.$cID.'">';
echo " Init<script>countdown($test4,'cID$cID');</script></b><br>";     
echo '<form method="post" action="chara.php?aktion=abbrechen"><input type="checkbox" name="check" value="Ja"> <input class="button2" name="login" id="login" value="Aktion abbrechen" type="submit"></form>';

}

?>  
