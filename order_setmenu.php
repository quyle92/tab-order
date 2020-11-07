<?php 
@session_start();

$themsetmenu = 0;
if(isset($_POST['themsetmenu']))
{
  	 $themsetmenu = $_POST['themsetmenu'];

  	 if(isset($_SESSION['ThemMonSetMenu']))
  	 {
  	   $_SESSION['ThemMonSetMenu']=$themsetmenu;  //ok
	   }
}
?>