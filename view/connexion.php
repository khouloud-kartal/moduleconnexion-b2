<?php
    require_once '../UserController.php';

    session_start();

    if($_POST != null && isset($_GET['inscription'])){
        $connect = new UserController();
        $connect->Connect($_POST);
        echo $connect->getMsg();
        die();  
    }
?>

<?php require_once './header-footer/header.php';?>

<main>
    <form action="connexion.php" method="post" id="connexion">
        <fieldset>
            <legend>Sign In</legend>

            <label for="email">Email</label>
            <input type="email" name="email" id="email">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <button type="submit" name="submit" value="submit">Submit</button>

            <div id="message"></div>
            <p>Password forgotten? <a href="">Change your Password</a></p>
        </fieldset>
    </form>
</main>

</body>
</html>