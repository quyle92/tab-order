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
		setTimeout('window.location="login.php"',0);
</script>
<?php
}
$order = 0;
if(isset($_GET['order']))
{
	$order = intval($_GET['order']);
	//echo "huy order"; 
}

if($order == 1)
{
	//echo "xac nhan order";
//
$matrungtam = $_SESSION['MaTrungTam'];
$manv = $_SESSION['MaNV'];
$tennv = $_SESSION['TenNV'];
$makhu = $_SESSION['MaKhu'];
$maban = $_SESSION['MaBan'];
//
//-----------------------xử lý các giá trị post, get ------------------//
//
$malichsuphieu = "";
if(isset($_POST['malichsuphieu']))
{
	 $malichsuphieu = $_POST['malichsuphieu'];
}

if(isset($_GET['malichsuphieu']))
{
	 $malichsuphieu = $_GET['malichsuphieu'];
}
//
//----------------phiếu mới ---------------------//
//
if ($malichsuphieu == NULL || $malichsuphieu == "")
{
	$malichsuphieu = func_TaoLichSuPhieuID($conn,$matrungtam);
	//$l_sql = func_TaoLichSuPhieuID($conn,$matrungtam);
	//echo "tao ma lich su phieu: ".$malichsuphieu;
	if($malichsuphieu != "")
	{
		$l_sResult = ""; $orderid = ""; $lydo = "";

		$l_sResult = func_InsertLichSuPhieu($conn,$malichsuphieu,$makhu,$maban,$manv);
		if($l_sResult != "") echo $l_sResult;

		reset($_SESSION['TenHangBan']);
		reset($_SESSION['MaDVT']);
		reset($_SESSION['Gia']);
		reset($_SESSION['SoLuong']);

		for ($i = 0; $i< count( $_SESSION['TenHangBan']) ; $i++)
		{
			( $mahangban=key($_SESSION['TenHangBan']) );
			( $tenHB=current($_SESSION['TenHangBan']) );
			( $madvt=current($_SESSION['MaDVT']) );
			( $giaHB=intval(current($_SESSION['Gia'])) );
			$soluong=current($_SESSION['SoLuong']);
			$thanhtien=$soluong*$giaHB;

			$l_sResult = "";
			if($orderid == "")
			{
				$orderid = func_TaoOrderID($conn,$matrungtam); // chỉ tạo 1 lần
				$l_sResult = func_InsertOrder($conn,$orderid,$malichsuphieu,$manv,$tennv);
				if($l_sResult != "") echo $l_sResult;
			}

			if($orderid != "" && $l_sResult == "")
			{
				$l_sResult = func_InsertOrderChiTiet($conn,$orderid,$manv,$malichsuphieu,$mahangban,$madvt,$soluong,$giaHB,$thanhtien,$tenHB,$lydo);
				if($l_sResult != "") echo $l_sResult;
			}
	 
			next($_SESSION['TenHangBan']);
			next($_SESSION['MaDVT']);
			next($_SESSION['Gia']);
			next($_SESSION['SoLuong']);
		}//end for
	}//end insert lich su phieu
	//////////////////////TEST TAO PHIEU HANG BAN OK///////////////////////////
}
else
{
	//
	//////////////////TEST THEM MON: OK/////////////////////
	//////////////////TEST TRA MON: OK////////////////////////
	//////////////////TEST XOA MON: OK////////////////////////
	//
	//echo "them mon".$malichsuphieu;
	#################################################################################3
	//----co thông tin lịch sử phiếu ----------//
	$changeSL = 0; $hangbanmoi=""; $orderid = ""; $lydo= ""; $slsession = 0;

	if(!isset($_SESSION['TenHangBan']))
	{
		echo "test sau khi remove sp,khong con session hang ban";
	}
	else
	{
	reset($_SESSION['TenHangBan']);
	reset($_SESSION['MaDVT']);
	reset($_SESSION['Gia']);
	reset($_SESSION['SoLuong']);
	$slsession = count( $_SESSION['TenHangBan']);

	for ($i = 0; $i< count( $_SESSION['TenHangBan']) ; $i++)
	{
		$flag = 0; $changeSL = 0;

		( $mahangban=key($_SESSION['TenHangBan']) );
		( $tenHB=current($_SESSION['TenHangBan']) );
		( $madvt=current($_SESSION['MaDVT']) );
		( $giaHB=intval(current($_SESSION['Gia'])) );
		$soluong=current($_SESSION['SoLuong']);
		$thanhtien = $giaHB*$soluong;

		if($hangbanmoi == "")	//lay ds de kiem tra hang ban removed
		{
			$hangbanmoi = $mahangban;
		}
		else
		{
			$hangbanmoi = $hangbanmoi."','".$mahangban;
		}
		//
		//----kiem tra hang ban moi trong db ----//
		//
		$l_sql = "Select MaHangBan, Sum(SoLuong) as SoLuong from tblLSPhieu_HangBan Where MaLichSuPhieu like '$malichsuphieu' and MaHangBan like '$mahangban' Group by MaHangBan";
		try
		{
			$result_lsp = sqlsrv_query($conn,$l_sql);
			if($result_lsp != false)	//co hang ban cu
			{
				while($r=sqlsrv_fetch_array($result_lsp))
				{
					$r['MaHangBan'];
					$r['SoLuong'];
					
					$flag = 1;	// day hang ban cu
					$changeSL = $soluong - $r['SoLuong']; // co tang, giảm
					$thanhtien = $giaHB*$changeSL;
					//echo "sua sl".$changeSL;
				}//end while duyet hang ban cu
			}//end if co du lieu hang ban cu

			sqlsrv_free_stmt($result_lsp);
		}
		catch(Exception $e) { $flag = 0; }

		$l_sResult = "";
		if($flag == 0 || $changeSL != 0) //----có hàng bán mới hoặc thay đổi số lượng
		{
			if($orderid == "")
			{
				//echo "tao order id";
				$orderid = func_TaoOrderID($conn,$matrungtam); // chỉ tạo 1 lần
				$l_sResult = func_InsertOrder($conn,$orderid,$malichsuphieu,$manv,$tennv);
				if($l_sResult != "") echo $l_sResult;
			}
		}
		//
		//---------xu ly du lieu thay doi -------------//
		//
		if($flag == 0 && $orderid != "" && $l_sResult == "") 						
		{
			//----hang ban mới hoàn toàn ----//
			//
			$l_sResult = func_InsertOrderChiTiet($conn,$orderid,$manv,$malichsuphieu,$mahangban,$madvt,$soluong,$giaHB,$thanhtien,$tenHB,$lydo);
			if($l_sResult != "") echo $l_sResult;
		}
		elseif($flag == 1 && $changeSL != 0 && $orderid != "" && $l_sResult == "")
		{
			//----hang bán cũ thay đổi số lượng --//
			//
			if($changeSL < 0) $lydo = "Tra hang";
			$l_sResult = func_InsertOrderChiTiet($conn,$orderid,$manv,$malichsuphieu,$mahangban,$madvt,$changeSL,$giaHB,$thanhtien,$tenHB,$lydo);
			if($l_sResult != "") echo $l_sResult;
		}

		next($_SESSION['TenHangBan']);
		next($_SESSION['MaDVT']);
		next($_SESSION['Gia']);
		next($_SESSION['SoLuong']);
	}//end for duyet session hang ban
	}
	//
	//-----------xu ly viec tra hang, theo so luong > 0 neu co -------------//
	//
	if($hangbanmoi != "" || $slsession == 0) //ds hàng bán có trong session hoặc session ko có dịch vụ
	{
		$orderid = ""; $changeSL = 0; $dongia = 0;
		$tenhangban = ""; $mahangban = ""; $madvt = "";
		$l_sql = "Select MaHangBan, TenHangBan, MaDVT, DonGia, Sum(SoLuong) as SoLuong from tblLSPhieu_HangBan Where MaLichSuPhieu like '$malichsuphieu' and MaHangBan not in ('$hangbanmoi') Group by MaHangBan, TenHangBan, MaDVT, DonGia Having sum(SoLuong) > 0";
		//echo $l_sql;
		try
		{
			$result_lsp = sqlsrv_query($conn,$l_sql);
			if($result_lsp != false)	//co hang ban cu bi tra lai
			{
				while($r=sqlsrv_fetch_array($result_lsp))
				{
					$r['MaHangBan'];
					$r['TenHangBan'];
					$r['MaDVT'];
					$r['SoLuong'];
					$r['DonGia'];

					$mahangban = $r['MaHangBan'];
					$tenhangban = $r['TenHangBan'];
					$madvt = $r['MaDVT'];
					$changeSL = 0 - $r['SoLuong']; // trả hàng
					$dongia = $r['DonGia'];

					$thanhtien = $dongia*$changeSL;
					$lydo = "Huy mon";

					$l_sResult = "";
					if($orderid == "")
					{
						//echo "tao order id";
						$orderid = func_TaoOrderID($conn,$matrungtam); // chỉ tạo 1 lần
						$l_sResult = func_InsertOrder($conn,$orderid,$malichsuphieu,$manv,$tennv);
						if($l_sResult != "") echo $l_sResult;
					}

					if($changeSL != 0 && $orderid != "" && $l_sResult == "")
					{
						//----hang bán cũ tra lai het --//
						//
						$l_sResult = func_InsertOrderChiTiet($conn,$orderid,$manv,$malichsuphieu,$mahangban,$madvt,$changeSL,$dongia,$thanhtien,$tenhangban,$lydo);
						if($l_sResult != "") echo $l_sResult;
					}
				}//end while duyet ds hang ban cu tra lai
			}//end if co du lieu tra lai

			sqlsrv_free_stmt($result_lsp);
		}
		catch(Exception $e) { }
	}//end if co hang ban moi

	func_TinhTienThucTra($conn,$malichsuphieu);
}//end else co ma lich su phieu
}//end if co xac nhan order
########################
unset($_SESSION['NhapMon']);
unset($_SESSION['MaLichSuPhieu']);
unset($_SESSION['MaNhomHangBan']);
unset($_SESSION['MaHangBan']);
unset($_SESSION['ThemMonSetMenu']);
unset($_SESSION['SoLuong']);
unset($_SESSION['TenHangBan']);
unset($_SESSION['MaDVT']);
unset($_SESSION['Gia']);
?>
<!--<form>
<button type="submit" class="btn" style="color:red" name ="back" formaction="home.php">home</button>
</form> -->
<script>
	setTimeout('window.location="home.php"',0);
</script>