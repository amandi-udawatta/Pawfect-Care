<?php 

class EditPetDetails
{
	use Controller;

	public function index()
	{
		AuthorizationMiddleware::authorize(['Receptionist']);
		$userdataModel = new ReceptionistsModel();
		$data['userdata'] = $userdataModel->getReceptionistRoleDataById($_SESSION['USER']->id);

		$this->view('receptionist/editpetdetails',$data);
	}

}
