<?php 
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();

date_default_timezone_set('Asia/Bangkok');
if (isset($_SESSION['previous'])) {
   if (basename($_SERVER['PHP_SELF']) != $_SESSION['previous']) {
        unset($_SESSION['SoLuong']);
		unset($_SESSION['TenHangBan']);
		unset($_SESSION['Gia']);
		unset($_SESSION['maphieu']);
        ### or alternatively, you can use this for specific variables:
        ### unset($_SESSION['varname']);
   }
}

if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
		//setTimeout('window.location="login.php"',0);
</script>
<?php
}

$manv=$_SESSION['MaNV'];
$tennv = $_SESSION['TenNV'];
$matrungtam = $_SESSION['MaTrungTam'];
$tentrungtam = $_SESSION['TenTrungTam'];

$makhu =  ""; $maban = "";
if(isset($_GET['makhu']))
{
	$makhu = $_GET['makhu'];
}
//var_dump ($_SESSION['makhu'] = $makhu);

if(isset($_GET['maban']))
{
	$maban = $_GET['maban'];
} 
//var_dump($_SESSION['maban'] = $maban);
//
//---xử lý có nhập món ko ?
//
$nhapmon = "0";
if(@$_GET['nhapmon'] != null)
{
	$nhapmon = @$_GET['nhapmon'];
}
else 
{
	$nhapmon = "0";
}
//	lấy giá trị get khác
//
$maphieu = ""; 
if(isset($_GET['maphieu']))
{
	var_dump ($maphieu = $_GET['maphieu']);
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
	$l_sql = "Select * from tblLichSuPhieu Where MaBan = '$maban' and DaTinhTien = 0 and PhieuHuy = 0";
	$rs3=sqlsrv_query($conn,$l_sql);
	while($r3=sqlsrv_fetch_array($rs3))
	{
		$maphieu = $r3['MaLichSuPhieu'];
		$makhach = $r3['MaKhachHang'];
		$tenkhach = $r3['TenKhachHang'];
	}
	sqlsrv_free_stmt( $rs3);
}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Giải pháp quản lý Nhà hàng chuyên nghiệp - ZinRES</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý nhà hàng ZinRes" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href="css/search-form-home.css" rel='stylesheet' type='text/css' />
<link href="css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
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

