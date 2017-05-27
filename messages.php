<?php
ini_set('max_execution_time', 30000);
ini_set('memory_limit', '-1');
include('graph/phpgraphlib.php');
$file = file_get_contents("messages.htm");
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
$words = explode(" ", $messages_together);
$count = array();
foreach ($words as $word){
	if(array_key_exists($word, $count) != TRUE){
		$count[$word] = 0;
	}else{
		$count[$word]++;
	}	
}
arsort($count);
$data = array_slice($count, 0, 30);

$graph = new PHPGraphLib(1300,600);
$graph->addData($data);
$graph->setTitle("Words as how many times they appeared in my facebook's messages archive");
$graph->setGradient('red', 'maroon');
$graph->createGraph();
