<?php

namespace Classes;

require 'Conexao.php';
use Classes\Conexao;
use JsonException;

class Usuario
{

    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConexao();
    }

    public function listar()
    {

        $sql = "SELECT * FROM usuario;";
        $q = $this->conexao->prepare($sql);
        $q->execute();
         return $q;
    }
    public function UmUsuario($codigo)
    {
       // $sql = "SELECT codigo,nome,email,login FROM usuario WHERE
      //  codigo = :codigo;";
        $sql = "SELECT codigo,nome,email,login FROM usuario WHERE
        codigo = :codigo;";
        $q = $this->conexao->prepare($sql);
        $q->bindParam(1, $codigo);
        $q->execute();
        return $q;
    }

    public function inserir($nome, $email, $login, $senha)
    {

        $sql = "INSERT INTO usuario (nome, email, login, senha) VALUES (?, ?, ?, ?);";
        $q = $this->conexao->prepare($sql);

        $senha = md5($senha);

        $q->bindParam(1, $nome);
        $q->bindParam(2, $email);
        $q->bindParam(3, $login);
        $q->bindParam(4, $senha);
        $q->execute();

    }
    public function editar($codigo, $nome, $email, $login, $senha)
    {

        $sql = "UPDATE usuario SET nome=?, email=?, login=?, senha=? WHERE codigo =? ;";
        $q = $this->conexao->prepare($sql);
        $senha = md5($senha);
        $q->bindParam(1, $nome);
        $q->bindParam(2, $email);
        $q->bindParam(3, $login);
        $q->bindParam(4, $senha);
        $q->bindParam(5, $codigo);
        $q->execute();
    }
    public function delete($codigo)
    {
        $sql = "DELETE FROM usuario WHERE codigo = ?;";
        $q = $this->conexao->prepare($sql);
        $q->bindParam(1, $codigo);
        $q->execute();
    }
  public function __toString()
  {
      return json_encode(Array(
         "codigo"=>$this->codigo,
         "nome"=>$this->nome,
         "email"=>$this->email,
         "login"=>$this->login
      ));
  }


}
