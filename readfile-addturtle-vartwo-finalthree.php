<?php
include('./Requests/library/Requests.php');
Requests::register_autoloader();
//$filename = 'first_one-hundred-nasa-spacecraft-filtered-addjpg.nt';
//$filename = 'first_one-hundred-nasa-spacecraft-filtered.nt';
$filename = 'nasa-spacecraft-filtered.nt';
//$filename = 'nasa-spacecraft-selected.nt';
$dbg = 1;
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

if($dbg == 1) {
echo 'This is the start of map two'."\n";
}
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
echo 'code to grab to object uris'."\n";
}
foreach($filerow_to_array as $key => $value) {
  $matchtwo = preg_match('/<[a-zA-Z0-9_:#-\/\.]*> .$/',$filerow_to_array[$key],$matches);
  if($matchtwo == 1) {
    if($dbg == 1) {
    echo $matches[0]."\n";
    }
    $forstringminusperiod = $matches[0];
    $stringminusperiod = preg_replace('/ .$/','',$forstringminusperiod);
    $map_two_end[$key] = $stringminusperiod;
  }
}

if($dbg == 1) {
echo 'end of code to grab the object uris'."\n";
}

// code to select what you want from object uris..

$selectedobjecturiprefixes = array('data.kasabi.com');

$objectmatches = array();

//print_r($replacementarray);

// select the object with the specified prefix
foreach($map_two_end as $key => $value) {
  $objectarrayelement = $map_two_end[$key];
  foreach($selectedobjecturiprefixes as $keytwo => $valuetwo) {
     $prefixelementtostring = $selectedobjecturiprefixes[$keytwo];
     $prefixpattern = preg_quote($prefixelementtostring,'/');
     $regexforreplaceindata = '/'.$prefixpattern.'/';
     $matchprefixdata = preg_match($regexforreplaceindata,$objectarrayelement,$matches);
     if($matchprefixdata == 1) {
        array_push($objectmatches,$objectarrayelement);
        array_push($map_two,$objectarrayelement);
     }
 }
}

if($dbg == 1) {
echo 'The matching objects are'."\n";


foreach ($objectmatches as $key => $value) {
    echo $objectmatches[$key]."\n";
}
}

if($dbg == 1) {
echo 'The matching objects with map two are'."\n";
foreach ($map_two as $key => $value) {
    echo $map_two[$key]."\n";
}
}

// end of selected object uris

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
  // match each element with an extension
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

// put the array in order
$array_three_rebased = array();
foreach($array_three as $key => $value) {
  array_push($array_three_rebased,$array_three[$key]);
}

if($dbg == 1) {
echo 'Print array three rebased'."\n";
print_r($array_three_rebased);
}

// create a map of array three rebased
$array_three_rebased_map = array();
foreach($array_three_rebased as $key => $value) {
  array_push($array_three_rebased_map,$array_three_rebased[$key]);
}

// get rid of the undefined offset by replacing the array_three with the array_three_map ...(make sure to rebase the coordinates)
foreach($array_three_rebased_map as $i => $value_one) {
foreach($array_three_ext as $j => $value_two) {
  if($array_three_rebased_map[$i] == $array_three_ext[$j]) {
    if($dbg == 1){
      echo("We are equal for ".$array_three_rebased_map[$i]." and ".$array_three_ext[$j]);
      echo("\r\n");
    }
     unset($array_three_rebased[$i]);
  } elseif ($array_three_rebased_map[$i] !== $array_three_ext[$j]) {
    if($dbg == 1){
    echo("We are not equal for ".$array_three_rebased_map[$i]." and ".$array_three_ext[$j]);
    echo("\r\n");
   }
  }
}
}

// after this further process array three by adding the objects from a particular namespace that should have ldp containers
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

if($dbg == 1){
echo "array three rebased is"."\n";
print_r($array_three_rebased);

echo "\n";
}

$array_three_rebased_rebased = array();
foreach($array_three_rebased as $key => $value) {
  array_push($array_three_rebased_rebased,$array_three_rebased[$key]);
}

if($dbg == 1){
echo "array three rebased rebased is"."\n";
print_r($array_three_rebased_rebased);

echo "\n";
}

// nest all of these arrays in the future..
$array_six = array();

// this is for matching the .jpg stuff...
foreach($array_three_ext as $keyone => $value) {
}

