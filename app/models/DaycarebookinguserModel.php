<?php

class DaycarebookinguserModel
{
    use Model;

    protected $table = 'daycarebookinguser'; 
    protected $allowedColumns = ['id','drop_off_time','pick_up_time','drop_off_date','list_of_items','allergies','pet_behaviour','medications','pet_id','created_at', 'status']; 

    public function getAllDaycarebookings()
    {
        // Adjusted query to fetch all daycare bookings with pet and pet owner details
        $query = "SELECT
                    d.drop_off_time,
                    d.pick_up_time,
                    d.drop_off_date,
                    d.pet_id,
                    p.name AS pet_name,
                    po.name AS pet_owner_name,
                    po.contact AS pet_owner_contact
                FROM
                    daycarebookinguser d
                JOIN
                    pets p ON d.pet_id = p.id
                JOIN
                    petowners po ON p.petowner_id = po.id";

        return $this->query($query);
    }

//     public function getAllOldDaycarebookings(){
//         $query = "SELECT 
//         d.drop_off_time,
//         d.pick_up_time,
//         d.drop_off_date,
//         d.pet_id,
//         d.status,
//         d.list_of_items,
//         d.allergies,
//         d.pet_behaviour ,
//         d.medications,
//          p.name AS pet_name,
//         po.name AS pet_owner_name,
//         po.contact  AS pet_owner_contact
//     FROM
//         daycarebookinguser d
//     JOIN
//         pets p ON d.pet_id = p.id
//      JOIN
//          petowners po ON p.petowner_id = po.id
//          WHERE d.status !='pending'
//       ORDER BY DESC";
// return $this->query($query);
//     }


    public function addDaycarebooking(array $data)
    {
        // Retrieve pet owner details based on user ID stored in session
        $userId = $_SESSION['USER']->id;
        $petOwnerDetails = $this->getPetOwnerDetailsByUserId($userId);

        // If pet owner details are not found, return an error
        if (!$petOwnerDetails) {
            return "Failed to fetch pet owner details.";
        }

        // Include pet owner details in the booking data
        $data['pet_owner_name'] = $petOwnerDetails['name'];
        $data['pet_owner_contact'] = $petOwnerDetails['contact'];

        // Insert the new booking
        $inserted = $this->insert($data);
        if ($inserted) {
            return true; 
        } else {
            return "Failed to save booking.";
        }
    }

    // Method to get pet owner details by user ID
    private function getPetOwnerDetailsByUserId($userId)
    {
        // Query to fetch pet owner details based on user ID
        $query = "SELECT name, contact FROM petowners WHERE user_id = :user_id";
        $bindings = [':user_id' => $userId];

        // Execute the query
        $result = $this->query($query, $bindings);

        // Check if pet owner details are found
        if ($result && count($result) > 0) {
            return [
                'name' => $result[0]->name,
                'contact' => $result[0]->contact
            ];
        } else {
            return false;
        }
    }

    public function getPetOwnerId($id){
       $query = "SELECT po.id
                FROM daycarebookinguser dbu
                JOIN pets p ON dbu.pet_id = p.id
                JOIN petowners po ON p.petowner_id = po.id
                WHERE dbu.id = :id";

        $bindings = [':id' => $id];
        $result = $this->query($query, $bindings);
        return $result[0]->id;
    }

    public function getPetOwnerEmailById($id)
    {
    // Query to fetch pet owner using daycarebookinguser id
        $query = "SELECT u.email
                  FROM daycarebookinguser dbu
                  JOIN pets p ON dbu.pet_id = p.id
                  JOIN petowners po ON p.petowner_id = po.id
                  JOIN users u ON po.user_id = u.id
                  WHERE dbu.id = :id";

        $bindings = [':id' => $id];
        $result = $this->query($query, $bindings);
        return $result[0]->email;
    }
    
