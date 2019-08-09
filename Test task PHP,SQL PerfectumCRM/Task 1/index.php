<?php 
	require_once ('sort.php');
	$taskObject = new taskClass();
	$data = $taskObject->getSortData();
	foreach ($data as $value){
		echo implode($value, ', ') . '<br>';
	}
	