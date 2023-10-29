<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <?php 
        $errors = [];
        if($_SERVER["REQUEST_METHOD"] === "POST" ){ 
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . uniqid() . basename($_FILES['avatar']['name']);
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $authorizedExtensions = ['jpg','png', 'gif', 'webp'];
            $maxFileSize = 1000000;

            if( (!in_array($extension, $authorizedExtensions))) {
                $errors[] = 'Veuillez sélectionner une image de type Jpg ou Png ou gif ou webp !';
            }

            if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
                $errors[] = "Votre fichier doit faire moins de 1k !";
            }
           
            if(empty($errors)){
                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
                }
        }
        ?>
                <div>
                    <ul>
                        <?php if(!empty($errors)) {
                             foreach ($errors as $error) : ?>
                            <li><?= $error ?></li>
                        <?php endforeach; }?>
                    </ul>
                </div>
        <form action= "" method="post" enctype="multipart/form-data">
            <label for="imageUpload">Upload an profile image</label>    
            <input type="file" name="avatar" id="imageUpload" />
            <button name="send">Send</button>
        </form>

        <img src="<?= $uploadFile?>"> 
    </body>
</html>
