   Current Active NordVPN Servers

Current Active NordVPN Servers (getActiveServers.php)
=====================================================

### Background

I've worked in AdTech for >20 years during which time we've had to build tools that help us manage and debug ad-delivery on our site.  
One specifc issue we have faced is managing ads delivered to different Geo-Locations.  
We make use of NordVPN to help us appear as if we are in different countries, which is fine for manual checking BUT what we really wanted to do is be able to leverage Nord in out automated testing tools.  
The issue we found was, eve though we had a list of >6000 named servers from Nord these are not always guaranteed to be currently active. So a server may work one day but not the next.  
We wanted to find a way to access ONLY active servers and this tool is the result of that.  
Every 30mins this tool checks the current active servers from the Nord website (URL) and provides this in easily consumable files that can be loaded into your app as json, js, txt or csv values.

**Latest Update: Saturday 14th of May 2022 06:08:49 PM**

[serverlist.txt](serverlist.txt) - returns a formatted list of servers, one domain per line  
[serverlist.json](serverlist.json) - a json array of servers  
[serverlist.js](serverlist.js) - returns an array called '_nordServers_'  
[serverlist.csv](serverlist.csv) - csv delimited list of servers  
[serverlist.log](serverlist.log) - Date/Time when these file last updated  

[getActiveServers source code](getActiveServers.php.txt)  

### About the code

The core of this tool (getActiveServers.php) is a script I run via the crontab.  
It sits in a folder outside of the webserver directory and is executed via the crontab every 30mins (configurable).  
It's quite a yeavy script and makes upwards of 200 requests to the Nord servers so ensuring it's not publically executable is important.  
It can take up to 2mins to run, so you may need to extend the timeout in your php config, NB: I'm hoping to refactor the code to use cURL multi-threading in the future.  
Once all results are collected it then outputs a list of active servers it's obtained into a number of different file formats: txt, json, js and csv  
It then copies these files to another directory (the files you can access above) to publically expose them for your use.  
If you do not want to copy these files just comment out the line starting '_$conf\["destinationDir"\]_'  

### Configuration

To get this working on your setup you'll need to configure a handful of parameters. These are all at the start of the script and are prefixed $conf\[VAR\_NAME\]  

         //////////////////////////////////////////////////////////////////////////////////////////
         // CONFIGURATION
         //////////////////////////////////////////////////////////////////////////////////////////
           $conf\["installDir"\]     = "DIR\_IN\_WHICH\_THIS\_SCRIPT\_WILL\_RUN";  // the dir this script is installed in eg; /home/nordVPN/
           $conf\["destinationDir"\] = "DIR\_TO\_COPY\_FILES\_TO";               // the dir into which you want to copy the serverlist files eg; /home/www/nord/
           $conf\["filename"\]       = "serverlist";                         // name of the files output , these are appended by file extensions in the next line
           $conf\["output\_types"\]   = \['txt','json','js','csv','log'\];      // list of support file outut types
           $conf\["serverMaxCount"\] = 300;                                  // each country is represented as a number, 200 should mean we capture all known countries - this needs optimising!
         //////////////////////////////////////////////////////////////////////////////////////////
        

Crontab:  
Change the location according to where you've installed this script. The following will execute every 15mins

        \*/15 \* \* \* \* php /DIR\_IN\_WHICH\_THIS\_SCRIPT\_WILL\_RUN/getActiveServers.php
        

Permissions:  
This shoudl all work as is... however, you may need to ensure you have permissions to write and copy fils to the respective directories.

### Contact

[\[email protected\]](/cdn-cgi/l/email-protection)  
[\[email protected\]](/cdn-cgi/l/email-protection)
