<?php

    if (isset($_POST["email"])) {
      $url = 'https://192.168.1.16:9001/employee/get-token?email=' . $_POST["email"] . '&password=' . $_POST["password"];

      $ch = curl_init($url);
      // Bypass SSL
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      // Thiết lập có return
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);

      curl_close($ch);
      $res = json_decode($result, 1);

      if ($res["status"]) {
          setcookie("token", $res["token"], time() + (60 * COOKIE_EXPIRE_TIME), "/");
          header("Refresh:0");
      } else {
        switch ($res["errorCode"]) {
          case '2':
            $_SESSION['loginStatus'] = "Email không tồn tại";
            break;
          case '3':
            $_SESSION['loginStatus'] = "Mật khẩu không đúng";
            break;

          default:
            break;
        }
      }

    }

    if (!isset($_COOKIE["userData"])) {
      ?>

      <!DOCTYPE html>
      <html lang="en">
      <head>
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
        <title>Document</title>
      </head>
      <body>
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

        <div class="container">
          <?php
              if (isset($_SESSION['loginStatus'])) {
                  ?>
                  <div class="alert alert-danger mt-2" role="alert">
                    <?php echo $_SESSION['loginStatus']; ?>
                  </div>
                  <?php

                  unset($_SESSION['loginStatus']);
              }
          ?>
          <div class="row">
            <div class="col-lg-8 offset-lg-2">
              <h2 class="text-center">Login</h2>
              <form action="" method="POST">
                <div class="form-group">
                  <label for="exampleInputEmail1">Tài khoản</label>
                  <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" class="form-control" name="password">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
              </form>
            </div>
          </div>
        </div>

        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'; ?>
      </body>
      </html>
      <?php die;
    }
