<?php
include('graph/phpgraphlib.php');
$limit=10;
$numbers = array();
for($x=0;$x<=$limit;$x++){
	array_push($numbers, 0);
}
$x = 0;
$time_start = microtime(true); 
while(true){
	$x++;
	$rand = rand(0, $limit);
	$numbers[$rand]++;
	if($x == 1000000){
		break;
	}
}
$time_end = microtime(true);
$graph = new PHPGraphLib(1300,600);
$execution_time = ($time_end - $time_start);
$data = $numbers;
$graph->addData($data);
$graph->setTitle("Numbers from 0 to $limit (executed in $execution_time seconds)");
$graph->setGradient('red', 'maroon');
$graph->createGraph();
?>