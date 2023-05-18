<?php

namespace App\Controllers\Type;

use App\Controllers\BaseController;
use App\Models\TypeModel;

class Type extends BaseController
{


    public function index()
    {
        $TypeModel = new TypeModel();

        $var['title']    = "Type";
        $var['type']     = $TypeModel->get_data_index();




        return view('Inventory\Type\index', $var);
    }

    public function  view()
    {
        $var['title']    = "Type";

        return view('Layout\menu');
    }

    public function add()
    {
        session();
        $validation = \Config\Services::validation();

        $var['title'] = "ADD TYPE";
        $var['validation'] = $validation;
        // dd($var);

        return view('Inventory\Type\add', $var);
    }

    public function save()
    {
        if ($this->request->getPost()) {

            $valid = $this->validate(
                [
                    'txtTypeName'   => [
                        'rules'     => 'required',
                        'errors'    => [
                            'required'  => 'Please fill your Type Name'
                        ]
                    ],
                    'txtTypeCode'   => [
                        'rules'     => 'required|max_length[5]|is_unique[ms_type.type_code]',
                        'errors'    => [
                            'required'  => 'Please fill your Type Code',
                            'is_unique'  => 'Type Code already exist in database',
                            'max_length' => 'Maximum Code 5 inputs length'
                        ]
                    ],
                ],

            );
            // session()->setFlashdata('errors', $this->validator->listErrors());
            // $validation = \Config\Services::validation();
            // return redirect()->back()->withInput();

            $txtTypeName        = $this->request->getVar('txtTypeName');
            $txtTypeCode        = $this->request->getVar('txtTypeCode');
            $cretime            = date('Y-m-d H:i:s');

            if ($valid) {
                $data = [
                    'type_name'         => strToUpper($txtTypeName),
                    'type_code'         => strToUpper($txtTypeCode),
                    'created_at'           => $cretime

                ];

                $TypeModel = new TypeModel();
                $TypeModel->insert_Type($data);

                return redirect()->to('Type/Type');
            } else {
                session()->setFlashdata('txtTypeName', $txtTypeName);
                session()->setFlashdata('txtTypeCode', $txtTypeCode);

                session()->setFlashdata('errors', $this->validator->listErrors());
                $validation = \Config\Services::validation();
                return $this->add();
            }


            $var['title'] = "ADD TYPE";
            return view('Inventory\Type\add', $var);
        }
    }

    public function edit($id)
    {
        // Mengambil data dari model berdasarkan id
        $TypeModel = new TypeModel();

        $data['result'] = $TypeModel->get_data($id);
        $data['title'] = "EDIT Type";


        // Menampilkan data ke view untuk diedit
        return view('Inventory\Type\edit', $data);
    }

    public function update($id)
    {

        $TypeModel = new TypeModel();
        $code = $TypeModel->get_data($id);
        $code = array_pop($code);
        $codeBaru        = $this->request->getVar('txtTypeCode');
        $codeLama        = $code['type_code'];
        if ($codeBaru == $codeLama) {
            $rulesCode = 'required|max_length[5]';
        } else {
            $rulesCode = 'required|max_length[5]|is_unique[ms_type.type_code]';
        }

        $valid = $this->validate(
            [
                'txtTypeName'   => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => 'Please fill your Type Name'
                    ]
                ],
                'txtTypeCode'   => [
                    'rules'     => $rulesCode,
                    'errors'    => [
                        'required'  => 'Please fill your Type Code',
                        'is_unique'  => 'Type Code already exist',
                        'max_length' => 'Maximum Code 5 inputs length'
                    ]
                ],
            ],

        );

        $txtTypeID        = $this->request->getVar('txtTypeID');
        $txtTypeName        = $this->request->getVar('txtTypeName');
        $txtTypeCode        = $this->request->getVar('txtTypeCode');
        $updatetime            = date('Y-m-d H:i:s');

        if ($valid) {
            $data = [
                'type_name'         => strToUpper($txtTypeName),
                'type_code'         => strToUpper($txtTypeCode),
                'updated_at'        => $updatetime

            ];
            $TypeModel = new TypeModel;
            $TypeModel->update($id, $data);

            return redirect()->to('Type/Type');
        } else {

            session()->setFlashdata('txtTypeID', $txtTypeID);
            session()->setFlashdata('txtTypeName', $txtTypeName);
            session()->setFlashdata('txtTypeCode', $txtTypeCode);

            session()->setFlashdata('errors', $this->validator->listErrors());
            $validation = \Config\Services::validation();
            return $this->edit($txtTypeID);
        }
        $var['title'] = "EDIT TYPE";
        return view('Inventory\Type\edit', $var);
    }


    public function delete($id)
    {
        $TypeModel = new TypeModel();
        $TypeModel->delete($id);

        return redirect()->to(base_url('/Type/Type'));
    }
}
