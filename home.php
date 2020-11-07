<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();

date_default_timezone_set('Asia/Bangkok');
if (isset($_SESSION['previous'])) {
   if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
        unset($_SESSION['SoLuong']);
		unset($_SESSION['TenHangBan']);
		unset($_SESSION['MaDVT']);
		unset($_SESSION['Gia']);
		unset($_SESSION['MaLichSuPhieu']);
		unset($_SESSION['NhapMon']);
        ### or alternatively, you can use this for specific variables:
        ### unset($_SESSION['varname']);
   }
}

if(!isset($_SESSION['MaNV'])) //------check session nhân viên, ko có thoát ra đăng nhập lại
{
?>
<script>
	setTimeout('window.location="login.php"',0);
</script>
<?php
}

$manv=$_SESSION['MaNV'];
$tennv = $_SESSION['TenNV'];
$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];
//
//--------------------XỬ LÝ KHU, BÀN ----------------------//
//
$makhu = $_SESSION['MaKhu']; 
if(isset($_GET['makhu']))
{
	$makhu = $_GET['makhu']; //---check ok
}
//
//var_dump ($_SESSION['makhu'] = $makhu);
$maban = "";
if(isset($_GET['maban']))
{
	$maban = $_GET['maban'];
} 
//
//	lưu lại session khi click khu
//
if($makhu != null && $maban != "")
{
	$_SESSION['MaKhu'] = $makhu;
	$_SESSION['MaBan'] = $maban;
}

if(isset($_SESSION['MaBan'])) 
{
	$maban = $_SESSION['MaBan'];
	//
	//	lay cac gia tri tu lich su phieus
	//
	$l_sql = "Select * from tblLichSuPhieu Where MaBan = '$maban' and DaTinhTien = 0 and PhieuHuy = 0 and ThoiGianDongPhieu is null";
	$rs3=sqlsrv_query($conn,$l_sql);
	while($r3=sqlsrv_fetch_array($rs3))
	{
		$malichsuphieu = $r3['MaLichSuPhieu'];
		$makhachhang = $r3['MaKhachHang'];
		$tenkhachhang = $r3['TenKhachHang'];
	}

	sqlsrv_free_stmt( $rs3);
}
//
//
$malichsuphieu = ""; $tenkhachhang = "";
if(isset($_GET['malichsuphieu']))
{
	$malichsuphieu = $_GET['malichsuphieu'];
	//var_dump ($malichsuphieu = $_GET['malichsuphieu']);
}
//
//------------set trạng thái cờ để refresh trang ---------//
//
$nhapmon = 0;
if(isset($_SESSION['NhapMon']))
{
	$nhapmon = $_SESSION['NhapMon'];
}
else 
{
	$nhapmon = 0;
}

?>
<!DOCTYPE HTML>
<html>
<head>
<?php include("head-tag.php"); ?>
</head>
<body>
<div id="wrapper">
	<?php include 'menukhu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
	<div class="xs">
	<h4>DANH SÁCH BÀN</h4>
	<div class="row">
		<div class="col-md-12">
			<div class="grid">
