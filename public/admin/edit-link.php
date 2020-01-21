<?php
    require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/functions/checkToken.php';
    require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/models/UrlDatabase.php';
    require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/models/UrlShortener.php';

    $db = new UrlDatabase;
    $urlShortener = new UrlShortener;
    $id = $_GET["id"];
    $urlData = $db->getUrlData($id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = $urlShortener->validateUpdateInput($id, $_POST);
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
        } else {

            $result = $db->updateUrlData($id, $_POST["long_url"], $_POST["short_code"], $urlData["short_code"], $_POST["status"], $_POST["expire"], $_COOKIE["userId"], $_COOKIE["fullname"]);

            if ($result === 1) {
              $_SESSION['updateStatus'] = "Update Url thành công!";
              header('Location: /admin/');
            }
            elseif ($result === 0) {
              $message = "Url không thay đổi!";
              echo "<script type='text/javascript'>alert('$message');</script>";
            } else {
              $message = "Update Url thất bại!";
              echo "<script type='text/javascript'>alert('$message');</script>";
            }
        }

    }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
  <title>Edit Link</title>
</head>

<body>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

  <div class="container">
    <?php
        if (isset($_SESSION['errors'])) {
            ?>
            <div class="alert alert-danger mt-2" role="alert">
              <?php foreach ($_SESSION["errors"] as $error) {
                  echo "<li>$error</li>";
              } ?>
            </div>
            <?php

            unset($_SESSION['errors']);
        }
    ?>
    <h1 class="display-4 text-center">Update link</h1>
    <form method="POST" name="update_link" id="update_link">
      <input type="hidden" name="id" value="<?php echo $urlData[" id"]; ?>">
      <div class="form-group">
        <label for="formGroupExampleInput"><b>Url đích</b></label>
        <input type="url" class="form-control <?php echo isset($errors["long_url"])  ? 'is-invalid' : ''; ?>" id="long_url" name="long_url" value="<?php echo isset($_POST["long_url"]) ? $_POST["long_url"] : $urlData["long_url"]; ?>">
        <p class="long-url-error" style="color: red;"></p>
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2"><b>Short code</b></label>
        <input type="text" class="form-control <?php echo isset($errors["short_code"])  ? 'is-invalid' : ''; ?>" id="short_code" name="short_code" value="<?php echo isset($_POST["short_code"]) ? $_POST["short_code"] : $urlData["short_code"]; ?>">
        <p class="short-code-error" style="color: red;"></p>
      </div>
      <?php if (ENABLE_EXPIRED_TIME): ?>
        <div class="form-group">
          <label for="formGroupExampleInput2"><b>Hết hạn</b></label>
          <input class="form-control" type="datetime-local" name="expire" value="">
        </div>
      <?php endif; ?>
      <div class="form-group">
        <label for="formGroupExampleInput2"><b>Status</b></label>
        <br>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="customRadioInline1" name="status" class="custom-control-input" value="1" <?php echo ($urlData["status"] ? 'checked' : ''); ?>>
          <label class="custom-control-label" for="customRadioInline1">Kích hoạt</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="customRadioInline2" name="status" class="custom-control-input" value="0" <?php echo (!$urlData["status"] ? 'checked' : ''); ?>>
          <label class="custom-control-label" for="customRadioInline2">Vô hiệu hoá</label>
        </div>
      </div>
      <button class="btn btn-success btn-block" type="submit">Update</button>

    </form>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'; ?>
  <script type="text/javascript">

    $(document).ready(function () {
      function removeAccents(str) {
        str = str.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
        str= str.replace(/-+-/g,"-"); //thay thế 2- thành 1-
        str = str.replace(/^\-+|\-+$/g, "");

        return str;
      }
      $("#short_code").blur(function () {
        let code = $("#short_code").val()
        code = removeAccents(code)

        $("#short_code").val(code
        )
      })
      
      function checkIfFormValid() {
        var longUrl = $("#long_url").val()
        var shortCode = $("#short_code").val()

        var validLongUrl = false;
        var validShortCode = false;

        if (longUrl === "") {
          validLongUrl = false
          $(".long-url-error").text("Url không được trống")
        } else {
          validLongUrl = true
          $(".long-url-error").text("")
        }

        if (shortCode === "") {
          validShortCode = false
          $(".short-code-error").text("Short Code không được trống")

        } else {

          validShortCode = true
          $(".short-code-error").text("")
        }

        if (validLongUrl && validShortCode) {
          return true;

        } else {
          return false;
        }


      }

      $("#update_link").submit(function (e) {

        if (!checkIfFormValid()) {
          e.preventDefault();
        }

      })
    })
  </script>
</body>

</html>
