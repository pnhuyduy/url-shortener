<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/app/UrlDatabase.php';

    $db = new UrlDatabase;
    $id = $_GET["id"];
    $urlData = $db->getUrlData($id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $result = $db->updateUrlData($id, $_POST["long_url"], $_POST["short_code"], $_POST["status"], $_POST["expire"]);
        if ($result === 1) {
          $_SESSION['updateStatus'] = "Update Url thành công!";
          header('Location: links-management.php');
        }
        elseif ($result === 0) {
          $message = "Url không thay đổi!";
          echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
          $message = "Update Url thất bại!";
          echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" charset="utf-8"></script>
  <title>Edit Link</title>
</head>

<body>
  <header class="mb-2">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo BASE_URL . 'pages/links-management.php'; ?>">Quản lý Link</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
  <div class="container">
    <h1 class="display-4 text-center">Update link</h1>
    <form method="POST" name="update_link">
      <input type="hidden" name="id" value="<?php echo $urlData[" id"]; ?>">
      <div class="form-group">
        <label for="formGroupExampleInput"><b>Url đích</b></label>
        <input type="url" class="form-control" name="long_url" value="<?php echo $urlData["long_url"]; ?>">
      </div>
      <div class="form-group">
        <label for="formGroupExampleInput2"><b>Short code</b></label>
        <input type="text" class="form-control" name="short_code" value="<?php echo $urlData["short_code"]; ?>">
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
</body>

</html>
