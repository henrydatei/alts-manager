function copyToClipboard(account) {
  document.getElementById(account).type = "text";
  document.getElementById(account).focus();
  document.getElementById(account).select();
  document.execCommand("copy");
  document.getElementById(account).type = "hidden";
}
