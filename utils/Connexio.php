<?php
    try {
	    $conn = mysqli_connect("localhost", "u124167221_pinya", "T3niente", "u124167221_pinya");
    } catch (Exception $e) {
        error_log("Caught $e");
    }

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	/*
	if (!$conn)
	{
		die('Could not connect: ' . mysqli_error($conn));
	}
	*/

function GetStrDB($str)
{
    return addslashes(NotInjection($str));
}

function NotInjection($str)
{
	$str = str_replace("update", "", $str);
	$str = str_replace("delete", "", $str);
	$str = str_replace(" from ", "", $str);
	$str = str_replace("truncate", "", $str);
	$str = str_replace("drop ", "", $str);
	$str = str_replace("create ", "", $str);
	$str = str_replace("alter ", "", $str);
    return str_replace("select ", "", $str);
}

function GetFormatedDate($date, $format = 'Ymd')
{
	$combinedDT = date('Y-m-d', strtotime("$date"));
	$d = new DateTime($combinedDT);
	$data = $d->format($format);
	if ($data == "19700101")
		return "NULL";
	return "'".$data."'";
}

function GetFormatedDateTime($date, $time, $format = 'YmdHis')
{
	$combinedDT = date('Y-m-d H:i:s', strtotime("$date $time"));
    $d = new DateTime($combinedDT);
    return $d->format($format);
}

?>
