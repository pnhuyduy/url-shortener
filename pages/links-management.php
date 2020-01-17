<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'] . '/configs.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/app/UrlDatabase.php';
    $db = new UrlDatabase;
    $short_urls = $db->getShortUrls();

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" charset="utf-8"></script>
  <title>Quản lý Links</title>
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
            <a href="<?php echo BASE_URL . $short_url["short_code"]; ?>">
              <?php echo BASE_URL . $short_url["short_code"]; ?></a>
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
            <?php echo $short_url["created_by"]; ?>
          </td>
          <td>
            <?php if ($short_url["status"]): ?>
              <span class="badge badge-success">Kích hoạt</span>
            <?php else: ?>
              <span class="badge badge-danger">Vô hiệu hoá</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="<?php echo BASE_URL . 'pages/edit-link.php' . '?id=' .$short_url["id"]; ?>" class="btn btn-info">Edit</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php else: ?>
    <h5 class="text-danger">Không tìm thấy dữ liệu</h5>
    <?php endif; ?>

  </div>
</body>

</html>