    //function to search date and load the booking for that day
   // In DaycarebookinguserModel class

public function getBookingsForDate($date)
{
    $query = "SELECT
                d.drop_off_time,
                d.pick_up_time,
                d.drop_off_date,
                d.pet_id,
                p.name AS pet_name,
                po.name AS pet_owner_name,
                po.contact AS pet_owner_contact
            FROM
                daycarebookinguser d
            JOIN
                pets p ON d.pet_id = p.id
            JOIN
                petowners po ON p.petowner_id = po.id
            WHERE
                d.drop_off_date = :drop_off_date";

    $bindings = [':drop_off_date' => $date];

    return $this->query($query, $bindings);
}


// public function search($term)
// {
//     $term = "%{$term}%";
 
//        $query = "SELECT d.* , p.name AS pet_name, po.name AS pet_owner_name, po.contact AS pet_owner_contact
//                 FROM daycarebookinguser d
//                 JOIN pets p ON d.pet_id = p.id
//                 JOIN petowners po ON p.petowner_id = po.id
//                 WHERE d.drop_off_date LIKE :term";

//           return $this->query($query, [':term' => $term]);
// }

public function searchforDaycareStaff($term) {
    $term = "%{$term}%";
  
    
    $query = "SELECT
        d.id,
        d.drop_off_time,
        d.pick_up_time,
        d.drop_off_date,
        d.pet_id,
        d.list_of_items,
        d.allergies,
        d.pet_behaviour,
        d.medications,
        d.status,
        p.name AS pet_name,
        po.name AS pet_owner_name,
        po.contact AS pet_owner_contact,
        d.status
        FROM daycarebookinguser d
        JOIN
            pets p ON d.pet_id = p.id
        JOIN
            petowners po ON p.petowner_id = po.id
        WHERE 
        (po.name LIKE :term 
        OR po.contact LIKE :term
        OR po.id LIKE :term
        OR p.name LIKE :term)
        ORDER BY d.drop_off_date DESC;
        ";
    $bindings = [':term' => $term];
    
    return $this->query($query, $bindings);
}

        public function getLastInsertedId(){
            $query = "SELECT id FROM daycarebookinguser ORDER BY id DESC LIMIT 1";
            $result = $this->query($query);

            if ($result && !empty($result[0]->id)) {
                return $result[0]->id; // Access id property of the first row
            } else {
                return null; // Return null if no record is found or id is empty
            }
        }


public function searchByDate($date)
{
    $query = "SELECT d.*, p.name AS pet_name, po.name AS pet_owner_name, po.contact AS pet_owner_contact
              FROM daycarebookinguser d
              JOIN pets p ON d.pet_id = p.id
              JOIN petowners po ON p.petowner_id = po.id
              WHERE d.drop_off_date = :date";

    return $this->query($query, [':date' => $date]);
}
  
    public function updateDaycarebooking($id, array $data)
        {
            // Filter out non-allowed columns
            $data = array_filter($data, function ($key) {
                return in_array($key, $this->allowedColumns);
            }, ARRAY_FILTER_USE_KEY);
        
            return $this->update($id, $data, 'id');
        }
 

    public function getPetOwneremail($id)
    {
       // Query to fetch petowner using daycarebookinguser id
         $query = "SELECT u.email
                  FROM daycarebookinguser dbu
                  JOIN pets p ON dbu.pet_id = p.id
                  JOIN petowners po ON p.petowner_id = po.id
                  JOIN users u ON po.user_id = u.id
                  WHERE dbu.id = :id";

        $bindings = [':id' => $id];
        $result = $this->query($query, $bindings);
        return $result[0]->email;
    }

        public function acceptDaycarebooking($id)
            {
                $query = "UPDATE daycarebookinguser SET status = 'accepted' WHERE id = :id AND status = 'pending'";
                $bindings = [':id' => $id];
                $result = $this->query($query, $bindings);
                return $result; // Return true or false based on the success of the update operation
            }



            public function declineDaycarebooking($id)
            {
                // Update the status of the daycare booking to 'declined'
                $query = "UPDATE daycarebookinguser SET status = 'declined' WHERE id = :id AND status = 'pending'";
                $bindings = [':id' => $id];
                $result = $this->query($query, $bindings);

                return $result; // Return true or false based on the success of the update operation
            }

            public function finishDaycarebooking($id){
                $query = "UPDATE daycarebookinguser SET status = 'finished' WHERE id = :id AND status = 'accepted'";
                $bindings = [':id' => $id];
                $result = $this->query($query, $bindings);
                return $result;
            }

            public function countTodayBookings() {
                // timezone 
                date_default_timezone_set('Asia/Colombo');
                //count today  from  created at datetime
                $query = "SELECT * FROM daycarebookinguser WHERE DATE(drop_off_date) = CURDATE()";
                $result = $this->query($query);

                if(!$result){
                    return 0;
                }
                return count($result);

            }

