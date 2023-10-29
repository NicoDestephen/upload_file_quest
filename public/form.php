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
        // Je vérifie que le formulaire est soumis, comme pour tout traitement de formulaire.
        if($_SERVER["REQUEST_METHOD"] === "POST" ){ 
            // chemin vers un dossier sur le serveur qui va recevoir les fichiers transférés (attention ce dossier doit être accessible en écriture)
            $uploadDir = 'uploads/';
            
            // le nom de fichier sur le serveur est celui du nom d'origine du fichier sur le poste du client (mais d'autres stratégies de nommage sont possibles)
            $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
        
            // Je récupère l'extension du fichier
            $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);

            // Les extensions autorisées
            $authorizedExtensions = ['jpg','png', 'gif', 'webp'];

            // Le poids max géré par PHP par défaut est de 1M
            $maxFileSize = 1000000;
            
   
            // Je sécurise et effectue mes tests

            /****** Si l'extension est autorisée *************/
            if( (!in_array($extension, $authorizedExtensions))) {
                $errors[] = 'Veuillez sélectionner une image de type Jpg ou Png ou gif ou webp !';
            }

            /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
            if( file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
                $errors[] = "Votre fichier doit faire moins de 1k !";
            }
           
            if(empty($errors)){
                // on déplace le fichier temporaire vers le nouvel emplacement sur le serveur. Ça y est, le fichier est uploadé
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

        <img src="uploads/homer-simpson-les-simpson-le-film-2007-2jk4tgd.jpg"> 
    </body>
</html>
