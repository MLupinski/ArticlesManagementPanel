<?php

namespace Src\Model;

use PDO;

class AuthorModel
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;    
    }

    public function getAll()
    {
        $query = "SELECT authors.* from authors";
        $result = $this->connection->query($query);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }    

    public function update($data)
    {
        $id = "";
        $name = ""; 
        $surname = ""; 

        foreach ($data as $key => $author) {
            switch ($author->name) {
                case 'id':
                    $id = $author->value;
                    break;
                case 'author-name':
                    $name = $author->value;
                    break;
                case 'author-surname':
                    $surname = $author->value;
                    break;
            }
        }

        $query = "UPDATE authors SET name = :name, surname = :surname WHERE ID = :id";
        $stm = $this->connection->prepare($query);
        $stm->bindValue(":name", $name);
        $stm->bindValue(":surname", $surname);
        $stm->bindValue(":id", $id);
        $result = $stm->execute();

        return $result;
    }

    public function add($data)
    {
        $name = ""; 
        $surname = ""; 

        foreach ($data as $key => $author) {
            switch ($author->name) {
                case 'author-name':
                    $name = $author->value;
                    break;
                case 'author-surname':
                    $surname = $author->value;
                    break;
            }
        }

        $query = "INSERT INTO authors (name, surname) VALUES (:name, :surname)";
        $stm = $this->connection->prepare($query);
        $stm->bindValue(":name", $name);
        $stm->bindValue(":surname", $surname);
        $result = $stm->execute();

        return $result;    
    }

    public function delete($id)
    {
        $query = "DELETE FROM authors WHERE id = :id";

        $stm = $this->connection->prepare($query);
        $stm->bindValue(":id", $id);
        $result = $stm->execute();
        
        return $result;
    }
}