<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* dev : mpampam*/
/* fb : https://facebook.com/mpampam*/
/* fanspage : https://web.facebook.com/programmerjalanan*/
/* web : www.mpampam.com*/
/* Generate By M-CRUD Generator 04/11/2022 14:37*/
/* Location: ./application/modules/backend/controllers/Tbl_master_golongan.php*/
/* Please DO NOT modify this information */


class Tbl_master_golongan extends Backend{

  private $title = "Tbl Master Golongan";

  public function __construct()
  {
    $config = array(
      'title' => $this->title,
     );
    parent::__construct($config);
    $this->load->model("Tbl_master_golongan_model","model");
  }

  function _rules()
  {
		$this->form_validation->set_rules('golongan', 'Golongan', 'trim|xss_clean|required');
		$this->form_validation->set_rules('uraian', 'Uraian', 'trim|xss_clean|required');
		$this->form_validation->set_rules('level', 'Level', 'trim|xss_clean|required');
		$this->form_validation->set_error_delimiters('<i class="text-danger" style="font-size:11px">', '</i>');
  }

  function index()
  {
    $this->is_allowed('tbl_master_golongan_list');
    $this->template->set_title("$this->title");
    $this->template->view("content/tbl_master_golongan/index");
  }

  function json()
  {
    if ($this->input->is_ajax_request()) {
      if (!is_allowed('tbl_master_golongan_list')) {
        show_error("Access Permission", 403,'403::Access Not Permission');
        exit();
      }

      $rows = $this->model->get_datatables();
      $data = array();
      foreach ($rows as $get) {
          $row = array();
					$row[] = $get->golongan;
					$row[] = $get->uraian;
					$row[] = $get->level;
          $row[] = '
                      <div class="btn-group" role="group" aria-label="Basic example">
                          <a href="'.url("tbl_master_golongan/detail/".enc_url($get->id_golongan)).'" id="detail" class="btn btn-primary" title="'.cclang("detail").'">
                            <i class="ti-file"></i>
                          </a>
                          <a href="'.url("tbl_master_golongan/update/".enc_url($get->id_golongan)).'" id="update" class="btn btn-warning" title="'.cclang("upadte").'">
                            <i class="ti-pencil"></i>
                          </a>
                          <a href="'.url("tbl_master_golongan/delete/".enc_url($get->id_golongan)).'" id="delete" class="btn btn-danger" title="'.cclang("delete").'">
                            <i class="ti-trash"></i>
                          </a>
                        </div>
                   ';

          $data[] = $row;
      }

      $output = array(
                      "draw" => $_POST['draw'],
                      "recordsTotal" => $this->model->count_all(),
                      "recordsFiltered" => $this->model->count_filtered(),
                      "data" => $data,
              );
      //output to json format
      return $this->response($output);
    }
  }


  function filter()
  {
    $this->template->view("content/tbl_master_golongan/filter",[],false);
  }

  function detail($id = null)
  {
    $this->is_allowed('tbl_master_golongan_detail');
    if ($row = $this->model->find(dec_url($id))) {
      $this->template->set_title(cclang("detail")." $this->title");
      $data = array(
										'golongan' => $row->golongan,
										'uraian' => $row->uraian,
										'level' => $row->level,
                    );
      $this->template->view("content/tbl_master_golongan/detail",$data);
    }else {
      $this->error404();
    }
  }


  function add()
  {
    $this->is_allowed('tbl_master_golongan_add');
    $this->template->set_title(cclang("add")." $this->title");
    $data = array('action' => url("tbl_master_golongan/add_action"),
                  'params' => "add",
									'golongan' => set_value('golongan'),
									'uraian' => set_value('uraian'),
									'level' => set_value('level'),
                  );
    $this->template->view("content/tbl_master_golongan/form",$data);
  }


  function add_action()
  {
    if($this->input->is_ajax_request()){
      if (!is_allowed('tbl_master_golongan_add')) {
        show_error("Access Permission", 403,'403::Access Not Permission');
        exit();
      }

      $json = array('success' => false, "alert" => array());
      $this->_rules();
      if ($this->form_validation->run()) {
				$save_data['golongan'] = $this->input->post('golongan',true);
				$save_data['uraian'] = $this->input->post('uraian',true);
				$save_data['level'] = $this->input->post('level',true);

        $this->model->insert($save_data);
        set_message("success",cclang("notif_save"));

        $json['redirect'] = url("tbl_master_golongan");
        $json['success'] = true;
      }else {
        foreach ($_POST as $key => $value) {
          $json['alert'][$key] = form_error($key);
        }
      }
      return $this->response($json);
    }
  }

  function update($id = null)
  {
    $this->is_allowed('tbl_master_golongan_update');
    if ($row = $this->model->find(dec_url($id))) {
      $this->template->set_title(cclang("update")." $this->title");
      $data = array('action' => url("tbl_master_golongan/update_action/$id"),
                    'params' => "update",
										'golongan' => set_value('golongan',$row->golongan),
										'uraian' => set_value('uraian',$row->uraian),
										'level' => set_value('level',$row->level),
                    );
      $this->template->view("content/tbl_master_golongan/form",$data);
    }else {
      $this->error404();
    }
  }

  function update_action($id = null)
  {
    if($this->input->is_ajax_request()){
      if (!is_allowed('tbl_master_golongan_update')) {
        show_error("Access Permission", 403,'403::Access Not Permission');
        exit();
      }

      $json = array('success' => false, "alert" => array());
      $this->_rules();
      if ($this->form_validation->run()) {
				$save_data['golongan'] = $this->input->post('golongan',true);
				$save_data['uraian'] = $this->input->post('uraian',true);
				$save_data['level'] = $this->input->post('level',true);

        $this->model->change(dec_url($id), $save_data);
        set_message("success",cclang("notif_update"));

        $json['redirect'] = url("tbl_master_golongan");
        $json['success'] = true;
      }else {
        foreach ($_POST as $key => $value) {
          $json['alert'][$key] = form_error($key);
        }
      }
      return $this->response($json);
    }
  }


  function delete($id = null)
  {
    if ($this->input->is_ajax_request()) {

        if (!is_allowed('tbl_master_golongan_delete')) {
          return $this->response([
            'type_msg' => "error",
            'msg' => "Do not have permission to access"
  				]);
        }

        $remove = $this->model->remove(dec_url($id));
        if ($remove) {
          $json['type_msg'] = "success";
          $json['msg'] = cclang("notif_delete");
        }else {
          $json['type_msg'] = "error";
          $json['msg'] = cclang("notif_delete_failed");
        }
        return $this->response($json);
    }
  }


}
