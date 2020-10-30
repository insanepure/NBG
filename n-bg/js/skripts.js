function checkbox(name,checker) {        
var box = checker.form.elements[name];
if(checker.checked == true)
{
  for (i = 0; i < box.length; i++) {
  box[i].checked = true;}
}
else
{
  for (i = 0; i < box.length; i++) {
  box[i].checked = false;}
}
}

function showtext(thetext){
if (!document.getElementById)
return
document.getElementById("textdiv").innerHTML=thetext
}

function hidetext(){
document.getElementById("textdiv").innerHTML=""
}

var skillPoints = null;

function updown(what,obj) {
 if (what != "" && what != "undefined") {
  if (obj != "" && obj != "undefined") {  
    o = document.getElementById(obj);   
    g = document.getElementById("zahl");   
    if(skillPoints == null)
      skillPoints = parseInt(g.innerText, 10);
    if (o.value != "") {
     if (what == "incr") {
      if(o.value != 20&&g.innerText != 0){
      o.value ++;        
      skillPoints--;
      g.innerText = skillPoints;
      }
     }
     else if (what == "decr") {   
      if(o.value != 10&&g.innerText != 30){
      o.value --;     
      skillPoints++; 
      g.innerText = skillPoints;
      }
     }
   }
  }
 }
}
function updown2(what,obj) {
 if (what != "" && what != "undefined") {
  if (obj != "" && obj != "undefined") {  
    o = document.getElementById(obj);   
    g = document.getElementById("zahl");   
    f = document.getElementById("zahl2");  
    if(skillPoints == null)
      skillPoints = parseInt(g.innerText, 10);
    if (o.value != "") {
     if (what == "incr") {
      if(o.value != 999&&g.innerText != 0){
      o.value ++;       
      skillPoints--;
      g.innerText = skillPoints;
      }
     }
     else if (what == "decr") {   
      if(o.value != 0&&g.innerText != f.innerText){
      o.value --;     
      skillPoints++; 
      g.innerText = skillPoints;
      }
     }
   }
  }
 }
}

//Sonstiges
function show(divid) {
if(divid == "leicht"){         
  document.getElementById("reise").style.backgroundImage = 'url(bilder/design/reisel.jpg)';   
  }
if(divid == "normal"){         
  document.getElementById("reise").style.backgroundImage = 'url(bilder/design/reisen.jpg)';   
  }      
if(divid == "hart"){         
  document.getElementById("reise").style.backgroundImage = 'url(bilder/design/reiseh.jpg)';   
  }
}
function hide() {
  document.getElementById("reise").style.backgroundImage = 'url(bilder/design/reise.jpg)'; 
}        

function Chatpopup(url)
{
var breite=830;
var hoehe=490;     
var positionX=((screen.availWidth / 2) - breite / 2);
var positionY=((screen.availHeight / 2) - hoehe / 2);
pop=window.open(url,'_blank','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,fullscreen=no,locationbar=no,width='+breite+',height='+hoehe+',top='+positionY+',left='+positionX);
} 

