<?php

namespace Repository;

use DB\MySQL;

class AgendaRepository
{
    private object $MySQL;
    public const TABELA = 'agenda';

    /**
     * UsuariosRepository constructor.
     */
    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function insertUser($id_funcionario, $id_usuario,$data_hora,$id_servico){
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (id_funcionario, id_usuario, data_hora, id_servico) VALUES (:id_funcionario, :id_usuario,:data_hora,:id_servico)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':id_funcionario', $id_funcionario);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':data_hora', $data_hora);
        $stmt->bindParam(':id_servico', $id_servico);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados){
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET id_funcionario = :id_funcionario, id_usuario = :id_usuario, data_hora = :data_hora, id_servico = :id_servico WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':id_funcionario', $dados['id_funcionario']);
        $stmt->bindValue(':id_usuario', $dados['id_usuario']);
        $stmt->bindValue(':data_hora', $dados['data_hora']);
        $stmt->bindValue(':id_servico', $dados['id_servico']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    
    public function getMySQL()
    {
        return $this->MySQL;
    }
}