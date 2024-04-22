<?php

class Petdetails
{
    use Controller;

    public function index(string $a = '', string $b = '', string $c = ''): void
    {
        $userdataModel = new MedicalStaffModel();
        $data['userdata'] = $userdataModel->getMedstaffRoleDataById($_SESSION['USER']->id);

        $petdetailsModel = new PetdetailsModel();
        $petDetails = $petdetailsModel->getAllPetDetails();

        // Calculate age for each pet
        foreach ($petDetails as $pet) {
            $pet->age = $this->calculateAge($pet->birthday);
        }

        $data['petdetails'] = $petDetails;
        $this->view('medicalstaff/petdetails', $data);
    }

    public function calculateAge($birthday) {
        $dateOfBirth = new DateTime($birthday);
        $today = new DateTime('today');
        return $dateOfBirth->diff($today)->y;
    }

    
}


