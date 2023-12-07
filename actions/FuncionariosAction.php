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

        // echo '<prev>';
        // print_r($u->getId_person());
        // echo '</prev>';
        // die();
    
        try {
            $sql = "INSERT INTO employees (id_person, position, dt_hiring, real_wage , fiscal_wage, id_shift) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$u->getId_person(), $u->getPosition(), $u->getDt_hiring(), $u->getfiscal_wage(), $u->getReal_wage(),$u->getId_shift()]);       
            echo "Funcionário adicionado com sucesso!!";
        } catch (PDOException $e) {
            echo "Erro ao adicionar funcionário";
        }
    }
    
    public function findAll(){
       
    }

    public function findById($id) {
        
    }

    public function update(FuncionarioClass $u){
       
    }
    
    public function delete(FuncionarioClass $id){
        $dataAtual = date("Y-m-d");
        try {
            $sql = "UPDATE employees SET deleted_at = '$dataAtual' WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $idValue = $id->getId();
            $stmt->bindParam(':id', $idValue);
            $stmt->execute();
            echo "Funcionario Deletado";
            
        } catch(PDOException $e) {
            echo "Erro ao Excluir funcionario: " . $e->getMessage();
        }
    }

    
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true); 
        if (isset($data['action']) && $data['action'] === 'saveFuncionarios') {
            $funcionarioDAO = new FuncionariosAction($pdo); 
            $funcionario = new FuncionarioClass();
            $funcionario->setId($data['id']);
            $funcionario->setId_person($data['id_person']);
            $funcionario->setId_shift($data['id_shift']);
            $funcionario->setDt_hiring($data['dt_hiring']);
            $funcionario->setfiscal_wage($data['fiscal_wage']);
            $funcionario->setReal_wage($data['real_wage']);
            $funcionario->setPosition($data['position']);
            $funcionario->setBalance_of_hours($data['balance_of_hours']); //!======Balance_of_hours não tem input======


            $funcionarioDAO->adicionarFuncionario($funcionario);

        } else if (isset($data['action']) && $data['action'] === 'deleteFuncionario' ) {
            $funcionarioDAO = new FuncionariosAction($pdo); 
            $funcionario = new FuncionarioClass();
            $funcionario->setId($data['id']); 
            $funcionarioDAO->delete($funcionario);
        }  

    } 
    

?>
