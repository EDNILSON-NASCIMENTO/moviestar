<?php
    require_once("globals.php");
    require_once("db.php");
    require_once("models/User.php");
    require_once("models/Message.php");
    require_once("dao/UserDAO.php");

    $message = new Message($BASE_URL);

    $userDao = new UserDAO($conn, $BASE_URL);

     // Resgata tipo formulário
     $type = filter_input(INPUT_POST, "type");

    //atualiza usuário
    if($type === "update"){

        // Resgata dados do usuário
        $userData = $userDao->verifyToken();

        // Receber dados do post
        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $bio = filter_input(INPUT_POST, "bio");
       
        //criar novo objeto de usuario
        $user = new User();

        // Preencher os dados do usuário
        $userData->name = $name;
        $userData->lastname = $lastname;
        $userData->email = $email;
        $userData->bio = $bio;
       
        //upload da imagem
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            if(in_array($image["type"], $imageTypes)){

                //Checar se jpg
                if(in_array($image, $jpgArrayg)){
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);
                }
                else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }


            }
            else {
                $message->setMessage("Tipo inválido de imagem!", "error", "back");
            }
        }


        $userDao->update($userData);

    }
    else if ($type === "changepassword"){

    }
    else {
        $message->setMessage("Informações inválidas!", "error", "index.php");

    }

?>