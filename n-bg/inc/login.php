Ihr könnt euch auch mit dem Account vom <a href="https://db-bg.de">Dragonball Browsergame</a> einloggen!
<table width="100%">
<tr>
<td width="30%" align="center">
<form method="post" action="main_login.php?aktion=login">
<table class="table">
<tr class="tdbg">
<td class="tdborder">Login
</td>
</tr>
<tr>
<td align=center> 
<div class="eingabe1">
<input class="eingabe2" name="acc" value="Accountname" onfocus="this.value=''" size="15" maxlength="30" type="text">
</div>
</td>
</tr> 
<tr>
<td align=center> 
<div class="eingabe1">
<input class="eingabe2" name="pw" id="userpass" value="Password" onfocus="this.value=''" size="15" maxlength="30" type="password">
</div>
</td>   
</tr>            
<tr>
<td align=center> 
<input type="checkbox" name="logged" value="Ja">Eingeloggt bleiben<br>
</td>
</tr>  
<tr>
<td align=center> 
<input class="button" name="login" id="login" value="Einloggen" type="submit">
</td>
</tr>   
<tr>
<td align=center> 
<a href="register.php">Registrierung</a> | <a href="pwforgot.php">Passwort vergessen</a>
</td>
</tr>   
<tr>
<td class="tdborder">                   
<img src="bilder/design/kompatibel.png"></img>                      
<br>         
<a href="info.php">Info</a>         
<br>            
<a href="https://discord.gg/PUC5MwT" target="_blank">Discord</a>   
<br>                                                                                       
<a href="statistik.php">Statistiken</a>   
<br>                     
<a href="info.php?page=impressum">Impressum</a>      
<br>      
<br>                                             
<a id="no-link" title="naruto,browsergame" href="https://www.webwiki.de/n-bg.de" target="_blank">Bei webwiki voten</a>
<br>    
<?php      
echo '<br>';
echo '<a href="online.php">Online: <b id="oid">';
$online = getanzahl(NULL,"charaktere","session","2");
echo  '('.$online.')';
echo '</b></a>';
echo '<br>';
echo '<a href="list.php">User: <b id="lid">';
$useranzahl = getanzahl($row['id'],"charaktere","id","0");
echo '('.$useranzahl.')';
echo '</b></a>';      
?>
 
</td>  
</tr>
</table>    
</form>
</td>
<td width="30%">

<table class="table">
<tr class="tdbg">
<td class="tdborder" colspan="2">Screenshots
</td>
</tr>
<?php
$t = 0;
$anzahl = 8;          
$zeile = 0;
$drin = "";
while($t < 6){    
$weiter = 0;   
while($weiter == 0){  
$weiter = 1;   
$z = rand(1,$anzahl);   
$count = 0;
while($drin[$count] != ""){
if($drin[$count] == $z){
$weiter = 0;
}
$count++;
}
}
$drin[$t] = $z;       
if($zeile == 0){
echo '<tr>';
}
$zeile++;   
echo '<td><a href="bilder/screens/screen0'.$z.'.png" target="_blank"><img height="50px" width="100px" src="bilder/screens/screen0'.$z.'.png" border="0"></a>';
if($zeile == 2){
$zeile = 0;
echo '</tr>';
}
$t++;   
}

?>
</table>
</td>
</tr>
</table>
