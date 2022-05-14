<?php
?>

<html>
<head>

<link rel="stylesheet" href="css.php">
<script type="text/javascript" src="nordservers.php" defer></script> 
<script type="text/javascript" src="js.php" defer></script> 

</head>

<body>

  <div id="header_container">
      <div id="header">
          NORD PROXY SERVER STATUS CHECKER [VERY ALPHA]
      </div>
  </div>


  <div id="container">
      <div id="content">

        <table id="mainTable" width="100%">
            <thead>
              <tr>
                <th width="600px">URL</th>
                <th width="75px">Country</th>
                <th width="75px">Status</th>
                <th width="150px">Domain</th>
                <th width="150px">IP</th>
                <th width="150px">Country</th>
                <th width="150px">City</th>
                <th width="100px">In EU</th>
                <th width="100px">Continent</th>
              </tr>
            </thead>
        </table>

        <p></p>


      </div>
  </div>


   
  <div id="footer_container">
      <div id="footer">

       <table width="100%">
          <tr>
            <td align="center" valign="middle" class="confTblTitle" colspan="4">Configuration</td>
          </tr>
          <tr>
            <td align="center" valign="middle" class="confTblLabel">
              URLs
            </td>
            <td align="center" class="confTblLabel">
              <label for="vpnServer">Geo List:</label>
            </td>
            <td align="center" class="confTblLabel">
              <label for="chosenGeo">Chosen Geo:</label>
            </td>
            <td rowspan="2" align="center" valign="middle" width="15%">
              <button type="button" onClick="analyse()" style="height: 50px; width: 100px;">Analyse:</button>
            </td>
          </tr>

          <tr>
            <td align="center" valign="middle" width="50%%">
              <textarea id="serverlist" name="serverlist" rows="5" style="width:100%">
              </textarea>
            </td>
            <td align="center">
              <select id="vpnServer" name="vpnServer" onchange="upDateServerList()">
              </select>        
            </td>
            <td align="center" id="chosenGeo">
              
            </td>
          </tr>


          <tr>
            <td align="center" valign="middle" class="confTblFooter" colspan="4">...</td>
          </tr>

        </table>



      </div>
  </div>

</body>
</html>
