<?php
include ("universal_dataset.php");
$universal = extract_all();

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
print_r($json);

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
