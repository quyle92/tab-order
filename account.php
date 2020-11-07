<?php
session_start();
require('lib/db.php');
if(!isset($_SESSION['MaNV']) && !isset($_SESSION['TenSD'])) header('location:login.php');

$manv=$_SESSION['MaNV'];
$tensd=$_SESSION['TenSD'];
$tentrungtam=$_SESSION['TenTrungTam'];

if(isset($_POST['pass']))
{
		$pass=$_POST['pass'];
		$repass=$_POST['repass'];
		//$captcha=$_POST['captcha'];
		if($pass!=$repass)
    {
		  $msg='Mật khẩu nhập lại không đúng';
    }
    else
    {
		//elseif($captcha!=$_SESSION['captcha'])
		//	$msg1='Ảnh bảo mật nhập không đúng';
		//else
		//{
			$l_sql="update tblDSNguoiSD set MatKhau=PWDENCRYPT('$pass') WHERE TenSD like '$tensd'";
			//lay ket qua query tong gia tri the
      //
			$result_doipass = sqlsrv_query($conn, $l_sql);
			if($result_doipass != false)
			{
	?>
				<script>
					window.onload=function(){
					alert("Đổi mật khẩu thành công. Đăng nhập lại để check thông tin");
						setTimeout('window.location="login.php"',0);
					}
				</script>
   <?php
			}//end if doi pass ok
			else
			{
	?>
				<script>
						alert("Đổi mật khẩu không thành công");
				</script>
	<?php
			}
		}//end else check pass
}//end if have pass
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
<link href="css/custom.css" rel="stylesheet">
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
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

  .width_input {
    width: 200px !important;
  }
  
/*quy css*/
@media (min-width:768px){
  .col-md-12 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr ;
    box-sizing: border-box;
    
    grid-row-gap: 7px;
  }
}

@media (max-width:768px){
  .col-md-12 .grid  {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    box-sizing: border-box;
    
    grid-row-gap: 7px;
  }
}
</style>
</head>
<body>
<div id="wrapper">
    <?php include 'menukhu.php'; ?>
    <div id="page-wrapper">
    <div class="col-md-12 graphs">
	  <div class="xs">
  	<h4>ĐỔI MẬT KHẨU</h4>
  	<div class="bs-example4" data-example-id="contextual-table">
    <div class="table-responsive">
     <form action="" method="post">
      <table class="table">
          <tr>
            <td width="18%"></td>
            <th width="20%" scope="row">Tên đăng nhập:</th>
            <td width="50%"><input name="id" class="width_input" type="text" size="135" value="<?php echo $tensd; ?>"></td>
            <td width="12%"></td>
          </tr>
          
          <tr>
            <td></td>
            <th scope="row">Mật khẩu mới:</th>
            <td> <input name="pass" class="width_input" type="password" size="135" required></td>
            <td></td>
          </tr>
          <tr>
            <td></td>
            <th scope="row">Nhập lại mật khẩu:</th>
            <td> <input name="repass" class="width_input" type="password" size="135" required></td>
            <td class="error"><?php echo @$msg?></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td><input name="submit" type="submit" value="Xác nhận"></td>
            <td></td>
          </tr>
      </table>
      </form>
    </div><!-- /.table-responsive -->
   </div>
  </div>
 
   </div>
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
	$('#tungay').datepicker({
		dateFormat:'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		yearRange:'-99:+0',
	})
	 
	$('#denngay').datepicker({
		dateFormat:'dd-mm-yy',
		changeMonth:true,
		changeYear:true,
		yearRange:'-99:+0',
	})

</script>   
<script>
$('.navbar-toggle').on('click', function() {
  $('.sidebar-nav').toggleClass('block');  
});
</script>
</body>
</html>
