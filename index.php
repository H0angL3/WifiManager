<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="jquery-3.3.1.min.js"></script>
    <title>UNIFI WIFI CONTROLLER MANAGER</title>
  </head>
  <body>
    <p id = "clock"></p>
    <a href="#" onclick="return getOutput();"> test </a>
    <div id="output">waiting for action</div>
    </body>
</html>




<script type="text/javascript">
  function coundown(){
    var countdown = 30 * 60 * 1000;
    var timerId = setInterval(function(){
    countdown -= 1000;
    var min = Math.floor(countdown / (60 * 1000));
    //var sec = Math.floor(countdown - (min * 60 * 1000));  // wrong
    var sec = Math.floor((countdown - (min * 60 * 1000)) / 1000);  //correct
    document.getElementById("clock").innerHTML = min + "m " + sec + "s ";
    if (countdown <= 0) {
       alert("30 min!");
       clearInterval(timerId);
       //doSomething();
    } else {
       $("#countTime").html(min + " : " + sec);
    }

    }, 1000); //1000ms. = 1sec.
  }
  // handles the click event for link 1, sends the query
  function getOutput() {
    getRequest(
        'unifi.php', // URL for the PHP file
         drawOutput,  // handle successful request
         drawError    // handle error
    );
    return false;
  }
  // handles drawing an error message
  function drawError() {
      var container = document.getElementById('output');
      container.innerHTML = 'Bummer: there was an error!';
  }
  // handles the response, adds the html
  function drawOutput(responseText) {
      var container = document.getElementById('output');
      container.innerHTML = responseText;
  }
  // helper function for cross-browser request object
  function getRequest(url, success, error) {
      var req = false;
      try{
          // most browsers
          req = new XMLHttpRequest();
      } catch (e){
          // IE
          try{
              req = new ActiveXObject("Msxml2.XMLHTTP");
          } catch(e) {
              // try an older version
              try{
                  req = new ActiveXObject("Microsoft.XMLHTTP");
              } catch(e) {
                  return false;
              }
          }
      }
      if (!req) return false;
      if (typeof success != 'function') success = function () {};
      if (typeof error!= 'function') error = function () {};
      req.onreadystatechange = function(){
          if(req.readyState == 4) {
              return req.status === 200 ?
                  success(req.responseText) : error(req.status);
          }
      }
      req.open("GET", url, true);
      req.send(null);
      return req;
  }
</script>
