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

    //Verificação do tipo form
    if($type === "register"){

        $name = filter_input(INPUT_POST, "name");
        $lastname = filter_input(INPUT_POST, "lastname");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        $confirmpassword = filter_input(INPUT_POST, "confirmpassword");


        //verificação de dados minimos
        if($name && $lastname && $email && $password){
            //verificar senhas
            if($password === $confirmpassword){
                
                // Verificar se o email já está cadastrado
                if($userDao->findByEmail($email)=== false){
                    
                    $user = new User();

                    // Criação de token e senha
                    $userToken = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);


                    $user->name = $name;
                    $user->lastname = $lastname;
                    $user->email = $email;
                    $user->password = $finalPassword;
                    $user->token = $userToken;
                    
                    $auth = true;

                    $userDao->create($user, $auth);
                }
                else {
                    //enviar erro
                    $message->setMessage("Usuário já cadastrado, tente outro email.", "error", "back");    
                }

            } 
            else {
                //enviar erro
                $message->setMessage("As senhas não são iguais.", "error", "back");
            }
        }
        else {
            // msg de erro de dados faltantes
            $message->setMessage("Por favor, preencha todos os campos.","error","back");
        }

    }
    else if($type === "login"){
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");
        // Tentativa de aut usuario
        if($userDao->authenticateUser($email, $password)) {
            
            $message->setMessage("Seja bem-vindo(a)!","success","editprofile.php");
        // Redireciona o usu/ário caso não autentique...
        }
        else {
            $message->setMessage("Usuários e/ou senhas incorretos.","error","back");
        }
    }
    else {
        $message->setMessage("informações inválidas!!!","error","index.php");
    }

?>