(function main (arg) {
  
  getData(arg).then(renderData(response));
  
   function getData () {
   	 return new Promise(function (proceed) {
   	 var xhr = new XMLHttpRequest();
   	 xhr.open("POST","baSQL.php",true);
   	 xhr.send(document.getElementById("zSearch").textContent);
   	 xhr.onload(function () { if (xhr.status === 200) proceed(xhr.responseText);});
   	 //xhr.onreadystatechange(function () {renderData(xhr.responseText); });	
   }
   );
   }
   function renderData (serverData) {
   	 var collection = JSON.parse(serverData);
   	 var table = document.createElement("TABLE");
   	 collection.forEach(function (row) {
   	   var tr = document.createElement("TR");
   	   for (var column in row) {
   	     var td = document.createElement("TD");
   	     td.textContent = column;
   	     tr.appendChild(td);   	      
   	 	}
   	 	table.appendChild(tr);
   	 }); 	
   	 return table;
   }    
  return;
  })("%");
