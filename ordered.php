<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');

@session_start();	//session_destroy();
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('Asia/Bangkok');
$_SESSION['previous'] = basename($_SERVER['PHP_SELF']);
//
//------------xử lý session của user ---------------//
//
if(!isset($_SESSION['MaNV'])) 
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
//----------------------lấy các thông tin post, get -------------------//
//
//----------------------mã lịch sử phiếu, mã bàn --------------------------------------//
//
//	lấy giá trị get khác
//
$malichsuphieu = ""; $maban = "";
if(isset($_GET['malichsuphieu']))
{
	$malichsuphieu= $_GET['malichsuphieu'];
}
if(isset($_POST['malichsuphieu']))
{
	$malichsuphieu= $_POST['malichsuphieu'];
}

if(isset($_SESSION['MaLichSuPhieu'])) 
{
	$malichsuphieu = $_SESSION['MaLichSuPhieu'];
}
//
if(isset($_GET['maban']))
{
	$maban = $_GET['maban'];
}

if(isset($_POST['maban']))
{
	$maban = $_POST['maban'];
} 

if(isset($_SESSION['MaBan'])) 
{
	$maban = $_SESSION['MaBan'];
}
else
{
	$_SESSION['MaBan'] = $maban;
}

if($maban==null or $maban=="") 
{ 
?> 
	<script> alert('chưa có mã bàn');</script>
<?php 
}
//
//echo $maban;
//
$action = "";
if(isset($_GET['action']))
{
	$action=$_GET['action'];
}
//
//-----------------------mã nhóm hàng, hàng bán -----------------------//
//
$manhomhangban =  ""; $mahangban = "";$mahangban_xoa = "";
if(isset($_GET['manhomhangban']) )
{
	$manhomhangban = $_GET['manhomhangban'];
}

if(isset($_POST['mahangban']))
{
	echo "$-POST-mahangban: ". $mahangban = $_POST['mahangban'];
	
	$l_sql = "Select * from tblDMHangBan WHERE MaHangBan = '$mahangban'";
	$rs7=sqlsrv_query($conn,$l_sql);
	while($r7=sqlsrv_fetch_array($rs7))
	{
		echo "</br>MaNhomHangBan: ". $manhomhangban = $r7['MaNhomHangBan'];
	}
	sqlsrv_free_stmt( $rs7);
}

if(isset($_GET['mahangban']))
{
	echo "</br>$-GET-mahangban: ".$mahangban = $_GET['mahangban'];

	$l_sql = "Select * from tblDMHangBan WHERE MaHangBan = '$mahangban'";
	$rs5=sqlsrv_query($conn,$l_sql);
	while($r5=sqlsrv_fetch_array($rs5))
	{
		echo "</br>MaNhomHangBan: ". $manhomhangban = $r5['MaNhomHangBan'];

	}
	sqlsrv_free_stmt( $rs5);
}

if(isset($_GET['mahangban_xoa']))
{
	 $mahangban_xoa = $_GET['mahangban_xoa'];
}
//
//---xử lý có nhập món ko ?
//
$chonmon = "0";
if(@$_GET['chonmon'] != null)
{
	$chonmon = @$_GET['chonmon'];
}
else 
{
	$chonmon = "0";
}
//
//	lưu lại session khi click nhóm hàng
//
if($manhomhangban != null & $mahangban != "")
{
	$_SESSION['MaNhomHangBan'] = $manhomhangban;
	$_SESSION['MaHangBan'] = $mahangban;
} 

$_SESSION['MaHangBan'] = $mahangban;

if ($action=="remove") 
{
	//settype($idDT,'int'); if ($mahangban<=0) return;
	unset($_SESSION['SoLuong'][$mahangban_xoa]);
	unset($_SESSION['TenHangBan'][$mahangban_xoa]);
	unset($_SESSION['Gia'][$mahangban_xoa]);
}

