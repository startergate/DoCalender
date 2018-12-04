<!DOCTYPE html>
<?php
  require("./lib/sidUnified.php");
  require("./config/config.php");
  $SID = new SID("docalender");
  $SID -> loginCheck("./");

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
    <script type="text/javascript">
      var init = function() {
        var t = new Date();
        document.querySelector('.doCalenderYear').value = t.getFullYear();
        document.getElementsByClassName("doCalenderMonth")[0].options[t.getMonth()].selected = true;
        document.querySelector('.doCalenderYear').addEventListener("change", monthChange);
        document.getElementsByClassName("doCalenderMonth")[0].addEventListener("change", monthChange);
        monthChange();
      }
      var getMaxDate = function(month) {
        switch (month) {
          case 1:
          case 3:
          case 5:
          case 7:
          case 8:
          case 10:
          case 12:
            return 31;
            break;
          case 2:
            return 28;
            break;
          default:
            return 30;
        }
      }
      var monthChange = function(e) {
        if (Number(document.querySelector('.doCalenderYear').value) < 1900) {
          alert("1900년 이전의 날짜는 사용이 불가합니다.");
          return;
        }
        document.title = document.querySelector('.doCalenderYear').value + "년 " + (Number(document.querySelector('.doCalenderMonth').value) + 1) + "월의 DoCalender";
        console.log("working");
        doCalenderSet();
      }
      var doCalenderSet = function() {
        var d = new Date(Number(document.querySelector('.doCalenderYear').value), Number(document.getElementsByClassName("doCalenderMonth")[0].value), 1);
        var day = d.getDay()+1;
        var row = 1;
        for (var i = 1; i < day; i++) {
          document.getElementById('w1-'+day).setAttribute('day', 0);
          document.getElementById('w1-'+i).onclick = "";
          document.getElementById('w1-'+i).innerHTML = "";
          document.getElementById('w1-'+i).style.backgroundColor = "rgb(224, 224, 224)";
        }
        for (var i = 0; i < getMaxDate(d.getMonth()+1); i++) {
          if (day > 7) {
            day = 1;
            row++;
          }
          document.getElementById('w'+row+'-'+day).onclick = function() {
            doCalenderTodoPopup(d.getFullYear(), d.getMonth()+1, this.getAttribute('day'));
          }
          document.getElementById('w'+row+'-'+day).setAttribute('day', i+1);
          document.getElementById('w'+row+'-'+day).innerHTML = (i+1)+'<hr class="doCalenderHR">';
          document.getElementById('w'+row+'-'+day).style.backgroundColor = "white";
          day++;
        }
        for (var i = (row-1)*7+day; i <= 42; i++) {
          if (day > 7) {
            day = 1;
            row++;
          }
          document.getElementById('w'+row+'-'+day).setAttribute('day', 0);
          document.getElementById('w'+row+'-'+day).onclick = "";
          document.getElementById('w'+row+'-'+day).innerHTML = "";
          document.getElementById('w'+row+'-'+day).style.backgroundColor = "rgb(224, 224, 224)";
          day++;
        }
      }
      var doCalenderTodoPopup = function(year, month, day) {
        var datename = year+"-"+month+"-"+day;
        var notetext = [];

        $.ajax({
          url: './dbaccess/getter.php',
          type: 'POST',
          dataType: 'json',
          async: true,
          data: {pid: '<?=$_SESSION['pid']?>',date: datename},
          success: function(data) {
            if (!data.error) {
              var noteid;
              $.ajax({
                url: 'http://donote.co/api/getNote.php',
                type: 'POST',
                dataType: 'json',
                data: {pid: '<?=$_SESSION['pid']?>', id: noteid},
                success: function(data) {
                  notetext = data.text.split('\r\n');
                }
              })
              .done(function() {
                console.log("success");
              })
              .fail(function() {
                console.log("error");
              })
              .always(function() {
                console.log("complete");
              });
            }
          }
        })
        .done(function() {
          console.log("success");
        })
        .fail(function() {
          console.log("error");
        })
        .always(function() {
          console.log("complete");
        });
        var popuplistNumber = notetext.length;
        var popuplist = "";
        for (var i = 0; i < notetext.length; i++) {
          var checked = "";
          if (notetext[i].split(' | ')[0] == 완료) {
            checked = " checked";
          }
          popuplist += "<li class='doCalenderPopupList'><input type='checkbox' class='doCalenderPopupCheckbox' style='margin-right: 10px'"+checked+"><input type='text' name='' class='doCalenderPopupInput' value='"+notetext[i].split(' | ')[1]+"' placeholder='할 일을 입력하세요.'></li>"
        }
        var output = "<div style='width: 100%'><p class='doCalenderPopupHead'>"+month+"월 "+day+"일의 할 일"+"<span class='doCalenderPopupHead glyphicon glyphicon-remove' aria-hidden='true' onclick='doCalenderTodoPopupDestroy()' style='position: absolute; right: 33px; top: 23px'></span></div><span id='count' style='display:none'>0</span><form class='popupForm' action='' method='post'><div class='popupFormData'></div><li class='doCalenderPopupList'><span class='glyphicon glyphicon-plus' aria-hidden='true' onclick='doCalenderPopupAddLine()'></span>  할 일 추가</li></form><button class='doCalenderPopupBtn' id='doCalenderPopupSaveBtn' onclick='doCalenderPopupSave('"+datename+"')'><span class='glyphicon glyphicon-ok'></span> | 저장</button>";
        document.getElementsByClassName("doCalenderTODOEditPopup")[0].innerHTML = output;
        document.getElementsByClassName("doCalenderTODOEditPopup")[0].style.display = "block";
        document.getElementsByClassName("fullLayer")[0].style.display = "block";
      }
      var doCalenderPopupAddLine = function() {
        if (Number(document.getElementById('count').innerHTML) >= 14) {
          return;
        }
        document.getElementById('count').innerHTML = Number(document.getElementById('count').innerHTML) + 1;
        document.getElementsByClassName('popupFormData')[0].innerHTML += "<li class='doCalenderPopupList'><input type='checkbox' class='doCalenderPopupCheckbox' style='margin-right: 10px' onchange='doCalenderPopupCheckboxTempSaver("+(Number(document.getElementById('count').innerHTML) - 1)+")'><input type='text' name='' class='doCalenderPopupInput' value='' placeholder='할 일을 입력하세요.' onchange='doCalenderPopupInputTempSaver("+(Number(document.getElementById('count').innerHTML) - 1)+")'></li>"
        for (var i = 0; i < document.getElementsByClassName("doCalenderPopupInput").length; i++) {
          if (document.getElementsByClassName("doCalenderPopupInput")[i].getAttribute("string") == undefined) {
            continue;
          }
          document.getElementsByClassName("doCalenderPopupInput")[i].value = document.getElementsByClassName("doCalenderPopupInput")[i].getAttribute("string");
        }
      }
      var doCalenderTodoPopupDestroy = function() {
        document.getElementsByClassName("doCalenderTODOEditPopup")[0].innerHTML = '';
        document.getElementsByClassName("doCalenderTODOEditPopup")[0].style.display = "none";
        document.getElementsByClassName("fullLayer")[0].style.display = "none";
      }
      var doCalenderPopupSave = function(datename) {
        var datename = year+"-"+month+"-"+day;
        var notetext;
        $.ajax({
          url: './dbaccess/getter.php',
          type: 'POST',
          dataType: 'json',
          async: true,
          data: {pid: '<?=$_SESSION['pid']?>',name: datename},
          success: function(data) {
            if (data.error) {
              var noteid;
              $.ajax({
                url: 'http://donote.co/api/newNote.php',
                type: 'POST',
                dataType: 'json',
                async: true,
                data: {title: d.getFullYear()+"년 "+(d.getMonth()+1)+"월 "+d.getDate()+"일의 할 일", text:text},
                success: function(data) {
                  noteid = data.pid;
                  $.ajax({
                    url: './dbaccess/setter.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {date: datename, note:data.pid}
                  })
                }
              })
            } else {

            }
          }
        })
      }
      var doCalenderPopupInputTempSaver = function(number) {
        document.getElementsByClassName("doCalenderPopupInput")[number].setAttribute("string", document.getElementsByClassName("doCalenderPopupInput")[number].value);
      }
      var doCalenderPopupCheckboxTempSaver = function(number) {
        if (document.getElementsByClassName("doCalenderPopupCheckbox")[number].getAttribute("checked") == "true") {
          document.getElementsByClassName("doCalenderPopupCheckbox")[number].removeAttribute("checked");
        }
        if (document.getElementsByClassName("doCalenderPopupCheckbox")[number].value === 'on') {
          document.getElementsByClassName("doCalenderPopupCheckbox")[number].setAttribute("checked", "true");
        }
      }
    </script>
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
              <li><p class="dropdown-item text-center" id="black"><strong><?=$_SESSION['nickname']?>님, 환영합니다</strong></p></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="container-fluid layer2" id="padding-generate-top">
      <hr class="displayOptionMobile" />
      <div class="col-md-12 doCalDiv">
        <div class="doCalenderTODOEditPopup" style="display:none"></div>
        <div class="fullLayer" onclick='doCalenderTodoPopupDestroy()' style="display:none"></div>
        <table class="doCalenderUI doCalenderTop">
          <caption>
            <input type="text" class="doCalenderYear" name="" value="" maxlength="4" size="2">년
            <select class="doCalenderMonth" name="">
              <option value="0" selected="none">1월</option>
              <option value="1" selected="none">2월</option>
              <option value="2" selected="none">3월</option>
              <option value="3" selected="none">4월</option>
              <option value="4" selected="none">5월</option>
              <option value="5" selected="none">6월</option>
              <option value="6" selected="none">7월</option>
              <option value="7" selected="none">8월</option>
              <option value="8" selected="none">9월</option>
              <option value="9" selected="none">10월</option>
              <option value="10" selected="none">11월</option>
              <option value="11" selected="none">12월</option>
            </select>
            <button onclick="init()">오늘로</button>
          </caption>
          <tr class="doCalenderUI">
            <td class="doCalenderUI doCalenderDay">일</td>
            <td class="doCalenderUI doCalenderDay">월</td>
            <td class="doCalenderUI doCalenderDay">화</td>
            <td class="doCalenderUI doCalenderDay">수</td>
            <td class="doCalenderUI doCalenderDay">목</td>
            <td class="doCalenderUI doCalenderDay">금</td>
            <td class="doCalenderUI doCalenderDay">토</td>
          </tr>
          <tr class="doCalenderUI" id="w1">
            <td class="doCalenderUI doCalenderDate" id="w1-1"></td>
            <td class="doCalenderUI doCalenderDate" id="w1-2"></td>
            <td class="doCalenderUI doCalenderDate" id="w1-3"></td>
            <td class="doCalenderUI doCalenderDate" id="w1-4"></td>
            <td class="doCalenderUI doCalenderDate" id="w1-5"></td>
            <td class="doCalenderUI doCalenderDate" id="w1-6"></td>
            <td class="doCalenderUI doCalenderDate" id="w1-7"></td>
          </tr>
          <tr class="doCalenderUI" id="w2">
            <td class="doCalenderUI doCalenderDate" id="w2-1"></td>
            <td class="doCalenderUI doCalenderDate" id="w2-2"></td>
            <td class="doCalenderUI doCalenderDate" id="w2-3"></td>
            <td class="doCalenderUI doCalenderDate" id="w2-4"></td>
            <td class="doCalenderUI doCalenderDate" id="w2-5"></td>
            <td class="doCalenderUI doCalenderDate" id="w2-6"></td>
            <td class="doCalenderUI doCalenderDate" id="w2-7"></td>
          </tr>
          <tr class="doCalenderUI" id="w3">
            <td class="doCalenderUI doCalenderDate" id="w3-1"></td>
            <td class="doCalenderUI doCalenderDate" id="w3-2"></td>
            <td class="doCalenderUI doCalenderDate" id="w3-3"></td>
            <td class="doCalenderUI doCalenderDate" id="w3-4"></td>
            <td class="doCalenderUI doCalenderDate" id="w3-5"></td>
            <td class="doCalenderUI doCalenderDate" id="w3-6"></td>
            <td class="doCalenderUI doCalenderDate" id="w3-7"></td>
          </tr>
          <tr class="doCalenderUI" id="w4">
            <td class="doCalenderUI doCalenderDate" id="w4-1"></td>
            <td class="doCalenderUI doCalenderDate" id="w4-2"></td>
            <td class="doCalenderUI doCalenderDate" id="w4-3"></td>
            <td class="doCalenderUI doCalenderDate" id="w4-4"></td>
            <td class="doCalenderUI doCalenderDate" id="w4-5"></td>
            <td class="doCalenderUI doCalenderDate" id="w4-6"></td>
            <td class="doCalenderUI doCalenderDate" id="w4-7"></td>
          </tr>
          <tr class="doCalenderUI" id="w5">
            <td class="doCalenderUI doCalenderDate" id="w5-1"></td>
            <td class="doCalenderUI doCalenderDate" id="w5-2"></td>
            <td class="doCalenderUI doCalenderDate" id="w5-3"></td>
            <td class="doCalenderUI doCalenderDate" id="w5-4"></td>
            <td class="doCalenderUI doCalenderDate" id="w5-5"></td>
            <td class="doCalenderUI doCalenderDate" id="w5-6"></td>
            <td class="doCalenderUI doCalenderDate" id="w5-7"></td>
          </tr>
          <tr class="doCalenderUI" id="w6">
            <td class="doCalenderUI doCalenderDate" id="w6-1"></td>
            <td class="doCalenderUI doCalenderDate" id="w6-2"></td>
            <td class="doCalenderUI doCalenderDate" id="w6-3"></td>
            <td class="doCalenderUI doCalenderDate" id="w6-4"></td>
            <td class="doCalenderUI doCalenderDate" id="w6-5"></td>
            <td class="doCalenderUI doCalenderDate" id="w6-6"></td>
            <td class="doCalenderUI doCalenderDate" id="w6-7"></td>
          </tr>
        </table>
      </div>
    </div>
    <script type="text/javascript">
      window.onload = init;
    </script>
    <script src="./lib/jquery-3.3.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
