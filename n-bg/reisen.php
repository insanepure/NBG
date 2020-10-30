<?php
include 'inc/incoben.php';
if(logged_in()){
$ziel = $_GET['ziel'];    
$wo = $_GET['wo'];     
if($wo != "weiter"&&$wo != "back"){
$wo = "weiter";
}     
$aktion = $_GET['aktion'];                        
$reise = getwert(session_id(),"charaktere","reise","session");  
$uhp = getwert(session_id(),"charaktere","hp","session");       
$urank = getwert(session_id(),"charaktere","rank","session");    
$admin = getwert(session_id(),"charaktere","admin","session");  
if($ziel == ""){
if($aktion == "direkt"){
if($reise != ""){ 
$uaktion = getwert(session_id(),"charaktere","aktion","session");    
if($uaktion == ""){          
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));       
$uid = getwert(session_id(),"charaktere","id","session");            
$rwo = getwert(session_id(),"charaktere","rwo","session");         
$ort = getwert(session_id(),"charaktere","ort","session");  
$odauer = getwert($ort,"orte","rdauer","id");
$zeit = $odauer-$rwo;      
$dauer = $zeit*15;    
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);         
$sql="UPDATE charaktere SET aktion ='Direkte Reise',aktiond ='$dauer',rweg ='weiter',aktions ='$zeit' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                  
mysqli_close($con); 
$error = 'Du reist nun direkt zum Ziel.';
}
else{
$error = "Du tust gerade etwas.";
}
}
else{
$error = "Du bist nicht auf einer Reise.";
}
}
if($aktion == "weg"){
if($reise != ""){ 
$uaktion = getwert(session_id(),"charaktere","aktion","session");    
if($uaktion == ""){                             
$weg = $_GET['weg'];         
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));       
$uid = getwert(session_id(),"charaktere","id","session");            
$rwo = getwert(session_id(),"charaktere","rwo","session");
$ulevel = getwert(session_id(),"charaktere","level","session");    
$geht = 1; 
if($wo == "back"&&$rwo == 0){  
$uaktion = "Leichter Weg";  
$dauer = 0;
}
else{ 
if($weg == "leicht"){
$uaktion = "Leichter Weg";  
$dauer = 15;
}
if($weg == "normal"){
if($uhp == 0){
$geht = 0;
}
if($urank == 'student'){
$geht = 2;
}
$uaktion = "Normaler Weg";    
$dauer = 10;
}
if($weg == "hart"){
if($uhp == 0){
$geht = 0;
}
if($urank == 'student' || $urank == 'genin' || $urank == 'nuke-nin' && $ulevel < 30){
$geht = 3;
}
$uaktion = "Harter Weg";
$dauer = 5;
}   
}    
if($geht == 1){    
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);                
$sql="UPDATE charaktere SET aktion ='$uaktion',aktiond ='$dauer',aktions ='$zeit',rweg ='$wo' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}                
mysqli_close($con); 
if($wo == "weiter"){
$error = "Die Reise geht weiter.";
}
if($wo == "back"){
$error = "Du reist zurück.";
}
}
else{
if($geht == 0){
$error = 'Du kannst nur eine leichte Reise mit so wenig HP machen.';
}
if($geht == 2){
$error = 'Als Student kannst du nur eine leichte Reise machen.';
}
if($geht == 3){
$error = 'Du musst mindestens Chuunin sein um eine harte Reise zu machen.';
}
}
}
else{
$error = "Du tust gerade etwas.";
}
}
else{
$error = "Du bist nicht auf einer Reise.";
}
}
}
if($ziel != ""){    
$ortnuke = getwert($ziel,"orte","nuke","id");   
$ortw = getwert($ziel,"orte","was","id");   
if($ortw != "reise"){  
$rank = getwert(session_id(),"charaktere","rank","session"); 
   
$ort = getwert(session_id(),"charaktere","ort","session");   
$ortreise = getwert($ort,"orte","reiseorte","id");          
$reisegeht = 0;                              
$count = 0;            
$array = explode(";", trim($ortreise));   
while(isset($array[$count])){   
if($ziel == $array[$count]){
$reisegeht = 1;
}
$count++;
}
if($aktion == "reisen"){
if($reisegeht == 1){      
$kid = getwert(session_id(),"charaktere","kampfid","session");    
if($kid == 0){   
$uaktion = getwert(session_id(),"charaktere","aktion","session");    
if($uaktion == ""){
if($reise == ""){
                        
$uid = getwert(session_id(),"charaktere","id","session");
$reisenach = $ort.';'.$ziel;      
$nort = getwert($reisenach,"orte","id","name");
if($nort == ""){           
$reisenach2 = $ziel.';'.$ort;      
$nort = getwert($reisenach2,"orte","id","name");
}
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con));    
$sql="UPDATE charaktere SET reise ='$reisenach',ort ='$nort' WHERE id = '".$uid."' LIMIT 1";
if (!mysqli_query($con, $sql))
{
die('Error: ' . mysqli_error($con));
}       
mysqli_close($con); 
$reisegeht = 0;
$error = "Reise gestartet.";
}
else{
$error = "Du reist bereits.";
}
}
else{
$error = 'Du tust bereits etwas.';
}

}
else{
$error = "Du befindest dich in einem Kampf.";
}

}
else{
$error = "Du kannst nicht zu diesen Ort reisen.";
}
}
}
}
}
if(logged_in()){
include 'inc/design1.php';
include 'inc/bbcode.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}             
if($ziel != ""){        
$ortnuke = getwert($ziel,"orte","nuke","id");   
$ortw = getwert($ziel,"orte","was","id");   
if($ortw != "reise"){         
$rank = getwert(session_id(),"charaktere","rank","session");        
if($rank == "nuke-nin"&&$ortnuke == "1"||$ortnuke == "0"||$ort == $ziel||$rank == 'admin'){                                                            
$ortn = getwert($ziel,"orte","name","id");                                                         
$ortb = getwert($ziel,"orte","bild","id");                                                     
$ortbe = getwert($ziel,"orte","beschreibung","id");                                                  
$owetter = getwert($ziel,"orte","wetter","id");                                                
$ally = getwert($ziel,"orte","ally","id");        
echo '<center><table class="table"><tr><td class="tdborder tdbg" colspan="2">'.ucwords($ortn).'</td></tr>';
echo '<tr><td>
<img src="'.$ortb.'"></img>
<div class="shadow" style="width:100px; height:100px; background:url(bilder/wetter/'.$owetter.'.png);"><br><br>'.$owetter.'</div>   

<br>
</td>'; 
echo '<td>';
echo $bbcode->parse ($ortbe);
if($ally != ''){        
echo '<br>Verbündet mit: ';                                                                  
$count = 0;       
$array = explode(";", trim($ally));   
while(isset($array[$count])){                                                               
$on = getwert($array[$count],"orte","name","id"); 
echo '<a href="reisen.php?ziel='.$array[$count].'">'.ucwords($on).'gakure </a>';                                                      
if($array[$count+1] != ''){
echo ', ';
}
$count++;
}
echo '<br>';  
echo '<br>';
}
echo '</td></tr>';   
if($reisegeht == 1){     
echo '<tr><td colspan="2">';
echo '<form method="post" action="reisen.php?ziel='.$ziel.'&aktion=reisen"><input class="button" name="login" id="login" value="Reisen" type="submit"></form><br>';
echo '</td></tr>';

} 
if($admin == 3){     
echo '<tr><td colspan="2">';
echo '<form method="post" action="admin.php?aktion=reise&wo='.$ziel.'"><input class="button" name="login" id="login" value="Adminreise" type="submit"></form>';
echo '</td></tr>';

}
echo '</table></center>'; 
}

}                                     
}
else{           
$ort = getwert(session_id(),"charaktere","ort","session");        
$ortm = getwert($ort,"orte","map","id");  
if($ortm == 0){
echo '<a href="map.php">Karte</a>';
}
else{
echo '<a href="map.php?map=event">Karte</a>';
}
echo '<center><div id="reise">';
echo '<table height="100%" width="100%">';
echo '<tr>';
echo '<td valign="center" width="33%">';
echo '<a href="reisen.php?aktion=weg&weg=leicht&wo='.$wo.'" onmouseout="hide();" onmouseover="show('."'leicht'".');">';
echo '<img border="0" src="bilder/design/rleicht.png"></img>';
echo '</a>';
echo '</td>';
echo '<td valign="center" width="34%">';
echo '<a href="reisen.php?aktion=weg&weg=normal&wo='.$wo.'" onmouseout="hide();" onmouseover="show('."'normal'".');">';
echo '<img border="0" src="bilder/design/rnormal.png"></img>';
echo '</a>';
echo '</td>';         
echo '<td valign="center" width="33%">';
echo '<a href="reisen.php?aktion=weg&weg=hart&wo='.$wo.'" onmouseout="hide();" onmouseover="show('."'hart'".');">';
echo '<img border="0" src="bilder/design/rhart.png"></img>';
echo '</a>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '</div>';
echo '<table>';
echo '<tr>';
echo '<td>';
if($wo == "weiter"){
echo '<div class="arrowlof"><a href="reisen.php?wo=back"></a></div>';
}
else{      
echo '<div class="arrowlon"><a href="reisen.php?wo=back"></a></div>';
}
echo '</td>'; 
echo '<td>';
if($wo == "back"){
echo '<div class="arrowrof"><a href="reisen.php?wo=weiter"></a></div>';
}
else{      
echo '<div class="arrowron"><a href="reisen.php?wo=weiter"></a></div>';
}         
echo '</td>'; 
echo '</tr>';
echo '</table>';
echo '<br>';
echo '<div class="weg" style="z-index:0; position:relative;">';

echo '<div class="wegd" style="position:absolute; width:';     
$rwo = getwert(session_id(),"charaktere","rwo","session");   
$ort = getwert(session_id(),"charaktere","ort","session");    
$odauer = getwert($ort,"orte","rdauer","id");   
$prozent = $rwo/$odauer;     
$wo = 200*$prozent-5;
$prozent = $prozent*100;
echo $prozent.'%" style="z-index:1;">';
echo '</div>';                  
  $mapc = getwert(session_id(),"charaktere","mapc","session");
echo '<div class="mchar'.$mapc.'" style="position:absolute; left:'.$wo.'px; z-index:2;"></div>';
echo '</div>';     
echo '<br>';  
echo '<form method="post" action="reisen.php?aktion=direkt">'; 
echo '<input class="button" name="login" id="login" value="Direkte Reise" type="submit"></form>';    
echo '</center>';   
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