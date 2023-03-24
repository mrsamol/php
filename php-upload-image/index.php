<?php
    include_once('functions.php');

    $listImage = new UplaodImage();
    $getImage = $listImage->list_dir('uploads/2023/24/');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 5 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container-fluid p-5 bg-primary text-white text-center">
  <h1>Upload Image</h1>
</div>
  
<div class="container mt-5">
    <form action="action.php" method="post" enctype="multipart/form-data">
        <div class="row">
            <h5>
                <?php 
                    $message = $listImage->get_flash_message('message');
                    echo $message;
                ?>

            </h5>
        <div class="mb-3 col-12 col-sm-11 ">
            <input class="form-control" type="file" id="formFile" name="image">
        </div>
        <div class="mb-3 col-12 col-sm-1">
            <button type="submit" class="btn btn-success">Submit</button>
        </div>
    </form>
    <?php 
        echo $getImage;
    ?>
  </div>
</div>

</body>
</html>
