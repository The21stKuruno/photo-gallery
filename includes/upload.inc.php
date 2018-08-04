<?php
 if (isset($_POST['submitUpload'])) {
    $newFileName = $_POST['file-name'];

    if (empty($newFileName)) {
      // when file name is empty
      $newFileName = "gallery";
    } else {
      // replace spaces with a -
      $newFileName = strtolower(str_replace(" ", "-", $newFileName));
    }

    $imageTitle = $_POST['image-title'];
    $imageDescription = $_POST['image-description'];

    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    // Error Handlers
    if (in_array($fileActualExt, $allowed)) {
      if ($fileError === 0) {
        if ($fileSize < 2000000) {
          $imageFullName = $newFileName . "." . uniqid("", true) . "." . $fileActualExt;
          $fileDestination = '../img/gallery/'.$imageFullName;

          include_once 'dbh.inc.php';
          // Error Handlers
          if (empty($imageTitle) || empty($imageDescription)) {
            header("Location: ../index.php?upload=empty");
            exit();
          } else {
            $sql = "SELECT * FROM tblImg;";
            $stmt = mysqli_stmt_init($conn);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "SQL statement failed!";
            } else {
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              $rowCount = mysqli_num_rows($result);
              $setImageOrder = $rowCount + 1;

              $sql = "INSERT INTO tblImg (titleImg, descriptionImg, imgFullNameImg, orderImg) VALUES (?, ?, ?, ?);";
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "SQL statement failed!";
              } else {
                mysqli_stmt_bind_param($stmt, "ssss", $imageTitle, $imageDescription, $imageFullName, $setImageOrder);
                mysqli_stmt_execute($stmt);

                move_uploaded_file($fileTmpName, $fileDestination);

                header("Location: ../index.php?upload=success");
                exit();
              }
            }
          }
        } else {
          header("Location: ../index.php?upload=filetoolarge");
          exit();
        }
      } else {
        header("Location: ../index.php?upload=fileerror");
        exit();
      }
    } else {
      header("Location: ../index.php?upload=exterror");
      exit();
    }

  } else {
    header("Location: ../index.php?upload=error");
    exit();
  }

?>
