<?php
include ("universal_dataset.php");
$universal = extract_all();

foreach ($universal as $key=>$data) {
  $followups[$key]["District"] = $data["District"];
  $followups[$key]["Child Age"] = $data["Child Age"];
	$followups[$key]["Child Sex"] = $data["Child Sex"];
	$followups[$key]["Call Duration"] = $data["Call Duration"];
  $followups[$key]["Call Start Time"] = $data["Call Start Time"];
  $followups[$key]["Call End Time"] = $data["Call End Time"];
  $followups[$key]["Type of Caller"] = $data["Type of Caller"];
  if(array_key_exists("call reason",$data)) {
		if(array_key_exists("VANE",$data["call reason"])) {
      foreach ($data["call reason"]["VANE"] as $vane_key => $value) {
        $followups[$key]["VANE"][] = $value;
      }
			if(array_key_exists("Perpetrator",$data["call reason"]["VANE"])) {
				$followups[$key]["Perpetrator"] = $data["call reason"]["VANE"]["Perpetrator"];
			}
			if(!array_key_exists("Perpetrator",$followups[$key]))
			$followups[$key]["Perpetrator"] = "";
		}
	}
  if(array_key_exists("Action Taken",$data)) {
    if(array_key_exists("Extra Calls (Follow-up or Feedback)",$data["Action Taken"])) {
      foreach ($data["Action Taken"]["Extra Calls (Follow-up or Feedback)"] as $foll_key=>$followup) {
        if($foll_key == "Initiated by the Helpline")
        $foll_key = "Followup Initiated by the Helpline";
        elseif($foll_key == "Initiated by the Caller")
        $foll_key = "Followup Initiated by the Caller";

        $followups[$key][$foll_key] = $followup;
      }
    }
	}
  if(!array_key_exists("Followup Initiated by the Caller",$followups[$key]))
  $followups[$key]["Followup Initiated by the Caller"] = "";
  if(!array_key_exists("Followup Initiated by the Helpline",$followups[$key]))
  $followups[$key]["Followup Initiated by the Helpline"] = "";
}
$json = json_encode($followups,JSON_PRETTY_PRINT);
file_put_contents("datasets/followups.json",$json);
print_r($json);
?>
