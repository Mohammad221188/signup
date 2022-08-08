<?php

class Auth extends Database {
    use Uploader;
    public function register(iterable $data){
        // alle Daten beim Anmeldung kriegen
        $firstname = filter_var($data['firstname'], FILTER_SANITIZE_STRING);
        $lastname = filter_var($data['lastname'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_STRING);
        $password = filter_var($data['password'], FILTER_SANITIZE_STRING);
        $password_confirm = filter_var($data['password_confirm'], FILTER_SANITIZE_STRING);

        // upload foto 
        if(isset($_FILES['photo'])){
            $photo_name = $this->photo_uploader($_FILES['photo']);
        }else{
            $photo_name = null;
        }

        // checken alle Passwörter
        if($password != $password_confirm) {
            $_SESSION['error'] = 'Deine Eingaben sind falsch!!!';
            return false;
        }
        // Password länge prüfen
        if(strlen($password) < 8 ) {
            $_SESSION['error'] = 'Deine Passwort ist zu kurz!!!';
            return false;
        }
        // prüfen ob Email format richtig ist 
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Die Email muss richtig geschrieben werden';
            return false;
        }
        // prüfen ob die Email schon existiert
        $sql = "SELECT email FROM users_tbl WHERE email = '$email'";
        $result = $this->connection->query($sql);
        if($result->num_rows > 0 ){
            $_SESSION['error'] = 'Die von dir eingegebene Emailadresse existiert schon';
            return false;
        }
        // Hashpasswort generieren
        $password = md5($password.$this->salt);
        
        // prüfen ob das Foto hochgeladen worden ist und danach alle daten in Datenbank einfügen
        if(isset($photo_name)){
            $sql2 = "INSERT INTO users_tbl (firstname, lastname, photo, email, password) VALUES ('$firstname','$lastname','$photo_name','$email','$password')";
       
        }else{
            $sql2 = "INSERT INTO users_tbl (firstname, lastname, email, password) VALUES ('$firstname','$lastname','$email','$password')";
       
        }
        if($this->connection->query($sql2) === true){
            $_SESSION['success'] = 'jetzt kannst du dich einloggen';
            return true;
        }else{
            $_SESSION['error'] = 'die Anmeldung ist leider gescheitert';
            return false;
        }
        
    }
    public function login($data) {
        $email = filter_var($data['email'], FILTER_SANITIZE_STRING);
        $password = filter_var($data['password'], FILTER_SANITIZE_STRING);

         // prüfen ob Email format richtig ist 
         if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Die Email muss richtig geschrieben werden';
            return false;
        }
        // prüfen ob die Email schon existiert
        $sql = "SELECT * FROM users_tbl";
        $result = $this->connection->query($sql);
        if($result->num_rows <= 0 ){
            $_SESSION['error'] = 'Du musst dich erstmal anmelden';
            return false;
        }
            $user = $result->fetch_assoc();
           
        
        // Hashpasswort generieren
        $password = md5($password.$this->salt);
        if($user['password'] != $password){
            $_SESSION['error'] = 'deine Eingaben sind falsch!!!';
        }
        unset($user['password']);

        // hinführen User zum index Seite
        header('Location: dashboard/index.php');die();
       
       
    }
}