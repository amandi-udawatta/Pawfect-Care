<?php 

/**
 * myprofile class
 */
class MyProfile
{
	use Controller;

	public function index()
	{
        AuthorizationMiddleware::authorize(['Medical Staff']);
		$userdataModel = new MedicalStaffModel();
		$data['userdata'] = $userdataModel->getMedstaffRoleDataById($_SESSION['USER']->id);

		$this->view('medicalstaff/myprofile',$data);
	}

}
