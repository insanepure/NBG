<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'../../../main/www/classes/session.php';
ini_set("log_errors", 0);
error_reporting(E_ALL ^ E_DEPRECATED);

$userRegisterActive = true;
$userLoginActive = true;
$charaCreationActive = true;


 function getmicrotime(){
list($usec, $sec) = explode(" ",microtime());
return ((float)$usec + (float)$sec);
}

$time_start = getmicrotime(); //Am Kopf der Sei
include_once 'inc/serverdaten.php';   
include_once $_SERVER['DOCUMENT_ROOT'].'../../../main/www/classes/header.php';
include_once 'inc/funct.php'; 
include_once 'inc/sessionhelpers.php';  
$update = getwert(1,"game","onoff","id");  

$logged = $account->IsLogged();
if($logged && $account->IsValid() && $account->IsBannedInGame('NBG'))
{
  $error = 'Du wurdest aus folgendem Grund vom Spiel gebannt: '.$account->GetBanReason().'.';
  $account->Logout();
  $logged = false;
}

if($update == ""){     
if(!logged_in()){   
if($account->IsLogged())
{

  if(isset($_POST['GoogleCrawler']))
  {
    $googleChara = 329;
    $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
    mysqli_select_db($con, $datenbank) or die(mysqli_error($con)); 
    $ip = get_real_ip();
    $sql = 'UPDATE charaktere SET session="'.session_id().'",ip="'.$ip.'" WHERE id="'.$googleChara.'" LIMIT 1';
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));  
    setcookie("id", $id,time()+60*60*24*30);   //30 Tagee
    mysqli_close($con);
  }
  else if(basename($_SERVER['PHP_SELF']) != 'main_login.php' && basename($_SERVER['PHP_SELF']) != 'charregister.php')
  {
    if(is_numeric($_COOKIE['id']))
    { 
      include_once 'inc/serverdaten.php';  
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con));
      $sql = 'SELECT id,main FROM charaktere WHERE id="'.$_COOKIE['id'].'" LIMIT 1';
      $result = mysqli_query($con, $sql) or die(mysqli_error($con));   
      $row = mysqli_fetch_assoc($result);
      if($row['main'] == $account->Get('id')){   
        $ip = get_real_ip();
        $sql = 'UPDATE charaktere SET session="'.session_id().'",ip="'.$ip.'" WHERE id="'.$row['id'].'" LIMIT 1';
        $result = mysqli_query($con, $sql) or die(mysqli_error($con));  
      }
      else{     
      setcookie("id", '',time()-10);   
        header('Location: main_login.php');
      }  
      mysqli_close($con);
    }
    else
    {
      header('Location: main_login.php');
    }
  }
}
} 
if(logged_in()){     
  

$uname = getwert(session_id(),"charaktere","name","session");  
LoginTracker::TrackUser($accountDB, $account->Get('id'), $uname, 'nbgv2', $account->Get('password'), $account->Get('email'), session_id(), $account->GetIP(), $account->GetRealIP());   
  
$uid = getwert(session_id(),"charaktere","id","session");   
$uaktion = getwert(session_id(),"charaktere","aktion","session");   
//if($uadmin != 2) {   
//header("refresh: 1; url=test.php");

//}
if($_GET['aktion'] == "logout"){                    
header("refresh: 1; url=index.php");
}
//damit man net ausgeloggt wird
did(session_id());       
$uaktion = getwert(session_id(),"charaktere","aktion","session");   
$uclan = getwert(session_id(),"charaktere","clan","session");     
$ujutsus = getwert(session_id(),"charaktere","jutsus","session");       
$array = explode(";", trim($ujutsus));  
$count = 0;           
$edo = 0;
while($array[$count] != ''){
if($array[$count] == 406){
$edo = 1;
}
$count++;
}   
$count = 0;
if($uclan == "inuzuka"||$uclan == 'kugutsu'||$uclan == 'jiongu'||$uclan == 'sakon'||$uclan == 'admin'||$edo == 1){
$db = @new mysqli($host, $user, $pw, $datenbank);
if (mysqli_connect_errno()) {
die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
}
$sql = 'SELECT
id,
aktion,
aktions,
aktiond,
besitzer
FROM
summon
WHERE besitzer="'.$uid.'" AND aktion != "" LIMIT 10';
$result = $db->query($sql);
if (!$result) {
die ('Etwas stimmte mit dem Query nicht: '.$db->error);
}                     
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
while ($row = $result->fetch_assoc()) { // NULL ist quivalent zu false 
$saktiond = $row['aktiond'];
$saktions = $row['aktions'];      
$test2 = strtotime($zeit);
$test = strtotime($saktions); 
$test3 = $test2-$test;
$test4 = ($saktiond*60)-$test3; 
if($test4 <= 0&&$ukid == 0){
saktion($row['aktion'],$row['id'],$uclan,$edo);
}

}
$result->close(); $db->close(); 
}
if($uaktion != ""&&$ukid == 0){     
$aktiond = getwert(session_id(),"charaktere","aktiond","session");
$uaktions = getwert(session_id(),"charaktere","aktions","session");            
$zeit2 = time();
$zeit = date("YmdHis",$zeit2);
$test2 = strtotime($zeit);
$test = strtotime($uaktions); 
$test3 = $test2-$test;
$test4 = ($aktiond*60)-$test3;   
if($test4 <= 0){
uaktion($uaktion);  
}
}  
}

}
else{
$admin = getwert(session_id(),"charaktere","admin","session");
$adminin = getwert(session_id(),"charaktere","adminin","session");
if($admin != 3&&$adminin == 0){
header("Location: offline.php");
}
} 
?>