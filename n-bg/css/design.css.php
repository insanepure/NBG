<?php
session_start();
include '../inc/serverdaten.php';
header('Content-type: text/css');  
ob_start("ob_gzhandler");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
design,
session
FROM
charaktere
WHERE session = "'.session_id().'" LIMIT 1';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$design = $row['design'];
}
$result->close();
if($design == ""){
$design = "naruto";
}
echo "body { background:url(../bilder/design/$design/bg.png) repeat-x; background-color:#";
if($design == "naruto"){
echo 'f4fbff';
}
if($design == "neji"){
echo 'e0e2e4';
}
if($design == "sasuke"){
echo 'a6a1b4';
}
if($design == "rocklee"){
echo 'aec3c4';
}
if($design == "akatsuki"){
echo '0d0f0f';
}     
if($design == "chidori"){
echo '4189c0';
}         
if($design == "sakura"){
echo 'a95d68';
}
if($design == 'gaara'){
echo 'd1c3b4';
}    
if($design == 'kisame'){
echo '1f3146';
}
if($design == 'aburame'){
echo '1f3146';
}
echo ";}
.arrowlof a{   
background:url(../bilder/design/$design/arrowlof.png);     
}    
.arrowlof a:hover{   
background:url(../bilder/design/$design/arrowlh.png); 
}
.arrowlon a{  
background:url(../bilder/design/$design/arrowlon.png);  
} 
.arrowrof a{  
background:url(../bilder/design/$design/arrowrof.png);     
}    
.arrowrof a:hover{   
background:url(../bilder/design/$design/arrowrh.png); 
}
.arrowron a{  
background:url(../bilder/design/$design/arrowron.png);      
}  
.button {
background: url(../bilder/design/$design/up.png) no-repeat top left;
}   
.button:active {
background: url(../bilder/design/$design/down.png) no-repeat top left;
}
.button2 {
background: url(../bilder/design/$design/up2.png) no-repeat top left;
}   
.button2:active {
background: url(../bilder/design/$design/down2.png) no-repeat top left;
}
.button3 {
background: url(../bilder/design/$design/up3.png) no-repeat top left;
}   
.button3:active {
background: url(../bilder/design/$design/down3.png) no-repeat top left;
}
.textfield2
{
background: url(../bilder/design/$design/textfield.png) no-repeat;
}
.eingabe1
{
background: url(../bilder/design/$design/eingabe.png) no-repeat;
}
.eingabe3
{
background: url(../bilder/design/$design/eingabe2.png) no-repeat;
}
.eingabe5
{
background: url(../bilder/design/$design/eingabe3.png) no-repeat;
}
.ltc{
background:url(../bilder/design/$design/lefttopc.png);
}
.lt{
background:url(../bilder/design/$design/lefttop.png);
}
.lm{
background:url(../bilder/design/$design/leftmit.png);
}
.lb{
background:url(../bilder/design/$design/leftbot.png);
}
.rth{
background:url(../bilder/design/$design/rechtstoph.png);
}
.rt{
background:url(../bilder/design/$design/rechtstop.png);
}
.rm{
background:url(../bilder/design/$design/rechtsmit.png);
}
.rb{
background:url(../bilder/design/$design/rechtsbot.png);
}
.olb{
background:url(../bilder/design/$design/topl.png);
}
.omb{
background:url(../bilder/design/$design/topm.png);
}
.orb{
background:url(../bilder/design/$design/topr.png);
}";
if($design == "naruto"){
echo "
A:link {color: #000090; }
A:visited {color: #000090; }
A:active {color: #0000ff; }
A:hover {color: #0000ff; text-shadow: 0px 0px 5px #fff;}
A.blink{color: #f00000;}
.footer{color:#000;}
.auswahl{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #ffa74d;}
.auswahl2{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #ffa74d;}
.statsadd{color:#33bb33;}
";
}
if($design == "neji"){
echo "
A:link {color: #000090; }
A:visited {color: #000090; }
A:active {color: #0000ff; }
A:hover {color: #0000ff; text-shadow: 0px 0px 5px #fff;}
A.blink{color: #f00000;}
.footer{color:#000;}
.auswahl{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #93908d;}
.auswahl2{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #93908d;}
.statsadd{color:#33bb33;}
";
}
if($design == "sasuke"){
echo "
A:link {color: #fff; }
A:visited {color: #fff; }
A:active {color: #fff; }
A:hover {color: #000; text-shadow: 0px 0px 5px #fff;}   
A.blink{color: #f00000;}
.footer{color:#fff;}
.auswahl{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #81819f;}
.auswahl2{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #81819f;}
.statsadd{color:#33cc33;}
";
}    
if($design == "chidori"){
echo "
A:link {color: #fff; }
A:visited {color: #fff; }
A:active {color: #fff; }
A:hover {color: #000; text-shadow: 0px 0px 5px #fff;}   
A.blink{color: #f00000;}
.footer{color:#fff;}
.auswahl{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #4a84b4;}
.auswahl2{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #4a84b4;}
.statsadd{color:#33cc33;}
";
}    
if($design == "gaara"){
echo "
A:link {color: #fff; }
A:visited {color: #fff; }
A:active {color: #fff; }
A:hover {color: #000; text-shadow: 0px 0px 5px #fff;}   
A.blink{color: #f00000;}
.footer{color:#fff;}
.auswahl{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #bba288;}
.auswahl2{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #bba288;}
.statsadd{color:#33cc33;}
";
}      
if($design == "akatsuki"){
echo "
A:link {color: #fff; }
A:visited {color: #fff; }
A:active {color: #fff; }
A:hover {color: #000; text-shadow: 0px 0px 5px #fff;}   
A.blink{color: #f00000;}
.footer{color:#fff;}
.auswahl{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #8e2f38;}
.auswahl2{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #8e2f38;}
.statsadd{color:#33cc33;}
";
}
if($design == "rocklee"){
echo "
A:link {color: #000090; }
A:visited {color: #000090; }
A:active {color: #0000ff; }
A:hover {color: #0000ff; text-shadow: 0px 0px 5px #fff;}
A.blink{color: #f00000;}
.footer{color:#000;}
.auswahl{color: #000090;  background: url(../bilder/design/auswahlp.png) no-repeat right #789a91;}
.auswahl2{color: #000090;  background: url(../bilder/design/auswahlp.png) no-repeat right #789a91;}
.statsadd{color:#33cc33;}
";
}   
if($design == "aburame"){
echo "
A:link {color: #000090; }
A:visited {color: #000090; }
A:active {color: #0000ff; }
A:hover {color: #0000ff; text-shadow: 0px 0px 5px #fff;}
A.blink{color: #f00000;}
.footer{color:#000;}
.auswahl{color: #000090;  background: url(../bilder/design/auswahlp.png) no-repeat right #789a91;}
.auswahl2{color: #000090;  background: url(../bilder/design/auswahlp.png) no-repeat right #789a91;}
.statsadd{color:#33cc33;}
";
} 
if($design == "sakura"){
echo "
A:link {color: #000090; }
A:visited {color: #000090; }
A:active {color: #0000ff; }
A:hover {color: #0000ff; text-shadow: 0px 0px 5px #fff;}
A.blink{color: #f00000;}
.footer{color:#000;}
.auswahl{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #bf7a82;}
.auswahl2{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #bf7a82;}
.statsadd{color:#33bb33;}
";
}
if($design == "kisame"){
echo "
A:link {color: #fff; }
A:visited {color: #fff; }
A:active {color: #fff; }
A:hover {color: #000; text-shadow: 0px 0px 5px #fff;}   
A.blink{color: #f00000;}
.footer{color:#fff;}
.auswahl{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #62737b;}
.auswahl2{color: #fff;  background: url(../bilder/design/auswahlp.png) no-repeat right #62737b;}
.statsadd{color:#33bb33;}
";
}
?>