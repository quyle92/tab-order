<?php 
require('../lib/db.php');
require('../lib/restaurant.php');
require('../functions/lichsuphieu.php');
@session_start();
$restaurant = new Restaurant;

if(!isset($_SESSION['MaNV'])) 
{
?>
<script>
	setTimeout('window.location="login.php"',0);
</script>
<?php
}

$client_name = isset( $_POST['client_name'] ) ? $_POST['client_name'] : "";
$client_address = isset( $_POST['client_address'] ) ? $_POST['client_address'] : "";
$client_tel = isset( $_POST['client_tel'] ) ? $_POST['client_tel'] : "";

$insert_new_client = $restaurant->insertNewClient( $client_name, $client_address, $client_tel );//var_dump($insert_new_client);
echo '<script>history.back();</script>';