<?php

class PetsModel
{
    use Model;

    protected $table = 'pets';
    protected $allowedColumns = ['name', 'birthday', 'gender', 'species', 'breed', 'petowner_id'];

    public function getAllPetDetails()
    {
        
        //return $this->findAll();
        $query = "SELECT p.*, po.name AS owner_name, po.contact
        FROM
            pets p
        JOIN
            petowners po ON p.petowner_id = po.id";

        return $this->query($query);
    }

    /*public function getPetDetailsById($id)
    {
        //return $this->first(['id' => $id]);
        $query = "SELECT p.*, po.name AS owner_name, po.contact
        FROM
            pets p
        JOIN
            petowners po ON p.petowner_id = po.id
        WHERE p.id= :id";

        return $this->get_row($query, ['id' => $id]);
    }*/

    
    public function getAllPetsByUserId($id) {
        $query = "SELECT p.id, p.name
        FROM pets AS p
        JOIN petowners AS po ON p.petowner_id = po.id
        JOIN users AS u ON po.user_id = u.id
        WHERE u.id = :id";
  
        return $this->query($query, ['id' => $id]);
        
    }

    public function getPetById($id) {
        $query = "SELECT p.*, u.email, u.status
                  FROM pets AS p
                  JOIN users AS u ON p.user_id = u.id
                  WHERE p.id = :id";
        // show($id);
        // die();
        return $this->get_row($query, ['id' => $id]);
    }





}