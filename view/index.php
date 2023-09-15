

<?php require_once './header-footer/header.php';?>

<main>

    <div id='home'>
        <h1>Welcome to my WebSite <?php if (isset($_SESSION['user'])){ echo $_SESSION['user']->getLogin();} ?></h1>
    </div>

</main>
</body>
</html>
