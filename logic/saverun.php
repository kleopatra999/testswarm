<?php
	include "inc/init.php";

	$run_id = ereg_replace("[^0-9]", "", $_POST['run_id']);
	$fail = ereg_replace("[^0-9-]", "", $_POST['fail']);
	$error = ereg_replace("[^0-9-]", "", $_POST['error']);
	$total = ereg_replace("[^0-9-]", "", $_POST['total']);
	$results = $_POST['results'];

	# Make sure we've received some results from the client
	if ( $results ) {
		mysql_queryf("UPDATE run_client SET status=2, fail=%u, error=%u, total=%u, results=%s WHERE client_id=%u AND run_id=%u LIMIT 1;", $fail, $error, $total, $results, $client_id, $run_id);
		mysql_queryf("UPDATE run_useragent SET completed = completed + 1, status = IF(completed+1<max, 1, 2) WHERE useragent_id=%u AND run_id=%u LIMIT 1;", $useragent_id, $run_id);
	}

	echo "<script>window.top.done();</script>";

	exit();
?>