if ($action=="remove-all") 
{ 
	unset($_SESSION['SoLuong']);
	unset($_SESSION['TenHangBan']);
	unset($_SESSION['Gia']);
}

//var_dump( $id_arr=$_POST['id_arr'] )."<br>"; //print_r($id_arr);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý Nhà hàng chuyên nghiệp - ZinRES</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý Nhà hàng ZinRes" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script
src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
crossorigin="anonymous">
</script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<style> 
/*--new menu 19042020 ---*/
.li-level1
{
  padding: 8px 8px 8px 5px;
}

.menu-level1 {
  font-size: 14px;
  color: #818181;
}

.menu-level1:hover {
  color: #f1f1f1;
}

.menu-level2 {
  padding: 8px 8px 8px 15px;
  font-size: 14px;
  color: #818181;
}

.menu-level2:hover {
  color: #f1f1f1;
}

.sidenav {
  height: 100%;
  width: 200px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

/* Style the sidenav links and the dropdown button */
.sidenav a, .dropdown-btn {
  padding: 8px 8px 8px 5px; /*top right bottom left*/
  text-decoration: none;
  font-size: 14px;
  color: #818181;
  display: block;
  border: none;
  background: none;
  width: 100%;
  text-align: left;
  cursor: pointer;
  outline: none;
}

/* On mouse-over */
.sidenav a:hover, .dropdown-btn:hover {
  color: #f1f1f1;
}

/* Main content */
.main {
  margin-left: 200px; /* Same as the width of the sidenav */
  font-size: 20px; /* Increased text to enable scrolling */
  padding: 0px 10px;
}

/* Add an active class to the active dropdown button */
.active {
  background-color: green;
  color: white;
}

/* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
.dropdown-container {
  display: none;
  background-color: #262626;
  padding-left: 12px;
  line-height: 2em;
}

/* Optional: Style the caret down icon */
.fa-caret-down {
  float: right;
  padding-right: 8px;
}

/* Some media queries for responsiveness */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 12px;}
}

/*-----end style new menu 19042020*/

#myDIV {
    margin: 10px; /*original: 25px */
    width: 100%; /*original: 550px */
    background: orange;
    position: relative;
    font-size: 20px; /*original: 20px */
    text-align: center;
    -webkit-animation: mymove 3s infinite; /* Chrome, Safari, Opera 4s */
    animation: mymove 3s infinite;
}

@media (min-width:768px){	
.titledieutour {
  font-size: 2em;
	}
}

/* Chrome, Safari, Opera from {top: 0px;}
    to {top: 200px;}*/
@-webkit-keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

@keyframes mymove {
    from {top: 0px;}
    to {top: 0px;}
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.nhomhb_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
	}

	.nhomhb {
    background: #0073aa;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0 0;
    margin-top: 1em;
    margin-right: 8px;
    margin-bottom: 0px;
	}

