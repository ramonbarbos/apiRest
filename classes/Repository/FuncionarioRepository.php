<?php

namespace Repository;

use DB\MySQL;
use Exception;
use InvalidArgumentException;
use PDO;
use Util\ConstantesGenericasUtil;

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

    public function getVerificar($idUsuario)
    {
        $consulta = 'SELECT * FROM ' . self::TABELA . ' WHERE usuario_id = :id_usuario ';
        $stmt = $this->MySQL->getDb()->prepare($consulta);
        $stmt->bindValue(':id_usuario', $idUsuario);
        $stmt->execute();
        $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
        return $funcionario;
    }

    public function getFunc($tabela)
    {
        if ($tabela) {
            $consulta = 'SELECT * FROM ' . $tabela . ' WHERE ativo = "s"';
            $stmt = $this->MySQL->getDb()->query($consulta);
            $registros = $stmt->fetchAll($this->MySQL->getDb()::FETCH_ASSOC);
            if (is_array($registros) && count($registros) > 0) {
                return $registros;
            }
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
    }

    public function getMySQL()
    {
        return $this->MySQL;
    }
}