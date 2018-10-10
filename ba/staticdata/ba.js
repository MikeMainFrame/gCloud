/* 
* Made by M.Rasch -2018 Q4
*/
  (function main() {
   // default search criteria is %
   var zSearch = document.getElementById("zSearch"); 
   var zOutput = document.getElementById("zOutput");
   document.getElementById("zButton").addEventListener("click", getData);
   

  function getData () {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.overrideMimeType("application/json");
    xmlhttp.onreadystatechange=function() {zOutput.textContent = zOutput.textContent + xmlhttp.responseText; };    
    xmlhttp.open("GET","baSQL.php" + "?search=" + zSearch.textContent);
    xmlhttp.send();
  } 
}
)();
