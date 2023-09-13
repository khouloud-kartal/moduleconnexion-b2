<?php 
    require_once '../UserController.php';
    
    $user = new UserController();

    $data = $user->getAllData();
    
?>

<?php require_once './header-footer/header.php';?>

    <main>
        <h1>Users</h1>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>fullname</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key => $value) { ?>
                    <tr>
                        <td><?= $value['id']?></td>
                        <td><?= $value['login']?></td>
                        <td><?= $value['email']?></td>
                        <td><?= $value['fullname']?></td>
                        <td><?= $value['phone']?></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </main>
</body>
</html>