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

    public function insertUser($dados){
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (usuario_id,nm_funcionario, nm_cargo,endereco,bairro,cidade,contato) VALUES (:usuario_id,:nm_funcionario, :nm_cargo, :endereco,:bairro,:cidade,:contato)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindParam(':usuario_id', $dados['usuario_id']);
        $stmt->bindParam(':nm_funcionario', $dados['nm_funcionario']);
        $stmt->bindParam(':nm_cargo', $dados['nm_cargo']);
        $stmt->bindParam(':endereco', $dados['endereco']);
        $stmt->bindParam(':bairro', $dados['bairro']);
        $stmt->bindParam(':cidade', $dados['cidade']);
        $stmt->bindParam(':contato', $dados['contato']);
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