.khu_active {
    background: #F9B703;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

	.khu {
    background: #0073aa;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

.giuong_active {
    background: #F9B703;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 115px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}

	.giuong {
    background: #0073aa;
    color: #fff;
    font-size: 1em;
    border: 2px solid transparent;
    text-transform: capitalize;
    border: 2px solid transparent;
    width: 115px;
    height: 100px;
    outline: none;
    cursor: pointer;
    -webkit-appearance: none;
    padding: 0.5em 0;
    margin-top: 0em;
    margin-left: 5px;
    margin-bottom: 5px;
	}
	
/*quy css*/
	.col-md-12 .grid	{
		display: grid;
		grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr ;
		box-sizing: border-box;
		
		grid-row-gap: 7px;
	}
</style>
</head>
<body>
<div id="wrapper">
	<?php include 'menukhu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
	<div class="xs">
		<h4>KHU</h4>
        <form action="home.php" method="get">
       	<div class="row">
       		<div class="col-md-12" style="margin-bottom:5px">
<?php 
	//
	//------chuyển sang làm menu side bar
	//
    $l_sql="select a.* from tblDMKhu a, tblNVTrucKhu b Where a.MaKhu = b.MaKhu and a.MaKhu in (Select MaKhu from tblDMBan Group by MaKhu) and b.MaNhanVien like '$manv' Order by a.MaKhu";

	try
	{
		$rskhu=sqlsrv_query($conn, $l_sql);
		if(sqlsrv_has_rows($rskhu) != false)
		{
			while ($r1 = sqlsrv_fetch_array($rskhu))
			{
				if($makhu == "")
					$makhu = $r1['MaKhu'];
				if($makhu == $r1['MaKhu'])
				{
?>
          			<button type="submit" name="makhu" value="<?php echo $r1['MaKhu']; ?>" class="khu_active"><?php echo $r1['MoTa']; ?></button>
          	
<?php
				}
				else
				{
?>
          			<button type="submit" name="makhu" value="<?php echo $r1['MaKhu']; ?>" class="khu"><?php echo $r1['MoTa']; ?></button>
<?php
				}
			}
		}//end if co ds khu
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
?>
			</div>
	    </div>
	</form>
	<h4>BÀN</h4>  
	
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
    $sql="select * from (SELECT *, ROW_NUMBER() OVER (ORDER BY MaBan) as rowNum FROM [tblDMBan] Where MaKhu = '$makhu') sub WHERE rowNum >  '$startRow' and rowNum <= '$endpoint'";
	try
	{
		$rs=sqlsrv_query($conn,$sql); $mabantemp = ""; $giovao = ""; $tiendv = ""; $malichsuphieu = "";
		while($r2=sqlsrv_fetch_array($rs))	//-----duyet danh sach ban
		{
			 $mabantemp = ""; $giovao = ""; $tiendv = "";

			if($maban == "")
					$maban = $r2['MaBan']; 	//-----neu chua co ban chon thi chon ban dau tien
			//
			//
			$mabantemp = $r2['MaBan'];
			if($maban == $r2['MaBan'])
			{
?>				<form action="order.php" method="get">
				<button type="submit" name="maban" value="<?php echo $r2['MaBan']; ?>" class="giuong_active">
				<?php echo $r2['MaBan']."<br>";
				/*hiển thị info khách (nếu có)*/
				$sql="SELECT * FROM [tblLichSuPhieu] WHERE MaBan like '$maban'";
				$result = sqlsrv_query($conn,$sql);
				$i = 0;
				try	
				{
					if(sqlsrv_has_rows($result) != false) //----có du lieu
					{
						while ($r1 = sqlsrv_fetch_array($result)) 
						{
							$r1['GioVao'];
							$r1['TienThucTra'];
							$r1['MaLichSuPhieu'];

							$giovao = strval(date_format($r1['GioVao'],'d-M H:m'));
							$tiendv = strval(number_format($r1['TienThucTra'],0,",","."));
							$malichsuphieu = $r1['MaLichSuPhieu'];
						}
					}
				}
				catch (Exception $e) {
					echo $e->getMessage();
				}
				echo $giovao."<br>";
				echo $tiendv."<br>";
				//echo $makh=$r1['MaKhachHang']."<br>";
				/*End hiển thị info khách (nếu có)*/
				?>
				<input type="hidden" name="maphieu" value="<?php echo $malichsuphieu; ?>" />
				<input type="hidden" name="xora" value="yes" />
				</button>
				</form>
<?php
			}//end if ban duoc chon
			else
			{
?>				<form action="order.php" method="get">
          		<button type="submit" name="maban" value="<?php echo $r2['MaBan']; ?>" class="giuong">
				<?php echo $r2['MaBan']."<br>"; 
				/*hiển thị info khách (nếu có)*/
				$sql="SELECT * FROM [tblLichSuPhieu] WHERE MaBan like '$mabantemp'";
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

							$giovao = strval(date_format($r1['GioVao'],'d-M H:m'));
							$tiendv = strval(number_format($r1['TienThucTra'],0,",","."));
							$malichsuphieu = $r1['MaLichSuPhieu'];							
						}
					}
				}
				catch (Exception $e) {
					echo $e->getMessage();
				}
				echo $giovao."<br>";
				echo $tiendv."<br>";
				//echo $makh=$r1['MaKhachHang']."<br>";
				/*End hiển thị info khách (nếu có)*/
?>		
				<input type="hidden" name="maphieu" value="<?php echo $malichsuphieu; ?>" />
				<input type="hidden" name="xora" value="yes" />
				</button>
				</form>
<?php
			}//end else hien thi danh sach ban con lai
		}//end while danh sach ban
		sqlsrv_free_stmt( $rs);
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
	if($nhapmon == "" || $nhapmon == null || $nhapmon == "0")	// ko co đánh giá hay nhập tip thì refresh lại
	{
?>
<script>
     // var time = new Date().getTime();
     // $(document.body).bind("mousemove keypress", function(e) {
         // time = new Date().getTime();
     // });

     // function refresh() {
         // if(new Date().getTime() - time >= 5000) //5s 1 phut: 60000
             // window.location.reload(true);
         // else 
             // setTimeout(refresh, 2000);
     // }

     // setTimeout(refresh, 2000);
</script>
<?php 
	}
?>
</body>
</html>
