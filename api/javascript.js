// Link mit richtiger URL ersetzen
var link = document.getElementById('link').innerText;
var newlink = "http://" + window.location.hostname + "/alts" + link;
document.getElementById('link').innerText = newlink;

// Anpassen der Höhe von result an config
var hoehe = getComputedStyle(document.getElementsByClassName('config')[0]).height;
var ohnepx = parseFloat(hoehe.substring(0,hoehe.length-2));
var resultHoehe = ohnepx - 76;
var resultHoehemitpx = resultHoehe + "px";
document.getElementsByClassName('result')[0].style.height = resultHoehemitpx;
