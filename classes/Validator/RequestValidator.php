<?php

namespace Validator;

use InvalidArgumentException;
use Repository\TokensAutorizadosRepository;
use Service\AgendaService;
use Service\CidadeService;
use Service\UsuarioService;
use Service\FuncionarioService;
use Service\ServicoService;
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
    const FUNCIONARIO = 'FUNCIONARIO';
    const SERVICO = 'SERVICO';
    const AGENDA = 'AGENDA';
    const CIDADE = 'CIDADE';

    public function __construct($request = [])
    {
       //Primeira coisa que ira fazer, vai ser o roteamento
       $this->request = $request;
       $this->TokensAutorizadosRepository  = new TokensAutorizadosRepository();
    }

    public function processarRequest(){

        //Aqui iremos direcionar as requisições. caso for GET,PUT,DELETE,POST

        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        if( in_array($this->request['metodo'],ConstantesGenericasUtil::TIPO_REQUEST,true)){
            $retorno = $this->direcionarRequest();
        }
        return $retorno;
    }


    
    private function direcionarRequest()
    {
        //Validando o metodo requisitado
        //Caso não seja GET e DELETE, quer dizer que tem um BODY ou seja um POST OU PUT
        if ($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE) {
            $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
        }

        //Responsavel pelo TOKEN
        //$this->TokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
        $metodo = $this->request['metodo'];
        return $this->$metodo(); //Direcionando 
    }

    private function get(){
       $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);
       if(in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET)){
            switch($this->request['rota']){
                case self::USUARIOS:
                    $UsuariosService = new UsuarioService($this->request);
                    $retorno = $UsuariosService->validarGet();
                    break;
                case self::FUNCIONARIO:
                    $FuncionarioService = new FuncionarioService($this->request);
                    $retorno = $FuncionarioService->validarGet();
                    break;   
                case self::SERVICO:
                    $ServicoService = new ServicoService($this->request);
                    $retorno = $ServicoService->validarGet();
                    break;
                case self::AGENDA:
                    $AgendaService = new AgendaService($this->request);
                    $retorno = $AgendaService->validarGet();
                    break;    
                case self::CIDADE:
                    $CidadeService = new CidadeService($this->request);
                    $retorno = $CidadeService->validarGet();
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
                case self::FUNCIONARIO:
                    $FuncionarioService = new FuncionarioService($this->request);
                    $retorno = $FuncionarioService->validarDelete();
                    break;
                case self::SERVICO:
                    $ServicoService = new ServicoService($this->request);
                    $retorno = $ServicoService->validarDelete();
                    break;
                case self::AGENDA:
                    $AgendaService = new AgendaService($this->request);
                    $retorno = $AgendaService->validarDelete();
                    break;
                case self::CIDADE:
                    $CidadeService = new CidadeService($this->request);
                    $retorno = $CidadeService->validarDelete();
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
                case self::FUNCIONARIO:
                    $FuncionarioService = new FuncionarioService($this->request);
                    $FuncionarioService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $FuncionarioService->validarPost();
                    break; 
                case self::SERVICO:
                    $ServicoService = new ServicoService($this->request);
                    $ServicoService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $ServicoService->validarPost();
                    break;     
                case self::AGENDA:
                    $AgendaService = new AgendaService($this->request);
                    $AgendaService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $AgendaService->validarPost();
                    break;    
                case self::CIDADE:
                    $CidadeService = new CidadeService($this->request);
                    $CidadeService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $CidadeService->validarPost();
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
                case self::FUNCIONARIO:
                    $FuncionarioService = new FuncionarioService($this->request);
                    $FuncionarioService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $FuncionarioService->validarPut();
                    break;
                case self::SERVICO:
                    $ServicoService = new ServicoService($this->request);
                    $ServicoService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $ServicoService->validarPut();
                    break;
                case self::AGENDA:
                    $AgendaService = new AgendaService($this->request);
                    $AgendaService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $AgendaService->validarPut();
                case self::CIDADE:
                    $CidadeService = new CidadeService($this->request);
                    $CidadeService->setDadosCorpoRequest($this->dadosRequest);
                    $retorno = $CidadeService->validarPut();
                    break;   
                 default:
                     throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
             }
         }
         return $retorno;
    }

    }