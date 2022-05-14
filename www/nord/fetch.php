<?php
  $conf["url"]           = "https://ipapi.co/json/";
  $conf["useragent"]     = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";
  $conf["proxy"]["host"] = $_GET['url'];
  $conf["proxy"]["geo"]  = $_GET['geo'];
  $conf["proxy"]["port"] = 89; 
  // your normal user/pass credentials will not work, you have to use the 'service credentials' which can be obtained from your account dashboard athttps://my.nordaccount.com/dashboard/nordvpn/
  $conf["proxy"]["user"] = "LyUCSndKxbqZDqZc6vKySJei";
  $conf["proxy"]["pass"] = "sSjvDyW2SckhPDpJPZAYUbsb";


  // Instantiate the CURL instance
  $curl = curl_init();

  // define CURL parameters
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,       0); 
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,       0); 
  curl_setopt($curl, CURLOPT_PROXY_SSL_VERIFYPEER, 0); 
  curl_setopt($curl, CURLOPT_PROXY,                "https://".$conf["proxy"]["host"].":".$conf["proxy"]["port"]);
  curl_setopt($curl, CURLOPT_PROXYPORT,            $conf["proxy"]["port"]);
  curl_setopt($curl, CURLOPT_PROXYUSERPWD,         $conf["proxy"]["user"].":".$conf["proxy"]["pass"]);
  curl_setopt($curl, CURLOPT_URL,                  $conf["url"]);
  curl_setopt($curl, CURLOPT_USERAGENT,            $conf["useragent"]);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION,       1); 
  curl_setopt($curl, CURLOPT_HEADER,               0); 
  curl_setopt($curl, CURLOPT_RETURNTRANSFER,       1); 

  // fetch the page content/body
  $html = curl_exec($curl);  

  // get connection data
  $response = curl_getinfo($curl);

  // add the HTML body to the responseobject, comment out if not needed
  // in this example we are including the response from https://ipapi.co/json/ as this shows the geo/ip details of the orignating proxy server
  $response['html']   = json_decode($html);
  $response['conf']   = $conf;

  // close the curl instance
  curl_close($curl);

  // output the results as a text file

//header('application/json');
header("Content-Type: text/plain");

//  print_r($response);
//  print_r($_GET);
//  print_r($conf);
print(json_encode($response, JSON_PRETTY_PRINT));

?>