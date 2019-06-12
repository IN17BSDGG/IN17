<?php
require_once("../system/config.inc.php");
require_once("../system/functions.inc.php");

//POST VAR = $_POST["login_email"] // $_POST["login_password"]
if(isset($_POST["login_button"])) {
  if(!empty($_POST["login_email"]) AND !empty($_POST["login_password"])) { 
    $login_email = $_POST["login_email"];
    $login_password = hash('sha512',$_POST["login_password"]);

    $sql = "SELECT * FROM BENUTZER WHERE EMAIL = '$login_email' AND PASSWORD = '$login_password'";
    $sth = $db->prepare($sql);
    $sth->execute();
    $array = $sth->fetchAll();
    print_r($array);
    if($sth) {
      $_SESSION["UID"] = $array["0"]["UID"];
      redirect("../dashboard");
    } else {
      echo '
      <div style="margin: 0px; border-radius: 0px" class="alert alert-danger" role="alert">
        <center><strong>LOGIN FEHLER:</strong> Es wurde kein Nutzerkonto mit den angegebenen Daten gefunden!</center>
      </div>';
    }
  } else {
    echo '
      <div style="margin: 0px; border-radius: 0px" class="alert alert-danger" role="alert">
        <center><strong>LOGIN FEHLER:</strong> Es wurde keine E-Mail Adresse oder Passwort angegeben!</center>
      </div>';
  }
}
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <title>Einloggen</title>
    <style>#loader{transition:all .3s ease-in-out;opacity:1;visibility:visible;position:fixed;height:100vh;width:100%;background:#fff;z-index:90000}#loader.fadeOut{opacity:0;visibility:hidden}.spinner{width:40px;height:40px;position:absolute;top:calc(50% - 20px);left:calc(50% - 20px);background-color:#333;border-radius:100%;-webkit-animation:sk-scaleout 1s infinite ease-in-out;animation:sk-scaleout 1s infinite ease-in-out}@-webkit-keyframes sk-scaleout{0%{-webkit-transform:scale(0)}100%{-webkit-transform:scale(1);opacity:0}}@keyframes sk-scaleout{0%{-webkit-transform:scale(0);transform:scale(0)}100%{-webkit-transform:scale(1);transform:scale(1);opacity:0}}</style>
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body class="app">
    <div id="loader">
      <div class="spinner"></div>
    </div>
    <script>window.addEventListener('load', () => {
      const loader = document.getElementById('loader');
      setTimeout(() => {
        loader.classList.add('fadeOut');
      }, 300);
      });
    </script>
    <div class="peers ai-s fxw-nw h-100vh">
      <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" style="background-image:url(https://picsum.photos/1920/1080/?random)">
      </div>
      <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style="min-width:320px">
        <h4 class="fw-300 c-grey-900 mB-40"><?php echo $config["site_name"]; ?> - Login</h4>
        <form method="POST">
          <div class="form-group">
            <label class="text-normal text-dark">E-Mail Adresse</label>
            <input name="login_email" type="email" class="form-control" placeholder="max.mustermann@semper-coding.de">
          </div>
          <div class="form-group">
            <label class="text-normal text-dark">Passwort</label>
            <input name="login_password" type="password" class="form-control" placeholder="Passwort">
          </div>
          <div class="form-group">
            <div class="peers ai-c jc-sb fxw-nw">
              <div class="peer">
                <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                  <input type="checkbox" id="inputCall1" name="inputCheckboxesCall" class="peer">
                  <label for="inputCall1" class="peers peer-greed js-sb ai-c">
                    <span class="peer peer-greed"> Eingeloggt bleiben</span>
                  </label>
                </div>
              </div>
              <div class="peer"><button name="login_button" type="submit" class="btn btn-primary">Login</button></div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <script type="text/javascript" src="../js/vendor.js"></script>
    <script type="text/javascript" src="../js/bundle.js"></script>
  </body>
</html>

