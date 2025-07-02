<?php
$page_title = "Avatar Upload";
$page = '';
// Include the main.php file
include 'main.php';
require_once 'header.php';

// Check if the user is logged in, if not, then redirect to the login page
check_loggedin($pdo);
// Template code below

?>
<link href="css/jquery.Jcrop.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<?php

$profile_id = $_SESSION['account_id'];
$imgSrc = "";
$result_path = "";
$msg = "";

/***********************************************************
 * 0 - Remove The Temp image if it exists
 ***********************************************************/
if (!isset($_POST['x']) && !isset($_FILES['image']['name'])) {
    //Delete user's temp image
    $temppath = '/images/avatar/' . $profile_id . '_temp.jpeg';
    if (file_exists($temppath)) {
        @unlink($temppath);
    }
}


if (isset($_FILES['image']['name'])) {
    /***********************************************************
     * 1 - Upload Original Image To Server
     ***********************************************************/
    //Get Name | Size | Temp Location
    $ImageName = $_FILES['image']['name'];
    $ImageSize = $_FILES['image']['size'];
    $ImageTempName = $_FILES['image']['tmp_name'];
    //Get File Ext
    $ImageType = @explode('/', $_FILES['image']['type']);
    $type = $ImageType[1]; //file type
    //Set Upload directory
    $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/images/avatar/';
    //Set File name
    $file_temp_name = $profile_id . '_original.' . md5(time()) . 'n' . $type; //the temp file name
    $fullpath = $uploaddir . "/" . $file_temp_name; // the temp file path
    $file_name = $profile_id . '_temp.jpeg'; //$profile_id.'_temp.'.$type; // for the final resized image
    $fullpath_2 = $uploaddir . "/" . $file_name; //for the final resized image
    //Move the file to the correct location
    $move = move_uploaded_file($ImageTempName, $fullpath);
    chmod($fullpath, 0777);
    //Check for valid upload
    if (!$move) {
        die('File didnt upload');
    } else {
        $imgSrc = "/images/avatar/" . $file_name; // the image to display in the crop area
        $msg = "Upload Complete!";    //message to page
        $src = $file_name;            //the file name to post from the cropping form to the resize
    }

    /***********************************************************
     * 2  - Resize The Image To Fit In the Cropping Area
     ***********************************************************/
    //get the uploaded image size
    clearstatcache();
    $original_size = getimagesize($fullpath);
    $original_width = $original_size[0];
    $original_height = $original_size[1];
    // Specify The new size
    $main_width = 500; // set the width of the image
    $main_height = $original_height / ($original_width / $main_width);    // this sets the height in ratio
    //create new image using correct php func
    if ($_FILES["image"]["type"] == "image/gif") {
        $src2 = imagecreatefromgif($fullpath);
    } elseif ($_FILES["image"]["type"] == "image/jpeg" || $_FILES["image"]["type"] == "image/pjpeg") {
        $src2 = imagecreatefromjpeg($fullpath);
    } elseif ($_FILES["image"]["type"] == "image/png") {
        $src2 = imagecreatefrompng($fullpath);
    } else {
        $msg .= "There was an error uploading the file. Please upload a .jpg, .gif or .png file. <br />";
    }
    //create the new resized image
    $main = imagecreatetruecolor((int) round($main_width), (int) round($main_height));
    imagecopyresampled(
        $main,
        $src2,
        0,
        0,
        0,
        0,
        (int) round($main_width),
        (int) round($main_height),
        (int) round($original_width),
        (int) round($original_height)
    );
    //upload new version
    $main_temp = $fullpath_2;
    imagejpeg($main, $main_temp, 90);
    chmod($main_temp, 0777);
    //free up memory
    imagedestroy($src2);
    imagedestroy($main);
    //imagedestroy($fullpath);
    @unlink($fullpath); // delete the original upload

} //ADD Image

/***********************************************************
 * 3- Cropping & Converting The Image To Jpg
 ***********************************************************/
