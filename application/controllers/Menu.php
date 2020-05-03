<?php
class Menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('M_menu', 'menu');
        $this->load->helper('text');
        $this->load->library('form_validation');
    }

    function index()
    {
        $data['title'] = 'Menu Management';
        $data['menu'] = $this->menu->get_all();
        // var_dump($data['menu'][0]);
        $this->load->view('menu/v_menu', $data);
    }



    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->menu->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $mymenu) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $mymenu->menu;
            $row[] =  $mymenu->icon;
            $row[] =  $mymenu->url;
            $row[] =  $mymenu->no_urut;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit_person(' . "'" . $mymenu->id . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="delete_person(' . "'" . $mymenu->id . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->menu->count_all(),
            "recordsFiltered" => $this->menu->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->menu->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_update()
    {
        $data = array(
            'menu' => $this->input->post('menu'),
            'icon' => $this->input->post('icon'),
            'url' => $this->input->post('url'),
            'no_urut'=> $this->input->post('urutan'),
        );

        $this->menu->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {

        $data = array(
            'menu' => $this->input->post('menu'),
            'icon' => $this->input->post('icon'),
            'url' => $this->input->post('url'),
            'no_urut'=> $this->input->post('urutan'),
            'isParent' => 1,
        );
        $insert = $this->menu->save($data);

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        //delete file

        $this->jabatan->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
