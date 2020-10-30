<?php session_start(); ?>
<?php
include 'serverdaten.php';
include 'sessionhelpers.php';
include 'funct.php';
$was = $_REQUEST['was'];
if($was == "spieler"){
$wer = $_POST['wer'];
$ukid = getwert(session_id(),"charaktere","kampfid","session");
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
kampfid,
kaktion
FROM
charaktere
where kampfid="'.$ukid.'"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$kspieler = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
$kspieler++;
if($kspieler == $wer){
if($row['kaktion'] == ""){
$text = "Wählt eine Aktion";
}
else{
$text = "Wartet";
}
}
}
$result->close(); $db->close(); 
$text = "Hallo";
$text = $wer.';'.$text;
echo $text;
}
if($was == "trade"){
did(session_id());
$userid = getwert(session_id(),"charaktere","id","session");
$trades = trade($userid);
if($trades == 0){
echo "($trades)";
}else{
echo "<BLINK><b>($trades)</b></BLINK>";
}
}
if($was == "pms"){
did(session_id());
$userid = getwert(session_id(),"charaktere","id","session");
$mails = mails($userid);
if($mails == 0){
echo "($mails)";
}else{
echo "<BLINK><b>($mails)</b></BLINK>";
}
}
if($was == "friends"){
$userid = getwert(session_id(),"charaktere","id","session");
$friends = friends($userid);
if($friends[1] == 0){
echo "(".$friends[0].")";
}
else{
echo "<BLINK><b>(".$friends[0].")</b></BLINK>";
}
}
if($was == "online"){
$online = getanzahl(NULL,"charaktere","session","2");
echo '('.$online.')';
}
if($was == "list"){
$useranzahl = getanzahl(0,"charaktere","id","0");
echo '('.$useranzahl.')';
}
if($was == "chat"){
$chato = chato(2);
echo '('.$chato.')';
}
?>