<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Myconfig extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_user', 'user');
	}

	public function index()
	{
		if ($this->session->userdata('status_login') != "login") {
			$data = array('page_title' => "Login",);
			$this->load->view('myconfig/v_login', $data);
		} else {
			$this->load->view('v_dashboard');
		}
	}

	function aksilogin()
	{
		$username = $this->input->post('username');
		$password = password_verify($this->input->post('password'), TRUE);
		$where = array(
			'username' => $username,
		);
		$cek_fase_1 = $this->user->cek_login($where)->num_rows();
		$cek_fase_2 = $this->user->cek_login($where)->row();
		if ($cek_fase_1 > 0) {

			$password_encrypt = password_verify($password, $cek_fase_2->password);
			if ($password == $password_encrypt) {
				$data_session = array(
					'id_user'       => $cek_fase_2->id_user,
					'username' => $cek_fase_2->username,
					'role_id'	=> $cek_fase_2->role_id,
					'status_login'  => "login"
				);
				$this->session->set_userdata($data_session);
				//$this->rat->log('Login sukses! Dengan IP : '.$this->session->userdata('jabatan'),$this->session->userdata('id_user')); 
				redirect(base_url());
			} else {
				$this->session->set_flashdata("alert", "<script>
                    $.notify({
                        icon: 'report',
                        title: '<strong>Gagal !!</strong><br>',
                        message: 'Password tidak valid!!',
                    },{
                        type: 'danger',
                        timer: 3000,
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                    });
                </script>");

				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata("alert", "<script>
					$.notify({
						icon: '',
						title: '<strong>Gagal Login!!</strong><br>',
						message: 'Username tidak terdaftar!!',
					},{
						type: 'danger',
						timer: 3000,
						placement: {
							from: 'top',
							align: 'right'
						},
					});
				</script>");
			//$this->rat->log('Login Gagal! Dengan IP : '.$this->tampilkanip(),0); 
			redirect(base_url());
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
