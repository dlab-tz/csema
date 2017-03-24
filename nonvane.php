<?php
include ("universal_dataset.php");
$universal = extract_all();

foreach ($universal as $key=>$data) {
  $nonvane[$key]["District"] = $data["District"];
  $nonvane[$key]["Child Age"] = $data["Child Age"];
	$nonvane[$key]["Child Sex"] = $data["Child Sex"];
	$nonvane[$key]["Call Duration"] = $data["Call Duration"];
  $nonvane[$key]["Call Start Time"] = $data["Call Start Time"];
  $nonvane[$key]["Call End Time"] = $data["Call End Time"];
  $nonvane[$key]["Type of Caller"] = $data["Type of Caller"];
	if(array_key_exists("call reason",$data)) {
		if(array_key_exists("NON VANE",$data["call reason"])) {
			foreach ($data["call reason"]["NON VANE"] as $value) {
			  $nonvane[$key]["NON VANE"][] = $value;
			}
		}
	}
  if(!array_key_exists("NON VANE",$nonvane[$key])) {
    $nonvane[$key]["NON VANE"] = array();
  }
  if(array_key_exists("call reason",$data)) {
		if(array_key_exists("helpline issues",$data["call reason"])) {
			foreach ($data["call reason"]["helpline issues"] as $value) {
			  $nonvane[$key]["Other"][] = $value;
			}
    }
    if(array_key_exists("Outside Mandate",$data["call reason"])) {
		    $nonvane[$key]["Other"][] = $data["call reason"]["Outside Mandate"];
    }
	}
  if(!array_key_exists("Other",$data)) {
    $data[$key]["Other"] = array();
  }
}
$json = json_encode($nonvane,JSON_PRETTY_PRINT);
file_put_contents("datasets/nonvane.json",$json);
print_r($json);
?>
