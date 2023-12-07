<?php 
include '../connection/connection.php';
include 'PessoasClass.php';

class PessoasAction implements PessoasDAO {
    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo =  $driver;
    }
    
    public function adicionarPessoa(PessoasClass $p){
        try {
            
            $sqlPeople = "INSERT INTO people (name, person_type, document, id_company,telephone , dt_birth) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtPeople = $this->pdo->prepare($sqlPeople);
            $stmtPeople->execute([$p->getNome(), $p->getPerson_type(), $p->getDocument(), $p->getId_company(), $p->getTelephone(), $p->getDt_birth()]);
            $lastInsertedId = $this->pdo->lastInsertId();       
        
            $sqlAddress = "INSERT INTO addresses (zip_code, street, number, district, complement ,city, id_person, state) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtAddress = $this->pdo->prepare($sqlAddress); 
            $stmtAddress->execute([$p->getZip_code(), $p->getStreet(), $p->getNumber(), $p->getDistrict(), $p->getComplement(), $p->getCity(), $lastInsertedId, $p->getState()]);       
            
            $sqlEmail = "INSERT INTO emails ( email, id_person ) VALUES ( ?, ?)";
            $stmtEmail = $this->pdo->prepare($sqlEmail);
            $stmtEmail->execute([$p->getEmail(), $lastInsertedId]);       


        } catch (PDOException $e) {
            echo "Erro AdicionarPessoa" . $e->getMessage();
        }
    }
    
        // echo '<prev>';
        // print_r($u->getId_person());
        // echo '</prev>';
        // die();
    public function findAll(){
       
    }

    public function findById($id) {
        
    }

    public function updatePessoa(PessoasClass $u){
       
    }
    
    public function deletePessoa(PessoasClass $id){
    //     $dataAtual = date("Y-m-d");
    //     try {
    //         $sql = "UPDATE employees SET deleted_at = '$dataAtual' WHERE id = :id";
    //         $stmt = $this->pdo->prepare($sql);
    //         $idValue = $id->getId();
    //         $stmt->bindParam(':id', $idValue);
    //         $stmt->execute();
    //         echo "Funcionario Deletado";
            
    //     } catch(PDOException $e) {
    //         echo "Erro ao Excluir funcionario: " . $e->getMessage();
    //     }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $data = json_decode(file_get_contents('php://input'), true); 
        
        
        if (isset($data['action']) && $data['action'] === 'savePessoas') {
            $pessoasDAO = new PessoasAction($pdo); 
            $pessoas = new PessoasClass();
            $pessoas->setNome($data['name']);
            $pessoas->setPerson_type($data['person_type']);
            $pessoas->setDocument($data['document']);
            $pessoas->setTelephone($data['telephone']);
            $pessoas->setDtBirth($data['dt_birth']);
            $pessoas->setZip_code($data['zip_code']);
            $pessoas->setStreet($data['street']); 
            $pessoas->setNumber($data['number']); 
            $pessoas->setDistrict($data['district']); 
            $pessoas->setComplement($data['complement']); 
            $pessoas->setCity($data['city']); 
            $pessoas->setState($data['state']);
            $pessoas->setEmail($data['email']); 
            $pessoas->setId_company($data['id_company']); 
          
            $pessoasDAO->adicionarPessoa($pessoas);
        }
        // } else if (isset($data['action']) && $data['action'] === 'deleteFuncionario' ) {
        //     $funcionarioDAO = new FuncionariosAction($pdo); 
        //     $funcionario = new FuncionarioClass();
        //     $funcionario->setId($data['id']); 
        //     $funcionarioDAO->delete($funcionario);
        // }  

    } 