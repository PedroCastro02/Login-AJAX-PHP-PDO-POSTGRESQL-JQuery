<?php
error_reporting(0);
include '../connection/connection.php';
include 'UsuarioClass.php';


class UsuarioActions implements UsuarioDAO {

    private $pdo;

    public function __construct(PDO $driver) {
        $this->pdo =  $driver;
    }

    public function add(UsuarioClass $u) {
        $flag = 0;
        if ($this->usernameExists($u->getUsername())) {
            echo "Username ja esta em uso!";
            $flag = 2;
            return $flag;
        
        } elseif ($this->emailExists($u->getEmail())) {
            echo "Email ja esta em uso!";
            $flag = 1;
            return $flag;
        } elseif($flag == 2){
            echo "Username e Email ja estão em uso!";
        }else {
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
    }
    public function adicionarUsuario(UsuarioClass $u) {
        $flag = 0;
        if ($this->usernameExists($u->getUsername())) {
            echo "Username ja esta em uso!";
            $flag = 2;
            return $flag;
        
        } elseif ($this->emailExists($u->getEmail())) {
            echo "Email ja esta em uso!";
            $flag = 1;
            return $flag;
        } elseif($flag == 2){
            echo "Username e Email ja estão em uso!";
        }else {
            try {
                $hashedPassword = password_hash($u->getPassword(), PASSWORD_BCRYPT);
                $sql = "INSERT INTO users (email, username, password, id_company, id_person, id_profile) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$u->getEmail(), $u->getUsername(), $hashedPassword, $u->getId_Company(), $u->getId_Person(), $u->getId_Profile()]);
                echo "Usuário cadastrado com sucesso!";
            } catch (PDOException $e) {
                echo "Erro ao cadastrar usuário";
            }
        }
    }
    
    public function findAll(){
        $usuarios = array();
        $resultado = $this->pdo->query("SELECT * FROM users");
        
        while ($row = $resultado->fetchAll()) {
            $u = new UsuarioClass();
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

    public function update(UsuarioClass $u){
        $sql = "UPDATE users SET email=?, username=?, password=?, id_company=?, id_person=?, id_profile=? WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["ssssssi", $u->getEmail(), $u->getUsername(), $u->getPassword(), $u->getId_Company(), $u->getId_Person(), $u->getId_Profile(), $u->getId()]);
    }
    public function delete(UsuarioClass $id){
        return true;
    }
    public function deleteUsuario(UsuarioClass $id){
        echo json_encode(["message" => "chegou aqui"]);
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $idValue = $id->getId();
            $stmt->bindParam(':id', $idValue);
            $stmt->execute();
            echo "Usuário Deletado";
        } catch(PDOException $e) {
            echo "Erro ao Excluir Usuário: " . $e->getMessage();
        }
    }

    private function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    private function usernameExists($username) {
        $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }   
}
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['action']) && $data['action'] === 'saveRecords') {
            $usuarioDAO = new UsuarioActions($pdo); 

            $usuario = new UsuarioClass();
            $usuario->setEmail($data['email']);
            $usuario->setUsername($data['username']);
            $usuario->setPassword($data['password']);
            $usuario->setId_Company($data['id_company']);
            $usuario->setId_Profile($data['id_profile']);
            $usuario->setId_Person($data['id_person']);

            $usuarioDAO->add($usuario);
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['action']) && $data['action'] === 'saveUsuarios') {
            $usuarioDAO = new UsuarioActions($pdo); 

            $usuario = new UsuarioClass();
            $usuario->setEmail($data['email']);
            $usuario->setUsername($data['username']);
            $usuario->setPassword($data['password']);
            $usuario->setId_Company($data['id_company']);
            $usuario->setId_Profile($data['id_profile']);
            $usuario->setId_Person($data['id_person']);

            $usuarioDAO->adicionarUsuario($usuario);
        } else if (isset($data['action']) && $data['action'] === 'deleteUsuario' ) {
            $usuarioDAO = new UsuarioActions($pdo); 
            $usuario = new UsuarioClass();
            $usuario->setId($data['id']); 
            $usuarioDAO->deleteUsuario($usuario);
        }  
    }

?>
