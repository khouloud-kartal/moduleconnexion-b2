<?php

class UserModel{

    private $connect;

    public function __construct(){
        try {
            $this->connect = new \PDO('mysql:host=localhost;dbname=moduleconnexion', 'root', '');
        } catch (PDOException $e) {
            var_dump($e->getMessage()) ;
        }
    
        return $this->connect;
        
    }

    public function requestCheckEmail($email){
        $request = $this->connect->prepare("SELECT * FROM users WHERE email = :email");
        $request->execute([':email' => $email]);
        $data = $request->rowCount();

        return $data;
    }

    public function requestRegister($login, $email, $fullname, $phone, $password){
        $request = $this->connect->prepare("INSERT INTO users (login, email, fullname, phone, password) VALUES (:login, :email, :fullname, :phone, :password)");
        $request->execute([':login' => $login,
                            ':email' => $email,
                            ':fullname' => $fullname,
                            ':phone' => $phone,
                            ':password' => $password
        ]);

        return $request;
    }

    public function requestGetDataMail($email){
        $request = $this->connect->prepare("SELECT * FROM users WHERE email = :email");
        $request->execute([':email' => $email]);

        $data = $request->fetch(\PDO::FETCH_ASSOC);
        return $data;
    }

    public function requestUpdate($id, $changes){

        $strRequest = "Update users SET";

        foreach ($changes as $key => $value) {
            $strRequest = $strRequest . " `$key` = :$key,";
        }

        $strRequest = rtrim($strRequest, ','); // suprimer la virgule finale
        $strRequest = $strRequest . " " . "WHERE id = $id";

        $request = $this->connect->prepare($strRequest);

        var_dump($request);
        var_dump($changes);
        $request->execute($changes);
    }

    public function requestGetAllData(){
        $request = $this->connect->prepare("SELECT * FROM users");
        $request->execute();

        $data = $request->fetchAll(\PDO::FETCH_ASSOC);

        return $data;
    }

}
