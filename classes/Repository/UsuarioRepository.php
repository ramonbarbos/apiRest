<?php

namespace Repository;

use DB\MySQL;

class UsuarioRepository
{
    private object $MySQL;
    public const TABELA = 'usuarios';

    /**
     * UsuariosRepository constructor.
     */
    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertUser($dados){
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (login, senha, nome ,cidade) VALUES (:login, :senha, :nome, :cidade)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':login', $dados['login']);
        $stmt->bindParam(':senha', $dados['senha']);
        $stmt->bindParam(':nome', $dados['nome']);
       // $stmt->bindParam(':foto', $dados['foto']);
        $stmt->bindParam(':cidade', $dados['cidade']);
        //$stmt->bindParam(':funcionario_id', $dados['funcionario_id']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados){
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET login = :login, senha = :senha, nome = :nome, foto = :foto ,cidade = :cidade,funcionario_id = :funcionario_id WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':login', $dados['login']);
        $stmt->bindParam(':senha', $dados['senha']);
        $stmt->bindParam(':nome', $dados['nome']);
        $stmt->bindParam(':foto', $dados['foto']);
        $stmt->bindParam(':cidade', $dados['cidade']);
        $stmt->bindParam(':funcionario_id', $dados['funcionario_id']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function loginUser($login, $senha){
        $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE login = :login AND senha = :senha AND ativo = "s" ';
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();
        
        return $stmt->fetch();

    }
    public function getMySQL()
    {
        return $this->MySQL;
    }
}