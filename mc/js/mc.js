(function main () {

  document.getElementById('zSend').addEventListener("click", wrapUp);

  function wrapUp() {

    var transaction = document.implementation.createDocument ("", "", null);
    
    var zMessage = transaction.createElement("message");
    
    var zWho = transaction.createElement("who");
    zWho.textContent = document.getElementById('zWho').value;

    var zSubject = transaction.createElement("subject");
    zSubject.textContent = document.getElementById('zSubject').value;

    var zBody = transaction.createElement("body");
    zBody.textContent = document.getElementById('zBody').value;

    var xmlhttp = new XMLHttpRequest();
    
    zMessage.appendChild(zWho)
    zMessage.appendChild(zSubject);
    zMessage.appendChild(zBody)
   
    transaction.appendChild(zMessage);

    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState === 4) {
        var zstatus = document.getElementById('zStatus');
        zstatus.textContent = xmlhttp.responseText;
      }
    }
    xmlhttp.open("POST","mcTransaction.php",true);
    xmlhttp.send(transaction);
  }
})();
