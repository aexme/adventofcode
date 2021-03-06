<?php 

include_once('vendor/autoload.php');

$shortopts  = "";
$longopts   = array(
    "day:", 
    "part::",
    "year::",
);

$options    = getopt($shortopts, $longopts);

$year       = $options['year']?? date("Y");
$day        = $options['day']?? false;
$part       = $options['part']?? false;

if(!$day){
    echo "day argumment is missing; example --day=1 \n";
    exit();
}

$day_padded = str_pad($day, 2, '0', STR_PAD_LEFT);
$data_path  = __DIR__."/data/$year/";

$input_file = "day$day_padded";

if(!file_exists($data_path . $input_file)){
    echo "the file /data/$year/$input_file does not exist create it first! \n";
    exit();
}

$file_path  = __DIR__."/src/Year$year/";
$file_name  = "Day$day_padded.php";

if(!file_exists($file_path . $file_name)){
    echo "the file /src/$year/$file_name does not exist create it first! \n";
    exit();
}

$class      = "Solver\\Year$year\\Day$day_padded";
include_once($file_path . $file_name);

$parser     = new Solver\InputParser($data_path . $input_file);
$solver     = new $class($parser->getData());

echo "result for assignment 'day$day' from $year \n";
if($part){
    echo "part $part: " . $solver->getResult($part) . " \n";
}else{
    echo "part 1: " . $solver->getResult(1) . " \n";
    echo "part 2: " . $solver->getResult(2) . " \n";
}

