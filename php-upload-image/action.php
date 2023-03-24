<?php
    include_once('functions.php');

    $uplaod = new UplaodImage();
    $uplaod->upload_file([]);
    $uplaod->redirect('index.php');
    