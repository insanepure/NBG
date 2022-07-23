<?php                         
include 'inc/incoben.php';  
if(!$account->IsLogged() && $userLoginActive)
{ 
  if($_GET['aktion'] == 'login')
  {
    if($account->LoginSafe($_POST['acc'], $safedPW, $_POST['logged']))
    {               
      $logged = true;
      if($account->IsValid() && $account->IsBannedInGame('NBG'))
      {
        $error = 'Du wurdest aus folgendem Grund vom Spiel gebannt: '.$account->GetBanReason().'.';
        $account->Logout();
        $logged = false;
      }
    }
    else
    {
      $error = 'Deine Anmeldedaten waren nicht korrekt!';
      header("refresh: 2; url=index.php");
    }
  } 
}

if($_GET['aktion'] == "charlogout" && logged_in()){        
setcookie("id", '',time()-10);  
logout();                                
header("refresh: 1; url=main_login.php");
$error = "Erfolgreich ausgeloggt!";
}

if($account->IsLogged())
{
if($_REQUEST['aktion'] == 'logout'){   
$account->Logout();
$error = "Erfolgreich ausgeloggt!";           
header("refresh: 1; url=index.php");
include 'inc/serverdaten.php';  
}
else if($_REQUEST['aktion'] == 'accdelete'){   
  if($account->HasAnyCharacter())
  {
    $error = 'Du musst zuerst alle Charaktere in DB-BG und N-BG löschen.<br/>';
  }
  else if(!isset($_GET['code']) && isset($_POST['logged']))
  {

    $email = $account->Get('email'); 
    $topic = 'Account löschen';
    $content ='
        Jemand möchte deinen Account <b>'.$account->Get('login').'</b> löschen.<br/>
        Wenn du deinen Account wirklich löschen willst, dann folge den folgenden Link.<br/>
        <br/>
        Wenn du den Account nicht löschen willst, ignoriere diese Mail.<br/>
        <br/>
        <br/>
        <br/>
        <a href="https://v2.n-bg.de//main_login.php?aktion=accdelete&code='.md5($account->Get('password')).'">Ich möchte den Account löschen.</a>
        <br/>
        <br/>';
    if(SendMail($email,$topic, $content))
    {
      $error = 'Es wurde eine Mail an deiner E-Mail Addresse gesendet. Schau auch im Spam-Ordner nach.';
    }
    else
    {
      $error = 'Es gab einen Fehler beim Senden der E-Mail. Bitte frage im Discord nach.';
    }
  }
  else if($_GET['code'] == md5($account->Get('password')))
  {
    $account->DeleteAccount();
    $error = 'Dein Account wurde gelöscht.';
    header("refresh: 1; url=index.php");
  }
include 'inc/serverdaten.php';  
}
else if($_REQUEST['aktion'] == 'changepw')
{          
  if($safedPW == $safedPW2)
  {
    $account->ChangePasswordSafe($safedPW);
    $error = 'Du hast dein Passwort geändert.';
  }
  else
  {
    $error = "Die Passwörter stimmen nicht überein.";
  }
}
else if($_GET['aktion'] == 'charalogin'){
$id = $_GET['id'];
if(is_numeric($id))
{
$con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
$sql = 'SELECT id,main FROM charaktere WHERE id="'.$id.'" LIMIT 1';
$result = mysqli_query($con, $sql) or die(mysqli_error($con));   
$row = mysqli_fetch_assoc($result);
if($row['main'] == $account->Get('id')){    
$ip = get_real_ip();
$sql = 'UPDATE charaktere SET session="'.session_id().'",ip="'.$ip.'" WHERE id="'.$row['id'].'" LIMIT 1';
$result = mysqli_query($con, $sql) or die(mysqli_error($con));  
if($_POST['logged'] == 'Ja'){   
setcookie("id", $id,time()+60*60*24*30);   //30 Tagee
$error = 'Du wurdest erfolgreich eingeloggt und bleibst eingeloggt!';
}
else{   
setcookie("id", '',time()-10);   
$error = 'Du wurdest erfolgreich eingeloggt!';
}  
header("refresh: 1; url=index.php");
}
mysqli_close($con);
}
}
}
include 'inc/design3.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}