.hangban_active {
    background: #F9B703;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

	.hangban {
    background: #0073aa;
    color: #fff;
    font-size: 0.8em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 112px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

#page-wrapper {
	margin: 0 0 0 0px !important;
}
</style>
</head>
<body>
<div id="wrapper">
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
	<div class="xs">
       	<div class="row">
       		<div class="col-sm-6 col-md-8" style="margin-bottom:5px">
			<h4>NHÓM HÀNG BÁN</h4>Mã phiếu: <?=$malichsuphieu?>
				<form action="order.php" method="get">	
				<div class="grid">
<?php 
/*code để lấy total page*/
	if (isset($_GET['pageno_nhb'])) {
	   $pageno_nhb = $_GET['pageno_nhb'];
	} else {
		$pageno_nhb = 1;
	}
	$no_of_records_per_page = 6;
	$startRow = ($pageno_nhb-1) * $no_of_records_per_page;
	$endpoint = $startRow + $no_of_records_per_page;
	$total_pages = 3;
/*End code để lấy total page*/
	
	//
	//------------------------------danh sách nhóm hàng ----------------------//
	//
	$l_sql="select * from (SELECT *, ROW_NUMBER() OVER (ORDER BY ThuTuTrinhBay) as rowNum FROM tblDMNhomHangBan) sub WHERE rowNum >  '$startRow' and rowNum <= '$endpoint'"; 
	try
	{
		$rsnhomhb=sqlsrv_query($conn, $l_sql);
		if(sqlsrv_has_rows($rsnhomhb) != false)
		{
			while ($r1 = sqlsrv_fetch_array($rsnhomhb))
			{
				if($manhomhangban == "")
				 	$manhomhangban = $r1['Ma'];

				if($manhomhangban == $r1['Ma'])
				{
?>		
					<input type="hidden" name="maban" value="<?=$maban;?>" />
					<input type="hidden" name="malichsuphieu" value="<?=$malichsuphieu;?>" />
					<button type="submit" name="manhomhangban" value="<?php echo $r1['Ma']; ?>" class="nhomhb_active"><?php echo $r1['Ten']; ?></button>
<?php
				}
				else
				{
?>				
					<input type="hidden" name="maban" value="<?=$maban;?>" />
					<input type="hidden" name="malichsuphieu" value="<?=$malichsuphieu;?>" />
					<button type="submit" name="manhomhangban" value="<?php echo $r1['Ma']; ?>" class="nhomhb"><?php echo $r1['Ten']; ?></button>
<?php
				}
			}
		}//end if co ds nhom hang ban
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
?>
				</div>
				</form>
<!-- ---------------------NHÓM HÀNG BÁN Pagination -------------------------->
		<ul class="pagination">
        	<li><a href="?pageno_nhb=1&manhomhangban=<?=$manhomhangban?>&malichsuphieu=<?=$malichsuphieu?>">First</a></li>
        	<li class="<?php if($pageno_nhb <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno_nhb <= 1){ echo '#'; } else { echo '?pageno_nhb='.($pageno_nhb - 1).'&manhomhangban='.$manhomhangban.'malichsuphieu='.$malichsuphieu; } ?>">Prev</a>
        	</li>
		
<?php
	$from=$pageno_nhb-3;
	$to=$pageno_nhb+3;
	if ($from<=0) $from=1;  $to=3*4;
	if ($to>$total_pages)	$to=$total_pages;
	for ($j=$from;$j<=$to;$j++) 
	{
		if ($j==$pageno_nhb) 
		{ 
?>
			<li class='active'><a href='order.php?pageno_nhb=<?=$j?>&manhomhangban=<?=$manhomhangban?>&malichsuphieu=<?=$malichsuphieu?>'><?=$j?></a></li>
<?php 
		} 
		else 
		{ 
?>
			<li class=''><a href='order.php?pageno_nhb=<?=$j?>&manhomhangban=<?=$manhomhangban?>&malichsuphieu=<?=$malichsuphieu?>'><?=$j?></a></li>
<?php 
		}
	}
?>		
        	<li class="<?php if($pageno_nhb >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno_nhb >= $total_pages){ echo '#'; } else { echo "?pageno_nhb=".($pageno_nhb + 1).'&manhomhangban='.$manhomhangban.'malichsuphieu='.$malichsuphieu; } ?>">Next</a>
        	</li>
        	<li><a href="?pageno_nhb=<?php echo $total_pages.'&manhomhangban='.$manhomhangban ?>&malichsuphieu=<?=$malichsuphieu?>">Last</a></li>
    	</ul>
<!--------------------- NHÓM HÀNG BÁN Pagination End--------------------------->

<!----------------------HÀNG BÁN ---------------------------------------------->
		<h4 style="margin: 20px 0;">HÀNG BÁN</h4> 
			<form action="order.php" method="get">
			<div class="grid" style="margin-left: -10px;">	  
<?php
	if (isset($_GET['pageno'])) 
	{
	   $pageno = $_GET['pageno'];
	} 
	else 
	{
		$pageno = 1;
	}
	
	$no_of_records_per_page = 6;
	$startRow = ($pageno-1) * $no_of_records_per_page;
	$endpoint = $startRow + $no_of_records_per_page;
					
	$total_pages_sql = "select  COUNT(*) from tblDMHangBan  Where MaNhomHangBan = '$manhomhangban'";
	try
	{
		$rs_total=sqlsrv_query($conn,$total_pages_sql);
		$total_rows=sqlsrv_fetch_array($rs_total)[0];
		$total_pages = ceil($total_rows / $no_of_records_per_page);
	}
	catch (Exception $e) 
	{
		echo $e->getMessage();
	}
	//		   
	//$sql="select e.MaHangBan, e.TenHangBan from tblDMHangBan e Where MaNhomHangBan = '$manhomhangban' Order by e.ThuTuTrinhBay ";
	$sql="select MaHangBan, TenHangBan,MaNhomHangBan from (SELECT *, ROW_NUMBER() OVER (ORDER BY ThuTuTrinhBay) as rowNum FROM tblDMHangBan   Where MaNhomHangBan = '$manhomhangban') sub WHERE rowNum >  '$startRow' and rowNum <= '$endpoint'";
	try
	{
		$rs=sqlsrv_query($conn,$sql);
		$i=1;
		while($r2=sqlsrv_fetch_array($rs))
		{
			if($mahangban == $r2['MaHangBan'] )
			{ 
?>
				<input type="hidden" name="maban" value="<?=$maban;?>"  />
				<input type="hidden" name="malichsuphieu" value="<?=$malichsuphieu;?>" />
				<button type="submit" name="mahangban" value="<?php echo $r2['MaHangBan']; ?>" class="hangban_active"><span><?php echo $r2['TenHangBan']; ?></span></button>
<?php
			}
			else
			{	
?>
				<input type="hidden" name="maban" value="<?=$maban;?>"  />
				<input type="hidden" name="malichsuphieu" value="<?=$malichsuphieu;?>"  />
				<input type="hidden" name="pageno" value ="<?=$pageno?>"/>
				<button type="submit" name="mahangban" value="<?php echo $r2['MaHangBan']; ?>" class="hangban"><span><?php echo $r2['TenHangBan']; ?></span></button>
<?php
			}
		}//end while duyet danh sach hang ban
		
		sqlsrv_free_stmt( $rs);
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}				
?>
			</div>	
			</form>
<!-- ----------------------Begin Pagination cho hang ban ---------------------->
		<ul class="pagination">
        	<li><a href="?pageno=1&manhomhangban=<?=$manhomhangban?>&malichsuphieu=<?=$malichsuphieu?>">First</a></li>
        	<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo '?pageno='.($pageno - 1).'&manhomhangban='.$manhomhangban.'malichsuphieu='.$malichsuphieu; } ?>">Prev</a>
        	</li>
<?php
	$from=$pageno-3;
	$to=$pageno+3;
	if ($from<=0) $from=1;  $to=3*5;
	if ($to>$total_pages)	$to=$total_pages;
	for ($j=$from;$j<=$to;$j++) 
	{
		if ($j==$pageno) 
		{ 
?>
			<li class='active'><a href='order.php?pageno=<?=$j?>&manhomhangban=<?=$manhomhangban?>&malichsuphieu=<?=$malichsuphieu?>'><?=$j?></a></li>
<?php 
		} 
		else 
		{ 
?>
			<li class=''><a href='order.php?pageno=<?=$j?>&manhomhangban=<?=$manhomhangban?>&malichsuphieu=<?=$malichsuphieu?>'><?=$j?></a></li>
<?php 
		}
	}//end for duyet paging
?>
        	<li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1).'&manhomhangban='.$manhomhangban.'malichsuphieu='.$malichsuphieu; } ?>">Next</a>
        	</li>
        	<li><a href="?pageno=<?php echo $total_pages.'&manhomhangban='.$manhomhangban ?>&malichsuphieu=<?=$malichsuphieu?>">Last</a></li>
    	</ul>
