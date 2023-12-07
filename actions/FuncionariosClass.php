<?php


class FuncionarioClass {
    private $id;
    private $id_person;
    private $dt_hiring;
    private $fiscal_wage;
    private $real_wage;
    private $position;
    private $id_shift;
    private $balance_of_hours;
//!=========================Functions Funcionario====================================
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
       $this->id = $id;
    }
//*------------------------------------------
    public function getId_person() {
        return $this->id_person;
    }
    public function setId_person($n) {
       $this->id_person = $n;
    }
//*------------------------------------------
    public function getDt_hiring() {
        return $this->dt_hiring;
    }
    public function setDt_hiring($dt) {
       $this->dt_hiring = $dt;
    }
//*------------------------------------------
    public function getfiscal_wage() {
        return $this->fiscal_wage;
    }
    public function setfiscal_wage($Fw) {
       $this->fiscal_wage = $Fw;
    }
//*------------------------------------------
    public function getReal_wage() {
        return $this->real_wage;
    }
    public function setReal_wage($Rw) {
       $this->real_wage = $Rw;
    }
//*------------------------------------------
    public function getPosition() {
        return $this->position;
    }
    public function setPosition($pos) {
       $this->position = $pos;
    }
//*------------------------------------------
    public function getBalance_of_hours() {
        return $this->balance_of_hours;
    }
    public function setBalance_of_hours($Bh) {
        $this->balance_of_hours = $Bh;
    }
//*------------------------------------------
    public function getId_shift() {
        return $this->id_shift;
    }
    public function setId_shift($s) {
       $this->id_shift = $s;
    }
    
}

Interface FuncionarioDAO {
    public function adicionarFuncionario(FuncionarioClass $u);
    public function findAll();
    public function findById($id);
    public function update(FuncionarioClass $u);
    public function delete(FuncionarioClass $id);
}