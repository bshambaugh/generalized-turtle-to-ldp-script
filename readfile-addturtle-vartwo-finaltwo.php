<?php
//$filename = 'first_one-hundred-nasa-spacecraft-filtered-addjpg.nt';
//$filename = 'first_one-hundred-nasa-spacecraft-filtered.nt';
//$filename = 'nasa-spacecraft-filtered.nt';
$filename = 'nasa-spacecraft-selected.nt';
$fp = fopen($filename,'rw');
$string = fread($fp, filesize($filename));
fclose($fp);
echo $string;
$duck = explode("\n",$string);
echo 'The count of ducks is'.count($duck);
unset($duck[count($duck) - 1]);
print_r($duck);
var_dump($duck);

//preg_match('/<http:\/\/data\.kasabi\.com\/dataset\/nasa\/>/',$duck[1],$matches);
$matchone = preg_match('/^<[0-9A-Za-z:_\.\/-]*>/',$duck[1],$matches);
print_r($matches);
if($matchone == 1) {
  echo $matches[0];
}

$map_two = array();

foreach($duck as $key => $value) {
  $matchtwo = preg_match('/^<[0-9A-Za-z:_\.\/#-]*>/',$duck[$key],$matches);
  if($matchtwo == 1) {
    echo $matches[0]."\n";
    $map_two[$key] = $matches[0];
  }
}

echo '------------------This is map one:----------------';

/*
foreach($map_one as $key => $value) {
 echo $map_one[$key]."\n";
}
*/

$array_three = array();

$array_three = array_unique($map_two);
$array_three_ext = array();

echo "array three is"."\n";
print_r($array_three);

echo "\n";

foreach($array_three as $key => $value) {
   $string_two = preg_match('/^<[0-9A-Za-z:_\/\.#]*\.[A-Za-z]*>/',$array_three[$key],$matches);
  // preg_match('/[0-9A-Za-z_\.]*$>/',$array_three[$key],$matches);
  echo $string_two.'is the man';
if($string_two == 1) {
  $string = $matches[0];
  array_push($array_three_ext,$string);
}
 // print_r($matches);
//echo $array_three[$key];
}

echo 'Array three ext'."\n";

foreach($array_three_ext as $key => $value) {
  echo $array_three_ext[$key];
}

echo "array three is"."\n";
print_r($array_three);

echo "\n";

// nest all of these arrays in the future..
$array_sixty = array();
$array_six = array();

foreach($array_three as $key => $value) {
  $replace_one =  preg_replace('/[<>]/','',$array_three[$key]);
  $replace_two = preg_replace('/http:\/\/[a-zA-Z0-9\.-]*\//','',$replace_one);
  $pizza = explode('/',$replace_two);
  foreach($pizza as $key_three => $value) {
    $array_sixty[strval($array_three[$key])][$key_three] = strval($pizza[$key_three]);
  }
}


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

echo 'array six is:'."\n";
print_r($array_six);
echo 'array sixty is:'."\n";
print_r($array_sixty);



$matches = array();

