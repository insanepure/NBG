<?php   
function check_user($name, $pass)
{                       
include 'serverdaten.php';
      $link = mysqli_connect($host, $user, $pw);
if (!$link) {
    die('Verbindung schlug fehl: ' . mysqli_error($link));
}    
$name = mysqli_real_escape_string($link, $name);
mysqli_select_db($link, $datenbank) or die(mysqli_error($link));   
    $sql="SELECT id
    FROM charaktere
    WHERE acc='".$name."' AND pw='".$pass."'
    LIMIT 1";
    $result=mysqli_query($link, $sql) or die(mysqli_error($link));
    if (mysqli_num_rows($result)==1)
    {
        $user=mysqli_fetch_assoc($result);
        return $user['id'];
    }       
    else
    {
        return false;  
     }   
mysqli_close($link); 
}

function login($userid)
{                         
include 'serverdaten.php';
      $link = mysqli_connect($host, $user, $pw);
if (!$link) {
    die('Verbindung schlug fehl: ' . mysqli_error($link));
}    
mysqli_select_db($link, $datenbank) or die(mysqli_error($link));   
    
    $sql="UPDATE charaktere
    SET Session='".session_id()."'
    WHERE id=".$userid." LIMIT 1"; 
    mysqli_query($link, $sql); 
      echo mysqli_error($link);  
mysqli_close($link); 
}

function IsGoogle()
{
  return $_SESSION['google'] == true;
}

function logged_in()
{                 
  
include 'serverdaten.php';
      $link = mysqli_connect($host, $user, $pw);
if (!$link) {
    die('Verbindung schlug fehl: ' . mysqli_error($link));
}    
mysqli_select_db($link, $datenbank) or die(mysqli_error($link));   
    $sql="SELECT id
    FROM charaktere
    WHERE Session='".session_id()."'
    LIMIT 1";
    $result=mysqli_query($link, $sql);      
      echo mysqli_error($link);   
      return (mysqli_num_rows($result)==1);          
mysqli_close($link);
}

function logout()
{               
include 'serverdaten.php';
      $link = mysqli_connect($host, $user, $pw);
if (!$link) {
    die('Verbindung schlug fehl: ' . mysqli_error($link));
}    
mysqli_select_db($link, $datenbank) or die(mysqli_error($link));      
    $sql="UPDATE charaktere
    SET adminin='0',wksucht='0',Session=NULL
    WHERE Session='".session_id()."' LIMIT 1";
    mysqli_query($link, $sql);     
mysqli_close($link);     

}

?> 