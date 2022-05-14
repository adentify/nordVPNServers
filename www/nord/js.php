<?php
  header('Content-Type: application/javascript');
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
?>

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function testServer(){
  console.log("FETCH: testServer(): ");
  // set up the table to make it look like it's calling something
  var url = window.servers[0];
  var geo = window.geo;
  function makeCall(url, geo){
    console.log("FETCH: makeCall() Attempting to fetch record: ",url, geo);
    // 1. Create a new XMLHttpRequest object
    let xhr = new XMLHttpRequest();

    // build the corret url to send in the test, 
    var fetchUrl  = "fetch.php?url="+url+"&geo="+geo;

    // 2. Configure it: GET-request for the URL /article/.../load
    xhr.open('GET', fetchUrl, true);
    // 
    //xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // 3. Send the request over the network
    //xhr.send(document.getElementById('payload').value);
    //xhr.send(payload);
    xhr.send();
    // 4. This will be called after the response is received
    xhr.onload = function() {
      if (xhr.status != 200) { // analyze HTTP status of the response
        console.log('FETCH: makeCall() Error',xhr); // response is the server response
      } else { // show the result
        console.log('FETCH: makeCall() Success',xhr); // response is the server response
        // output pyload to page
        data = JSON.parse(xhr.responseText.trim());
        handleResponse(data);
      }
    };
    xhr.onerror = function() {
      console.log("FETCH: makeCall() FAIL");
    };
  }

  makeCall(url, geo);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function analyse(){
  // get the list of servers to test
  window.servers = document.getElementById('serverlist').value.split("\n");
  window.geo     = document.getElementById('chosenGeo').getAttribute('data-geo')

  testServer();
}


function handleResponse(obj){

  console.log("handleResponse() - ", obj);
  var table = document.getElementById('mainTable');
  // remove the last row in the table as this is the one suggesting the process is still checking 
  //  table.deleteRow(table.rows.length -1);


  obj.html = obj.html || {};

  // add output to the table
  var row  = table.insertRow(-1); // -1 appends to the end of the table
  var rowCount = table.rows.length;
      row.id = "tblRowID-"+rowCount
    // add cells
    cell = row.insertCell(-1);
    cell.innerHTML = decodeURIComponent(decodeURIComponent(obj.conf.url));

    cell = row.insertCell(-1);
    cell.innerHTML = "<img src='flags/"+obj.conf.proxy.geo.toLowerCase()+".png' height='30px' alt='"+obj.conf.proxy.geo+"' title='"+obj.conf.proxy.geo+"'>";
    cell.style.textAlign = "center";

    cell = row.insertCell(-1);
    if(obj.html.ip){
      cell.innerHTML  = "WORKING";
      cell.className += " perfGreen";
    } else {
      cell.innerHTML  = "DOWN";
      cell.className += " perfRed";
    }
    cell = row.insertCell(-1);
    cell.innerHTML = obj.conf.proxy.host || "ERROR";

    cell = row.insertCell(-1);
    cell.innerHTML = obj.html.country_name || "ERROR";

    cell = row.insertCell(-1);
    cell.innerHTML = obj.html.ip || "ERROR";

    cell = row.insertCell(-1);
    cell.innerHTML = obj.html.city || "ERROR";

    cell = row.insertCell(-1);
    cell.innerHTML = obj.html.in_eu || "ERROR";

    cell = row.insertCell(-1);
    cell.innerHTML = obj.html.continent_code || "ERROR";


        // remove this 
        window,servers.shift();
        // call the analyser again
        if(window.servers.length>0){
          testServer();
        }

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function loadGeoList(geo){

   // add an ALL option
   var newOption            = document.getElementById("vpnServer");
   var option       = document.createElement("option");
       option.value = "ALL";     
       option.text  = "ALL Countries";
       option.selected = true;
       newOption.add(option); 
   // Add geo codes from main nordVPNServers.countries object - https://www.delftstack.com/howto/javascript/add-options-to-select-with-javascript/
   var geoCodes = Object.keys(nordVPNServers.servers.country);
   for(var i=0; i<geoCodes.length; i++){
      // chck if this geo exists in the classList

      var newOption    = document.getElementById('vpnServer');
      var option       = document.createElement('option');
         option.value = geoCodes[i].toUpperCase();     
         option.text  = nordVPNServers.countries[geoCodes[i]];
         newOption.add(option);    
       //console.log(option);         


   }
   loadVPNServerList(document.getElementById('vpnServer').value.toLowerCase());
   updateChosenGeo(document.getElementById('vpnServer').value);
}


function loadVPNServerList(geo){
  //console.log('loadVPNServerList',geo);
  if(geo == 'all'){
    var servers = nordVPNServers.servers.all.join('\n');
  } else {
    var servers = nordVPNServers.servers.country[geo].join('\n');
  }

  //console.log('loadVPNServerList',geo,servers);
  // getlist of servers
  // delete current classList
  document.getElementById('serverlist').value = ""; 
  // update with this list
  document.getElementById('serverlist').value = servers; 

}


function upDateServerList(){
  //console.log("upDateServerList");
   // get new geo value
   var geo = document.getElementById("vpnServer").value.toLowerCase();
   loadVPNServerList(geo);
   updateChosenGeo(geo);
}

function updateChosenGeo(geo){
  console.log("updateChosenGeo", geo);
  var el = document.getElementById('chosenGeo');
      el.innerHTML = "<img src='flags/"+geo.toLowerCase()+".png' height='50px' border='0'>";
      el.setAttribute('data-geo', geo.toLowerCase());
}


////////////////////////////////////////////////////////////////////////////////////////////////////////////////

window.addEventListener('DOMContentLoaded', (event) => {
  console.log('DOM fully loaded and parsed');
  loadGeoList();
});


