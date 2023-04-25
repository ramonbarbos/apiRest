<?php

namespace Validator;

use InvalidArgumentException;
use Repository\TokensAutorizadosRepository;
use Service\UsuarioService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{

    private array $request; 
    private array $dadosRequest = []; 
    private object $TokensAutorizadosRepository; 
    
    const GET = 'GET';
    const DELETE = 'DELETE';
    const USUARIOS = 'USUARIOS';

    public function __construct($request = [])
    {
       $this->request = $request;
       $this->TokensAutorizadosRepository  = new TokensAutorizadosRepository();
    }

    public function processarRequest(){
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        if( in_array($this->request['metodo'],ConstantesGenericasUtil::TIPO_REQUEST,true)){
            $retorno = $this->direcionarRequest();
        }
        return $retorno;
    }


    
    private function direcionarRequest()
    {
        if ($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE) {
            $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
        }

        //$this->TokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
        $metodo = $this->request['metodo'];
        return $this->$metodo(); //Direcionando para o GET 
    }

    private function get(){
       $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
       if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET)){
            switch($this->request['rota']){
                case self::USUARIOS:
                    $UsuariosService = new UsuarioService($this->request);
                    $retorno = $UsuariosService->validarGet();
                    break;
                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        return $retorno;
    }

    private function delete()
    {
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_DELETE)){
             switch($this->request['rota']){
                 case self::USUARIOS:
                     $UsuariosService = new UsuarioService($this->request);
                     $retorno = $UsuariosService->validarDelete();
                     break;
                 default:
                     throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
             }
         }
         return $retorno;
    }

    private function post(){
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_POST)){
             switch($this->request['rota']){
                 case self::USUARIOS:
                     $UsuariosService = new UsuarioService($this->request);
                     $UsuariosService->setDadosCorpoRequest($this->dadosRequest);
                     $retorno = $UsuariosService->validarPost();
                     break;
                 default:
                     throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
             }
         }
         return $retorno;
    }

    private function put(){
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
        if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_PUT)){
             switch($this->request['rota']){
                 case self::USUARIOS:
                     $UsuariosService = new UsuarioService($this->request);
                     $UsuariosService->setDadosCorpoRequest($this->dadosRequest);
                     $retorno = $UsuariosService->validarPut();
                     break;
                 default:
                     throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
             }
         }
         return $retorno;
    }

    }