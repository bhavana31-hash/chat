<?php namespace App\Controllers;

use App\Models\UserModel;


class Users extends BaseController
{
	public function index()
	{

		$session = session();
        $sess= $session->get();
        // print_r($data) ; die();
        if(isset($sess['isLoggedIn']) && $sess['isLoggedIn'] && $sess['sessiontoken'] !== '')
            return redirect()->to('/dashboard');


		$data = [];
		$session = session();
		helper(['form']);
		// print_r($this->request->getMethod());die;

		if ($this->request->getMethod() == 'POST') {
			//let's do the validation here
			$rules = [
				'username' => 'required|min_length[4]|max_length[50]',
				'password' => 'required|min_length[8]|max_length[255]',
			];

			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
				
			}else{
				$model = new UserModel();

				$user = $model->where('username', $this->request->getVar('username'))->first();
				// print_r($user);die;
				if(is_null($user)) {
					$session->setFlashdata('msg', 'User Not Found..');
					return redirect()->to('/');
				}

				$pwd_verify = password_verify($this->request->getVar('password'), $user['password']);
				
        		if(!$pwd_verify){
					$session->setFlashdata('msg', 'Password is incorrect.');
					return redirect()->to('/');    
				}else{
					
					$my_token = md5(uniqid(rand(), true));
					$ses_data = [
						'id' => $user['id'],
						'username' => $user['username'],
						'sessiontoken' => $my_token,
						'isLoggedIn' => TRUE
					];
					
					$session->set($ses_data);
					$session->setFlashdata('success', 'Successful loggedin');
					return redirect()->to('dashboard');
				}
				

			}
		}else{
			echo view('templates/header', $data);
			echo view('login');
			echo view('templates/footer');
		}

		
	}

	private function setUserSession($user){
		$data = [
			'id' => $user['id'],
			'username' => $user['username'],
			
			'email' => $user['email'],
			'isLoggedIn' => true,
		];

		session()->set($data);
		return true;
	}

	public function register(){
		$data = [];
		
		helper(['form']);
		// print_r($this->request->getMethod());die;
		if ($this->request->getMethod() == 'POST') {
			// echo "post" ;die;
			//let's do the validation here
			$rules = [
				'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
				
				'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
				'password' => 'required|min_length[8]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			if (!$this->validate($rules)) {
				
				$data['validation'] = $this->validator;
				echo view('templates/header', $data);
				echo view('register');
				echo view('templates/footer');
			}else{
								
				$model = new UserModel();

				$newData = [
					'username' => $this->request->getVar('username'),
					
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
				];
				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', 'Successful Registration');
				return redirect()->to('/');

			}
		}else{
			echo view('templates/header', $data);
			echo view('register');
			echo view('templates/footer');
		}

		// print_r($data);die();
		
	}

	public function profile(){
		// print_r(session()->get('isLoggedIn'));die;
		$data = [];
		helper(['form']);
		$model = new UserModel();

		if ($this->request->getMethod() == 'POST') {
			//let's do the validation here
			$rules = [
				'username' => 'required|min_length[3]|max_length[20]',
				
				];

			if($this->request->getPost('password') != ''){
				$rules['password'] = 'required|min_length[8]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}


			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{

				$newData = [
					'id' => session()->get('id'),
					'username' => $this->request->getPost('username'),
					
					];
					if($this->request->getPost('password') != ''){
						$newData['password'] = $this->request->getPost('password');
					}
				$model->save($newData);

				session()->setFlashdata('success', 'Successfuly Updated');
				return redirect()->to('/profile');

			}
		}

		$data['user'] = $model->where('id', session()->get('id'))->first();
		echo view('templates/header', $data);
		echo view('profile');
		echo view('templates/footer');
	}

	public function logout(){
		session()->destroy();
		return redirect()->to('/');
	}

	//--------------------------------------------------------------------

}
