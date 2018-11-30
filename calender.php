<!DOCTYPE html>
<?php
  require("./lib/sidUnified.php");
  require("./config/config.php");
  $SID = new SID("docalender");
  $SID -> loginCheck("./");
  // Select Note Database
  if (empty($_GET['id']) && !empty($_COOKIE['docalYuuta'])) {
      $id = $_COOKIE['docalYuuta'];
  } elseif (empty($_GET['id'])) {
      $id = 'startergatedonotedefaultregister';
  } else {
      $id = $_GET['id'];
  }
  setcookie("docalYuuta", $id, time() + 86400 * 30, '/note');
  $conn = new mysqli($config["host"], $config["duser"], $config["dpw"], $config["dname"]);  //Note Database

  // Select Profile Image
  $profileImg = $SID -> profileGet($_SESSION['pid'], ".");


?>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="./static/img/favicon/favicon-16x16.png" type="image/x-icon">
    <link rel="icon" href="./static/img/favicon/favicon-16x16.png" type="image/x-icon">
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
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./css/master.css">
  	<link rel="stylesheet" type="text/css" href="./css/style.css?v=8">
    <link rel="stylesheet" type="text/css" href="./css/bg_style.css?v=2">
  	<link rel="stylesheet" type="text/css" href="./css/cal.css">
  	<link rel="stylesheet" type="text/css" href="./css/top.css">
  	<link rel="stylesheet" type="text/css" href="./css/text.css">
  	<link rel="stylesheet" type="text/css" href="./css/Normalize.css">
    <title>DoCalender</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src='./lib/reCaptchaEnabler.js'></script>
  </head>
  <body>
    <div class="container-fluid padding-erase">
      <div class="fixed layer1 bg bgi bgImg">
        <div class="col-md-3">
          <a href="./note.php"><img src="./static/img/common/donotevec.png" alt="DoNote" class="img-rounded" id=logo alt='메인으로 가기' \></a>
        </div>
        <div class="col-md-9 text-right">
          <div class="btn-group dropdown">
            <button class="full-erase btn btn-link dropdown-toggle" type="button" id="white" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src='<?php echo $profileImg."' alt='".$_SESSION['nickname']?>' id='profile' class='img-circle' />
            </button>
            <ul class="dropdown-menu dropdown-menu-right">
              <li><a class="dropdown-item" id="black" href="./user/confirm.php"><strong><span class='glyphicon glyphicon-cog' aria-hidden='true'></span> 정보 수정</strong></a></li>
              <li><a class="dropdown-item" id="black" href="./function/logout.php"><strong><span class='glyphicon glyphicon-off' aria-hidden='true'></span> 로그아웃</strong></a></li>
              <li role="separator" class="divider"></li>
              <li><p class="dropdown-item text-center" id="black"><strong><?php echo $_SESSION['nickname']?>님, 환영합니다</strong></p></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid layer2" id="padding-generate-top">
      <hr class="displayOptionMobile" />
      <div class="col-md-12">
        <table class="doCalenderUI doCalenderTop">
          <tr class="doCalenderUI">
            <td class="doCalenderUI">일</td>
            <td class="doCalenderUI">월</td>
            <td class="doCalenderUI">화</td>
            <td class="doCalenderUI">수</td>
            <td class="doCalenderUI">목</td>
            <td class="doCalenderUI">금</td>
            <td class="doCalenderUI">토</td>
          </tr>
          <tr class="doCalenderUI">
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
          </tr>
          <tr class="doCalenderUI">
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
          </tr>
          <tr class="doCalenderUI">
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
          </tr>
          <tr class="doCalenderUI">
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
          </tr>
          <tr class="doCalenderUI">
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
          </tr>
          <tr class="doCalenderUI">
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
            <td class="doCalenderUI">d</td>
          </tr>
        </table>
        <!-- <div class="g-recaptcha" data-callback="saveEnable" data-expired-callback="saveDisable" data-sitekey="6LdYE2UUAAAAAH75nPeL2j1kYBpjaECBXs-TwYTA"></div> -->
      </div>
    </div>
    <script src="./lib/jquery-3.3.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
