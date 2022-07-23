<?php
include 'inc/incoben.php';
if(logged_in()){
include 'inc/design1.php';
}
else{
include 'inc/design3.php';
}
$page = $_GET['page'];
if($page == ""){
echo '<center><table width="600px">';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=skills">Skills</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=allgemeines">Allgemeines</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=missionen">Missionen</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=jutsus">Jutsus</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=krieg">Krieg</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=items">Items</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=bluterben">Bluterben</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=vg">Vertraute Geister</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=rang">Ränge</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=dorf">Dörfer</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=exam">Prüfungen</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=pus">Powerups</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=chat">Chat</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=bbcode">BB-Code</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=verlinken">Verlinkungen</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=regeln">Regeln</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=cookies">Cookies</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=dsgvo">Datenschutz</a>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=events">Events</a>';
echo '</td>';
echo '<td width="200px" align="center">';
echo '<a href="info.php?page=impressum">Impressum</a>';
echo '</td>';
echo '</tr>';
echo '</table></center>';

}
if($page == 'dsgvo')
{
  ?>
  <h1>Datenschutzerklärung</h1>
<h2 id="m14">Einleitung</h2>
<p>Mit der folgenden Datenschutzerklärung möchten wir Sie darüber aufklären, welche Arten Ihrer personenbezogenen Daten (nachfolgend auch kurz als "Daten“ bezeichnet) wir zu welchen Zwecken und in welchem Umfang verarbeiten. Die Datenschutzerklärung gilt für alle von uns durchgeführten Verarbeitungen personenbezogener Daten, sowohl im Rahmen der Erbringung unserer Leistungen als auch insbesondere auf unseren Webseiten, in mobilen Applikationen sowie innerhalb externer Onlinepräsenzen, wie z.B. unserer Social-Media-Profile (nachfolgend zusammenfassend bezeichnet als "Onlineangebot“).</p>
<ul class="m-elements"></ul><p>Stand: 19. August 2019<h2>Inhaltsübersicht</h2> <ul class="index"><li><a class="index-link" href="#m14"> Einleitung</a></li><li><a class="index-link" href="#m3"> Verantwortlicher</a></li><li><a class="index-link" href="#mOverview"> Übersicht der Verarbeitungen</a></li><li><a class="index-link" href="#m13"> Maßgebliche Rechtsgrundlagen</a></li><li><a class="index-link" href="#m27"> Sicherheitsmaßnahmen</a></li><li><a class="index-link" href="#m25"> Übermittlung und Offenbarung von personenbezogenen Daten</a></li><li><a class="index-link" href="#m24"> Datenverarbeitung in Drittländern</a></li><li><a class="index-link" href="#m134"> Einsatz von Cookies</a></li><li><a class="index-link" href="#m367"> Registrierung und Anmeldung</a></li><li><a class="index-link" href="#m182"> Kontaktaufnahme</a></li><li><a class="index-link" href="#m391"> Kommunikation via Messenger</a></li><li><a class="index-link" href="#m225"> Bereitstellung des Onlineangebotes und Webhosting</a></li><li><a class="index-link" href="#m29"> Cloud-Dienste</a></li><li><a class="index-link" href="#m17"> Newsletter und Breitenkommunikation</a></li><li><a class="index-link" href="#m263"> Webanalyse und Optimierung</a></li><li><a class="index-link" href="#m264"> Onlinemarketing</a></li><li><a class="index-link" href="#m136"> Präsenzen in sozialen Netzwerken</a></li><li><a class="index-link" href="#m328"> Plugins und eingebettete Funktionen sowie Inhalte</a></li><li><a class="index-link" href="#m12"> Löschung von Daten</a></li><li><a class="index-link" href="#m15"> Änderung und Aktualisierung der Datenschutzerklärung</a></li><li><a class="index-link" href="#m10"> Rechte der betroffenen Personen</a></li><li><a class="index-link" href="#m42"> Begriffsdefinitionen</a></li></ul><h2 id="m3">Verantwortlicher</h2> <p>André Braun<br>Obergasse 11A<br>55576 Welgesheim</p>
<p><strong>E-Mail-Adresse</strong>: <a href="mailto:p-u-r-e@hotmail.de">p-u-r-e@hotmail.de</a></p>
<ul class="m-elements"></ul><h2 id="mOverview">Übersicht der Verarbeitungen</h2><p>Die nachfolgende Übersicht fasst die Arten der verarbeiteten Daten und die Zwecke ihrer Verarbeitung zusammen und verweist auf die betroffenen Personen.</p><h3>Arten der verarbeiteten Daten</h3>
<ul><li><p>Bestandsdaten (z.B. Namen, Adressen).</p></li><li><p>Inhaltsdaten  (z.B. Texteingaben, Fotografien, Videos).</p></li><li><p>Kontaktdaten (z.B. E-Mail, Telefonnummern).</p></li><li><p>Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</p></li><li><p>Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten).</p></li><li><p>Standortdaten (Daten, die den Standort des Endgeräts eines Endnutzers angeben).</p></li></ul><h3>Kategorien betroffener Personen</h3><ul><li><p>Beschäftigte (z.B. Angestellte, Bewerber, ehemalige Mitarbeiter).</p></li><li><p>Interessenten.</p></li><li><p>Kommunikationspartner.</p></li><li><p>Kunden.</p></li><li><p>Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</p></li></ul><h3>Zwecke der Verarbeitung</h3><ul><li><p>Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit.</p></li><li><p>Besuchsaktionsauswertung.</p></li><li><p>Büro- und Organisationsverfahren.</p></li><li><p>Cross-Device Tracking (geräteübergreifende Verarbeitung von Nutzerdaten für Marketingzwecke).</p></li><li><p>Direktmarketing (z.B. per E-Mail oder postalisch).</p></li><li><p>Interessenbasiertes und verhaltensbezogenes Marketing.</p></li><li><p>Kontaktanfragen und Kommunikation.</p></li><li><p>Konversionsmessung (Messung der Effektivität von Marketingmaßnahmen).</p></li><li><p>Profiling (Erstellen von Nutzerprofilen).</p></li><li><p>Remarketing.</p></li><li><p>Reichweitenmessung (z.B. Zugriffsstatistiken, Erkennung wiederkehrender Besucher).</p></li><li><p>Sicherheitsmaßnahmen.</p></li><li><p>Tracking (z.B. interessens-/verhaltensbezogenes Profiling, Nutzung von Cookies).</p></li><li><p>Vertragliche Leistungen und Service.</p></li><li><p>Verwaltung und Beantwortung von Anfragen.</p></li><li><p>Zielgruppenbildung (Bestimmung von für Marketingzwecke relevanten Zielgruppen oder sonstige Ausgabe von Inhalten).</p></li></ul><h2></h2><h3 id="m13">Maßgebliche Rechtsgrundlagen</h3><p>Im Folgenden teilen wir die Rechtsgrundlagen der Datenschutzgrundverordnung (DSGVO), auf deren Basis wir die personenbezogenen Daten verarbeiten, mit. Bitte beachten Sie, dass zusätzlich zu den Regelungen der DSGVO die nationalen Datenschutzvorgaben in Ihrem bzw. unserem Wohn- und Sitzland gelten können.</p>
 <ul><li><p><strong>Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO)</strong> - Die betroffene Person hat ihre Einwilligung in die Verarbeitung der sie betreffenden personenbezogenen Daten für einen spezifischen Zweck oder mehrere bestimmte Zwecke gegeben.</p></li><li><p><strong>Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b. DSGVO)</strong> - Die Verarbeitung ist für die Erfüllung eines Vertrags, dessen Vertragspartei die betroffene Person ist, oder zur Durchführung vorvertraglicher Maßnahmen erforderlich, die auf Anfrage der betroffenen Person erfolgen.</p></li><li><p><strong>Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO)</strong> - Die Verarbeitung ist zur Wahrung der berechtigten Interessen des Verantwortlichen oder eines Dritten erforderlich, sofern nicht die Interessen oder Grundrechte und Grundfreiheiten der betroffenen Person, die den Schutz personenbezogener Daten erfordern, überwiegen.</p></li></ul><p><strong>Nationale Datenschutzregelungen in Deutschland</strong>: Zusätzlich zu den Datenschutzregelungen der Datenschutz-Grundverordnung gelten nationale Regelungen zum Datenschutz in Deutschland. Hierzu gehört insbesondere das Gesetz zum Schutz vor Missbrauch personenbezogener Daten bei der Datenverarbeitung (Bundesdatenschutzgesetz – BDSG). Das BDSG enthält insbesondere Spezialregelungen zum Recht auf Auskunft, zum Recht auf Löschung, zum Widerspruchsrecht, zur Verarbeitung besonderer Kategorien personenbezogener Daten, zur Verarbeitung für andere Zwecke und zur Übermittlung sowie automatisierten Entscheidungsfindung im Einzelfall einschließlich Profiling. Des Weiteren regelt es die Datenverarbeitung für Zwecke des Beschäftigungsverhältnisses (§ 26 BDSG), insbesondere im Hinblick auf die Begründung, Durchführung oder Beendigung von Beschäftigungsverhältnissen sowie die Einwilligung von Beschäftigten. Ferner können Landesdatenschutzgesetze der einzelnen Bundesländer zur Anwendung gelangen.</p>
