<?php
require('lib/db.php');
require('functions/lichsuphieu.php');

@session_start();//session_destroy();
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('Asia/Bangkok');

if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
		//setTimeout('window.location="login.php"',0);
</script>
<?php
}
if(isset($_POST['maphieu']))
{
	 $maphieu = $_POST['maphieu'];
}
if(isset($_GET['maphieu']))
{
	 $maphieu = $_GET['maphieu'];
}
if(isset($_SESSION['maphieu']))
{
	 $maphieu = $_SESSION['maphieu'];
}
var_dump ($maphieu);
var_dump ($magiuong = $_SESSION['magiuong']);
 ($makhu = $_SESSION['makhu'] );
if ($maphieu != NULL OR $maphieu != "") {
/*[tblLichSuPhieu] MaLichSuPhieu: 03-1-20150823-0456 */
	"<br>".$tongtien=$_SESSION['tongtien'];//$_SESSION['tongtien']
	$sql_tong_tien = "SELECT TongTien FROM [tblLichSuPhieu] WHERE  MaLichSuPhieu = '$maphieu' ";
	try
	{
		$result_tong_tien = sqlsrv_query($conn,$sql_tong_tien);
		echo $r_tong_tien = sqlsrv_fetch_array($result_tong_tien)[0];
	}
	catch(Exception $e)
	{
		echo $e->getMessage();
	}
	$tongtien=$r_tong_tien-$tongtien;
/* End [tblLichSuPhieu] MaLichSuPhieu: 03-1-20150823-0456 */
	echo $sql = "
	UPDATE  tblLichSuPhieu SET TongTien = '$tongtien', TienThucTra = '$tongtien', TienDichVu = '$tongtien' WHERE MaLichSuPhieu = '$maphieu';
	DELETE FROM tblOrder WHERE OrderID=''
	 ";
	 $stmt = sqlsrv_query($conn, $sql);
	
	
}

?>
<button type="submit" class="btn" style="color:red"><a href="order.php">back</a></button>