<?php
ini_set('max_execution_time', 30000);
ini_set('memory_limit', '-1');
include('graph/phpgraphlib.php');
$file = file_get_contents("quran.txt");
function get_all_string_between($string, $start, $end){
    $result = array();
    $string = " ".$string;
    $offset = 0;
    while(true)    {
        $ini = strpos($string,$start,$offset);
        if ($ini == 0)
            break;
        $ini += strlen($start);
        $len = strpos($string,$end,$ini) - $ini;
        $result[] = substr($string,$ini,$len);
        $offset = $ini+$len;
    }
    return $result;
}
$messages = get_all_string_between($file, "<p>", "</p>");
$messages_together = implode(" ",$messages);
//$file = str_replace("\n", " ",$file);
$words = explode(" ", $messages);
$count = array();
foreach ($words as $key => $word){
	if(array_key_exists($word, $count) != TRUE){
		array_push($count, $word);
		$count[$word] = 0;
	}else{
		$count[$word]++;
	}	
}
arsort($count);
$data = array();
$x = 0;
foreach($count as $key => $value){
	$x++;
	$data[$x] = $value;
	if($x > 200){
		break;
	}
}

//var_dump($data);
$graph = new PHPGraphLib(900,800);
$graph->setBackgroundColor("black");
$graph->addData($data);
$graph->setBarColor('255,255,204');
$graph->setTitle("Quran words as many times appeared");
$graph->setTitleColor('yellow');
$graph->setupYAxis(12, 'yellow');
$graph->setupXAxis(20, 'yellow');
$graph->setGrid(false);
$graph->setGradient('silver', 'gray');
$graph->setBarOutlineColor('white');
$graph->setTextColor('white');
$graph->setDataPoints(true);
$graph->setDataPointColor('yellow');
$graph->setLine(true);
$graph->setLineColor('yellow');
$graph->createGraph();
