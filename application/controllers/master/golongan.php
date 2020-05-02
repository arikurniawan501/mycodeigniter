<?php
class Golongan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('Master/M_golongan', 'gol');
        $this->load->helper('text');
    }

    function index()
    {
        $data['title'] = 'Data Golongan';
        $this->load->view('Master/v_golongan', $data);
    }
    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->gol->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $mygol) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $mygol->n_golongan;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit_person(' . "'" . $mygol->id_golongan . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="delete_person(' . "'" . $mygol->id_golongan . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->gol->count_all(),
            "recordsFiltered" => $this->gol->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->gol->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_update()
    {
        $data = array(
            'n_golongan' => $this->input->post('n_golongan'),
        );

        $this->gol->update(array('id_golongan' => $this->input->post('id_golongan')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {

        $data = array(
            'n_golongan' => $this->input->post('n_golongan'),

        );
        $insert = $this->gol->save($data);

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        //delete file

        $this->jabatan->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