            public function countweekallBookings(){
                // timezone 
                date_default_timezone_set('Asia/Colombo');
                $query = "SELECT * FROM daycarebookinguser WHERE DATE(drop_off_date) BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
                $result = $this->query($query);
                // if not found
                if(!$result){
                    return 0;
                }
                return count($result);
            }

            public function countTodayacceptedBookings(){
                date_default_timezone_set('Asia/Colombo');
                $query = "SELECT * FROM daycarebookinguser WHERE DATE(drop_off_date) = CURDATE() AND status = 'accepted'";
                $result = $this->query($query);
                // if not found
                if(!$result){
                    return 0;
                }
                return count($result);
            }
            public function countDaycareBookingForWeek($week) {
                date_default_timezone_set('Asia/Colombo');
                // Get the start and end dates for the current month
                $startDate = date('Y-m-d', strtotime("first day of this month"));
                $endDate = date('Y-m-d', strtotime("last day of this month"));
            
                // Get the start dates for each week of the month
                $week1 = date('Y-m-d', strtotime("first day of this month"));
                $week2 = date('Y-m-d', strtotime("first day of this month + 1 week"));
                $week3 = date('Y-m-d', strtotime("first day of this month + 2 weeks"));
                $week4 = date('Y-m-d', strtotime("first day of this month + 3 weeks"));
            
                // Determine the start and end dates for the specified week
                if ($week == 1) {
                    $startDate = $week1;
                    $endDate = $week2;
                } elseif ($week == 2) {
                    $startDate = $week2;
                    $endDate = $week3;
                } elseif ($week == 3) {
                    $startDate = $week3;
                    $endDate = $week4;
                } elseif ($week == 4) {
                    $startDate = $week4;
                    $endDate = date('Y-m-d', strtotime("last day of this month"));
                }
            
                // Construct the SQL query to count daycare bookings for the specified week
                $query = "SELECT COUNT(*) AS total 
                          FROM daycarebookinguser 
                          WHERE drop_off_date >= :start_date 
                          AND drop_off_date < :end_date 
                          AND status = 'accepted'";
            
                // Set query parameters
                $params = [
                    ':start_date' => $startDate,
                    ':end_date' => $endDate
                ];
            
                // Execute the query
                $result = $this->query($query, $params);
            
                // Check if the query result is false
                if ($result === false) {
                    return 0;
                }
            
                // Return the count of daycare bookings
                return $result[0]->total ?? 0;  
            }
            
            
            public function countTodaydeclinedBookings(){
                date_default_timezone_set('Asia/Colombo');
                $query = "SELECT * FROM daycarebookinguser WHERE drop_off_date = CURDATE() AND status = 'declined'";
                $result = $this->query($query);
                // if not found
                if(!$result){
                    return 0;
                }

                return count($result);
            }

            public function getNotifications(){
            
                $query = "SELECT * FROM daycarebookinguser";
                $result = $this->query($query);
                return $result;
       
            }

        // Define validation rules
        public function validate($data)
        {
            $this->errors = [];
    
            if (empty($data['drop_off_time'])) {
                $this->errors['drop_off_time'] = "Drop off Time is required";
            }
            if (empty($data['pick_up_time'])) {
                $this->errors['pick_up_time'] = "Pick up Time is required";
            }
            
            if (empty($data['drop_off_date'])) {
                $this->errors['drop_off_date'] = "Drop off Date is required";
            }
    
            return empty($this->errors);
        }
         /////////////////////////////////////////////////////////////// reports   /////////////////////////////////////////////////

    //get the appointment count for given period for all vets
    public function countAllDaycareBookings($startDate, $endDate) {
        $query = "SELECT COUNT(*) AS total 
                  FROM {$this->table} 
                  WHERE created_at >= :start_date 
                  AND created_at < :end_date";
                  
        $params = [
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ];
        $result = $this->query($query, $params);
        return $result[0]->total ?? 0;  
    }

    public function countDaycareBookingsByStatus($status, $startDate, $endDate) {
        $query = "SELECT COUNT(*) AS total 
                  FROM {$this->table} 
                  WHERE status = :status
                  AND created_at >= :start_date 
                  AND created_at < :end_date";
        $params = [':status' => $status,
        ':start_date' => $startDate,
        ':end_date' => $endDate];
        $result = $this->query($query, $params);
        return $result[0]->total ?? 0;  // Default to 0 if no results found
    }
    
}


