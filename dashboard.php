<?php 
    require_once("templates/header.php");

    //Verificar se o usuario esta autenticado
    require_once("templates/header.php");
    require_once("dao/UserDAO.php");

    $user = new User();
    $userDao = new UserDAO($conn, $BASE_URL);

    $userData = $userDao->verifyToken(true);

?>

    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Dashboard</h2>
        <p class="section-description">Adicione ou atualize as informações dos filmes.</p>
        <div class="com-md-12" id="movies-dashboard">
            <table class="table"></table>
        </div>
    </div>

<?php 
    require_once("templates/footer.php");
?>

