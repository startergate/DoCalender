<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="57x57" href="./static/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="./static/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./static/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="./static/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./static/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="./static/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="./static/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="./static/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="./static/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="./static/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./static/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="./static/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./static/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="./manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./static/img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
    <title>DoCalender</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/style2.css?ver=2018-07-13_2">
  	<link rel="stylesheet" type="text/css" href="./css/bg_style.css?ver=1.5">
  	<link rel="stylesheet" type="text/css" href="./css/master.css">
  	<link rel="stylesheet" type="text/css" href="./css/Normalize.css">
    <style media="screen">
      .indexTitle{
        font-size: 6.2vw;
      }
      .imgLocation{
        position: fixed;
        margin:auto;
        font-size: 10px;
        background-color:rgba(255,255,255,0.5);
        width:100px;
        padding: 5px;
        top: 10px;
        left: 10px;
      }
    </style>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src='./lib/reCaptchaEnabler.js'></script>
  </head>
  <body class='bg bge bgImg'>
    <p class="imgLocation">Image by Unsplash</p>
    <div id="index" class="cover full-window">
      <div class="col-sm-12 larger">
        <p class='text-center'>
          <strong class="indexTitle domi">DoCalender</strong>
        </p>
        <div class="control">
          <p class='text-center'>
            <?php
              require './lib/sidUnified.php';
              session_start();
              if (!empty($_COOKIE['sidAutorizeRikka'])) {
                  $SID = new SID('docalender');
                  $SID->authCheck();
              }
              if (!empty($_SESSION['pid'])) {
                  echo "<div id='white'>".$_SESSION['nickname'].'님, 돌아오셨군요!</div>';
                  echo "<script type=\"text/javascript\">setTimeout(\"location.href = './calender.php'\", 5000);</script>";
                  echo "<div style='color:white'>곧 리다이렉트됩니다.</div>";
              } else {
                  echo "<button class='btn btn-light btn-lg' id='loginBtn1'>SID로 로그인</button>";
              }
            ?>
          </p>
        </div>
      </div>
    </div>
    <div id="login_form" class="covra covraLogin text-center" style="display:none">
      <div class="center">
        <div id="login">로그인 | DoCalender</div>
        <div id="lotext" class="text-center">
          <br />
          <form class="center form" action="./function/process_log.php" method="post">
            <input type="text" class="form-control form"name="id" placeholder="아이디" required>
            <input type="password" class="form-control form"name="pw" placeholder="비밀번호" required>
            <div class="checkbox">
              <input type="checkbox" name="auto"> 자동 로그인<br>자동 로그인 기능은 쿠키를 사용합니다.
            </div>
            <div class="g-recaptcha" data-callback="saveEnable" data-expired-callback="saveDisable" data-sitekey="6LdYE2UUAAAAAH75nPeL2j1kYBpjaECBXs-TwYTA"></div>
            <br />
            <input type="submit" name="confirm_login" disabled="disabled" id="saveBtnTop" class="btn btn-light" value="로그인">
            <button class='btn btn-light' id="registerBtn">회원가입</button>
          </form>
        </div>
      </div>
    </div>
    <div id="register" class="covra covraRegister text-center" style="display:none">
      <div align="center">
        <div id="login">회원가입 | DoCalender</div>
        <div id="lotext">
          <br />
          <form class="center form" action="./function/process_reg.php" method="post">
            <input type="text" class="form-control form" name="id" placeholder="아이디" required>
            <input type="password" class="form-control form" name="pw" placeholder="비밀번호" required>
            <input type="password" class="form-control form" name="pwr" placeholder="비밀번호 확인" required>
            <input type="text" class="form-control form" name="nickname" placeholder="닉네임">
            <br />
            <div class="g-recaptcha" data-callback="saveEnable" data-expired-callback="saveDisable" data-sitekey="6LdYE2UUAAAAAH75nPeL2j1kYBpjaECBXs-TwYTA"></div>
            <br />
            <input type="submit" name="confirm_register" disabled="disabled" id="saveBtnBottom" class="btn btn-light" value="회원가입">
            <button class='btn btn-light' id="loginBtn2">로그인</button>
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      var logTarget1 = document.getElementById('loginBtn1');
      logTarget1.addEventListener('click', function(event) {
        $("#login_form").css('display', 'block');
        $("#register").css('display', 'none');
        $("#index").css('display', 'none');
      });
      var logTarget2 = document.getElementById('loginBtn2');
      logTarget2.addEventListener('click', function(event) {
        event.preventDefault()
        $("#login_form").css('display', 'block');
        $("#register").css('display', 'none');
        $("#index").css('display', 'none');
      });
      var regTarget = document.getElementById('registerBtn');
      regTarget.addEventListener('click', function(event) {
        event.preventDefault()
        $("#register").css('display', 'block');
        $("#index").css('display', 'none');
        $("#login_form").css('display', 'none');
      });
    </script>
		<script src="./lib/jquery-3.3.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
