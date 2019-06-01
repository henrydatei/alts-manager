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
