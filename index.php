<html>
<head>
    <title>multiple upload</title>
</head>
<body>

<form action="#" enctype="multipart/form-data" method="post">

    <input type="file" name="img[]" multiple="multiple">
    <input name="submit" type="submit"/>

</form>

<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

require_once 'vendor/autoload.php';

$whoops = new Run;
$whoops->pushHandler(new PrettyPageHandler);
$whoops->register();

$con = mysqli_connect("localhost", "root", "1234");
mysqli_select_dB($con, "multiple");

if (isset($_POST["submit"])) {

    dump($_POST);
    dump($_FILES['img']);

    $filename = $_FILES['img']['name'];
    $file_tmp = $_FILES['img']['tmp_name'];
    $filetype = $_FILES['img']['type'];
    $filesize = $_FILES['img']['size'];

//    for ($i = 0; $i < count($filename); $i++) {
//
//        if (!empty($file_tmp[$i])) {
//            $name = addslashes($filename[$i]);
//            $tmp = addslashes(file_get_contents($file_tmp[$i]));
//            mysqli_query($con,"Insert into img(name,image) values('$name','$tmp')");
//        }
//
//    }

    foreach ($_FILES["img"]["tmp_name"] as $key => $tmp_name) {

        $name = addslashes($_FILES["img"]["name"][$key]);
        $temp = addslashes($_FILES["img"]["tmp_name"][$key]);

        if (!empty($temp)) {
            mysqli_query($con, "Insert into img(name) values('$name')");
        }

        if(!move_uploaded_file($temp, "images/" . $name))
        {
            echo 'Upload error.';
        }
    }

}

//display
$res = mysqli_query($con, "SELECT * FROM img");
while ($row = mysqli_fetch_array($res)) {
    echo '<img src=images/' . $row['name'] . '" width="250" height="250">';
    echo "<br />";
}

?>

</body>
</html>