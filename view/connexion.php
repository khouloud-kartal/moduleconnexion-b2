<?php
    require_once '../UserController.php';

    session_start();

    if(isset($_POST['submit'])){
        $connect = new UserController();
        // var_dump($_POST);
        $connect->Connect($_POST);
    }
?>

<?php require_once './header-footer/header.php';?>

<main>
    <form action="connexion.php" method="post">
        <fieldset>
            <legend>Connexion</legend>

            <label for="email">Login</label>
            <input type="email" name="email" id="email">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <button type="submit" name="submit" value="submit">Submit</button>
        </fieldset>
    </form>
</main>