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
            <a class="nav-link" href="<?php echo BASE_URL . '/pages/links-management.php'; ?>">Quản lý Link</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <?php if (isset($_COOKIE["token"])): ?>
            <li class="nav-item">

              <a href="<?php echo BASE_URL . '/logOut.php'; ?>" class="nav-link">Đăng xuất</a>
            </li>
          <?php endif; ?>
        </ul>

      </div>
    </nav>
  </div>
</header>
