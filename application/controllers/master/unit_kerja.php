<?php
class Unit_kerja extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('Master/M_unit_kerja', 'u_kerja');
        $this->load->model('Master/M_skpd', 'skpd');
        $this->load->helper('text');
    }

    function index()
    {
        $data = array(
            'data_skpd' => $this->skpd->get_all(),
            'title' => 'Data Unit Kerja',
        );
        $this->load->view('Master/v_unit_kerja', $data);
    }
    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->u_kerja->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $my_ukerja) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $my_ukerja->n_unitkerja;
            $row[] =  $my_ukerja->n_skpd;
            $row[] =  $my_ukerja->initial_unitkerja;

            //add html for action
            $row[] = '<center><a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit_person(' . "'" . $my_ukerja->id_unitkerja . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="delete_person(' . "'" . $my_ukerja->id_unitkerja . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->u_kerja->count_all(),
            "recordsFiltered" => $this->u_kerja->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->u_kerja->get_by_id($id);
        echo json_encode($data);
    }
    public function ajax_update()
    {
        $data = array(
            'n_unitkerja' => $this->input->post('n_unitkerja'),
            'unitkerja_skpd' => $this->input->post('unitkerja_skpd'),
            'initial_unitkerja' => $this->input->post('initial_unitkerja'),
        );

        $this->u_kerja->update(array('id_unitkerja' => $this->input->post('id_unitkerja')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {

        $data = array(
            'n_unitkerja' => $this->input->post('n_unitkerja'),
            'unitkerja_skpd' => $this->input->post('unitkerja_skpd'),
            'initial_unitkerja' => $this->input->post('initial_unitkerja'),

        );

        $insert = $this->u_kerja->save($data);

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        $this->u_kerja->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
