<?php

class Conexao{
	/**
	* Método que estabelece uma conexão com o banco de dados
	* @version 1
	* @author Cândido Farias
	**/
	public static function getConexao(){
		/*String com informações do banco de dados*/
		$str_database="mysql:host=localhost;dbname=chat";
		/*Usuário utilizado para conectar no banco de dados*/
		$user="root";
		/*Senha para conexão no banco de dados*/
		$pass="";
		try{
			/*Conexão com o banco de dados*/
			$pdo = new PDO($str_database, $user, $pass);
			return $pdo;
		}catch(PDOException $ex){
			/*Exibe a mensagem de erro retornada na tentativa de conexao*/
			echo "ERRO:".$ex->getMessage();
			return false;
		}
	}
}