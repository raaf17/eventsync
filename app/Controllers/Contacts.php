<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\GroupModel;
use App\Models\ContactModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Contacts extends ResourceController
{
    protected $group;
    protected $contact;
    protected $helpers = ['custom'];

    public function __construct()
    {
        $this->group = new GroupModel();
        $this->contact = new ContactModel();
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data['contacts'] = $this->contact->getAll();
        return view('contact/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data['group_data'] = $this->group->findAll();
        return view('contact/new', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = $this->request->getPost();
        $this->contact->insert($data);
        return redirect()->to(site_url('contacts'))->with('success', 'Data Berhasil Disimpan');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $contact = $this->contact->find($id);
        if (is_object($contact)) {
            $data['contact'] = $contact;
            $data['group_data'] = $this->group->findAll();
            return view('contact/edit', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = $this->request->getPost();
        $this->contact->update($id, $data);
        return redirect()->to(site_url('contacts'))->with('success', 'Data Berhasil Diupdate');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $this->contact->delete($id);
        return redirect()->to(site_url('contacts'))->with('success', 'Data Berhasil Dihapus');
    }

    public function export()
    {
        $contacts = $this->contact->findAll();
        // $keyword = $this->request->getGet('keyword');
        // $db = \Config\Database::connect();
        // $builder = $db->table('contacts');
        // $builder->join('group_data', 'group_data.id_group = contacts.id_group');
        // if ($keyword != '') {
        //     $builder->like('name_contact', $keyword);
        //     $builder->orLike('name_alias', $keyword);
        //     $builder->orlike('address', $keyword);
        //     $builder->orlike('phone', $keyword);
        //     $builder->orlike('email', $keyword);
        //     $builder->orlike('name_group', $keyword);
        // }
        // $query = $builder->get();
        // $contacts = $query->getResult();

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();
        $activeWorksheet->setCellValue('A1', 'No');
        $activeWorksheet->setCellValue('B1', 'Nama');
        $activeWorksheet->setCellValue('C1', 'Alias');
        $activeWorksheet->setCellValue('D1', 'Telepon');
        $activeWorksheet->setCellValue('E1', 'Email');
        $activeWorksheet->setCellValue('F1', 'Alamat');
        $activeWorksheet->setCellValue('G1', 'Info');

        $column = 2; // Kolom Start
        foreach ($contacts as $key => $value) {
            $activeWorksheet->setCellValue('A'.$column, ($column-1));
            $activeWorksheet->setCellValue('B'.$column, $value->name_contact);
            $activeWorksheet->setCellValue('C'.$column, $value->name_alias);
            $activeWorksheet->setCellValue('D'.$column, $value->phone);
            $activeWorksheet->setCellValue('E'.$column, $value->email);
            $activeWorksheet->setCellValue('F'.$column, $value->address);
            $activeWorksheet->setCellValue('G'.$column, $value->info_contact);
            $column++;
        }

        $activeWorksheet->getStyle('A1:G1')->getFont()->setBold(true);
        $activeWorksheet->getStyle('A1:G1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFFFFF00');
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ],
        ];
        $activeWorksheet->getStyle('A1:G'.($column-1))->applyFromArray($styleArray);

        $activeWorksheet->getColumnDimension('A')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('B')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('C')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('D')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('E')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('F')->setAutoSize(true);
        $activeWorksheet->getColumnDimension('G')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachement;filename=contacts.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function import()
    {
        $file = $this->request->getFile('file_excel');
        $extension = $file->getClientExtension();
        if ($extension == 'xlsx' || $extension == 'xls') {
            if ($extension == 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($file);
            $contacts = $spreadsheet->getActiveSheet()->toArray();
            foreach ($contacts as $key => $value) {
                if ($key == 0) {
                    continue;
                }
                $data = [
                    'name_contact' => $value[1],
                    'name_alias' => $value[2],
                    'phone' => $value[3],
                    'email' => $value[4],
                    'address' => $value[5],
                    'info_contact' => $value[6],
                    'id_group' => 0,
                ];
                $this->contact->insert($data);
            }
            return redirect()->back()->with('success', 'Data excel berhasil diimpor');
        } else {
            return redirect()->back()->with('errors', 'Format file tidak sesuai');
        }
    }
}
