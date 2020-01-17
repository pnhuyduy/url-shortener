<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/checkToken.php';
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
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
  <title>Edit Link</title>
</head>

<body>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

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

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'; ?>
</body>

</html>
