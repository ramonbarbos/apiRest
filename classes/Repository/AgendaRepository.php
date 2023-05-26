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

    public function insertUser($dados){
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (id_funcionario, id_usuario, data_hora, id_servico,valor) VALUES (:id_funcionario, :id_usuario,:data_hora,:id_servico,:valor)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindValue(':id_funcionario', $dados['id_funcionario']);
        $stmt->bindValue(':id_usuario', $dados['id_usuario']);
        $stmt->bindValue(':data_hora', $dados['data_hora']);
        $stmt->bindValue(':id_servico', $dados['id_servico']);
        $stmt->bindParam(':valor', $dados['valor']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function updateUser($id, $dados){
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET id_funcionario = :id_funcionario, id_usuario = :id_usuario, data_hora = :data_hora, id_servico = :id_servico, valor = :valor WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':id_funcionario', $dados['id_funcionario']);
        $stmt->bindValue(':id_usuario', $dados['id_usuario']);
        $stmt->bindValue(':data_hora', $dados['data_hora']);
        $stmt->bindValue(':id_servico', $dados['id_servico']);
        //$stmt->bindParam(':valor', $dados['valor']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    
    public function getMySQL()
    {
        return $this->MySQL;
    }
}