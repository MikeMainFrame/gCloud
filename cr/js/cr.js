
  var svgdoc = document.getElementById('zcanvas');
  var products = [], prices = [], values = [], zfactor = 1;
  var now = new Date();
  var toDay = parseInt((now.getFullYear() * 1.0E4) + ((now.getMonth() + 1) * 1.0E2) + now.getDate(), 10);

	xhrServer()
		.then(function(responseText) {
      preInitialSetup(JSON.parse(responseText));
		})
		.catch(console.log(status));

function xhrServer() {
  return new Promise(function(serverData, reject) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "https://storage.googleapis.com/gcloud19631205.appspot.com/crMenu.json");
    xhr.onload = function() {if (xhr.readyState === 4) serverData(xhr.responseText);};
    xhr.onerror = function() {reject(xhr.statusText);};
    xhr.send();
  });
}
/***
*  build visible buttons - predefined tag+price
*/
function preInitialSetup(choices) {

  svgdoc.addEventListener('click', handleClick, false);

  var x = -250, y = 200;
  var hook = document.getElementById('buttons');
  var g = document.createElementNS("http://www.w3.org/2000/svg", 'g');
      g.setAttribute("fill", '#fff');
      g.setAttribute("font-size", 36);
      g.setAttribute("text-anchor", 'middle');


  for (ix = 0; ix < choices.length; ix++) {

    if (ix < 24) {
      if (x === 1100) {
        y = y + 300;
        x = 200;
      } else x = x + 450;
    } else if (ix < 27) {
      x = x + 450;
    } else if (ix === 27) {
      y = 200;
      x = 2900;
    } else if (x === 3800) {
      y = y + 300;
      x = 2900;
    } else x = x + 450;

    var rect = document.createElementNS("http://www.w3.org/2000/svg", 'rect');
    rect.setAttribute("x", x);
    rect.setAttribute("y", y);
    rect.setAttribute("width", 400);
    rect.setAttribute("height", 250);
    rect.setAttribute("rx", 50);
    rect.setAttribute("fill", (function(ix) {  if (ix < 25) return '#000060';  if (ix < 35) return '#0000a0';  return '#000080';})(ix) );
    rect.setAttribute("zproduct", choices[ix].name);
    rect.setAttribute("zprice", choices[ix].price);
    rect.setAttribute("zindex", ix + 1);

    g.appendChild(rect);

    var text = document.createElementNS("http://www.w3.org/2000/svg", 'text');
    text.setAttribute("x", x + 30);
    text.setAttribute("y", y + 50);
    text.setAttribute("text-anchor", 'start');
    text.setAttribute("fill", '#fff');
    text.textContent = choices[ix].name;

    g.appendChild(text);

    var text = document.createElementNS("http://www.w3.org/2000/svg", 'text');
    text.setAttribute("x", x + 200);
    text.setAttribute("y", y + 144);
    text.setAttribute("font-size", 72);
    text.setAttribute("id", "c" + parseInt(ix + 1));
    text.setAttribute("text-anchor", 'middle');
    text.textContent = "";

    g.appendChild(text);

    var text = document.createElementNS("http://www.w3.org/2000/svg", 'text');
    text.setAttribute("x", x + 370);
    text.setAttribute("y", y + 220);
    text.setAttribute("fill", '#fff');
    text.setAttribute("text-anchor", 'end');
    text.textContent = ix + 1;
    values[ix + 1] = 0;
    prices[ix + 1] = choices[ix].price;

    g.appendChild(text);
  }
  hook.appendChild(g);

  document.getElementById('zstatus').textContent = now.toString();
}
/***
*  button pressed/touched - using attribute presence,
*  different part of canvas can be identified using only one area
*/
function handleClick(evt) {

  var scope = evt.target;

  if (scope.getAttribute("zprice")) {
    index = parseInt(scope.getAttribute("zindex"));
    products[index] = scope.getAttribute("zproduct");
    values[index]=values[index]+zfactor;
    scope.setAttribute("fill", '#00f');
    var count = document.getElementById("c" + index);
    count.textContent = values[index];
    rebuildList();
  } else if (scope.getAttribute("zfactor")) toogleFactor(scope);
  else if (scope.getAttribute("zfinalise")) wrapUp();
  else if (scope.getAttribute("zdateselect")) subDates();
  else if (scope.getAttribute("zdate")) {
    document.getElementById('zstatus').textContent = scope.getAttribute("zdate");
    var execute = document.getElementById('dates');
    if (execute) svgdoc.removeChild(execute);
  };

}
/***
*  add/subtract mode
*/
function toogleFactor(toogle) {
  zfactor = toogle.getAttribute("zfactor") * -1;  // toogle

  if (zfactor ===  -1) {
    toogle.setAttribute("stroke", '#f00');
    document.getElementById('addsub').textContent = "sub";
  } else {
    toogle.setAttribute("stroke", '#00b');
    document.getElementById('addsub').textContent = "add";
  }
  toogle.setAttribute("zfactor", zfactor);
}
/***
*  save at server - transaction wise
*/
function wrapUp() {

  var transaction = document.implementation.createDocument ("", "", null);

  var zDay = transaction.createElement("dayquantum");
  zDay.setAttribute("date",document.getElementById('zstatus').textContent);

  for (ix = 0; ix < products.length; ix++) {
    if (parseInt(values[ix]) > 0) {
      var zSlot = transaction.createElement("item");
      zSlot.setAttribute("value",values[ix]);
      zSlot.setAttribute("product",products[ix]);
      zDay.appendChild(zSlot);
    }
  }
  transaction.appendChild(zDay);

  var xmlhttp = new XMLHttpRequest();

  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var zstatus = document.getElementById('zstatus');
      zstatus.textContent = xmlhttp.responseText;
      products = [];
      rebuildList();
    }
  } ;
  xmlhttp.open("POST","crCount.php",true);
  xmlhttp.send(transaction);
}
/***
*  show new list
*/
function rebuildList() {
  var execute = document.getElementById('todie');
  if (execute) svgdoc.removeChild(execute);

  var g = document.createElementNS("http://www.w3.org/2000/svg", 'g');
      g.setAttribute("id", 'todie');
      g.setAttribute("fill", '#fff');
      g.setAttribute("font-size", 48);

  var y=300; zSum = 0;

  for (ix = 0; ix < products.length; ix++) {
    var jx = ix + 1;
    if (parseInt(values[jx]) > 0) {
      var text = document.createElementNS("http://www.w3.org/2000/svg", 'text');
      text.setAttribute("text-anchor", 'end');
      text.setAttribute("x", 1650);
      text.setAttribute("y", y);
      text.textContent = values[jx];

      g.appendChild(text);

      var text = document.createElementNS("http://www.w3.org/2000/svg", 'text');
      text.setAttribute("text-anchor", 'start');
      text.setAttribute("x", 1700);
      text.setAttribute("y", y);
      text.textContent = products[jx] + " (" + jx + ")";

      g.appendChild(text);

      var text = document.createElementNS("http://www.w3.org/2000/svg", 'text');
      text.setAttribute("text-anchor", 'end');
      text.setAttribute("x", 2800);
      text.setAttribute("y", y);
      slam = new Number(parseInt(values[jx] * prices[jx]));
      text.textContent = slam.toFixed(2);

      g.appendChild(text);
      zSum = zSum + slam;
      y=y+64;
    }
  }

  var text = document.createElementNS("http://www.w3.org/2000/svg", 'text');
  text.setAttribute("text-anchor", 'end');
  text.setAttribute("font-weight", 900);
  text.setAttribute("font-size", 96);
  text.setAttribute("x", 2800);
  text.setAttribute("y", 1800);
  slam = new Number(zSum);
  text.textContent = slam.toFixed(2);

  g.appendChild(text);
  svgdoc.appendChild(g);
}
function subDates() {

   var more = true, zDate = new Date(), ix = 0;

   var x = 0, y = 0;

   var g = document.createElementNS("http://www.w3.org/2000/svg", 'g');
       g.setAttribute("id", 'dates');
       g.setAttribute("fill", '#fff');
       g.setAttribute("font-size", 24);
       g.setAttribute("text-anchor", 'middle');


   var rect = document.createElementNS("http://www.w3.org/2000/svg", 'rect');

   rect.setAttribute("x", 100);
   rect.setAttribute("y", 150);
   rect.setAttribute("width", 4200);
   rect.setAttribute("height", 2550);
   rect.setAttribute("rx", 10);
   rect.setAttribute("fill", 'rgba(0,0,64,0.8)');

   g.appendChild(rect);

   while (more) {
     ix++;

     zDate = new Date(parseInt(zDate.getTime())-86400000);
     x = (zDate.getMonth() * 305) + 106;     y = (zDate.getDate() * 80) + 126;
     var thisDate = parseInt((zDate.getFullYear() * 10000) + ((zDate.getMonth() + 1) * 100) + zDate.getDate());

     var rect = document.createElementNS("http://www.w3.org/2000/svg", 'rect');
     rect.setAttribute("x", x);
     rect.setAttribute("y", y);
     rect.setAttribute("width", 300);
     rect.setAttribute("height", 75);
     rect.setAttribute("rx", 15);
     rect.setAttribute("fill", 'rgba(0,0,255,0.5)');
     rect.setAttribute("zdate", thisDate);

     var text = document.createElementNS("http://www.w3.org/2000/svg", 'text');
     text.setAttribute("x", x + 150);
     text.setAttribute("y", y + 47);
     text.setAttribute("fill", '#fff');
     text.textContent = formatT(thisDate.toString());

     g.appendChild(text);
     g.appendChild(rect);

     if (ix > 59) more = false;
   }
   svgdoc.appendChild(g);
}
function formatT(base) {
  var m = "   JANFEBMARAPRMAJJUNJULAUGSEPOCTNOVDEC";
  var i = parseInt(base.substr(4,2) * 3);
  return base.substr(6,2) + m.substr(i, 3) + base.substr(0,4);
}
