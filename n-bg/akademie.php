<?php
include 'inc/incoben.php';
// Hier kommen Skripts hin die vorm Laden ausgeführt werden    
if(logged_in()){
$ort = getwert(session_id(),"charaktere","ort","session"); 
$lehrer = getwert($ort,"orte","lehrer","id");           
$urank = getwert(session_id(),"charaktere","rank","session");
if($urank == "student"){     
$array = explode(";", trim($lehrer));    
$count = 0;
$hat = 0;
while(isset($array[$count])){   
if($array[$count] == "3"){
$hat = 1;
}
$count++;
}
if($hat == 1){
$lehrer = "3";
}
else{
$lehrer = "";
}
}
$aktion = $_GET['aktion'];
if($lehrer != ""){
if($aktion == "element"){      
$uaktion = getwert(session_id(),"charaktere","aktion","session");
if($uaktion == ""){
$lehrer2 = $_POST['lehrer'];     
$array = explode(";", trim($lehrer));
$count = 0;
$geht = 0;
while(isset($array[$count])){   
if($lehrer2 == $array[$count]){
$geht = 1;
}
$count++;
}
if($geht == 1){   
$relement = getwert($lehrer2,"npc","element","id");     
$uelemente = getwert(session_id(),"charaktere","elemente","session");  
$uclan = getwert(session_id(),"charaktere","clan","session"); 
$array = explode(";", trim($uelemente));  
$count = 0;
while(isset($array[$count])){    
if($array[$count] == $relement){
$geht = 0;
}
$count++;
}
if($geht == 1&&$count < 2||$geht == 1&&$uclan == "jiongu"){
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));       
$uid = getwert(session_id(),"charaktere","id","session");    
$dauer = 60*24;               
$uaktion = $relement.' lernen';  
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);            
$sql="UPDATE charaktere SET aktion ='$uaktion',aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}         
mysqli_close($con); 
$error = 'Du lernst nun das '.$relement.' Element.';
}
else{
$error = "Du hast dieses Element nicht lernen.";
}
}
else{
$error = "Dieser Lehrer ist nicht im Dorf.";
} 
}
else{
$error = "Du tust bereits etwas.";
} 
}
if($aktion == "lern"){
$lehrer2 = $_GET['lehrer'];  
$array = explode(";", trim($lehrer));
$count = 0;
$geht = 0;
while(isset($array[$count])){   
if($lehrer2 == $array[$count]){
$geht = 1;
}
$count++;
}
if($geht == 1){   
$uaktion = getwert(session_id(),"charaktere","aktion","session");
if($uaktion == ""){
$jutsu = $_GET['jutsu'];
$rjutsus = getwert($lehrer2,"npc","jutsus","id");
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");    
$uclan = getwert(session_id(),"charaktere","clan","session");
$uelemente = getwert(session_id(),"charaktere","elemente","session");      
$ulevel = getwert(session_id(),"charaktere","level","session");
$count = 0;
$c3 = 0;
$array = explode(";", trim($rjutsus));
while(isset($array[$count])){   
$count2 = 0; 
if($array[$count] != 1&&$array[$count] != 2){
$geht = 1;       
}
else{
$geht = 0;
}
$array2 = explode(";", trim($ujutsus));
while(isset($array2[$count2])){
if($array[$count] == $array2[$count2]){
$geht = 0;
}
$count2++;
}
if($geht == 1){
$geht = 0;
if($array[$count] == $jutsu){
$jreq = getwert($array[$count],"jutsus","req","id");      
$jelement = getwert($array[$count],"jutsus","element","id");  
$jclan = getwert($array[$count],"jutsus","clan","id");      
$jutsuben = getwert($array[$count],"jutsus","jutsuben","id");  
$jutsulevel = getwert($array[$count],"jutsus","level","id");         
$jutsus = "";
$jgeht = "";
$req = explode(";", trim($jreq));
$geht = 1;   
$geht2 = 1; 
if($jutsulevel != 0){
if($ulevel < $jutsulevel){
$geht = $geht-1;   
$geht2 = 0;     
$error = $error.'<br>Du musst mindestens auf Level '.$jutsulevel.' sein.';
}
}
if($jutsuben != "0"){
$geht = $geht-1;   
$geht2 = 0;
$jut = explode(";", trim($ujutsus));
$count2 = 0;
while(isset($jut[$count2])){
if($jut[$count2] == $jutsuben){
$geht = $geht+1;
}
$count2++;
}
if($geht2 == 0){    
$jbenn = getwert($jutsuben,"jutsus","name","id");     
$error = $error.'<br>Du benötigst das Jutsu '.$jbenn.'.';
}
}         
$geht2 = 0; 
if($jelement != ""){
$geht = $geht-1;
$ele = explode(";", trim($uelemente));
$count2 = 0;
while(isset($ele[$count2])){
if($ele[$count2] == $jelement){
$geht = $geht+1;       
$geht2 = 1;
}
$count2++;
}
if($geht2 == 0){
$error = $error.'<br>Du benötigst das '.$jelement.' Element.';
}
} 
if($geht < 0){
$geht = 0;
}                      
if($jclan != ""&&$uclan != $jclan){
$geht = 0;
$error = $error.'<br>Dies ist ein Bluterbenjutsu. Du kannst es nicht lernen.';
}
$hrp = $req[0];      
$uhp = getwert(session_id(),"charaktere","mhp","session");
if($uhp < $hrp){
$geht = 0;                   
$error = $error.'<br>Du benötigst '.$hrp.' HP.';
}
$rchr = $req[1]; 
$uchr = getwert(session_id(),"charaktere","mchakra","session");  
if($uchr < $rchr){
$geht = 0;            
$error = $error.'<br>Du benötigst '.$rchr.' Chakra.';
}
$rkr = $req[2]; 
$ukr = getwert(session_id(),"charaktere","mkr","session"); 
if($ukr < $rkr){
$geht = 0;                                
$error = $error.'<br>Du benötigst '.$rkr.' Kraft.';
}
$rint = $req[3]; 
$uint = getwert(session_id(),"charaktere","mintl","session");  
if($uint < $rint){
$geht = 0;                                       
$error = $error.'<br>Du benötigst '.$rint.' Intelligenz.';
}
$rchrk = $req[4]; 
$uchrk = getwert(session_id(),"charaktere","mchrk","session"); 
if($uchrk < $rchrk){
$geht = 0;                    
$error = $error.'<br>Du benötigst '.$rchrk.' Chakrakontrolle.';
}
$rtmp = $req[5];
$utmp = getwert(session_id(),"charaktere","mtmp","session"); 
if($utmp < $rtmp){
$geht = 0;          
$error = $error.'<br>Du benötigst '.$rtmp.' Tempo.';
}
$rgnk = $req[6]; 
$ugnk = getwert(session_id(),"charaktere","mgnk","session"); 
if($ugnk < $rgnk){
$geht = 0;             
$error = $error.'<br>Du benötigst '.$rgnk.' Genauigkeit.';
}
$rwid = $req[7]; 
$uwid = getwert(session_id(),"charaktere","mwid","session"); 
if($uwid < $rwid){
$geht = 0;
$error = $error.'<br>Du benötigst '.$rwid.' Widerstand.';
}
$hatitem = 0;              
$jitem = getwert($jutsu,"jutsus","item","id");  
if($jitem == ""){
$hatitem = 1;
}
else{
$array2 = explode(";", trim($jitem));
$count2 = 0;
while(isset($array2[$count2])){      
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt
FROM
items
WHERE besitzer="'.$uid.'" AND name = "'.$array2[$count2].'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['angelegt'] == 'LHand'||$row['angelegt'] == 'RHand'||$row['angelegt'] == 'LHand&RHand'){
$hatitem = 1;
}
}
$result->close(); 
$db->close(); 
$count2++;
}
} 
if($hatitem == 0){
$geht = 0;
$error = $error.'<br>Du hast nicht das benötigte Item angelegt.';
}
if($geht == 1){
//Lern
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));       
$uid = getwert(session_id(),"charaktere","id","session");    
$dauer = getwert($array[$count],"jutsus","dauer","id");     
$jname = getwert($array[$count],"jutsus","name","id");               
$uaktion = $jname.' lernen'; 
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);             
$sql="UPDATE charaktere SET aktion ='$uaktion',aktiond ='$dauer',aktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
mysqli_close($con); 
$error = 'Du lernst nun '.$jname.'.';
}
}
}
$count++;
}
}
else{
$error = "Du tust bereits etwas.";
}
}
else{
$error = "Dieser Lehrer ist nicht im Dorf.";
}
}
}
else{
$error = "Hier gibt es keine Lehrer.";
}   
}                   

