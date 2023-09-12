<?php 
    require_once '../UserController.php';
    
    $user = new UserController();

    if(isset($_POST['submit'])){
        $user->Register($_POST);
    }
    
?>

<?php require_once './header-footer/header.php';?>

<main>
    <form action="inscription.php" method="post">
        <fieldset>
            <legend>Inscription</legend>

            <label for="login">Login</label>
            <input type="text" name="login" placeholder="login" id="login">

            <label for="email">Email</label>
            <input type="email" name="email" id="email">

            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" id="fullname">

            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone">

            <label for="password">Password</label>
            <input type="password" name="password" id="password">

            <label for="confirmPassword">Confirm Password</label>
            <input type="password" name="confirmPassword" id="confirmPassword">

            <button type="submit" name="submit" value="submit">Submit</button>
        </fieldset>
    </form>
</main>