<!-- ------End Pagination cho hang ban ------------------------------------>
		</div>
<!-------------------Xu ly form Order Review ------------------------------>
		
		<div class="col-sm-6 col-md-4" style="margin-bottom:5px">
<!-----------------------------SHIPPING METHOD ---------------------------->
			<div class="panel panel-default">
				<div class="panel-heading text-center"><h4>Danh mục được chọn</h4></div>
				<div class="panel-body" style="padding: 2px;">
				   	<table class="table borderless">
					<form method="post" action="order.php?action=update">
						<tbody>
						<tr>
							<td class="text-center">
								<button type="submit" class="btn btn-warning"  formaction="remove-selected.php" name="malichsuphieu" value="<?=$malichsuphieu?>">
									<i class="fa fa-trash-o"></i>
									<input type="hidden" name="maban" value="<?=$maban;?>" />
								</button>
								<input type="checkbox" id="checkAll">
							</td>
							<td class="col-md-12">Tên Sản Phẩm</td>
							<td class="text-center soluong">SL</td>
							<td class="text-center tien">Tiền</td>
							<td class="text-center">
								<!-- <div  class="btn btn-danger" style="margin-left: 20px;">
									<a href="order.php?action=remove-all&malichsuphieu=<?php //$malichsuphieu?>&maban=<?php //$maban?>"><i class="fa fa-times-circle" style="color:#fff"></i></a>
								</div>-->
							</td>
						</tr>
							<!-- foreach ($order->lineItems as $line) or some such thing here -->
