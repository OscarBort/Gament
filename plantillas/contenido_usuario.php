<?php
if (isset($_POST["submitImagen"]) && isset($_FILES["fileToUpload"])) {
    subirImagen();
}

echo '<form action="" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submitImagen">
    </form>';
?>