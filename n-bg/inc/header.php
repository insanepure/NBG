<!DOCTYPE html>
<html>
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<?php
$analyticsID = 'G-V4FKL7471M';
?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $analyticsID; ?>"></script>
<?php
$user_id_analytics = '';
$accountTag = '';
$charaTag = '';
if($account->IsLogged())
{
  $accountTag = $account->Get('id').' ('.$account->Get('login').')';
  $user_id_analytics = $account->Get('id');
  if(logged_in())
  {
    $uid = getwert(session_id(),"charaktere","id","session");
    $uname = getwert(session_id(),"charaktere","name","session");
    $charaTag = $uid.' ('.$uname.')';
  }
}
?>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('set','user_properties', {
  sessionid: '<?php echo session_id(); ?>',
  account: '<?php echo $accountTag; ?>',
  character: '<?php echo $charaTag; ?>'
  });
  gtag('config', '<?php echo $analyticsID; ?>' <?php if($user_id_analytics != '') { ?>,{ 'user_id': '<?php echo $user_id_analytics; ?>' } <?php } ?>);
</script>  
<script src="https://www.google.com/recaptcha/api.js?render=6LdMP7kUAAAAABZPx7qz5I5snHzWntPFMT__E-lu"></script>
<script>
grecaptcha.ready(function() {
  grecaptcha.execute('6LdMP7kUAAAAABZPx7qz5I5snHzWntPFMT__E-lu', {action: 'homepage'}).then(function(token) {
              // Verify the token on the server.
              document.getElementById('g-recaptcha-response').value = token;
              document.getElementById("captcha").style.display="block";
              document.getElementById("captcha_text").style.display="none";
              });
          });
</script>
<?php
$fileName = ucwords(basename($_SERVER['SCRIPT_NAME'], '.php'));
if($fileName == 'Index')
  $fileName = 'Das Naruto Browsergame';
?>
  
<title>NBG - <?php echo $fileName; ?></title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico?v=2"/>
<meta http-equiv="content-type" content="text/html; charset=utf-8"> 
<meta http-equiv="pragma" content= "cache">
<meta name="viewport" content="width=device-width, initial-scale=0.42">
<meta name="Page-type" content="HTML-Formular">
<meta name="Robots" content="INDEX,FOLLOW">
<meta http-equiv="content-language" content= "de">
<meta name="description" content="NBG ist das Naruto Browsergame basierend auf dem berühmten Anime Naruto. Werde ein Ninja in dem Dorf Konohagakure , Sunagakure und weitere und tauche in einer Welt voller spannende Kämpfe ein. Es ist das Naruto Browsergame !" />
<meta name="abstract" content="NBG ist das Naruto Browsergame basierend auf dem berühmten Anime Naruto. Werde ein Ninja in dem Dorf Konohagakure , Sunagakure und weitere und tauche in einer Welt voller spannende Kämpfe ein. Es ist das Naruto Browsergame !">
<meta name="keywords" content= "Naruto, Naruto Browsergame, anime, RPG, BG, NBG, NarutoBG, Online, online, Rollenspiel, browsergame, naruto, manga, ninja, kampf, dorf, konhagakure, sunagakure, kirigakure, otogakure">
<meta name="author" content= "André Braun">
<meta name="publisher" content= "André Braun">
<meta name="copyright" content= "André Braun">
<meta name="audience" content="Alle">
<meta name="page-topic" content="Browsergame, Naruto, Onlinespiel">
<meta name="revisit after" content= "1 days">
<link rel="stylesheet" type="text/css" href="css/main.css?004" />    
<?php
    
$design = getwert(session_id(),"charaktere","design","session");
if(!$design){
$design = 'naruto';
}
echo '<link rel="stylesheet" type="text/css" href="css/'.$design.'.css"/>'; 
?>  
<link rel="stylesheet" type="text/css" href="css/reg.css" />
<link rel="stylesheet" type="text/css" href="css/kampf.css?002" />
<script type="text/javascript" src="js/skripts.js?002"></script>
<script type="text/javascript" src="js/timer.js?06"></script>
</head>
<body>