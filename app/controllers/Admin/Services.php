<?php 

/**
 * services class
 */
class Services
{
	use Controller;

	public function index()
	{

		$data['username'] = empty($_SESSION['USER']) ? 'User':$_SESSION['USER']->email;

		$this->view('admin/services',$data);
	}

}