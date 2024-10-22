<?php
class Usuario{

    private $tabla = "Usuarios";
    private $connection;


    public function __construct()
    {
        $this -> getConnection();
    }

    public function getConnection(){
        $dbObj = new db();
        $this -> connection = $dbObj ->conection;
    }



    public function insertUsuario($param)
    {

        // Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            /* Validación del token para prevenir inyección SQL */
        $listaSQL = ["WHERE", "where", "AND", "and"];
        $limpio = true; // Cambié a true para evitar invertir la lógica después
        foreach($listaSQL as $strSQL) {
            foreach($post as $elementoPost)
            {
                if (strpos($elementoPost, $strSQL) !== false) {
                    echo "Es falso";
                    $limpio = false;
                    break;
                }
            }
            
        }

        if (isset($post) && $limpio)
        {
            if ($post['email'] == '' ||
            $post['password'] == '') {
            return;
            }

            $passwordHaseada = password_hash($post["password"], PASSWORD_DEFAULT);
            
            $stmt = $this -> connection -> prepare("INSERT INTO ".$this->tabla." ( email,
            nombre, password, username, rol, foto_perfil ) VALUES (:email, :nombre, :password,
            :username, :rol, :foto_perfil)");

            $stmt -> execute([
                ':email' => isset($post['email']) ? $post['email'] : "",
                ':nombre' => isset($post["nombre"]) ? $post["nombre"] : "",
                ':password' => isset($passwordHaseada) ? $passwordHaseada : "",
                ':username' => isset($post['username']) ? $post['username'] : "",
                ':rol' => isset($post['rol']) ? $post['rol'] : "",
                ':foto_perfil' => isset($post['foto_perfil']) ? $post['foto_perfil'] : ""
            ]);


        }


    }

    public function getUsuarios(){

        $sql = "SELECT * FROM ".$this->tabla;
        $stmt = $this -> connection ->prepare($sql);
        /*Esta linéa del FetchMode lo que hace es convertilo en objetos Usuario donde las columnas de la tabla
        son los atributos del mismo */
        $stmt ->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        $stmt->execute();
        return $stmt ->fetchAll(); 
    }

    public function getUsuarioByEmailAndPassword($email,$password)
    {
        $sql = "SELECT * FROM ".$this->tabla." WHERE email = ? AND password = ?";
        $stmt = $this-> connection ->prepare($sql);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        $stmt -> execute([$email],[$password]);
        return $stmt ->fetch();
    }

    public function login($param)
    {
        // Sanitize POST
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            /* Validación del token para prevenir inyección SQL */
        $listaSQL = ["WHERE", "where", "AND", "and", "="];
        $limpio = true; // Cambié a true para evitar invertir la lógica después
        foreach($listaSQL as $strSQL) {
            if (strpos($post, $strSQL) !== false) {
                $limpio = false;
                break;
            }
        }

        if (isset($post['submit']) && $limpio)
        {
            $usuarioAlmacenado = $this->getUsuarioByEmailAndPassword($post['email'],$post['password']);


        }

    }



}