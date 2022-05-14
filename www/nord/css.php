
/* Reset body padding and margins */
body { 
  margin:0; 
  padding:0; 
  font-family: consolas, arial, verdana, sans-serif
}
 
/* Make Header Sticky */
#header_container { 
  background:#C2C2C2; 
  border:1px solid #666; 
  height:60px; 
  left:0; 
  position:fixed; 
  width:100%; 
  top:0; 
}
#header{ 
  line-height:60px; 
  margin:0 auto; 
  width:940px; 
  text-align:center; 
}
 
/* CSS for the content of page. I am giving top and bottom padding of 80px to make sure the header and footer do not overlap the content.*/
#container { 
  margin:0 auto; 
  overflow:auto; 
  padding:60px 0; 
  width:100%; 
}

#content{}
 
/* Make Footer Sticky */
  #footer_container { 
  background:#C2C2C2; 
  border:1px solid #666; 
  bottom:0; 
  height: auto;
  left:0; 
  position:fixed; 
  width:100%; 
}
#footer { 
  height: auto;
  margin:0 auto; 
  text-align:center; 
}

.confTblTitle {
  background-color: #C2C2C2;
}

.confTblLabel {
  background-color: #D8D8D8
}


.screengrabTitle {
  font-weight: bold;
  font-size: 15px;
  padding: 10px;
  text-align: center;
  background-color: #D8D8D8;
  width: 100%; 
  width: 100vw;
} 

.screengrab{
  text-align: center;
  background-color: #F5F5F5;
  width: 100%; //fallback
  width: 100vw;
}  
.screengrab-output {
  text-align: center;
  background-color: #F5F5F5;
  width: 40%; //fallback
  width: 40vw;
  max-width: 800px;
}  
table {
  background: white;
  border: 1px solid grey;
  border-collapse: collapse;
}

thead th {
  padding: 5px;
  font-size: 12px;
  border: 1px solid #666;
  font-weight: bold;
  background-color: #D8D8D8;
}

td {
  text-align: center;
  font-size: 12px;
  padding: 5px;
  min-height: 150px;
  word-break: break-all;
  border: 1px solid lightgrey;
}

tr {
  min-height: 30px;
}

.tblMain tr:hover {
  background-color: #E5E5E5;
}

.loadingCell {
  text-align: center;
  background-color: #FFFFFF;
}
.perfGrey {
  background-color: #D6D6D6;
}
.perfGreen {
  text-align: center;
  background-color: #C4F7B5;
}
.perfRed {
  text-align: center;
  background-color: #F7B5B5;
}
.subheader td {
  font-size: 15px;
  padding: .5em;
  border: 1px solid lightgrey;
  font-weight: bold;
  background-color: #E5E5E5;
}

