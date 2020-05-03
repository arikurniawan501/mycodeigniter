<?php
class Role extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };

        $this->load->model('M_role', 'role');
        $this->load->helper('text');
        $this->load->library('form_validation');
    }

    function index()
    {
        $data['title'] = 'Role Management';
        $data['role'] = $this->role->get_all();
        // var_dump($data['menu'][0]);
        $this->load->view('role/v_role', $data);
    }



    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->role->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $myrole) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $myrole->role;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit_role(' . "'" . $myrole->id . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="delete_role(' . "'" . $myrole->id . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->role->count_all(),
            "recordsFiltered" => $this->role->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->role->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_update()
    {
        $data = array(
            'role' => $this->input->post('role'),
        );

        $this->role->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {

        $data = array(
            'role' => $this->input->post('role'),
        );
        $insert = $this->role->save($data);

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        //delete file

        $this->role->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
