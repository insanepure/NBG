<?php
include '../inc/serverdaten.php';
header('Content-type: text/css');
ob_start("ob_gzhandler");
echo '.klogo{
width:500px;
height:30px;
background-image:url(../bilder/kampf/klogo.png);
}
.klogu{
width:500px;
height:30px;
background-image:url(../bilder/kampf/klogu.png);
}
.klogm{
width:500px;
min-height:340px;
height:auto !important;
height:340px;
background-image:url(../bilder/kampf/klogm.png);
}
.katk{
border:0px;
border-spacing:0px;
min-width:300px;
width:auto !important;
width:300px;
}
.katkc{
text-align:center;
}
.katkm {
height:180px;
min-width:200px;
width:auto !important;
width:200px;
}
.katkmb {
background-image:url(../bilder/kampf/katkm.png);
}
.katkl{
width:50px;
height:180px;
}
.katklb{
background-image:url(../bilder/kampf/katkl.png);
}
.katkr{
width:50px;
height:180px;
}
.katkrb{
background-image:url(../bilder/kampf/katkr.png);
}
.kbx{
width:50px;
height:50px;
display:block;
background-image:url(../bilder/kampf/kbx.png);
}
.kbbild a{
width:50px;
height:50px;
display:block;
}
.kbbild a:hover{
background-image:url(../bilder/kampf/kbh.png);
}
.ksx{
width:75px;
height:75px;
display:block;
background-image:url(../bilder/kampf/ksx.png);
}
.ksbild a{
width:75px;
height:75px;
display:block;
}
.ksbild a:hover{
background-image:url(../bilder/kampf/ksh.png);
}
.kspieler{
with:77px;
}
.kbild{
height:50px;
width:50px;
}
.ksbar{
height:10px;
width:75px;
background-image:url(../bilder/kampf/ksbar.png);
text-align:left;
}
.kshp{
height:9px;
background-image:url(../bilder/kampf/kshp.png);
}
.kschakra{
height:9px;
background-image:url(../bilder/kampf/kschakra.png);
}
.ksbc{
height:10px;
width:75px;
text-align:center;
font-size:10px
}
.kbbc{
height:10px;
width:50px;
text-align:center;
font-size:8px;
}
.kbbar{
height:10px;
width:50px;
background-image:url(../bilder/kampf/kbbar.png);
text-align:left;
}
.kbhp{
height:9px;
background-image:url(../bilder/kampf/kbhp.png);
}
.kbchakra{
height:9px;
background-image:url(../bilder/kampf/kbchakra.png);
}
.ktabelle{
width:100%;
}
.ktd{
width:50%;
vertical-align:top;
}
.ksob{
width:220px;
height:20px;
background-image:url(../bilder/kampf/kso.png);
}
.ksub{
width:220px;
height:20px;
background-image:url(../bilder/kampf/ksu.png);
}
.kpu{
width:30px;
height:30px;
background-image:url(../bilder/kampf/kpu.png);
display:block;
}
.ksmb{
width:220px;
min-height:100px;
height:auto !important;
height:100px;
background-image:url(../bilder/kampf/ksm.png);
}
.kspieler{
width:210px;
margin-left:5px;
text-align:left;
vertical-align:top;
}
.att{
font-size:11px;
}
';
echo '.jutsu
{cursor: url(../bilder/design/cursora.ani), url(../bilder/design/cursora.png), auto !important;
display:block;
height:75px;
width:75px;
color:#fff;
    color: transparent;
    text-transform: capitalize;
border: none;
cursor:url(../bilder/cursorl.cur),pointer;
}';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
bild
FROM
jutsus';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '.'.strtolower($row['bild']).'
{
background-image:url(../bilder/jutsus/'.strtolower($row['bild']).'.png);
}
.'.strtolower($row['bild']).':hover
{
background-image:url(../bilder/jutsus/'.strtolower($row['bild']).'h.png);
}
.'.strtolower($row['bild']).':active
{
background-image:url(../bilder/jutsus/'.strtolower($row['bild']).'a.png);
}';
}
$result->close();
?>