<?php 
    require_once '../UserController.php';

    session_start();

    $user = $_SESSION['user'];

    if($_POST != NULL && isset($_GET['inscription'])){
        $users = new UserController();
        $users->Update($_POST);
        echo $users->getMsg();
        die();
    }
    
?>

<?php require_once './header-footer/header.php';?>

<main>
    <form action="profil.php" method="post" id="profil">
        <fieldset>
            <legend>Profil</legend>

            <label for="login">Login</label>
            <input type="text" name="login" id="login" value="<?= $user->getLogin() ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?= $user->getEmail() ?>">

            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" id="fullname" value="<?= $user->getFullName() ?>">

            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" value="<?= $user->getPhone() ?>">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <label for="newPassword">New Password</label>
            <input type="password" name="newPassword" id="newPassword">

            <label for="confirmNewPassword">Confirm New Password</label>
            <input type="password" name="confirmNewPassword" id="confirmNewPassword">

            <button type="submit" name="submit" value="submit">Submit</button>

            <div id="message"></div>
        </fieldset>
    </form>
</main>

</body>
</html>