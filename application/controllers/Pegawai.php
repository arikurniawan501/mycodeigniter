<?php
class Pegawai extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('status_login') != "login") {
            $url = base_url();
            redirect($url);
        };
        $this->load->model('M_pegawai', 'pegawaiku');
        $this->load->model('Master/M_skpd', 'skpd');
        $this->load->model('Master/M_jabatan', 'jabatan');
        $this->load->model('Master/M_unit_kerja', 'unitkerja');
        $this->load->helper('text');
    }

    function index()
    {
        $data = array(
            'data_skpd' => $this->skpd->get_all(),
            'data_jabatan' => $this->jabatan->get_all(),
            'data_unitkerja' => $this->unitkerja->get_all(),
            'data_unitkerja' => $this->unitkerja->get_all(),
            'title' => "Data Pegawai"
        );

        $this->load->view('pegawai/v_pegawai', $data);
    }
    public function ajax_list()
    {
        $this->load->helper('url');

        $list = $this->pegawaiku->get_datatables();
        $data = array();
        $no = $this->input->post('start');
        foreach ($list as $mypegawai) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] =  $mypegawai->nip;
            $row[] =  $mypegawai->nama;
            $row[] =  $mypegawai->no_hp;
            $row[] =  $mypegawai->n_skpd;
            $row[] =  $mypegawai->n_jabatan;
            $row[] =  $mypegawai->n_unitkerja;
            //add html for action


            //add html for action
            $row[] =  '
            <a href="' . base_url('pegawai/edit/' . $mypegawai->id_pegawai) . '" class="btn btn-secondary btn-sm"><i class="fa fa-user"></i></a>
             <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Edit" onclick="edit_person(' . "'" . $mypegawai->id_pegawai . "'" . ')"><i class="fa fa-edit"></i></a>
				      <a class="btn btn-sm btn-secondary" href="javascript:void(0)" title="Hapus" onclick="delete_person(' . "'" . $mypegawai->id_pegawai . "'" . ')"><i class="fa fa-trash"></i> </a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pegawaiku->count_all(),
            "recordsFiltered" => $this->pegawaiku->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    public function ajax_edit($id)
    {
        $data = $this->pegawaiku->get_by_id($id);
        echo json_encode($data);
    }

    public function edit($id)
    {
        $row = $this->pegawaiku->get_by_id($id);
        if ($row) {
            $data = array(
                'nip'                   => $row->nip,
                'username'              => $row->username,
                'password'              => $row->password,
                'nama'                  => $row->nama,
                'title' => "Edit Data Pegawai"

            );
            $this->load->view('pegawai/v_edit_pegawai', $data);
        } else {
            $this->session->set_flashdata('message', 'swal({
                title: "Alert",
                text: "Data Tidak Ditemukan !",
                buttonsStyling: false,
                confirmButtonClass: "btn btn-danger",
                type: "warning"
            })');
            redirect(site_url('pegawai'));
        }
    }

    public function ajax_update()
    {
        $data = array(
            'nip' => $this->input->post('nip'),
            'nama' => $this->input->post('nama'),
            'no_hp' => $this->input->post('no_hp'),
            'pegawai_skpd' => $this->input->post('pegawai_skpd'),
            'pegawai_jabatan' => $this->input->post('pegawai_jabatan'),
            'pegawai_unitkerja' => $this->input->post('pegawai_unitkerja'),
        );

        $this->pegawaiku->update(array('id_pegawai' => $this->input->post('id_pegawai')), $data);
        echo json_encode(array("status" => TRUE));
    }
    public function ajax_add()
    {

        $data = array(
            'nip' => $this->input->post('nip'),
            'nama' => $this->input->post('nama'),
            'no_hp' => $this->input->post('no_hp'),
            'pegawai_skpd' => $this->input->post('pegawai_skpd'),
            'pegawai_jabatan' => $this->input->post('pegawai_jabatan'),
            'pegawai_unitkerja' => $this->input->post('pegawai_unitkerja'),
        );
        $insert = $this->pegawaiku->save($data);

        echo json_encode(array("status" => TRUE));
    }
    public function ajax_delete($id)
    {
        //delete file

        $this->pegawaiku->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
}
