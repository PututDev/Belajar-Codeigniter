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

}
