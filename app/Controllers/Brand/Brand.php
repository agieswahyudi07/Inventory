<?php

namespace App\Controllers\Brand;

use App\Controllers\BaseController;
use App\Models\BrandModel;

class Brand extends BaseController
{


    public function index()
    {
        $BrandModel = new BrandModel();

        $var['title']    = "Brand";
        $var['brand']     = $BrandModel->get_data_index();




        return view('Inventory\Brand\index', $var);
    }

    public function  view()
    {
        $var['title']    = "Brand";

        return view('Layout\menu');
    }

    public function add()
    {
        session();
        $validation = \Config\Services::validation();

        $var['title'] = "ADD Brand";
        $var['validation'] = $validation;
        // dd($var);

        return view('Inventory\Brand\add', $var);
    }

    public function save()
    {
        if ($this->request->getPost()) {

            $valid = $this->validate(
                [
                    'txtBrandName'   => [
                        'rules'     => 'required',
                        'errors'    => [
                            'required'  => 'Please fill your Brand Name'
                        ]
                    ],
                    'txtBrandCode'   => [
                        'rules'     => 'required|max_length[5]|is_unique[ms_brand.brand_code]',
                        'errors'    => [
                            'required'  => 'Please fill your Brand Code',
                            'is_unique'  => 'Brand Code already exist in database',
                            'max_length' => 'Maximum Code 5 inputs length'
                        ]
                    ],
                ],

            );
            // session()->setFlashdata('errors', $this->validator->listErrors());
            // $validation = \Config\Services::validation();
            // return redirect()->back()->withInput();

            $txtBrandName        = $this->request->getVar('txtBrandName');
            $txtBrandCode        = $this->request->getVar('txtBrandCode');
            $cretime            = date('Y-m-d H:i:s');

            if ($valid) {
                $data = [
                    'brand_name'         => strToUpper($txtBrandName),
                    'brand_code'         => strToUpper($txtBrandCode),
                    'created_at'           => $cretime

                ];

                $BrandModel = new BrandModel();
                $BrandModel->insert_brand($data);

                return redirect()->to('Brand/Brand');
            } else {
                session()->setFlashdata('txtBrandName', $txtBrandName);
                session()->setFlashdata('txtBrandCode', $txtBrandCode);

                session()->setFlashdata('errors', $this->validator->listErrors());
                $validation = \Config\Services::validation();
                return $this->add();
            }


            $var['title'] = "ADD BRAND";
            return view('Inventory\Brand\add', $var);
        }
    }

    public function edit($id)
    {
        // Mengambil data dari model berdasarkan id
        $BrandModel = new BrandModel();

        $data['result'] = $BrandModel->get_data($id);
        $data['title'] = "EDIT Brand";


        // Menampilkan data ke view untuk diedit
        return view('Inventory\Brand\edit', $data);
    }

    public function update($id)
    {

        $BrandModel = new BrandModel();
        $code = $BrandModel->get_data($id);
        $code = array_pop($code);
        $codeBaru        = $this->request->getVar('txtBrandCode');
        $codeLama        = $code['brand_code'];
        if ($codeBaru == $codeLama) {
            $rulesCode = 'required|max_length[5]';
        } else {
            $rulesCode = 'required|max_length[5]|is_unique[ms_brand.brand_code]';
        }

        $valid = $this->validate(
            [
                'txtBrandName'   => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => 'Please fill your Brand Name'
                    ]
                ],
                'txtBrandCode'   => [
                    'rules'     => $rulesCode,
                    'errors'    => [
                        'required'  => 'Please fill your Brand Code',
                        'is_unique'  => 'Brand Code already exist',
                        'max_length' => 'Maximum Code 5 inputs length'
                    ]
                ],
            ],

        );

        $txtBrandID        = $this->request->getVar('txtBrandID');
        $txtBrandName        = $this->request->getVar('txtBrandName');
        $txtBrandCode        = $this->request->getVar('txtBrandCode');
        $updatetime            = date('Y-m-d H:i:s');

        if ($valid) {
            $data = [
                'brand_name'         => strToUpper($txtBrandName),
                'brand_code'         => strToUpper($txtBrandCode),
                'updated_at'        => $updatetime

            ];
            $BrandModel = new BrandModel;
            $BrandModel->update($id, $data);

            return redirect()->to('Brand/Brand');
        } else {

            session()->setFlashdata('txtBrandID', $txtBrandID);
            session()->setFlashdata('txtBrandName', $txtBrandName);
            session()->setFlashdata('txtBrandCode', $txtBrandCode);

            session()->setFlashdata('errors', $this->validator->listErrors());
            $validation = \Config\Services::validation();
            return $this->edit($txtBrandID);
        }
        $var['title'] = "EDIT BRAND";
        return view('Inventory\Brand\edit', $var);
    }


    public function delete($id)
    {
        $BrandModel = new BrandModel();
        $BrandModel->delete($id);

        return redirect()->to(base_url('/Brand/Brand'));
    }
}
