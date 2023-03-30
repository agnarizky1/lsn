<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Ajax extends CI_Controller {
    public function get_data_role_user(){
        validation_ajax_request();
        $data = [
            'data' => $this->m->get_role_user()->result()
        ];
        $this->load->view('ajax/master/role_user', $data);
    }

    public function get_data_menu(){
        validation_ajax_request();
        $data = [
            'data' => $this->m->get_menu()->result()
        ];
        $this->load->view('ajax/master/menu', $data);
    }

    public function get_data_cabang(){
        validation_ajax_request();
        $data = [
            'data' => $this->m->get_cabang()->result()
        ];
        $this->load->view('ajax/master/cabang', $data);
    }

    public function load_data_member(){
        validation_ajax_request();
        $data = [
            'data' => $this->m->get_member()->result()
        ];
        $this->load->view('ajax/master/member', $data);
    }

    public function load_data_anggota(){
        validation_ajax_request();
        $id = $_POST['id'];
        $data = [
            'data' => $this->m->get_member($id)->row()
        ];
        $this->load->view('ajax/master/member_detail', $data);
    }

    public function coba(){
        $date = '22-9-2003';
        $p = date_create($date);
        echo date_format($p, 'Y-m-d');

    }
    


}