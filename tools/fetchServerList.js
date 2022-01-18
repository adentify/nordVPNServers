// Output a JSON object containing all the named servers on: https://nordvpn.com/ovpn/
// Use: 
// - navigate to https://nordvpn.com/ovpn/
// - open the console
// - run the folllowing code in the console, it will exho back an arrray of all server names

var servers = document.getElementsByClassName("ListItem");
var output = [];

// populate servers object with data
for(var i = 0; i < servers.length-1; i++){
  // get the domain name
  thisServer = servers[i].getElementsByClassName("mr-2")[0];
  // ensure thisServer is valid
  if(typeof thisServer != "undefined"){
    // add to the servers array
    output.push(thisServer.innerText);
  }
}
console.log(JSON.stringify(output));
