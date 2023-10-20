<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Costumer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');

    }

    public function index()
    {
        $data['title'] = "Costumer";
        $data['costumer'] = $this->admin->get('costumer');
        $this->template->load('templates/dashboard', 'costumer/data', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_costumer', 'Nama Costumer', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Costumer";
            $this->template->load('templates/dashboard', 'costumer/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('costumer', $input);
            if ($insert) {
                set_pesan('data berhasil disimpan');
                redirect('costumer');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('costumer/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "costumer";
            $data['costumer'] = $this->admin->get('costumer', ['id_costumer' => $id]);
            $this->template->load('templates/dashboard', 'costumer/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->admin->update('costumer', 'id_costumer', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('costumer');
            } else {
                set_pesan('data gagal disimpan', false);
                redirect('costumer/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('costumer', 'id_costumer', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('costumer');
    }
}
