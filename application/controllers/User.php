<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
    }

    public function index()
    {
        $data = [
            'title' => 'User',
            'user' => get_user(),
            'view' => 'user/index'
        ];
        $this->load->view('template', $data);
    }

    public function setting()
    {
        $data = [
            'title' => 'User Settings',
            'user' => get_user(),
            'view' => 'user/setting'
        ];
        $this->load->view('template', $data);
    }

    private function crop_image($file = null)
    {
        $config['image_library'] = 'gd2';
        $config['source_image'] = './assets/img/user/' . $file;
        $config['maintain_ratio'] = false;
        $config['width']         = 512;
        $config['height']       = 512;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

    public function change_setting()
    {

        $name = htmlspecialchars($this->input->post('nama', true));
        $img = $_FILES['foto'];
        $user = get_user();

        if ($img) {
            $file_name = 'lsn_user_' . time();
            $config['upload_path'] = './assets/img/user/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $file_name;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $file = $this->upload->data('file_name');
                $this->crop_image($file);

                if ($user->img != 'default.png') {
                    unlink('./assets/img/user/' . $user->img);
                }
            } else {
                $file = $user->img;
            }

            $data = [
                'nama' => $name,
                'img' => $file
            ];
            $this->db->where('email', $this->session->userdata('email'))->update('user', $data);
            redirect('user/setting');
        }
    }

    public function change_password()
    {
        validation_ajax_request();
        $this->form_validation->set_rules('old_pass', 'Password lama', 'required|trim');
        $this->form_validation->set_rules('new_pass', 'Password baru', 'required|trim|min_length[5]|matches[re_new]');
        $this->form_validation->set_rules('re_new', 'Ulangi password baru', 'required|trim|matches[new_pass]');

        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_old' => form_error('old_pass'),
                'err_new' => form_error('new_pass'),
                'err_re' => form_error('re_new')
            ];
        } else {
            $new_pass = md5(sha1($this->input->post('new_pass')));
            $old_pass = md5(sha1($this->input->post('old_pass')));
            $user = get_user();

            if ($new_pass == $user->password) {
                $params = [
                    'type' => 'result',
                    'success' => false,
                    'msg' => 'Password baru tidak boleh sama dengan password lama'
                ];
            } else {
                if ($old_pass != $user->password) {
                    $params = [
                        'type' => 'result',
                        'success' => false,
                        'msg' => 'Password lama salah'
                    ];
                } else {
                    $this->db->set('password', $new_pass)->where('email', $this->session->userdata('email'))->update('user');
                    if ($this->db->affected_rows() > 0) {
                        $params = [
                            'type' => 'result',
                            'success' => true,
                            'msg' => 'Password berhasil di ubah'
                        ];
                    } else {
                        $params = [
                            'type' => 'result',
                            'success' => false,
                            'msg' => 'Password gagal di ubah'
                        ];
                    }
                }
            }
        }
        echo json_encode($params);
    }
    // UPLOAD FILE KTP
    public function upload_ktp()
    {
        $file_ktp = $_FILES['file_ktp'];
        $user = get_user();

        if ($file_ktp) {
            $file_name = 'lsn_ktp_user_' . time();
            $config['upload_path'] = './assets/img/ktp/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['file_name'] = $file_name;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('file_ktp')) {
                $file = $this->upload->data('file_name');
                $this->crop_image($file);

                if ($user->img != 'default-image.jpg') {
                    unlink('./assets/img/ktp/' . $user->file_ktp);
                }
            } else {
                $file = $user->file_ktp;
            }

            $data = [
                'file_ktp' => $file
            ];
            $this->db->where('email', $this->session->userdata('email'))->update('user', $data);
            redirect('user/setting');
        }
    }
    // END UPLOAD FILE KTP
}
