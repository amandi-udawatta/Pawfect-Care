<?php

class AmbulanceDriversModel
{
    use Model;

    protected $table = 'ambulancedrivers';
    protected $allowedColumns = ['name', 'address', 'contact', 'nic', 'license', 'user_id','status', 'image'];


    public function getAllAmbulanceDrivers() {
        $query = "SELECT a.*, u.email ,u.status
                  FROM ambulancedrivers AS a
                  JOIN users AS u ON a.user_id = u.id";

        return $this->query($query);
        
    }

    // public function getAvailableAmbulanceDrivers() {
    //      $query ="SELECT a.*, u.email ,u.status
    //               FROM ambulancedrivers AS a
    //               JOIN users AS u ON a.user_id = u.id
    //               WHERE a.availability = 'available'";
    //             //   join ambulacebookings table and check the pending bookings for drivers is 1 and drivers availability available  
    // }
    public function getAvailableAmbulanceDrivers() {
        $query = "SELECT a.*, u.email, u.status
                  FROM ambulancedrivers AS a
                  JOIN users AS u ON a.user_id = u.id
                  WHERE a.availability = 'available'
                  AND NOT EXISTS (
                      SELECT 1
                      FROM ambulancebookings AS ab
                      WHERE ab.driver_id = a.id
                      AND ab.status = 'pending'
                  )";
        return $this->query($query);
    }

    public function getAmbulanceDriverById($id) {
        $query = "SELECT a.*, u.email ,u.status
                  FROM ambulancedrivers AS a
                  JOIN users AS u ON a.user_id = u.id
                  WHERE a.id = :id";
        // show($id);
        // die();
        return $this->get_row($query, ['id' => $id]);
    }

        public function getAmbulanceDriverIdByUserId($id) {
            $query = "SELECT a.id
                    FROM ambulancedrivers AS a
                    JOIN users AS u ON a.user_id = u.id
                    WHERE u.id = :id";
            
            // Execute the query and fetch the result
            $result = $this->get_row($query, ['id' => $id]);
        
            // Check if a result was obtained
            if ($result) {
                // Access the 'id' property of the result object
                return $result->id;
            } else {
                // Return null if no result was found
                return null;
            }
        }
    

    public function search($term)
    {
        $term = "%{$term}%";
        $query = "SELECT a.*, u.email ,u.status
                FROM {$this->table} AS a
                JOIN users AS u ON a.user_id = u.id 
                WHERE name LIKE :term";
        
        return $this->query($query, [':term' => $term]);
    }

    public function getDriverRoleDataById($id) {
        $query = "SELECT a.*, u.email ,u.status ,u.user_type
                  FROM ambulancedrivers AS a
                  JOIN users AS u ON a.user_id = u.id
                  WHERE u.id = :id";
        // show($id);
        // die();
        return $this->get_row($query, ['id' => $id]);


    }

    public function addAmbulanceDriver($data)
    {
        $userModel = new UserModel;
        

        // Register the daycare staff as a user and directly assign the user_id to $data array
        $data['user_id'] = $userModel->addUser([
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => 'Ambulance Driver', 
        ]);

        if ($data['user_id']) {
            // Prepare daycare staff-specific data
            $staffData = [
                'user_id' => $data['user_id'],
                'name' => $data['name'],
                'address' => $data['address'],
                'contact' => $data['contact'],
                'nic' => $data['nic'],
                'license' => $data['license'],
            ];

            return $this->insert($staffData);
            

            if (!($this->insert($staffData))) {
                $this->errors[] = 'Failed to insert driver data';
                return false;
            }
        } else {
            $this->errors[] = 'User registration failed';
            return false; 
        }
    }

    public function updateAmbulanceDriver($id, array $data)
    {
        // alowed column
        $data = array_filter($data, function ($key) {
            return in_array($key, $this->allowedColumns);
        }, ARRAY_FILTER_USE_KEY);
    
        return $this->update($id, $data, 'id');
    }

    

    public function deleteAmbulanceDriver($id)
    {
        return $this->delete($id);
    }

    // public function deactivateAmbulanceDriver($id)
    // {
    //     return $this->update($id, ['status' => 'inactive']);
    // }
    public function deactivateAmbulanceDriver($id)
    {
        // Get the user_id associated with the daycare staff
        $staffData = $this->getAmbulanceDriverById($id);
        if ($staffData && isset($staffData->user_id)) {
            $userModel = new UserModel();
            // Call a method in the UserModel to update the status
            return $userModel->updateUserStatus($staffData->user_id, 'inactive');
        }

        return false;
    }
    public function activateAmbulanceDriver($id)
    {
        // Get the user_id associated with the daycare staff
        $staffData = $this->getAmbulanceDriverById($id);
        if ($staffData && isset($staffData->user_id)) {
            $userModel = new UserModel();
            // Call a method in the UserModel to update the status
            return $userModel->updateUserStatus($staffData->user_id, 'active');
        }

        return false;
    }

    public function updateAvailability($id, $newAvailability)
    {
        
        $query = "UPDATE ambulancedrivers SET availability = :newAvailability WHERE id = :id";
        return $this->query($query, ['newAvailability' => $newAvailability, 'id' => $id]);
    }

    public function updateAvailabilityToAvailable($id)
    {
        return $this->updateAvailability($id, 'available');
    }

    public function validate($data)
    {
        $this->errors = [];

        if(empty($data['name'])) {
            $this->errors['name'] = "Name is required";
        }

        if(empty($data['address'])) {
            $this->errors['address'] = "Address is required";
        }

        if(empty($data['contact_no'])) {
            $this->errors['contact_no'] = "Contact number is required";
        } elseif (!preg_match('/^[0-9]{10}$/', $data['contact_no'])) {
            $this->errors['contact_no'] = "Contact number is not valid";
        }

       
        if (empty($data['nic'])) {
            $this->errors['nic'] = "NIC is required";
        } elseif (!preg_match('/^[0-9]{9}[vVxX]$|^([0-9]{12})$/', $data['nic'])) {
            $this->errors['nic'] = "NIC is not valid";
        }

        if (empty($data['email'])) {
            $this->errors['email'] = "Email is required";
        }
    
        if (empty($data['license'])) {
            $this->errors['license'] = "License number is required";
        }

        return empty($this->errors);
    }
}


