<?php

namespace Src\Model;

use PDO;

class ArticleModel
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;    
    }

    public function getAll()
    {
        $query = "SELECT articles.id, concat(authors.name, ' ', authors.surname) as author, articles.content, articles.name as article_name,
            articles.created_at, articles.updated_at 
            from authors, articles 
            WHERE articles.author_id = authors.ID";
          
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $id = "";
        $name = ""; 
        $content = ""; 
        $author = "";

        foreach ($data as $key => $article) {
            switch ($article->name) {
                case 'id':
                    $id = $article->value;
                    break;
                case 'article-name':
                    $name = $article->value;
                    break;
                case 'article-content':
                    $content = $article->value;
                    break;
                case 'article-author': 
                    $author = $article->value;
                    break;
            }
        }

        $query = "UPDATE articles SET name = :name, content = :content, author_id = :authorId WHERE id = :id";
        $stm = $this->connection->prepare($query);
        $stm->bindValue(":name", $name);
        $stm->bindValue(":content", $content);
        $stm->bindValue(":authorId", $author);
        $stm->bindValue(":id", $id);
        $result = $stm->execute();

        return $result;
    }

    public function delete($id)
    {
        $query = "DELETE FROM articles WHERE id = :id";

        $stm = $this->connection->prepare($query);
        $stm->bindValue(":id", $id);
        $result = $stm->execute();
        
        return $result;
    }

    public function add($data) {
        $name = ""; 
        $content = ""; 
        $author = "";

        foreach ($data as $key => $article) {
            switch ($article->name) {
                case 'article-name':
                    $name = $article->value;
                    break;
                case 'article-content':
                    $content = $article->value;
                    break;
                case 'article-author': 
                    $author = $article->value;
                    break;
            }
        }

        $query = "INSERT INTO articles (name, content, author_id) VALUES (:name, :content, :authorId) ";
        $stm = $this->connection->prepare($query);
        $stm->bindValue(":name", $name);
        $stm->bindValue(":content", $content);
        $stm->bindValue(":authorId", $author);
        $result = $stm->execute();

        return $result;    
    }
}