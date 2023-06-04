<?php

namespace Service;

use InvalidArgumentException;
use Repository\FuncionarioRepository;
use Util\ConstantesGenericasUtil;

class FuncionarioService
{
    public const TABELA = 'funcionario';
    public const RECURSOS_GET = ['listar', 'verificar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_PUT = ['atualizar'];
    private array $dados;

    private array $dadosCorpoRequest;

    private object $FuncionarioRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->FuncionarioRepository = new FuncionarioRepository();
    }

    public function validarGet(){
        $retorno = null;
        $recurso = $this->dados['recurso'];
        if (in_array($recurso, self::RECURSOS_GET, true)) {

            if ($recurso === 'verificar') {
                $retorno = $this->verificar();
            } else  {
                $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();
            }

           

        } else{
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);


        }

        if ($retorno === null) {
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }

        return $retorno;
    }

    public function validarDelete(){
        $retorno = null;
        $recurso = $this->dados['recurso'];
        if (in_array($recurso, self::RECURSOS_DELETE, true)) {
            if($this->dados['id'] > 0){
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

    public function validarPost(){
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

    public function setDadosCorpoRequest($dadosCorpoRequest){
        $this->dadosCorpoRequest = $dadosCorpoRequest;
    }

    private function listar(){
        //return $this->FuncionarioRepository->getMySQL()->getAll(self::TABELA);
        return $this->FuncionarioRepository->getMySQL()->getFunc(self::TABELA);

    }
 
    private function verificar()
    {
        $idUsuario = $this->dados['id'];
        return $this->FuncionarioRepository->getVerificar($idUsuario);
    }
    
   
    private function getOneByKey()
    {
        return $this->FuncionarioRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    private function deletar(){
        return $this->FuncionarioRepository->getMySQL()->delete(self::TABELA, $this->dados['id']);
    }

    private function cadastrar(){
        $nm_funcionario = $this->dadosCorpoRequest['nm_funcionario'];
        if($nm_funcionario ){

            if($this->FuncionarioRepository->insertUser( $this->dadosCorpoRequest) > 0){

                $idIserido = $this->FuncionarioRepository->getMySQL()->getDb()->lastInsertId();
                $this->FuncionarioRepository->getMySQL()->getDb()->commit();
                return ['id_inserido' => $idIserido];

            }
            $this->FuncionarioRepository->getMySQL()->getDb()->rollback();
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);
    }

    private function atualizar()
    {
        if ($this->FuncionarioRepository->updateUser($this->dados['id'], $this->dadosCorpoRequest) > 0) {
            $this->FuncionarioRepository->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }
        $this->FuncionarioRepository->getMySQL()->getDb()->rollBack();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }
}