if($account->IsLogged()){
?>        
<h3>Charakter Auswahl</h3>
<table width="100%">
<tr>
<?php
$count = 0;
$con = mysqli_connect($host,$user,$pw);
mysqli_select_db($con, $datenbank);     
$sql = 'SELECT id,name,level,kbild,platz,aktion,aktions,aktiond,rank, dorf, clan FROM charaktere WHERE main="'.$account->Get('id').'"';
$result = mysqli_query($con, $sql) or die(mysqli_error($con));  
while ($row = mysqli_fetch_assoc($result))
{ 
if($count == 3){
$count = 0;
?>
</tr>
<tr>
<?php } ?>
<td align="center">
<table class="table2" width="200px">
<tr>
<td class="tdbg"><?php echo $row['name']; ?></td>
</tr>     
<tr>
<td class="tdbo" height="60px">
<table><tr>
<td><img src="<?php if($row['kbild'] == '') echo '/bilder/design/nokpic.png'; else echo $row['kbild']; ?>" width="50px" height="50px"></img></td>
<td>
Platz: <?php echo $row['platz']; ?><br>
Level: <?php echo $row['level']; ?><br>
Rank: 
<?php 
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
echo $rank;
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
if($row['level'] >= 10&&$row['level'] < 30){
$rank = 'C-Rang Nuke-Nin';
}
if($row['level'] < 10){
$rank = 'D-Rang Nuke-Nin';
}       
echo $rank; 
} 
else{
echo ucwords($row['rank']);
}
?><br>
Clan: <?php echo ucwords($row['clan']); ?><br>
</td>
</tr>
<tr>
<td width="200px" height="50px">
<?php
if($row['aktion'] != ""){     
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($row['aktions']); 
$test3 = $test2-$test;
$test4 = ($row['aktiond']*60)-$test3;
$cID = $cID+1;
?>
<b> <?php echo $row['aktion']; ?></b><br>
Dauer: <b id="cID<?php echo $cID; ?>">
<?php echo " Init<script>countdown($test4,'cID$cID');</script></b><br>"; 
}
?>
</td>
</tr>
</table>
</td>
</tr>  
<tr>
<td class="tdbg tdbo">
<form method="post" action="main_login.php?aktion=charalogin&id=<?php echo $row['id']; ?>">
<input type="checkbox" name="logged" value="Ja">Eingeloggt bleiben<br>
<input class="button" name="login" id="login" value="Einloggen" type="submit">
</form></td>
</tr> 
</table>
</td>
<?php 
$count++;
}
mysqli_close($con);
?>
</tr>
</table>                                                   
<br>      
<hr>
<br/>
<a href="charregister.php">Charakter erstellen</a>     
<br>                                    
<br>      
<hr>
<br/>
<h3 class="shadow">Passwort ändern</h3>
<form method="post" action="main_login.php?aktion=changepw">
<center>
<table>
<tr>
<td>Passwort</td>
<td>
<div class="eingabe1">
<input class="eingabe2" name="pw" id="userpass1" value="" size="15" maxlength="30" type="password">
</div>
</td>
</tr>
<tr>
<td>wiederholen</td>
<td>
<div class="eingabe1">
<input class="eingabe2" name="pw2" id="userpass2" value="" size="15" maxlength="30" type="password">
</div>
</td>
</tr>
</table>
</center>
<input class="button" name="login" id="login" value="ändern" type="submit">
</form>    
<br>
<br>
<hr>
<br>
<h3 class="shadow">Account löschen</h3><br/>
<form method="post" action="main_login.php?aktion=accdelete">
<input type="checkbox" name="logged" value="Ja">Ich bin mir sicher<br>
<input class="button" name="login" id="login" value="Account Löschen" type="submit">
</form>
<br>
<br>
<hr>
<br>
<a href="main_login.php?aktion=logout">Ausloggen</a>
<?php
}
include 'inc/design2.php'; ?>