<?php 
require('lib/db.php');
require('lib/restaurant.php');
require('functions/lichsuphieu.php');
@session_start();
$restaurant = new Restaurant;

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

$client_id = isset( $_GET['client_id'] ) ? $_GET['client_id'] : "";
if( !empty( $client_id ))
	$delete_client = $restaurant->deleteClient( $client_id );
?>
<!DOCTYPE HTML>
<html>
<head>
<?php include("head-tag.php"); ?>

<script>

$(document).ready(function() {
    $.noConflict();

    $('#customers_list').DataTable();
} );

//remove query string after page load 
$(document).ready(function(){
   var href = window.location.href,
       newUrl = href.substring(0, href.indexOf('?'))
   window.history.replaceState({}, '', newUrl);
});


</script>
</head>
<body>
<div id="wrapper">
	<?php include 'menukhu.php'; ?>
    <div id="page-wrapper">
	    <div class="col-md-12 graphs">
	    	<?php
	    		if( isset( $_SESSION['insert_error'] ) )
			    {
			    	echo '<div class="alert alert-danger" >' . 
                         $_SESSION['insert_error'] .
                      '</div>';
                      unset($_SESSION['insert_error']);
			    }

                if( isset($_SESSION['insert_success']))
                {
                	echo '<div class="alert alert-success" >' . 
                         $_SESSION['insert_success'] .
                      '</div>';
                      unset($_SESSION['insert_success']);
                }

			    if( isset( $_SESSION['update_error'] ) )
			    {
			    	echo '<div class="alert alert-danger" >' . 
                         $_SESSION['update_error'] .
                      '</div>';
                      unset($_SESSION['update_error']);
			    }

                if( isset($_SESSION['update_success']))
                {
                	echo '<div class="alert alert-success" >' . 
                         $_SESSION['update_success'] .
                      '</div>';
                      unset($_SESSION['update_success']);
                }

                if( isset( $_SESSION['delete_error'] ) )
			    {
			    	echo '<div class="alert alert-danger" >' . 
                         $_SESSION['delete_error'] .
                      '</div>';
                      unset($_SESSION['delete_error']);
			    }

                if( isset($_SESSION['delete_success']))
                {
                	echo '<div class="alert alert-success" >' . 
                         $_SESSION['delete_success'] .
                      '</div>';
                      unset($_SESSION['delete_success']);
                }
						    
			?>
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#client_form">Thêm khách hàng</button>

			 <!-- Modal -->
			<div class="modal fade" id="client_form" tabindex="-1" role="dialog" aria-labelledby="client_form" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Thông tin khách hàng</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -22px;">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			    <form action="process/new-client.php" method="post" >
			      <div class="modal-body">
			      		<div class="container">
							<input type="hidden" class="form-control" name="client_id" value="' . $r['MaDoiTuong'] . '">
							<div class="row">
							  <div class="col-md-4">
							  <div class="row">
							    <div class="col-md-4 col-xs-3 col-sm-4"><label class="control-label text-right" >Tên</label></div>
							    <div class="col-md-8 col-xs-9 col-sm-8"><input type="text" class="form-control" name="client_name" value="" required></div>
							    </div>
							  </div>
							</div>
							<br>
							<div class="row">
							  <div class="col-md-4">
							  <div class="row">
							    <div class="col-md-4 col-xs-3 col-sm-4"><label class="control-label text-right">Địa chỉ</label></div>
							    <div class="col-md-8 col-xs-9 col-sm-8"><input type="text" class="form-control"  name="client_address" value=""></div>
							    </div>
							  </div>
							</div>
							<br>
							<div class="row">
							  <div class="col-md-4">
							  <div class="row">
							    <div class="col-md-4 col-xs-3 col-sm-4"><label class="control-label text-right" >SĐT</label></div>
							    <div class="col-md-8 col-xs-9 col-sm-8"><input type="text" class="form-control" name="client_tel" value=""></div>
							    </div>
							  </div>
							</div>
						</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Save changes</button>
			      </div>
			  	</form>
			    </div>
			  </div>
			</div>
			<!-- End Modal -->

  			<table id="customers_list" class="display" style="width:100%">
		        <thead>
		            <tr>
		                <th>Mã KH</th>
		                <th>Tên KH</th>
		       			<th>Địa chỉ</th>
		                <th>SĐT</th>
		                <th>Sửa/ Xóa</th>
		            </tr>
		        </thead>
		        <tbody>
		        	<?php
		        	$customers_list = $restaurant->getCustomersList(); 
		        	for( $i = 0; $i < sqlsrv_num_rows($customers_list); $i++ )
		        	{ 
		        		$r = sqlsrv_fetch_array($customers_list);
		        	?>
		            <tr>
		                <td><?=$r['MaDoiTuong']?></td>
		                <td><?=$r['TenDoiTuong']?></td>
		                <td><?=$r['DiaChi']?></td>
		                <td><?=$r['DienThoai']?></td>
		                <td><a href="#"  class="btn btn-info" data-toggle="modal" data-target="#client_form_<?=$r['MaDoiTuong']?>">Sửa</a> 
		                		<a href="?client_id=<?=$r['MaDoiTuong']?>" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this item?');">Xóa</a></td>

		           <!-- Modal -->
			<div class="modal fade" id="client_form_<?=$r['MaDoiTuong']?>" tabindex="-1" role="dialog" aria-labelledby="client_form" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Thông tin khách hàng</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -22px;">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			    <form action="process/client-edit.php" method="post" id="client_edit">
			      <div class="modal-body">
			      		<div class="container">

			      			<?php
			      			$output = "";
							//$ma_khach_hang = $_POST['ma_khach_hang'];
							$ma_khach_hang = $r['MaDoiTuong'];
							$client_info = $restaurant->getClientInfo($ma_khach_hang);
							$r = sqlsrv_fetch_array($client_info);

							echo $output = '
							<input type="hidden" class="form-control" name="client_id" value="' . $r['MaDoiTuong'] . '">
							<div class="row">
							  <div class="col-md-4">
							  <div class="row">
							    <div class="col-md-4 col-xs-3 col-sm-4"><label class="control-label text-right" >Tên</label></div>
							    <div class="col-md-8 col-xs-9 col-sm-8"><input type="text" class="form-control" name="client_name" value="' . $r['TenDoiTuong'] . '"></div>
							    </div>
							  </div>
							</div>
							<br>
							<div class="row">
							  <div class="col-md-4">
							  <div class="row">
							    <div class="col-md-4 col-xs-3 col-sm-4"><label class="control-label text-right">Địa chỉ</label></div>
							    <div class="col-md-8 col-xs-9 col-sm-8"><input type="text" class="form-control"  name="client_address" value="'. $r['DiaChi'] . '"></div>
							    </div>
							  </div>
							</div>
							<br>
							<div class="row">
							  <div class="col-md-4">
							  <div class="row">
							    <div class="col-md-4 col-xs-3 col-sm-4"><label class="control-label text-right" >SĐT</label></div>
							    <div class="col-md-8 col-xs-9 col-sm-8"><input type="text" class="form-control" name="client_tel" value="' . $r['DienThoai'] . '"></div>
							    </div>
							  </div>
							</div>
							';
							?>
						</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-primary">Save changes</button>
			      </div>
			  	</form>
			    </div>
			  </div>
			</div>
			<!-- End Modal -->
		            </tr>
		            <?php 
		        	}
		            ?>
		        </tbody>
		        <tfoot>
		            <tr>
		                <th>Mã KH</th>
		                <th>Tên KH</th>
		       			<th>Địa chỉ</th>
		                <th>SĐT</th>
		                <th>Sửa/ Xóa</th>
		            </tr>
		        </tfoot>
    		</table>




  		</div>
	<!-- /div class="col-md-12 graphs"-->
    </div>
    <!-- /#page-wrapper -->
</div>

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
	if(@$nhapmon == 0)	// ko co dang nhap mon
	{
?>
<script>
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });


</script>
<?php 
	}
?>
</body>
</html>
