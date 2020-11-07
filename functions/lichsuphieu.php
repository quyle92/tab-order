<?php

function func_TaoLichSuPhieuID($conn,$matrungtam)
{
	// format: mã trung tâm - loại hình kd - ymd - id
	$malichsuphieu = $matrungtam."-1-".date("yymd")."-";
	$l_sql = "Select MAX(Right(MaLichSuPhieu,4)) as iMaLSP from [tblLichSuPhieu] WHERE MaLichSuPhieu like '".$matrungtam."-1-".date("yymd")."%'";
	$l_index = 0;	
	try
	{
		$result_malsp = sqlsrv_query($conn,$l_sql);
		while($rbk=sqlsrv_fetch_array($result_malsp))
		{
			$l_index = intval($rbk['iMaLSP']);
		}
		sqlsrv_free_stmt($result_malsp);
	}
	catch(Exception $e) 
	{ 
		$l_index = 0; 
	}
	
	$l_index = $l_index + 1;
	$malichsuphieu = $malichsuphieu.substr("0000", 0, 4-strlen(strval($l_index))).$l_index;
	return $malichsuphieu;
}

function func_InsertLichSuPhieu($conn,$malichsuphieu,$makhu,$maban,$manv)
{
	$l_sResult = "";
	try 
	{
		$sql = "INSERT INTO  tblLichSuPhieu (MaLichSuPhieu,MaBan,GioVao,DangNgoi,DaTinhTien,DaTraDu,MaKhachHang, SoLuongKhach,TongTien,TienGiamGia,TienThucTra,TienDichVu,NVTaoMaNV,NVTinhTienMaNV,ThoiGianTaoPhieu,MaTienTe,MaKhu,TyGia,KeyString) VALUES ('$malichsuphieu','$maban',GETDATE(),1,0,0,'','1','0','0','0','0','$manv','$manv',GETDATE(),'VND','$makhu',1,'$maban')";
		$rs=sqlsrv_query($conn,$sql);
		if($rs == false)
		{
			$l_sResult = "Loi tao hoa don.".$sql;
		}
	}
	catch (Exception $e) 
	{
    	$l_sResult = $e->getMessage();
	}
	return $l_sResult;
}

function func_TaoOrderID($conn,$matrungtam)
{
	//
	/*[tblOrder] OrderID: 03-150819-0001*/
	$orderID = $matrungtam."-".date("ymd")."-";
	$l_sql_order = "Select MAX(Right(OrderID,4)) as iMaOrder from [tblOrder] WHERE OrderID like '".$matrungtam."-".date("ymd")."%'";
	$l_index = 0;	
	try
	{
		$result_maorder = sqlsrv_query($conn,$l_sql_order);
		while($rbk=sqlsrv_fetch_array($result_maorder))
		{
			$l_index = intval($rbk['iMaOrder']);
		}
		sqlsrv_free_stmt($result_maorder);
	}
	catch(Exception $e) 
	{ 
		$l_index = 0; 
	}
			 
	$l_index = $l_index + 1;
	$orderID = $orderID.substr("0000", 0,4-strlen(strval($l_index))).$l_index;
	return $orderID;
}

function func_InsertOrder($conn,$orderid,$malichsuphieu,$manv,$tennv)
{
	$l_sResult = "";
	try 
	{
		//----set trang thai = 0 de in order bep tu dong
		$sql = "Insert into tblOrder(OrderID,MaNV,MaLichSuPhieu,ThoiGian,TrangThai,TenNV) values('$orderid','$manv','$malichsuphieu',GETDATE(),'0',N'$tennv')";
		$rs=sqlsrv_query($conn,$sql);
		if($rs == false)
		{
			$l_sResult = "Loi tao Order.".$sql;
		}
	} 
	catch (Exception $e) 
	{
    	$l_sResult = $e->getMessage();
	}
	return $l_sResult;
}

