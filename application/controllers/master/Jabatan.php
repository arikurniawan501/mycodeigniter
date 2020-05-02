<?php
class Jabatan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('Master/M_jabatan', 'jabatan');
        $this->load->helper('text');
    }

    function index()
    {
        $data['title'] = 'Data jabatan';
        $this->load->view('Master/v_jabatan', $data);
    }
    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->jabatan->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $myjabatan) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $myjabatan->n_jabatan;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit_person(' . "'" . $myjabatan->id_jabatan . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="delete_person(' . "'" . $myjabatan->id_jabatan . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jabatan->count_all(),
            "recordsFiltered" => $this->jabatan->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->jabatan->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_update()
    {
        $data = array(
            'n_jabatan' => $this->input->post('n_jabatan'),
        );

        $this->jabatan->update(array('id_jabatan' => $this->input->post('id_jabatan')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {

        $data = array(
            'n_jabatan' => $this->input->post('n_jabatan'),

        );
        $insert = $this->jabatan->save($data);

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        //delete file

        $this->jabatan->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
