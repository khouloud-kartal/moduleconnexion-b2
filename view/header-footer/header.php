
<?php 

    require_once '../UserController.php';


    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./scripts/script.js" defer></script>
    <title>Module</title>
</head>
    <body>
        <header>
            <nav>
                <a href="index.php">Home</a>
                <?php if (!isset($_SESSION['user'])){ ?><a href="connexion.php">Sign In</a><?php } ?>
                <?php if (!isset($_SESSION['user'])){ ?><a href="inscription.php">Sign Up</a><?php } ?>
                <?php if (isset($_SESSION['user'])){ ?><a href="profil.php">Profil</a><?php } ?>
                <?php if ((isset($_SESSION['user'])) && ($_SESSION['user']->getEmail() === 'admiN1337$@test.fr')){ ?><a href="admin.php">Admin</a><?php } ?>
                <?php if (isset($_SESSION['user'])){ ?><a href="disconnect.php">Disconnect</a><?php } ?>
            
            </nav>    
        </header>    
    </body>
</html>