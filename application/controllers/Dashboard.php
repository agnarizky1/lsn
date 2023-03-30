<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // DIRECT LINK SESUAI ROLE //
        // check_admin();
        check_login();
        // END DIRECT LINK SESUAI ROLE //
    }
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'user' => get_user(),
            'view' => 'dashboard/index'
        ];
        $this->load->view('template', $data);
    }
}
