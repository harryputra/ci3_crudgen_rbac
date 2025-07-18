<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* dev : mpampam*/
/* fb : https://facebook.com/mpampam*/
/* web : www.mpampam.com*/
/* Generate By M-CRUD Generator 04/11/2022 14:37*/
/* Location: ./application/modules/backend/models/Tbl_master_golongan_model.php*/
/* Please DO NOT modify this information */

class Tbl_master_golongan_model extends MY_Model{

  private $table        = "tbl_master_golongan";
  private $primary_key  = "id_golongan";
  private $column_order = ["golongan","uraian","level"];
  private $order        = ["id_golongan"=>"DESC"];
  private $select       = "id_golongan,golongan,uraian,level";

public function __construct()
	{
		$config = array(
      'table' 	      => $this->table,
			'primary_key' 	=> $this->primary_key,
		 	'select' 	      => $this->select,
      'column_order' 	=> $this->column_order,
      'order' 	      => $this->order,
		 );

		parent::__construct($config);
	}


  private function _get_datatables_query()
    {
      $this->db->select($this->select);
      $this->db->from($this->table);

      //filter
			if($this->input->post('golongan')){
				$this->db->like('golongan', $this->input->post('golongan'));
			}
			if($this->input->post('uraian')){
				$this->db->like('uraian', $this->input->post('uraian'));
			}
			if($this->input->post('level')){
				$this->db->like('level', $this->input->post('level'));
			}


      if(isset($_POST['order'])) // here order processing
       {
           $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
       }
       else if(isset($this->order))
       {
           $order = $this->order;
           $this->db->order_by(key($order), $order[key($order)]);
       }

    }


    public function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
      $this->db->select($this->select);
      $this->db->from($this->table);
      return $this->db->count_all_results();
    }


}
