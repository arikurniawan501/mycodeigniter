<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_access extends CI_Model
{
    public $table = 'tb_user_access_menu';
    var $column_order = array('role', null, 'menu', 'title'); //set column field database for datatable orderable
    var $column_search = array('role', 'menu', 'title'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('role' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_all()
    {
        $this->db->from($this->table);
        $this->db->join('tb_user_role', 'tb_user_access_menu.role_id = tb_user_role.id');
        $this->db->join('tb_user_menu', 'tb_user_access_menu.menu_id = tb_user_menu.id');
        $this->db->join('tb_user_sub_menu', 'tb_user_access_menu.submenu_id = tb_user_sub_menu.id', 'left');

        return $this->db->get();
    }
    private function _get_datatables_query()
    {

        $this->db->select('tb_user_access_menu.*, tb_user_role.role, tb_user_menu.menu, tb_user_sub_menu.title');
        $this->db->from($this->table);
        $this->db->join('tb_user_role', 'tb_user_access_menu.role_id = tb_user_role.id');
        $this->db->join('tb_user_menu', 'tb_user_access_menu.menu_id = tb_user_menu.id');
        $this->db->join('tb_user_sub_menu', 'tb_user_access_menu.submenu_id = tb_user_sub_menu.id', 'left');

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function get_where($where)
    {
        return $this->db->query('select * from tb_user_access_menu ' . $where)->result();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function get_by_id($id)
    {
        $this->db->select('tb_user_access_menu.*');
        $this->db->from($this->table);
        $this->db->join('tb_user_role', 'tb_user_access_menu.role_id = tb_user_role.id');
        $this->db->join('tb_user_menu', 'tb_user_access_menu.menu_id = tb_user_menu.id');
        $this->db->join('tb_user_sub_menu', 'tb_user_access_menu.submenu_id = tb_user_sub_menu.id', 'left');
        $this->db->where('tb_user_access_menu.id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

	function menu_by_role($role)
	{
		$this->db->select('tb_user_access_menu.*, tb_user_menu.menu, tb_user_menu.url, tb_user_menu.icon, tb_user_menu.no_urut');
		$this->db->from($this->table);
		$this->db->join('tb_user_menu', 'tb_user_access_menu.menu_id = tb_user_menu.id');
		$this->db->where('role_id', $role);
		$this->db->group_by('menu_id');
		$this->db->order_by('tb_user_menu.no_urut');

		$query = $this->db->get();
		return $query->result();
	}

	function submenu_by_role($role)
	{
		$this->db->select('*');
		$this->db->from($this->table);
		$this->db->join('tb_user_sub_menu', 'tb_user_access_menu.submenu_id = tb_user_sub_menu.id');
		$this->db->where('role_id', $role);
		$this->db->order_by('tb_user_sub_menu.no_urut');

		$query = $this->db->get();
		return $query->result();
	}
}
