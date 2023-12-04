<?php


class UsuarioClass {
    private $id;
    private $email;
    private $username;
    private $password;
    private $id_company;
    private $id_profile;
    private $id_person;
//!=========================Functions User====================================
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
       $this->id = trim($id);
    }
//------------------------------------------
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($e) {
       $this->email = strtolower(trim($e));
    }
//------------------------------------------
    public function getUsername() {
        return $this->username;
    }
    public function setUsername($n) {
       $this->username = ucwords(trim($n));
    }
//------------------------------------------
    public function getPassword() {
        return $this->password;
    }
    public function setPassword($p) {
       $this->password = (trim($p));
    }
//------------------------------------------
    public function getId_company() {
        return $this->id_company;
    }
    public function setId_company($c) {
       $this->id_company = $c;
    }
//------------------------------------------
    public function getId_profile() {
        return $this->id_profile;
    }
    public function setId_profile($prof) {
       $this->id_profile = $prof;
    }
//------------------------------------------
    public function getId_person() {
        return $this->id_person;
    }
    public function setId_person($pers) {
    $this->id_person = $pers;
    }
    
}

Interface UsuarioDAO {
    public function add(UsuarioClass $u);
    public function findAll();
    public function findById($id);
    public function update(UsuarioClass $u);
    public function delete(UsuarioClass $id);
}