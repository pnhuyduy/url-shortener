<?php
    require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/functions/checkToken.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
  <title>Index</title>
</head>

<body>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4 text-center">URL Shortener</h1>
      <hr class="my-4">
      <form class="input-group mb-3" action="/shorten.php" method="POST">
        <input type="url" class="form-control" placeholder="E.g: https://www.google.com" name="url" required>
        <div class="input-group-append">
          <button class="btn btn-info" type="submit" id="button-addon2">Shorten</button>
        </div>
      </form>
      <h3>
        Kết quả:
        <?php
        if (isset($_SESSION['shortUrl'])) {
            echo $_SESSION['shortUrl'];

            unset($_SESSION['shortUrl']);
        }
        ?>
      </h3>
    </div>
  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'; ?>
  <script type="text/javascript">
    function validateUrl(url) {
      return /^((([A-Za-z]{3,9}:(?:\/\/)?)(?:[\-;:&=\+\$,\w]+@)?[A-Za-z0-9\.\-]+|(?:www\.|[\-;:&=\+\$,\w]+@)[A-Za-z0-9\.\-]+)((?:\/[\+~%\/\.\w\-_]*)?\??(?:[\-\+=&;%@\.\w_]*)#?(?:[\.\!\/\\\w]*))?)$/.test(url)
    }
  </script>
</body>

</html>
