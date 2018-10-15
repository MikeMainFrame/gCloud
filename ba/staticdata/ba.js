/* 
* Made by M.Rasch -2018 Q4
*/
  (function main() {
  	
    document.getElementById("zButton").addEventListener("click", getData);   

    function getData () {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.overrideMimeType("application/json");
      xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState === 4 
        && xmlhttp.status === 200) {
        
          document.getElementById("zOutput").textContent = "";
          renderTable(xmlhttp.responseText);
        }
      };    
      xmlhttp.open("GET","baSQL.php" + "?search=" + document.getElementById("zSearch").textContent);
      xmlhttp.send();
    }   
    function renderTable (JSONstr) {
      var motherObject = JSON.parse(JSONstr);        
   	  var table = document.createElement('TABLE');   	   	
  	  motherObject.forEach(function(row) {
  	    var tr = document.createElement('TR');  	    
  	    for (var data in row) {
  	      var td = document.createElement('TD');
  	      td.textContent = row[data];
  	      tr.appendChild(td);
        }
  	    table.appendChild(tr);
  	  });  	  
  	  document.getElementById("zOutput").innerHTML = table.outerHTML;
    }
  }
)();
