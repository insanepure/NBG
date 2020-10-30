<?php
include_once 'inc/incoben.php';
$aktion = $_GET['aktion'];
if($aktion == 'change')
{
  if(isset($_GET['id']) && isset($_GET['code']))
  {
		$id = $accountDB->EscapeString($_GET['id']);
		$result = $accountDB->Select('*','users','id = "'.$id.'"',1);
		if ($result) 
		{
      $row = $result->fetch_assoc();
      if($row['password'] == $_GET['code'])
      {
        $pw1 = $_POST['pw1'];
        $pw2 = $_POST['pw2'];
        if($pw1 == $pw2)
        {
		      $pw = $accountDB->EscapeString($pw1);
          $pw = Account::GetPassword($pw1);
		      $accountDB->Update('password="'.$pw.'"','users','id = "'.$id.'"',1);
          $error = 'Das Passwort wurde geändert.';
        }
        else
        {
          $error = 'Die Passwörter stimmen nicht überein!';
        }
      }
			$result->close();
		}
  }
}
else if($aktion == 'mail')
{
  if(isset($_POST['email']))
  {
		$email = $accountDB->EscapeString($_POST['email']);
		$result = $accountDB->Select('*','users','email = "'.$email.'"',1);
		if ($result && $result->num_rows > 0) 
		{
      $row = $result->fetch_assoc();
      
      $topic = 'Passwort ändern';
			$content ='
					Jemand hat eine Änderung des Passwortes für deinen Account <b>'.$row['login'].'</b> beantragt.<br/>
					Wenn du Passwort wirklich ändern willst, dann folge den folgenden Link.<br/>
					<br/>
					Wenn du das Passwort nicht ändern willst, ignoriere diese Mail.<br/>
					<br/>
					<br/>
					<br/>
					<a href="https://v2.n-bg.de/pwforgot.php?id='.$row['id'].'&code='.$row['password'].'">Ich möchte das Passwort ändern.</a>
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
			$result->close();
		}
  }
}
      
if(!logged_in()){
include 'inc/design3.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
$valid = false;
if(isset($_GET['id']) && isset($_GET['code']))
{
	$id = $accountDB->EscapeString($_GET['id']);
	$result = $accountDB->Select('*','users','id = "'.$id.'"',1);
	if ($result) 
	{
    $row = $result->fetch_assoc();
    if($row['password'] == $_GET['code'])
    {
      $valid = true;
    }
	}
}

if($valid)
{
  ?>
<center>
  Du musst nun dein neues Passwort im oberen Feld eingeben und im unteren Feld wiederholen.<br/><br/>
  <form method="post" action="pwforgot.php?aktion=change&id=<?php echo $_GET['id']; ?>&code=<?php echo $_GET['code']; ?>">
<div class="eingabe1">
    <input class="eingabe2" type="password" name="pw1" placeholder="Passwort">
    </div>
    <br/>
<div class="eingabe1">
    <input class="eingabe2" type="password" name="pw2" placeholder="Passwort wiederholen">
    </div>
    <br/>
    <input class="button" type="submit" value="Passwort ändern">
  </form>
</center>
  <?php
}
else
{  
  
?>
<center>
Du kannst dir hier eine E-Mail senden, um dein Passwort zu ändern.<br/>
    <br/>
  <form method="post" action="pwforgot.php?aktion=mail">
<div class="eingabe1">
    <input class="eingabe2" type="text" name="email" placeholder="E-Mail">
    </div>
    <br/>
    <input class="button" type="submit" value="Passwort vergessen">
  </form>
</center>
<?php
}
echo '<br/><a href="index.php">Zurück</a>';
}
include 'inc/design2.php'; ?>