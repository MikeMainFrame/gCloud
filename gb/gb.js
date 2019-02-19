(function main (what) {
 
	handleData(what);

  async function handleData (what) {
    var temp = await xhrServer(what);
    var objs = JSON.parse(temp);
    // loop thru template text slots - need to mature
    var target = this.document.body.getElementsByTagName("text");
    objs.forEach(function(row) {  
      target[1].textContent = row.name;      
      target[3].textContent = row.timeCreated;  
      target[5].textContent = row.contentType;  
      target[7].textContent = row.size;        
      target[9].textContent = row.mediaLink;  
      var temp  = document.getElementById('ztemp');
      var div = document.createElement("DIV");
      div.innerHTML = temp.outerHTML;
      div.setAttribute('class', 'c48');
      document.body.appendChild(div);
    })
  }

  function xhrServer(what) {
		return new Promise(function(serverData, reject) {
			var xhr = new XMLHttpRequest();
			xhr.open("GET", "swListBucketObjects.php" + what, true);
			xhr.onload = function() {if (xhr.readyState === 4) serverData(xhr.responseText);};
			xhr.onerror = function() {reject(xhr.statusText)};      
    	xhr.send();
		});
	}
}
)(window.location.search);
