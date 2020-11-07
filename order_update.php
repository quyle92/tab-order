<?php 
@session_start();

$mahangban = ""; $soluong = 0;
if(isset($_POST['mahangban']))
{
  	$mahangban = $_POST['mahangban'];
  	$soluong = $_POST['soluong'];

  	if(isset($_SESSION['TenHangBan']))
  	{
  		reset($_SESSION['TenHangBan']);
		  reset($_SESSION['MaDVT']);
		  reset($_SESSION['Gia']);
		  reset($_SESSION['SoLuong']);  

  		($_SESSION['SoLuong'][$mahangban]=$soluong);  //ok
	 }
}
?>