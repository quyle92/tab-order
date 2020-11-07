<?php
@session_start();
$update=$_GET['process'];
$soluong_update =$_POST['soluong_update']."<br>";
var_dump ($sku_update=$_POST['sku_update']);
for ($i=0;$i<count($_POST['soluong_update']);$i++) { //echo 11;
	echo"soluong_moi".$soluong_moi=$soluong_update; if ($soluong_moi<=0) continue;
	echo"mahangban". $mahangban=$sku_update;if ($mahangban<=0) continue;
	$_SESSION['SoLuong_moi'][$mahangban]=$soluong_moi;
}
echo "<br>".$_SESSION['SoLuong_moi'][$mahangban];
//echo '<script>history.back();</script>';
 $_SESSION['id'] = 444;