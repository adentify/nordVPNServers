<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Current Active NordVPN Servers</title>
  </head>

  <body>

    <div id="container">

      <div id="title">
        <h1>Current Active NordVPN Servers (getActiveServers.php)</h1>
      </div>

      <div id="description">
        <div class="text_content">
          <h3>Background</h3>
<p>I've worked in AdTech for >20 years during which time we've had to build tools that help us manage and debug ad-delivery on our site. <br>
One specifc issue we have faced is managing ads delivered to different Geo-Locations.<br>
We make use of NordVPN to help us appear as if we are in different countries, which is fine for manual checking BUT what we really wanted to do is be able to leverage Nord in out automated testing tools.<br>
The issue we found was, eve  though we had a list of >6000 named servers from Nord these are not always guaranteed to be currently active. So a server may work one day but not the next.<br>
We wanted to find a way to access ONLY active servers and this tool is the result of that.<br>
Every 30mins this tool checks the current active servers from the Nord website (URL) and provides this in easily consumable files that can be loaded into your app as json, js, txt or csv values.</p>

<p><strong>Latest Update: <?php include("serverlist.log"); ?></strong></p>

<p>
  <a href="serverlist.txt">serverlist.txt</a> - returns a formatted list of servers, one domain per line<br>
  <a href="serverlist.json">serverlist.json</a> - a json array of servers<br>
  <a href="serverlist.js">serverlist.js</a> - returns an array called '<i>nordServers</i>'<br>
  <a href="serverlist.csv">serverlist.csv</a> - csv delimited list of servers<br>
  <a href="serverlist.log">serverlist.log</a> - Date/Time when these file last updated<br>
</p>

<p>
  <a href="getActiveServers.php.txt">getActiveServers source code</a><br>
</p>

        </div>
      </div>




      <div id="contact">
        <h3>About the code</h3>
        <div class="text_content">
The core of this tool (getActiveServers.php) is a script I run via the crontab.<br>
It sits in a folder outside of the webserver directory and is executed via the crontab every 30mins (configurable).<br>
It's quite a yeavy script and makes upwards of 200 requests to the Nord servers so ensuring it's not publically executable is important.<br>
It can take up to 2mins to run, so you may need to extend the timeout in your php config, NB: I'm hoping to refactor the code to use cURL multi-threading in the future.<br>
Once all results are collected it then outputs a list of active servers it's obtained into a number of different file formats: txt, json, js and csv<br>
It then copies these files to another directory (the files you can access above) to publically expose them for your use.<br>
If you do not want to copy these files just comment out the line starting '<i>$conf["destinationDir"]</i>'<br>
        </div>
      </div>

      <div id="contact">
        <h3>Configuration</h3>
        <div class="text_content">
        To get this working on your setup you'll need to configure a handful of parameters. These are all at the start of the script and are prefixed $conf[VAR_NAME]<br>
        <pre>
         //////////////////////////////////////////////////////////////////////////////////////////
         // CONFIGURATION
         //////////////////////////////////////////////////////////////////////////////////////////
           $conf["installDir"]     = "DIR_IN_WHICH_THIS_SCRIPT_WILL_RUN";  // the dir this script is installed in eg; /home/nordVPN/
           $conf["destinationDir"] = "DIR_TO_COPY_FILES_TO";               // the dir into which you want to copy the serverlist files eg; /home/www/nord/
           $conf["filename"]       = "serverlist";                         // name of the files output , these are appended by file extensions in the next line
           $conf["output_types"]   = ['txt','json','js','csv','log'];      // list of support file outut types
           $conf["serverMaxCount"] = 300;                                  // each country is represented as a number, 200 should mean we capture all known countries - this needs optimising!
         //////////////////////////////////////////////////////////////////////////////////////////
        </pre>

        <p>Crontab:<br>Change the location according to where you've installed this script. The following will execute every 15mins</p>
        <pre>
        */15 * * * * php /DIR_IN_WHICH_THIS_SCRIPT_WILL_RUN/getActiveServers.php
        </pre>

         <p>Permissions:<br>This shoudl all work as is... however, you may need to ensure you have permissions to write and copy fils to the respective directories.</p>
       </div>
      </div>




      <div id="contact">
        <h3>Contact</h3>
        <div class="text_content">
sean@telegraph.co.uk<br>
sean@adentify.net<br>
        </div>
      </div>

    </div>

  </body>



</html>