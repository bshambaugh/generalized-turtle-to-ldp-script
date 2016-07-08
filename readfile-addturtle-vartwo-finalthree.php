<?php
include('./Requests/library/Requests.php');
Requests::register_autoloader();
//$filename = 'first_one-hundred-nasa-spacecraft-filtered-addjpg.nt';
//$filename = 'first_one-hundred-nasa-spacecraft-filtered.nt';
$filename = 'nasa-spacecraft-filtered.nt';
//$filename = 'nasa-spacecraft-selected.nt';
$dbg = 0;
$fp = fopen($filename,'rw');
$string = fread($fp, filesize($filename));
fclose($fp);
if($dbg == 1) {
echo $string;
}
$filerow_to_array = explode("\n",$string);
if($dbg == 1) {
echo 'The count of filerow_to_array is'.count($filerow_to_array);
}
unset($filerow_to_array[count($filerow_to_array) - 1]);
if($dbg == 1) {
print_r($filerow_to_array);
var_dump($filerow_to_array);
}

$map_two = array();

foreach($filerow_to_array as $key => $value) {
  $matchtwo = preg_match('/^<[0-9A-Za-z:_\.\/#-]*>/',$filerow_to_array[$key],$matches);
  if($matchtwo == 1) {
    if($dbg == 1) {
    echo $matches[0]."\n";
    }
    $map_two[$key] = $matches[0];
  }
}

if($dbg == 1) {
echo '------------------This is map one:----------------';
}

$array_three = array();

$array_three = array_unique($map_two);
$array_three_ext = array();

if($dbg == 1) {
echo "array three is"."\n";
print_r($array_three);

echo "\n";
}

foreach($array_three as $key => $value) {
   $string_two = preg_match('/^<[0-9A-Za-z:_\/\.#]*\.[A-Za-z]{3,}>/',$array_three[$key],$matches);
  // preg_match('/[0-9A-Za-z_\.]*$>/',$array_three[$key],$matches);
  if($dbg == 1) {
  echo $string_two.'is the man';
  }
if($string_two == 1) {
  $string = $matches[0];
  array_push($array_three_ext,$string);
}

}

if($dbg == 1) {
echo 'Array three ext'."\n";
}

if($dbg == 1) {
foreach($array_three_ext as $key => $value) {
  echo $array_three_ext[$key]."\n";
}
}

if($dbg == 1) {
echo 'This is the end of the array three ext'."\n";
}

//$dbg = 1;

//$array_three_map = array();

if($dbg == 1) {
echo 'Recove the <>'."\n";
}

// remove the triple with <> as a the subject
foreach($array_three as $k => $value_three) {
    // array_push($array_three_map,$array_three[$k]);
    $matchseven = preg_match('/<>/',$array_three[$k],$matches);
    if($matchseven == 1) {
      if($dbg == 1) {
      echo 'there is a match for'.$array_three[$k];
      }
      unset($array_three[$k]);
    }
}

foreach($array_three as $i => $value_one) {
foreach($array_three_ext as $j => $value_two) {
  if($array_three[$i] == $array_three_ext[$j]) {
    if($dbg == 1){
      echo("We are equal for ".$array_three[$i]." and ".$array_three_ext[$j]);
      echo("\r\n");
    }
     unset($array_three[$i]);
  } elseif ($array_three[$i] !== $array_three_ext[$j]) {
    if($dbg == 1){
    echo("We are not equal for ".$array_three[$i]." and ".$array_three_ext[$j]);
    echo("\r\n");
   }
  }
}
}

/*
echo 'array three map is'."\n";
print_r($array_three_map);
*/

///
if($dbg == 1){
echo "array three is"."\n";
print_r($array_three);

echo "\n";
}

// nest all of these arrays in the future..
$array_six = array();

// this is for matching the .jpg stuff...
foreach($array_three_ext as $keyone => $value) {
}

foreach($array_three as $key => $value) {
  $replace_one =  preg_replace('/[<>]/','',$array_three[$key]);
  $replace_two = preg_replace('/http:\/\/[a-zA-Z0-9\.-]*\//','',$replace_one);
  $pizza = explode('/',$replace_two);
  foreach($pizza as $key_three => $value) {
    $array_six[strval($array_three[$key])][$key_three] = strval($pizza[$key_three]);
  }
}

if($dbg == 1){
echo 'array six is:'."\n";
print_r($array_six);
}

$matches = array();

foreach($array_six as $keyone => $value) {

$matches = array(NULL);
$matchesarraytwo = array();
$ahappystring = $keyone;
//$ahappystring = '<http://data.kasabi.com/dataset/nasa/launchsite/hammaguir>';
$pattern = preg_quote($ahappystring,'/');
$regex = '/^'.$pattern.' <[a-zA-Z0-9_:#-\/\.]*> (<[a-zA-Z0-9_:#-\/\.]*>|"[a-z ,A-z0-9-]*") ./';


foreach($filerow_to_array as $key => $value) {
$matches[0] = NULL;
$firstmatch = preg_match($regex,$filerow_to_array[$key],$matches);
if($firstmatch == 1) {
if($dbg == 1){
echo 'the first match is'.$firstmatch;
}

 if($matches[0] != NULL) {

  array_push($matchesarraytwo,$matches[0]);
 }

}

}

foreach($matchesarraytwo as $key => $value) {
if($dbg == 1){
  echo $matchesarraytwo[$key]."\n";
}
 $matchesarraytwo[$key] = preg_replace('/.$/','; ',$matchesarraytwo[$key]);
 $matchesarraytwo[$key] = preg_replace('/^<[0-9A-Za-z\.\/_#:-]*> /','',$matchesarraytwo[$key]);
}

// I stopped looking at the code here...
$stringarray = implode($matchesarraytwo);
$data = '<> '.$stringarray;
$data = preg_replace('/; $/','.',$data);
if($dbg == 1){
echo 'the data is:'."\n";
echo $data;
echo 'end of data'."\n";
}
// put the ldp container stuff here ...
// first take the array to create the ldp container...
// then post the data...

  $count = 0;
  foreach (array_filter($array_six[$keyone]) as $keytwo => $value) {
    if($dbg == 1){
      echo $array_six[$keyone][$keytwo]."\n";
    }
      $count++;
  }
  if($dbg == 1){
   echo "\n";
   echo 'The count is'.$count."\n\n";
  }

$string = '';
$rootcontainer = 'http://localhost:8080/marmotta/ldp/test8/';
$string = $rootcontainer;


 for($i = 0; $i < $count; $i++) {
 if($dbg == 1){
  echo 'root container: '.$string.', target container: '.$array_six[$keyone][$i]."\n";
  }
  createldpcontainer($string,$array_six[$keyone][$i],$dbg);
  $string = $string.$array_six[$keyone][$i].'/';
 }


$url = $string;
if($dbg == 1){
echo 'start of ldp put'."\n";
echo 'The url is: '.$url."\n";
echo 'The data is: '."\n";
echo $data;
echo "\n";
echo 'end of ldp put'."\n";
}
 putrequest($data,$url,$dbg);

}

