<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../modules/commons/Commons/Utils/ClassImageUtils.php';
    $thumbnail = Commons_Utils_ImageUtils::createThumbnailJpeg($_FILES['user_image']['tmp_name'], 150, 150);
    header('Content-type: image/jpeg');
    echo $thumbnail;
    //print_r($_FILES);
} else {
?><form enctype="multipart/form-data" action="" method="POST">
    What would you like to call the image?: <input type="text" name="image_name" id="image_name" />
    <br />
    What caption should the image have?: <input type="text" name="image_caption" id="image_caption" />
    <br />
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    Pick an Image from your computer: <input name="user_image" type="file" />
    <br />
    <input type="submit" value="Upload" />
</form>
<?php } ?>