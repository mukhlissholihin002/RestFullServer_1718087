<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class barang extends REST_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('barang_model');
  }

  public function index_get()
  {

    $barang = $this->barang_model->getAllData();

    $data = [
      'status' => true,
      'data' => $barang
    ];

    $this->response($data, REST_Controller::HTTP_OK);
  }

  public function index_delete()
  {
    $id = $this->delete('id');
    if ($id === null) {
      $this->response([
        'status' => false,
        'msg' => 'Tidak ada id yang dipilih'
      ], REST_Controller::HTTP_BAD_REQUEST);
    } else {
      if ($this->barang_model->deletebarang($id) > 0) {
        $this->response([
          'status' => true,
          'id' => $id,
          'msg' => 'Data berhasil dihapus'
        ], REST_Controller::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'msg' => 'Id tidak ditemukan'
        ], REST_Controller::HTTP_BAD_REQUEST);
      }
    }
  }

  public function index_post()
  {
    $data = [
      'id' => $this->post('id'),
      'nama_barang' => $this->post('nama_barang'),
      'jenis_barang' => $this->post('jenis_barang'),
      'warna_barang' => $this->post('warna_barang'),
      'ukuran' => $this->post('ukuran'),
      'jumlah' => $this->post('jumlah'),
      'harga' => $this->post('harga'),
    ];

    $simpan = $this->barang_model->tambahbarang($data);
    
    if ($simpan['status']) {
      $this->response(['status' => true, 'msg' => 'Data telah ditambahkan'], REST_Controller::HTTP_OK);
    } else {
      $this->response(['status' => false, 'msg' => $simpan['msg']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }

  public function index_put()
  {
    $data = [
      'id' => $this->post('id'),
      'nama_barang' => $this->put('nama_barang'),
      'jenis_barang' => $this->put('jenis_barang'),
      'warna_barang' => $this->put('warna_barang'),
      'ukuran' => $this->put('ukuran'),
      'jumlah' => $this->put('jumlah'),
      'harga' => $this->put('harga'),
    ];

    $id = $this->put('id');
    
    $simpan = $this->barang_model->updatebarang($data, $id);

    if ($simpan['status']) {
      $status = (int) $simpan['data'];
      if ($status > 0) {
        $this->response(['status' => true, 'msg' => 'Data telah diupdate'], REST_Controller::HTTP_OK);
      } else {
        $this->response(['status' => false, 'msg' => 'Tidak ada data yang dirubah'], REST_Controller::HTTP_BAD_REQUEST);
      }
    } else {
      $this->response(['status' => false, 'msg' => $simpan['msg']], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
  

 
}
