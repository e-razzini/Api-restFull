<?php

//Dependências
require './Classes/Usuario.php';
use Classes\Usuario;
/* API RESTFul em PHP puro */
//Informa para o cliente que será retornado JSON
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
//Captura os parâmetros
$param = filter_input_array(INPUT_GET, FILTER_DEFAULT);
//Captura o método de requisição
$method = $_SERVER ['REQUEST_METHOD'];
//Captura os dados enviados no body
$body = file_get_contents('php://input');
if      ($method == "GET") 
   {
   //um usuario
     $usu = new Usuario();
     if (isset($param ['codigo'])) {              
      $row = $usu->UmUsuario($param['codigo']);
      $usuario = [];
      foreach ($row as $info) {
      unset($info[0]);
      unset($info[1]);
      unset($info[2]);
      unset($info[3]);
      unset($info[4]);
      unset($info['senha']);
      $usuario[] = $info;   
      } 
     
     echo json_encode( $usuario);

    } else {

       //varios usuarios
        $usu = new Usuario();
        $resultado = $usu->listar();                                                
        $usuarios = [];
        
        foreach ($resultado as $info)
         {
            Unset($info[0]); 
            Unset($info[1]); 
            Unset($info[2]); 
            Unset($info[3]); 
            Unset($info[4]); 
            Unset($info['senha']);             
            $usuarios []= $info;       
         }
       
           echo json_encode($usuarios);         
        }
    }
else if ($method == "POST") 
   { 
        
    //inserindo usuarios    
    $usuario = json_decode($body);
    $usu = new Usuario();    
    $usu->inserir($usuario->nome, $usuario->email, $usuario->login, $usuario->senha);
    echo json_encode($usuario);    
   } 
else if ($method == "PUT") 
   {
  //update
  $usu = new Usuario();
  if(isset($param->codigo)){
    $usuario =json_decode($body);            
    $usu->editar($param->codigo,$usuario->nome, $usuario->email, $usuario->login, $usuario->senha);        
    echo json_encode($usu);
  }
 } 

else if ($method == "DELETE") 

 {
     $usu = new Usuario();
     $usu->delete($param['codigo']);
     return $usu->listar();

 }
?>
