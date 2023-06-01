<?php

namespace Repository;

use DB\MySQL;
use Exception;
use PDO;

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

    public function insertUser($dados)
    {
        // Verifica se o usuário é um funcionário
        $consultaFuncionario = 'SELECT id FROM funcionario WHERE usuario_id = :id_usuario';
        $stmtFuncionario = $this->MySQL->getDb()->prepare($consultaFuncionario);
        $stmtFuncionario->bindValue(':id_usuario', $dados['id_usuario']);
        $stmtFuncionario->execute();
        $totalFuncionarios = $stmtFuncionario->rowCount();
        
        if ($totalFuncionarios > 0) {
            // O usuário é um funcionário, não permite inserir o agendamento
            throw new Exception('Nao e permitido agendar para funcionarios.');
        }
        
        // É um usuário normal, permite inserir o agendamento
        $consultaInsert = 'INSERT INTO ' . self::TABELA . ' (id_funcionario, nm_funcionario, id_usuario, nm_usuario, data_hora, id_servico, valor) VALUES (:id_funcionario, :nm_funcionario, :id_usuario, :nm_usuario, :data_hora, :id_servico, :valor)';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaInsert);
        $stmt->bindValue(':id_funcionario', $dados['id_funcionario']);
        $stmt->bindValue(':nm_funcionario', $dados['nm_funcionario']);
        $stmt->bindValue(':id_usuario', $dados['id_usuario']);
        $stmt->bindValue(':nm_usuario', $dados['nm_usuario']);
        $stmt->bindValue(':data_hora', $dados['data_hora']);
        $stmt->bindValue(':id_servico', $dados['id_servico']);
        $stmt->bindParam(':valor', $dados['valor']);
        $stmt->execute();
        
        return $stmt->rowCount();
    }
    

    public function updateUser($id, $dados){
        $consultaUpdate = 'UPDATE ' . self::TABELA . ' SET id_funcionario = :id_funcionario, id_usuario = :id_usuario, nm_usuario = :nm_usuario, data_hora = :data_hora, id_servico = :id_servico,valor = :valor WHERE id = :id';
        $this->MySQL->getDb()->beginTransaction();
        $stmt = $this->MySQL->getDb()->prepare($consultaUpdate);
        $stmt->bindParam(':id', $id);
        $stmt->bindValue(':id_funcionario', $dados['id_funcionario']);
        $stmt->bindValue(':id_usuario', $dados['id_usuario']);
        $stmt->bindValue(':nm_usuario', $dados['nm_usuario']);
        $stmt->bindValue(':data_hora', $dados['data_hora']);
        $stmt->bindValue(':id_servico', $dados['id_servico']);
        $stmt->bindParam(':valor', $dados['valor']);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function getRecentesPorUsuario($idUsuario)
    {
        $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE id_usuario = :id_usuario ORDER BY data_hora DESC LIMIT 1';
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindValue(':id_usuario', $idUsuario);
        $stmt->execute();
        $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);
        return $agendamento;
    }

     

  
    public function getMySQL()
    {
        return $this->MySQL;
    }
}