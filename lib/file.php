<?php  
    class Upload
    {
        function doUpload($files)
        {
            $target_dir = $_SERVER['DOCUMENT_ROOT']."/NguyenQuangTruong/asset/images/"; // Base directory for upload
            $imageFileType = strtolower(pathinfo($files["name"], PATHINFO_EXTENSION));
            $uploadOk = 1;

            // Generate a unique file name to avoid overwriting
            $newFileName = uniqid('', true) . '.' . $imageFileType;
            $target_file = $target_dir . $newFileName;

            // Check if image file is a valid image
            if (isset($_POST["submit"])) {
                $check = getimagesize($files["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    return "File is not an image.";
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                return "Sorry, file already exists.";
            }

            // Check file size (adjust the size as per requirement)
            if ($files["size"] > 500000) {
                return "Sorry, your file is too large.";
            }

            // Allow only certain file formats
            if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }

            // Check if upload is okay, otherwise return an error message
            if ($uploadOk == 0) {
                return "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($files["tmp_name"], $target_file)) {
                    return "The file " . htmlspecialchars($newFileName) . " has been uploaded.";
                } else {
                    return "Sorry, there was an error uploading your file.";
                }
            }
        }
    }
?>