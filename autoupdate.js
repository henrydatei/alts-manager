loadTime = Math.round(new Date().getTime()/1000);

setInterval(function() {
    // console.log("Check for new update");
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Typical action to be performed when the document is ready:
        // response = xhttp.responseText;
        // console.log(response);

        if (xhttp.responseText > loadTime) {
          console.log("do update");
          location.reload();
        }
      }
    };
    xhttp.open("GET", "getLastUpdate.php", true);
    xhttp.send();
}, 1000); // 1000 milsec
