<?php 
	require 'connection.php';
	$id_pendapatan = $_GET['id_pendapatan'];
	if (isset($id_pendapatan)) {
		if (deletePendapatan($id_pendapatan) > 0) {
			setAlert("Pendapatan has been deleted", "Successfully deleted", "success");
		    header("Location: pendapatan.php");
	    }
	} else {
	   header("Location: pendapatan.php");
	}