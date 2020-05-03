<?php
class Access extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };

        $this->load->model('M_access', 'access');
        $this->load->helper('text');
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->load->model('M_role', 'role');
        $this->load->model('M_menu', 'menu');
        
        $data['title'] = 'Access Management';
        $data['access'] = $this->access->get_all();
        $data['role'] = $this->role->get_all();
        $data['menu'] = $this->menu->get_all();

        $this->load->view('access/v_access', $data);
    }



    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->access->get_datatables();
        $data = array();
        $no = $this->input->post('start');

        foreach ($list as $myaccess) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $myaccess->role;
            $row[] =  $myaccess->menu;
            $row[] =  $myaccess->title;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit_access(' . "'" . $myaccess->id . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="delete_access(' . "'" . $myaccess->id . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->access->count_all(),
            "recordsFiltered" => $this->access->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->access->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_update()
    {
        $data = array(
            'role_id' => $this->input->post('role'),
            'menu_id' => $this->input->post('menu'),
            'submenu_id' => $this->input->post('submenu'),
        );

        $this->access->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {
        $menu = $this->input->post('menu');
        $submenu = $this->input->post('submenu');
        $role = $this->input->post('role');

        if (isset($submenu) && is_array($submenu)) {
            foreach ($submenu as $key => $value) {
                $data[$key] = array(
                    'menu_id' => $menu,
                    'submenu_id' => $value,
                    'role_id' => $role
                );
            }


            $this->db->insert_batch('tb_user_access_menu', $data);
        }else{
            $data = array(
                'menu_id' => $menu,
                'role_id' => $role
            );

            $this->db->insert('tb_user_access_menu', $data);
        }

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        //delete file

        $this->access->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
