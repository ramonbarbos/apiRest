<?php

namespace DB;

use InvalidArgumentException;
use PDO;
use PDOException;
use Util\ConstantesGenericasUtil;

class MySQL
{
    private object $db;

    /**
     * MySQL constructor.
     */
    
    public function __construct()
    {
        $this->db = $this->setDB();
    }

   
    public function setDB()
    {
        try {
            return new PDO(
                'mysql:host=' . HOST . '; dbname=' . BANCO . ';', USUARIO, SENHA
            );
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }


    public function delete($tabela, $id)
    {
        $consultaDelete = 'DELETE FROM ' . $tabela . ' WHERE id = :id';
        if ($tabela && $id) {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($consultaDelete);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->db->commit();
                return ConstantesGenericasUtil::MSG_DELETADO_SUCESSO;
            }
            $this->db->rollBack();
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
    }

 
    public function getAll($tabela)
    {
        if ($tabela) {
            $consulta = 'SELECT * FROM ' . $tabela;
            $stmt = $this->db->query($consulta);
            $registros = $stmt->fetchAll($this->db::FETCH_ASSOC);
            if (is_array($registros) && count($registros) > 0) {
                return $registros;
            }
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
    }

    public function getFunc($tabela)
    {
        if ($tabela) {
            $consulta = 'SELECT * FROM ' . $tabela . ' WHERE ativo = "s"';
            $stmt = $this->db->query($consulta);
            $registros = $stmt->fetchAll($this->db::FETCH_ASSOC);
            if (is_array($registros) && count($registros) > 0) {
                return $registros;
            }
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
    }

 

    public function getOneByKey($tabela, $id)
    {
        if ($tabela && $id) {
            $consulta = 'SELECT * FROM ' . $tabela . ' WHERE id = :id';
            $stmt = $this->db->prepare($consulta);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $totalRegistros = $stmt->rowCount();
            if ($totalRegistros === 1) {
                return $stmt->fetch($this->db::FETCH_ASSOC);
            }
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
    }

   

    public function getAgenda($tabela, $id)
    {
        if (empty($tabela)) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
        }
    
        // Verifica se o ID fornecido corresponde a um funcionário
        $consultaFuncionario = 'SELECT id FROM funcionario WHERE usuario_id = :id';
        $stmtFuncionario = $this->db->prepare($consultaFuncionario);
        $stmtFuncionario->bindParam(':id', $id);
        $stmtFuncionario->execute();
        $funcionario = $stmtFuncionario->fetch();
        $totalFuncionarios = $stmtFuncionario->rowCount();
    
        if ($totalFuncionarios > 0) {
            // O ID fornecido corresponde a um funcionário
            $consulta = 'SELECT * FROM ' . $tabela . ' WHERE id_funcionario = :id';
            $stmt = $this->db->prepare($consulta);
            $stmt->bindParam(':id', $funcionario['id']);
        } else {
            // O ID fornecido não corresponde a um funcionário
            $consulta = 'SELECT * FROM ' . $tabela . ' WHERE id_usuario = :id';
            $stmt = $this->db->prepare($consulta);
            $stmt->bindParam(':id', $id);
        }
    
        $stmt->execute();
        $totalRegistros = $stmt->rowCount();
    
        if ($totalRegistros > 0) {
            return $stmt->fetchAll($this->db::FETCH_ASSOC); // Retorna a agenda do usuário
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_SEM_RETORNO);
        }
    }
    
    

    /**
     * @return object|PDO
     */
    public function getDb()
    {
        return $this->db;
    }
}