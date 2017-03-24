<?php
include ("universal_dataset.php");
$universal = extract_all();

foreach ($universal as $key=>$data) {
  $vane[$key]["District"] = $data["District"];
  $vane[$key]["Child Age"] = $data["Child Age"];
	$vane[$key]["Child Sex"] = $data["Child Sex"];
	$vane[$key]["Call Duration"] = $data["Call Duration"];
  $vane[$key]["Call Start Time"] = $data["Call Start Time"];
  $vane[$key]["Call End Time"] = $data["Call End Time"];
  $vane[$key]["Type of Caller"] = $data["Type of Caller"];
	if(array_key_exists("call reason",$data)) {
		if(array_key_exists("VANE",$data["call reason"])) {
      foreach ($data["call reason"]["VANE"] as $vane_key => $value) {
        $vane[$key]["VANE"][] = $value;
      }
			if(array_key_exists("Perpetrator",$data["call reason"]["VANE"])) {
				$vane[$key]["Perpetrator"] = $data["call reason"]["VANE"]["Perpetrator"];
			}
			if(!array_key_exists("Perpetrator",$vane[$key]))
			$vane[$key]["Perpetrator"] = "";
		}
	}
}
$json = json_encode($vane,JSON_PRETTY_PRINT);
file_put_contents("datasets/vane.json",$json);
print_r($json);
?>
