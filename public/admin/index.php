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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
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

      <table id="example" class="table table-striped table-bordered display" style="width:100%">
            <thead>
                <tr>
                    <th>Url đích</th>
                    <th>Short Code</th>
                    <th>Lượt click</th>
                    <th>Tạo lúc</th>
                    <th>Cập nhật lúc</th>
                    <th>Tạo bởi</th>
                    <th>Trạng thái</th>
                    <th>Action</th>
                </tr>
            </thead>
      </table>

    <?php else: ?>
    <h5 class="text-danger">Không tìm thấy dữ liệu</h5>
    <?php endif; ?>

  </div>

  <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/scripts.php'; ?>
  <script src="https://code.jquery.com/jquery-3.3.1.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" charset="utf-8"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" charset="utf-8"></script>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable( {
      "ajax": {
        url: "../urlsJson.php",
        method: "GET",
        dataFilter(data) {

          data = JSON.parse(data);
          data.data.map((url) => {
            if (url.status) {
              url.status = '<span class="badge badge-success">Kích hoạt</span>'
            } else {
              url.status = '<span class="badge badge-danger">Vô hiệu hoá</span>'
            }

            longUrl = `<a href="${url.long_url}">${url.long_url}</a>`;
            url.long_url = longUrl;

            hostName = window.location.hostname
            shortCode = `<a href="http://${hostName}/${url.short_code}">${url.short_code}</a>`;
            url.short_code = shortCode;

            editHref = window.location.href
            url.action = `<a href="${editHref}edit-link.php?id=${url.id}" class="btn btn-info">Edit</a>`
          })

          return JSON.stringify(data);
        }
      },
      "columns": [
          { "data": "long_url" },
          { "data": "short_code" },
          { "data": "clicked_counter" },
          { "data": "created_at" },
          { "data": "updated_at" },
          { "data": "username_created" },
          { "data": "status" },
          { "data": "action" },

      ],
    });
  });
  </script>
</body>

</html>