function func_InsertOrderChiTiet($conn,$orderid,$manv,$malichsuphieu,$mahangban,$madvt,$soluong,$dongia,$thanhtien,$tenhangban,$lydo)
{
	$l_sResult = "";
	try 
	{
		$sql = "Insert into tblOrderChiTiet(OrderID,MaHangBan,MaDVT,SoLuong,DonGia,YeuCauThem,ThoiGian,MaSuCo,TenHangBan,LyDo,MaNVLienQuan,GhiChuKMHB,KeyString) values('$orderid','$mahangban','$madvt','$soluong','$dongia','',GETDATE(),'',N'$tenhangban',N'$lydo','$manv','','')";
		$rs=sqlsrv_query($conn,$sql);
		if($rs == false)
		{
			$l_sResult = "Loi tao Order Chi tiet.".$sql;
		}
		//
		//----test ok
		//
		$id_hangban = $malichsuphieu."-".$mahangban."-".(string)date('His');
		$sql = "Insert into tblLSPhieu_HangBan(ID,MaLichSuPhieu,MaHangBan,TenHangBan,SoLuong,MaDVT,DonGia,ThanhTien,MaNhanVien,ThoiGianBan,MaSuCo,LyDo,
		DaXuLy,OrderID,DonGiaTT,MaTienTe,ThanhTienTT,GhiChuKMHB) values('$id_hangban','$malichsuphieu','$mahangban',N'$tenhangban','$soluong','$madvt','$dongia','$thanhtien','$manv',GETDATE(),'',N'$lydo','1','$orderid','$dongia','VND','$thanhtien','')";
		$rs=sqlsrv_query($conn,$sql);
		if($rs == false)
		{
			$l_sResult = $l_sResult.";Loi tao lsphieu hang ban.".$sql;
		}
		//
		//-----update lai tien thuc tra cho lich su phieu: ok
		//
		$sql = "Select Sum(ThanhTien) as TienHangBan From tblLSPhieu_HangBan Where MaLichSuPhieu like '$malichsuphieu'";
		$rs=sqlsrv_query($conn,$sql);
		if(sqlsrv_has_rows($rs) != false)
		{
			$tiendichvu = 0;
			while ($r1 = sqlsrv_fetch_array($rs))
			{
				$r1['TienHangBan'];
				$tiendichvu = $r1['TienHangBan'];
			}
			$sql = "Update tblLichSuPhieu Set TienDichVu = '$tiendichvu', TongTien = '$tiendichvu' where MaLichSuPhieu like '$malichsuphieu'";
			$rs=sqlsrv_query($conn,$sql);

			$sql = "Update tblLichSuPhieu Set TienThucTra = TongTien - TienCoc - TienGiamGia where MaLichSuPhieu like '$malichsuphieu'";
			$rs=sqlsrv_query($conn,$sql);
		}

		sqlsrv_free_stmt( $rs);
	} 
	catch (Exception $e) 
	{
    	$l_sResult = $e->getMessage();
	}
	return $l_sResult;
}

function func_TinhTienThucTra($conn,$malichsuphieu)
{
	$l_sResult = "";
	try 
	{
		//
		//-----update lai tien thuc tra cho lich su phieu: ok
		//
		$sql = "Select Sum(ThanhTien) as TienHangBan From tblLSPhieu_HangBan Where MaLichSuPhieu like '$malichsuphieu'";
		$rs=sqlsrv_query($conn,$sql);
		if(sqlsrv_has_rows($rs) != false)
		{
			$tiendichvu = 0;
			while ($r1 = sqlsrv_fetch_array($rs))
			{
				$r1['TienHangBan'];
				$tiendichvu = $r1['TienHangBan'];
			}
			$sql = "Update tblLichSuPhieu Set TienDichVu = '$tiendichvu', TongTien = '$tiendichvu' where MaLichSuPhieu like '$malichsuphieu'";
			$rs=sqlsrv_query($conn,$sql);

			$sql = "Update tblLichSuPhieu Set TienThucTra = TongTien - TienCoc - TienGiamGia where MaLichSuPhieu like '$malichsuphieu'";
			$rs=sqlsrv_query($conn,$sql);
		}

		sqlsrv_free_stmt( $rs);
	} 
	catch (Exception $e) 
	{
    	$l_sResult = $e->getMessage();
	}
	return $l_sResult;
}
?>
	
		
	