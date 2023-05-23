<?php

namespace Repository;

use DB\MySQL;

class FuncionarioRepository
{
    private object $MySQL;
    public const TABELA = 'funcionario';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertUser($nm_funcionario, $nm_cargo, $login){
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (nm_funcionario, nm_cargo, login) VALUES (:nm_funcionario, :nm_cargo, :login)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':nm_funcionario', $nm_funcionario);
        $stmt->bindParam(':nm_cargo', $nm_cargo);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados){
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET nm_funcionario = :nm_funcionario, nm_cargo = :nm_cargo, login = :login  WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':nm_funcionario', $dados['nm_funcionario']);
        $stmt->bindValue(':nm_cargo', $dados['nm_cargo']);
        $stmt->bindValue(':login', $dados['login']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }
}