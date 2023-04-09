<?php 

    require_once("models/User.php");
    require_once("models/Message.php");

    class UserDAO implements UserDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildUser($data) {
            
            $user = new User();

            $user->id = $data["id"];
            $user->name = $data["name"];
            $user->lastname = $data["lastname"];
            $user->email = $data["email"];
            $user->password = $data["password"];
            $user->image = $data["image"];
            $user->bio = $data["bio"];
            $user->token = $data["token"];

            return $user;

        }

        public function create(User $user, $authUser = false) {

            $stmt = $this->conn->prepare(
                "INSERT INTO users(name, lastname, email, password, token) 
                VALUES (:name, :lastname, :email, :password, :token)");
            
            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":lastname", $user->lastname);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":password", $user->password); // password modificado e declarado com finalPassowrd
            $stmt->bindParam(":token", $user->token); // token já criado e declarado com a func generateToken()

            $stmt->execute();

            // Autenticar usuário caso auth seja true
            if($authUser) {
                $this->setTokenToSession($user->token);
            }

        }

        public function update(User $user) {

        }

        public function verifyToken($protected = false) {

            if(!empty($_SESSION["token"])) {

                // Resgata token da session
                $token = $_SESSION["token"];

                $user = $this->findByToken($token);

                // Se for retornado um usuário com o token resgatado acima
                if($user) {
                    return $user;
                } else if($protected) {

                    // O usuário tentou fazer login mas o token não foi encontrado
                    $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
                    
                }
                
            } else if($protected) {
                // Se não houver token na session, o usuário não está autenticado
                $this->message->setMessage("Faça a autenticação para acessar esta página!", "error", "index.php");
            }

        }

        public function setTokenToSession($token, $redirect = true) {

            // Salvar token na session
            $_SESSION["token"] = $token;

            if($redirect) {

                // Redireciona para o perfil do usuário
                $this->message->setMessage("Seja bem-vindo!", "success", "editprofile.php");

            }

        }

        public function authenticateUser($email, $password) {

        }

        public function findByEmail($email) {

            // Caso o email tenha sido declarado executamos o statement
            if($email != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                // Caso o stmt retorne uma row com o email declarado
                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {
                    return false;
                }

            } else {
                return false;
            }

        }

        public function findById($id) {

        }

        public function findByToken($token) {

            // Mesma lógica da func findByEmail
            if($token != "") {

                $stmt = $this->conn->prepare("SELECT * FROM users WHERE token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                // Caso o stmt retorne uma row com o token declarado
                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildUser($data);

                    return $user;

                } else {
                    return false;
                }

            } else {
                return false;
            }
            

        }

        public function destroyToken() {
            // Remove o token da session
            $_SESSION["token"] = "";

            // Redirecionar usuário e mostrar mensagem de sucesso de logout
            $this->message->setMessage("Você fez o logout!", "success", "index.php");
        }

        public function changePassword(User $user) {

        }

    }