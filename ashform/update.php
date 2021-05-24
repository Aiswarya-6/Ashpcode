<?php

global $wpdb;
$table_name=$wpdb->prefix.'ashform';
$ed=$wpdb->get_results("select * from $table_name");
$edit=$_GET['$ed'];

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>