?>
<?php //lädt jetzt erst das Design
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}         
$lehrer = getwert($ort,"orte","lehrer","id");           
$urank = getwert(session_id(),"charaktere","rank","session");       
$ulevel = getwert(session_id(),"charaktere","level","session");     
if($urank == "student"){     
$array = explode(";", trim($lehrer));    
$count = 0;
$hat = 0;
while(isset($array[$count])){   
if($array[$count] == "3"){
$hat = 1;
}
$count++;
}
if($hat == 1){
$lehrer = "3";
}
else{
$lehrer = "";
}
}
if($lehrer != ""){
$lanz = 0;                       
$lehr = explode(";", trim($lehrer));
while(isset($lehr[$lanz])){        
$rname = getwert($lehr[$lanz],"npc","name","id");
$rbild = getwert($lehr[$lanz],"npc","bild","id");  
$rclan = getwert($lehr[$lanz],"npc","clan","id");   
$uclan = getwert(session_id(),"charaktere","clan","session");
if($rclan == ""||$rclan == $uclan){
echo '<center><table class="table "><tr><td class="tdborder tdbg" colspan="2">'.ucwords($rname).'</td></tr>';
echo '<tr><td><img src="'.$rbild.'"></img></td>'; 
echo '<td>';  
//Jutsus lernen
$rjutsus = getwert($lehr[$lanz],"npc","jutsus","id");
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");     
$uelemente = getwert(session_id(),"charaktere","elemente","session");
$jutsus = array();
$jgeht = "";
$count = 0;
$c3 = 0;
$array = explode(";", trim($rjutsus));
while(isset($array[$count])){
$count2 = 0;   
$jlehr = getwert($array[$count],"jutsus","lehrbar","id");      
$geht = 1;
$jelement = getwert($array[$count],"jutsus","element","id");  
$jclan = getwert($array[$count],"jutsus","clan","id");  
$jutsuben = getwert($array[$count],"jutsus","jutsuben","id");    
$jutsulevel = getwert($array[$count],"jutsus","level","id");   
if($jclan != ""&&$uclan != $jclan){
$geht = 0;
}
if($jlehr == 1){
$hatjutsus = 1;
}
else{
$geht = 0;
}
$array2 = explode(";", trim($ujutsus));
while(isset($array2[$count2])){
if($array[$count] == $array2[$count2]){
$geht = 0;
}
$count2++;
}
if($geht == 1){                                      
$jreq = getwert($array[$count],"jutsus","req","id");   
$req = explode(";", trim($jreq));
$geht = 1;
if($jutsuben != "0"){
$geht = $geht-1;
$jut = explode(";", trim($ujutsus));
$count2 = 0;
while(isset($jut[$count2])){
if($jut[$count2] == $jutsuben){
$geht = $geht+1;
}
$count2++;
}
}  
if($jutsulevel != 0){
if($ulevel < $jutsulevel){
$geht = $geht-1;
}
}
if($jelement != ""){
$geht = $geht-1;
$ele = explode(";", trim($uelemente));
$count2 = 0;
while(isset($ele[$count2])){
if($ele[$count2] == $jelement){
$geht = $geht+1;
}
$count2++;
}
}
if($geht < 0){
$geht = 0;
}
$hrp = $req[0];      
$uhp = getwert(session_id(),"charaktere","mhp","session");
if($uhp < $hrp){
$geht = 0;
}
$rchr = $req[1]; 
$uchr = getwert(session_id(),"charaktere","mchakra","session");  
if($uchr < $rchr){
$geht = 0;
}
$rkr = $req[2]; 
$ukr = getwert(session_id(),"charaktere","mkr","session"); 
if($ukr < $rkr){
$geht = 0;
}
$rint = $req[3]; 
$uint = getwert(session_id(),"charaktere","mintl","session");  
if($uint < $rint){
$geht = 0;
}
$rchrk = $req[4]; 
$uchrk = getwert(session_id(),"charaktere","mchrk","session"); 
if($uchrk < $rchrk){
$geht = 0;
}
$rtmp = $req[5];
$utmp = getwert(session_id(),"charaktere","mtmp","session"); 
if($utmp < $rtmp){
$geht = 0;
}
$rgnk = $req[6]; 
$ugnk = getwert(session_id(),"charaktere","mgnk","session"); 
if($ugnk < $rgnk){
$geht = 0;
}
$rwid = $req[7]; 
$uwid = getwert(session_id(),"charaktere","mwid","session"); 
if($uwid < $rwid){
$geht = 0;
}
$hatitem = 0;          
$jitem = getwert($array[$count],"jutsus","item","id");  
if($jitem == ""){
$hatitem = 1;
}
else{            
$array2 = explode(";", trim($jitem));
$count2 = 0;
while(isset($array2[$count2])){      
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
besitzer,
angelegt
FROM
items
WHERE besitzer="'.$uid.'" AND name = "'.$array2[$count2].'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['angelegt'] == 'LHand'||$row['angelegt'] == 'RHand'||$row['angelegt'] == 'LHand&RHand'){
$hatitem = 1;
}
}
$result->close(); 
$db->close();
$count2++;
}
} 
if($hatitem == 0){
$geht = 0;
}
if($geht == 1){
$jutsus[$c3] = $array[$count];    
$jgeht[$c3] = 1;
$c3++;
}
else{   
$jutsus[$c3] = $array[$count];    
$jgeht[$c3] = 0;
$c3++;

}     
}
$count++;
}
echo '<h3>Jutsus</h3><br>';
echo '<b>Diese Jutsus lehre ich:</b><br><br>';  
if($jutsus[0] != ""){
$count = 0;
while(isset($jutsus[$count])){ 
$jname = getwert($jutsus[$count],"jutsus","name","id");   
$jbild = getwert($jutsus[$count],"jutsus","bild","id");  
$jlevel = getwert($jutsus[$count],"jutsus","level","id");  
if($jgeht[$count] == 1){
echo '<a class="sinfo" href="akademie.php?aktion=lern&jutsu='.$jutsus[$count].'&lehrer='.$lehr[$lanz].'"><img src="bilder/jutsus/'.strtolower($jbild).'a.png" width="50px" height="50px"></img><span class="spanmap">'.$jname.'</span></a> ';
}
else{   
if($ulevel < $jlevel){
$jname = $jname.'<br>Level '.$jlevel.' benötigt';
} 
$jreq = getwert($jutsus[$count],"jutsus","req","id"); 
$req = explode(";", trim($jreq));
$hrp = $req[0];      
$uhp = getwert(session_id(),"charaktere","mhp","session");
if($uhp < $hrp){           
$jname = $jname.'<br>'.$hrp.' HP.';
}
$rchr = $req[1]; 
$uchr = getwert(session_id(),"charaktere","mchakra","session");  
if($uchr < $rchr){ 
$jname = $jname.'<br>'.$rchr.' Chakra.';
}
$rkr = $req[2]; 
$ukr = getwert(session_id(),"charaktere","mkr","session"); 
if($ukr < $rkr){                     
$jname = $jname.'<br>'.$rkr.' Kraft.';
}
$rint = $req[3]; 
$uint = getwert(session_id(),"charaktere","mintl","session");  
if($uint < $rint){                             
$jname = $jname.'<br>'.$rint.' Intelligenz.';
}
$rchrk = $req[4]; 
$uchrk = getwert(session_id(),"charaktere","mchrk","session"); 
if($uchrk < $rchrk){        
$jname = $jname.'<br>'.$rchrk.' Chakrakontrolle.';
}
$rtmp = $req[5];
$utmp = getwert(session_id(),"charaktere","mtmp","session"); 
if($utmp < $rtmp){
$jname = $jname.'<br>'.$rtmp.' Tempo.';
}
$rgnk = $req[6]; 
$ugnk = getwert(session_id(),"charaktere","mgnk","session"); 
if($ugnk < $rgnk){   
$jname = $jname.'<br>'.$rgnk.' Genauigkeit.';
}
$rwid = $req[7]; 
$uwid = getwert(session_id(),"charaktere","mwid","session"); 
if($uwid < $rwid){
$jname = $jname.'<br>'.$rwid.' Widerstand.';
}
echo '<a class="sinfo" href="akademie.php?aktion=lern&jutsu='.$jutsus[$count].'&lehrer='.$lehr[$lanz].'"><img src="bilder/jutsus/'.strtolower($jbild).'.png" width="50px" height="50px"></img><span class="spanmap">'.$jname.'</span></a> ';
}
$count++;
}
echo '<br><br>';
}
else{
echo '<b class="shadow">Ich habe dir schon alles beigebracht, was ich kann.</b>';
}

//Jutsulern ende
//Elementlern
$relement = getwert($lehr[$lanz],"npc","element","id");      
if($relement != ""){
$array = explode(";", trim($uelemente));  
$count = 0;
$geht = 1;
while(isset($array[$count])){    
if($array[$count] == $relement){
$geht = 0;
}
$count++;
}
if($geht == 1&&$count < 2||$geht == 1&&$uclan == "jiongu"){
echo '<br><br><h3>Elemente</h3>';
echo '<br>';
echo 'Möchtest du das <b class="shadow">'.$relement.'</b> Element lernen?';
echo '<br><form method="post" action="akademie.php?aktion=element">';
echo '<input type="hidden" value="'.$lehr[$lanz].'" name="lehrer">'; 
echo '<input class="button" name="login" id="login" value="lernen" type="submit"></form>';
}
}

echo '</td></tr></table></center><br>';
}
$lanz++;
}
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