// explode array element into ldp container
foreach($array_three_rebased_rebased as $key => $value) {
  $replace_one =  preg_replace('/[<>]/','',$array_three_rebased_rebased[$key]);
  $replace_two = preg_replace('/http:\/\/[a-zA-Z0-9\.-]*\//','',$replace_one);
  $explodintoldpcontainer = explode('/',$replace_two);
  foreach($explodintoldpcontainer as $key_three => $value) {
    $array_six[strval($array_three_rebased_rebased[$key])][$key_three] = strval($explodintoldpcontainer[$key_three]);
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
$regexstringforcontainer = $keyone;
//$ahappystring = '<http://data.kasabi.com/dataset/nasa/launchsite/hammaguir>';
$pattern = preg_quote($regexstringforcontainer,'/');
$regex = '/^'.$pattern.' <[a-zA-Z0-9_:#-\/\.]*> (<[a-zA-Z0-9_:#-\/\.]*>|"[a-z ,A-z0-9-]*") ./';


foreach($filerow_to_array as $key => $value) {
$matches[0] = NULL;
// Match triples to container for post to a particular container
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
// replace the period at the end of each triple with a semicolon
 $matchesarraytwo[$key] = preg_replace('/.$/','; ',$matchesarraytwo[$key]);
 // remove the first element in the triple to prepare to write as compacted turtle
 $matchesarraytwo[$key] = preg_replace('/^<[0-9A-Za-z\.\/_#:-]*> /','',$matchesarraytwo[$key]);
}

// Create the raw data to post of the ldp container
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

// count the number of containers below the master root container
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
$rootcontainer = 'http://localhost:8080/marmotta/ldp/';
$string = $rootcontainer;


 for($i = 0; $i < $count; $i++) {
 if($dbg == 1){
  echo 'root container: '.$string.', target container: '.$array_six[$keyone][$i]."\n";
}
  // create each ldp container (do I need to post array six)
  createldpcontainer($string,$array_six[$keyone][$i],$dbg);
 // create the new ldp root container
  $string = $string.$array_six[$keyone][$i].'/';
  // I need to add code here to give a title to each ldp container...
  if($dbg == 1) {
  echo 'The new string is '.$string.' and the title is '.$array_six[$keyone][$i]."\n";
  }
  // Prepare the data to post the title to the ldp container
  $container_title = '<> '.'<http://purl.org/dc/terms/title> '.'"'.$array_six[$keyone][$i].'" .';
  if($dbg == 1) {
  echo $container_title."\n";
   }
   // post the title of the container as the previous target container name to each container
   putrequest($container_title,$string,$dbg);
 }

/// replace array elements with the local namespace...
 foreach($array_three_rebased_rebased as $key => $value) {
    // assign a string to the present array element
     $elementtostring = $array_three_rebased_rebased[$key];
     // convert string to regular expression
     $patternfromarray = preg_quote($elementtostring,'/');
     $regexforreplaceindata = '/'.$patternfromarray.'/';
     $rootcontainer = 'http://localhost:8080/marmotta/ldp/';
     // Find candidates to replace in the data
     $changedata = preg_match($regexforreplaceindata,$data,$matches);
  if($changedata == 1) {
     $matchelementindata = $matches[0];
     // Transform the data matches to the local namespace
     $tolocalnamespace = preg_replace('/http:\/\/[A-Za-z0-9\.]*\//',$rootcontainer,$matchelementindata);
     // perform replacements in the data
     $datatemp = preg_replace($regexforreplaceindata,$tolocalnamespace,$data);
     $data = $datatemp;
   }
 }

 // array to replace selected prefixes in the data
 $replacementarray = array('purl.org/net' => 'data.thespaceplan.com','data.kasabi.com' => 'investors.ddns.net:8080/marmotta/ldp');

 //print_r($replacementarray);

// run through each replacement in the replacement array and apply it to the data
 foreach($replacementarray as $key => $value) {
  // echo $key.' '.$replacementarray[$key]."\n";
   $replacementstring = $replacementarray[$key];
   $arraypatterntoreplace = preg_quote($key,'/');
   $regexforreplaceindatafromarray = '/'.$arraypatterntoreplace.'/';
   $dataintermed = preg_replace($regexforreplaceindatafromarray,$replacementstring,$data);
   $data = $dataintermed;
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
  $arrayelementasstring = $array_three_ext[$key];
  $pattern = preg_quote($arrayelementasstring,'/');
  // match triples with the subject uri with the file extension
  $regex = '/^'.$pattern.' <[a-zA-Z0-9_:#-\/\.]*> (<[a-zA-Z0-9_:#-\/\.]*>|"[a-z ,A-z0-9-]*") ./';

foreach($filerow_to_array as $key => $value) {
  // grab all triples in the raw data that have the subject uri with the file extension
  $matchfive = preg_match($regex,$filerow_to_array[$key],$matches);
  if($matchfive == 1) {
    array_push($matchesarraytwo,$matches[0]);
   }
}

  foreach($matchesarraytwo as $key => $value) {
    if($dbg == 1){
    echo $matchesarraytwo[$key]."\n";
   }
    // replace the period at the end of each triple with a semicolon
    $matchesarraytwo[$key] = preg_replace('/.$/','; ',$matchesarraytwo[$key]);
    // remove the first element in the triple to prepare to write as compacted turtle
    $matchesarraytwo[$key] = preg_replace('/^<[0-9A-Za-z\.\/_#:-]*> /','',$matchesarraytwo[$key]);
  }

  // create a string from the array...
  $stringarray = implode($matchesarraytwo);
  $data = '<> '.'skos:member '.$arrayelementasstring.' . '.$arrayelementasstring.' '.$stringarray;
  // change the terminator in the data to a period to complete the conpacted turtle
  $data = preg_replace('/; $/','.',$data);
  if($dbg == 1){
  echo 'the data is:'."\n";
  echo $data;
  echo 'end of data'."\n";
}

  $rootcontainer = 'http://localhost:8080/marmotta/ldp';

  foreach($array_three_rebased_rebased as $key => $value) {
    $pattern = preg_quote($array_three_rebased_rebased[$key],'/');
    $regex = '/'.$pattern.'/';
    $matcheight = preg_match($regex,$data,$matches);
   if($matcheight == 1) {
     if($dbg == 1){
      echo 'I have a container match in the post data'.$array_three_rebased_rebased[$key]."\n";
    }
      $containerfileexttriples = preg_replace('/http:\/\/[A-Za-z\.]*/',$rootcontainer,$array_three_rebased_rebased[$key]);
     if($dbg == 1){
      echo 'The title for the post container is'.$containerfileexttriples."\n";
     }
      $data = preg_replace($regex,'<>',$data);
     if($dbg == 1){
      echo 'the data for posting is'.$data."\n";
     }
      $url = preg_replace('/[<>]/','',$containerfileexttriples);
     if($dbg == 1){
      echo 'the url for posting the extension triples is:'.$url."\n";
     }
      // pot the extension triples in an existing ldp container
      putrequest($data,$url,$dbg);
      // post to the ldp continer here...
   }
  }


}

// create a function that creates an ldp container..and that is it...
function createldpcontainer($rootcontainer,$target_container,$dbg) {
  $auth = base64_encode('username:password');
  $url = $rootcontainer.$target_container;
  $headers = array('Accept' => 'text/turtle');
  // first check to see if the container exists
  $response = Requests::get($url,$headers);
  if($dbg == 1){
  echo 'The result of get is'."\n";
  var_dump($response->raw);
  }
  // create the container if it does not exist..
  if($response->status_code == 404) {
    $headers_two = array('Content-Type' => 'text/turtle','Slug' => $target_container,'Authorization' => 'Basic '.$auth);
    $response = Requests::post($rootcontainer, $headers_two);
    $string = $response->raw;
    // match the url in the raw response
    preg_match('/Location: http[:\/a-z0-9-_A-Z]*/',$string,$matches);
    $substring = $matches[0];
    preg_match('/http[:\/a-z0-9-_A-Z]*/',$substring,$matches);
    $url = $matches[0];
  }
}

// create a function that posts data to a container
function putrequest($data,$url,$dbg) {
  //$url = 'http://localhost:8080/marmotta/ldp/'.$containertitle;
  $auth = base64_encode('username:password');
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
  $headers = array('Content-Type' => 'text/turtle','If-Match' => $etag,'Authorization' => 'Basic '.$auth);
  //$headers = array('Content-Type' => 'text/turtle','If-Match' => 'W/"1459004153000"','Slug' => 'Penguins are Awesome');
  $response = Requests::put($url, $headers, $data);
  //$response = Requests:_put($url, $headers, json_encode($data));
  if($dbg == 1){
  var_dump($response->body);
  }
}


?>