<ul class="m-elements"></ul> <h2 id="m27">Sicherheitsmaßnahmen</h2><p>Wir treffen nach Maßgabe der gesetzlichen Vorgaben unter Berücksichtigung des Stands der Technik, der Implementierungskosten und der Art, des Umfangs, der Umstände und der Zwecke der Verarbeitung sowie der unterschiedlichen Eintrittswahrscheinlichkeiten und des Ausmaßes der Bedrohung der Rechte und Freiheiten natürlicher Personen geeignete technische und organisatorische Maßnahmen, um ein dem Risiko angemessenes Schutzniveau zu gewährleisten.</p>
<p>Zu den Maßnahmen gehören insbesondere die Sicherung der Vertraulichkeit, Integrität und Verfügbarkeit von Daten durch Kontrolle des physischen und elektronischen Zugangs zu den Daten als auch des sie betreffenden Zugriffs, der Eingabe, der Weitergabe, der Sicherung der Verfügbarkeit und ihrer Trennung. Des Weiteren haben wir Verfahren eingerichtet, die eine Wahrnehmung von Betroffenenrechten, die Löschung von Daten und Reaktionen auf die Gefährdung der Daten gewährleisten. Ferner berücksichtigen wir den Schutz personenbezogener Daten bereits bei der Entwicklung bzw. Auswahl von Hardware, Software sowie Verfahren entsprechend dem Prinzip des Datenschutzes, durch Technikgestaltung und durch datenschutzfreundliche Voreinstellungen.</p>
<p><strong>Kürzung der IP-Adresse</strong>: Sofern es uns möglich ist oder eine Speicherung der IP-Adresse nicht erforderlich ist, kürzen wir oder lassen Ihre IP-Adresse kürzen. Im Fall der Kürzung der IP-Adresse, auch als "IP-Masking" bezeichnet, wird das letzte Oktett, d.h., die letzten beiden Zahlen einer IP-Adresse, gelöscht (die IP-Adresse ist in diesem Kontext eine einem Internetanschluss durch den Online-Zugangs-Provider individuell zugeordnete Kennung). Mit der Kürzung der IP-Adresse soll die Identifizierung einer Person anhand ihrer IP-Adresse verhindert oder wesentlich erschwert werden.</p>
<p><strong>SSL-Verschlüsselung (https)</strong>: Um Ihre via unser Online-Angebot übermittelten Daten zu schützen, nutzen wir eine SSL-Verschlüsselung. Sie erkennen derart verschlüsselte Verbindungen an dem Präfix https:// in der Adresszeile Ihres Browsers.</p>
<h2 id="m25">Übermittlung und Offenbarung von personenbezogenen Daten</h2><p>Im Rahmen unserer Verarbeitung von personenbezogenen Daten kommt es vor, dass die Daten an andere Stellen, Unternehmen, rechtlich selbstständige Organisationseinheiten oder Personen übermittelt oder sie ihnen gegenüber offengelegt werden. Zu den Empfängern dieser Daten können z.B. Zahlungsinstitute im Rahmen von Zahlungsvorgängen, mit IT-Aufgaben beauftragte Dienstleister oder Anbieter von Diensten und Inhalten, die in eine Webseite eingebunden werden, gehören. In solchen Fall beachten wir die gesetzlichen Vorgaben und schließen insbesondere entsprechende Verträge bzw. Vereinbarungen, die dem Schutz Ihrer Daten dienen, mit den Empfängern Ihrer Daten ab.</p>
<h2 id="m24">Datenverarbeitung in Drittländern</h2><p>Sofern wir Daten in einem Drittland (d.h., außerhalb der Europäischen Union (EU), des Europäischen Wirtschaftsraums (EWR)) verarbeiten oder die Verarbeitung im Rahmen der Inanspruchnahme von Diensten Dritter oder der Offenlegung bzw. Übermittlung von Daten an andere Personen, Stellen oder Unternehmen stattfindet, erfolgt dies nur im Einklang mit den gesetzlichen Vorgaben. </p>
<p>Vorbehaltlich ausdrücklicher Einwilligung oder vertraglich oder gesetzlich erforderlicher Übermittlung verarbeiten oder lassen wir die Daten nur in Drittländern mit einem anerkannten Datenschutzniveau, zu denen die unter dem "Privacy-Shield" zertifizierten US-Verarbeiter gehören, oder auf Grundlage besonderer Garantien, wie z.B. vertraglicher Verpflichtung durch sogenannte Standardschutzklauseln der EU-Kommission, des Vorliegens von Zertifizierungen oder verbindlicher interner Datenschutzvorschriften, verarbeiten (Art. 44 bis 49 DSGVO, Informationsseite der EU-Kommission: <a href="https://ec.europa.eu/info/law/law-topic/data-protection/international-dimension-data-protection_de" target="_blank">https://ec.europa.eu/info/law/law-topic/data-protection/international-dimension-data-protection_de</a> ).</p>
<h2 id="m134">Einsatz von Cookies</h2><p>Als "Cookies“ werden kleine Dateien bezeichnet, die auf Geräten der Nutzer gespeichert werden. Mittels Cookies können unterschiedliche Angaben gespeichert werden. Zu den Angaben können z.B. die Spracheinstellungen auf einer Webseite, der Loginstatus, ein Warenkorb oder die Stelle, an der ein Video geschaut wurde, gehören. </p>
<p>Cookies werden im Regelfall auch dann eingesetzt, wenn die Interessen eines Nutzers oder sein Verhalten (z.B. Betrachten bestimmter Inhalte, Nutzen von Funktionen etc.) auf einzelnen Webseiten in einem Nutzerprofil gespeichert werden. Solche Profile dienen dazu, den Nutzern z.B. Inhalte anzuzeigen, die ihren potentiellen Interessen entsprechen. Dieses Verfahren wird auch als "Tracking", d.h., Nachverfolgung der potentiellen Interessen der Nutzer bezeichnet. Zu dem Begriff der Cookies zählen wir ferner andere Technologien, die die gleichen Funktionen wie Cookies erfüllen (z.B., wenn Angaben der Nutzer anhand pseudonymer Onlinekennzeichnungen gespeichert werden, auch als "Nutzer-IDs" bezeichnet).</p>
<p>Soweit wir Cookies oder "Tracking"-Technologien einsetzen, informieren wir Sie gesondert in unserer Datenschutzerklärung. </p>
<p><strong>Hinweise zu Rechtsgrundlagen: </strong> Auf welcher Rechtsgrundlage wir Ihre personenbezogenen Daten mit Hilfe von Cookies verarbeiten, hängt davon ab, ob wir Sie um eine Einwilligung bitten. Falls dies zutrifft und Sie in die Nutzung von Cookies einwilligen, ist die Rechtsgrundlage der Verarbeitung Ihrer Daten die erklärte Einwilligung. Andernfalls werden die mithilfe von Cookies verarbeiteten Daten auf Grundlage unserer berechtigten Interessen (z.B. an einem betriebswirtschaftlichen Betrieb unseres Onlineangebotes und dessen Verbesserung) verarbeitet oder, wenn der Einsatz von Cookies erforderlich ist, um unsere vertraglichen Verpflichtungen zu erfüllen.</p>
<p><strong>Widerruf und Widerspruch (Opt-Out): </strong> Unabhängig davon, ob die Verarbeitung auf Grundlage einer Einwilligung oder gesetzlichen Erlaubnis erfolgt, haben Sie jederzeit die Möglichkeit, eine erteilte Einwilligung zu widerrufen oder der Verarbeitung Ihrer Daten durch Cookie-Technologien zu widersprechen (zusammenfassend als "Opt-Out" bezeichnet).</p>
<p>Sie können Ihren Widerspruch zunächst mittels der Einstellungen Ihres Browsers erklären, z.B., indem Sie die Nutzung von Cookies deaktivieren (wobei hierdurch auch die Funktionsfähigkeit unseres Onlineangebotes eingeschränkt werden kann).</p>
<p>Ein Widerspruch gegen den Einsatz von Cookies zu Zwecken des Onlinemarketings kann mittels einer Vielzahl von Diensten, vor allem im Fall des Trackings, über die US-amerikanische Seite <a href="http://www.aboutads.info/choices/" target="_blank">http://www.aboutads.info/choices/</a> oder die EU-Seite <a href="http://www.youronlinechoices.com/" target="_blank">http://www.youronlinechoices.com/</a> oder generell auf <a href="http://optout.aboutads.info" target="_blank">http://optout.aboutads.info</a> erklärt werden.</p>
<p><strong>Verarbeitung von Cookie-Daten auf Grundlage einer Einwilligung</strong>: Bevor wir Daten im Rahmen der Nutzung von Cookies verarbeiten oder verarbeiten lassen, bitten wir die Nutzer um eine jederzeit widerrufbare Einwilligung. Bevor die Einwilligung nicht ausgesprochen wurde, werden allenfalls Cookies eingesetzt, die für den Betrieb unseres Onlineangebotes erforderlich sind. Deren Einsatz erfolgt auf der Grundlage unseres Interesses und des Interesses der Nutzer an der erwarteten Funktionsfähigkeit unseres Onlineangebotes.</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</p></li><li><p><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</p></li><li><p><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><h2 id="m367">Registrierung und Anmeldung</h2><p>Nutzer können ein Nutzerkonto anlegen. Im Rahmen der Registrierung werden den Nutzern die erforderlichen Pflichtangaben mitgeteilt und zu Zwecken der Bereitstellung des Nutzerkontos auf Grundlage vertraglicher Pflichterfüllung verarbeitet. Zu den verarbeiteten Daten gehören insbesondere die Login-Informationen (Name, Passwort sowie eine E-Mail-Adresse). Die im Rahmen der Registrierung eingegebenen Daten werden für die Zwecke der Nutzung des Nutzerkontos und dessen Zwecks verwendet. </p>
<p>Die Nutzer können über Vorgänge, die für deren Nutzerkonto relevant sind, wie z.B. technische Änderungen, per E-Mail informiert werden. Wenn Nutzer ihr Nutzerkonto gekündigt haben, werden deren Daten im Hinblick auf das Nutzerkonto, vorbehaltlich einer gesetzlichen Aufbewahrungspflicht, gelöscht. Es obliegt den Nutzern, ihre Daten bei erfolgter Kündigung vor dem Vertragsende zu sichern. Wir sind berechtigt, sämtliche während der Vertragsdauer gespeicherte Daten des Nutzers unwiederbringlich zu löschen.</p>
<p>Im Rahmen der Inanspruchnahme unserer Registrierungs- und Anmeldefunktionen sowie der Nutzung des Nutzerkontos speichern wir die IP-Adresse und den Zeitpunkt der jeweiligen Nutzerhandlung. Die Speicherung erfolgt auf Grundlage unserer berechtigten Interessen als auch jener der Nutzer an einem Schutz vor Missbrauch und sonstiger unbefugter Nutzung. Eine Weitergabe dieser Daten an Dritte erfolgt grundsätzlich nicht, es sei denn, sie ist zur Verfolgung unserer Ansprüche erforderlich oder es besteht hierzu besteht eine gesetzliche Verpflichtung.</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z.B. Namen, Adressen), Kontaktdaten (z.B. E-Mail, Telefonnummern), Inhaltsdaten  (z.B. Texteingaben, Fotografien, Videos), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</p></li><li><p><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Vertragliche Leistungen und Service, Sicherheitsmaßnahmen, Verwaltung und Beantwortung von Anfragen.</p></li><li><p><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO), Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><h2 id="m182">Kontaktaufnahme</h2><p>Bei der Kontaktaufnahme mit uns (z.B. per Kontaktformular, E-Mail, Telefon oder via soziale Medien) werden die Angaben der anfragenden Personen verarbeitet, soweit dies zur Beantwortung der Kontaktanfragen und etwaiger angefragter Maßnahmen erforderlich ist.</p>
<p>Die Beantwortung der Kontaktanfragen im Rahmen von vertraglichen oder vorvertraglichen Beziehungen erfolgt zur Erfüllung unserer vertraglichen Pflichten oder zur Beantwortung von (vor)vertraglichen Anfragen und im Übrigen auf Grundlage der berechtigten Interessen an der Beantwortung der Anfragen.</p>
<p><strong>Chat-Funktion</strong>: Zu Zwecken der Kommunikation und der Beantwortung von Anfragen bieten wir innerhalb unseres Onlineangebotes eine Chat-Funktion an. Die Eingaben der Nutzer innerhalb des Chats werden für Zwecke der Beantwortung ihrer Anfragen verarbeitet.</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z.B. Namen, Adressen), Kontaktdaten (z.B. E-Mail, Telefonnummern), Inhaltsdaten  (z.B. Texteingaben, Fotografien, Videos), Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</p></li><li><p><strong>Betroffene Personen:</strong> Kommunikationspartner, Interessenten.</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Kontaktanfragen und Kommunikation, Verwaltung und Beantwortung von Anfragen.</p></li><li><p><strong>Rechtsgrundlagen:</strong> Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><h2 id="m391">Kommunikation via Messenger</h2><p>Wir setzen zu Zwecken der Kommunikation Messenger-Dienste ein und bitten daher darum, die nachfolgenden Hinweise zur Funktionsfähigkeit der Messenger, zur Verschlüsselung, zur Nutzung der Metadaten der Kommunikation und zu Ihren Widerspruchsmöglichkeiten zu beachten.</p>
<p>Sie können uns auch auf alternativen Wegen, z.B. via Telefon oder E-Mail, kontaktieren. Bitte nutzen Sie die Ihnen mitgeteilten Kontaktmöglichkeiten oder die innerhalb unseres Onlineangebotes angegebenen Kontaktmöglichkeiten.</p>
<p>Im Fall einer Ende-zu-Ende-Verschlüsselung von Inhalten (d.h., der Inhalt Ihrer Nachricht und Anhänge) weisen wir darauf hin, dass die Kommunikationsinhalte (d.h., der Inhalt der Nachricht und angehängte Bilder) von Ende zu Ende verschlüsselt werden. Das bedeutet, dass der Inhalt der Nachrichten nicht einsehbar ist, nicht einmal durch die Messenger-Anbieter selbst. Sie sollten immer eine aktuelle Version der Messenger mit aktivierter Verschlüsselung nutzen, damit die Verschlüsselung der Nachrichteninhalte sichergestellt ist. </p>
<p>Wir weisen unsere Kommunikationspartner jedoch zusätzlich darauf hin, dass die Anbieter der Messenger zwar nicht den Inhalt einsehen, aber in Erfahrung bringen können, dass und wann Kommunikationspartner mit uns kommunizieren sowie technische Informationen zum verwendeten Gerät der Kommunikationspartner und je nach Einstellungen ihres Gerätes auch Standortinformationen (sogenannte Metadaten) verarbeitet werden.</p>
<p><strong>Hinweise zu Rechtsgrundlagen: </strong> Sofern wir Kommunikationspartner vor der Kommunikation mit ihnen via Messenger um eine Erlaubnis bitten, ist die Rechtsgrundlage unserer Verarbeitung ihrer Daten deren Einwilligung. Im Übrigen, falls wir nicht um eine Einwilligung bitten und sie z.B. von sich aus Kontakt mit uns aufnehmen, nutzen wir Messenger im Verhältnis zu unseren Vertragspartnern sowie im Rahmen der Vertragsanbahnung als eine vertragliche Maßnahme und im Fall anderer Interessenten und Kommunikationspartner auf Grundlage unserer berechtigten Interessen an einer schnellen und effizienten Kommunikation und Erfüllung der Bedürfnisse unser Kommunikationspartner an der Kommunikation via Messengern. Ferner weisen wir Sie darauf hin, dass wir die uns mitgeteilten Kontaktdaten ohne Ihre Einwilligung nicht erstmalig an die Messenger übermitteln.</p>
<p><strong>Widerruf, Widerspruch und Löschung:</strong> Sie können jederzeit eine erteilte Einwilligung widerrufen und der Kommunikation mit uns via Messenger jederzeit widersprechen. Im Fall der Kommunikation via Messenger löschen wir die Nachrichten entsprechend unseren generellen Löschrichtlinien (d.h. z.B., wie oben beschrieben, nach Ende vertraglicher Beziehungen, im Kontext von Archivierungsvorgaben etc.) und sonst, sobald wir davon ausgehen können, etwaige Auskünfte der Kommunikationspartner beantwortet zu haben, wenn kein Rückbezug auf eine vorhergehende Konversation zu erwarten ist und der Löschung keine gesetzlichen Aufbewahrungspflichten entgegenstehen.</p>
<p><strong>Vorbehalt des Verweises auf andere Kommunikationswege:</strong> Zum Abschluss möchten wir darauf hinweisen, dass wir uns aus Gründen Ihrer Sicherheit vorbehalten, Anfragen über Messenger nicht zu beantworten. Das ist der Fall, wenn z.B. Vertragsinterna besonderer Geheimhaltung bedürfen oder eine Antwort über den Messenger den formellen Ansprüchen nicht genügt. In solchen Fällen verweisen wir Sie auf adäquatere Kommunikationswege.</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Kontaktdaten (z.B. E-Mail, Telefonnummern), Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</p></li><li><p><strong>Betroffene Personen:</strong> Kommunikationspartner.</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Kontaktanfragen und Kommunikation, Direktmarketing (z.B. per E-Mail oder postalisch).</p></li><li><p><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><h2 id="m225">Bereitstellung des Onlineangebotes und Webhosting</h2><p>Um unser Onlineangebot sicher und effizient bereitstellen zu können, nehmen wir die Leistungen von einem oder mehreren Webhosting-Anbietern in Anspruch, von deren Servern (bzw. von ihnen verwalteten Servern) das Onlineangebot abgerufen werden kann. Zu diesen Zwecken können wir Infrastruktur- und Plattformdienstleistungen, Rechenkapazität, Speicherplatz und Datenbankdienste sowie Sicherheitsleistungen und technische Wartungsleistungen in Anspruch nehmen.</p>
<p>Zu den im Rahmen der Bereitstellung des Hostingangebotes verarbeiteten Daten können alle die Nutzer unseres Onlineangebotes betreffenden Angaben gehören, die im Rahmen der Nutzung und der Kommunikation anfallen. Hierzu gehören regelmäßig die IP-Adresse, die notwendig ist, um die Inhalte von Onlineangeboten an Browser ausliefern zu können, und alle innerhalb unseres Onlineangebotes oder von Webseiten getätigten Eingaben.</p>
<p><strong>E-Mail-Versand und -Hosting</strong>: Die von uns in Anspruch genommenen Webhosting-Leistungen umfassen ebenfalls den Versand, den Empfang sowie die Speicherung von E-Mails. Zu diesen Zwecken werden die Adressen der Empfänger sowie Absender als auch weitere Informationen betreffend den E-Mailversand (z.B. die beteiligten Provider) sowie die Inhalte der jeweiligen E-Mails verarbeitet. Die vorgenannten Daten können ferner zu Zwecken der Erkennung von SPAM verarbeitet werden. Wir bitten darum, zu beachten, dass E-Mails im Internet grundsätzlich nicht verschlüsselt versendet werden. Im Regelfall werden E-Mails zwar auf dem Transportweg verschlüsselt, aber (sofern kein sogenanntes Ende-zu-Ende-Verschlüsselungsverfahren eingesetzt wird) nicht auf den Servern, von denen sie abgesendet und empfangen werden. Wir können daher für den Übertragungsweg der E-Mails zwischen dem Absender und dem Empfang auf unserem Server keine Verantwortung übernehmen.</p>
<p><strong>Erhebung von Zugriffsdaten und Logfiles</strong>: Wir selbst (bzw. unser Webhostinganbieter) erheben Daten zu jedem Zugriff auf den Server (sogenannte Serverlogfiles). Zu den Serverlogfiles können die Adresse und Name der abgerufenen Webseiten und Dateien, Datum und Uhrzeit des Abrufs, übertragene Datenmengen, Meldung über erfolgreichen Abruf, Browsertyp nebst Version, das Betriebssystem des Nutzers, Referrer URL (die zuvor besuchte Seite) und im Regelfall IP-Adressen und der anfragende Provider gehören.</p>
<p>Die Serverlogfiles können zum einen zu Zwecken der Sicherheit eingesetzt werden, z.B., um eine Überlastung der Server zu vermeiden (insbesondere im Fall von missbräuchlichen Angriffen, sogenannten DDoS-Attacken) und zum anderen, um die Auslastung der Server und ihre Stabilität sicherzustellen.</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Inhaltsdaten  (z.B. Texteingaben, Fotografien, Videos), Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</p></li><li><p><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</p></li><li><p><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><h2 id="m29">Cloud-Dienste</h2><p>Wir nutzen über das Internet zugängliche und auf den Servern ihrer Anbieter ausgeführte Softwaredienste (sogenannte "Cloud-Dienste", auch bezeichnet als "Software as a Service") für die folgenden Zwecke: Dokumentenspeicherung und Verwaltung, Kalenderverwaltung, E-Mail-Versand, Tabellenkalkulationen und Präsentationen, Austausch von Dokumenten, Inhalten und Informationen mit bestimmten Empfängern oder Veröffentlichung von Webseiten, Formularen oder sonstigen Inhalten und Informationen sowie Chats und Teilnahme an Audio- und Videokonferenzen.</p>
<p>In diesem Rahmen können personenbezogenen Daten verarbeitet und auf den Servern der Anbieter gespeichert werden, soweit diese Bestandteil von Kommunikationsvorgängen mit uns sind oder von uns sonst, wie im Rahmen dieser Datenschutzerklärung dargelegt, verarbeitet werden. Zu diesen Daten können insbesondere Stammdaten und Kontaktdaten der Nutzer, Daten zu Vorgängen, Verträgen, sonstigen Prozessen und deren Inhalte gehören. Die Anbieter der Cloud-Dienste verarbeiten ferner Nutzungsdaten und Metadaten, die von ihnen zu Sicherheitszwecken und zur Serviceoptimierung verwendet werden.</p>
<p>Sofern wir mit Hilfe der Cloud-Dienste für andere Nutzer oder öffentlich zugängliche Webseiten Formulare o.a. Dokumente und Inhalte bereitstellen, können die Anbieter Cookies auf den Geräten der Nutzer für Zwecke der Webanalyse oder, um sich Einstellungen der Nutzer (z.B. im Fall der Mediensteuerung) zu merken, speichern.</p>
<p><strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir um eine Einwilligung in den Einsatz der Cloud-Dienste bitten, ist die Rechtsgrundlage der Verarbeitung die Einwilligung. Ferner kann deren Einsatz ein Bestandteil unserer (vor)vertraglichen Leistungen sein, sofern der Einsatz der Cloud-Dienste in diesem Rahmen vereinbart wurde. Ansonsten werden die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d.h., Interesse an effizienten und sicheren Verwaltungs- und Kollaborationsprozessen) verarbeitet</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z.B. Namen, Adressen), Kontaktdaten (z.B. E-Mail, Telefonnummern), Inhaltsdaten  (z.B. Texteingaben, Fotografien, Videos), Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</p></li><li><p><strong>Betroffene Personen:</strong> Kunden, Beschäftigte (z.B. Angestellte, Bewerber, ehemalige Mitarbeiter), Interessenten, Kommunikationspartner.</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Büro- und Organisationsverfahren.</p></li><li><p><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO), Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><p><strong>Eingesetzte Dienste und Diensteanbieter:</strong></p><ul class="m-elements"><li><p><strong>Google Cloud-Dienste:</strong> Cloud-Speicher-Dienste; Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, Mutterunternehmen: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Website: <a href="https://cloud.google.com/" target="_blank">https://cloud.google.com/</a>; Datenschutzerklärung: <a href="https://www.google.com/policies/privacy" target="_blank">https://www.google.com/policies/privacy</a>,  Sicherheitshinweise: <a href="https://cloud.google.com/security/privacy" target="_blank">https://cloud.google.com/security/privacy</a>; Privacy Shield (Gewährleistung Datenschutzniveau bei Verarbeitung von Daten in den USA): <a href="https://www.privacyshield.gov/participant?id=a2zt0000000000001L5AAI&status=Aktive" target="_blank">https://www.privacyshield.gov/participant?id=a2zt0000000000001L5AAI&status=Aktive</a>; Standardvertragsklauseln (Gewährleistung Datenschutzniveau bei Verarbeitung im Drittland): <a href="https://cloud.google.com/terms/data-processing-terms" target="_blank">https://cloud.google.com/terms/data-processing-terms</a>; Zusätzliche Hinweise zum Datenschutz: <a href="https://cloud.google.com/terms/data-processing-terms" target="_blank">https://cloud.google.com/terms/data-processing-terms</a>.</p></li></ul><h2 id="m17">Newsletter und Breitenkommunikation</h2><p>Wir versenden Newsletter, E-Mails und weitere elektronische Benachrichtigungen (nachfolgend "Newsletter“) nur mit der Einwilligung der Empfänger oder einer gesetzlichen Erlaubnis. Sofern im Rahmen einer Anmeldung zum Newsletter dessen Inhalte konkret umschrieben werden, sind sie für die Einwilligung der Nutzer maßgeblich. Im Übrigen enthalten unsere Newsletter Informationen zu unseren Leistungen und uns.</p>
<p>Um sich zu unseren Newslettern anzumelden, reicht es grundsätzlich aus, wenn Sie Ihre E-Mail-Adresse angeben. Wir können Sie jedoch bitten, einen Namen, zwecks persönlicher Ansprache im Newsletter, oder weitere Angaben, sofern diese für die Zwecke des Newsletters erforderlich sind, zu tätigen.</p>
<p><strong>Double-Opt-In-Verfahren:</strong> Die Anmeldung zu unserem Newsletter erfolgt grundsätzlich in einem sogenannte Double-Opt-In-Verfahren. D.h., Sie erhalten nach der Anmeldung eine E-Mail, in der Sie um die Bestätigung Ihrer Anmeldung gebeten werden. Diese Bestätigung ist notwendig, damit sich niemand mit fremden E-Mail-Adressen anmelden kann. Die Anmeldungen zum Newsletter werden protokolliert, um den Anmeldeprozess entsprechend den rechtlichen Anforderungen nachweisen zu können. Hierzu gehört die Speicherung des Anmelde- und des Bestätigungszeitpunkts als auch der IP-Adresse. Ebenso werden die Änderungen Ihrer bei dem Versanddienstleister gespeicherten Daten protokolliert.</p>
<p><strong>Löschung und Einschränkung der Verarbeitung: </strong> Wir können die ausgetragenen E-Mail-Adressen bis zu drei Jahren auf Grundlage unserer berechtigten Interessen speichern, bevor wir sie löschen, um eine ehemals gegebene Einwilligung nachweisen zu können. Die Verarbeitung dieser Daten wird auf den Zweck einer möglichen Abwehr von Ansprüchen beschränkt. Ein individueller Löschungsantrag ist jederzeit möglich, sofern zugleich das ehemalige Bestehen einer Einwilligung bestätigt wird. Im Fall von Pflichten zur dauerhaften Beachtung von Widersprüchen behalten wir uns die Speicherung der E-Mail-Adresse alleine zu diesem Zweck in einer Sperrliste (sogenannte "Blacklist") vor.</p>
<p>Die Protokollierung des Anmeldeverfahrens erfolgt auf Grundlage unserer berechtigten Interessen zu Zwecken des Nachweises seines ordnungsgemäßen Ablaufs. Soweit wir einen Dienstleister mit dem Versand von E-Mails beauftragen, erfolgt dies auf Grundlage unserer berechtigten Interessen an einem effizienten und sicheren Versandsystem.</p>
<p><strong>Hinweise zu Rechtsgrundlagen:</strong> Der Versand der Newsletter erfolgt auf Grundlage einer Einwilligung der Empfänger oder, falls eine Einwilligung nicht erforderlich ist, auf Grundlage unserer berechtigten Interessen am Direktmarketing, sofern und soweit diese gesetzlich, z.B. im Fall von Bestandskundenwerbung, erlaubt ist. Soweit wir einen Dienstleister mit dem Versand von E-Mails beauftragen, geschieht dies auf der Grundlage unserer berechtigten Interessen. Das Registrierungsverfahren wird auf der Grundlage unserer berechtigten Interessen aufgezeichnet, um nachzuweisen, dass es in Übereinstimmung mit dem Gesetz durchgeführt wurde.</p>
<p><strong>Inhalte</strong>: Informationen zu uns, unseren Leistungen, Aktionen und Angeboten.</p>
<p><strong>Erfolgsmessung</strong>: Die Newsletter enthalten einen sogenannte "web-beacon“, d.h., eine pixelgroße Datei, die beim Öffnen des Newsletters von unserem Server, bzw., sofern wir einen Versanddienstleister einsetzen, von dessen Server abgerufen wird. Im Rahmen dieses Abrufs werden zunächst technische Informationen, wie Informationen zum Browser und Ihrem System, als auch Ihre IP-Adresse und der Zeitpunkt des Abrufs, erhoben. </p>
<p>Diese Informationen werden zur technischen Verbesserung unseres Newsletters anhand der technischen Daten oder der Zielgruppen und ihres Leseverhaltens auf Basis ihrer Abruforte (die mit Hilfe der IP-Adresse bestimmbar sind) oder der Zugriffszeiten genutzt. Diese Analyse beinhaltet ebenfalls die Feststellung, ob die Newsletter geöffnet werden, wann sie geöffnet werden und welche Links geklickt werden. Diese Informationen können aus technischen Gründen zwar den einzelnen Newsletterempfängern zugeordnet werden. Es ist jedoch weder unser Bestreben noch, sofern eingesetzt, das des Versanddienstleisters, einzelne Nutzer zu beobachten. Die Auswertungen dienen uns vielmehr dazu, die Lesegewohnheiten unserer Nutzer zu erkennen und unsere Inhalte an sie anzupassen oder unterschiedliche Inhalte entsprechend den Interessen unserer Nutzer zu versenden.</p>
<p>Die Auswertung des Newsletters und die Erfolgsmessung erfolgen, vorbehaltlich einer ausdrücklichen Einwilligung der Nutzer, auf Grundlage unserer berechtigten Interessen zu Zwecken des Einsatzes eines nutzerfreundlichen sowie sicheren Newslettersystems, welches sowohl unseren geschäftlichen Interessen dient, als auch den Erwartungen der Nutzer entspricht.</p>
<p>Ein getrennter Widerruf der Erfolgsmessung ist leider nicht möglich, in diesem Fall muss das gesamte Newsletterabonnement gekündigt, bzw. muss ihm widersprochen werden.</p>
<p><strong>Voraussetzung der Inanspruchnahme kostenloser Leistungen</strong>: Die Einwilligungen in den Versand von Mailings kann als Voraussetzung zur Inanspruchnahme kostenloser Leistungen (z.B. Zugang zu bestimmten Inhalten oder Teilnahme an bestimmten Aktionen) abhängig gemacht werden. Sofern die Nutzer die kostenlose Leistung in Anspruch nehmen möchten, ohne sich zum Newsletter anzumelden, bitten wir Sie um eine Kontaktaufnahme.</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z.B. Namen, Adressen), Kontaktdaten (z.B. E-Mail, Telefonnummern), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen), Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten).</p></li><li><p><strong>Betroffene Personen:</strong> Kommunikationspartner, Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Direktmarketing (z.B. per E-Mail oder postalisch), Vertragliche Leistungen und Service.</p></li><li><p><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li><li><p><strong>Widerspruchsmöglichkeit (Opt-Out):</strong> Sie können den Empfang unseres Newsletters jederzeit kündigen, d.h. Ihre Einwilligungen widerrufen, bzw. dem weiteren Empfang widersprechen. Einen Link zur Kündigung des Newsletters finden Sie entweder am Ende eines jeden Newsletters oder können sonst eine der oben angegebenen Kontaktmöglichkeiten, vorzugswürdig E-Mail, hierzu nutzen.</p></li></ul><h2 id="m263">Webanalyse und Optimierung</h2><p>Die Webanalyse (auch als "Reichweitenmessung" bezeichnet) dient der Auswertung der Besucherströme unseres Onlineangebotes und kann Verhalten, Interessen oder demographische Informationen zu den Besuchern, wie z.B. das Alter oder das Geschlecht, als pseudonyme Werte umfassen. Mit Hilfe der Reichweitenanalyse können wir z.B. erkennen, zu welcher Zeit unser Onlineangebot oder dessen Funktionen oder Inhalte am häufigsten genutzt werden oder zur Wiederverwendung einladen. Ebenso können wir nachvollziehen, welche Bereiche der Optimierung bedürfen. </p>
<p>Neben der Webanalyse können wir auch Testverfahren einsetzen, um z.B. unterschiedliche Versionen unseres Onlineangebotes oder seiner Bestandteile zu testen und optimieren.</p>
<p>Zu diesen Zwecken können sogenannte Nutzerprofile angelegt und in einer Datei (sogenannte "Cookie") gespeichert oder ähnliche Verfahren mit dem gleichen Zweck genutzt werden. Zu diesen Angaben können z.B. betrachtete Inhalte, besuchte Webseiten und dort genutzte Elemente und technische Angaben, wie der verwendete Browser, das verwendete Computersystem sowie Angaben zu Nutzungszeiten gehören. Sofern Nutzer in die Erhebung ihrer Standortdaten eingewilligt haben, können je nach Anbieter auch diese verarbeitet werden.</p>
<p>Es werden ebenfalls die IP-Adressen der Nutzer gespeichert. Jedoch nutzen wir ein IP-Masking-Verfahren (d.h., Pseudonymisierung durch Kürzung der IP-Adresse) zum Schutz der Nutzer. Generell werden die im Rahmen von Webanalyse, A/B-Testings und Optimierung keine Klardaten der Nutzer (wie z.B. E-Mail-Adressen oder Namen) gespeichert, sondern Pseudonyme. D.h., wir als auch die Anbieter der eingesetzten Software kennen nicht die tatsächliche Identität der Nutzer, sondern nur den für Zwecke der jeweiligen Verfahren in deren Profilen gespeicherten Angaben.</p>
<p><strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir die Nutzer um deren Einwilligung in den Einsatz der Drittanbieter bitten, ist die Rechtsgrundlage der Verarbeitung von Daten die Einwilligung. Ansonsten werden die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d.h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.</p>
<ul class="m-elements"><li><p><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Reichweitenmessung (z.B. Zugriffsstatistiken, Erkennung wiederkehrender Besucher), Tracking (z.B. interessens-/verhaltensbezogenes Profiling, Nutzung von Cookies), Besuchsaktionsauswertung, Profiling (Erstellen von Nutzerprofilen).</p></li><li><p><strong>Sicherheitsmaßnahmen:</strong> IP-Masking (Pseudonymisierung der IP-Adresse).</p></li><li><p><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><h2 id="m264">Onlinemarketing</h2><p>Wir verarbeiten personenbezogene Daten zu Zwecken des Onlinemarketings, worunter insbesondere die Darstellung von werbenden und sonstigen Inhalten (zusammenfassend als "Inhalte" bezeichnet) anhand potentieller Interessen der Nutzer sowie die Messung ihrer Effektivität fallen. </p>
<p>Zu diesen Zwecken werden sogenannte Nutzerprofile angelegt und in einer Datei (sogenannte "Cookie") gespeichert oder ähnliche Verfahren genutzt, mittels derer die für die Darstellung der vorgenannten Inhalte relevante Angaben zum Nutzer gespeichert werden. Zu diesen Angaben können z.B. betrachtete Inhalte, besuchte Webseiten, genutzte Onlinenetzwerke, aber auch Kommunikationspartner und technische Angaben, wie der verwendete Browser, das verwendete Computersystem sowie Angaben zu Nutzungszeiten gehören. Sofern Nutzer in die Erhebung ihrer Standortdaten eingewilligt haben, können auch diese verarbeitet werden.</p>
<p>Es werden ebenfalls die IP-Adressen der Nutzer gespeichert. Jedoch nutzen wir IP-Masking-Verfahren (d.h., Pseudonymisierung durch Kürzung der IP-Adresse) zum Schutz der Nutzer. Generell werden im Rahmen des Onlinemarketingverfahren keine Klardaten der Nutzer (wie z.B. E-Mail-Adressen oder Namen) gespeichert, sondern Pseudonyme. D.h., wir als auch die Anbieter der Onlinemarketingverfahren kennen nicht die tatsächlich Identität der Nutzer, sondern nur die in deren Profilen gespeicherten Angaben.</p>
<p>Die Angaben in den Profilen werden im Regelfall in den Cookies oder mittels ähnlicher Verfahren gespeichert. Diese Cookies können später generell auch auf anderen Webseiten die dasselbe Onlinemarketingverfahren einsetzen, ausgelesen und zu Zwecken der Darstellung von Inhalten analysiert als auch mit weiteren Daten ergänzt und auf dem Server des Onlinemarketingverfahrensanbieters gespeichert werden.</p>
<p>Ausnahmsweise können Klardaten den Profilen zugeordnet werden. Das ist der Fall, wenn die Nutzer z.B. Mitglieder eines sozialen Netzwerks sind, dessen Onlinemarketingverfahren wir einsetzen und das Netzwerk die Profile der Nutzer im den vorgenannten Angaben verbindet. Wir bitten darum, zu beachten, dass Nutzer mit den Anbietern zusätzliche Abreden, z.B. durch Einwilligung im Rahmen der Registrierung, treffen können.</p>
<p>Wir erhalten grundsätzlich nur Zugang zu zusammengefassten Informationen über den Erfolg unserer Werbeanzeigen. Jedoch können wir im Rahmen sogenannter Konversionsmessungen prüfen, welche unserer Onlinemarketingverfahren zu einer sogenannten Konversion geführt haben, d.h. z.B., zu einem Vertragsschluss mit uns. Die Konversionsmessung wird alleine zur Analyse des Erfolgs unserer Marketingmaßnahmen verwendet.</p>
<p><strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir die Nutzer um deren Einwilligung in den Einsatz der Drittanbieter bitten, ist die Rechtsgrundlage der Verarbeitung von Daten die Einwilligung. Ansonsten werden die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d.h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.</p>
<p><strong>Facebook-Pixel</strong>: Mit Hilfe des Facebook-Pixels ist es Facebook zum einen möglich, die Besucher unseres Onlineangebotes als Zielgruppe für die Darstellung von Anzeigen (sogenannte "Facebook-Ads") zu bestimmen. Dementsprechend setzen wir das Facebook-Pixel ein, um die durch uns geschalteten Facebook-Ads nur solchen Facebook-Nutzern anzuzeigen, die auch ein Interesse an unserem Onlineangebot gezeigt haben oder die bestimmte Merkmale (z.B. Interesse an bestimmten Themen oder Produkten, die anhand der besuchten Webseiten ersichtlich werden) aufweisen, die wir an Facebook übermitteln (sogenannte "Custom Audiences“). Mit Hilfe des Facebook-Pixels möchten wir auch sicherstellen, dass unsere Facebook-Ads dem potentiellen Interesse der Nutzer entsprechen und nicht belästigend wirken. Mit Hilfe des Facebook-Pixels können wir ferner die Wirksamkeit der Facebook-Werbeanzeigen für statistische und Marktforschungszwecke nachvollziehen, indem wir sehen, ob Nutzer nach dem Klick auf eine Facebook-Werbeanzeige auf unsere Webseite weitergeleitet wurden (sogenannte "Konversionsmessung“).</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen), Standortdaten (Daten, die den Standort des Endgeräts eines Endnutzers angeben).</p></li><li><p><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten), Interessenten.</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Tracking (z.B. interessens-/verhaltensbezogenes Profiling, Nutzung von Cookies), Remarketing, Besuchsaktionsauswertung, Interessenbasiertes und verhaltensbezogenes Marketing, Profiling (Erstellen von Nutzerprofilen), Konversionsmessung (Messung der Effektivität von Marketingmaßnahmen), Reichweitenmessung (z.B. Zugriffsstatistiken, Erkennung wiederkehrender Besucher), Zielgruppenbildung (Bestimmung von für Marketingzwecke relevanten Zielgruppen oder sonstige Ausgabe von Inhalten), Cross-Device Tracking (geräteübergreifende Verarbeitung von Nutzerdaten für Marketingzwecke).</p></li><li><p><strong>Sicherheitsmaßnahmen:</strong> IP-Masking (Pseudonymisierung der IP-Adresse).</p></li><li><p><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li><li><p><strong>Widerspruchsmöglichkeit (Opt-Out):</strong> Wir verweisen auf die Datenschutzhinweise der jeweiligen Anbieter und die zu den Anbietern angegebenen Widerspruchsmöglichkeiten (sog. \"Opt-Out\"). Sofern keine explizite Opt-Out-Möglichkeit angegeben wurde, besteht zum einen die Möglichkeit, dass Sie Cookies in den Einstellungen Ihres Browsers abschalten. Hierdurch können jedoch Funktionen unseres Onlineangebotes eingeschränkt werden. Wir empfehlen daher zusätzlich die folgenden Opt-Out-Möglichkeiten, die zusammenfassend auf jeweilige Gebiete gerichtet angeboten werden:

a) Europa: <a href="https://www.youronlinechoices.eu" target="_blank">https://www.youronlinechoices.eu</a>.  
b) Kanada: <a href="https://www.youradchoices.ca/choices" target="_blank">https://www.youradchoices.ca/choices</a>. 
c) USA: <a href="https://www.aboutads.info/choices" target="_blank">https://www.aboutads.info/choices</a>. 
d) Gebietsübergreifend: <a href="http://optout.aboutads.info" target="_blank">http://optout.aboutads.info</a>.</p></li></ul><p><strong>Eingesetzte Dienste und Diensteanbieter:</strong></p><ul class="m-elements"><li><p><strong>Google Tag Manager:</strong> Google Tag Manager ist eine Lösung, mit der wir sog. Website-Tags über eine Oberfläche verwalten können (und so z.B. Google Analytics sowie andere Google-Marketing-Dienste in unser Onlineangebot einbinden). Der Tag Manager selbst (welches die Tags implementiert) verarbeitet keine personenbezogenen Daten der Nutzer. Im Hinblick auf die Verarbeitung der personenbezogenen Daten der Nutzer wird auf die folgenden Angaben zu den Google-Diensten verwiesen. Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, Mutterunternehmen: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Website: <a href="https://marketingplatform.google.com" target="_blank">https://marketingplatform.google.com</a>; Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>; Privacy Shield (Gewährleistung Datenschutzniveau bei Verarbeitung von Daten in den USA): <a href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active" target="_blank">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active</a>.</p></li> <li><p><strong>Google Analytics:</strong> Onlinemarketing und Webanalyse; Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, Mutterunternehmen: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Website: <a href="https://marketingplatform.google.com/intl/de/about/analytics/" target="_blank">https://marketingplatform.google.com/intl/de/about/analytics/</a>; Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>; Privacy Shield (Gewährleistung Datenschutzniveau bei Verarbeitung von Daten in den USA): <a href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active" target="_blank">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active</a>; Widerspruchsmöglichkeit (Opt-Out): Opt-Out-Plugin: <a href="http://tools.google.com/dlpage/gaoptout?hl=de" target="_blank">http://tools.google.com/dlpage/gaoptout?hl=de</a>,  Einstellungen für die Darstellung von Werbeeinblendungen: <a href="https://adssettings.google.com/authenticated" target="_blank">https://adssettings.google.com/authenticated</a>.</p></li> <li><p><strong>Facebook-Pixel:</strong> Facebook-Pixel; Dienstanbieter: <a href="https://www.facebook.com" target="_blank">https://www.facebook.com</a>, Facebook Ireland Ltd., 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland, Mutterunternehmen: Facebook, 1 Hacker Way, Menlo Park, CA 94025, USA; Website: <a href="https://www.facebook.com" target="_blank">https://www.facebook.com</a>; Datenschutzerklärung: <a href="https://www.facebook.com/about/privacy" target="_blank">https://www.facebook.com/about/privacy</a>; Privacy Shield (Gewährleistung Datenschutzniveau bei Verarbeitung von Daten in den USA): <a href="https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&status=Active" target="_blank">https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&status=Active</a>; Widerspruchsmöglichkeit (Opt-Out): <a href="https://www.facebook.com/settings?tab=ads" target="_blank">https://www.facebook.com/settings?tab=ads</a>.</p></li></ul><h2 id="m136">Präsenzen in sozialen Netzwerken</h2><p>Wir unterhalten Onlinepräsenzen innerhalb sozialer Netzwerke, um mit den dort aktiven Nutzern zu kommunizieren oder um dort Informationen über uns anzubieten.</p>
<p>Wir weisen darauf hin, dass dabei Daten der Nutzer außerhalb des Raumes der Europäischen Union verarbeitet werden können. Hierdurch können sich für die Nutzer Risiken ergeben, weil so z.B. die Durchsetzung der Rechte der Nutzer erschwert werden könnte. Im Hinblick auf US-Anbieter, die unter dem Privacy-Shield zertifiziert sind oder vergleichbare Garantien eines sicheren Datenschutzniveaus bieten, weisen wir darauf hin, dass sie sich damit verpflichten, die Datenschutzstandards der EU einzuhalten.</p>
<p>Ferner werden die Daten der Nutzer innerhalb sozialer Netzwerke im Regelfall für Marktforschungs- und Werbezwecke verarbeitet. So können z.B. anhand des Nutzungsverhaltens und sich daraus ergebender Interessen der Nutzer Nutzungsprofile erstellt werden. Die Nutzungsprofile können wiederum verwendet werden, um z.B. Werbeanzeigen innerhalb und außerhalb der Netzwerke zu schalten, die mutmaßlich den Interessen der Nutzer entsprechen. Zu diesen Zwecken werden im Regelfall Cookies auf den Rechnern der Nutzer gespeichert, in denen das Nutzungsverhalten und die Interessen der Nutzer gespeichert werden. Ferner können in den Nutzungsprofilen auch Daten unabhängig der von den Nutzern verwendeten Geräte gespeichert werden (insbesondere, wenn die Nutzer Mitglieder der jeweiligen Plattformen sind und bei diesen eingeloggt sind).</p>
<p>Für eine detaillierte Darstellung der jeweiligen Verarbeitungsformen und der Widerspruchsmöglichkeiten (Opt-Out) verweisen wir auf die Datenschutzerklärungen und Angaben der Betreiber der jeweiligen Netzwerke.</p>
<p>Auch im Fall von Auskunftsanfragen und der Geltendmachung von Betroffenenrechten weisen wir darauf hin, dass diese am effektivsten bei den Anbietern geltend gemacht werden können. Nur die Anbieter haben jeweils Zugriff auf die Daten der Nutzer und können direkt entsprechende Maßnahmen ergreifen und Auskünfte geben. Sollten Sie dennoch Hilfe benötigen, dann können Sie sich an uns wenden.</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Bestandsdaten (z.B. Namen, Adressen), Kontaktdaten (z.B. E-Mail, Telefonnummern), Inhaltsdaten  (z.B. Texteingaben, Fotografien, Videos), Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen).</p></li><li><p><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Kontaktanfragen und Kommunikation, Tracking (z.B. interessens-/verhaltensbezogenes Profiling, Nutzung von Cookies), Remarketing, Reichweitenmessung (z.B. Zugriffsstatistiken, Erkennung wiederkehrender Besucher).</p></li><li><p><strong>Rechtsgrundlagen:</strong> Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><p><strong>Eingesetzte Dienste und Diensteanbieter:</strong></p><ul class="m-elements"><li><p><strong>Instagram :</strong> Soziales Netzwerk; Dienstanbieter: Instagram Inc., 1601 Willow Road, Menlo Park, CA, 94025, USA; Website: <a href="https://www.instagram.com" target="_blank">https://www.instagram.com</a>; Datenschutzerklärung: <a href="http://instagram.com/about/legal/privacy" target="_blank">http://instagram.com/about/legal/privacy</a>.</p></li> <li><p><strong>Facebook:</strong> Soziales Netzwerk; Dienstanbieter: Facebook Ireland Ltd., 4 Grand Canal Square, Grand Canal Harbour, Dublin 2, Irland, Mutterunternehmen: Facebook, 1 Hacker Way, Menlo Park, CA 94025, USA; Website: <a href="https://www.facebook.com" target="_blank">https://www.facebook.com</a>; Datenschutzerklärung: <a href="https://www.facebook.com/about/privacy" target="_blank">https://www.facebook.com/about/privacy</a>; Privacy Shield (Gewährleistung Datenschutzniveau bei Verarbeitung von Daten in den USA): <a href="https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&status=Active" target="_blank">https://www.privacyshield.gov/participant?id=a2zt0000000GnywAAC&status=Active</a>; Widerspruchsmöglichkeit (Opt-Out): Einstellungen für Werbeanzeigen: <a href="https://www.facebook.com/settings?tab=ads" target="_blank">https://www.facebook.com/settings?tab=ads</a>; Zusätzliche Hinweise zum Datenschutz: Vereinbarung über gemeinsame Verarbeitung personenbezogener Daten auf Facebook-Seiten: <a href="https://www.facebook.com/legal/terms/page_controller_addendum" target="_blank">https://www.facebook.com/legal/terms/page_controller_addendum</a>, Datenschutzhinweise für Facebook-Seiten: <a href="https://www.facebook.com/legal/terms/information_about_page_insights_data" target="_blank">https://www.facebook.com/legal/terms/information_about_page_insights_data</a>.</p></li> <li><p><strong>YouTube:</strong> Soziales Netzwerk; Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, Mutterunternehmen: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>; Privacy Shield (Gewährleistung Datenschutzniveau bei Verarbeitung von Daten in den USA): <a href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active" target="_blank">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active</a>; Widerspruchsmöglichkeit (Opt-Out): <a href="https://adssettings.google.com/authenticated" target="_blank">https://adssettings.google.com/authenticated</a>.</p></li></ul><h2 id="m328">Plugins und eingebettete Funktionen sowie Inhalte</h2><p>Wir binden in unser Onlineangebot Funktions- und Inhaltselemente ein, die von den Servern ihrer jeweiligen Anbieter (nachfolgend bezeichnet als "Drittanbieter”) bezogen werden. Dabei kann es sich zum Beispiel um Grafiken, Videos oder Social-Media-Schaltflächen sowie Beiträge handeln (nachfolgend einheitlich bezeichnet als "Inhalte”).</p>
<p>Die Einbindung setzt immer voraus, dass die Drittanbieter dieser Inhalte die IP-Adresse der Nutzer verarbeiten, da sie ohne die IP-Adresse die Inhalte nicht an deren Browser senden könnten. Die IP-Adresse ist damit für die Darstellung dieser Inhalte oder Funktionen erforderlich. Wir bemühen uns, nur solche Inhalte zu verwenden, deren jeweilige Anbieter die IP-Adresse lediglich zur Auslieferung der Inhalte verwenden. Drittanbieter können ferner sogenannte Pixel-Tags (unsichtbare Grafiken, auch als "Web Beacons" bezeichnet) für statistische oder Marketingzwecke verwenden. Durch die "Pixel-Tags" können Informationen, wie der Besucherverkehr auf den Seiten dieser Webseite, ausgewertet werden. Die pseudonymen Informationen können ferner in Cookies auf dem Gerät der Nutzer gespeichert werden und unter anderem technische Informationen zum Browser und zum Betriebssystem, zu verweisenden Webseiten, zur Besuchszeit sowie weitere Angaben zur Nutzung unseres Onlineangebotes enthalten als auch mit solchen Informationen aus anderen Quellen verbunden werden.</p>
<p><strong>Hinweise zu Rechtsgrundlagen:</strong> Sofern wir die Nutzer um deren Einwilligung in den Einsatz der Drittanbieter bitten, ist die Rechtsgrundlage der Verarbeitung von Daten die Einwilligung. Ansonsten werden die Daten der Nutzer auf Grundlage unserer berechtigten Interessen (d.h. Interesse an effizienten, wirtschaftlichen und empfängerfreundlichen Leistungen) verarbeitet. In diesem Zusammenhang möchten wir Sie auch auf die Informationen zur Verwendung von Cookies in dieser Datenschutzerklärung hinweisen.</p>
<ul class="m-elements"><li><p><strong>Verarbeitete Datenarten:</strong> Nutzungsdaten  (z.B. besuchte Webseiten, Interesse an Inhalten, Zugriffszeiten), Meta-/Kommunikationsdaten (z.B. Geräte-Informationen, IP-Adressen), Bestandsdaten (z.B. Namen, Adressen), Kontaktdaten (z.B. E-Mail, Telefonnummern), Inhaltsdaten  (z.B. Texteingaben, Fotografien, Videos).</p></li><li><p><strong>Betroffene Personen:</strong> Nutzer (z.B. Webseitenbesucher, Nutzer von Onlinediensten).</p></li><li><p><strong>Zwecke der Verarbeitung:</strong> Bereitstellung unseres Onlineangebotes und Nutzerfreundlichkeit, Vertragliche Leistungen und Service, Sicherheitsmaßnahmen, Verwaltung und Beantwortung von Anfragen.</p></li><li><p><strong>Rechtsgrundlagen:</strong> Einwilligung (Art. 6 Abs. 1 S. 1 lit. a DSGVO), Vertragserfüllung und vorvertragliche Anfragen (Art. 6 Abs. 1 S. 1 lit. b. DSGVO), Berechtigte Interessen (Art. 6 Abs. 1 S. 1 lit. f. DSGVO).</p></li></ul><p><strong>Eingesetzte Dienste und Diensteanbieter:</strong></p><ul class="m-elements"><li><p><strong>YouTube:</strong> Videos; Dienstanbieter: Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, Mutterunternehmen: Google LLC, 1600 Amphitheatre Parkway, Mountain View, CA 94043, USA; Website: <a href="https://www.youtube.com" target="_blank">https://www.youtube.com</a>; Datenschutzerklärung: <a href="https://policies.google.com/privacy" target="_blank">https://policies.google.com/privacy</a>; Privacy Shield (Gewährleistung Datenschutzniveau bei Verarbeitung von Daten in den USA): <a href="https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active" target="_blank">https://www.privacyshield.gov/participant?id=a2zt000000001L5AAI&status=Active</a>; Widerspruchsmöglichkeit (Opt-Out): Opt-Out-Plugin: <a href="http://tools.google.com/dlpage/gaoptout?hl=de" target="_blank">http://tools.google.com/dlpage/gaoptout?hl=de</a>,  Einstellungen für die Darstellung von Werbeeinblendungen: <a href="https://adssettings.google.com/authenticated" target="_blank">https://adssettings.google.com/authenticated</a>.</p></li></ul><h2 id="m12">Löschung von Daten</h2><p>Die von uns verarbeiteten Daten werden nach Maßgabe der gesetzlichen Vorgaben gelöscht, sobald deren zur Verarbeitung erlaubten Einwilligungen widerrufen werden oder sonstige Erlaubnisse entfallen (z.B., wenn der Zweck der Verarbeitung dieser Daten entfallen ist oder sie für den Zweck nicht erforderlich sind).</p>
<p>Sofern die Daten nicht gelöscht werden, weil sie für andere und gesetzlich zulässige Zwecke erforderlich sind, wird deren Verarbeitung auf diese Zwecke beschränkt. D.h., die Daten werden gesperrt und nicht für andere Zwecke verarbeitet. Das gilt z.B. für Daten, die aus handels- oder steuerrechtlichen Gründen aufbewahrt werden müssen oder deren Speicherung zur Geltendmachung, Ausübung oder Verteidigung von Rechtsansprüchen oder zum Schutz der Rechte einer anderen natürlichen oder juristischen Person erforderlich ist.</p>
<p>Weitere Hinweise zu der Löschung von personenbezogenen Daten können ferner im Rahmen der einzelnen Datenschutzhinweise dieser Datenschutzerklärung erfolgen.</p>
<ul class="m-elements"></ul><h2 id="m15">Änderung und Aktualisierung der Datenschutzerklärung</h2><p>Wir bitten Sie, sich regelmäßig über den Inhalt unserer Datenschutzerklärung zu informieren. Wir passen die Datenschutzerklärung an, sobald die Änderungen der von uns durchgeführten Datenverarbeitungen dies erforderlich machen. Wir informieren Sie, sobald durch die Änderungen eine Mitwirkungshandlung Ihrerseits (z.B. Einwilligung) oder eine sonstige individuelle Benachrichtigung erforderlich wird.</p>
<h2 id="m10">Rechte der betroffenen Personen</h2><p>Ihnen stehen als Betroffene nach der DSGVO verschiedene Rechte zu, die sich insbesondere aus Art. 15 bis 18 und 21 DS-GVO ergeben:</p><ul><li><strong>Widerspruchsrecht: Sie haben das Recht, aus Gründen, die sich aus Ihrer besonderen Situation ergeben, jederzeit gegen die Verarbeitung der Sie betreffenden personenbezogenen Daten, die aufgrund von Art. 6 Abs. 1 lit. e oder f DSGVO erfolgt, Widerspruch einzulegen; dies gilt auch für ein auf diese Bestimmungen gestütztes Profiling. Werden die Sie betreffenden personenbezogenen Daten verarbeitet, um Direktwerbung zu betreiben, haben Sie das Recht, jederzeit Widerspruch gegen die Verarbeitung der Sie betreffenden personenbezogenen Daten zum Zwecke derartiger Werbung einzulegen; dies gilt auch für das Profiling, soweit es mit solcher Direktwerbung in Verbindung steht.</strong></li><li><strong>Widerrufsrecht bei Einwilligungen:</strong> Sie haben das Recht, erteilte Einwilligungen jederzeit zu widerrufen.</li><li><strong>Auskunftsrecht:</strong> Sie haben das Recht, eine Bestätigung darüber zu verlangen, ob betreffende Daten verarbeitet werden und auf Auskunft über diese Daten sowie auf weitere Informationen und Kopie der Daten entsprechend den gesetzlichen Vorgaben.</li><li><strong>Recht auf Berichtigung:</strong> Sie haben entsprechend den gesetzlichen Vorgaben das Recht, die Vervollständigung der Sie betreffenden Daten oder die Berichtigung der Sie betreffenden unrichtigen Daten zu verlangen.</li><li><strong>Recht auf Löschung und Einschränkung der Verarbeitung:</strong> Sie haben nach Maßgabe der gesetzlichen Vorgaben das Recht, zu verlangen, dass Sie betreffende Daten unverzüglich gelöscht werden, bzw. alternativ nach Maßgabe der gesetzlichen Vorgaben eine Einschränkung der Verarbeitung der Daten zu verlangen.</li><li><strong>Recht auf Datenübertragbarkeit:</strong> Sie haben das Recht, Sie betreffende Daten, die Sie uns bereitgestellt haben, nach Maßgabe der gesetzlichen Vorgaben in einem strukturierten, gängigen und maschinenlesbaren Format zu erhalten oder deren Übermittlung an einen anderen Verantwortlichen zu fordern.</li><li><strong>Beschwerde bei Aufsichtsbehörde:</strong> Sie haben ferner nach Maßgabe der gesetzlichen Vorgaben das Recht,  bei einer Aufsichtsbehörde, insbesondere in dem Mitgliedstaat Ihres gewöhnlichen Aufenthaltsorts, Ihres Arbeitsplatzes oder des Orts des mutmaßlichen Verstoßes, wenn Sie der Ansicht sind, dass die Verarbeitung der Sie betreffenden personenbezogenen Daten gegen die DSGVO verstößt.</li></ul>
<h2 id="m42">Begriffsdefinitionen</h2><p>In diesem Abschnitt erhalten Sie eine Übersicht über die in dieser Datenschutzerklärung verwendeten Begrifflichkeiten. Viele der Begriffe sind dem Gesetz entnommen und vor allem im Art. 4 DSGVO definiert. Die gesetzlichen Definitionen sind verbindlich. Die nachfolgenden Erläuterungen sollen dagegen vor allem dem Verständnis dienen. Die Begriffe sind alphabetisch sortiert.</p>
 <ul class="glossary"><li><strong>Besuchsaktionsauswertung:</strong> "Besuchsaktionsauswertung" (englisch "Conversion Tracking") bezeichnet ein Verfahren, mit dem die Wirksamkeit von Marketingmaßnahmen festgestellt werden kann. Dazu wird im Regelfall ein Cookie auf den Geräten der Nutzer innerhalb der Webseiten, auf denen die Marketingmaßnahmen erfolgen, gespeichert und dann erneut auf der Zielwebseite abgerufen. Beispielsweise können wir so nachvollziehen, ob die von uns auf anderen Webseiten geschalteten Anzeigen erfolgreich waren). </li><li><strong>Cross-Device Tracking:</strong> Das Cross-Device Tracking ist eine Form des Trackings, bei der Verhaltens- und Interessensinformationen der Nutzer geräteübergreifend in sogenannten Profilen erfasst werden, indem den Nutzern eine Onlinekennung zugeordnet wird. Hierdurch können die Nutzerinformationen unabhängig von verwendeten Browsern oder Geräten (z.B. Mobiltelefonen oder Desktopcomputern) im Regelfall für Marketingzwecke analysiert werden. Die Onlinekennung ist bei den meisten Anbietern nicht mit Klardaten, wie Namen, Postadressen oder E-Mail-Adressen, verknüpft. </li><li><strong>IP-Masking:</strong> Als "IP-Masking” wird eine Methode bezeichnet, bei der das letzte Oktett, d.h., die letzten beiden Zahlen einer IP-Adresse, gelöscht wird, damit die IP-Adresse nicht mehr der eindeutigen Identifizierung einer Person dienen kann. Daher ist das IP-Masking ein Mittel zur Pseudonymisierung von Verarbeitungsverfahren, insbesondere im Onlinemarketing </li><li><strong>Interessenbasiertes und verhaltensbezogenes Marketing:</strong> Von interessens- und/oder verhaltensbezogenem Marketing spricht man, wenn potentielle Interessen von Nutzern an Anzeigen und sonstigen Inhalten möglichst genau vorbestimmt werden. Dies geschieht anhand von Angaben zu deren Vorverhalten (z.B. Aufsuchen von bestimmten Webseiten und Verweilen auf diesen, Kaufverhaltens oder Interaktion mit anderen Nutzern), die in einem sogenannten Profil gespeichert werden. Zu diesen Zwecken werden im Regelfall Cookies eingesetzt. </li><li><strong>Konversionsmessung:</strong> Die Konversionsmessung ist ein Verfahren, mit dem die Wirksamkeit von Marketingmaßnahmen festgestellt werden kann. Dazu wird im Regelfall ein Cookie auf den Geräten der Nutzer innerhalb der Webseiten, auf denen die Marketingmaßnahmen erfolgen, gespeichert und dann erneut auf der Zielwebseite abgerufen. Beispielsweise können wir so nachvollziehen, ob die von uns auf anderen Webseiten geschalteten Anzeigen erfolgreich waren. </li><li><strong>Personenbezogene Daten:</strong> "Personenbezogene Daten“ sind alle Informationen, die sich auf eine identifizierte oder identifizierbare natürliche Person (im Folgenden "betroffene Person“) beziehen; als identifizierbar wird eine natürliche Person angesehen, die direkt oder indirekt, insbesondere mittels Zuordnung zu einer Kennung wie einem Namen, zu einer Kennnummer, zu Standortdaten, zu einer Online-Kennung (z.B. Cookie) oder zu einem oder mehreren besonderen Merkmalen identifiziert werden kann, die Ausdruck der physischen, physiologischen, genetischen, psychischen, wirtschaftlichen, kulturellen oder sozialen Identität dieser natürlichen Person sind. </li><li><strong>Profiling:</strong> Als "Profiling“ wird jede Art der automatisierten Verarbeitung personenbezogener Daten bezeichnet, die darin besteht, dass diese personenbezogenen Daten verwendet werden, um bestimmte persönliche Aspekte, die sich auf eine natürliche Person beziehen (je nach Art des Profilings gehören dazu Informationen betreffend das Alter, das Geschlecht, Standortdaten und Bewegungsdaten, Interaktion mit Webseiten und deren Inhalten, Einkaufsverhalten, soziale Interaktionen mit anderen Menschen) zu analysieren, zu bewerten oder, um sie vorherzusagen (z.B. die Interessen an bestimmten Inhalten oder Produkten, das Klickverhalten auf einer Webseite oder den Aufenthaltsort). Zu Zwecken des Profilings werden häufig Cookies und Web-Beacons eingesetzt. </li><li><strong>Reichweitenmessung:</strong> Die Reichweitenmessung (auch als Web Analytics bezeichnet) dient der Auswertung der Besucherströme eines Onlineangebotes und kann das Verhalten oder Interessen der Besucher an bestimmten Informationen, wie z.B. Inhalten von Webseiten, umfassen. Mit Hilfe der Reichweitenanalyse können Webseiteninhaber z.B. erkennen, zu welcher Zeit Besucher ihre Webseite besuchen und für welche Inhalte sie sich interessieren. Dadurch können sie z.B. die Inhalte der Webseite besser an die Bedürfnisse ihrer Besucher anpassen. Zu Zwecken der Reichweitenanalyse werden häufig pseudonyme Cookies und Web-Beacons eingesetzt, um wiederkehrende Besucher zu erkennen und so genauere Analysen zur Nutzung eines Onlineangebotes zu erhalten. </li><li><strong>Remarketing:</strong> Vom "Remarketing“ bzw. "Retargeting“ spricht man, wenn z.B. zu Werbezwecken vermerkt wird, für welche Produkte sich ein Nutzer auf einer Webseite interessiert hat, um den Nutzer auf anderen Webseiten an diese Produkte, z.B. in Werbeanzeigen, zu erinnern. </li><li><strong>Tracking:</strong> Vom "Tracking“ spricht man, wenn das Verhalten von Nutzern über mehrere Onlineangebote hinweg nachvollzogen werden kann. Im Regelfall werden im Hinblick auf die genutzten Onlineangebote Verhaltens- und Interessensinformationen in Cookies oder auf Servern der Anbieter der Trackingtechnologien gespeichert (sogenanntes Profiling). Diese Informationen können anschließend z.B. eingesetzt werden, um den Nutzern Werbeanzeigen anzuzeigen, die voraussichtlich deren Interessen entsprechen. </li><li><strong>Verantwortlicher:</strong> Als "Verantwortlicher“ wird die natürliche oder juristische Person, Behörde, Einrichtung oder andere Stelle, die allein oder gemeinsam mit anderen über die Zwecke und Mittel der Verarbeitung von personenbezogenen Daten entscheidet, bezeichnet. </li><li><strong>Verarbeitung:</strong> "Verarbeitung" ist jeder mit oder ohne Hilfe automatisierter Verfahren ausgeführte Vorgang oder jede solche Vorgangsreihe im Zusammenhang mit personenbezogenen Daten. Der Begriff reicht weit und umfasst praktisch jeden Umgang mit Daten, sei es das Erheben, das Auswerten, das Speichern, das Übermitteln oder das Löschen. </li><li><strong>Zielgruppenbildung:</strong> Von Zielgruppenbildung (bzw. "Custom Audiences“) spricht man, wenn Zielgruppen für Werbezwecke, z.B. Einblendung von Werbeanzeigen, bestimmt werden. So kann z.B. anhand des Interesses eines Nutzers an bestimmten Produkten oder Themen im Internet geschlussfolgert werden, dass dieser Nutzer sich für Werbeanzeigen für ähnliche Produkte oder den Onlineshop, in dem er die Produkte betrachtet hat, interessiert. Von "Lookalike Audiences“ (bzw. ähnlichen Zielgruppen) spricht man wiederum, wenn die als geeignet eingeschätzten Inhalte Nutzern angezeigt werden, deren Profile bzw. Interessen mutmaßlich den Nutzern, zu denen die Profile gebildet wurden, entsprechen. Zur Zwecken der Bildung von Custom Audiences und Lookalike Audiences werden im Regelfall Cookies und Web-Beacons eingesetzt. </li></ul></p>
<p class="seal"><a href="https://datenschutz-generator.de/?l=de" title="Rechtstext von Dr. Schwenke - für weitere Informationen bitte anklicken." target="_blank">Erstellt mit Datenschutz-Generator.de von Dr. jur. Thomas Schwenke</a></p>
<?php
}
else if($page == 'events'){
echo '<h2>Events</h2>';
echo '<br/>';
echo '<h2>Januar</h2>';
echo '<img src="bilder/news/neujahrevent.png"></img><br/>';
echo 'Neujahr Event findet statt vom 01.01 bis zum 14.01.<br/>';
echo '<br/>';
echo '<h2>Februar</h2>';
echo '<img src="bilder/news/valentinsevent.png"></img><br/>';
echo 'Valentins Event findet statt vom 14.02 bis zum 28.02.<br/>';
echo '<br/>';
echo '<h2>März</h2>';
echo '<img src="bilder/news/fruehlingsevent.png"></img><br/>';
echo 'Frühlings Event findet statt vom 12.03 bis zum 26.03.<br/>';
echo '<br/>';
echo '<h2>April</h2>';
echo '<img src="bilder/news/osterevent.png"></img><br/>';
echo 'Das Oster Event findet statt vom 20.04 bis zum 30.04.<br/>';
echo '<br/>';
echo '<h2>Mai</h2>';
echo 'Kinder Event findet statt vom 12.05 bis zum 26.05.<br/>';
echo '<br/>';
echo '<h2>Juni</h2>';
echo 'Sonnen Event findet statt vom 13.06 bis zum 27.06.<br/>';
echo '<br/>';
echo '<h2>Juli</h2>';
echo 'Strand Event findet statt vom 12.07 bis zum 26.07.<br/>';
echo '<br/>';
echo '<h2>August</h2>';
echo 'Ehrungs Event findet statt vom 11.08 bis zum 25.08.<br/>';
echo '<br/>';
echo '<h2>September</h2>';
echo '<img src="bilder/news/rennenevent.png"></img><br/>';
echo 'Rennen Event findet statt vom 13.09 bis zum 27.09.<br/>';
echo '<br/>';
echo '<h2>Oktober</h2>';
echo '<img src="bilder/news/sportevent.png"></img><br/>';
echo 'Sport Event findet statt vom 05.10 bis zum 19.10.<br/>';
echo '<br/>';
echo '<h2>November</h2>';
echo '<img src="bilder/news/halloweenevent.png"></img><br/>';
echo 'Halloween Event findet statt vom 31.10 bis zum 13.11.<br/>';
echo '<br/>';
echo '<h2>Dezember</h2>';
echo '<img src="bilder/news/weihnachtsevent.png"></img><br/>';
echo 'Weihnachts Event findet statt vom 06.12 bis zum 24.12.<br/>';
echo '<br/>';
}
else if($page == 'cookies'){
echo '<h2>Cookies</h2>';
echo 'Wir nutzen Cookies um eure Logindaten verschlüsselt zu speichern.<br/>';
echo 'Damit wird die Funktion "Eingeloggt bleiben" ermöglicht.<br/>';
}
else if($page == 'partner'){
echo '<h3>Partner</h3>';
echo '<br/>';
echo '<br/><br/><br/>';
echo '<br/>Um Partner zu werden, schreibt einfach im Spiel oder in Discord eine Nachricht an einem Admin und bewirbt eure Webseite.
Dann müsst ihr nunoch unser <a href="info.php?page=verlinken">Banner</a> einfügen.<br/>';
}
else if($page == 'pus'){
echo '<center><form method="post" action="info.php?page=pus">';
$clan = $_REQUEST['clan'];
echo'<div class="auswahl">';
echo '<select name="clan" class="Auswahl" size="1">';
echo '<option value=""';
if($clan == ""){
echo ' selected>';
}
else{
echo '>';
}
echo 'Alle';
echo '</option>';
echo '<option value="kein"';
if($clan == "kein"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kein Clan';
echo '</option>';
echo '<option value="normal"';
if($clan == "normal"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Normal';
echo '</option>';
echo '<option value="kumo"';
if($clan == "kumo"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kumo';
echo '</option>';
echo '<option value="uchiha"';
if($clan == "uchiha"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Uchiha';
echo '</option>';
echo '<option value="hyuuga"';
if($clan == "hyuuga"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Hyuuga';
echo '</option>';
echo '<option value="aburame"';
if($clan == "aburame"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Aburame';
echo '</option>';
echo '<option value="akimichi"';
if($clan == "akimichi"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Akimichi';
echo '</option>';
echo '<option value="inuzuka"';
if($clan == "inuzuka"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Inuzuka';
echo '</option>';
echo '<option value="kaguya"';
if($clan == "kaguya"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kaguya';
echo '</option>';
echo '<option value="kugutsu"';
if($clan == "kugutsu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kugutsu';
echo '</option>';
echo '<option value="mokuton"';
if($clan == "mokuton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Mokuton';
echo '</option>';
echo '<option value="yuki"';
if($clan == "yuki"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Yuki';
echo '</option>';
echo '<option value="sand"';
if($clan == "sand"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Sand';
echo '</option>';
echo '<option value="tai"';
if($clan == "tai"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Tai';
echo '</option>';
echo '<option value="youton"';
if($clan == "youton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Youton';
echo '</option>';
echo '<option value="nara"';
if($clan == "nara"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Nara';
echo '</option>';
echo '<option value="shouton"';
if($clan == "shouton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Shouton';
echo '</option>';
echo '<option value="jiton"';
if($clan == "jiton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jiton';
echo '</option>';
echo '<option value="iryonin"';
if($clan == "iryonin"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Iryonin';
echo '</option>';
echo '<option value="sumi"';
if($clan == "sumi"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Sumi';
echo '</option>';
echo '<option value="kami"';
if($clan == "kami"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kami';
echo '</option>';
echo '<option value="schlange"';
if($clan == "schlange"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Schlange';
echo '</option>';
echo '<option value="frosch"';
if($clan == "frosch"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Frosch';
echo '</option>';
echo '<option value="puroresu"';
if($clan == "puroresu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Puroresu';
echo '</option>';
echo '<option value="buki"';
if($clan == "buki"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Buki';
echo '</option>';
echo '<option value="jiongu"';
if($clan == "jiongu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jiongu';
echo '</option>';
echo '<option value="kibaku nendo"';
if($clan == "kibaku nendo"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kibaku Nendo';
echo '</option>';
echo '<option value="kengou"';
if($clan == "kengou"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kengou';
echo '</option>';
echo '<option value="sakon"';
if($clan == "sakon"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Sakon';
echo '</option>';
echo '<option value="senninka"';
if($clan == "senninka"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Senninka';
echo '</option>';
echo '<option value="hozuki"';
if($clan == "hozuki"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Hozuki';
echo '</option>';
echo '<option value="kamizuru"';
if($clan == "kamizuru"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kamizuru';
echo '</option>';
echo '<option value="kurama"';
if($clan == "kurama"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kurama';
echo '</option>';
echo '<option value="yamanaka"';
if($clan == "yamanaka"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Yamanaka';
echo '</option>';
echo '<option value="ishoku sharingan"';
if($clan == "ishoku sharingan"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Ishoku Sharingan';
echo '</option>';
echo '<option value="utakata"';
if($clan == "utakata"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Utakata';
echo '</option>';
echo '<option value="jinchuuriki modoki"';
if($clan == "jinchuuriki modoki"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jinchuuriki Modoki';
echo '</option>';
echo '<option value="jashin"';
if($clan == "jashin"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jashin';
echo '</option>';
echo '<option value="roku pasu"';
if($clan == "roku pasu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Roku Pasu';
echo '</option>';
echo '<option value="jinton"';
if($clan == "jinton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jinton';
echo '</option>';
echo '</select>';
echo '</div>';
echo '<br><input class="button" name="login" id="login" value="suchen" type="submit"></form></center><br>';
echo 'Jutsus in der Spalte 1 lassen sich mit Jutsus der Spalte 1 und 2 kombinieren.<br> Jutsus in der Spalte 2 lassen sich mit Jutsus der Spalte 1 kombinieren, aber nicht mit Jutsus der Spalte 2 oder 3.<br> Jutsus in der Spalte 3 sind nur alleine einsetzbar und mit nichts kombinierbar.<br><br>';
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td class="tdbg tdborder"><b class="shadow">Spalte 1</b></td>';
echo '<td class="tdbg tdborder"><b class="shadow">Spalte 2</b></td>';
echo '<td class="tdbg tdborder"><b class="shadow">Spalte 3</b></td>';
echo '</tr>';
echo '<tr>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
name,
pucheck,
bild,
clan,
sichtbar
FROM
jutsus
WHERE pucheck != "0" AND sichtbar = 1
ORDER BY
pucheck,
name';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$vorher = 0;
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['pucheck'] == 1){
if($vorher != 1){
echo '<td>';
$vorher = 1;
}
if($clan == $row['clan']||$clan == ""||$clan == 'kein'&&$row['clan'] == ''){
echo '<a class="sinfo"><img border="0" src="bilder/jutsus/'.$row['bild'].'a.png" width="50px" height="50px"></img><span class="spanmap">'.$row['name'].'</span></a> ';
}
//echo '<td><b>'.$row['name'].'</b></td><td></td><td></td>';
}
if($row['pucheck'] == 2){
if($vorher != 2){
echo '</td><td>';
$vorher = 2;
}
//echo '<td></td><td><b>'.$row['name'].'</b></td><td></td>';
if($clan == $row['clan']||$clan == ""||$clan == 'kein'&&$row['clan'] == ''){
echo '<a class="sinfo"><img border="0" src="bilder/jutsus/'.$row['bild'].'a.png" width="50px" height="50px"></img><span class="spanmap">'.$row['name'].'</span></a> ';
}
}
if($row['pucheck'] == 3){
if($vorher != 3){
echo '</td><td>';
$vorher = 3;
}
//echo '<td></td><td></td><td><b>'.$row['name'].'</b></td>';
if($clan == $row['clan']||$clan == ""||$clan == 'kein'&&$row['clan'] == ''){
echo '<a class="sinfo"><img border="0" src="bilder/jutsus/'.$row['bild'].'a.png" width="50px" height="50px"></img><span class="spanmap">'.$row['name'].'</span></a> ';
}
}
}
$result->close();
$db->close();
echo '</td></tr>';
echo '</table>';
}
if($page == 'skills'){
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr><td class="tdbg tdborder"><h3>Skills</h3></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>HP</h3></td></tr>';
echo '<tr><td>Der Hp-Wert gibt an, wieviel Schaden du aushältst.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Chakra</h3></td></tr>';
echo '<tr><td>Der Chakra-Wert gibt an, wieviel Energie du hast, die du für Jutsus einsetzen kannst.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Kraft</h3></td></tr>';
echo '<tr><td>Kraft verstärkt deine Taijutsus.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Intelligenz</h3></td></tr>';
echo '<tr><td>Intelligenz verstärkt deine Genjutsus.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Chakrakontrolle</h3></td></tr>';
echo '<tr><td>Chakrakontrolle verstärkt deine Ninjutsus.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Tempo</h3></td></tr>';
echo '<tr><td>Tempo Erhöht deine Ausweichchance.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Genauigkeit</h3></td></tr>';
echo '<tr><td>Genauigkeit Erhöht deine Trefferchance.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Widerstand</h3></td></tr>';
echo '<tr><td>Widerstand Erhöht deine Verteidigung.</td></tr>';
echo '</table>';
}
if($page == 'allgemeines'){
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr><td class="tdbg tdborder"><h3>Allgemeines</h3></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Update</h3></td></tr>';
echo '<tr><td>Jeden Abend findet zwischen 23:45 und 0 Uhr ein Update statt.<br>
In dieser Zeit Künnt ihr keinerlei Aktionen beenden.<br>
Ab 23:30 ist es nichtmehr möglich Aktionen zu starten.<br>
Der Chatlog wird geleert und alle die im Chat waren müssen sich wieder neu einloggen.<br></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Erfahrung und Ryo</h3></td></tr>';
echo '<tr><td>Um Erfahrung und Ryo zu sammeln musst du Missionen abschließen.<br></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Jutsus lernen</h3></td></tr>';
echo '<tr><td>Du kannst ab dem Rang Genin neue Jutsus, darunter die Jutsus deines Clans, lernen.<br>
Jutsus, die in der Jutsuliste als "Clan bedingt" verzeichnet sind, können nur durch die Clanmission erlernt werden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Puppen</h3></td></tr>';
echo '<tr><td>Du bekommst neue Puppen, indem du sie im Shop kaufst.<br></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Reisen</h3></td></tr>';
echo '<tr><td>Um von einem Ort zu einen anderen Ort zu kommen, musst du reisen.<br>
wähle auf der Karte ein Ort aus, welcher neben deiner momentanen Position ist.<br>
An deiner Position befindet sich dein Mapcharakter.<br>
Es gibt drei verschiedene Wege: Leicht , Normal und Schwer.<br>
Nur bei der normalen und schweren Reise können dir Gegner begegnen.<br>
Du kannst bis Level 10 nur die leichte Reise machen.<br></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Multiplikator</h3></td></tr>';
echo '<tr><td>Der Multiplikator im Kampf kann für zwei Dinge benutzt werden:<br/>
1. Bei Jutsus die vom Typ "Items werfen" sind, gibt der Multiplikator an, wieviele Items man wirft.<br/>
2. Bei anderen Jutsus wird der Multiplikator mit dem Chakra multipliziert und der Schaden erhöht, aber auch die Chakrakosten.<br></td></tr>';
echo '</table>';
}
if($page == 'missionen'){
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr><td class="tdbg tdborder"><h3>Missionen</h3></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>D-Rang</h3></td></tr>';
echo '<tr><td>Die D-Rang-Missionen sind von jedem Rang machbar.<br></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>C-Rang</h3></td></tr>';
echo '<tr><td>Die C-Rang-Missionen sind ab dem Genin Rang machbar.<br>
Nuke-Nin können nach 50 kriminellen Missionen diese ebenfalls machen.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>B-Rang</h3></td></tr>';
echo '<tr><td>Die B-Rang-Missionen sind ab dem Chuunin Rang machbar.<br>
Nuke-Nin können nach 200 kriminellen Missionen diese ebenfalls machen.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>A-Rang</h3></td></tr>';
echo '<tr><td>Die A-Rang-Missionen sind ab dem Jounin Rang machbar.<br>
Nuke-Nin können nach 500 kriminellen Missionen diese ebenfalls machen.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>S-Rang</h3></td></tr>';
echo '<tr><td>Die S-Rang-Missionen sind ab dem Anbu Rang machbar.<br>
Nuke-Nin können nach 1000 kriminellen Missionen diese ebenfalls machen.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Story</h3></td></tr>';
echo '<tr><td>Die Story-Missionen sind immer in einen Abstand von 3 Leveln machbar.<br>
Es sind einzigartige Missionen und daher nur einmal machbar.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Clan</h3></td></tr>';
echo '<tr><td>Die Clan-Missionen unterscheiden sich bei jedem Clan.<br>
Durch sie bekommst du spezielle Jutsus, Beschwörungen oder Items.<br>
Der Normale Ninja kann sich durch die Clan-Missionen spezialisieren und erhält dann besondere Fähigkeiten.</td></tr>';
echo '</table>';
}
if($page == 'krieg'){
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr><td class="tdbg tdborder"><h3>Krieg</h3></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Gebiete</h3></td></tr>';
echo '<tr><td>Im Krieg gibt es verschiedene Gebiete, die unterschiedliche Farben haben können.<br>
Jedes Dorf besitzt eine eigene Farbe. Wenn ein Gebiet die Farbe eines Dorfes hat, dann ist es von dem Dorf erobert worden.<br>
Nuke-Nin haben keine eigene Farbe. Ihnen gehören die Gebiete ohne Farben.<br></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Reise zwischen Gebieten</h3></td></tr>';
echo '<tr><td>Die Reise von einem Gebiet zu einem anderen Gebiet ist nur von einem eroberten Gebiet aus möglich.<br>
Sollte man sich nicht auf einem erobertem Gebiet befinden, dann kann man nicht woanders hin. Man muss es zuerst erobern!<br>
Nuke-Nin müssen die eroberten Gebiete von der Eroberung befreien, um weiterreisen zu können.<br></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Die Bijuus</h3></td></tr>';
echo '<tr><td>Auf der Karte befinden sich 9 Bijuus.<br>
Sie sind durch das Hakke no Fuuin Shiki in Spielern versiegelbar.<br>
Dazu muss der Jinchuuriki als Ziel in einem Bijuukampf angegeben werden.<br>
Zudem benötigt der Bijuu weniger als 10% seiner HP.<br>
Um einen Bijuu zu entsiegeln, benutzt man das Hakke no Kaiin Shiki.<br>
Der Jinchuuriki muss als Ziel angegeben werden und muss weniger als 10% seiner HP besitzen.<br>';
echo '</table>';
}
if($page == 'vg'){
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr><td class="tdbg tdborder"><h3>Vertraute Geister</h3></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Frosch</h3></td></tr>';
echo '<tr><td>Die Frösche sind spezialisiert auf Ninjutsu und Genjutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.<br>
Als normaler Ninja kannst du dich auch auf die Frösche spezialisieren.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Schlange</h3></td></tr>';
echo '<tr><td>Die Schlangen sind spezialisiert auf Taijutsu und Ninjutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.<br>
Als normaler Ninja kannst du dich auch auf die Schlangen spezialisieren.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Schnecke</h3></td></tr>';
echo '<tr><td>Die Schnecken sind spezialisiert auf Taijutsu und Ninjutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Spinnen</h3></td></tr>';
echo '<tr><td>Die Spinnen sind spezialisiert auf Ninjutsu.<br>
Sie sind nur für das Bluterbe Kumo.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Eule</h3></td></tr>';
echo '<tr><td>Die Eulen sind spezialisiert auf Genjutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Haie</h3></td></tr>';
echo '<tr><td>Die Haie sind spezialisiert auf Ninjutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Dämonen</h3></td></tr>';
echo '<tr><td>Die Dämonen sind spezialisiert auf Genjutsu und Taijutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Affe</h3></td></tr>';
echo '<tr><td>Die Affen sind spezialisiert auf Taijutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Krähen</h3></td></tr>';
echo '<tr><td>Die Krähen sind spezialisiert auf Ninjutsu und Genjutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Falke</h3></td></tr>';
echo '<tr><td>Die Falken sind spezialisiert auf Ninjutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Salamander</h3></td></tr>';
echo '<tr><td>Die Salamander sind spezialisiert auf Ninjutsu und Taijutsu.<br>
Du kannst den Vertraggeber auf der Reise finden.</td></tr>';
echo '</table>';
}
if($page == 'bluterben'){
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Bluterben</h3></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="normal">Normal</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/normal.png"></img></td>';
echo '<td width="80">Die normalen Ninjas haben keine genetischen Fähigkeiten.<br>
Sie können sich jedoch später in einer Richtung spezialisieren und so dennoch starke Fähigkeiten erlernen.<br>
<br>
Spielbar in: Jedem Dorf</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="kumo">Kumo</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/kumos.png"></img></td>';
echo '<td width="80">Der Kumo-Clan hat sich auf die Spinnen spezialisiert.<br>
Sie haben von Geburt an 6 Arme und können Jutsus basierend auf die Spinnen lernen.<br>
<br>
Spielbar in: Sunagakure, Kumogakure und Otogakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="uchiha">Uchiha</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/uchiha.png"></img></td>';
echo '<td width="80">Die Uchihas sind ein Clan, der sich durch ihre Augen auszeichnet.<br>
Sie können ab einen bestimmten Level das Sharingan freischalten, wodurch sie starke Fähigkeiten lernen können.<br>
<br>
Spielbar in: Kumogakure, Takigakure und Otogakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="hyuuga">Hyuuga</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/hyuuga.png"></img></td>';
echo '<td width="80">Die Hyuugas sind ein Clan, der sich durch ihre Augen auszeichnet.<br>
Sie können ab einen bestimmten Level das Byakugan freischalten, wodurch sie starke Fähigkeiten lernen können.<br>
<br>
Spielbar in: Sunagakure, Iwagakure und Kumogakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="aburame">Aburame</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/aburame.png"></img></td>';
echo '<td width="80">Der Aburame-Clan hat sich auf die Insekten spezialisiert.<br>
Sie können mit den Insekten spezielle Jutsus durchführen.<br>
<br>
Spielbar in: Iwagakure und Kusagakure</td>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="akimichi">Akimichi</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/akimichi.png"></img></td>';
echo '<td width="80">Der Akimichi-Clan hat sich auf die eigene Körperkapazität spezialisiert.<br>
Sie können ihr Fett in Chakra umwandeln und starke Jutsus durchführen.<br>
<br>
Spielbar in: Konohagakure und Iwagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="inuzuka">Inuzuka</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/inuzuka.png"></img></td>';
echo '<td width="80">Der Inuzuka-Clan hat sich auf die Zucht von Hunden und Wölfen spezialisiert.<br>
Sie können zusammen mit ihren Partnern spezielle Jutsus durchführen.<br>
<br>
Spielbar in: Konohagakure, Kusagakure, Takigakure und Iwagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="kaguya">Kaguya</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/kaguya.png"></img></td>';
echo '<td width="80">Der Kaguya-Clan hat sich auf die eigenen Knochen spezialisiert.<br>
Sie können durch ihre Knochen spezielle Jutsus ausführen.<br>
<br>
Spielbar in: Kirigakure, Amegakure und Otogakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="kugutsu">Kugutsu</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/kugutsu.png"></img></td>';
echo '<td width="80">Ein Kugutsu-Ninja hat sich auf den Umgang mit Puppen spezialisiert.<br>
Er kann mit der Hilfe der Puppe besondere Jutsus ausführen.<br>
Zudem kann er später Menschen zu Puppen umwandeln.<br>
<br>
Spielbar in: Sunagakure, Amegakure und Kirigakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="mokuton">Mokuton</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/mokuton.png"></img></td>';
echo '<td width="80">Ein Mokuton-Ninja hat sich auf den Umgang mit dem Holzversteck spezialisiert.<br>
Er kann durch die Kombination von Doton und Suiton Leben erschaffen und Holzjutsus ausführen.<br>
<br>
Spielbar in: Konohagakure, Kusagakure, Takigakure und Otogakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="yuki">Yuki</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/yuki.png"></img></td>';
echo '<td width="80">Der Yuki-Clan kann durch Kombination von Suiton und Fuuton Eis erschaffen.<br>
So kann ein Yuki-Ninja Eisjutsus lernen.<br>
<br>
Spielbar in: Kirigakure, Amegakure und Takigakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="sand">Sand</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/sand.png"></img></td>';
echo '<td width="80">Ein Sand-Ninja hat sich auf den Umgang mit Sand spezialisiert.<br>
Er kann mit dem Sand besondere Jutsus ausführen.<br>
<br>
Spielbar in: Sunagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="tai">Tai</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/tai.png"></img></td>';
echo '<td width="80">Ein Tai-Ninja hat sich auf den Umgang mit Taijutsu spezialisiert.<br>
Er kann besondere Taijutsus ausführen.<br>
Zudem kann er die acht inneren Tore öffnen.<br>
<br>
Spielbar in: Konohagakure und Kusagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="youton">Youton</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/youton.png"></img></td>';
echo '<td width="80">Ein Youton-Ninja hat sich auf den Umgang mit dem Lavaversteck spezialisiert.<br>
Er kann durch die Kombination von Katon und Doton Lavajutsus wirken.<br>
<br>
Spielbar in: Kirigakure, Kumogakure und Amegakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="nara">Nara</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/nara.png"></img></td>';
echo '<td width="80">Der Nara-Clan hat sich auf die Schatten spezialisiert.<br>
Sie können durch die Erweiterung des eigenen Schattens den Gegner kontrollieren.<br>
<br>
Spielbar in: Konohagakure, Kirigakure und Kusagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="shouton">Shouton</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/shouton.png"></img></td>';
echo '<td width="80">Der Shouton-Ninja kann Kristalle erstellen.<br>
Er kann durch die Kristalle besondere Jutsus ausführen.<br>
<br>
Spielbar in: Kumogakure, Takigakure, Amegakure und Otogakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="jiton">Jiton</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/jiton.png"></img></td>';
echo '<td width="80">Der Jiton-Ninja kann Magnetfelder erstellen.<br>
Er kann somit den Eisensand steuern und mächtige Jutsus ausführen.<br>
<br>
Spielbar in: Sunagakure und Iwagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="sakon">Sakon</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/sakon.png"></img></td>';
echo '<td width="80">Diese Ninjas haben einen Zwillingsbruder im Körper.<br>
Sie können sich im Kampf trennen und gemeinsam kämpfen.<br>
<br>
Spielbar in: Kumogakure, Otogakure und Sunagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="senninka">Senninka</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/senninka.png"></img></td>';
echo '<td width="80">Senninka-Ninja sind von Geburt aus mit der Natur verbunden.<br>
Sie nutzen das Chakra aus der Natur um stärker zu werden.<br>
<br>
Spielbar in: Kirigakure, Otogakure und Sunagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="hozuki">Hozuki</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/hozuki.png"></img></td>';
echo '<td width="80">Der Hozuki-Clan ist ein auf Wasser basierender Clan.<br>
Sie können sich in Wasser auflösen und starke Wasserjutsus durchführen.<br>
<br>
Spielbar in: Kirigakure, Takigakure und Amegakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="kamizuru">Kamizuru</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/kamizuru.png"></img></td>';
echo '<td width="80">Der Kamizuru-Clan basiert auf Bienen.<br>
Sie nutzen im Kampf Bienen für starke Jutsus.<br>
<br>
Spielbar in: Iwagakure, Takigakure und Kusagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="kurama">Kurama</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/kurama.png"></img></td>';
echo '<td width="80">Der Kurama-Clan basiert auf Genjutsus.<br>
Sie können mächtige Genjutsus durchführen um den Gegner Leiden zu lassen.<br>
<br>
Spielbar in: Konohagakure, Iwagakure und Kusagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="yamanaka">Yamanaka</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/yamanaka.png"></img></td>';
echo '<td width="80">Der Yamanaka-Clan basiert auf Gedankenkontrolle.<br>
Sie können den Feind mit ihren Geist steuern und Schaden zufügen.<br>
<br>
Spielbar in: Konohagakure, Kumogakure und Amegakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Spezialisierungen</h3></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="iryonin">Iryonin</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/iryonin.png"></img></td>';
echo '<td width="80">Der Iryonin wird auch Heiler genannt.<br>
Er kann durch besondere Jutsus sich und andere Ninjas heilen.<br>
<br>
Spezialisierbar in: Jedem Dorf</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="sumi">Sumi</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/sumi.png"></img></td>';
echo '<td width="80">Der Sumi-Ninja ist ein ausgezeichneter Künstler.<br>
Er kann seine Kunst durch besondere Jutsus zum Leben erwecken.<br>
<br>
Spezialisierbar in: Kusagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="kami">Kami</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/kami.png"></img></td>';
echo '<td width="80">Der Kami-Ninja ist ein ausgezeichneter Origami-Künstler.<br>
Er kann durch Papier besondere Jutsus ausführen.<br>
<br>
Spezialisierbar in: Amegakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="schlange">Schlange</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/schlange.png"></img></td>';
echo '<td width="80">Der Schlangen-Ninja hat sich auf seinen vertrauten Geist spezialisiert.<br>
Er kann mit den Schlangen besondere Jutsus ausführen.<br>
Zudem lernt er den Sennin Mode.<br>
<br>
Spezialisierbar in: Bergpass</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="frosch">Frosch</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/frosch.png"></img></td>';
echo '<td width="80">Der Frosch-Ninja hat sich auf seinen vertrauten Geist spezialisiert.<br>
Er kann mit den Fröschen besondere Jutsus ausführen.<br>
Zudem lernt er den Sennin Mode.<br>
<br>
Spezialisierbar in: Wald</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="puroresu">Puroresu</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/puroresu.png"></img></td>';
echo '<td width="80">Der Puroresu-Ninja ist ein ausgezeichneter Wrestler.<br>
Er hat durch besondere Wrestlingjutsus in Kombination mit Raiton einen sehr starken Taijutsu.<br>
<br>
Spezialisierbar in: Kumogakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="buki">Buki</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/buki.png"></img></td>';
echo '<td width="80">Der Buki-Ninja kann sehr gut mit Waffen umgehen.<br>
Er kann durch die Waffen besondere Jutsus ausführen.<br>
<br>
Spezialisierbar in: Konohagakure oder Otogakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="jiongu">Jiongu</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/jiongu.png"></img></td>';
echo '<td width="80">Der Jiongu-Ninja hat durch das Lesen einer geheimen Schriftrolle besondere Fähigkeiten gelernt.<br>
Er kann Tentakeln beschwören und vier verschiedene Herzen erlangen.<br>
<br>
Spezialisierbar in: Takigakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="kibaku">Kibaku Nendo</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/kibakunendo.png"></img></td>';
echo '<td width="80">Der Kibaku Nendo-Ninja hat durch das Lesen einer geheimen Schriftrolle besondere Fähigkeiten gelernt.<br>
Er kann explodierendes Lehm erzeugen und damit kunstvolle Tier erschaffen, die explodieren.<br>
<br>
Spezialisierbar in: Iwagakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="kengou">Kengou</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/kengou.png"></img></td>';
echo '<td width="80">Der Kengou-Ninja ist ein ausgezeichneter Schwertkämpfer.<br>
Er folgt den Weg der sieben Schwertkämpfer aus Kirigakure und erlangt eins der sieben Schwerter.<br>
<br>
Spezialisierbar in: Kirigakure</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="ishoku">Ishoku Sharingan</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/ishoku.png"></img></td>';
echo '<td width="80">Der Ishoku-Ninja hat ein Sharingan transplantiert bekommen.<br>
Er kann teilweise Jutsus des Uchiha Clans nutzen, besitzt aber auch eigene.<br>
<br>
Spezialisierbar in: Tanzaku</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="utakata">Utakata</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/utakata.png"></img></td>';
echo '<td width="80">Der Utakata-Ninja basiert auf Seifenblasen.<br>
Er kann mit Seifenblasen mächtige Jutsus durchführen.<br>
<br>
Spezialisierbar in: Kanabi Brücke</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="modoki">Jinchuuriki Modoki</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/modoki.png"></img></td>';
echo '<td width="80">Der Modoki-Ninja wurde einmal von einen Bijuu gefressen und hatte es überlebt.<br>
Seitdem kann er sich teilweise in einen Bijuu verwandeln.<br>
<br>
Spezialisierbar in: Bergpass</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="jashin">Jashin</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/jashin.png"></img></td>';
echo '<td width="80">Der Jashin-Ninja glaubt an den Gott Jashin.<br>
Durch seinen Glaube bekam er die Unsterblichkeit und wendet somit besondere Jutsus an.<br>
<br>
Spezialisierbar in: Totbaumwald</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="roku">Roku Pasu</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/roku.png"></img></td>';
echo '<td width="80">Der Roku-Ninja hat ein Rinnegan transplantiert bekommen.<br>
Er kann die sechs Pfade nutzen und mit dem Rinnegan besondere Jutsus durchführen.<br>
<br>
Spezialisierbar in: Tenchi Brücke</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="jinton">Jinton</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="bilder/reg/jinton.png"></img></td>';
echo '<td width="80">Jinton-Ninja besitzen das einzigartige Jinton Kekkai Toka.<br>
Sie können besondere Jinton-Jutsus anwenden.<br>
<br>
Spezialisierbar in: Iwagakure</td>';
echo '</tr>';
echo '</table>';
}
if($page == 'rang'){
echo '<table class="table" width="100%">';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Ränge</h3></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Student</h3></td></tr>';
echo '<tr><td>Als Student sind nur die D-Missionen machbar.<br>
Zudem kann man als Student keine Clan-Missionen erlernen.<br>
Ein Student kann zudem das Dorf nicht verlassen.<br>
Die Genin Prüfung ist ab Level 10 machbar.</td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Genin</h3></td></tr>';
echo '<tr><td>Als Genin sind  die D-Missionen und C-Missionen machbar.<br>
Man kann nun die Clan-Missionen erlernen.<br>
Zudem kann man das Dorf verlassen und ein Nuke-Nin werden.<br>
Die Chuunin Prüfung ist ab Level 20 machbar.</td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Chuunin</h3></td></tr>';
echo '<tr><td>Als Chuunin sind die D-Missionen ,C-Missionen und B-Missionen machbar.<br>
Man kann auf Level 50 zum Jounin werden.<br></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Jounin</h3></td></tr>';
echo '<tr><td>Als Jounin sind die D-Missionen ,C-Missionen, B-Missionen und A-Missionen machbar.<br>
Man kann auf Level 60 zum Anbu werden.<br></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Anbu</h3></td></tr>';
echo '<tr><td>Als Anbu kann man alle Missionen machen.<br>
Man kann auf Level 70 zum Kage werden.<br></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Kage</h3></td></tr>';
echo '<tr><td>Als Kage kann man alle Missionen machen.<br>
Der Kage hat administrative Rechte im Dorf.<br>
Kage wird man, wenn man das Turnier einmal im Monat gewinnt.<br>
Das Turnier findet jeden 10. des Monates statt.<br>
Man kann sich am 09 und 10 des Monates beim Turnier registrieren.<br/>
Falls sich keiner am 09 des Monates registriert wird das Turnier gelöscht.<br/></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Nuke-Nin</h3></td></tr>';
echo '<tr><td>Als Nuke-Nin kann man Missionen abhängig von seinem Level.<br>
Man ist ab Level 10 ein D-Rang Nuke-Nin.<br>
Man ist ab Level 20 ein C-Rang Nuke-Nin.<br>
Man ist ab Level 30 ein B-Rang Nuke-Nin.<br>
Man ist ab Level 50 ein A-Rang Nuke-Nin.<br>
Man ist ab Level 60 ein S-Rang Nuke-Nin.<br>';
echo '</table>';
}
if($page == 'exam'){
echo '<table class="table" width="100%">';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Dörfer</h3></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Genin Prüfung</h3></td></tr>';
echo '<tr><td>Die Geninprüfung findet immer am Dienstag, Donnerstag und Samstag von 10 bis 20 Uhr statt.<br>
Ihre Anforderungen unterscheiden sich von jedem Kage.<br>
In den meisten Fällen musst du Level 10 erreicht haben und die 3 Grundjutsus erlernt haben.<br>
Als Tai-Ninja musst du nur Level 10 erreichen.</td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Chunin Prüfung</h3></td></tr>';
echo '<tr><td>Die Chuninprüfung findet immer am Mittwoch, Freitag und Sonntag statt.<br>
Um sie bestehen zu können, musst du eine schriftliche Prüfung bestehen,<br>
welche aus 10 Fragen besteht und anschließend einem praktischen Teil.<br>
Dort musst du in einem Turnier alle deine Konkurrenten besiegen.<br>
Die schriftliche Prüfung findet von 15 bis 18 Uhr statt und <br>
das Turnier findet im Anschluss von 18 bis 20 Uhr statt.  <br>
Am Turnier kann man erst ab Level 20 teilnehmen.<br></td></tr>';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Jounin Prüfung</h3></td></tr>';
echo '<tr><td>Die Jouninprüfung kannst du ablegen, sobald du Level 50 erreicht hast. <br>
Sie besteht nur aus einem Kampf, den du gewinnen musst.<br></td></tr>';
echo '</table>';
}
if($page == 'dorf'){
echo '<table class="table" width="100%">';
echo '<tr><td class="tdbg tdborder" colspan="2"><h3>Dörfer</h3></td></tr>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
was,
bild,
beschreibung
FROM
orte
WHERE was = "dorf" && id != "13"';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
echo '<tr><td class="tdbg tdborder" colspan="2"><h3 id="'.$row['name'].'">'.ucwords($row['name']).'</h3></td></tr>';
echo '<tr>';
echo '<td width="20%"><img src="'.$row['bild'].'"></img></td>';
echo '<td width="80%">'.$row['beschreibung'].'</td>';
echo '</tr>';
}
$result->close();$db->close();
echo '</table>';

}
if($page == 'impressum'){
echo '<h1>Impressum</h1>

<h2>Angaben gem&auml;&szlig; &sect; 5 TMG</h2>
<p>Andr&eacute; Braun<br />
Obergasse 11A<br />
55576 Welgesheim/p>

<h2>Kontakt</h2>
<p>E-Mail: <a href="mailto:p-u-r-e@hotmail.de">p-u-r-e@hotmail.de</a></p>

<h3>Haftung f&uuml;r Inhalte</h3> <p>Als Diensteanbieter sind wir gem&auml;&szlig; &sect; 7 Abs.1 TMG f&uuml;r eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach &sect;&sect; 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, &uuml;bermittelte oder gespeicherte fremde Informationen zu &uuml;berwachen oder nach Umst&auml;nden zu forschen, die auf eine rechtswidrige T&auml;tigkeit hinweisen.</p> <p>Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unber&uuml;hrt. Eine diesbez&uuml;gliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung m&ouml;glich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.</p> <h3>Haftung f&uuml;r Links</h3> <p>Unser Angebot enth&auml;lt Links zu externen Websites Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb k&ouml;nnen wir f&uuml;r diese fremden Inhalte auch keine Gew&auml;hr &uuml;bernehmen. F&uuml;r die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf m&ouml;gliche Rechtsverst&ouml;&szlig;e &uuml;berpr&uuml;ft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.</p> <p>Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.</p> <h3>Urheberrecht</h3> <p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielf&auml;ltigung, Bearbeitung, Verbreitung und jede Art der Verwertung au&szlig;erhalb der Grenzen des Urheberrechtes bed&uuml;rfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur f&uuml;r den privaten, nicht kommerziellen Gebrauch gestattet.</p> <p>Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.</p>

<p>Quelle: <a href="https://www.e-recht24.de">e-recht24.de</a></p>';
}
if($page == 'items'){
     echo '<h3>Items</h3><br>';
$seite = $_GET['seite'];
$suche = htmlspecialchars($_POST['suche']);
$kaufbar = $_REQUEST['kaufbar'];
if($suche == "Was suchst du?"){
$suche = "";
}
if($seite <= 1){
$seite = 1;
}
echo '<form method="post" action="info.php?page=items">';
echo '<table width="100%" class="shadow">';
echo '<tr>';
echo '<td align="center">';
echo '<div class="eingabe1">';
if($suche != ""){
echo '<input class="eingabe2" name="suche" value="'.$suche.'" size="15" maxlength="80" type="text">';
}
else{
echo '<input class="eingabe2" name="suche" value="Was suchst du?" size="15" maxlength="80" type="text">';
}
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center">';
echo'<div class="auswahl">';
echo '<select name="kaufbar" class="Auswahl" size="1">';
echo '<option value=""';
if($kaufbar == ""){
echo ' selected>';
}
else{
echo '>';
}
echo 'Alle';
echo '</option>';
echo '<option value="0"';
if($kaufbar == '0'){
echo ' selected>';
}
else{
echo '>';
}
echo 'Legendäre Items';
echo '</option>';
echo '<option value="1"';
if($kaufbar == '1'){
echo ' selected>';
}
else{
echo '>';
}
echo 'Normale Items';
echo '</option>';
echo '</select>';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<input class="button" name="login" id="login" value="suchen" type="submit"></form><br>';
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td width="100px" class="tdbg tdborder">';
echo 'Name';
echo '</td>';
echo '<td width="50px" class="tdbg tdborder">';
echo 'Bild';
echo '</td>';
echo '<td width="100px" class="tdbg tdborder">';
echo 'Level';
echo '</td>';
echo '<td width="100px" class="tdbg tdborder">';
echo 'Preis';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Beschreibung';
echo '</td>';
echo '</tr>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
name,
shop,
preis,
beschreibung,
bild,
typ,
werte,
level,
inshop
FROM
item
ORDER BY
level,
preis,
name';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}

$platz = 0;
$ps = 30;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
//Seite 1 , 1-30
//Seite 2 , 31-60
//Seite 3 , 61-90
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($kaufbar == ''||$kaufbar == $row['inshop']){
$platz++;
if($suche == ""||$suche != ""&&strpos(strtolower($row['name']), strtolower($suche)) !== false){
if($suche == ""&&$platz >= $von&&$platz <= $bis||$suche != ""){
echo '<tr>';
echo '<td>'.$row['name'].'</td>';
echo '<td><img src="'.$row['bild'].'"></img></td>';
echo '<td>'.$row['level'].'</td>';
if($row['preis'] == 0){
echo '<td>Nicht kaufbar</td>';
}
else{
echo '<td>'.$row['preis'].' Ryo</td>';
}
$ibesch = $row['beschreibung'];
if($row['typ'] == 1){
$array = explode(";", trim($row['werte']));
$ihph = $array[0];
$ichakrak = $array[1];
$ibesch = $ibesch.'<br>Heilt ';
if($ihph != 0){
$ibesch = $ibesch.$ihph.' HP';
if($ichakrak != 0){
$ibesch = $ibesch.' und '.$ichakrak.' Chakra';
}
}
else{
$ibesch = $ibesch.$ichakrak.' Chakra';
}
$ibesch = $ibesch.'.';
}
if($row['typ'] == 3){
$array = explode(";", trim($row['werte']));
$ikr = $array[0];
$iint = $array[1];
$ichrk = $array[2];
$itmp = $array[3];
$ignk = $array[4];
$iwid = $array[5];
$islots = $array[6];
if($ikr != 0){
$ilevel = substr($ikr, -1);
if($ilevel == "L"){
$ikr = substr($ikr,0, -1);
$ibesch = $ibesch.'<br>Erhöht Kraft um '.$ikr.' pro Level.';
}
else{
$ibesch = $ibesch.'<br>Erhöht Kraft um '.$ikr.'.';
}
}
if($iint != 0){
$ilevel = substr($iint, -1);
if($ilevel == "L"){
$iint = substr($iint,0, -1);
$ibesch = $ibesch.'<br>Erhöht Intelligenz um '.$iint.' pro Level.';
}
else{
$ibesch = $ibesch.'<br>Erhöht Intelligenz um '.$iint.'.';
}
}
if($ichrk != 0){
$ilevel = substr($ichrk, -1);
if($ilevel == "L"){
$ichrk = substr($ichrk,0, -1);
$ibesch = $ibesch.'<br>Erhöht Chakrakontrolle um '.$ichrk.' pro Level.';
}
else{
$ibesch = $ibesch.'<br>Erhöht Chakrakontrolle um '.$ichrk.'.';
}
}
if($itmp != 0){
$ilevel = substr($itmp, -1);
if($ilevel == "L"){
$itmp = substr($itmp,0, -1);
$ibesch = $ibesch.'<br>Erhöht Tempo um '.$itmp.' pro Level.';
}
else{
$ibesch = $ibesch.'<br>Erhöht Tempo um '.$itmp.'.';
}
}
if($ignk != 0){
$ilevel = substr($ignk, -1);
if($ilevel == "L"){
$ignk = substr($ignk,0, -1);
$ibesch = $ibesch.'<br>Erhöht Genauigkeit um '.$ignk.' pro Level.';
}
else{
$ibesch = $ibesch.'<br>Erhöht Genauigkeit um '.$ignk.'.';
}
}
if($iwid != 0){
$ilevel = substr($iwid, -1);
if($ilevel == "L"){
$iwid = substr($iwid,0, -1);
$ibesch = $ibesch.'<br>Erhöht Widerstand um '.$iwid.' pro Level.';
}
else{
$ibesch = $ibesch.'<br>Erhöht Widerstand um '.$iwid.'.';
}
}
if($islots != 0){
$ibesch = $ibesch.'<br>Erhöht Slots um '.$islots.'.';
}
}
echo '<td>'.$ibesch.'</td>';
echo '</tr>';
}
}
}
}
$result->close();$db->close();
echo '</table>';
if($suche == ""){
$count = 1;
$anzahl = $platz;
if($platz > $ps){
while($platz > 0){
$platz = $platz-$ps;
echo '<a href="info.php?page=items&seite='.$count.'&kaufbar='.$kaufbar.'">'.$count.'</a> ';
$count++;
}
}
echo '<br>Anzahl: '.$anzahl;
}

}
if($page == "bbcode")
{
echo '<table class="table" width="100%">';
echo '<tr><td class="tdbg tdborder"><h2 class="shadow">BB-Code</h2></td></tr>';
echo '<tr><td>
Der BB-Code ist eine einfache Form um Wörter und Texte besser darzustellen.<br>
Es gibt folgende Codes:';
echo '<tr><td class="tdbg tdborder"><h3><u>Unterstrichener Text</u></h3></td></tr>';
echo '<tr><td>[u] Text [/u]</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3><i>Kursiver Text</i></h3></td></tr>';
echo '<tr><td>[i] Text [/i]</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3><b>Dicker Text</b></h3></td></tr>';
echo '<tr><td>[b] Text [/b]</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3><a id="anker">Anker</a></h3></td></tr>';
echo '<tr><td>[a=ankerid] Text [/a]<br>
Verlinken mit [url=#ankerid]Link[/url]</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Youtube-Video</h3></td></tr>';
echo '<tr><td>';
echo '<table width="100%"><tr><td><embed pluginspage="http://www.macromedia.com/go/getflashplayer" src="http://www.youtube.com/v/7ilCHKYbIhg" type="application/x-shockwave-flash" wmode="transparent" quality="high" scale="exactfit" width="400" height="300">';
echo '</td><td>[youtube] den Wert nach v= hier eintragen [/youtube]<br>
<br>Youtube Video Beispiel:<br>
[youtube]7ilCHKYbIhg[/youtube]<br></td></tr></table>';
echo '</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3><a id="anker">Bilder</a></h3></td></tr>';
echo '<tr><td>';
echo '<table width="100%"><tr><td><img src="bilder/banner/banner1.png"></img></td><td> [bild] link [/bild]</td></tr></table>';
echo '<tr><td class="tdbg tdborder"><h3><font color="#ff0000">Colorierter Text</font></h3></td></tr>';
echo '<tr><td>[color=farbe] Text [/color]</td></tr>';
echo '</table>';
}

if($page == 'regeln'){
echo '<table class="table" width="100%">';
echo '<tr><td class="tdbg tdborder"><h2 class="shadow">Regeln</h2></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Verwarnungen</h3></td></tr>';
echo '<tr>';
echo '<td>Bei zwei Verwarnungen wird der User für zehn Tage gesperrt.<br>
Bei drei Verwarnungen wird der User für immer gesperrt.<br>
Falls der User ein Kage ist , verliert er diesen Rang.<br>
Sollte der User sich während einer Sperrung löschen und dann neuanmelden, gibt es eine weitere Verwarnung zu seinen alten Verwarnungen.<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Beleidigungen/anstößige Namen</h3></td></tr>';
echo '<tr>';
echo '<td>Es werden keine Beleidigungen , anstößige Namen und Mobbing anderer Art in Texten , Namen und Bildern geduldet!<br>
 Jegliche Beleidigungen sollten einem Admin gemeldet werden.<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Spam</h3></td></tr>';
echo '<tr>';
echo '<td>Es dürfen Nachrichten nicht massenhaft gesendet werden , weder per PN noch im Chat! Nur einmal klicken, das reicht. Wenn jemand erwischt wird<br>
der mehrere Nachrichten nacheinander in sofortiger Abfolge gesendet hat, wird dieser verwarnt und bei erneutigem Erwischen gesperrt! <br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Fremdsprachen</h3></td></tr>';
echo '<tr>';
echo '<td>Gespräche in einer anderen Sprache als Deutsch sind im Chat nicht erlaubt.<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Bugusing</h3></td></tr>';
echo '<tr>';
echo '<td>Wenn jemand erwischt wird, dass er ein Bug benutzt, mit dem Wissen das er ihn benutzt, und es nicht meldet, kann er gelöscht werden. <br>
Bugs müssen gemeldet werden, es dient zur Verbesserung des Spieles. <br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Jinchuuriki</h3></td></tr>';
echo '<tr>';
echo '<td>Als Jinchuuriki ist es nicht erlaubt einen Herausforderungskampf durch andere Kämpfe zu entgehen.</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Kriegskämpfe</h3></td></tr>';
echo '<tr>';
echo '<td>Kriegskämpfe dürfen nicht unnötig in die Länge gezogen werden, es sollte immer eine Aktion gemacht werden sofern man dies kann.</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>anstößige Bilder</h3></td></tr>';
echo '<tr>';
echo '<td>Bilder, bei denen sexuelle Anspielungen oder Handlungen gemacht werden, sind verboten.
Darunter zählen auch: Ecchi, Yaoi, Yuri, Hentai und Weiteres. <br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Werbung</h3></td></tr>';
echo '<tr>';
echo '<td>Das Werben eines anderen Browsergames durch Links im Profil oder im Chat ist verboten!<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Youtube-Videos</h3></td></tr>';
echo '<tr>';
echo '<td>Youtube-Videos dürfen in Texten nicht automatisch starten, dafür sind die Themes da.<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Wertungskämpfe</h3></td></tr>';
echo '<tr>';
echo '<td>Das absichtliche Verlieren in Wertungskämpfen ist nicht erlaubt.<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Profiltexte</h3></td></tr>';
echo '<tr>';
echo '<td>Das Erwähnen von anderen Usern in den Profiltexten, ohne deren Einverständnis, ist verboten.<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>RPGlen</h3></td></tr>';
echo '<tr>';
echo '<td>Das "Rpg-len" ist ausdrücklich erlaubt und erwünscht, jedoch nicht in einer Form, die man beleidigend
aufnehmen könnte. Das heißt es wird sich nicht über andere lustig gemacht bzw es wird nichts im Profil erlaubt, das andere beleidigend finden. Somit sind generell Anti-Rassen-Bilder/Texte nicht erlaubt.<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Mehrere Charaktere</h3></td></tr>';
echo '<tr>';
echo '<td>Es ist nicht erlaubt, dass eigene Charaktere miteinander interagieren.<br/>
Das bedeutet, Handel und Kämpfe sind miteinander nicht gestattet, außer es sind Spaßkämpfe.<br/>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Kage-Turnier</h3></td></tr>';
echo '<tr>';
echo '<td>Man darf nur mit einem Charakter an den Kage-Turnieren teilnehmen.<br/>
Man darf also nicht mit mehreren Charakteren an dem Selben oder an unterschiedlichen Turnieren teilnehmen.<br/>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Akzeptierung</h3></td></tr>';
echo '<tr>';
echo '<td>Durch das Spielen von NBG akzeptierst du die zu der Zeit des Spielens geltende Regeln an.<br>
</td>';
echo '</tr>';
echo '<tr><td class="tdbg tdborder"><h3>Änderungen</h3></td></tr>';
echo '<tr>';
echo '<td>Diese Regeln können immer ohne Meldung geändert werden.<br>
</td>';
echo '</tr>';
echo '</table>';
}

if($page == "verlinken"){

     echo '<br>
<h2>Banner</h2>';
echo '<a href=""><img src="bilder/banner/banner.png"></img></a>';
echo '<br>';
echo '<textarea cols="40" rows="3">';
echo '<a href="https://v2.n-bg.de/"><img src="https://v2.n-bg.de/bilder/banner/banner.png"></img></a>';
echo '</textarea>';
echo '<br>';
echo '<a href=""><img src="bilder/banner/banner4.png "></img></a>';
echo '<br>';
echo '<textarea cols="40" rows="3">';
echo '<a href="https://v2.n-bg.de/"><img src="https://v2.n-bg.de/bilder/banner/banner4.png"></img></a>';
echo '</textarea>';
echo '<br>';
echo '<a href=""><img src="hbilder/banner/banner5.png"></img></a>';
echo '<br>';
echo '<textarea cols="40" rows="3">';
echo '<a href="https://v2.n-bg.de/"><img src="https://v2.n-bg.de/bilder/banner/banner5.png"></img></a>';
echo '</textarea>';
echo '<br>';
echo '<a href=""><img src="bilder/banner/banner6.png"></img></a>';
echo '<br>';
echo '<textarea cols="40" rows="3">';
echo '<a href="https://v2.n-bg.de/"><img src="https://v2.n-bg.de/bilder/banner/banner6.png"></img></a>';
echo '</textarea>';
echo '<br>';
echo '<a href=""><img src="bilder/banner/banner7.png"></img></a>';
echo '<br>';
echo '<textarea cols="40" rows="3">';
echo '<a href="https://v2.n-bg.de/"><img src="https://v2.n-bg.de/bilder/banner/banner7.png"></img></a>';
echo '</textarea>';
echo '<br>';

 }

if($page == 'chat'){
echo '<table class="table" width="100%">';
echo '<tr><td class="tdbg tdborder"><h2 class="shadow">Chat</h2></td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Logout</h3></td></tr>';
echo '<tr><td>"/logout" oder der "L"-Button<br>
Wenn du den Chat verlassen mächtest, kannst du dich hiermit ausloggen. </td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Verfügbare BB-Codes</h3></td></tr>';
echo '<tr><td>Im Chat kannst du den Großteil der BB-Codes verwenden. Einzig die Anker können nicht benutzt werden.</td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Farbe</h3></td></tr>';
echo '<tr><td>"/farbe farbe" oder der "C"-Button   <br>
Wenn du deine Schriftfarbe ändern mächtest, suche dir eine gut lesbare Farbe aus und nutze dann den "Hexcode" der Farbe.   <br>
Beispiel:<br>
Farbe Rot    <br>
"/farbe red" oder "/farbe FF0000" </td></tr>';
echo '<tr><td class="tdbg tdborder"><h3>Flüstern</h3></td></tr>';
echo '<tr><td>"/w User Naricht" oder der "W"-Button <br>
Hiermit ist es dir möglich einen User einzeln und privat anzuschreiben.      <br>
Dazu gibst du einfach "/w Username Text" ein. <br>
Beispiel:  <br>
"/w PuRe Hallo"  <br>
Damit sendest du an den User "PuRe" den Text "Hallo".</td></tr>';
echo '</table>';
}
if($page == 'jutsus'){
$seite = $_GET['seite'];
$suche = htmlspecialchars($_GET['suche']);
$clan = $_GET['clan'];
$typ = $_GET['typ'];
$element = $_GET['element'];
$art = $_GET['art'];
if($suche == "Was suchst du?"){
$suche = "";
}
if($seite <= 1){
$seite = 1;
}
echo '<form method="GET" action="info.php">';
echo '<table width="100%" class="shadow">';
echo '<tr>';
echo '<td align="center">';
echo '<div class="eingabe1">';
echo '<input type="hidden" name="page" value="jutsus">';
if($suche != ""){
echo '<input class="eingabe2" name="suche" value="'.$suche.'" size="15" maxlength="80" type="text">';
}
else{
echo '<input class="eingabe2" name="suche" value="Was suchst du?" size="15" maxlength="80" type="text">';
}
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center">';
echo'<div class="auswahl">';
echo '<select name="clan" class="Auswahl" size="1">';
echo '<option value=""';
if($clan == ""){
echo ' selected>';
}
else{
echo '>';
}
echo 'Alle';
echo '</option>';
echo '<option value="kein"';
if($clan == "kein"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kein Clan';
echo '</option>';
echo '<option value="normal"';
if($clan == "normal"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Normal';
echo '</option>';
echo '<option value="kumo"';
if($clan == "kumo"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kumo';
echo '</option>';
echo '<option value="uchiha"';
if($clan == "uchiha"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Uchiha';
echo '</option>';
echo '<option value="hyuuga"';
if($clan == "hyuuga"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Hyuuga';
echo '</option>';
echo '<option value="aburame"';
if($clan == "aburame"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Aburame';
echo '</option>';
echo '<option value="akimichi"';
if($clan == "akimichi"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Akimichi';
echo '</option>';
echo '<option value="inuzuka"';
if($clan == "inuzuka"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Inuzuka';
echo '</option>';
echo '<option value="kaguya"';
if($clan == "kaguya"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kaguya';
echo '</option>';
echo '<option value="kugutsu"';
if($clan == "kugutsu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kugutsu';
echo '</option>';
echo '<option value="mokuton"';
if($clan == "mokuton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Mokuton';
echo '</option>';
echo '<option value="yuki"';
if($clan == "yuki"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Yuki';
echo '</option>';
echo '<option value="sand"';
if($clan == "sand"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Sand';
echo '</option>';
echo '<option value="tai"';
if($clan == "tai"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Tai';
echo '</option>';
echo '<option value="youton"';
if($clan == "youton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Youton';
echo '</option>';
echo '<option value="nara"';
if($clan == "nara"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Nara';
echo '</option>';
echo '<option value="shouton"';
if($clan == "shouton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Shouton';
echo '</option>';
echo '<option value="jiton"';
if($clan == "jiton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jiton';
echo '</option>';
echo '<option value="iryonin"';
if($clan == "iryonin"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Iryonin';
echo '</option>';
echo '<option value="sumi"';
if($clan == "sumi"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Sumi';
echo '</option>';
echo '<option value="kami"';
if($clan == "kami"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kami';
echo '</option>';
echo '<option value="schlange"';
if($clan == "schlange"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Schlange';
echo '</option>';
echo '<option value="frosch"';
if($clan == "frosch"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Frosch';
echo '</option>';
echo '<option value="puroresu"';
if($clan == "puroresu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Puroresu';
echo '</option>';
echo '<option value="buki"';
if($clan == "buki"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Buki';
echo '</option>';
echo '<option value="jiongu"';
if($clan == "jiongu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jiongu';
echo '</option>';
echo '<option value="kibaku nendo"';
if($clan == "kibaku nendo"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kibaku Nendo';
echo '</option>';
echo '<option value="kengou"';
if($clan == "kengou"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kengou';
echo '</option>';
echo '<option value="sakon"';
if($clan == "sakon"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Sakon';
echo '</option>';
echo '<option value="senninka"';
if($clan == "senninka"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Senninka';
echo '</option>';
echo '<option value="hozuki"';
if($clan == "hozuki"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Hozuki';
echo '</option>';
echo '<option value="kamizuru"';
if($clan == "kamizuru"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kamizuru';
echo '</option>';
echo '<option value="kurama"';
if($clan == "kurama"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kurama';
echo '</option>';
echo '<option value="yamanaka"';
if($clan == "yamanaka"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Yamanaka';
echo '</option>';
echo '<option value="ishoku sharingan"';
if($clan == "ishoku sharingan"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Ishoku Sharingan';
echo '</option>';
echo '<option value="utakata"';
if($clan == "utakata"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Utakata';
echo '</option>';
echo '<option value="jinchuuriki modoki"';
if($clan == "jinchuuriki modoki"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jinchuuriki Modoki';
echo '</option>';
echo '<option value="jashin"';
if($clan == "jashin"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jashin';
echo '</option>';
echo '<option value="roku pasu"';
if($clan == "roku pasu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Roku Pasu';
echo '</option>';
echo '<option value="jinton"';
if($clan == "jinton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Jinton';
echo '</option>';
echo '</select>';
echo '</div>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td align="center">';
echo'<div class="auswahl">';
echo '<select name="typ" class="Auswahl" size="1">';
echo '<option value=""';
if($typ == ""){
echo ' selected>';
}
else{
echo '>';
}
echo 'Alle';
echo '</option>';
echo '<option value="Taijutsu"';
if($typ == "Taijutsu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Taijutsu';
echo '</option>';
echo '<option value="Ninjutsu"';
if($typ == "Ninjutsu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Ninjutsu';
echo '</option>';
echo '<option value="Genjutsu"';
if($typ == "Genjutsu"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Genjutsu';
echo '</option>';
echo '<option value="Powerup"';
if($typ == "Powerup"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Powerup';
echo '</option>';
echo '</select>';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '<tr>';
echo '<td align="center">';
echo'<div class="auswahl">';
echo '<select name="element" class="Auswahl" size="1">';
echo '<option value=""';
if($element == ""){
echo ' selected>';
}
else{
echo '>';
}
echo 'Alle';
echo '</option>';
echo '<option value="kein"';
if($element == "kein"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kein Element';
echo '</option>';
echo '<option value="Suiton"';
if($element == "Suiton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Suiton';
echo '</option>';
echo '<option value="Fuuton"';
if($element == "Fuuton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Fuuton';
echo '</option>';
echo '<option value="Katon"';
if($element == "Katon"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Katon';
echo '</option>';
echo '<option value="Doton"';
if($element == "Doton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Doton';
echo '</option>';
echo '<option value="Raiton"';
if($element == "Raiton"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Raiton';
echo '</option>';
echo '</select>';
echo '<tr>';
echo '<td align="center">';
echo'<div class="auswahl">';
echo '<select name="art" class="Auswahl" size="1">';
echo '<option value=""';
if($art == ""){
echo ' selected>';
}
else{
echo '>';
}
echo 'Alle';
echo '</option>';
echo '<option value="1"';
if($art == "1"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Schaden';
echo '</option>';
echo '<option value="2"';
if($art == "2"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Verteidigung';
echo '</option>';
echo '<option value="3"';
if($art == "3"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Bunshin';
echo '</option>';
echo '<option value="4"';
if($art == "4"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Henge';
echo '</option>';
echo '<option value="5"';
if($art == "5"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Rufen';
echo '</option>';
echo '<option value="6"';
if($art == "6"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Powerup';
echo '</option>';
echo '<option value="7"';
if($art == "7"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Debuff';
echo '</option>';
echo '<option value="8"';
if($art == "8"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Werfen';
echo '</option>';
echo '<option value="9"';
if($art == "9"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Einnehmen';
echo '</option>';
echo '<option value="10"';
if($art == "10"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Heilung';
echo '</option>';
echo '<option value="11"';
if($art == "11"){
echo ' selected>';
}
else{
echo '>';
}
echo 'AOE';
echo '</option>';
echo '<option value="12"';
if($art == "12"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Selbstheilung';
echo '</option>';
echo '<option value="13"';
if($art == "13"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Spezial';
echo '</option>';
echo '<option value="15"';
if($art == "15"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Kombination';
echo '</option>';
echo '<option value="16"';
if($art == "16"){
echo ' selected>';
}
else{
echo '>';
}
echo 'Heilung (mehrere)';
echo '</option>';
echo '</select>';
echo '</div>';
echo '</td>';
echo '</tr>';
echo '</table>';
echo '<input class="button" value="suchen" type="submit"></form><br>';
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno())
{
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = '
SELECT
id,
name,
bild,
art,
typ,
req,
lehrbar,
dmg,
cdmg,
clan,
element,
item,
chakra,
level,
sichtbar
FROM
jutsus
WHERE sichtbar=1
ORDER BY
dmg,id ASC';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
echo '<table class="table" width="100%" cellspacing="0">';
echo '<tr>';
echo '<td width="25px" class="tdbg tdborder">';
echo 'NR';
echo '</td>';
echo '<td width="50px" class="tdbg tdborder">';
echo 'Bild';
echo '</td>';
echo '<td width="70px" class="tdbg tdborder">';
echo 'Name';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Typ';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Clan';
echo '</td>';
echo '<td class="tdbg tdborder">';
echo 'Art';
echo '</td>';
echo '<td width="110px" class="tdbg tdborder">';
echo 'Benötigt';
echo '</td>';
echo '<td width="100px" class="tdbg tdborder">';
echo 'Item benötigt';
echo '</td>';
echo '<td width="70px" class="tdbg tdborder">';
echo 'Verbrauch';
echo '</td>';
echo '<td width="110px" class="tdbg tdborder">';
echo 'Werte';
echo '</td>';
echo '</tr>';
$platz = 0;
$ps = 30;
$von = (($ps*$seite)-($ps-1)); // (10*1)-9 = 1; (10*2)-9 = 11 , (10*3)-9 = 21
$bis = $ps*$seite;
//Seite 1 , 1-30
//Seite 2 , 31-60
//Seite 3 , 61-90
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false
if($row['name'] != 'God Chop'){
if($clan == $row['clan']||$clan == ""||$clan == 'kein'&&$row['clan'] == ''){
if($row['typ'] == $typ||$typ == ""){
if($row['element'] == $element||$element == ""||$element == 'kein'&&$row['element'] == ''){
if($row['art'] == $art||$art == ''||$art == 6&&$row['art'] == 14){
$platz++;
if($suche == ""||$suche != ""&&strpos(strtolower($row['name']), strtolower($suche)) !== false){
if($suche == ""&&$platz >= $von&&$platz <= $bis||$suche != ""){
$req = explode(";", trim($row['req']));
$rchr = $req[1];
$hrp = $req[0];
$rkr = $req[2];
$rint = $req[3];
$rchrk = $req[4];
$rtmp = $req[5];
$rgnk = $req[6];
$rwid = $req[7];
echo '<tr height="60px">';
echo '<td width="10px" class="tdborder">';
echo $platz;
echo '</td>';
echo '<td width="50px" class="tdborder">';
echo '<img width="50px" height="50px" src="bilder/jutsus/'.$row['bild'].'a.png"></img>';
echo '</td>';
echo '<td width="100px" class="tdborder">';
echo $row['name'];
echo '</td>';
echo '<td width="70px" class="tdborder">';
echo $row['typ'];
echo '</td>';
echo '<td width="60px" class="tdborder">';
echo ucwords($row['clan']);
echo '</td>';
echo '<td width="50px" class="tdborder">';
if($row['art'] == "1"){
echo 'Schaden';
$dmg = 100;
}
if($row['art'] == "2"){
echo 'Verteidigung';
$dmg = 100;
}
if($row['art'] == "3"){
echo 'Bunshin';
$dmg = 1;
}
if($row['art'] == "4"){
echo 'Henge';
$dmg = 1;
}
if($row['art'] == "5"){
echo 'Rufen';
$dmg = 1;
}
if($row['art'] == "6"||$row['art'] == "14"){
echo 'Powerup';
$dmg = 1;
}
if($row['art'] == "7"){
echo 'Debuff';
$dmg = 1;
}
if($row['art'] == "8"){
echo 'Item werfen';
$dmg = 10;
}
if($row['art'] == "9"){
echo 'Item einnehmen';
$dmg = 1;
}
if($row['art'] == "10"){
echo 'Heilung';
$dmg = 100;
}
if($row['art'] == "11"){
echo 'Schaden (mehrere)';
$dmg = 100;
}
if($row['art'] == "12"){
echo 'Heilung (selbst)';
$dmg = 100;
}
if($row['art'] == "13"){
echo 'Spezial';
}
if($row['art'] == "15"){
echo 'Kombination';
}
if($row['art'] == "16"){
echo 'Heilung (mehrere)';
}
echo '</td>';
echo '<td width="150px" class="tdborder">';
if($row['lehrbar'] == 1){
if($hrp != 0||$rchr != 0||$rkr != 0||$rint != 0||$rchrk != 0||$rtmp != 0||$rgnk != 0||$rwid != 0&&$row['level'] != 0){
if($hrp != 0){
echo '<br>'.$hrp.' HP.';
}
if($rchr != 0){
echo '<br>'.$rchr.' Chakra.';
}
if($rkr != 0){
echo '<br>'.$rkr.' Kraft.';
}
if($rint != 0){
echo '<br>'.$rint.' Intelligenz.';
}
if($rchrk != 0){
echo '<br>'.$rchrk.' Chakrakontrolle.';
}
if($rtmp != 0){
echo '<br>'.$rtmp.' Tempo.';
}
if($rgnk != 0){
echo '<br>'.$rgnk.' Genauigkeit.';
}
if($rwid != 0){
echo '<br>'.$rwid.' Widerstand.';
}
if($row['level'] != 0){
echo '<br>Level '.$row['level'].'';
}
}
else{
echo 'Benötigt nichts.';
}
}
else{
if($row['id'] == 1||$row['id'] == 2||$row['id'] == 3||$row['id'] == 456||$row['id'] == 457){
echo 'Schon erlernt.';
}
else{
if($row['art'] == "15"){
$sql2 = 'SELECT
id,name,kombineu
FROM
jutsus
WHERE kombineu="'.$row['id'].'" LIMIT 2';

$result2 = $db->query($sql2);
if (!$result2) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}
$c = false;
while ($row2 = $result2->fetch_assoc()) { // NULL ist quivalent zu false
if($c){
echo ' + ';
}
echo $row2['name'];
$c = true;
}
$result2->close();
}
else{
echo 'Clan bedingt.';
}
}
}
echo '</td>';
echo '<td width="120px" class="tdborder">';
$array = explode(";", trim($row['item']));
$count = 0;
while(isset($array[$count])){   
echo $array[$count];
$count++;
if($array[$count] != ""){
echo '<br>';
}
}
echo '</td>';

echo '<td width="30px" class="tdborder">';
echo $row['chakra'].' Chakra';
echo '</td>';
echo '<td class="tdborder">';
if($row['art'] == "1"||$row['art'] == 15||$row['art'] == 16){
$multi = $row['dmg'];
$multi2 = $row['cdmg'];
echo $multi;
if($multi2 != 0){
echo '<br>'.$multi2.'%';
}
}
if($row['art'] == "6"||$row['art'] == "14"){
$req = explode(";", trim($row['dmg']));
if($req[0] != 0){
$inc = $req[0];
echo 'HP: '.$inc.'%';
echo '<br>';
}
if($req[1] != 0){
$inc = $req[1];
echo 'Chakra: '.$inc.'%';
echo '<br>';
}
if($req[2] != 0){
$inc = $req[2];
echo 'Kraft: '.$inc.'%';
echo '<br>';
}
if($req[3] != 0){
$inc = $req[3];
echo 'Tempo: '.$inc.'%';
echo '<br>';
}
if($req[4] != 0){
$inc = $req[4];
echo 'Intelligenz: '.$inc.'%';
echo '<br>';
}
if($req[5] != 0){
$inc = $req[5];
echo 'Genauigkeit: '.$inc.'%';
echo '<br>';
}
if($req[6] != 0){
$inc = $req[6];
echo 'Chakrakontrolle: '.$inc.'%';
echo '<br>';
}
if($req[7] != 0){
$inc = $req[7];
echo 'Widerstand: '.$inc.'%';
echo '<br>';
}
}
if($row['art'] == "7"){
$req = explode(";", trim($row['dmg']));
if($req[0] != 0){
$inc = $req[0];
echo 'Kraft: '.$inc.'%';
echo '<br>';
}
if($req[1] != 0){
$inc = $req[1];
echo 'Tempo: '.$inc.'%';
echo '<br>';
}
if($req[2] != 0){
$inc = $req[2];
echo 'Intelligenz: '.$inc.'%';
echo '<br>';
}
if($req[3] != 0){
$inc = $req[3];
echo 'Genauigkeit: '.$inc.'%';
echo '<br>';
}
if($req[4] != 0){
$inc = $req[4];
echo 'Chakrakontrolle: '.$inc.'%';
echo '<br>';
}
if($req[5] != 0){
$inc = $req[5];
echo 'Widerstand: '.$inc.'%';
echo '<br>';
}
}
if($row['art'] == "8"){
$multi = getwert($row['dmg'],"item","werte","name");
echo $multi;
}
if($row['art'] == "9"){
$multi = getwert($row['dmg'],"item","werte","name");
$req = explode(";", trim($multi));
if($req[0] != 0){
$inc = $req[0];
echo 'HP: '.$inc.'%';
echo '<br>';
}
if($req[1] != 0){
$inc = $req[1];
echo 'Chakra: '.$inc.'%';
echo '<br>';
}
if($req[2] != 0){
$inc = $req[2];
echo 'Kraft: '.$inc.'%';
echo '<br>';
}
if($req[3] != 0){
$inc = $req[3];
echo 'Tempo: '.$inc.'%';
echo '<br>';
}
if($req[4] != 0){
$inc = $req[4];
echo 'Intelligenz: '.$inc.'%';
echo '<br>';
}
if($req[5] != 0){
$inc = $req[5];
echo 'Genauigkeit: '.$inc.'%';
echo '<br>';
}
if($req[6] != 0){
$inc = $req[6];
echo 'Chakrakontrolle: '.$inc.'%';
echo '<br>';
}
if($req[7] != 0){
$inc = $req[7];
echo 'Widerstand: '.$inc.'%';
echo '<br>';
}
}
if($row['art'] == "10"){
$multi = $row['dmg'];
echo $multi;
}
if($row['art'] == "11"){
$multi = $row['dmg'];
echo $multi;
}
if($row['art'] == "12"){
$multi = $row['dmg'];
echo $multi;
}
echo '</td>';
echo '</tr>';
}
}
}
}
}
}
}
}
$result->close(); $db->close();
echo '</table>';
if($suche == ""){
$count = 1;
$anzahl = $platz;
if($platz > $ps){
while($platz > 0){
$platz = $platz-$ps;
echo '<a href="info.php?page=jutsus&seite='.$count.'&clan='.$clan.'&typ='.$typ.'&element='.$element.'&art='.$art.'">'.$count.'</a> ';
$count++;
}
}
echo '<br>Anzahl: '.$anzahl;
}

}
if($page != ""){
echo '<br><a href="info.php">Zurück</a>';

}
else{
if(!logged_in()){
echo '<br><a href="index.php">Zurück</a>';
}
}
include 'inc/design2.php';
?>