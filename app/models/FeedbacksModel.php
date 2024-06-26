<?php

class FeedbacksModel
{
    use Model;

    protected $table = 'feedbacks';
    protected $allowedColumns = ['id', 'feedback', 'date', 'petowner_id', 'status'];

    public function getAllFeedbacks()
    {
        $query = "SELECT f.*, po.name AS owner_name
        FROM feedbacks f
        JOIN petowners po 
        ON f.petowner_id = po.id";

        return $this->query($query);
        return $this->findAll();
    }

    public function getPostedFeedbacks()
    {
        $query = "SELECT f.*, po.name AS owner_name
        FROM feedbacks f
        JOIN petowners po 
        ON f.petowner_id = po.id
        WHERE f.status = 'posted'";

        return $this->query($query);
        return $this->findAll();
    }

public function getNotPostedFeedbacks()
{
    $query = "SELECT f.*, po.name AS owner_name
              FROM feedbacks f
              JOIN petowners po 
              ON f.petowner_id = po.id
              WHERE f.status = 'not posted'";

    $feedbacks = $this->query($query);

    // Check if there are feedbacks
    if ($feedbacks && count($feedbacks) > 0) {
        return $feedbacks;
    } else {
        return "No feedbacks at the moment.";
    }
}
   
// public function getNotPostedandRejectedFeedbacks()
// {
//     $query = "SELECT f.*, po.name AS owner_name
//               FROM feedbacks f
//               JOIN petowners po 
//               ON f.petowner_id = po.id
//               WHERE f.status = 'not posted' OR f.status = 'rejected'";

//     $feedbacks = $this->query($query);

//     // Check if there are feedbacks
//     if ($feedbacks && count($feedbacks) > 0) {
//         return $feedbacks;
//     } else {
//         return "No feedbacks at the moment.";
//     }
// }

    public function getFeedbacksByOwner($ownerId)
    {
        $query = "SELECT f.*, po.name AS owner_name
        FROM feedbacks f
        JOIN petowners po 
        ON f.petowner_id = po.id
        WHERE f.petowner_id = :owner_id";

        return $this->query($query, ['owner_id' => $ownerId]);
}


    public function search($term)
    {
        $term = "%{$term}%";
        $query = "SELECT f.*, po.name AS owner_name
                FROM {$this->table} AS f
                JOIN petowners AS po ON f.petowner_id = po.id 
                WHERE f.feedback LIKE :term
                OR po.name LIKE :term";
        
        return $this->query($query, [':term' => $term]);
    }

    public function getFeedbackById($id)
    {
        $query = "SELECT f.*, po.name AS owner_name
        FROM feedbacks f
        JOIN petowners po 
        ON f.petowner_id = po.id
        WHERE f.id= :id";

        return $this->get_row($query, ['id' => $id]);
    }

    public function addFeedback($data)
    {
        return $this->insert($data);
    }

    public function updateFeedback($id, array $data)
    {
        // alowed column
        $data = array_filter($data, function ($key) {
            return in_array($key, $this->allowedColumns);
        }, ARRAY_FILTER_USE_KEY);
    
        return $this->update($id, $data, 'id');
    }
    
    public function deleteFeedback($id)
    {
        return $this->delete($id);
    }

    public function removeFeedback($id)
    {
        $feedbackData = $this->getFeedbackById($id);
        if ($feedbackData) {
            $query = "UPDATE $this->table SET status = :status WHERE id = :id";
            return $this->query($query, ['status' => 'not posted', 'id' => $id]);
        }

        return false;
    }
    public function postFeedback($id)
    {
        $feedbackData = $this->getFeedbackById($id);
        if ($feedbackData) {
            $query = "UPDATE $this->table SET status = :status WHERE id = :id";
            return $this->query($query, ['status' => 'posted', 'id' => $id]);
        }

        return false;
    }
   
    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['feedback'])) {
            $this->errors['feedback'] = "Feedback is required";
        }


        return empty($this->errors);
    }
}


