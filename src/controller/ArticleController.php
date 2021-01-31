<?php

namespace Src\Controller;

use Src\Core\Config;
use Src\Core\Database;
use Src\Controller\Data\ApiInterface;
use Src\Model\ArticleModel;
use Src\Core\View;

class ArticleController implements ApiInterface
{
    private $db;

    public function __construct()
    {
        $this->db = new Database(new Config());

    }

    public function index() 
    {
        $article = new ArticleModel($this->db->openConnection());
        $articlesList = $article->getAll();
        $this->db->closeConnection();

        return new View('article/index.phtml', $articlesList);
    }

    public function getAll()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(200);

        $article = new ArticleModel($this->db->openConnection());
        $articlesList = $article->getAll();
        $this->db->closeConnection();

        echo json_encode($articlesList);
    }

    public function add()
    {
        $data = json_decode(file_get_contents("php://input"));
        $article = new ArticleModel($this->db->openConnection());
        $result = $article->add($data);
        $this->db->closeConnection();

        if (!$result) {
            echo 'Coś poszło nie tak !';
        } else {
            echo 'Artykuł dodany poprawnie.';
        }
    }

    public function update()
    {
        $data = json_decode(file_get_contents("php://input"));
        $article = new ArticleModel($this->db->openConnection());
        $result = $article->update($data);
        $this->db->closeConnection();

        if (!$result) {
            echo 'Coś poszło nie tak !';
        } else {
            echo 'Artykuł edytowany poprawnie.';
        }
    }

    public function delete()
    {
        $data = json_decode(file_get_contents("php://input"));
        $article = new ArticleModel($this->db->openConnection());
        $deleteResult = $article->delete($data->id);
        $this->db->closeConnection();

        if ($deleteResult) {
            echo json_encode(['200', 'Artykuł usunięty']);
        } else {
            echo 'wystąpił błąd podczas usuwania artykułu';
        }
    }
    
}