<?php
   // Set timezone and date time format
   date_default_timezone_set('Singapore');
   $today = date("d M Y, h:i:s A (T)");

   // Check for arguments else set default to Japan
   if(empty($argv[1])){
       $city = "Japan";
       echo "No input for city, default to Japan. \n";
   }elseif(isset($argv[1])){
       $city = $argv[1];
       echo "Input for city is $city. \n";
   }
   if(empty($argv[2])){
       $output = "default";
   }elseif(isset($argv[2])){   
       $output = $argv[2];
       echo "Output is $output. \n";
   }

   // Set Units
   $unit = "&units=metric";

   // Set APIkey
   $key = "&APPID=715e84cf5d35fb0d921257599fa2f0f6";

   // Call API
   $service_url = "http://api.openweathermap.org/data/2.5/weather?q=$city$unit$key";
   $curl = curl_init($service_url);
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   $curl_response = curl_exec($curl);
var_dump($curl_response);
   if ($curl_response === false) {
       $info = curl_getinfo($curl);
       curl_close($curl);
       die("error occured during curl exec. Additional info: \n" . var_export($info));
   }
   curl_close($curl);
   $decoded = json_decode($curl_response);
   if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
       die('error occured: ' . $decoded->response->errormessage);
   }
   echo "Response received at $today! \r\n";

if (($decoded->cod) !== "200") {
die("error occured: " . $decoded->message.". \r\n");
} 
// Extract each property from JSON object
foreach($decoded->weather as $entry1) {
$weatherMain = $entry1->main;
$weatherDesc = $entry1->description;
}
//foreach($decoded->main as $entry2) {
$mainTemp = $decoded->main->temp;
$mainPres = $decoded->main->pressure;
$mainHumi = $decoded->main->humidity;
//}
//var_dump(get_object_vars($decoded->main));

if ($output == "file"){
   file_put_contents('weather.txt', print_r($decoded, true));
}elseif ($output == "dump") {
   var_dump($decoded);
}else{
       echo "The weather status in $city is $weatherMain - $weatherDesc. \r\n";
        echo "The temperature is $mainTemp degrees and humidity is $mainHumi%. \r\n";
//   echo "The weather is $weather. \r\n";
//   var_dump($decoded);
}
//var_export($decoded->response);

?>
