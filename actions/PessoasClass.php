 <?php

class PessoasClass {
    private $id;
    private $nome;
    private $person_type;
    private $document;
    private $telephone;
    private $dt_birth;
    //!============Address===================
    private $zip_code;
    private $street;
    private $number;
    private $district;
    private $complement;
    private $city;
    private $state;
     //!============Email===================
    private $email;
    private $id_company;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
       $this->id = $id;
    }
    //* ------------------------------------
    public function getNome() {
        return $this->nome;
    }
    public function setNome($n){
        $this->nome=$n;
    }
    //* ------------------------------------
    public function getPerson_type() {
        return $this->person_type;
    }
    public function setPerson_type($pt){
        $this->person_type=$pt;
    }
    //* ------------------------------------
    public function getDocument(){
        return $this->document;
    }
    public function setDocument($d){
        $this->document=$d;
    }
    //* ------------------------------------
    public function getTelephone(){
        return $this->telephone;
    }
    public function setTelephone($t){
        $this->telephone=$t;
    }
    //* ------------------------------------
    public function getDt_birth(){
        return $this->dt_birth;
    }
    public function setDtBirth($db){
        $this->dt_birth=$db;
    }
    //? ---------------Address---------------------
    public function getZip_code() {
        return $this->zip_code;
    }
    public function setZip_code($zp) {
        $this->zip_code=$zp;
    }
    //* ------------------------------------
    public function getStreet() {
        return $this->street;
    }
    public function setStreet($s) {
        return $this->street=$s;
    }
    //* ------------------------------------
    public function getNumber() {
        return $this->number;
    }
    public function setNumber($num) {
        $this->number=$num;
    }
    //* ------------------------------------
    public function getDistrict() {
        return $this->district;
    }
    public function setDistrict($dis) {
        $this->district=$dis;
    }
    //* ------------------------------------
    public function getComplement() {
        return $this->complement;
    }
    public function setComplement($Com) {
        $this->complement=$Com;
    }
    //* ------------------------------------
    public function getCity() {
        return $this->city;
    }
    public function setCity($city) {
        $this->city=$city;
    }
    //* ------------------------------------
    public function getState() {
        return $this->state; 
    }
    public function setState($state) {
        $this->state=$state;
    }
    //? ----------------Email------------------
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email=$email;
    }
    //------------------------------
    public function getId_company() {
        return $this->id_company;
    }
    public function setId_company($id_company) {
        $this->id_company = $id_company;
    }
}

    Interface PessoasDAO {
        public function adicionarPessoa(PessoasClass $p);
        public function deletePessoa(PessoasClass $id);
        public function updatePessoa(PessoasClass $p);
        public function findAll();
        public function findById($id);

    } 