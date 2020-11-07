<?php
require('lib/db.php');
@session_start();
$action=$_GET['action'];
 ($id_arr=$_POST['id_arr']); echo "<br>"; print_r($id_arr);
 print_r($_SESSION['SoLuong'][$id_arr])
if ($action=="remove-selected") { 
	for ($i=0;$i<count($_POST['id_arr']);$i++) {echo "aa";
	unset($_SESSION['SoLuong'][$id_arr]);
	unset($_SESSION['TenHangBan'][$id_arr]);
	unset($_SESSION['Gia'][$id_arr]);
	}
}