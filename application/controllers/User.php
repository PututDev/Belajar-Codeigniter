<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->form_validation->set_rules('name', 'Nama Lengkap', 'required|trim');
        if($this->form_validation->run() == false)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        }
        else{
            
            $nama = $this->input->post('name');
            $email = $this->input->post('email');

            // Cek Jika Ada Gambar Yang Akan Di Upload
            $upload_image = $_FILES['image']['name'];                       //id 'image' diambilo dar form edi dengan name = image

            if($upload_image)
            {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';                           //Default satuan KB => 100 saya ubah ke Mb 
                $config['upload_path'] = './assets/img/profile/';
                $this->load->library('upload', $config);

                if($this->upload->do_upload('image'))                       //Ambil dari edit.php => name = image (ambil dri id namenya)
                {
                
                  $gambar_lama = $data['user']['image'];
                  if($gambar_lama != 'gambar.jpg')
                  {
                    unlink(FCPATH. 'assets/img/profile/'. $gambar_lama);        //Hapus Gambar di Folder maupun di database, gunakan fungsi unlin & FCPATH
                  }

                  $gambar_baru = $this->upload->data('file_name');
                  $this->db->set('image', $gambar_baru);

                }
                else{
                    
                    $this->upload->display_errors();
                }
            }

            
            $this->db->set('name', $nama);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Profile Kamu Berhasil di Update</div>');
            redirect('user');
        }
    }

    public function ubahpassword()
    {
        $data['title'] = 'Ubah Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|max_length[10]|matches[ulangi_password]');
        $this->form_validation->set_rules('ulangi_password', 'Konfirmasi Password', 'required|trim|max_length[10]|matches[password_baru]');

        if($this->form_validation->run() == false)
        {
            
                    $this->load->view('templates/header', $data);
                    $this->load->view('templates/sidebar', $data);
                    $this->load->view('templates/topbar', $data);
                    $this->load->view('user/ubahpassword', $data);
                    $this->load->view('templates/footer');

        }
        else{

            $password_lama = $this->input->post('password_lama');
            $password_baru = $this->input->post('password_baru');
            if(! password_verify($password_lama, $data['user']['password']))
            {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Password Lama anda salah, masukkan password dengan benar</div>');
                redirect('user/ubahpassword');
            }
            else{
                if($password_lama == $password_baru)
                {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Password baru tidak boleh sama dengan password lama</div>');
                    redirect('user/ubahpassword');
                }
                else{
                    // Jika password benar atau sesuai
                    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                    
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Password Berhasil diubah !</div>');
                    redirect('user/ubahpassword');


                }
            }

        }
    }

}
