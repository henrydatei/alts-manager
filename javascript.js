function buildParty(account) {
  partymode = document.getElementById('partymode').selectedOptions[0].text;
  if (partymode.localeCompare("kein Party Prefix") == 0) {
    // kein Party-Prefix gewünscht
    partycommand = account;
  } else {
    partycommand = partymode + " " + account;
  }
  document.getElementById(account).value = partycommand;
  document.getElementById(account).type = "text";
  document.getElementById(account).focus();
  document.getElementById(account).select();
  document.execCommand("copy");
  document.getElementById(account).type = "hidden";

  // Zurücksetzen
  document.getElementById(account).value = account;
}

function copyToClipboard(account) {
  document.getElementById(account).type = "text";
  document.getElementById(account).focus();
  document.getElementById(account).select();
  document.execCommand("copy");
  document.getElementById(account).type = "hidden";
}

function showSkin(account) {
  var br = document.createElement('br');
  var iframe = document.createElement('iframe');

  br.id = account + "Br";
  iframe.className = "skin";
  iframe.src = "https://minotar.net/body/" + account + "/50.png";
  iframe.id = account + "Skin";

  document.getElementById(account).append(br);
  document.getElementById(account).append(br);
  document.getElementById(account).append(iframe);
}

function unshowSkin(account) {
  var iframe = document.getElementById(account + "Skin");
  iframe.parentNode.removeChild(iframe);
  var br = document.getElementById(account + "Br");
  br.parentNode.removeChild(br);
}

function showAllSkins() {
  var liste = document.getElementById('accountList').value.split(" ");
  for (var i = 0; i < liste.length; i++) {
    showSkin(liste[i]);
  }
  document.getElementById('hideSkins').style.display = "block";
  document.getElementById('showSkins').style.display = "none";
}

function unshowAllSkins() {
  var liste = document.getElementById('accountList').value.split(" ");
  for (var i = 0; i < liste.length; i++) {
    unshowSkin(liste[i]);
  }
  document.getElementById('hideSkins').style.display = "none";
  document.getElementById('showSkins').style.display = "block";
}

function showUserPass() {
  var liste = document.getElementsByClassName('userpass');
  for (var i = 0; i < liste.length; i++) {
    liste[i].style.display = 'block';
  }
  document.getElementById('hideLogin').style.display = "block";
  document.getElementById('showLogin').style.display = "none";
}

function hideUserPass() {
  var liste = document.getElementsByClassName('userpass');
  for (var i = 0; i < liste.length; i++) {
    liste[i].style.display = 'none';
  }
  document.getElementById('hideLogin').style.display = "none";
  document.getElementById('showLogin').style.display = "block";
}