foreach($array_six as $keyone => $value) {
//  echo $keyone."\n";


$matches = array(NULL);
$matchesarraytwo = array();
$ahappystring = $keyone;
//$ahappystring = '<http://data.kasabi.com/dataset/nasa/launchsite/hammaguir>';
$pattern = preg_quote($ahappystring,'/');
$regex = '/^'.$pattern.' <[a-zA-Z0-9_:#-\/\.]*> (<[a-zA-Z0-9_:#-\/\.]*>|"[a-z ,A-z0-9-]*") ./';


foreach($duck as $key => $value) {
$matches[0] = NULL;
$firstmatch = preg_match($regex,$duck[$key],$matches);
//preg_match('/^<http:\/\/data\.kasabi\.com\/dataset\/nasa\/launchsite\/hammaguir> <[0-9A-Za-z\.\/#:-]*> (\"[a-zA-Z0-9-]*\"|<[0-9A-Za-z\.\/:#-]*>) ./',$duck[$key],$matches);
if($firstmatch == 1) {
echo 'the first match is'.$firstmatch;


 if($matches[0] != NULL) {
//  echo $matches[0].'matches is not null';
  array_push($matchesarraytwo,$matches[0]);
 }

}

// print_r($matches);
 // create the turtle files here...
}

foreach($matchesarraytwo as $key => $value) {
  echo $matchesarraytwo[$key]."\n";
 $matchesarraytwo[$key] = preg_replace('/.$/','; ',$matchesarraytwo[$key]);
 $matchesarraytwo[$key] = preg_replace('/^<[0-9A-Za-z\.\/_#:-]*> /','',$matchesarraytwo[$key]);
}

// I stopped looking at the code here...
$stringarray = implode($matchesarraytwo);
// $data = '<> '.' skos:member '.$keyone.' . '.$keyone.' '.$stringarray;
// comment the original data defintion out and replace with the one above (oops this should be the data for the original container...)
$data = '<> '.$stringarray;
$data = preg_replace('/; $/','.',$data);
echo 'the data is:'."\n";
echo $data;
echo 'end of data'."\n";
// the original containers are above... the stuff above is for

/// How do I wrap the stuff below in a function???
// ----------------------------------------------------
//.. I commented it out so it works...
/*
$array_sixty_six = array();

// so array sixty has what we want in addition to .jpg
echo 'This is array sixty:'."\n";
foreach($array_sixty as $key => $value) {
  //echo $key."\n";
  preg_match('/\.[a-zA-Z]*>/',$key,$matches);
  if($matches != NULL) {
   echo 'The matches is here'.$matches[0].'for'.$key;
  }
  if($matches == NULL) {
    array_push($array_sixty_six,$key);
  }
}

$array_sixty_seven = array();

foreach($array_sixty_six as $key => $value) {
  preg_match('/<>/',$array_sixty_six[$key],$matches);
  if($matches == NULL) {
    echo $array_sixty_six[$key]."\n";
    array_push($array_sixty_seven,$array_sixty_six[$key]);
  }
}

array_push($array_sixty_seven,'<http://data.kasabi.com/dataset/nasa/spacecraft/1965-091A>');
foreach($array_sixty_seven as $key => $value) {
  echo $array_sixty_seven[$key]."\n";
}

foreach($array_sixty_seven as $key => $value) {
  $pattern = preg_quote($array_sixty_seven[$key],'/');
  $regex = '/'.$pattern.'/';
  preg_match($regex,$data,$matches);
  if($matches != NULL) {
    echo 'I match for'.$array_sixty_seven[$key]."\n";
    $data = preg_replace($regex,'<>',$data);
    echo $data."\n";
  }
}
*/
//}
/// ---------------------------------------------------------------------

// put the ldp container stuff here ...
// first take the array to create the ldp container...
// then post the data...

  $count = 0;
  foreach (array_filter($array_six[$keyone]) as $keytwo => $value) {
      echo $array_six[$keyone][$keytwo]."\n";
      $count++;
  }
   echo "\n";
   echo 'The count is'.$count."\n\n";

$string = '';
$rootcontainer = 'http://localhost:8080/marmotta/ldp/';
$string = $rootcontainer;

//foreach($arrayone as $key => $value) {
 for($i = 0; $i < $count; $i++) {
//  echo $arrayone[$key][$i]."\n";
//    echo $i."\n";
  echo 'root container: '.$string.', target container: '.$array_six[$keyone][$i]."\n";
 // createldpcontainer($string,$arrayone[$key][$i]);
  $string = $string.$array_six[$keyone][$i].'/';
  // echo $string.' Slug: '.$arrayone[$key][$i]."\n";
 }


$url = $string;
echo 'start of ldp put'."\n";
echo 'The url is: '.$url."\n";
echo 'The data is: '."\n";
echo $data;
echo "\n";
echo 'end of ldp put'."\n";
//putrequest($data,$url);

}


foreach($array_six as $key => $value) {
 echo $key."\n";
 $matchthree = preg_match('/[A-Za-z0-9#:-]*>/',$key,$matches);
if($matchthree == 1) {
   $matchresult = $matches[0];
   $replaceresult = preg_replace('/>/','',$matchresult);
   echo $replaceresult."\n";
 }
 // This only works for things in the array without an ending "/" .. but this is good becauase we do not have a turtle file to post?? not necessarily..
}

