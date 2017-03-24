<?php

$legitimate_path = "./Legitimate";
$non_legit_path = "./Non_Legit";
include("universal_dataset.php");
$universal = extract_all($legitimate_path);


//FUNCTION EXECUTIONS
call_action($universal);
call_followups($universal);
vane_calls($universal);
nonvane_calls($universal);
referral_calls($universal);
nonlegitimate_calls($non_legit_path);

//FUNCTION DEFINITIONS

/********************************************************
 * FUNCTION TO MONITOR CALLS
 *******************************************************/
function call_action($universal){
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
		else{
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
	//print_r($json);
	}


/********************************************************
 * FUNCTION TO MONITOR FOLLOW UPS
 *******************************************************/
function call_followups($universal){
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
	//print_r($json);
	}


/********************************************************
 * FUNCTION TO MONITOR VANE CALLS
 *******************************************************/
function vane_calls($universal){
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
	//print_r($json);
	}


/********************************************************
 * FUNCTION TO MONITOR NONVANE CALLS
 *******************************************************/
function nonvane_calls($universal){
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
	//print_r($json);
	}


/********************************************************
 * FUNCTION TO MONITOR REFERRAL CASES
 *******************************************************/
function referral_calls($universal){
	foreach ($universal as $key=>$data) {
		$referrals[$key]["District"] = $data["District"];
		$referrals[$key]["Child Age"] = $data["Child Age"];
		$referrals[$key]["Child Sex"] = $data["Child Sex"];
		$referrals[$key]["Call Duration"] = $data["Call Duration"];
		$referrals[$key]["Call Start Time"] = $data["Call Start Time"];
		$referrals[$key]["Call End Time"] = $data["Call End Time"];
		$referrals[$key]["Type of Caller"] = $data["Type of Caller"];
		
		if(array_key_exists("call reason",$data)) {
			if(array_key_exists("VANE",$data["call reason"])) {
				foreach ($data["call reason"]["VANE"] as $vane_key => $value) {
					$referrals[$key]["VANE"][] = $value;
					}
				if(array_key_exists("Perpetrator",$data["call reason"]["VANE"])) {
					$referrals[$key]["Perpetrator"] = $data["call reason"]["VANE"]["Perpetrator"];
					}
				if(!array_key_exists("Perpetrator",$referrals[$key]))
					$referrals[$key]["Perpetrator"] = "";
				}
			}
		
		if(array_key_exists("Action Taken",$data)) {
			if(array_key_exists("Referral By Helpline",$data["Action Taken"])) {
				$referrals[$key]["Referral"] = "Referral By Helpline";
				}
			else
				$referrals[$key]["Referral"] = "";
			
			if(array_key_exists("Details of Referral",$data["Action Taken"])) {
				foreach ($data["Action Taken"]["Details of Referral"] as $ref_key=>$referral) {
					$referrals[$key][$ref_key] = $referral;
					}
				$referrals[$key]["Referal Acknowledgement Duration"] = get_days($referrals[$key]["Date Referred"],$referrals[$key]["Date Referral Acknowleged"]);
				}
			}
		}
		
	$json = json_encode($referrals,JSON_PRETTY_PRINT);
	file_put_contents("datasets/refferals.json",$json);
	//print_r($json);
	}


/********************************************************
 * FUNCTION TO MONITOR NON-LEGITIMATE CALLS
 *******************************************************/
function nonlegitimate_calls($non_legit_path){
	foreach (glob($non_legit_path."/*.csv") as $file) {
		$files[] = $file;
		}

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
	$json = json_encode($nonlegitimate,JSON_PRETTY_PRINT);
	file_put_contents("datasets/nonlegitimate.json",$json);
	//print_r($json);
	}


/********************************************************
 * FUNCTION TO CONVERT DATE STRING TO TIME DAYS
 *******************************************************/
function get_days($date1,$date2) {
	if($date1=="" or $date2=="")
		return;
	
	$date1 = explode("/",$date1);
	$date1 = $date1[0]."-".$date1[1]."-20".$date1[2];
	$date2 = explode("/",$date2);
	$date2 = $date2[0]."-".$date2[1]."-20".$date2[2];
	$date1= strtotime($date1);
	$date2= strtotime($date2);
	$datediff = $date2-$date1;
	
	return floor($datediff / (60 * 60 * 24));
	}
?>
