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


    public function getUsuarios(){

        $sql = "SELECT * FROM ".$this->tabla;
        $stmt = $this -> connection ->prepare($sql);
        /*Esta linéa del FetchMode lo que hace es convertilo en objetos Usuario donde las columnas de la tabla
        son los atributos del mismo */
        $stmt ->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        $stmt->execute();
        return $stmt ->fetchAll(); 
    }

}