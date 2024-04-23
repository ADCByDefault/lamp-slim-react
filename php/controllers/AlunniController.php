<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController{
    

    public function index(Request $request, Response $response, $args){

        $conn = new mysqli("my_mariadb","root","ciccio","scuola");

        $sql = "SELECT * FROM alunni";
        $result = $conn->query($sql);

        $results = $result->fetch_all(MYSQLI_ASSOC);

        $response->getBody()->write(json_encode($results, JSON_NUMERIC_CHECK));
        
        return $response->withHeader("Content-Type","application/json");
    }
    public function show(Request $request, Response $response, $args){
        $id = $args["id"];

        $conn = new mysqli("my_mariadb","root","ciccio","scuola");

        $sql = "SELECT * FROM alunni WHERE id = '$id'";
        $result = $conn->query($sql);

        $results = $result->fetch_all(MYSQLI_ASSOC);

        $response->getBody()->write(json_encode($results, JSON_NUMERIC_CHECK));
        return $response->withHeader("Content-Type","application/json");
    }

    public function create(Request $request, Response $response, $args){
        $conn = new mysqli("my_mariadb","root","ciccio","scuola");
        $test = $request->getBody()->getContents();
        $data = json_decode($test, true);
        //curl -X POST http://localhost:8080/alunni -d '{"id":"gg","nome":"carlo","cognome":"giannini","eta":39}' -H "Content-Type: application/json"
        
        $n = $data['nome'];
        $s = $data['cognome'];

        $sql = "INSERT INTO alunni(nome,cognome) VALUES ('$n','$s')";
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
        
        $c = $args['id'];
        $n = $data['nome'];
        $s = $data['cognome'];

        $sql = "UPDATE alunni
                SET nome = '$n', cognome = '$s'
                WHERE id = '$c'";
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

        $response->getBody()->write(json_encode($result, JSON_NUMERIC_CHECK));
        return $response->withStatus(405)->withHeader("Content-Type","application/json");
    }

    public function delete(Request $request, Response $response, $args){
        $conn = new mysqli("my_mariadb","root","ciccio","scuola");
        $data = json_decode($test, true);
        //curl -X DELETE http://localhost:8080/alunni/gg"
        
        $c = $args['id'];

        $sql = "DELETE FROM alunni
                WHERE id = '$c'";

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

        $response->getBody()->write(json_encode($result, JSON_NUMERIC_CHECK));
        return $response->withStatus(405)->withHeader("Content-Type","application/json");
    }
    
}

?>