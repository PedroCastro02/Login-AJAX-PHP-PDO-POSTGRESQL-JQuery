<?php
error_reporting(0);
include '../connection/connection.php';
include 'Usuario.php';


class Funcionarios implements UsuarioDAO {

    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo =  $driver;
    }

    public function add(Usuario $u) {
        
            try {
                $hashedPassword = password_hash($u->getPassword(), PASSWORD_BCRYPT);
                $sql = "INSERT INTO users (email, username, password, id_company, id_person, id_profile) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$u->getEmail(), $u->getUsername(), $hashedPassword, $u->getId_Company(), $u->getId_Person(), $u->getId_Profile()]);
                echo "Usuário cadastrado com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar usuário: " . $e->getMessage();
            
        }
    }
    
    public function findAll(){
        $usuarios = array();
        $resultado = $this->pdo->query("SELECT * FROM users");
        
        while ($row = $resultado->fetchAll()) {
            $u = new Usuario();
            $u->setId($row['id']);
            $u->setEmail($row['email']);
            $u->setUsername($row['username']);
            $u->setPassword($row['password']);
            $u->setId_Company($row['id_company']);
            $u->setId_Person($row['id_person']);
            $u->setId_Profile($row['id_profile']);
            $usuarios[] = $u;
        }

        return $usuarios;
    }


    public function findById($id) {
        
    }

    public function update(Usuario $u){
        $sql = "UPDATE users SET email=?, username=?, password=?, id_company=?, id_person=?, id_profile=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["ssssssi", $u->getEmail(), $u->getUsername(), $u->getPassword(), $u->getId_Company(), $u->getId_Person(), $u->getId_Profile(), $u->getId()]);
    }
    
    public function delete(Usuario $id){
      
    }

    
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['action']) && $data['action'] === 'saveRecords') {
            $usuarioDAO = new UsuarioDAOPgSQL($pdo); 

            $usuario = new Usuario();
            $usuario->setEmail($data['email']);
            $usuario->setUsername($data['username']);
            $usuario->setPassword($data['password']);
            $usuario->setId_Company($data['id_company']);
            $usuario->setId_Profile($data['id_profile']);
            $usuario->setId_Person($data['id_person']);

            $usuarioDAO->add($usuario);
        }
    }

?>
