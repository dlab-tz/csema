<?php
function extract_all() {
$files = array("1.csv","2.csv","3.csv","4.csv","5.csv","6.csv","7.csv","8.csv","9.csv");
foreach ($files as $file) {
	$content = file("legitimate1314csv/".$file);
	$rows = array_map('str_getcsv', $content,array_fill(0, count($content), ","));
	foreach ($rows as $row) {
		foreach($row as $id=>$rw) {
			$row[$id] = trim($rw);
		}
	  	$csema_data[] = $row;
	}
}

$VANE = array(17=>"Physical Violence",18=>"Rape",19=>"Other Sexual Abuse",20=>"Neglect",21=>"Child Labour",22=>"Child Marriage",23=>"Child Pregnancy",24=>"Trafficking",25=>"Kidnapping",26=>"No CareGiver",27=>"Missing Child",28=>"Traditional Practices",29=>"Other Issues (VANE)");

$other_reason = array(31=>"Family Relationships",32=>"Peer Relationships",33=>"Physical Health",34=>"Psychosocial/Mental Health",35=>"Sexuality",36=>"Alcohol & Drugs",37=>"HIV/Aids",38=>"Other Disability",39=>"Education",40=>"Homelessness",41=>"Discrimination",42=>"Legal Issues",43=>"Other Issues (non-VANE)",47=>"Outside Mandate");

$helpline_issues = array(44=>"Info on Helpine",45=>"Complaints",46=>"Thanks");

$action_taken = array(49=>"Information",50=>"Advice / Counselling",51=>"Signposting",53=>"Referral By Helpline",58=>"Escalation");

$referral = array(54=>"Referral Authority",55=>"Method of Referral",56=>"Date Referred",57=>"Date Referral Acknowleged");

$extra_calls = array(60=>"Initiated by the Caller",61=>"Initiated by the Helpline");

$other_headers = array(6=>"Call Date",7=>"Call Start Time",8=>"Call End Time",9=>"Type of Caller",10=>"Name of Caller (if not Child)",11=>"Name of the Child",12=>"Child Age",13=>"Child Sex",14=>"District",15=>"Child Extra Home Details",16=>"Contact");

foreach ($csema_data as $top_key=>$subarr) {
	$csema_data[$top_key]["Call Duration"] = get_duration($subarr[7],$subarr[8]);
	foreach ($subarr as $key => $csema) {
		if($key>=6 and $key<=16) {
			$csema_data[$top_key][$other_headers[$key]] = $csema;
		}
		if($key>=17 and $key<=29) {
			if($csema=="X")
			$csema_data[$top_key]["call reason"]["VANE"][$VANE[$key]] = $VANE[$key];
		}
		if($key == 30) {
			if($csema)
			$csema_data[$top_key]["call reason"]["VANE"]["Perpetrator"] = $csema;
		}
		if($key>=31 and $key<=43) {
			if($csema=="X")
			$csema_data[$top_key]["call reason"]["NON VANE"][$other_reason[$key]] = $other_reason[$key];
		}
		if($key == 47) {
			if($csema=="X")
			$csema_data[$top_key]["call reason"][$other_reason[$key]] = $other_reason[$key];
		}
		if($key>=44 and $key<=46) {
			if($csema=="X")
			$csema_data[$top_key]["call reason"]["helpline issues"][$helpline_issues[$key]] = $helpline_issues[$key];
		}
		if(($key>=49 and $key<=51) or $key == 53 or $key == 58) {
			if($csema=="X")
			$csema_data[$top_key]["Action Taken"][$action_taken[$key]] = $action_taken[$key];
		}
		if($key == 52) {
			if($csema)
			$csema_data[$top_key]["Action Taken"]["Details of Signposting"]["Partner (target of signposting)"] = $csema;
		}
		if($key>=54 and $key<=57) {
			if($csema)
			$csema_data[$top_key]["Action Taken"]["Details of Referral"][$referral[$key]] = $csema;
		}
		if($key == 59) {
			if($csema)
			$csema_data[$top_key]["Action Taken"]["Date Of Escalation"] = $csema;
		}
		if($key>=60 and $key<=61) {
			if($csema)
			$csema_data[$top_key]["Action Taken"]["Extra Calls (Follow-up or Feedback)"][$extra_calls[$key]] = $csema;
		}
		unset($csema_data[$top_key][$key]);
	}
	unset($csema_data[$top_key]["Name of Caller (if not Child)"]);
	unset($csema_data[$top_key]["Name of the Child"]);
	unset($csema_data[$top_key]["Child Extra Home Details"]);
	unset($csema_data[$top_key]["Contact"]);
}
return $csema_data;
}

function get_duration($time1,$time2) {
	$time1= strtotime($time1);
	$time2= strtotime($time2);
	return round(abs($time2-$time1)/60,2);
}
//$json = json_encode($csema_data);
//print_r($json);
//print_r($csema_data);
?>
