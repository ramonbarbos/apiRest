<?php

namespace Repository;

use DB\MySQL;

class CidadeRepository
{
    private object $MySQL;
    public const TABELA = 'cidade';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertUser($dados){
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (nm_cidade, estado) VALUES (:nm_cidade, :estado)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':nm_cidade', $dados['nm_cidade']);
        $stmt->bindParam(':estado', $dados['estado']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados){
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET nm_cidade = :nm_cidade, estado = :estado WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nm_cidade', $dados['nm_cidade']);
        $stmt->bindParam(':estado', $dados['estado']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }
}