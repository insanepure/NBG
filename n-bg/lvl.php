<?php
$mexp = 100;
$level = 1;
$stats = 0;
$exp = 0;
$sgewin = 0;
$agewin = 0;
$astats = 0;
echo 'Level: '.$level.'<br>';    
echo 'EXP: '.$exp.'<br>';
echo 'MEXP: '.$mexp.'<br>';
echo 'Stats: '.$stats.' ('.$astats.')<br>';     
echo 'Statsg: '.$sgewin.' ('.$agewinn.')<br>';
echo '----------------------<br>';    
while($level != 70){   
$level = $level+1; 
$tempint = ($level)/10;
$tempint = ceil($tempint);
$tempint =$tempint*10;  
$exp = $exp+$mexp;
$mexp = $mexp+$tempint;     
$sgewin = round(10+1.24*$level);
$agewin = (floor(($level/2)+10));
$stats = $stats+$sgewin;        
$astats = $astats+$agewin;
echo 'Level: '.$level.'<br>';              
echo 'EXP: '.$exp.'<br>';
echo 'MEXP: '.$mexp.'<br>';
echo 'Stats: '.$stats.' ('.$astats.')<br>';     
echo 'Statsg: '.$sgewin.' ('.$agewin.')<br>';
echo '----------------------<br>';
}
?>