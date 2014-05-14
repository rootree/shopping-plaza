<?php

$topicContainer = array();
$countIteration = 0;

getTopic(0);

function getTopic($topicID){

	global $topicContainer, $countIteration;

	$countIteration++;
	if($countIteration == 5){
		print_r($topicContainer);
		exit();
	}

	if(isset($topicContainer[$topicID])){
		return;
	}

	$branches = file_get_contents('http://sprav.yandex.ru/cmd?cmd=ajax_get_rubrics_branch&parent_id='.$topicID);
	sleep(3);

	$branches = json_decode($branches);

	if(count($branches)){

		foreach($branches as $branch){
			$topicContainer[$branch->rubric_id] = $branch;
			getTopic($branch->rubric_id);
		}
	}
}

?>

 
