<?php

namespace App\Controllers;

class Gawe extends BaseController
{
  public function index()
  {
    // Cara 1 : query builder
    $builder = $this->db->table('gawe');
    $query   = $builder->get();

    // Cara 2 : query manual
    // $query     = $this->db->query("SELECT * FROM gawe");

    $data['gawe'] = $query->getResult();
    return view('gawe/get', $data);
  }

  public function create()
  {
    return view('gawe/add');
  }

  public function store()
  {
    $validate = $this->validate([
      'name_gawe' => [
          'rules' => 'required|min_length[3]',
          'errors' => [
              'required' => 'Nama event tidak boleh kosong',
              'min_length' => 'Nama event minimal 3 karakter',
          ],
      ],
      'date_gawe' => [
          'rules' => 'required',
          'errors' => [
              'required' => 'Tanggal event tidak boleh kosong',
          ],
      ],
  ]);
  if (!$validate) {
      return redirect()->back()->withInput();
  }
    // cara 1 : name sama
    $data = $this->request->getPost();
    $this->db->table('gawe')->insert($data);

    if($this->db->affectedRows() > 0){
      return redirect()->to(site_url('gawe'))->with('success', 'Data Berhasil Disimpan');
    }
  }

  public function edit($id = null)
  {
    if($id != null) {
      $query = $this->db->table('gawe')->getWhere(['id_gawe' => $id]);
      if($query->resultID->num_rows > 0) {
        $data['gawe'] = $query->getRow();
        return view('gawe/edit', $data);
      }
    } else {
      throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
  }

  public function update($id)
  {
    $validate = $this->validate([
      'name_gawe' => [
          'rules' => 'required|min_length[3]',
          'errors' => [
              'required' => 'Nama event tidak boleh kosong',
              'min_length' => 'Nama event minimal 3 karakter',
          ],
      ],
      'date_gawe' => [
          'rules' => 'required',
          'errors' => [
              'required' => 'Tanggal event tidak boleh kosong',
          ],
      ],
  ]);
  if (!$validate) {
      return redirect()->back()->withInput();
  }
    // Cara 1
    $data = $this->request->getPost();
    unset($data['_method']);

    // Cara 2
    // $data = [
    //   'name_gawe' => $this->request->getVar('name_gawe'),
    //   'date_gawe' => $this->request->getVar('name_gawe'),
    //   'info_gawe' => $this->request->getVar('name_gawe'),
    // ];

    $this->db->table('gawe')->where(['id_gawe' => $id])->update($data);
    return redirect()->to(site_url('gawe'))->with('success', 'Data Berhasil Diupdate');
  }
  
  public function destroy($id)
  {
    $this->db->table('gawe')->where(['id_gawe' => $id])->delete();
    return redirect()->to(site_url('gawe'))->with('success', 'Data Berhasil Dihapus');
  }
}
