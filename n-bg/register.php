<?php                         
include 'inc/incoben.php';  
if(!$logged && $userRegisterActive)
{ 
  if($_GET['aktion'] == 'registrieren')
  {
		if(isset($_GET['id']) && isset($_GET['code']))
		{
			$result = $account->Activate($_GET['id'], $_GET['code']);
      if($result)
      {
        $error = 'Die Registrierung ist abgeschlossen. Du kannst dich nun einloggen.';
      }
      else
      {
        $error = 'Der Code oder die ID ist ungültig.';
      }
		}
		else
    {
		  $acc = $_POST['acc'];
			$pw = $_POST['pw'];
			$pw2 = $_POST['pw2'];
			$email = $_POST['email'];
			$email2 = $_POST['email2'];
      $valid = true;
      
      //Do all validation checks
    	if(!isset($_POST['regeln']))
			{
				$error = 'Du hast die Regeln nicht akzeptiert!';
        $valid = false;
			}
			else if($pw != $pw2)
			{
			  $error = 'Die Passwörter stimmen nicht überein.';
        $valid = false;
        
			}
			else if($email != $email2)
			{
				$error = 'Die E-Mails stimmen nicht überein.';
        $valid = false;
			}
			else
			{
        $resultID = $account->Register($acc, $pw, $email);
        if($resultID > 0)
        {
          $code = $account->GetCode($acc, $email);
          
          $topic = 'Registrierung';
          $content ='
              Du hast dich bei dem <a href="https://v2.n-bg.de/">Naruto Browsergame</a> mit den Account <b>'.$acc.'</b> registriert.<br/>
              Um die Registrierung abzuschließen, musst du den folgenden Link klicken.<br/>
              Wenn du den Link nicht bis zum nächsten Tag öffnest, ist der Account verschwunden und du musst dich erneut registrieren.<br/>
              <br/>
              <a href="https://v2.n-bg.de/register.php?aktion=registrieren&code='.$code.'&id='.$resultID.'">Account aktivieren.</a>
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
        else if($resultID == -1)
        {
          $error = 'Dein Accountname ist ungültig.';
        }
        else if($resultID == -2)
        {
          $error = 'Deine E-Mail ist ungültig.';
        }
        else if($resultID == -3)
        {
          $error = 'Dieser Accountname existiert bereits.';
        }
        else if($resultID == -4)
        {
          $error = 'Dieser E-Mail existiert bereits.';
        }
      }
    }
  } 
}       
include 'inc/design3.php';
echo $error;
?>
<h3>Registrierung</h3>
<br/>
Falls du schon ein Account beim <a href="https://db-bg.de">Dragonball Browsergame</a> hast, so kannst du diesen beim <a href="index.php">Einloggen</a> benutzen.
<br/>
<br/>
<form method="post" action="register.php?aktion=registrieren">
<center>
<table width="50%">
<tr>
<td width=100px align=right>Accountname:</td>
<td align=center> 
<div class="eingabe1">
<input class="eingabe2" name="acc" value="" onfocus="this.value=''" size="15" maxlength="30" type="text">
</div>
</td>
</tr> 
<tr>
<td width=100px align=right>Passwort:</td>
<td align=center> 
<div class="eingabe1">
<input class="eingabe2" name="pw" id="userpass" value="" onfocus="this.value=''" size="15" maxlength="30" type="password">
</div>
</td>   
</tr> 
<tr>
<td width=100px align=right>Passwort wiederholen:</td>
<td align=center> 
<div class="eingabe1">
<input class="eingabe2" name="pw2" id="userpass" value="" onfocus="this.value=''" size="15" maxlength="30" type="password">
</div>
</td>   
</tr>  
<tr>
<td width=100px align=right>E-Mail:</td>
<td align=center> 
<div class="eingabe1">
<input class="eingabe2" name="email" id="email" value="" onfocus="this.value=''" size="15" maxlength="60" type="text">
</div>
</td>   
</tr> 
<tr>
<td width=100px align=right>E-Mail wiederholen:</td>
<td align=center> 
<div class="eingabe1">
<input class="eingabe2" name="email2" id="email" value="" onfocus="this.value=''" size="15" maxlength="60" type="text">
</div>
</td>   
</tr>  
<tr>
<td align=center colspan="2"> 
<input type="checkbox" name="regeln" value="Ja">Ich hab die <a href="info.php?page=regeln" target="_blank">Regeln</a> gelesen und akzeptiere sie.<br>
</td>
</tr> 
<tr>
<td align=center colspan="2"> 
<input class="button" name="login" id="login" value="Registrieren" type="submit">
</td>
</tr> 
</table>
</center>
</form>                                                 
<br>      
<br>
<a href="index.php">Zurück</a>
<?php include 'inc/design2.php'; ?>