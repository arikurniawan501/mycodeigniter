<?php
class Submenu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('M_submenu', 'submenu');
        $this->load->helper('text');
        $this->load->library('form_validation');
    }

    function index()
    {
        $this->load->model('M_menu', 'menu');
        $data['title'] = 'Sub Menu Management';

        $data['subMenu'] = $this->submenu->get_all();
        $data['menu'] = $this->menu->get_all();
        // var_dump($data['menu'][0]);
        $this->load->view('submenu/v_submenu', $data);
    }



    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->submenu->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $mysubmenu) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $mysubmenu->title;
            $row[] =  $mysubmenu->menu;
            $row[] =  $mysubmenu->url;
            $row[] =  $mysubmenu->icon;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit(' . "'" . $mysubmenu->id . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="remove(' . "'" . $mysubmenu->id . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->submenu->count_all(),
            "recordsFiltered" => $this->submenu->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->submenu->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_update()
    {
        $data = array(
            'title' => $this->input->post('menu'),
            'menu_id' => $this->input->post('parent'),
            'icon' => $this->input->post('icon'),
            'url' => $this->input->post('url'),            
        );

        $this->submenu->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {

        $data = array(
            'title' => $this->input->post('menu'),
            'menu_id' => $this->input->post('parent'),
            'icon' => $this->input->post('icon'),
            'url' => $this->input->post('url'),
        );
        $insert = $this->submenu->save($data);

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        //delete file

        $this->submenu->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
