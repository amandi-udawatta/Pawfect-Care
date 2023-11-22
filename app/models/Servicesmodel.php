<?php

class ServicesModel
{
    use Model;

    protected $table = 'services';
    protected $allowedColumns = ['service_tittle', 'description'];

    public function getAllServices()
    {
        return $this->findAll();
    }

    public function getServiceById($id)
    {
        return $this->first(['id' => $id]);
    }

    public function createService($data)
    {
        return $this->insert($data);
    }

    public function updateService($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteService($id)
    {
        return $this->delete($id);
    }

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['service_tittle'])) {
            $this->errors['service_tittle'] = "Service Tittle is required";
        }

        if (empty($data['description'])) {
            $this->errors['description'] = "Description is required";
        }

        return empty($this->errors);
    }
}

