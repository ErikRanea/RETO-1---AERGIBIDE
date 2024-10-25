<?php
class Usuario{

    private $tabla = "Usuarios";
    private $connection;
    public $id;
    public $nombre;
    public $email;
    public $foto_perfil;

    public function __construct()
    {
        $this -> getConnection();
    }

    public function getConnection(){
        $dbObj = new db();
        $this -> connection = $dbObj ->connection;
    }

    public function getUsuarioById($id_usuario)
    {
        $sql = "SELECT * FROM ".$this->tabla. " WHERE id=?";
        $stmt = $this -> connection ->prepare($sql);
        $stmt->execute([$id_usuario]);     
        return $stmt->fetch(); 
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

    public function getUsuarioByEmail($email)
    {
        $sql = "SELECT * FROM ".$this->tabla." WHERE email = ?";
        $stmt = $this-> connection ->prepare($sql);
        $stmt -> setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        $stmt -> execute([$email]);
        return $stmt ->fetch();
    }

    public function login($param)
    {
        // Sanitize POST

       // $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            /* Validación del token para prevenir inyección SQL */
      /*  $listaSQL = ["WHERE", "where", "AND", "and", "="];
        $limpio = true; // Cambié a true para evitar invertir la lógica después
        foreach($listaSQL as $strSQL) {
            foreach($post as $elementoPost)
            {
                if (strpos($elementoPost, $strSQL) !== false) {
                    $limpio = false;
                    break 2; // Salimos de ambos bucles
                }
            }
        } */

        //if (isset($post['submit']) && $limpio)

        $post = $param;


        if (isset($post))
        {
            $usuarioAlmacenado = $this->getUsuarioByEmail($post['email']);
          
            if(isset($usuarioAlmacenado->email) && password_verify($post["password"] , $usuarioAlmacenado->password))
            {
              
                return $usuarioAlmacenado;
            }
            else
                return;

        }

    }





}