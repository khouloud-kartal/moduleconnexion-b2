<?php

require_once '../UserModel.php';

class UserController{
    private ?int $id;
    private ?string $login;
    private ?string $email;
    private ?string $fullname;
    private ?int $phone;
    private ?string $password;
    public ?string $msg;

    public function __constructor(){
        
    }

    ####################################################################################
    #################### inscription ###################################################
    ####################################################################################


    private function checkFormNotEmpty($posts){
        
        foreach ($posts as $post) {
            if ($post == null || $post == '') {
                return false;
            }
        }
        return true;

    }

    private function checkPassword($password, $confirmPassword){

        // Has minimum 8 characters in length. Adjust it by modifying {8,}
        // At least one uppercase English letter. You can remove this condition by removing (?=.*?[A-Z])
        // At least one lowercase English letter.  You can remove this condition by removing (?=.*?[a-z])
        // At least one digit. You can remove this condition by removing (?=.*?[0-9])
        // At least one special character,  You can remove this condition by removing (?=.*?[#?!@$%^&*-])
        $regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";
        $checkRegex = false;
        $checkConfirmPassword = false;

        // check si le mot de passe est conpforme
        if(preg_match($regex, $password)){
            $checkRegex = true;
        }else{
            $this->msg = "<p class='error'>Le mot de passe n'est pas conforme.</p>";
        }

        // check si les mot de passe sont identiques
        if($password === $confirmPassword){
            $checkConfirmPassword = true;
        }else{
            $this->msg = "<p class='error'>Les mots de passe ne sont pas identiques.</p>";
        }

        // check is le password est validé
        if($checkRegex === true && $checkConfirmPassword === true){
            return true;
        }
    }

    private function checkEmail($email){

        $user = new UserModel();
        $count = $user->requestCheckEmail($email);

        if($count < 1){
            return true;
        }else{
            $this->msg = "<p class='error'>L'email est déjà utilisé.</p>";
        }
    }

    private function Xss($posts){
        foreach ($posts as $post) {
            $post = htmlspecialchars(trim($post));
        }
        return $post;
    }


    public function Register($post){
        if($this->checkFormNotEmpty($post)){
            if($this->checkEmail($post['email'])){
                if($this->checkPassword(($post['password']), ($post['confirmPassword']))){
                    if($this->Xss($post)){
                        $post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);

                        $request = new UserModel();
                        $request->requestRegister($post['login'], $post['email'], $post['fullname'], $post['phone'], $post['password']);
                        
                        $this->msg = "<p class='trueMsg'>Inscription réussie.</p>";
                    }
                }
            }
        }else{
            $this->msg = "<p class='error'>remplir tous les champs</p>";
        }
    }


    ##################################################################################
    ######################################## Connexion ###############################
    ##################################################################################




    private function checkPasswordConnect($email, $password){
        $request = new UserModel();
        $data = $request->requestGetDataMail($email);
        // var_dump($data);
        if(is_array($data)){
    
            if(password_verify($password, $data['password'])){
                // var_dump("success");
                return true;
            }else{
                $this->msg = "<p class='error'>Identifiant ou mot de passe incorrect</p>";
            }
        }else{
            $this->msg = "<p class='error'>Identifiant est incorrect</p>";
        }
        
    }

    public function Connect($post){
        if($this->checkFormNotEmpty($post)){
            if($this->checkPasswordConnect($post['email'], $post['password'])){
                if($this->Xss($post)){
                    $request = new UserModel();
                    $data = $request->requestGetDataMail($post['email']);

                    $userConnected = new UserController();

                    $userConnected->setId(intval($data['id']));
                    $userConnected->setLogin($data['login']);
                    $userConnected->setEmail($data['email']);
                    $userConnected->setFullName($data['fullname']);
                    $userConnected->setPhone($data['phone']);
                    $userConnected->setPassword($data['password']);

                    $_SESSION['user'] = $userConnected;

                    $this->msg = "Vous êtes connecté(e), vous allez être rédiger dans la page d'acceuil dans 2 secondes.";
                    
                }
            }
        }else{
            $this->msg = "<p class='error'>remplir tout les champs.</p>";
        }
    }



    ##################################################################################
    ######################################## Update ##################################
    ##################################################################################


    public function Update($post){
        $user = $_SESSION['user'];

        $idUser = $user->getId();

        $this->Xss($post);

        $changes = [];

        $posts = [$post['login'], $post['email'], $post['fullname'], $post['password']];

        if($this->checkFormNotEmpty($posts)){
            if(password_verify($post['password'], $user->getPassword())){
                if($post['email'] != $user->getEmail()){

                    if($this->checkEmail($post['email'])){
                        $changes['email'] = $post['email'];
                        $_SESSION['user']->setEmail($post['email']);
                    }
                }

                if($post['newPassword'] != null){
                    if($this->checkPassword($post['newPassword'], $post['confirmNewPassword'])){
                        $hashedPassword = password_hash($post['newPassword'], PASSWORD_BCRYPT);
                        $changes['password'] = $hashedPassword;
                        $_SESSION['user']->setPassword($hashedPassword);
                    }
                }

                if($post['login'] != $user->getLogin()){
                    $changes['login'] = $post['login'];
                    $_SESSION['user']->setLogin($post['login']);
                }
                
                if($post['fullname'] != $user->getFullName()){
                    $changes['fullname'] = $post['fullname'];
                    $_SESSION['user']->setFullName($post['fullname']);
                }

                if($post['phone'] != $user->getPhone()){
                    $changes['phone'] = $post['phone'];
                    $_SESSION['user']->setPhone($post['phone']);
                }

                if(!empty($changes)){
                    $request = new UserModel();
                    $data = $request->requestUpdate($idUser, $changes);
                    $this->msg = "<p>Les changements ont été effectués.</p>";
                }else{
                    $this->msg = "<p class='error'>Rien n'a été changé.</p>";
                }


            }else{
                $this->msg = "<p class='error'>Le mot de passe est faux</p>";
            }
        }else{
            $this->msg = "<p class='error'>Remplir tous les champs.</p>";
        }

    }

    public function disConnect(){
        session_unset();
        session_destroy();
            
        header("location: index.php");
    }


    ##################################################################################
    ######################################## Admin ###################################
    ##################################################################################

    function GetAllData(){
        $request = new UserModel();
        $data = $request->requestGetAllData();

        return $data;
    }


    function DeleteUser($id){
        $request = new UserModel();
        $data = $request->requestDeleteUser($id);
    }

    ##################################################################################
    ######################################## Getters #################################
    ##################################################################################


    public function getId(){
        return $this->id;
    }

    public function getLogin(){
        return $this->login;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getFullName(){
        return $this->fullname;
    }

    public function getPhone(){
        return $this->phone;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getMsg(){
        return $this->msg;
    }


    ##################################################################################
    ######################################## Setters #################################
    ##################################################################################


    public function setId($id){
        $this->id = $id;
    }

    public function setLogin($login){
        $this->login = $login;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function setFullName($fullname){
        $this->fullname = $fullname;
    }

    public function setPhone($phone){
        $this->phone = $phone;
    }

    public function setPassword($password){
        $this->password = $password;
    }

}