<?php
	$tenhangban = ""; $giaban = 0;
	if (isset($_SESSION['MaHangBan'])) 
	{
		/*loại bỏ null array element*/
		if(isset($_SESSION['Gia']))
		{
			foreach ($_SESSION['Gia'] as $mahangban => $gia) 
			{
				if ( $gia == null) 
				{
    				unset ($_SESSION['TenHangBan'][$mahangban]);
    				unset ($_SESSION['SoLuong'][$mahangban]);
					unset ($_SESSION['Gia'][$mahangban]);
				}
			}
		}
		/*End loại bỏ null array element*/
		$mahangban = $_SESSION['MaHangBan'];
		if(!isset($_SESSION['TenHangBan'])) 
		{
			$_SESSION['TenHangBan']=array(); 
		}

		if(!isset($_SESSION['Gia']))
		{
			$_SESSION['Gia']=array();
		}
		
		if(!isset($_SESSION['SoLuong']))
		{
			$_SESSION['SoLuong']=array();
		}
	//
	//	lay cac gia tri tu lich su phieu
	//
	//print_r ($_SESSION['TenHangBan']);
	//end($_SESSION['TenHangBan']);echo $key=key($_SESSION['TenHangBan']);
		if ($action!="update" and $action!="remove" ) 
		{ 
			//echo "add";
			if (!array_key_exists($mahangban,$_SESSION['TenHangBan'])) 
			{
				$l_sql = "Select a.*, b.Gia from tblDMHangBan a, tblGiaBanHang b Where a.MaHangBan = b.MaHangBan and a.MaHangBan = '$mahangban'";
				$rs3=sqlsrv_query($conn,$l_sql);
				$r3=sqlsrv_fetch_array($rs3);
									
				$_SESSION['TenHangBan'][$mahangban]=$r3['TenHangBan'];
				$_SESSION['Gia'][$mahangban]=$r3['Gia'];
				$_SESSION['SoLuong'][$mahangban]=1;
				
				sqlsrv_free_stmt( $rs3);
			}
		}
	
		if ($action=="update") 
		{
			( $soluong_arr =$_POST['soluong_arr'] );
			( $mahangban_arr=$_POST['mahangban_arr'] ); 
			count($_POST['mahangban_arr']);
		
			for ($i=0;$i<count($_POST['mahangban_arr']);$i++) 
			{
				"<br>".$soluong=$soluong_arr[$i];
				settype($soluong,'int'); 
				if ($soluong==0) continue;
			 	"<br>".$mahangban=$mahangban_arr[$i];
			 	settype($mahangban,'int');
			 	if ($mahangban<=0) continue;
				
				$l_sql_update = "Select a.*, b.Gia from tblDMHangBan a, tblGiaBanHang b Where a.MaHangBan = b.MaHangBan and a.MaHangBan = '$mahangban'";
				$rs4=sqlsrv_query($conn,$l_sql_update);
				$r4=sqlsrv_fetch_array($rs4);
				
				$_SESSION['TenHangBan'][$mahangban]=$r4['TenHangBan'];
				($_SESSION['Gia'][$mahangban]=$r4['Gia']);
			 	($_SESSION['SoLuong'][$mahangban]=$soluong); 
			 	//echo count( $_SESSION['TenHangBan'] ); 
				sqlsrv_free_stmt( $rs4);
			}
		}
	
		if ($_GET['xora']=="yes" )
		{
			if ($malichsuphieu!= null OR $malichsuphieu!= "" ) 
			{
				$sql="SELECT MaLichSuPhieu, MaHangBan, TenHangBan,DonGia, Sum(SoLuong) as SoLuong  from [tblLSPhieu_HangBan] Where Malichsuphieu like '$malichsuphieu' group by MaLichsuphieu, MaHangBan, TenHangBan,DonGia having sum(SoLuong) > 0";//group by những thằng ko sum lại
				$rs=sqlsrv_query($conn,$sql);
			
				while ($r=sqlsrv_fetch_array($rs))
				{
					$mahangban=$r['MaHangBan'];//echo "<br>";
				
					$_SESSION['TenHangBan'][$mahangban]=$r['TenHangBan'];
					$_SESSION['Gia'][$mahangban]=$r['DonGia'];

					if ($action=="update") 
					{
						++$_SESSION['SoLuong'][$mahangban];
					}
					else 
						$_SESSION['SoLuong'][$mahangban]=intval($r['SoLuong']);
					
					//++$_SESSION['SoLuong'][$mahangban]
					//$_SESSION['SoLuong'][$mahangban]=$r['SoLuong'];
				}
			}
		}//end if $_GET['xora']
		
		/*this is to avoid empty arra element*/
		if (array_key_exists("",$_SESSION['SoLuong'])) 
		{
			unset($_SESSION['SoLuong'][""]);
		}
			
		if (array_key_exists("",$_SESSION['TenHangBan'])) 
		{
			unset($_SESSION['TenHangBan'][""]);
		}
		
		if (array_key_exists("",$_SESSION['Gia'])) 
		{
			unset($_SESSION['Gia'][""]);
		}
		/*end of this is to avoid empty arra element*/
	 	
	 	($_SESSION['TenHangBan']);
	 	($soluong=($_SESSION['SoLuong']));
	 	($_SESSION['Gia']);
	
		reset($_SESSION['TenHangBan']);
		reset($_SESSION['Gia']);
		reset($_SESSION['SoLuong']);  
		//var_dump(($_SESSION['SoLuong'][$mahangban]));//20142712001 
		//$tongtien = $tongsoluong = 0;
	
		for ($i = 0; $i< count( $_SESSION['TenHangBan']) ; $i++)
		{ 
			( $mahangban=key($_SESSION['TenHangBan']) );
			( $tenHB=current($_SESSION['TenHangBan']) );
			( $giaHB=current($_SESSION['Gia']) );
		 	$soluong=current($_SESSION['SoLuong']);
			$tien=$soluong*$giaHB;
			@$tongtien+=$tien;
			number_format(@$tongtien,0,",",".");
			
			if ($tenHB!="" and $_GET['xora']=="yes")
			{ 
?>
				<tr>
					<td class="text-center">
						<input type="checkbox" name="id_arr[]" value="<?=$mahangban?>" />
					</td>
					<td class="col-md-12">
						<div class="media">
					 <!--<a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://lorempixel.com/460/250/" style="width: 72px; height: 72px;"> </a>-->
					 		<div class="media-body">
								<h5 class="media-heading"><?=$tenHB?></h5>
								<h5 class="media-heading"> SKU: <?=$mahangban?> </h5>
					 		</div>
						</div>
					</td>
					<td class="text-center soluong">
			    		<div class="numbers-row" style="display: flex;">
							<button type="button" class="btn btn-danger btn-number" value="-" style="height: 34px;">
								<i class="fa fa-minus" aria-hidden="true"></i>
							</button>
							<input type="text" name="soluong_arr[]" class="form-control input-number"  value="<?=$tenHB!=""?$soluong:"0"?>"  oninput="validity.valid||(value='');" style="border:1px solid #808080!important; border-radius:0px!important;width:45%"/>
				
				 			<button type="button" class="btn btn-success btn-number"  value="+"  style="height: 34px;">
								<i class="fa fa-plus" aria-hidden="true"></i>
				 			</button>
						</div>
					</td>
					<input type="hidden" value="<?=$mahangban?>" name="mahangban_arr[]" />
					<td class="text-center tien"><?=number_format($tien,0,",",".")?><sup>đ</sup></td>

				<!--<td class="text-right"><button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>-->
	
					<td class="text-right"></td>
				</tr>
<?php 
			} 
			elseif ($tenHB!="" and empty($_GET['xora']))
			{
?>
				<tr>
					<td class="text-center">
						<input type="checkbox" name="id_arr[]" value="<?=$mahangban?>" />
					</td>
					<td class="col-md-12">
						<div class="media">
					 		<!--<a class="thumbnail pull-left" href="#"> <img class="media-object" src="http://lorempixel.com/460/250/" style="width: 72px; height: 72px;"> </a>-->
					 		<div class="media-body">
								<h5 class="media-heading"><?=$tenHB?></h5>
								<h5 class="media-heading"> SKU: <?=$mahangban?> </h5>
							</div>
						</div>
					</td>
					<td class="text-center soluong">
						<div class="numbers-row"  style="display: flex;">
							<button type="button" class="btn btn-danger btn-number" value="-" style="height: 34px;">
							<i class="fa fa-minus" aria-hidden="true"></i>
							</button>
				
							<input type="text" name="soluong_arr[]" class="form-control input-number"  value="<?=$tenHB!=""?$soluong:"0"?>"  oninput="validity.valid||(value='');" style="border:1px solid #808080!important; border-radius:0px!important;width:45%"/>
				
				  			<button type="button" class="btn btn-success btn-number"  value="+"  style="height: 34px;">
							<i class="fa fa-plus" aria-hidden="true"></i>
							</button>
						</div>
					</td>
					<input type="hidden" value="<?=$mahangban?>" name="mahangban_arr[]" />
					<td class="text-center tien"><?=number_format($tien,0,",",".")?><sup>đ</sup></td>

					<!--<td class="text-right"><button type="submit" class="btn btn-info"><i class="fa fa-refresh"></i></button></td>-->
	
					<td class="text-right"></td>
				</tr>
<?php	
			}//elseif tenhb !=nul and xoa

			next($_SESSION['TenHangBan']);
			next($_SESSION['Gia']);
			next($_SESSION['SoLuong']);
		}//end for duyet danh sach ten hang ban
	}//end if isset SESSION MaHangBan
