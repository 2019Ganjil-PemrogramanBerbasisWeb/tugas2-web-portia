 <?php

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

if (file_exists($target_file)) {
    echo "File dah ada bro";
    $uploadOk = 0;
}

if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "File kebesaran bro. ";
    $uploadOk = 0;
}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "JPG, JPEG, PNG, GIF aja. ";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    echo "Maaf ngga keupload. ";

} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        $conn = mysqli_connect("localhost","root","","upload");
          if ($conn->connect_error) {
            die("Connection failed: " . mysqli_connect_error());
          }
    $link = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $nama = basename($_FILES["fileToUpload"]["name"]);
    $conn->query("INSERT INTO `upload`(`nama`, `link`) VALUES ('$nama','$target_file')");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>