<?php 
	if (isset($_GET['pageno'])) {
	   $pageno = $_GET['pageno'];
	} else {
		$pageno = 1;
	}
	$no_of_records_per_page = 20; //18
	$startRow = ($pageno-1) * $no_of_records_per_page;
	$endpoint = $startRow + $no_of_records_per_page;
	
	$total_pages_sql = "select  COUNT(*) from [tblDMBan]  Where MaKhu = '$makhu'";
	try
	{
		$rs_total=sqlsrv_query($conn,$total_pages_sql);
		$total_rows=sqlsrv_fetch_array($rs_total)[0];
		$total_pages = ceil($total_rows / $no_of_records_per_page);
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
	//
	//----------------danh sach ban ------------------------//
	//
  $makhu = '01-LT1';
     $sql="select * from (SELECT *, ROW_NUMBER() OVER (ORDER BY MaBan) as rowNum FROM [tblDMBan] Where MaKhu = '$makhu') sub WHERE rowNum >  '$startRow' and rowNum <= '$endpoint'";
	try
	{
		$mabantemp = ""; $giovao = ""; $tiendv = ""; $malichsuphieutemp = ""; $tenkhachhang = "";

		$rs=sqlsrv_query($conn,$sql); 
		while($r2=sqlsrv_fetch_array($rs))	//-----duyet danh sach ban
		{
			$r2['MaBan'];
			$mabantemp = ""; $giovao = ""; $tiendv = ""; $malichsuphieutemp = "";
			$mabantemp = $r2['MaBan'];
			//
			//
			if($maban == "")
					$maban = $r2['MaBan']; 	//-----neu chua co ban chon thi chon ban dau tien
?>				
			<form action="order.php" method="get">
<?php
			$sql="SELECT * FROM [tblLichSuPhieu] WHERE MaBan like '$mabantemp' and DaTinhTien = 0 and ThoiGianDongPhieu is null";
			$result = sqlsrv_query($conn,$sql);
			try	
			{
				if(sqlsrv_has_rows($result) != false) 
				{
					while ($r1 = sqlsrv_fetch_array($result)) 
					{
						$r1['GioVao'];
						$r1['TienThucTra'];
						$r1['MaLichSuPhieu'];
						$r1['TenKhachHang'];

						$giovao = strval(date_format($r1['GioVao'],'H:m'));
						$tiendv = strval(number_format($r1['TienThucTra'],0,",","."));
						$malichsuphieutemp = $r1['MaLichSuPhieu'];	
						$tenkhachhang = $r1['TenKhachHang'];
					}
				}
			}
			catch (Exception $e) {
				echo $e->getMessage();
			}
			
			if($malichsuphieutemp != "")
			{
				//echo $malichsuphieutemp; ok
?>
				<button type="submit" name="maban" value="<?php echo $mabantemp; ?>" class="ban_cokhach">
<?php
			}
			else
			{
?>
				<button type="submit" name="maban" value="<?php echo $mabantemp; ?>" class="ban_trong">
<?php
			}
					echo $mabantemp."<br>"; 
					echo $giovao."<br>";
					echo $tenkhachhang."<br>";
					echo $tiendv."<br>";
?>
				<input type="hidden" name="malichsuphieu" value="<?php echo $malichsuphieutemp; ?>" />
				<input type="hidden" name="xora" value="yes" />
				</button>
			</form>
<?php
		}//end while danh sach ban

		sqlsrv_free_stmt( $rs); //-----giải phóng bộ nhớ
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}			
?>
			</div>
			<!-- end grid -->
		</div>
		<!-- /#col-md-12 -->
	</div>
	
	<!-- Pagination -->

	<ul class="pagination">
        <li><a href="?pageno=1&makhu=<?=$makhu?>">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo '?pageno='.($pageno - 1).'&makhu='.$makhu; } ?>">Prev</a>
        </li>
		
		<?php
		$offset=10;
		$from=$pageno-$offset;
		$to=$pageno+$offset;
		if ($from<=0) $from=1;  $to=$offset*5;
		if ($to>$total_pages)	$to=$total_pages;
		for ($j=$from;$j<=$to;$j++) {
			if ($j==$pageno) { ?>
				<li class='active'><a href='home.php?pageno=<?=$j?>&makhu=<?=$makhu?>'><?=$j?></a></li>
			<?php } else { ?>
				<li class=''><a href='home.php?pageno=<?=$j?>&makhu=<?=$makhu?>'><?=$j?></a></li>
			<?php }
		}
		?>
		
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1).'&makhu='.$makhu; } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages.'&makhu='.$makhu ?>">Last</a></li>
    </ul>
		<!-- Pagination End-->
	</div>   
	<!-- /div class="xs" -->
  	</div>
	<!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<!-- Nav CSS -->

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" /> 
<script>
	/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
  	this.classList.toggle("active");
  	var dropdownContent = this.nextElementSibling;
  	if (dropdownContent.style.display === "block") {
  		dropdownContent.style.display = "none";
  	} else {
  		dropdownContent.style.display = "block";
  	}
  });
}
</script>
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
<?php
	if($nhapmon == 0)	// ko co dang nhap mon
	{
?>
<script>
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         if(new Date().getTime() - time >= 5000) //5s 1 phut: 60000
             window.location.reload(true);
         else 
             setTimeout(refresh, 2000);
     }

     setTimeout(refresh, 2000);
</script>
<?php 
	}
?>
</body>
</html>
