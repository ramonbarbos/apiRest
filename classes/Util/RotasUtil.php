<?php

namespace Util;

class RotasUtil{

    public static function getRotas(){


        $urls = self::getUrls(); //Pegándo roteamento tratado

        $request = [];
        $request['rota'] = strtoupper($urls[0]); //Ex: classe usuarios
        $request['recurso'] = $urls[1] ?? null; //recurso: se vai ser deletar, atualizar..
        $request['id'] = $urls[2] ?? null; //passando o id
        $request['metodo'] = $_SERVER['REQUEST_METHOD']; //Definindo a requisição: GET,POST..

        #http://localhost/apiRest/usuarios/atualizar/4
        #http://localhost/apiRest/usuarios/deletar/3
        #http://localhost/apiRest/usuarios/listar
        #http://localhost/apiRest/usuarios/cadastrar

        return $request;
    }

    public static function getUrls(){
        //Roteamento Simples
        $uri = str_replace('/'. DIR_PROJETO, '', $_SERVER['REQUEST_URI']);
        return explode('/', trim($uri, '/'));
    }

}