print_r($array_six);

foreach($array_six as $key => $value) {
  array_push($array_sixty,$array_six[$key]);
}

/// this is the new stuff for array sixty six...

foreach($array_six as $keyone => $value) {
//  echo $keyone."\n";


$matches = array(NULL);
$matchesarraytwo = array();
$ahappystring = $keyone;
//$ahappystring = '<http://data.kasabi.com/dataset/nasa/launchsite/hammaguir>';
$pattern = preg_quote($ahappystring,'/');
$regex = '/^'.$pattern.' <[a-zA-Z0-9_:#-\/\.]*> (<[a-zA-Z0-9_:#-\/\.]*>|"[a-z ,A-z0-9-]*") ./';


foreach($duck as $key => $value) {
$matches[0] = NULL;
$matchfive = preg_match($regex,$duck[$key],$matches);
//preg_match('/^<http:\/\/data\.kasabi\.com\/dataset\/nasa\/launchsite\/hammaguir> <[0-9A-Za-z\.\/#:-]*> (\"[a-zA-Z0-9-]*\"|<[0-9A-Za-z\.\/:#-]*>) ./',$duck[$key],$matches);

if($matchfive == 1) {
 if($matches[0] != NULL) {
//  echo $matches[0].'matches is not null';
  array_push($matchesarraytwo,$matches[0]);
 }
}

// print_r($matches);
 // create the turtle files here...
}

foreach($matchesarraytwo as $key => $value) {
  echo $matchesarraytwo[$key]."\n";
 $matchesarraytwo[$key] = preg_replace('/.$/','; ',$matchesarraytwo[$key]);
 $matchesarraytwo[$key] = preg_replace('/^<[0-9A-Za-z\.\/_#:-]*> /','',$matchesarraytwo[$key]);
}

$stringarray = implode($matchesarraytwo);
$data = '<> '.' skos:member '.$keyone.' . '.$keyone.' '.$stringarray;
// comment the original data defintion out and replace with the one above (oops this should be the data for the original container...)
// $data = '<> '.$stringarray;
$data = preg_replace('/; $/','.',$data);
echo 'the data is:'."\n";
echo $data;
echo 'end of data'."\n";

$array_sixty_six = array();

// so array sixty has what we want in addition to .jpg
echo 'This is array sixty:'."\n";
foreach($array_sixty as $key => $value) {
  //echo $key."\n";
  $matchsix = preg_match('/\.[a-zA-Z]*>/',$key,$matches);
  if($matchsix == 1) {
    if($matches != NULL) {
     echo 'The matches is here'.$matches[0].'for'.$key;
    }
    if($matchsix == 0) {
    //  if($matches == NULL) {
        array_push($array_sixty_six,$key);
    //  }
    }
  }
}

$array_sixty_seven = array();

foreach($array_sixty_six as $key => $value) {
  $matchseven = preg_match('/<>/',$array_sixty_six[$key],$matches);
 if($matchseven == 0) {
 //if($matchseven == 1) {
//  if($matches == NULL) {
    echo $array_sixty_six[$key]."\n";
    array_push($array_sixty_seven,$array_sixty_six[$key]);
//  }
 //}
 }
}

// Brentnote: I commented this out for testing...
/*
array_push($array_sixty_seven,'<http://data.kasabi.com/dataset/nasa/spacecraft/1965-091A>');
foreach($array_sixty_seven as $key => $value) {
  echo $array_sixty_seven[$key]."\n";
}
*/

foreach($array_sixty_seven as $key => $value) {
  $pattern = preg_quote($array_sixty_seven[$key],'/');
  $regex = '/'.$pattern.'/';
  $matcheight = preg_match($regex,$data,$matches);
 if($matcheight == 1) {
  if($matches != NULL) {
    echo 'I match for ---- <<<<giant centipede>>>>'.$array_sixty_seven[$key]."\n";
    $data = preg_replace($regex,'<>',$data);
    echo $data."\n";
  }
 }
}
}

// this is an echo of array_sixty_six
echo "\n";
echo 'This is array sixty six'."\n";
print_r($array_sixty_six);
echo "\n";
echo 'This is array sixty seven'."\n";
print_r($array_sixty_seven);

?>
