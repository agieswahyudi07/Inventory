<?php

namespace App\Controllers\Category;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Category extends BaseController
{


    public function index()
    {
        $CategoryModel = new CategoryModel();

        $var['title']    = "Category";
        $var['category']     = $CategoryModel->get_data_index();

        return view('Inventory\Category\index', $var);
    }

    public function  view()
    {
        $var['title']    = "Category";

        return view('Layout\menu');
    }

    public function add()
    {
        session();
        $validation = \Config\Services::validation();

        $var['title'] = "ADD CATEGORY";
        $var['validation'] = $validation;

        return view('Inventory\Category\add', $var);
    }

    public function save()
    {
        if ($this->request->getPost()) {

            $valid = $this->validate(
                [
                    'txtCategoryName'   => [
                        'rules'     => 'required',
                        'errors'    => [
                            'required'  => 'Please fill your Category Name'
                        ]
                    ],
                    'txtCategoryCode'   => [
                        'rules'     => 'required|max_length[5]|is_unique[ms_category.category_code]',
                        'errors'    => [
                            'required'  => 'Please fill your Category Code',
                            'is_unique'  => 'Category Code already exist in database',
                            'max_length' => 'Maximum Code 5 inputs length'
                        ]
                    ],
                ],

            );
            // session()->setFlashdata('errors', $this->validator->listErrors());
            // $validation = \Config\Services::validation();
            // return redirect()->back()->withInput();

            $txtCategoryName        = $this->request->getVar('txtCategoryName');
            $txtCategoryCode        = $this->request->getVar('txtCategoryCode');
            $cretime            = date('Y-m-d H:i:s');

            if ($valid) {
                $data = [
                    'category_name'         => strToUpper($txtCategoryName),
                    'category_code'         => strToUpper($txtCategoryCode),
                    'created_at'           => $cretime

                ];

                $CategoryModel = new CategoryModel();
                $CategoryModel->insert_category($data);

                return redirect()->to('Category/Category');
            } else {
                session()->setFlashdata('txtCategoryName', $txtCategoryName);
                session()->setFlashdata('txtCategoryCode', $txtCategoryCode);

                session()->setFlashdata('errors', $this->validator->listErrors());
                $validation = \Config\Services::validation();
                return $this->add();
            }


            $var['title'] = "ADD CATEGORY";
            return view('Inventory\Category\add', $var);
        }
    }

    public function edit($id)
    {
        // Mengambil data dari model berdasarkan id
        $CategoryModel = new CategoryModel();

        $data['result'] = $CategoryModel->get_data($id);
        $data['title'] = "EDIT CATEGORY";


        // Menampilkan data ke view untuk diedit
        return view('Inventory\Category\edit', $data);
    }

    public function update($id)
    {

        $CategoryModel = new CategoryModel();
        $code = $CategoryModel->get_data($id);
        $code = array_pop($code);
        $codeBaru        = $this->request->getVar('txtCategoryCode');
        $codeLama        = $code['category_code'];
        if ($codeBaru == $codeLama) {
            $rulesCode = 'required|max_length[5]';
        } else {
            $rulesCode = 'required|max_length[5]|is_unique[ms_category.category_code]';
        }

        $valid = $this->validate(
            [
                'txtCategoryName'   => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => 'Please fill your Category Name'
                    ]
                ],
                'txtCategoryCode'   => [
                    'rules'     => $rulesCode,
                    'errors'    => [
                        'required'  => 'Please fill your Category Code',
                        'is_unique'  => 'Category Code already exist',
                        'max_length' => 'Maximum Code 5 inputs length'
                    ]
                ],
            ],

        );

        $txtCategoryID        = $this->request->getVar('txtCategoryID');
        $txtCategoryName        = $this->request->getVar('txtCategoryName');
        $txtCategoryCode        = $this->request->getVar('txtCategoryCode');
        $updatetime            = date('Y-m-d H:i:s');

        if ($valid) {
            $data = [
                'category_name'         => strToUpper($txtCategoryName),
                'category_code'         => strToUpper($txtCategoryCode),
                'updated_at'        => $updatetime

            ];
            $CategoryModel = new CategoryModel;
            $CategoryModel->update($id, $data);

            return redirect()->to('Category/Category');
        } else {

            session()->setFlashdata('txtCategoryID', $txtCategoryID);
            session()->setFlashdata('txtCategoryName', $txtCategoryName);
            session()->setFlashdata('txtCategoryCode', $txtCategoryCode);

            session()->setFlashdata('errors', $this->validator->listErrors());
            $validation = \Config\Services::validation();
            return $this->edit($txtCategoryID);
        }
        $var['title'] = "EDIT CATEGORY";
        return view('Inventory\Category\edit', $var);
    }


    public function delete($id)
    {
        $CategoryModel = new CategoryModel();
        $CategoryModel->delete($id);

        return redirect()->to(base_url('/Category/Category'));
    }
}
