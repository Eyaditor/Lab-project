<?php

class Bookmark{
    private $id;
    private $link;
    private $dateAdded;
    private $title;
    private $dbConnection;
    private $dbTable = 'bookmarks';

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function getId(){
        return $this->id;
    }

    public function getlink(){
        return $this->link;
    }

    public function getDateAdded(){
        return $this->dateAdded;
    }

    public function getTitle(){
        return $this->title;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setlink($link){
        $this->link = $link;
    }

    public function setDateAdded($dateAdded){
        $this->dateAdded = $dateAdded;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->dbTable . ' (link, date_added, title) VALUES(:link, now(), :title)';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':link', $this->link);
        $stmt->bindParam(':title', $this->title);
        if($stmt->execute()){
            return true;
        }
        printf("Error: %s.\n", $stmt->error);   
        return false;
    }

    public function readOne(){
        $query = 'SELECT * FROM ' . $this->dbTable . ' WHERE id = :id';
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute() && $stmt->rowCount() == 1){
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $this->id= $result->id;
            $this->dateAdded = $result->date_added;
            $this->link = $result->link;
            $this->title = $result->title;
            return true;
        }
        return false;
    }

    public function readAll(){
        $query = 'SELECT * FROM ' . $this->dbTable;
        $stmt = $this->dbConnection->prepare($query);
        if($stmt->execute() && $stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
        
    }

    public function updateTitle()
    {
        $query = "UPDATE " . $this->dbTable . " SET title=:title WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute() && $stmt->rowCount() ==1) {
            return true;
        }
        return false;
    }


    public function updatelink()
    {
        $query = "UPDATE " . $this->dbTable . " SET link=:link WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":link", $this->link);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute() && $stmt->rowCount() ==1) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->dbTable . " WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute() && $stmt->rowCount() ==1) {
            return true;
        }
     


}
}