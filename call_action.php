<?php
include ("universal_dataset.php");
$universal = extract_all();

foreach ($universal as $key=>$data) {
  $call_action[$key]["District"] = $data["District"];
  $call_action[$key]["Child Age"] = $data["Child Age"];
	$call_action[$key]["Child Sex"] = $data["Child Sex"];
	$call_action[$key]["Call Duration"] = $data["Call Duration"];
  $call_action[$key]["Call Start Time"] = $data["Call Start Time"];
  $call_action[$key]["Call End Time"] = $data["Call End Time"];
  $call_action[$key]["Type of Caller"] = $data["Type of Caller"];
	if(array_key_exists("Action Taken",$data)) {
    foreach ($data["Action Taken"] as $act_key=>$action) {
      $call_action[$key]["Action Taken"][] = $act_key;
    }
	}
  else {
    $call_action[$key]["Action Taken"] = array();
  }
  if(is_array($call_action[$key]["Action Taken"]) and array_key_exists("Extra Calls (Follow-up or Feedback)",$call_action[$key]["Action Taken"]))
  unset($call_action[$key]["Action Taken"]["Extra Calls (Follow-up or Feedback)"]);
  if(is_array($call_action[$key]["Action Taken"]) and array_key_exists("Details of Referral",$call_action[$key]["Action Taken"]))
  unset($call_action[$key]["Action Taken"]["Details of Referral"]);
  if(is_array($call_action[$key]["Action Taken"]) and array_key_exists("Details of Signposting",$call_action[$key]["Action Taken"]))
  unset($call_action[$key]["Action Taken"]["Details of Signposting"]);
}
$json = json_encode($call_action,JSON_PRETTY_PRINT);
file_put_contents("datasets/call_action.json",$json);
print_r($json);
?>
