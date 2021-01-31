<?php

namespace Src\Controller;

use Src\Controller\Data\ApiInterface;
use Src\Core\Config;
use Src\Core\Database;
use Src\Model\AuthorModel;
use Src\Core\View;

class AuthorController implements ApiInterface
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(new Config());

    }

    public function index() 
    {
        $author = new AuthorModel($this->db->openConnection());
        $authorsList = $author->getAll();
        $this->db->closeConnection();

        return new View('author/index.phtml', $authorsList);
    }
    
    public function getAll()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);

        $author = new AuthorModel($this->db->openConnection());
        $authorsList = $author->getAll();
        
        echo json_encode($authorsList);
    }

    public function add() 
    {
        $data = json_decode(file_get_contents("php://input"));
        $author = new AuthorModel($this->db->openConnection());
        $result = $author->add($data);
        $this->db->closeConnection();

        if (!$result) {
            echo 'Coś poszło nie tak !';
        } else {
            echo 'Autor dodany poprawnie.';
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        $author = new AuthorModel($this->db->openConnection());
        $result = $author->update($data);
        $this->db->closeConnection();

        if (!$result) {
            echo 'Coś poszło nie tak !';
        } else {
            echo 'Autor edytowany poprawnie.';
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"));
        $author = new AuthorModel($this->db->openConnection());
        $deleteResult = $author->delete($data->id);
        $this->db->closeConnection();

        if ($deleteResult) {
            echo json_encode(['200', 'Autor usunięty']);
        } else {
            echo 'wystąpił błąd podczas usuwania autora';
        }       
    }
}