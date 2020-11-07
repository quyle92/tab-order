<?php
require('lib/db.php');
require('functions/lichsuphieu.php');
@session_start();

date_default_timezone_set('Asia/Bangkok');

if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
		setTimeout('window.location="login.php"',0);
</script>
<?php
}

$id=$_SESSION['MaNV'];
$tenktv = $_SESSION['TenNV'];
$trungtam = "GIẢI PHÁP QUẢN LÝ BÁN HÀNG CHUYÊN NGHIỆP";

$makhu =  ""; $magiuong = "";
if(isset($_GET['makhu']))
{
	$makhu = $_GET['makhu'];
}
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
	$maphieu = $_GET['maphieu'];
}
if(isset($_GET['magiuong']))
{
	$magiuong = $_GET['magiuong'];
}
//
//	lưu lại session khi click khu
//
if($makhu != null && $magiuong != "")
{
	$_SESSION['MaKhu'] = $makhu;
	$_SESSION['MaGiuong'] = $magiuong;
}

if(isset($_SESSION['MaGiuong'])) 
{
	$magiuong = $_SESSION['MaGiuong'];
	//
	//	lay cac gia tri tu lich su phieus
	//
	$l_sql = "Select * from tblLichSuPhieu Where MaBan = '$magiuong' and DaTinhTien = 0 and PhieuHuy = 0";
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
<html>
<head>
<title>Giải pháp quản lý SPA toàn diện - ZinSPA</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Phần mềm quản lý SPA ZinSpa" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!-- Custom CSS -->
<link href="css/style1.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<link href="css/search-form-home.css" rel='stylesheet' type='text/css' />
<!-- jQuery -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style> 
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
<!-- Navigation -->
	<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand"> <?php echo $trungtam; ?></a>
				</div>



			<div class="col-md-5">
				<form action="search.php" class="search-form" method="get">
					<div class="form-group has-feedback">
						<label for="search" class="sr-only">Search</label>
						<input type="text" class="form-control" name="query" id="search" placeholder="search">
						<span class="glyphicon glyphicon-search form-control-feedback"></span>
					</div>
				</form>
			</div>
	 </nav>
 <!-- End Navigation -->
 	<div id="page-wrapper">
    <div class="col-md-12 graphs">
	<div class="xs">
		<h4>KHU</h4>  
		<form action="home.php" method="get">
       	<div class="row">
       		<div class="col-md-12" style="margin-bottom:5px">
<?php 
    $l_sql="select * from tblDMKhu Where  MaKhu in (Select MaKhu from tblDMBan Group by MaKhu) Order by MaKhu";//MaKhu like '%spa%' and
	//echo $l_sql;
	$i = 1;
	try
	{
		$rskhu=sqlsrv_query($conn, $l_sql);
		if(sqlsrv_has_rows($rskhu) != false)
		{
			while ($r1 = sqlsrv_fetch_array($rskhu))
			{
				// if($makhu == "")
					// $makhu = $r1['MaKhu'];
				if($makhu == $r1['MaKhu'])
				{
					//F9B703
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
				//echo "khu".$i;
				$i = $i + 1;
			}
		}
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
?>
			</div>
	    </div>
		</form>
		
	
		<h4>Bàn</h4>
		<form action="order.php" method="get">
		<div class="row">
			<div class="col-md-12">
				<div class="grid" >
<?php
$query = $_GET['query'];
	/*code để lấy total page*/
		if (isset($_GET['pageno'])) {
	   $pageno = $_GET['pageno'];
	} else {
		$pageno = 1;
	}
	$no_of_records_per_page = 12;
	$startRow = ($pageno-1) * $no_of_records_per_page;
	$endpoint = $startRow + $no_of_records_per_page;
	
	$total_pages_sql = "select  COUNT(*) from tblDMBan  Where MaBan LIKE '%".$query."%'";
	try
	{
		$rs_total=sqlsrv_query($conn,$total_pages_sql);
		$total_rows=sqlsrv_fetch_array($rs_total)[0];
		$total_pages = ceil($total_rows / $no_of_records_per_page);
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}

	/*End code để lấy total page*/

$min_length = 3;
 if(strlen($query) >= $min_length){
	 $query = htmlspecialchars($query); 
	 $sql_search = "SELECT * FROM
	 (
	SELECT *, ROW_NUMBER() OVER (ORDER BY MaBan) as rowNum FROM [tblDMBan] WHERE MaBan LIKE '%".$query."%' 
	) sub
	WHERE rowNum >  '$startRow' and rowNum <= '$endpoint'
	";
	try 
	{
		$rs_search=sqlsrv_query($conn,$sql_search);
		if( sqlsrv_has_rows($rs_search) != false){
			while($r2_search=sqlsrv_fetch_array($rs_search))
			{ 
				
				if($magiuong == "")  $magiuong = $r2_search['MaBan'];
				if($magiuong == $r2_search['MaBan'])
				{ ?>
					 <button type="submit" name="magiuong" value="<?php echo $r2_search['MaBan']; ?>" class="giuong_active"><?php echo $r2_search['MaBan']; ?></button>
				<?php }
				else 
				{ ?>
					<button type="submit" name="magiuong" value="<?php echo $r2_search['MaBan']; ?>" class="giuong"><?php echo $r2_search['MaBan']; ?></button>
				<?php }
				
				
				
			}
		}
		else {
			 echo "No results";
		}
		sqlsrv_free_stmt( $rs_search);
	}
	catch (Exception $e) {
		echo $e->getMessage();
	}
 }
?> 
				</div>
			</div>
			<!-- /#col-md-12 -->
		</div>
		</form>
		
	<!-- Pagination -->

	<ul class="pagination">
        <li><a href="?pageno=1&query=<?=$query?>">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo '?pageno='.($pageno - 1).'&query='.$query; } ?>">Prev</a>
        </li>
		
		<?php
		$offset=3;
		$from=$pageno-$offset;
		$to=$pageno+$offset;
		if ($from<1) {$from=1;$to=$offset*5;}
		if ($to>$total_pages)	$to=$total_pages;
		for ($j=$from;$j<=$to;$j++) {
			if ($j==$pageno) { ?>
				<li class='active'><a href='search.php?pageno=<?=$j?>&query=<?=$query?>'><?=$j?></a></li>
			<?php } else { ?>
				<li class=''><a href='search.php?pageno=<?=$j?>&query=<?=$query?>'><?=$j?></a></li>
			<?php }
		}
		?>
		
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1).'&query='.$query; } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages.'&query='.$query ?>">Last</a></li>
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
</body>
</html>