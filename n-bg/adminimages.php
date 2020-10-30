<?php
include 'inc/incoben.php';
// Hier kommen Skripts hin die vorm Laden ausgeführt werden
if(logged_in()){

$admin = getwert(session_id(),"charaktere","admin","session");   
$uid = getwert(session_id(),"charaktere","id","session");
if($admin == 3){
  
if(isset($_GET['a']) && $_GET['a'] == 'delete')
{
  $path = 'bilder/'.$_GET['directory'].'/';
  $fileWithPath = $path.$_POST['file'];
if (!unlink($fileWithPath)) {  
  $message = 'Das Bild <b>'.$_POST['file'].'</b> in <b>'.$path.'</b> konnte nicht gelöscht werden.';
}  
else 
{  
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con));                                      
      $zeit2 = time();
      $zeit = date("d.m.Y H:i:s",$zeit2);
      $text = '<b>'.$zeit.'</b>;'.$uid.';hat das Bild <b>'.$_POST['file'].'</b> in <b>'.$path.'</b> gelöscht.';   
      $adminlog = getwert(1,"game","adminlog","id");
      if($adminlog == ""){
      $adminlog = $text;
      }
      else{
      $adminlog = $text.'@'.$adminlog;
      }    
      $sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
      mysqli_query($con, $sql);   
      mysqli_close($con); 
  $message = 'Das Bild '.$_POST['file'].' in '.$path.' wurde gelöscht.';
}  
  
}
else if(isset($_GET['a']) && $_GET['a'] == 'upload' && isset($_GET['directory']))
{
    if(isset($_FILES['file_upload']) && $_FILES['file_upload']['size'] != 0)
    {
      $path = 'bilder/'.$_GET['directory'].'/';
      $imgHandler = new ImageHandler($path);
      $result = $imgHandler->Upload($_FILES['file_upload'], $image, 2000, 2000, false);
      $imagename = $_FILES['file_upload']['name'];
      
      $message = 'Bild <b>'.$imagename.'</b> wurde in <b>'.$path.'</b> erfolgreich hochgeladen.';
      
      $con=mysqli_connect($host, $user, $pw) or die(mysqli_error($con));
      mysqli_select_db($con, $datenbank) or die(mysqli_error($con));                                      
      $zeit2 = time();
      $zeit = date("d.m.Y H:i:s",$zeit2);
      $text = '<b>'.$zeit.'</b>;'.$uid.';hat das Bild '.$imagename.' hochgeladen.';   
      $adminlog = getwert(1,"game","adminlog","id");
      if($adminlog == ""){
      $adminlog = $text;
      }
      else{
      $adminlog = $text.'@'.$adminlog;
      }    
      $sql="UPDATE game SET adminlog ='$adminlog' LIMIT 1";  
      mysqli_query($con, $sql);   
      mysqli_close($con); 
      
      switch($result)
      {
        case -1:
          $message = 'Die Datei ist zu groß.';
          break;
        case -2:
          $message = 'Die Datei ist ungültig.';
          break;
        case -3:
          $message = 'Es ist nur jpg, jpeg und png erlaubt.';
          break;
        case -4:
          $message = 'Der Name ist schon vergeben.';
          break;
        case -5:
          $message = 'Es gab ein Problem beim hochladen.';
          break;
      }
    }   
}  
  
}
}
?>
<?php //lädt jetzt erst das Design
if(logged_in()){
include 'inc/design1.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}

$admin = getwert(session_id(),"charaktere","admin","session");   
if($admin == 3){
$validDirectories = array('items', 'jutsus', 'news', 'npcs', 'orte', 'map'); 
?>
<h2>Bilder Verwaltung</h2>
<br/>
<?php echo $message.'<br/>'; ?>
<br/>
<?php
foreach ($validDirectories as &$directory) 
{
  if(isset($_GET['directory']) && $_GET['directory'] == $directory)
  {
  ?>- <b><a href="adminimages.php?directory=<?php echo $directory; ?>"><?php echo ucwords($directory); ?></a></b> -<?php
  }
  else
  {
  ?>- <a href="adminimages.php?directory=<?php echo $directory; ?>"><?php echo ucwords($directory); ?></a> -<?php
  }
}
?>
<br/>
<hr>
<br/>
<?php
if(isset($_GET['directory']) && in_array($_GET['directory'], $validDirectories))
{
?>

<form name="form1" action="adminimages.php?directory=<?php echo $_GET['directory']; ?>&a=upload" method="post" enctype="multipart/form-data">   
<input type="file" name="file_upload" accept=".png"/><input type="hidden" name="image"/>
<br/>
<br/>
<input type="submit" value="Hochladen">
</form>
<br/>
<hr>

<table>
<?php
  $path    = 'bilder/'.$_GET['directory'];
  $files = scandir($path);
  $files = array_diff(scandir($path), array('.', '..'));
  $i = 0;
  foreach ($files as &$file) 
  {
    if($i == 0)
    {
      ?><tr><?php
    }
    ?>
    <td width="200px;" height="200px">
    <div style="height:200px; width:200px; float:left; ">
      <img src="<?php echo $path.'/'.$file; ?>" width="100px" height="100px"></img><br/>
      <?php echo $file; ?> <br/>
      <form method="POST" action="adminimages.php?directory=<?php echo $_GET['directory']; ?>&a=delete">
        <input type="hidden" value="<?php echo $file; ?>" name="file">
        <input type="submit" value="Löschen">
      </form>
    </div>
    </td>
    <?php
    ++$i;
    if($i == 3)
    {
      $i = 0;
      ?></tr><?php
    }
  }
 ?>
</table>
<?php
}
}
  
}
//nicht eingeloggt , zeige Loginfenster
else{
include 'inc/design3.php';
if($error != ""){
echo '<br><div id="textdiv2" class="shadow">'.$error.'</div>';
}
include 'inc/mainindex.php';
}
include 'inc/design2.php'; ?>