// This is stuff to post all of the image files to ldp containers...

foreach($array_three_ext as $key => $value) {
  $matchesarraytwo = array();
  $ahappystring = $array_three_ext[$key];
  $pattern = preg_quote($ahappystring,'/');
  $regex = '/^'.$pattern.' <[a-zA-Z0-9_:#-\/\.]*> (<[a-zA-Z0-9_:#-\/\.]*>|"[a-z ,A-z0-9-]*") ./';

foreach($filerow_to_array as $key => $value) {
  $matchfive = preg_match($regex,$filerow_to_array[$key],$matches);
  if($matchfive == 1) {
    array_push($matchesarraytwo,$matches[0]);
   }
}

  foreach($matchesarraytwo as $key => $value) {
    if($dbg == 1){
    echo $matchesarraytwo[$key]."\n";
   }
    $matchesarraytwo[$key] = preg_replace('/.$/','; ',$matchesarraytwo[$key]);
    $matchesarraytwo[$key] = preg_replace('/^<[0-9A-Za-z\.\/_#:-]*> /','',$matchesarraytwo[$key]);
  }

  $stringarray = implode($matchesarraytwo);
  $data = '<> '.' skos:member '.$ahappystring.' . '.$ahappystring.' '.$stringarray;
  $data = preg_replace('/; $/','.',$data);
  if($dbg == 1){
  echo 'the data is:'."\n";
  echo $data;
  echo 'end of data'."\n";
}

  $rootcontainer = 'http://localhost:8080/marmotta/ldp/test8';

  foreach($array_three as $key => $value) {
    $pattern = preg_quote($array_three[$key],'/');
    $regex = '/'.$pattern.'/';
    $matcheight = preg_match($regex,$data,$matches);
   if($matcheight == 1) {
     if($dbg == 1){
      echo 'I match for ---- <<<<giant centipede>>>>'.$array_three[$key]."\n";
    }
      $pumpkin = preg_replace('/http:\/\/[A-Za-z\.]*/',$rootcontainer,$array_three[$key]);
     if($dbg == 1){
      echo 'Pumpkin is'.$pumpkin."\n";
     }
      $data = preg_replace($regex,'<>',$data);
     if($dbg == 1){
      echo 'the data for posting is'.$data."\n";
     }
      $url = preg_replace('/[<>]/','',$pumpkin);
     if($dbg == 1){
      echo 'the url for posting the jpg is:'.$url."\n";
     }
      putrequest($data,$url,$dbg);
      // post to the ldp continer here...
   }
  }


}

// create a function that creates an ldp container..and that is it...
function createldpcontainer($rootcontainer,$target_container,$dbg) {
  $url = $rootcontainer.$target_container;
  $headers = array('Accept' => 'text/turtle');
  $response = Requests::get($url,$headers);
  if($dbg == 1){
  echo 'The result of get is'."\n";
  var_dump($response->raw);
  }
  if($response->status_code == 404) {
    $headers_two = array('Content-Type' => 'text/turtle','Slug' => $target_container);
    $response = Requests::post($rootcontainer, $headers_two);
    $string = $response->raw;
    preg_match('/Location: http[:\/a-z0-9-_A-Z]*/',$string,$matches);
    $substring = $matches[0];
    preg_match('/http[:\/a-z0-9-_A-Z]*/',$substring,$matches);
    $url = $matches[0];
  }
}

function putrequest($data,$url,$dbg) {
  //$url = 'http://localhost:8080/marmotta/ldp/'.$containertitle;
  $existingheaders = get_headers($url);
  if($dbg == 1){
  print_r($existingheaders);
  echo($existingheaders[5]);
  }
  $etag = preg_replace('/ETag: /i','',$existingheaders[5]);
  if($dbg == 1){
  echo("\n");
  echo($etag);
  echo("\n");
  }
  // do I need the container tag in the header for the put request, it would be easier if I did not need to know ... try it
  //$headers = array('Content-Type' => 'text/turtle','If-Match' => $etag,'Slug' => $containertitle);
  $headers = array('Content-Type' => 'text/turtle','If-Match' => $etag);
  //$headers = array('Content-Type' => 'text/turtle','If-Match' => 'W/"1459004153000"','Slug' => 'Penguins are Awesome');
  $response = Requests::put($url, $headers, $data);
  //$response = Requests:_put($url, $headers, json_encode($data));
  if($dbg == 1){
  var_dump($response->body);
  }
}


?>
