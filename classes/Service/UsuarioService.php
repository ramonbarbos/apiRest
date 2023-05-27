<?php

namespace Service;

use InvalidArgumentException;
use Repository\UsuarioRepository;
use Util\ConstantesGenericasUtil;

class UsuarioService
{


    public const TABELA = 'usuarios';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_DELETE = ['deletar'];
    public const RECURSOS_POST = ['cadastrar'];
    public const RECURSOS_PUT = ['atualizar'];
    public const RECURSOS_LOGIN = ['login'];

    private array $dados;

    private array $dadosCorpoRequest;

    private object $UsuariosRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->UsuariosRepository = new UsuarioRepository();
    }

    public function validarGet(){
        $retorno = null;
        $recurso = $this->dados['recurso'];
        if (in_array($recurso, self::RECURSOS_GET, true)) {

            $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso();

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

        if (in_array($recurso, self::RECURSOS_LOGIN, true) ) {
            $retorno = $this->validarLogin();

        } elseif (in_array($recurso, self::RECURSOS_POST, true)) {
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
        return $this->UsuariosRepository->getMySQL()->getAll(self::TABELA);
    }

    
    private function getOneByKey()
    {
        return $this->UsuariosRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    private function deletar(){
        return $this->UsuariosRepository->getMySQL()->delete(self::TABELA, $this->dados['id']);
    }

    private function cadastrar(){
        $login = $this->dadosCorpoRequest['login'];
        $senha = $this->dadosCorpoRequest['senha'];
        if($login && $senha){

            if($this->UsuariosRepository->insertUser( $this->dadosCorpoRequest) > 0){

                $idIserido = $this->UsuariosRepository->getMySQL()->getDb()->lastInsertId();
                $this->UsuariosRepository->getMySQL()->getDb()->commit();
                return ['id_inserido' => $idIserido];

            }
            $this->UsuariosRepository->getMySQL()->getDb()->rollback();
            throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);
    }

    private function atualizar()
    {
        if ($this->UsuariosRepository->updateUser($this->dados['id'], $this->dadosCorpoRequest) > 0) {
            $this->UsuariosRepository->getMySQL()->getDb()->commit();
            return ConstantesGenericasUtil::MSG_ATUALIZADO_SUCESSO;
        }
        $this->UsuariosRepository->getMySQL()->getDb()->rollBack();
        throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_NAO_AFETADO);
    }

    public function validarLogin()
     {
            $login = $this->dadosCorpoRequest['login'];
            $senha = $this->dadosCorpoRequest['senha'];

            if ($login && $senha) {
                $usuario = $this->UsuariosRepository->loginUser($login, $senha);

                if ($usuario) {
                    // Login válido, prosseguir com o restante do código ou retornar uma resposta adequada
                    $idIserido = $this->UsuariosRepository->getMySQL()->getDb()->lastInsertId();
                    return ['mensagem' => 'Login válido','logado' => $usuario['id']];
                } else {
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_INVALIDO);
                }
            } else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_SENHA_OBRIGATORIO);
            }
        }

}