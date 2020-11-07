<?php
require('lib/db.php');
require('functions/lichsuphieu.php');

@session_start(); 

$id_arr=$_POST['id_arr']; // lưu bien mang
( $id_arr );

$mahangban_xoa = ""; $action = "";
for ($i=0;$i<count($_POST['id_arr']);$i++) 
{
	($mahangban_xoa=$id_arr[$i]);
	//echo $mahangban_xoa; ok
	unset($_SESSION['TenHangBan'][$mahangban_xoa]);
	unset($_SESSION['MaDVT'][$mahangban_xoa]);
	unset($_SESSION['SoLuong'][$mahangban_xoa]);
	unset($_SESSION['Gia'][$mahangban_xoa]);
}

if($mahangban_xoa != "")
{
	$action = "remove";
}
?>
	<script>
		setTimeout('window.location="order.php?action=<?=$action?>&mahangban_xoa=<?=$mahangban_xoa?>"',0);
	</script>
<?php
//	header('location:order.php?action=remove&mahangban_xoa=$mahangban_xoa');
//}
//else
//{
//	header('location:order.php');
//}
?>

<!--<button type="submit" class="btn" style="color:red"><a href="order.php">back</a></button> -->