<?php
$files = array("1.csv");
foreach ($files as $file) {
	$content = file($file);
	$rows = array_map('str_getcsv', $content,array_fill(0, count($content), ","));
	foreach ($rows as $row) {
		foreach($row as $id=>$rw) {
			$row[$id] = trim($rw);
		}
	  	$csema_data[] = $row;
	}
}

foreach ($csema_data as $top_key=>$subarr) {
  foreach ($subarr as $key => $csema) {
    if($key==6)
    $nonlegitimate[$top_key]["Date"] = $csema;
    if($key==7)
    $nonlegitimate[$top_key]["Start Time"] = $csema;
    if($key==8)
    $nonlegitimate[$top_key]["Finish Time"] = $csema;
    if($key==9)
    $nonlegitimate[$top_key]["Type Of Call"] = $csema;
  }
  $nonlegitimate[$top_key]["Call Duration"] = get_duration($subarr[7],$subarr[8]);
}

function get_duration($time1,$time2) {
	$time1= strtotime($time1);
	$time2= strtotime($time2);
	return round(abs($time2-$time1)/60,2);
}

$json = json_encode($nonlegitimate,JSON_PRETTY_PRINT);
file_put_contents("datasets/nonlegitimate.json",$json);
print_r($json);
?>
