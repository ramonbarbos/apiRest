<?php

namespace Repository;

use DB\MySQL;

class ServicoRepository
{
    private object $MySQL;
    public const TABELA = 'servico';

    /**
     * UsuariosRepository constructor.
     */
    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertUser($nm_servico, $valor){
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (nm_servico, valor) VALUES (:nm_servico, :valor)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':nm_servico', $nm_servico);
        $stmt->bindParam(':valor', $valor);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados){
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET nm_servico = :nm_servico, valor = :valor WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':nm_servico', $dados['nm_servico']);
        $stmt->bindValue(':valor', $dados['valor']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    
    public function getMySQL()
    {
        return $this->MySQL;
    }
}