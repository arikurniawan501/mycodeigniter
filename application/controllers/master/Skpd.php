<?php
class Skpd extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('Master/M_skpd', 'skpd');
        $this->load->helper('text');
    }

    function index()
    {
        $data['title'] = 'Data SKPD';
        $this->load->view('Master/v_skpd', $data);
    }
    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->skpd->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $myskpd) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $myskpd->n_skpd;
            $row[] =  $myskpd->inisial_skpd;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit_person(' . "'" . $myskpd->id_skpd . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="delete_person(' . "'" . $myskpd->id_skpd . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->skpd->count_all(),
            "recordsFiltered" => $this->skpd->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->skpd->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_update()
    {
        $data = array(
            'n_skpd' => $this->input->post('n_skpd'),
            'inisial_skpd' => $this->input->post('inisial_skpd'),
        );

        $this->skpd->update(array('id_skpd' => $this->input->post('id_skpd')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {

        $data = array(
            'n_skpd' => $this->input->post('n_skpd'),
            'inisial_skpd' => $this->input->post('inisial_skpd'),

        );

        $insert = $this->skpd->save($data);

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        //delete file

        $this->kategori->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
