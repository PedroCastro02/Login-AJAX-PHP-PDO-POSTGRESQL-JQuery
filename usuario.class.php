<?php
header('Content-Type: application/json');
require 'config.php';

class Usuario{

    private $id;
    private $email;
    private $username;
    private $password;
    private $id_company;
    private $id_profile;
    private $id_person;

    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }
// ----------------------------
    public function setEmail($email){
        $this->email = $email;
    }
    public function getEmail(){
        return $this->email;
    }
// ----------------------------
    public function setUsername($username){
        $this->username = $username;
    }
    public function getUsername(){
        return $this->username;
    }
// ----------------------------
    public function setPassword($password){
        $this->password = $password;
    }
    public function getPassword(){
        return $this->password;
    }
// ----------------------------
    public function setId_company($id_company){
        $this->id_company = $id_company;
    }
    public function getId_company(){
        return $this->Id_company;
    }
// ----------------------------
    public function setId_person($Id_person){
        $this->Id_person = $Id_person;
    }
    public function getId_person(){
        return $this->Id_person;
    }
// ----------------------------
    public function setId_profile($Id_profile){
        $this->Id_profile = $Id_profile;
    }
    public function getId_profile(){
        return $this->Id_profile;
    }
    
    public function Insert(){

        $sql = $pdo->prepare('INSERT INTO users (email, username, password, id_profile, id_company, id_person) VALUES (:email, :username, :password, :id_profile, :id_company, :id_person)');
        $sql->bindValue(':email', $email);
        $sql->bindValue(':password', $password);
        $sql->bindValue(':username', $username);
        $sql->bindValue(':id_profile', $id_profile);
        $sql->bindValue(':id_company', $id_company);
        $sql->bindValue(':id_person', $id_person);
        if ($sql->execute()) {
            echo json_encode("Usuario cadastrado com sucesso!");
            
        } else {
            echo json_encode("Erro ao cadastrar usuario");
        }
    
    }   

}

if (isset($_POST)) {
    $usuario = new Usuario();
    $data = $_POST['data'];
            

    switch ($_POST["action"]) {
        case 'saveRecords':
            $usuario->setEmail($data['email']);
            $usuario->setPassword($data['password']);
            $usuario->setUsername($data['username']);
            $usuario->setId_company($data['id_company']);
            $usuario->setId_profile($data['id_profile']);
            $usuario->setId_person($data['id_person']);
            $usuario->Insert();
            break;

        default:
            echo "erro";
            break;
    }
} else {
    echo "erro 2";
}
