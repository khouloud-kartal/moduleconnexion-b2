<?php 
    require_once '../UserController.php';

    session_start();
    
    $user = new UserController();

    $data = $user->getAllData();

    if(isset($_GET['delete'])){
        $user->DeleteUser($_GET['delete']);
    }
    
?>

<?php require_once './header-footer/header.php';?>

    <main id="admin">
        <h1>Users</h1>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>fullname</th>
                    <th>Phone Number</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $value) { 
                    if($value['email'] != $_SESSION['user']->getEmail()){ ?>
                        <tr>
                            <td><?= $value['id']?></td>
                            <td><?= $value['login']?></td>
                            <td><?= $value['email']?></td>
                            <td><?= $value['fullname']?></td>
                            <td><?= $value['phone']?></td>
                            <td><button class="delete" id="<?= $value['id']?>">Delete</button></td>
                        </tr>
                <?php }}; ?>
            </tbody>
        </table>
    </main>
</body>
</html>