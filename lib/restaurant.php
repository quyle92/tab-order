<?php
class DbConnection {

	protected $serverName = "DELL-PC\SQLEXPRESS";
	protected $connectionInfo = array( "Database"=>"NH_STEAK_PIZZA","CharacterSet" => "UTF-8", "UID"=>"sa", "PWD"=>"123");
	protected $conn;

	function __construct() {
			$this->conn =  sqlsrv_connect( $this->serverName, $this->connectionInfo) or die("Database Connection Error"."<br>". mssql_get_last_message()); 
    }
}
class Restaurant extends DbConnection {

	function order_chitiet( $orderID )
	{
		$sql = "SELECT  * FROM tblOrderChiTiet where OrderID='$orderID'";
		try
		{
			$rs = sqlsrv_query($this->conn, $sql);
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	function order_in_process(){
		$sql = "SELECT  * FROM [NH_STEAK_PIZZA].[dbo].[tblOrder] WHERE TrangThai = 0  ORDER BY OrderID ASC";
		try
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
			return $rs;
			sqlsrv_free_stmt( $rs);
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	} 

	function list_items_in_order( $orderID){
		$sql = "SELECT  * FROM [NH_STEAK_PIZZA].[dbo].[tblOrderChiTiet] WHERE OrderID = '$orderID' ORDER BY OrderID DESC";
		try
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
			return $rs;
			sqlsrv_free_stmt( $rs);
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	} 

	public function getCustomersList()
	{
		$sql = "SELECT * FROM [MASSAGE_VL].[dbo].[tblDMKHNCC] ";
		try
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function insertNewClient( $client_name, $client_address, $client_tel)
	{	
		$stt = 0;
		$sql = "SELECT max(substring(MaDoiTuong,11,5)) FROM [MASSAGE_VL].[dbo].[tblDMKHNCC]";
		$rs = sqlsrv_query($this->conn, $sql);
		$r = sqlsrv_fetch_array($rs);
		$stt = ++$r[0];

		$date = date("yy-m");//2020-11
		$date = substr($date,0,4) . substr($date,5,2);
		$ma_doi_tuong =  $_SESSION['MaTrungTam'] . "1" . $date . "-" . $stt;

		$ten_doi_tuong = htmlentities(trim(strip_tags($client_name)),ENT_QUOTES,'utf-8');
		$dia_chi = htmlentities(trim(strip_tags($client_address)),ENT_QUOTES,'utf-8');
		$dien_thoai = htmlentities(trim(strip_tags($client_tel)),ENT_QUOTES,'utf-8');

		$sql_1 = "INSERT INTO  [MASSAGE_VL].[dbo].[tblDMKHNCC] ( MaDoiTuong, TenDoiTuong, DiaChi, DienThoai	) VALUES( '$ma_doi_tuong', N'$ten_doi_tuong', N'$dia_chi', '$dien_thoai' )  ";
		try
		{
			$rs_1 = sqlsrv_query($this->conn, $sql_1);

			if( !$rs_1 ){
				$_SESSION['insert_error'] = "Insert failed...";
			}
			else
			{
				$_SESSION['insert_success'] = "Inserted successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function getClientInfo( $ma_doi_tuong )
	{
		$sql = "SELECT * FROM [MASSAGE_VL].[dbo].[tblDMKHNCC] Where [MaDoiTuong]='$ma_doi_tuong'";
		try
		{
			$rs = sqlsrv_query($this->conn, $sql, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
			return $rs;
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function updateClient( $client_id, $client_name, $client_address, $client_tel)
	{	
		$ma_doi_tuong = htmlentities(trim(strip_tags($client_id)),ENT_QUOTES,'utf-8');
		$ten_doi_tuong = htmlentities(trim(strip_tags($client_name)),ENT_QUOTES,'utf-8');
		$dia_chi = htmlentities(trim(strip_tags($client_address)),ENT_QUOTES,'utf-8');
		$dien_thoai = htmlentities(trim(strip_tags($client_tel)),ENT_QUOTES,'utf-8');

		$sql_1 = "UPDATE [MASSAGE_VL].[dbo].[tblDMKHNCC] SET  MaDoiTuong = '$ma_doi_tuong', TenDoiTuong = N'$ten_doi_tuong', DiaChi = '$dia_chi', DienThoai = '$dien_thoai'	WHERE [MaDoiTuong] = '$ma_doi_tuong' ";
		try
		{
			$rs_1 = sqlsrv_query($this->conn, $sql_1);

			if( !$rs_1 ){
				$_SESSION['update_error'] = "Update failed...";
			}
			else
			{
				$_SESSION['update_success'] = "Update successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}

	public function deleteClient( $client_id )
	{	
		$sql_1 = "DELETE FROM [MASSAGE_VL].[dbo].[tblDMKHNCC] WHERE [MaDoiTuong] = '$client_id' ";
		try
		{
			$rs_1 = sqlsrv_query($this->conn, $sql_1);

			if( !$rs_1 ){
				$_SESSION['delete_error'] = "Delete failed...";
			}
			else
			{
				$_SESSION['delete_success'] = "Delete successfully!";
			}
			
		}
		catch( Exception $e )
		{
			echo $e->getMessage();
		}
	}




	

}