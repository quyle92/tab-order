<?php
$sql="SELECT * FROM [tblLichSuPhieu] a LEFT JOIN [tblDMBan] b ON a.MaBan=b.MaBan WHERE Dangngoi=1";
$result = sqlsrv_query($conn,$sql);
try	{
		if(sqlsrv_has_rows($result) != false) {
			while ($r1 = sqlsrv_fetch_array($result)) {
				 $makh=$r1['MaKhachHang']."<br>";
				//echo $tienDV=number_format($r1['TienDichVu'],0,",",".")."<br>";
				//echo $giovao=date_format($r1['GioVao'],'d-M H:m');//h:mA for 12hr-format
			}
		}
	}
catch (Exception $e) {
	echo $e->getMessage();
	}
	
	