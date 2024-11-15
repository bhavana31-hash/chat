<?php 
namespace App\Controllers;
use App\Models\UserModel;

class Chat extends BaseController
{
	public function index()
	{
		$data = [];
		$userModel = new UserModel();
		$session = session();
        $sess= $session->get();
		
		$users= $userModel->where('id != ', $sess['id'])->findAll();
		$data = ["users" => $users];



		echo view('templates/header', $data);
		echo view('chat');
		echo view('templates/footer');
	}

	//--------------------------------------------------------------------

	public function send(){
		$data= [];
		
		die;
	} 

	public function chatDemo()
	{

		echo view('chat_view');
	}

}
