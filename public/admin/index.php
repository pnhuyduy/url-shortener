<?php
    require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/functions/checkToken.php';
    require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/system/models/UrlDatabase.php';

    $db = new UrlDatabase;
    $short_urls = $db->getShortUrls();
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
  <title>Quản lý Links</title>
</head>

<body>
  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

  <div class="container">

      <?php
          if (isset($_SESSION['updateStatus'])) {
              ?>
              <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['updateStatus']; ?>
              </div>
              <?php

              unset($_SESSION['updateStatus']);
          }
      ?>

    <h1 class="display-4 text-center">Quản lý Links</h1>

    <?php if ($short_urls): ?>

    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Url đích</th>
          <th scope="col">Short code</th>
          <th scope="col">Lượt click</th>
          <th scope="col">Tạo lúc</th>
          <th scope="col">Cập nhật lúc</th>
          <th scope="col">Tạo bởi</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($short_urls as $short_url): ?>
        <tr>
          <th scope="row">
            <?php echo $short_url["id"]; ?>
          </th>
          <td>
            <a href="<?php echo $short_url["long_url"]; ?>">
              <?php echo $short_url["long_url"]; ?></a>
          </td>
          <td>
            <a href="<?php echo BASE_URL . '/' . $short_url["short_code"]; ?>">
              <?php echo $short_url["short_code"]; ?></a>
          </td>
          <td>
            <?php echo $short_url["clicked_counter"]; ?>
          </td>
          <td>
            <?php echo $short_url["created_at"]; ?>
          </td>
          <td>
            <?php echo $short_url["updated_at"]; ?>
          </td>
          <td>
            <?php echo $short_url["username_created"]; ?>
          </td>
          <td>
            <?php if ($short_url["status"]): ?>
              <span class="badge badge-success">Kích hoạt</span>
            <?php else: ?>
              <span class="badge badge-danger">Vô hiệu hoá</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="<?php echo BASE_URL . '/admin/edit-link.php' . '?id=' .$short_url["id"]; ?>" class="btn btn-info">Edit</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php else: ?>
    <h5 class="text-danger">Không tìm thấy dữ liệu</h5>
    <?php endif; ?>

  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'; ?>
</body>

</html>
