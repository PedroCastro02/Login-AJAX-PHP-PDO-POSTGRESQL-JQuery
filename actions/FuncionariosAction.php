<?php
error_reporting(0);
include '../connection/connection.php';
include 'FuncionariosClass.php';


class FuncionariosAction implements FuncionarioDAO {

    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo =  $driver;
    }

    public function adicionarFuncionario(FuncionarioClass $u) {
        try {
            $sql = "INSERT INTO employees (id_person, position, dt_hiring, real_wage , fiscal_wage, id_shift) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$u->getId_person(), $u->getPosition(), $u->getDt_hiring(), $u->getfiscal_wage(), $u->getReal_wage(),$u->getId_shift()]);
            echo "Funcionario adicionado com sucesso";
        } catch (PDOException $e) {
            echo "Erro ao adicionar funcionario: " . $e->getMessage();
        }
    }
    
    public function findAll(){
       
    }


    public function findById($id) {
        
    }

    public function update(FuncionarioClass $u){
       
    }
    
    public function delete(FuncionarioClass $id){
      
    }

    
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['action']) && $data['action'] === 'saveFuncionarios') {
            $funcionarioDAO = new FuncionariosAction($pdo); 

            $funcionario = new FuncionarioClass();
            $funcionario->setId($data['id']);
            $funcionario->setId_person($data['id_person']);
            $funcionario->setDt_hiring($data['dt_hiring']);
            $funcionario->setfiscal_wage($data['fiscal_wage']);
            $funcionario->setReal_wage($data['real_wage']);
            $funcionario->setPosition($data['position']);
            $funcionario->setBalance_of_hours($data['balance_of_hours']);


            $funcionarioDAO->adicionarFuncionario($funcionario);
        }
    }

?>
