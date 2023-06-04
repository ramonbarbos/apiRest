<?php

namespace Service;

use InvalidArgumentException;
use Repository\AgendaRepository;
use Util\ConstantesGenericasUtil;

class AgendaService
{
    public const TABELA = 'agenda';
    public const RECURSOS_GET = ['listar', 'exibelista','exiberecente', 'proximos','historico'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_PUT = ['atualizar'];

    private array $dados;
    private array $dadosCorpoRequest;
    private object $AgendaRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->AgendaRepository = new AgendaRepository();
    }

    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_GET, true)) {
            if ($recurso === 'exibelista') {
                $retorno = $this->exibeLista();
            }else if($recurso === 'exiberecente'){
                $retorno = $this->recente();

            } else if($recurso === 'proximos'){
                $retorno = $this->recentes();

            } else if($recurso === 'historico'){
                $retorno = $this->historico();

            }else  {
                $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarDelete()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_DELETE, true)) {
            if ($this->dados['id'] > 0) {
                $retorno = $this->$recurso();
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarPost()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_POST, true)) {
            $retorno = $this->$recurso();
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarPut()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_PUT, true)) {
            if ($this->dados['id'] > 0) {
                $retorno = $this->$recurso();
            } else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        } else {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function setDadosCorpoRequest($dadosCorpoRequest)
    {
        $this->dadosCorpoRequest = $dadosCorpoRequest;
    }

    private function listar()
    {
        return $this->AgendaRepository->getMySQL()->getAll(self::TABELA);
    }

    private function getOneByKey()
    {
        return $this->AgendaRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    private function exibeLista()
    {
        return $this->AgendaRepository->getAgenda(self::TABELA, $this->dados['id']);
    }

    private function recentes()
    {
        $idUsuario = $this->dados['id'];
        return $this->AgendaRepository->getProximosPorUsuario($idUsuario);
    }

    private function recente()
    {
        $idUsuario = $this->dados['id'];
        return $this->AgendaRepository->getRecentesPorUsuario($idUsuario);
    }
    private function historico()
    {
        $idUsuario = $this->dados['id'];
        return $this->AgendaRepository->getHistoricoPorUsuario($idUsuario);
    }

    private function deletar()
    {
        return $this->AgendaRepository->getMySQL()->delete(self::TABELA, $this->dados['id']);
    }

    private function cadastrar()
    {
        $id_funcionario = $this->dadosCorpoRequest['id_funcionario'];

        if ($id_funcionario) {
            if ($this->AgendaRepository->insertUser($this->dadosCorpoRequest) > 0) {
                $idInserido = $this->AgendaRepository->getMySQL()->getDb()->lastInsertId();
                $this->AgendaRepository->getMySQL()->getDb()->commit();
                return ['id_inserido' => $idInserido];
            }

            $this->AgendaRepository->getMySQL()->getDb()->rollback();
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);
    }

    private function atualizar()
    {
        if ($this->AgendaRepository->updateUser($this->dados['id'], $this->dadosCorpoRequest) > 0) {
            $this->AgendaRepository->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }

        $this->AgendaRepository->getMySQL()->getDb()->rollBack();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }
}
