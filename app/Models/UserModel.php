<?php

namespace oQuiz\Models; 

use oQuiz\Utils\Database; 
use PDO;



 class UserModel extends CoreModel {
    /** @var string */
    protected $first_name;
    /** @var string */
    protected $last_name;
    /** @var string */
    protected $email;
    /** @var string */
    protected $password;





    // self => la classe dans laquelle est écrit le mot clé "self"
    // static => la classe courante = la classe depuis laquelle on a appelé la méthode
    // parent => la classe parente (dont on a hérité)
    // $this => l'objet courant
    // &copy; Georges : self c'est la classe où est écrit le code, static c'est la classe qui est en train d'utiliser la méthode
    
    const TABLE_NAME = 'users';

    // Méthode qui vérifie si l'email existe
    public static function findByEmail(string $email) {
        $sql = '
            SELECT *
            FROM '.self::TABLE_NAME.'
            WHERE email = :email
        ';
        $pdoStatement = Database::getPDO()->prepare($sql);
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        $pdoStatement->execute();
        
        return $pdoStatement->fetchObject(self::class);
    }


    // CRUD
    public function find() : bool {

    }

    // Insère en BDD les données du nouvel inscrit
    public function insert() : bool {
        $sql = '
        INSERT INTO '.self::TABLE_NAME.' (`first_name`, `last_name`, `email`, `password`)
        VALUES (:first_name, :last_name, :email, :password
        )
        ';
        $pdoStatement = Database::getPDO()->prepare($sql);
        $pdoStatement->bindValue(':first_name', $this->first_name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':last_name', $this->last_name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->execute();
        
        $affectedRows = $pdoStatement->rowCount();
        
        if ($affectedRows > 0) {
            $this->id = Database::getPDO()->lastInsertId();
            return true;
        }
        return false;


    }
    public function update() : bool {

    }
    public function delete() : bool {

    }



    /**
     * Get the value of first_name
     */ 
    public function getFirst_name()
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */ 
    public function setFirst_name($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */ 
    public function getLast_name()
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */ 
    public function setLast_name($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
}
