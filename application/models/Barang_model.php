<?php
defined('BASEPATH') or exit('No direct script access allowed');

class barang_model extends CI_Model
{
  public function getAllData()
  {
    return $this->db->get('tb_barang')->result();
  }

  public function deletebarang($id)
  {
    $this->db->delete('tb_barang', ['id' => $id]);
    return $this->db->affected_rows();
  }

  public function tambahbarang($data)
  {
    try {
      $this->db->insert('tb_barang', $data);
      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

  public function updatebarang($data, $id)
  {
    try {
      $this->db->where('id', $id);
      $this->db->update('tb_barang', $data);

      $error = $this->db->error();
      if (!empty($error['code'])) {
        throw new Exception('Terjadi kesalahan: ' . $error['message']);
        return false;
      }
      return ['status' => true, 'data' => $this->db->affected_rows()];
    } catch (Exception $ex) {
      return ['status' => false, 'msg' => $ex->getMessage()];
    }
  }

}