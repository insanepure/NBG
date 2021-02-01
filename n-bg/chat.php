<?php
include 'inc/incoben.php';
// Hier kommen Skripts hin die vorm Laden ausgeführt werden
$chat = new Chat($accountDB, session_id());
if(logged_in()){      
$game = 'NBG';
$channel = $game;
$uid = getwert(session_id(),"charaktere","id","session");
$uname = getwert(session_id(),"charaktere","name","session");   
$uadmin = getwert(session_id(),"charaktere","admin","session");  
$titel = '';
$titelColor = '';
$chat->AddUser($uid, $account->Get('id'), $game, $uname, $uadmin, $channel, session_id(), $titel, $titelColor);   
}

//HTML PART
if($chat->IsLogged()){  
?>
<?php include 'inc/header.php'; ?>
<script type="text/javascript" src="chat/chat.js?00019"></script> 
<script type="text/javascript">
var timerStart = Date.now();
window.onload = function()
{
	InitChat('');
}
function OnTextKeyDown()
{
    if(event.keyCode != 13) 
      return;
  
   SendMessage();
}
</script>
<center>
<table width="100%" height="100%" style="background-color:#DcDcDe; border: 1px solid black; border-collapse: collapse;" border="1">
  <tr height="500px">
    <td width="80%" valign="top"><div valign="top" id="chat-text" style="height:500px; overflow-y:scroll;overflow-x:hidden;"></div></td>
    <td width="20%" valign="top"><div valign="top" id="chat-users" style="height:500px; overflow-y:scroll;overflow-x:hidden;"></div></td>
  </tr>
  <tr height="20%">
  <td colspan="2" style="border-right: 1px solid #9c9c9e;">
    <table>
      <tr>
      <td><button class="button" type="button" id="chatReportButton" onclick="Report()">Melden</button></td>
      <td><button class="button" type="button" id="chatMessageButton" onclick="ClearSave()">Clear</button></td>
      <td><div class="eingabe1"><input class="eingabe2" id="chatChannel"  placeholder="Channel" size="15" maxlength="50" type="text" value="<?php echo $chat->GetChannel(); ?>"></div></td>
      <td><button class="button" type="button" id="chatChannelButton" onclick="SwitchChannel()">Wechseln</button></td>
      <td><div class="eingabe1"><input class="eingabe2" id="chatMessage"  placeholder="Text" size="15" maxlength="500" type="text" onkeydown="OnTextKeyDown()"></div></td>
      <td><button class="button" type="button" id="chatMessageButton" onclick="SendMessage()">Senden</button></td>
      </tr>
    </table>
    </td>
  <td ></td>
  </tr>
</table>
</center>
<?php
}
else
{
  ?>Du bist nicht eingeloggt.<?php
}
?>