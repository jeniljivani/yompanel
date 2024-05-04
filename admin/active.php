<?php 

	$con = mysqli_connect("localhost","root","","adminpanel");
	if(isset($_GET['id'])) {
		$s_id = $_GET['id'];
		$sql = "update `slider` set `status`=0 where `id`=".$s_id;
		mysqli_query($con , $sql);
		header("location:view_slider.php");
	}

	if(isset($_GET['oid'])) {
		$s_id = $_GET['oid'];
		$sql = "update `offer` set `status`=0 where `id`=".$s_id;
		mysqli_query($con , $sql);
		header("location:view_offer.php");
	}
	if(isset($_GET['rid'])) {
		$s_id = $_GET['rid'];
		$sql = "update `recent` set `status`=0 where `id`=".$s_id;
		mysqli_query($con , $sql);
		header("location:view_recent.php");
	}
	if(isset($_GET['lid'])) {
		$s_id = $_GET['lid'];
		$sql = "update `posts` set `status`=0 where `id`=".$s_id;
		mysqli_query($con , $sql);
		header("location:view_post.php");
	}
?>