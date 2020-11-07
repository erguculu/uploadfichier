<?php

if (isset($_FILES['photos']['name'][0])) {
    $files = $_FILES['photos'];
    $allowed = array('png' , 'jpg', 'gif');

    
    foreach($files['name'] as $position => $file_name) {
        $file_tmp = $files['tmp_name'][$position];
        $file_size = $files['size'][$position];

        $file_ext = explode('.', $file_name);
        $file_ext = strtolower(end($file_ext));

        if(in_array($file_ext, $allowed)) {

            if($file_size <= 1000000) {
                $file_name_new = uniqid('', true) . '.' . $file_ext;
                $file_destination = 'uploads/' . $file_name_new;

                if (move_uploaded_file($file_tmp, $file_destination)) {
                    $uploaded[$position] = $file_destination;
                    echo '<figure>' . PHP_EOL;
                    echo '    <img src=' . $file_destination . ' width=100px heigth=100px >' . PHP_EOL;
                    echo '    <figcaption>' . $file_name_new . '</figcaption' . PHP_EOL;
                    echo '</figure>' . '<br>';
                } else {
                    $failed[$position] = "Error";
                }
            } else {
                $failed[$position] = "La photo est trop lourd.";
            }
        } else {
            $failed[$position] = "Le format de photo ne pas accepté";
        }
    }
    if (!empty($uploaded)) {
        echo "Photo a été téléchargé avec succès" . '<br>';
    }
    if (!empty($failed)) {
        echo 'Une erreur est survenu pour';
    }
}


$fileIterator = new FilesystemIterator("uploads/");
foreach ($fileIterator as $fileinfo) {
    echo $fileinfo->getFilename() . "\n";
    echo "<figure><img src = '" . $fileinfo->getPathname() ."'></figure>";
}
?>

<form action="index.php" method="post" enctype="multipart/form-data">
    <label for="imageUpload">Télécharger vos photos</label>    
    <input type="file" name="photos[]" multiple="multiple" >
    <input type="submit" name="submit" value="Submit">

