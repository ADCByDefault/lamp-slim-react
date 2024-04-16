<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class SiteController{
    public function index(Request $request, Response $response, $args){
        $response->getBody()->write("Goodybye World!");
        return $response;
    }
}

?>