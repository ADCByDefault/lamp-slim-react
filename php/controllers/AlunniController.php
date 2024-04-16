<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController{
    

    public function index(Request $request, Response $response, $args){

        $conn = new mysqli("my_mariadb","root","ciccio","scuola");

        $sql = "SELECT * FROM alunni";
        $result = $conn->query($sql);

        $results = $result->fetch_all();

        $response->getBody()->write(json_encode(array("5DIA"=>$results)));
        
        return $response->withHeader("Content-Type","application/json");
    }
    public function show(Request $request, Response $response, $args){
        $cf = $args["cf"];

        $conn = new mysqli("my_mariadb","root","ciccio","scuola");

        $sql = "SELECT * FROM alunni WHERE cf = '$cf'";
        $result = $conn->query($sql);

        $results = $result->fetch_all();

        $response->getBody()->write(json_encode(array("5DIA"=>$results)));
        return $response->withHeader("Content-Type","application/json");
    }

    public function create(Request $request, Response $response, $args){
        $conn = new mysqli("my_mariadb","root","ciccio","scuola");
        $test = $request->getBody()->getContents();
        $data = json_decode($test, true);
        //curl -X POST http://localhost:8080/alunni -d '{"cf":"gg","nome":"carlo","cognome":"giannini","eta":39}' -H "Content-Type: application/json"
        
        $c = $data['cf'];
        $n = $data['nome'];
        $s = $data['cognome'];
        $e = $data['eta'];

        $sql = "INSERT INTO alunni(cf,nome,cognome,eta) VALUES ('$c','$n','$s','$e')";
        $conn->query($sql);

        if($conn->affected_rows > 0){
            $response->getBody()->write($test);
            return $response->withStatus(200)->withHeader("Content-Type","application/json");
        }

        $result = [
            "data" => $data,
            "error" => $conn->error,
            "query" => $sql
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withStatus(405)->withHeader("Content-Type","application/json");
    }

    public function update(Request $request, Response $response, $args){
        $conn = new mysqli("my_mariadb","root","ciccio","scuola");
        $test = $request->getBody()->getContents();
        $data = json_decode($test, true);
        //curl -X PUT http://localhost:8080/alunni/gg -d '{"nome":"carlo","cognome":"giannini","eta":39}' -H "Content-Type: application/json"
        
        $c = $args['cf'];
        $n = $data['nome'];
        $s = $data['cognome'];
        $e = $data['eta'];

        $sql = "UPDATE alunni
                SET nome = '$n', cognome = '$s', eta = '$e'
                WHERE cf = '$c'";
        $conn->query($sql);

        if($conn->affected_rows > 0){
            $response->getBody()->write($test);
            return $response->withStatus(200)->withHeader("Content-Type","application/json");
        }

        $result = [
            "data" => $data,
            "error" => $conn->error,
            "query" => $sql
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withStatus(405)->withHeader("Content-Type","application/json");
    }

    public function delete(Request $request, Response $response, $args){
        $conn = new mysqli("my_mariadb","root","ciccio","scuola");
        $data = json_decode($test, true);
        //curl -X DELETE http://localhost:8080/alunni/gg"
        
        $c = $args['cf'];

        $sql = "DELETE FROM alunni
                WHERE cf = '$c'";

        $conn->query($sql);

        if($conn->affected_rows > 0){
            $response->getBody()->write("alunno $c deleted successfully");
            return $response->withStatus(200)->withHeader("Content-Type","application/json");
        }

        $result = [
            "data" => $data,
            "error" => $conn->error,
            "query" => $sql
        ];

        $response->getBody()->write(json_encode($result));
        return $response->withStatus(405)->withHeader("Content-Type","application/json");
    }
    
}

?>