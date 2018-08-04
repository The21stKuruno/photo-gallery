<?php
  $_SESSION['username'] = "Admin";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Image Gallery</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <header>
    <div class="container">
      <div class="header-inner">
        <h1 class="grid-item-3">Image Gallery</h1>
        <form class="grid-item-3" action="index.html" method="post">
          <input type="text" name="inpSearch">
          <button type="submit" name="smbSearch">Search</button>
        </form>
      </div>
      <!-- End of header-inner -->
    </div>
    <!-- End of container -->
  </header>
  <!-- End of Header -->
  <div class="container">
    <!-- End of Header -->
    <div class="photo-grid">
      <?php
      include_once 'includes/dbh.inc.php';

      $sql = "SELECT * FROM tblImg ORDER BY orderImg DESC;";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed!";
      } else {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
          echo '
            <a href="#">
              <figure>
                <img src="img/gallery/'.$row["imgFullNameImg"].'" alt="">
                <h3>'.$row["titleImg"].'</h3>
                <figcaption>'.$row["descriptionImg"].'</figcaption>
              </figure>
            </a>
          ';
        }
      }
      ?>
    </div>
    <!-- <div style="background-image: url();"></div> -->
    <!-- Upload -->
    <?php
    if (isset($_SESSION['username'])) {
      echo '<section class="upload-photo">
        <h3>Upload Image</h3>
        <form class="" action="includes/upload.inc.php" method="post" enctype="multipart/form-data">
          <input type="text" name="file-name" placeholder="File name..">
          <input type="text" name="image-title" placeholder="Image title..">
          <textarea name="image-description" rows="3" cols="30" placeholder="Image description.."></textarea>
          <label for="img-des"><i class="fas fa-upload"></i>Choose a file..</label>
          <input id="img-des" type="file" name="file">
          <button class="btn" type="submit" name="submitUpload">Upload</button>
        </form>
      </section>';
    }
    ?>
  </div>
  <!-- End of container -->
  <footer>
    <div class="container">
      <div class="footer-inner">
        <p>Cris-Aian Vergara &copy; 2018</p>
      </div>
    </div>
  </footer>
</body>
</html>
