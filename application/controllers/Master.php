<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        check_login();
        $this->load->model('user_model');
    }


    //Management Role User

    public function index()
    {
        redirect('master/role_user');
    }

    public function role_user()
    {
        access_menu();
        $data = [
            'title' => 'Master Role User',
            'user' => get_user(),
            'view' => 'master/role_user',
            'list_menu' => $this->m->get_menu()->result()
        ];
        $this->load->view('template', $data);
    }

    private function validation_role()
    {
        $this->form_validation->set_rules('role', 'Nama Role', 'required|trim|is_unique[role_user.nama_role]', [
            'required' => 'Nama Role harap di isi',
            'is_unique' => 'Role sudah terdaftar'
        ]);
        if ($this->form_validation->run() == false) {
            $params = [
                'type' => 'validation',
                'err_role' => form_error('role')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }
    }

    public function add_role()
    {
        validation_ajax_request();
        $this->validation_role();

        $data = [
            'nama_role' => htmlspecialchars($this->input->post('role', true)),
            'status' => 1
        ];
        $this->db->insert('role_user', $data);
        if ($this->db->affected_rows() > 0) {
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Role baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Role baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_role()
    {
        validation_ajax_request();
        $this->validation_role();

        $id = $_POST['id_role'];
        $role = htmlspecialchars($this->input->post('role', true));
        $this->db->set('nama_role', $role)->where('md5(sha1(id_role))', $id)->update('role_user');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Role berhasil di edit'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Role gagal di edit'
            ];
        }
        echo json_encode($params);
    }

    public function change_status_role()
    {
        validation_ajax_request();
        $id = $_POST['id'];
        $type = $_POST['type'];
        if ($type == 1) {
            $this->db->set('status', 1)->where('md5(sha1(id_role))', $id)->update('role_user');
        } else if ($type == 2) {
            $this->db->set('status', 0)->where('md5(sha1(id_role))', $id)->update('role_user');
        }

        if ($this->db->affected_rows() > 0) {
            $params = [
                'success' => true,
                'msg' => 'Status role berhasil di ubah'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Status role gagal di ubah'
            ];
        }
        echo json_encode($params);
    }

    public function delete_role()
    {
        validation_ajax_request();
        $id = $_POST['id'];
        $this->db->where('md5(sha1(id_role))', $id)->delete('role_user');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'success' => true,
                'msg' => 'Role berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Role gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function change_access_menu(){
        validation_ajax_request();

        $id_role = $this->input->post('id_role');

        if(empty($_POST['check'])){
            $this->db->delete('access_menu', ['id_role' => $id_role]);
            if($this->db->affected_rows() > 0){
                $params = [
                    'success' => true,
                    'msg' => 'Akses menu berhasil di perbarui'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Akses menu gagal di perbarui'
                ];
            }

        } else {
            $menu = $_POST['check'];


            $a = count($menu);
            $data = array();

            for($b=0; $b<$a; $b++){
                array_push($data, array(
                    'id_role' => $id_role,
                    'id_menu' => $menu[$b]
                ));
            }
            $this->db->delete('access_menu', ['id_role' => $id_role]);
            $this->db->insert_batch('access_menu', $data);

            if($this->db->affected_rows() > 0){
                $params = [
                    'success' => true,
                    'msg' => 'Akses menu berhasil di perbarui'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Akses menu gagal di perbarui'
                ];
            }
        }

        echo json_encode($params);
    }

    public function load_access_menu(){
        validation_ajax_request();
        $id = $_POST['id'];
        $data = $this->m->get_access_menu($id);
        $html = '';
        if(isset($data)){
            foreach($data as $d){
                $html .= '
                    <li><i class="'.$d->icon.'"></i> '.$d->nama_menu.'</li>
                ';
            }
        } else {
            $html = '<li>No Data</li>';
        }

        echo $html;
    }


    //Management Menu

    public function menu(){
        access_menu();
        $data = [
            'title' => 'Master Menu',
            'user' => get_user(),
            'view' => 'master/menu'
        ];
        $this->load->view('template', $data);
    }

    private function validation_menu(){
        $this->form_validation->set_rules('menu', 'Nama menu', 'required|trim|is_unique[menu.nama_menu]',[
            'required' => 'Nama menu harap di isi',
            'is_unique' => 'Menu sudah terdaftar'
        ]);
        $this->form_validation->set_rules('icon', 'Icon menu', 'required|trim',[
            'required' => 'Icon menu harap di isi'
        ]);
        $this->form_validation->set_rules('url', 'Url menu', 'required|trim|is_unique[menu.url]',[
            'required' => 'Url menu harap di isi',
            'is_unique' => 'Url sudah terdaftar'
        ]);

        if($this->form_validation->run() == false){
            $params = [
                'type' => 'validation',
                'err_menu' => form_error('menu'),
                'err_icon' => form_error('icon'),
                'err_url' => form_error('url')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }


    }

    public function add_menu(){
        validation_ajax_request();
        $this->validation_menu();

        $data = [
            'nama_menu' => htmlspecialchars($this->input->post('menu', true)),
            'icon' => htmlspecialchars($this->input->post('icon', true)),
            'url' => htmlspecialchars($this->input->post('url', true)),
            'status' => 1
        ];
        $this->db->insert('menu', $data);
        if($this->db->affected_rows() > 0){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Menu baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Menu baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);

    }

    public function get_menu_row(){
        validation_ajax_request();
        $id = $_POST['id'];
        $data = $this->m->get_menu($id)->row();
        echo json_encode($data);
    }

    public function edit_menu(){
        validation_ajax_request();
        $this->validation_menu();
        $id = $this->input->post('id_menu');

        $data = [
            'nama_menu' => htmlspecialchars($this->input->post('menu', true)),
            'icon' => htmlspecialchars($this->input->post('icon', true)),
            'url' => htmlspecialchars($this->input->post('url', true))
        ];

        $this->db->where('md5(sha1(id_menu))', $id)->update('menu', $data);
        if($this->db->affected_rows() > 0){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Menu berhasil di edit'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Menu gagal di edit'
            ];
        }
        echo json_encode($params);
    }

    public function delete_menu()
    {
        validation_ajax_request();
        $id = $_POST['id'];
        $this->db->where('md5(sha1(id_menu))', $id)->delete('menu');
        if ($this->db->affected_rows() > 0) {
            $params = [
                'success' => true,
                'msg' => 'Menu berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Menu gagal di hapus'
            ];
        }
        echo json_encode($params);
    }

    public function change_status_menu()
    {
        validation_ajax_request();
        $id = $_POST['id'];
        $type = $_POST['type'];
        if ($type == 1) {
            $this->db->set('status', 1)->where('md5(sha1(id_menu))', $id)->update('menu');
        } else if ($type == 2) {
            $this->db->set('status', 0)->where('md5(sha1(id_menu))', $id)->update('menu');
        }

        if ($this->db->affected_rows() > 0) {
            $params = [
                'success' => true,
                'msg' => 'Status menu berhasil di ubah'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Status menu gagal di ubah'
            ];
        }
        echo json_encode($params);
    }


    //master cabang
    public function cabang(){
        access_menu();
        $data = [
            'title' => 'Master Anak Cabang',
            'user' => get_user(),
            'view' => 'master/cabang'
        ];
        $this->load->view('template', $data);
    }

    private function validation_cabang(){
        $this->form_validation->set_rules('cabang', 'Nama Cabang', 'required|trim|is_unique[cabang.nama_cabang]');
        if($this->form_validation->run() == false){
            $params = [
                'type' => 'validation',
                'err_cabang' => form_error('cabang')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }
    }

    public function add_cabang(){
        validation_ajax_request();
        $this->validation_cabang();
        $data = [
            'nama_cabang' => htmlspecialchars($this->input->post('cabang', true))
        ];
        $this->db->insert('cabang', $data);
        if($this->db->affected_rows() > 0){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Anak cabang baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Anak cabang baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_cabang(){
        validation_ajax_request();
        $this->validation_cabang();
        $data = [
            'nama_cabang' => htmlspecialchars($this->input->post('cabang', true))
        ];
        $id = $this->input->post('id_cabang');
        $this->db->where('md5(sha1(id_cabang))', $id)->update('cabang', $data);
        if($this->db->affected_rows() > 0){
            $params = [
                'type' => 'result',
                'success' => true,
                'msg' => 'Anak cabang berhasil di edit'
            ];
        } else {
            $params = [
                'type' => 'result',
                'success' => false,
                'msg' => 'Anak cabang gagal di edit'
            ];
        }
        echo json_encode($params);
    }

    public function delete_cabang(){
        validation_ajax_request();
        $id = $this->input->post('id');
        $this->db->where('md5(sha1(id_cabang))', $id)->delete('cabang');
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'msg' => 'Anak cabang berhasil di hapus'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Anak cabang gagal di hapus'
            ];
        }
        echo json_encode($params);
    }



    //master anggota

    public function member(){
        access_menu();
        $data = [
            'title' => 'Master Anggota',
            'user' => get_user(),
            'view' => 'master/member',
            'provinsi' => $this->db->get('wilayah_provinsi')->result(),
            'role' => $this->db->where('status', 1)->get('role_user')->result()
        ];
        $this->load->view('template', $data);
    }

    public function get_kabupaten(){
        validation_ajax_request();
        $prov = $_POST['id'];
        $data = $this->db->select('wilayah_kabupaten.*')->from('wilayah_kabupaten')->join('wilayah_provinsi', 'wilayah_kabupaten.provinsi_id = wilayah_provinsi.id')->where('wilayah_provinsi.id', $prov)->get()->result();
        echo json_encode($data);
    }

    public function get_kecamatan(){
        validation_ajax_request();
        $req = $_POST['id'];
        $this->db->select('wilayah_kecamatan.*')
        ->from('wilayah_kecamatan')
        ->join('wilayah_kabupaten', 'wilayah_kecamatan.kabupaten_id = wilayah_kabupaten.id')
        ->where('wilayah_kabupaten.id', $req);
        $data = $this->db->get()->result();
        echo json_encode($data);
    }

    public function get_kelurahan(){
        validation_ajax_request();
        $req = $_POST['id'];
        $this->db->select('wilayah_desa.*')
        ->from('wilayah_desa')
        ->join('wilayah_kecamatan', 'wilayah_kecamatan.id = wilayah_desa.kecamatan_id')
        ->where('wilayah_kecamatan.id', $req);
        $data = $this->db->get()->result();
        echo json_encode($data);
    }

    private function validation_member(){
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('nik', 'NIk', 'required|trim|numeric|is_unique[user.nik]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'No Telp', 'required|trim|numeric|is_unique[user.no_telp]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[5]');
        $this->form_validation->set_rules('dusun', 'Dusun', 'required|trim');
        $this->form_validation->set_rules('rw', 'Rw', 'required|trim|numeric');
        $this->form_validation->set_rules('rt', 'Rt', 'required|trim|numeric');
       
        if($this->form_validation->run() == false){
            $params = [
                'type' => 'validation',
                'err_nama' => form_error('nama'),
                'err_tl' => form_error('tempat_lahir'),
                'err_tlp' => form_error('no_telp'),
                'err_email' => form_error('email'),
                'err_pass' => form_error('password'),
                'err_dusun' => form_error('dusun'),
                'err_rw' => form_error('rw'),
                'err_rt' => form_error('rt'),
                'err_nik' => form_error('nik'),
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }
    }

    public function add_member(){
        validation_ajax_request();
        $this->validation_member();

        $prov = htmlspecialchars($this->input->post('provinsi', true));
        $kab = htmlspecialchars($this->input->post('kabupaten', true));
        $kec = htmlspecialchars($this->input->post('kecamatan', true));
        $desa = htmlspecialchars($this->input->post('desa', true));

        $get_prov = $this->db->where('id', $prov)->get('wilayah_provinsi')->row();
        $get_kab = $this->db->where('id', $kab)->get('wilayah_kabupaten')->row();
        $get_kec = $this->db->where('id', $kec)->get('wilayah_kecamatan')->row();
        $get_desa = $this->db->where('id', $desa)->get('wilayah_desa')->row();

        $data = [
            'nama' => htmlspecialchars($this->input->post('nama', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'password' => md5(sha1($this->input->post('password'))),
            'status' => 1,
            'img' => 'default.png',
            'id_role' => htmlspecialchars($this->input->post('role', true)),
            'nik' => htmlspecialchars($this->input->post('nik', true)),
            'tanggal_lahir' => htmlspecialchars($this->input->post('tgl_lahir', true)),
            'tempat_lahir' => htmlspecialchars($this->input->post('tempat_lahir', true)),
            'jenis_kelamin' => htmlspecialchars($this->input->post('jk', true)),
            'provinsi' => $get_prov->nama,
            'kabupaten' => $get_kab->nama,
            'kecamatan' => $get_kec->nama,
            'desa' => $get_desa->nama,
            'dusun' => htmlspecialchars($this->input->post('dusun', true)),
            'rw' => htmlspecialchars($this->input->post('rw', true)),
            'rt' => htmlspecialchars($this->input->post('rt', true)),
            'alamat_lengkap' => htmlspecialchars($this->input->post('alamat_lengkap', true)),
            'file_ktp' => '',
            'no_telp' => htmlspecialchars($this->input->post('no_telp', true)),
            'status_organisasi' => htmlspecialchars($this->input->post('status_organisasi', true)),
            'status_kepengurusan' => htmlspecialchars($this->input->post('status_kepengurusan', true)),
            'nama_kelompok_pengajian' => htmlspecialchars($this->input->post('kel_pengajian', true)),
        ];

        $this->db->insert('user', $data);
        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Anggota baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Anggota baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function change_status_user(){
        validation_ajax_request();
        $id = $_POST['id'];
        $type = $_POST['type'];
        if ($type == 1) {
            $this->db->set('status', 1)->where('md5(sha1(id_user))', $id)->update('user');
        } else if ($type == 2) {
            $this->db->set('status', 0)->where('md5(sha1(id_user))', $id)->update('user');
        }

        if ($this->db->affected_rows() > 0) {
            $params = [
                'success' => true,
                'msg' => 'Status user berhasil di ubah'
            ];
        } else {
            $params = [
                'success' => false,
                'msg' => 'Status user gagal di ubah'
            ];
        }
        echo json_encode($params);
    }


}
