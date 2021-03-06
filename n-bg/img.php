<?php
function get_domain($url)
{
      $urlobj=parse_url($url);
      $domain=$urlobj['host'];
      if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $regs)) {
        return $regs['domain'];
      }
      return false;
}

if(isset($_GET['url']))
{
  $url = $_GET['url'];
  if(get_domain($url) == 'n-bg.de')
  {
    header('Location: '.$url);
    exit;
  }
  
  $path_parts = pathinfo($url);
  if($path_parts['extension'] != 'jpg' && $path_parts['extension'] != 'png' && $path_parts['extension'] != 'bmp' && $path_parts['extension'] != 'jpeg')
  {
    $url = 'img/noimg.jpg';
    header('Location: '.$url);
    exit;
  }
  
  $size = getimagesize($url);
  $fp = fopen($url, "rb");
  if ($size && $fp) 
  {
      header("Cache-Control: max-age=2592000"); //30days (60sec * 60min * 24hours * 30days)
      header("Content-type: {$size['mime']}");
      fpassthru($fp);
      exit;
  }
}
?>