if (isset($_POST['x'])) {
    //the file type posted
    $type = $_POST['type'];
    //the image src
    $src = 'images/avatar/' . $_POST['src'];
    $finalname = $profile_id . md5(time());

    if ($type == 'jpg' || $type == 'jpeg' || $type == 'JPG' || $type == 'JPEG') {

        //the target dimensions 230x230
        $targ_w = $targ_h = 230;
        //quality of the output
        $jpeg_quality = 90;
        //create a cropped copy of the image
        $img_r = imagecreatefromjpeg($src);
        $dst_r = imagecreatetruecolor($targ_w, $targ_h);
        imagecopyresampled(
            $dst_r,
            $img_r,
            0,
            0,
            $_POST['x'],
            $_POST['y'],
            $targ_w,
            $targ_h,
            $_POST['w'],
            $_POST['h']
        );
        //save the new cropped version
        imagejpeg($dst_r, "images/avatar/" . $finalname . "n.jpeg", 90);
    } else if ($type == 'png' || $type == 'PNG') {

        //the target dimensions 230x230
        $targ_w = $targ_h = 230;
        //quality of the output
        $jpeg_quality = 90;
        //create a cropped copy of the image
        $img_r = imagecreatefrompng($src);
        $dst_r = imagecreatetruecolor($targ_w, $targ_h);
        imagecopyresampled(
            $dst_r,
            $img_r,
            0,
            0,
            $_POST['x'],
            $_POST['y'],
            $targ_w,
            $targ_h,
            $_POST['w'],
            $_POST['h']
        );
        //save the new cropped version
        imagejpeg($dst_r, "/images/avatar/" . $finalname . "n.jpeg", 90);
    } else if ($type == 'gif' || $type == 'GIF') {

        //the target dimensions 230x230
        $targ_w = $targ_h = 230;
        //quality of the output
        $jpeg_quality = 90;
        //create a cropped copy of the image
        $img_r = imagecreatefromgif($src);
        $dst_r = imagecreatetruecolor($targ_w, $targ_h);
        imagecopyresampled(
            $dst_r,
            $img_r,
            0,
            0,
            $_POST['x'],
            $_POST['y'],
            $targ_w,
            $targ_h,
            $_POST['w'],
            $_POST['h']
        );
        //save the new cropped version
        imagejpeg($dst_r, "/images/avatar/" . $finalname . "n.jpeg", 90);
    }
    //free up memory
    imagedestroy($img_r); // free up memory
    imagedestroy($dst_r); //free up memory
    @unlink($src); // delete the original upload

    //return cropped image to page
    $result_path = "/images/avatar/" . $finalname . "n.jpeg";

    // Check for an existing image and delete
    $stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ? LIMIT 1");
    $stmt->execute([$profile_id]);
    $record = $stmt->fetch();

    $imageUrl = ltrim($record['avatar'], '/');

    if (file_exists($imageUrl)) {
        //delete the image
        unlink($imageUrl);
    }

    //Insert image into database
    $sql = "UPDATE accounts SET avatar = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$result_path, $profile_id]);
    header("Location: /profile.php");
}
?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-3">
                    <div id="Overlay" style=" width:100%; height:100%; border:0px #990000 solid; position:absolute; top:0px; left:0px; display:none; z-index: -10;"></div>

                        <h2>Choose a New Profile Image</h2>
                        <h3 class="fw-light">Profile Upload</h3>
                        <div id="avatarForm">
                            <p>Select the image you want to use as your profile picture and click the upload button. You will be able to crop and save the new avatar or image on the next page.</p>
                            <form action="avatar.php" method="post" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="image" name="image" aria-describedby="image" required>
                                </div>
                                <input class="btn btn-primary mt-1" id="image" type="submit" value="Upload" />
                            </form>
                        </div> <!-- Form-->

                        <?php if ($imgSrc) { //if an image has been uploaded display cropping area
                        ?>
                        <script>
                            $('#Overlay').show();
                            $('#avatarForm').hide();
                        </script>

                <div id="CroppingContainer border pb-0">
                    <div class="col-md-7">
                        <div id="CroppingArea">
                            <img src="<?= $imgSrc ?>" border="0" id="jcrop_target" style="border:0px #990000 solid; position:relative; margin:0px 0px 0px 0px; padding:0px; " />
                        </div>
                    </div>
                    <div id="InfoArea">
                        <h5 class="mt-2">Crop Profile Image</h5>
                        <p>Resize your image by setting the crop boundary. Once you are happy with your new profile picture, please click the "Save Image" button and your new picture will be posted to your profile. If you don't want to continue with a new profile image click the "Cancel Crop" button.</p>
                        <div id="CropImageForm">
                            <form action="avatar.php" method="post" onsubmit="return checkCoords();">
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                                <input type="hidden" value="jpeg" name="type" /> <?php // $type
                                ?>
                                <input type="hidden" value="<?= $src ?>" name="src" />
                                <div class="d-grid gap-2">
                                    <input class="btn btn-success" type="submit" value="Save Image" />
                                </div>
                            </form>
                        </div>
                        <div id="CropImageForm2">
                            <form action="avatar.php" method="post" onsubmit="return cancelCrop();">
                                <div class="d-grid gap-2">
                                    <input class="btn btn-primary my-2" type="submit" value="Cancel Crop" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- CroppingContainer -->
                <?php } ?>
            </div>
        </div>
    </div>
</section>



<script src="js/jcrop_bits.js"></script>
<script src="js/jquery.Jcrop.js"></script>

<?php include 'footer.php'; ?>
