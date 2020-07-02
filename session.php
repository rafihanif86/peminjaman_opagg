<?php 
	session_start();
	$nia = "";
	if($_SESSION['status']=="admin" or $_SESSION['status']=="anggota"){
		$nia = $_SESSION['nia'];
		if((time() - $_SESSION['last_login_timestamp']) > 600){  
			header("location:logout.php");  
		}
		$_SESSION['last_login_timestamp'] = time();
		
	}else{
		header("location:login.php?pesan=belum_login");
	}
?>