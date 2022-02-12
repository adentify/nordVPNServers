#!/usr/bin/env node

// Screengrab generator
// outputs a JSON object with a base64 encoded image of the screengrab
// eg;


const puppeteer = require('puppeteer');

let conf          = new Object();
let output        = new Object();

conf.url      = "https://www.telegraph.co.uk";

// VPN
conf.vpnUser   = conf.vpnUSer   || 'USERNAME';
conf.vpnPass   = conf.vpnPass   || 'PASSWORD';
conf.vpnServer = conf.vpnServer || "https://uk1785.nordvpn.com:89";



(async() => {


    const browser = await puppeteer.launch({
            headless: true,
            args: [
                    '--disable-dev-shm-usage',
                    '--proxy-server='+conf.vpnServer
            ]
    });


    try {
      const page = await browser.newPage();

      await page.authenticate({
        username: conf.vpnUser,
        password: conf.vpnPass,
      });



      await page.goto(conf.url, { waitUntil: 'networkidle2' });

      await page.setViewport({
        width : 1920,
        height: 1080,
        deviceScaleFactor: 1,
      });



      let screenshot = await page.screenshot({ encoding: "base64"}).then(function(data){
          let base64Encode = `data:image/png;base64,${data}`;
          return base64Encode;
      });


      output.screengrab = screenshot;


      console.log(JSON.stringify(output));

    } catch (error) {
        console.error(error);
    } finally {
        await browser.close();
    }


})();
