<?php
//////////////////////////////////////////////////////////////////////////////////////////
// Current Active NordVPN Servers (getActiveServers.php)

//////////////////////////////////////////////////////////////////////////////////////////
// TODO
// - only query valid country IDs
// - handle threading of curl requests instead of one-at-a-time
// - add execution time in the .log output
// - add an additional verbose json response that also includes other data about each server such as protocol, ip-addr, location, service-quality etc... 


//////////////////////////////////////////////////////////////////////////////////////////
// set the local timezone to London or somewhere else
date_default_timezone_set('Europe/London');
// this script is not intended to be run in a browser
// it should be called via a cron job 
header("Content-Type: text/plain");

//////////////////////////////////////////////////////////////////////////////////////////
// CONFIGURATION
//////////////////////////////////////////////////////////////////////////////////////////
  $conf["installDir"]     = "DIR_PATH_OF_THIS_SCRIPT";  // the dir this script is installed to
  $conf["destinationDir"] = "DIR_PATH_OF_WHERE_FILES_ARE_COPIED_TO";  // the dir into which ou want to copy tyhr serverlist files
  $conf["filename"]       = "serverlist";  // name of the files output
  $conf["output_types"]   = ['txt','json','js','csv','log'];
  // each country has an ID number associated, this is sent in the url 
  // I don't know how many values they support BUT this should be less tha n the total number of countries in the world which is currently <300
  // TODO: Get a list of country and codes instead which will improve performance
  $conf["serverMaxCount"] = 300; 
//////////////////////////////////////////////////////////////////////////////////////////


//////////////////////////////////////////////////////////////////////////////////////////
// FUNCTIONS
//////////////////////////////////////////////////////////////////////////////////////////
// query Nord to fetch active server list for country
  function getUrl($url){
    // TODO: making CURL requests one-by-one is SLOW
    // considering using cURL multithreading to run multiple concurent connections: https://stackoverflow.com/questions/12394027/curl-multi-threading-with-php

    //https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:10}
    //https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:2}
    //https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:13}
    //https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:227} UK
    // Instantiate the CURL instance
    $curl = curl_init();

    // define CURL parameters
    curl_setopt($curl, CURLOPT_URL,                  $url);
    curl_setopt($curl, CURLOPT_USERAGENT,            "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,       1); 
    curl_setopt($curl, CURLOPT_HEADER,               0); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,       1); 

    // fetch the page content/body
    $html = curl_exec($curl);  

    // add the HTML body to the responseobject, comment out if not needed
    // in this example we are including the response from https://ipapi.co/json/ as this shows the geo/ip details of the orignating proxy server
    $response  = json_decode($html);

    // close the curl instance
    curl_close($curl);

    // output the results as a text file
    return json_encode($response, JSON_PRETTY_PRINT);
  }

  // 
  function writeFile($type, $results, $conf){
    $output     = "";
    $filename   = $conf["filename"].".".$type;       // name of the file including fileextension
    $filelocal  = $conf["installDir"].$filename;     // initial outout location of the file
    $filedest   = $conf["destinationDir"].$filename; // this is where you want the files moved to ie; into a publically accesibble flder on the web server
    $myfile     = fopen($filelocal, "w");            // open a local file with the supplied filename
    // Build text output based on type
    if($type=="txt"){
      // OUTPUT - text
        for($n=0; $n < count($results); $n++){
          $output .= $results[$n]."\n";
        }
    }
    if($type=="json"){
      // OUTPUT - json
        $output .= json_encode($results, JSON_PRETTY_PRINT)."\n";
    }
    if($type=="js"){
      // OUTPUT - js
        $output .= "var nordServers = [";
        for($n=0; $n < count($results); $n++){
          $output .= "'".$results[$n]."',";
        }
        $output = substr($output,0,-1)."];"."\n"; // removes trailing comma and closes the array enclosure
    }
    if($type=="csv"){
      // OUTPUT - csv
        for($n=0; $n < count($results); $n++){
          $output .= $results[$n].",";
        }
        $output = substr($output,0,-1)."\n";  // removes trailing comma
    }
    // oututs the date/time this ran
    if($type=="log"){
      // OUTPUT - json
        $output .= date("l jS \of F Y h:i:s A")."\n";
    }
    // write to file and close
    fwrite($myfile, $output);
    fclose($myfile);
    // if $conf["destinationDir"] is set then copy files to this directory
    if(isset($conf["destinationDir"])){
      copy($filelocal, $filedest);
      // output to the screen
      print("MOVING FILE: {$filelocal} -> {$filedest}\n");
    } else {
      print("NOT MOVING FILE: {$filelocal}\n");
    }
  }

///////////////////////////////////////////////
// check each country code
  for($i = 0 ; $i<$conf["serverMaxCount"]; $i++){
    $url     = "https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:$i}";
    $servers = json_decode(getUrl($url), true);
    if(count($servers)>0){
      for($n=0; $n < count($servers); $n++){
        $results[] = $servers[$n]['hostname'];
      }
    }
  }


////////////////////////////////////////////////
// write files
  foreach($conf["output_types"] as $type){
    writeFile($type,  $results, $conf);
  }

?>
