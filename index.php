<?php
    session_start();

    require_once 'app/configs.php';
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" charset="utf-8"></script>
  <title>Index</title>
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
              <a class="nav-link" href="<?php echo BASE_URL . 'pages/links-management.php'; ?>">Quản lý Links</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4 text-center">URL Shortener</h1>
      <hr class="my-4">
      <form class="input-group mb-3" action="shorten.php" method="POST">
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
</body>

</html>
