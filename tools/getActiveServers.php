<?php
  //https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:10}
  //https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:2}
  //https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:13}
  //https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:227} UK

  header("Content-Type: text/plain");

  $conf["useragent"]      = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
  $conf["serverMaxCount"] = 300;

  function getUrl($url){

    $conf["url"] = $url;
    // Instantiate the CURL instance
    $curl = curl_init();

    // define CURL parameters
    curl_setopt($curl, CURLOPT_URL,                  $conf["url"]);
    curl_setopt($curl, CURLOPT_USERAGENT,            $conf["useragent"]);
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


  $output  = "";

  for($i = 0 ; $i<$conf["serverMaxCount"]; $i++){
    $url     = "https://nordvpn.com/wp-admin/admin-ajax.php?action=servers_recommendations&filters={%22country_id%22:$i}";
    $servers = json_decode(getUrl($url), true);
    if(count($servers)>0){
      for($n=0; $n < count($servers); $n++){
        $results[] = $servers[$n]['hostname'];
      }
    }
  }

  // OUTPUT
  if(!$_GET['type']){
    for($n=0; $n < count($results); $n++){
      $output .= $results[$n]."\n";
    }
//  } elseif ($_GET['json']) {
//    // code...
//  } elseif ($_GET['js']) {
//    // code...
  } elseif ($_GET['csv']) {
    for($n=0; $n < count($results); $n++){
      $output .= $results[$n].",";
    }
  }


  print $output;

?>
