<?php
  header('Content-Type:text/plain');

  $conf["url"]           = "https://ipapi.co/json/";
  $conf["useragent"]     = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";

  $conf["proxy"]["host"] = "al24.nordvpn.com";

  // NordVPN uses 1080 for it's socks proxies
  $conf["proxy"]["port"] = 89; 

  // your normal user/pass credentials will not work, you have to use the 'service credentials' which can be obtained from your account dashboard athttps://my.nordaccount.com/dashboard/nordvpn/
  $conf["proxy"]["user"] = "YOUR_SERVICE_USERNAME";
  $conf["proxy"]["pass"] = "YOUR_SERVICE_PASSWORD";


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

  // add the proxy used to the response object
  $response['proxy']  = $conf["proxy"]["host"];

  // add the HTML body to the responseobject, comment out if not needed
  // in this example we are including the response from https://ipapi.co/json/ as this shows the geo/ip details of the orignating proxy server
  $response['html']   = $html;

  // close the curl instance
  curl_close($curl);

  // output the results as a text file
  header('Content-Type:text/plain');
  print_r($response);
?>