?>
				<tr>
					<td class="text-center"></td>
					<td class="col-md-12">Tổng tiền</td>
<?php
	/*this is to avoid empty array element*/
	if (array_key_exists("",$_SESSION['SoLuong'])) 
	{
		unset($_SESSION['SoLuong'][""]);
	}
	
	if (array_key_exists("",$_SESSION['TenHangBan'])) 
	{
		unset($_SESSION['TenHangBan'][""]);
	}
	
	if (array_key_exists("",$_SESSION['Gia'])) 
	{
		unset($_SESSION['Gia'][""]);
	}
	
	//var_dump($_SESSION['TenHangBan']);
	foreach ( $_SESSION['TenHangBan'] as $id => $ten ) 
	{
    	if ( $ten ==null  ) 
    	{
        	unset($_SESSION['TenHangBan'][$id]);
        	unset ($_SESSION['SoLuong'][$id]);
        
    	}
	}
	///var_dump($_SESSION['SoLuong']);
	reset($_SESSION['SoLuong']);
	for ($i=0;$i<count($_SESSION['SoLuong']);$i++) 
	{ 
		($soluong=current($_SESSION['SoLuong']));
		($tongsoluong+=$soluong); 
		next($_SESSION['SoLuong']); 
	}
?>
					<td class="text-center"><?=@$tongsoluong;?></td>
					<td class="text-center tien"><?=number_format(@$tongtien,0,",",".");?><sup>đ</sup></td>
					<input type="hidden" name ="mahangban" value="<?=$mahangban?>" style="width:107px;" />
					<td class="text-right"></td>
				</tr>
					<td class="text-center">
						<button type="submit" class="btn" style="color:red" name ="malichsuphieu" value="<?=$malichsuphieu?>" formaction="home.php">Hủy Bỏ</button>
						<input type="hidden" name="maban" value="<?=$maban?>"/>
					</td>
					<td class="text-center">
						<button type="submit" class="btn" style="color:red" name ="malichsuphieu" value="<?=$malichsuphieu?>" formaction="xac-nhan.php">Xác nhận</button>
					</td>
					<td class="text-center">
						<input type="hidden" name="maban" value="<?=$maban?>" />	
						<button type="submit" class="btn btn-info" name="malichsuphieu" value="<?=$malichsuphieu;?>"><i class="fa fa-refresh"></i>
						</button>
					</td>
				<tr></tr>
			</tbody>
			</form>
			</table>
		</div>
		</div>
