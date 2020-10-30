<?php include 'header.php'; ?>
<div class="om omb">
<?php include 'oben.php'; ?>
</div>
<!-- rechts -->
<table class="main2">
<!-- Ende von Oben -->
<tr>
<!-- Rand -->
<td class="rand">
</td>
<td align="center">
  <br/>
<!-- Main -->
<?php
if($account->IsLogged() && $account->Get('id') != 1)
{
    ?>
      <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- NBG Top -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:963px;height:90px"
           data-ad-client="ca-pub-7145796878009968"
           data-ad-slot="6601247425"></ins>
      <script>
           (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    <?php
}
?>
<table class="main">
<tr>
<!-- Links (wie man schwer merkt) -->
<td class="links"  valign="top">
<div class="links ltc">
</div>
<div class="links lt">
</div>
<div class="links lm container">
<div class="lmc"> <?php include 'links.php'; ?></div>
</div>    
<div class="links lb">
</div>
</td>
<!-- Links Ende -->
<!-- Abstand :D -->
<td class="spalt">
</td>
<!-- Rechts (wie man wiederum schwer merkt) -->
<td class="rechts">
<div class="rechts rth">
</div>
<div class="rechts rt">
</div>
<div class="rechts rm container">
<div class="rechtsmitte">
<?php
$tut = getwert(session_id(),"charaktere","tutorial","session");   
$gameinfo = getwert(session_id(),"charaktere","gameinfo","session");  
if($gameinfo != ''){
echo '<div class="tutbg">';
echo '<table width="100%" height="100%"><tr><td width="30%"></td><td width="40%" align="center"><div class="tut">';   
echo '<div class="tuttext">';
echo '<table width="100%" height="100%">';
echo '<tr height="5%"><td  align="center">';
echo '<h2>Information</h2>';
echo '</td></tr>';    
echo '<tr height="90%"><td  align="center" class="gameinfo">';  
include 'inc/bbcode.php';
echo $bbcode->parse ($gameinfo);
echo '</td></tr>';  
echo '<tr height="5%"><td align="center">';  
echo '<a class="atut" href="index.php?aktion=info">Weiter</a>';  
echo '</td></tr>';    
echo '</table>';
echo '</div>';
echo '</div></td><td width="30%"></td></tr></table>';
echo '</div>';
} 
elseif($tut < 30){         
$uname = getwert(session_id(),"charaktere","name","session");   
echo '<div class="tutbg">';
echo '<table width="100%" height="100%"><tr><td width="30%"></td><td width="40%" align="center"><div class="tut">';   
echo '<div class="tuttext">';
echo '<table width="100%" height="100%">';
echo '<tr height="5%"><td  align="center">';
echo '<h2>Tutorial '.$tut.'/29</h2>';
echo '</td></tr>';    
echo '<tr height="90%"><td  align="center">';
if($tut == '0'){
echo '<li>Hallo '.$uname.'!';
echo '<li>Dies ist das Tutorial.<li>Ich werde dir das Spiel und die Funktionen erklären.';
}    
if($tut == '1'){
echo '<li>In der oberen Leiste siehst du deine Daten.';
echo '<li>Ganz links ist dein Kampfbild.';
echo '<li>Die rote Leiste ist deine HP, ist der Balken leer, dann hast du keine HP mehr!'; 
echo '<li>Die blaue Leiste ist dein Chakra, ist der Balken leer, dann kannst du keine Jutsus mehr im Kampf anwenden.';
echo '<li>Der Balken darunter ist deine Erfahrung.';
}    
if($tut == '2'){
echo '<li>Erfahrung sammelst du durch Missionen.';
echo '<li>Ist der Balken voll, steigst du ein Level auf.';
echo '<li>Sobald du ein Level aufgestiegen bist, kannst du unter "Charakter" Statspunkte verteilen.';
}
if($tut == '3'){
echo '<li>Dein Level siehst du neben den drei Balken.';
echo '<li>Darunter ist dein Platz in der Liste.';
echo '<li>Dein Platz wird nach deinem Level und deiner Erfahrung gemessen.';
}
if($tut == '4'){
echo '<li>Daneben siehst du dein Dorf und dein Geld (Ryo).';
echo '<li>Auch dein Bluterbe und dein Rank siehst du in der oberen Leiste.';
echo '<li>Je höher dein Rank ist, desto größeres Ansehen hast du im Dorf und umso bessere Missionen kannst du machen!';
}
if($tut == '5'){
echo '<li>Durch Prüfungen kannst du im Rank aufsteigen.';
echo '<li>Die erste Prüfung ist die Genin Prüfung.';
echo '<li>Die Genin Prüfung findet jeden Dienstag, Donnerstag und Samstag von 10Uhr bis 20Uhr statt.';
}
if($tut == '6'){
echo '<li>In der Mitte der oberen Leiste siehst du dein Ort.';
echo '<li>Je nach Ort kannst du verschiedene Missionen machen.';
echo '<li>Nicht in jedem Ort gibt es Händler, sei also immer voll ausgerüstet!';
}
if($tut == '7'){
echo '<li>In der rechten Hälfte der oberen Leiste sind die Buttons.';
}
if($tut == '8'){
echo '<li>Die Buttons dienen zur schnellen übersicht.';
echo '<li>Durch die Buttons kannst du zu Statistiken , Infos, Nachrichten oder Einstellungen kommen.';
}
if($tut == '9'){
echo '<li>Wenn du auf den ersten Button klickst, kommst du zu deinen Nachrichten.';
echo '<li>Dort kannst du Nachrichten lesen , schreiben und senden.';  
echo '<li>Der zweite Button ist deine Freundesliste.';
}
if($tut == '10'){
echo '<li>Der dritte Button ist der Chat.';
echo '<li>im Chat kannst du mit Usern über Gott und die Welt reden.';  
}
if($tut == '11'){
echo '<li>Der vierte Button ist die Onlineliste.';
echo '<li>Hier siehst du, wer alles online ist.';   
echo '<li>Wenn du auf den fünften Button klickst, kommst du zu den verschiedenen Listen.';
echo '<li>Hier kannst du alle User und alle Organisationen/Teams sehen.';               
echo '<li>Auch eine Suchfunktion ist enthalten!';  
}
if($tut == '12'){
echo '<li>Durch den sechsten Button kommst du zu den News.';   
echo '<li>Hier schreiben die Admins über alle Neuigkeiten und Events.';  
echo '<li>Der siebte Button führt dich zu weiteren Informationen über das Spiel.';   
}
if($tut == '13'){
echo '<li>Der achten Button ist das Forum.';   
echo '<li>Hier kannst du dich mit Usern über das Spiel oder Anderes austauschen.';  
echo '<li>Du kannst auch hier für dein Team oder deine Organisation werben!';   
}
if($tut == '14'){
echo '<li>Der neunte Button ist der Support.';    
echo '<li>Hier kannst du das Team Fragen stellen oder deine Probleme melden.'; 
echo '<li>Auch wenn ein User dich belästigt, kannst du es hier melden.';     
}
if($tut == '15'){
echo '<li>Klickst du auf den zehnten Button, dann kommst du zu den Einstellungen.';    
echo '<li>Hier kannst du deine Jutsus im Kampf einstellen, deine Chatfarbe, deine Daten oder das Design.'; 
echo '<li>Auch deinen Account kannst du hier löschen.';                                                         
echo '<li>Du solltest immer bei den Einstellungen nachschauen, wenn du ein neues Jutsu gelernt hast.';     
}
if($tut == '16'){
echo '<li>Wenn du auf den letzten Button klickst, loggst du dich aus dem Spiel aus.';  
echo '<li>Du wirst nach 15 Minuten automatisch ausgeloggt, falls du nichts im Spiel machst.';   
}
if($tut == '17'){
echo '<li>Kommen wir nun zum Hauptbereich des Spieles.';  
echo '<li>Du siehst in der Mitte links einen dünnen Balken und rechts einen dicken Balken';   
echo '<li>Wenn du auf einen Link im linken Balken klickst, erscheint im rechten Balken etwas neues.';     
echo '<li>Ich erkläre dir nun die einzelnen Funktionen der Links im linken Balken.';   
}
if($tut == '18'){
echo '<li>Unter Profil kannst du dein eigenes Profil bearbeiten, dein Kampfbild ändern und einen schönen Profiltext schreiben.';    
echo '<li>Unter Charakter siehst du deine Werte. Fahre mit der Maus über die Werte, um zu erfahren, was sie bringen.';       
echo '<li>Im Inventar siehst du, welche Items du hast und du kannst dort deine Items ausrüsten.';               
echo '<li>Um ein Item auszurüsten oder um es zu benutzen, musst du einfach auf das Item klicken.';
} 
if($tut == '19'){
echo '<li>Unter Ort siehst du das Profil des Ortes, wo du dich gerade befindest.';
echo '<li>Auch wirst du hier die Missionen ausführen können.';
echo '<li>Missionen annehmen kannst du unter Missionen.';
}  
if($tut == '20'){        
echo '<li>In der Akademie siehst du verschiedene Lehrer, die dir Jutsus beibringen.';
echo '<li>Als Student wirst du hier nur den Akademie Lehrer sehen.';
echo '<li>Sobald du Genin bist, wirst du hier deine Clanjutsus lernen können.';
} 
if($tut == '21'){        
echo '<li>In der Apotheke kannst du Items kaufen, die deine HP und dein Chakra wiederherstellen.';      
echo '<li>Im Waffenladen kannst du Waffen kaufen, die du im Inventar ausrüsten kannst.';          
echo '<li>Im Kleidungsladen kannst du Kleidung kaufen, die dich vor Angriffen schützen.';
} 
if($tut == '22'){        
echo '<li>Auf den übungsplatz kannst du deine Werte trainieren.';  
echo '<li>Eine Stunde bringt 1 Punkt in deinen Werten.';          
echo '<li>HP und Chakra bekommen 10 Punkte pro Stunde.';       
echo '<li>Solltest du dein Training abbrechen, so erHältst du Punkte für die bisherig trainierten Stunden.';         
} 
if($tut == '23'){        
echo '<li>Unter Reise kannst du zu verschiedenen Orten reisen.'; 
echo '<li>Wenn du auf Reise klickst, siehst du zunächst eine Karte mit den verschiedenen Orten.';
echo '<li>Da wo dein Mapcharakter ist, befindest du dich gerade.';
echo '<li>Rote Kreise sind Dörfer, blaue Kreise sind Orte.';
} 
if($tut == '24'){        
echo '<li>Wenn du auf einen Kreis klickst, siehst du das Profil des Ortes und kannst zum Ort reisen.';    
echo '<li>Wenn du nun auf Reisen klickst, kommst du zu einem neuen Menü.';                             
echo '<li>Du kannst dort dann zwischen drei Reisearten auswählen: Leicht,  Mittel und Hart.'; 
} 
if($tut == '25'){        
echo '<li>Wenn du auf "Leicht" reist, dauert die Reise 15 Minuten bis zum nächsten Punkt. Du wirst gegen keine Gegner ankämpfen.';   
echo '<li>Wenn du auf "Mittel" reist, dauert die Reise 10 Minuten, es besteht aber die Chance, dass du auf Gegner oder andere NPCs triffst!';  
echo '<li>Wenn du auf "Hart" reist, dauert die Reise 5 Minuten, du wirst aber mit hoher Wahrscheinlichkeit kämpfen müssen.';       
} 
if($tut == '26'){        
echo '<li>Auch wirst du dort zwei Pfeile finden.';   
echo '<li>Wenn der linke Pfeil aktiv ist, wirst du zurück reisen.';    
echo '<li>Wenn der rechte Pfeil aktiv ist, wirst du weiter reisen.';   
}
if($tut == '27'){        
echo '<li>Unter Kampf kannst du einen Kampf erstellen und den Kampflog anschauen.'; 
echo '<li>Im Kampf wirst du den Gegner angreifen, der ein X auf sein Bild hat.';        
echo '<li>Durch das Klicken auf die Jutsubilder wirst du ein Jutsu ausführen können.';  
echo '<li>Unter Turnier siehst du alle laufenden und anstehenden Turniere im Ort.';    
}
if($tut == '28'){        
echo '<li>Sobald eine Prüfung ansteht, wirst du im linken Menü die Prüfung auswählen können.';    
echo '<li>Sobald du Genin bist, wirst du im linken Menü ein Team gründen und beitreten können.';  
}
if($tut == '29'){        
echo '<li>Das war alles.';  
echo '<li>Du kannst das Tutorial unter den Einstellungen wiederholen.';  
echo '<li>Solltest du noch Fragen haben, kannst du unter Support das Team kontaktieren.';  
echo '<li>Du kannst deine Fragen aber auch im Chat stellen!';       
echo '<li>Ich wünsche dir viel Spaß im Naruto Browsergame!';     
}
echo '</td></tr>';  
echo '<tr height="5%"><td>';  
echo '<table width="100%"><tr><td width="30%"><a class="atut" href="index.php?aktion=back">Zurück</a></td><td width="40%"><a class="atut" href="index.php?aktion=skip">überspringen</a></td><td width="30%"><a class="atut" href="index.php?aktion=weiter">Weiter</a></td></tr></table>';  
echo '</td></tr>';    
echo '</table>';
echo '</div>';
echo '</div></td><td width="30%"></td></tr></table>';
echo '</div>';
}
?>