<!----------------------END SHIPPING METHOD END-------------------------->
		</div>
<!----------------------End of Order Review Form------------------------->
	    </div>
	</div>   
	<!-- /div class="xs" -->
  	</div>
	<!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<script type="text/javascript" src="js/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<link href="js/jquery-ui-1.12.1.custom/jquery-ui.min.css" rel="stylesheet" /> 
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
   
});
</script>
<script type="text/javascript">
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
  $(".btn-number").on("click", function() {

    var $button = $(this);
    var oldValue =  $button.parent().find(".input-number").val();

    if  ($button.val() == "+" ) {
  	  var newVal = parseFloat(oldValue) + 1;
  	} else {
     
        var newVal = parseFloat(oldValue) - 1;
	   
	  }

    $button.parent().find(".input-number").val(newVal);

  });
</script>
<script>
		$("#checkAll").click(function () {
     $('input:checkbox').prop('checked', this.checked);
 });
</script>
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
	if($chonmon == "" || $chonmon == null || $chonmon == "0")	// ko co đánh giá hay nhập tip thì refresh lại
	{
?>
<!--<script>
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
</script>-->
<?php 
	}
?>
<!-- Select last recent order-->
<?php
$sql="SELECT TOP 1000 
      a.*

  FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan] a
  INNER JOIN (
  SELECT  [MaLichSuPhieu], max (OrderID) as OrderID
  FROM [GOLDENLOTUS_Q3].[dbo].[tblLSPhieu_HangBan]
   GROUP BY [MaLichSuPhieu]
 )b
  ON   a.[OrderID] =  b.[OrderID]
   WHERE a.[MaLichSuPhieu]='$malichsuphieu'
		";
?>
<!-- End select last recent order-->
</body>
</html>
