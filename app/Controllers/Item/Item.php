<?php

namespace App\Controllers\Item;

use App\Controllers\BaseController;
use App\Models\ItemModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\TypeModel;

class Item extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {

        $ItemModel = new ItemModel();

        $var['title']    = "ITEM";
        $var['item']     = $ItemModel->get_data_index();
        $var['validation']     = \Config\Services::validation();

        return view('Inventory\Item\index', $var);
    }

    public function  view()
    {
        $var['title']    = "ITEM";

        return view('Layout\menu');
    }

    public function add()
    {
        session();

        $CategoryModel = new CategoryModel();
        $var['category'] = $CategoryModel->getAllDataDescending();
        $BrandModel = new BrandModel();
        $var['brand'] = $BrandModel->getAllDataDescending();
        $TypeModel = new TypeModel();
        $var['type'] = $TypeModel->getAllDataDescending();

        $var['title'] = "ADD ITEM";
        $var['validation'] = \Config\Services::validation();

        return view('Inventory\Item\add', $var);
    }

    public function save()
    {
        if ($this->request->getPost()) {

            $valid = $this->validate(
                [
                    'txtItemName'   => [
                        'rules'     => 'required',
                        'errors'    => [
                            'required'  => 'Please fill your Item Name'
                        ]
                    ],
                    'txtItemCode'   => [
                        'rules'     => 'required|max_length[5]|is_unique[ms_item.item_code]',
                        'errors'    => [
                            'required'  => 'Please fill your Item Code',
                            'is_unique'  => 'Item Code already exist in database',
                            'max_length' => 'Maximum Code 5 inputs length'
                        ]
                    ],
                    'txtItemPrice'   => [
                        'rules'     => 'required',
                        'errors'    => [
                            'required'  => 'Please fill your Item Price',
                        ]
                    ],
                ],

            );
            // session()->setFlashdata('errors', $this->validator->listErrors());
            // $validation = \Config\Services::validation();
            // return redirect()->back()->withInput();

            $txtItemName        = $this->request->getVar('txtItemName');
            $txtItemCode        = $this->request->getVar('txtItemCode');
            $txtItemPrice       = $this->request->getVar('txtItemPrice');
            $selItemCategory    = $this->request->getVar('selItemCategory');
            $selItemBrand       = $this->request->getVar('selItemBrand');
            $selItemType        = $this->request->getVar('selItemType');
            $cretime            = date('Y-m-d H:i:s');

            if ($valid) {
                $data = [
                    'item_name'         => strToUpper($txtItemName),
                    'item_code'         => strToUpper($txtItemCode),
                    'item_price'        => str_replace(",", "", $txtItemPrice),
                    'category_id'       => strToUpper($selItemCategory),
                    'brand_id'          => strToUpper($selItemBrand),
                    'type_id'           => strToUpper($selItemType),
                    'created_at'           => $cretime

                ];

                $ItemModel = new ItemModel();
                $ItemModel->insert_item($data);

                return redirect()->to('Item/Item');
            } else {
                session()->setFlashdata('txtItemName', $txtItemName);
                session()->setFlashdata('txtItemCode', $txtItemCode);
                session()->setFlashdata('txtItemPrice', $txtItemPrice);

                session()->setFlashdata('selItemCategory', $selItemCategory);
                $category = $this->get_category($selItemCategory);
                $ct = array_pop($category);

                if ($ct) {
                    session()->setFlashdata('txtItemCategory', $ct['category_code'] . "-" . $ct['category_name']);
                }
                session()->setFlashdata('selItemBrand', $selItemBrand);
                $brand = $this->get_brand($selItemBrand);

                $br = array_pop($brand);
                if ($br) {
                    session()->setFlashdata('txtItemBrand', $br['brand_code'] . "-" . $br['brand_name']);
                }

                session()->setFlashdata('selItemType', $selItemType);
                $type = $this->get_type($selItemType);
                $ty = array_pop($type);
                if ($ty) {
                    session()->setFlashdata('txtItemType', $ty['type_code'] . "-" . $ty['type_name']);
                }

                session()->setFlashdata('errors', $this->validator->listErrors());
                $validation = \Config\Services::validation();
                return $this->add();
            }


            $var['title'] = "ADD ITEM";
            return view('Inventory\Item\add', $var);
        }
    }

    public function edit($id)
    {
        // ambil semua category, type, brand
        $CategoryModel = new CategoryModel();
        $data['allCategory'] = $CategoryModel->getAllDataDescending();
        $BrandModel = new BrandModel();
        $data['allBrand'] = $BrandModel->getAllDataDescending();
        $TypeModel = new TypeModel();
        $data['allType'] = $TypeModel->getAllDataDescending();
        // ambil semua category, type, brand

        // ambil semua data untuk diedit
        $ItemModel = new ItemModel();
        $data['result'] = $ItemModel->get_data($id);

        $item = $ItemModel->get_data($id);
        $item = array_pop($item);

        $param = [
            'category_id' => $item['category_id']
        ];
        $rsCategory = $this->get_category($param);
        $data['category'] = array_pop($rsCategory);

        $param = [
            'type_id' => $item['type_id']
        ];
        $rsType = $this->get_type($param);
        $data['type'] = array_pop($rsType);

        $param = [
            'brand_id' => $item['brand_id']
        ];
        $rsBrand = $this->get_brand($param);
        $data['brand'] = array_pop($rsBrand);
        // ambil semua data untuk diedit


        $data['title'] = "EDIT ITEM";


        return view('Inventory\Item\edit', $data);
    }

    public function update($id)
    {
        $ItemModel = new ItemModel();
        $code = $ItemModel->get_data($id);
        $code = array_pop($code);
        $codeBaru        = $this->request->getVar('txtItemCode');
        $codeLama        = $code['item_code'];
        if ($codeBaru == $codeLama) {
            $rulesCode = 'required|max_length[5]';
        } else {
            $rulesCode = 'required|max_length[5]|is_unique[ms_item.item_code]';
        }

        $valid = $this->validate(
            [
                'txtItemName'   => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => 'Please fill your Item Name'
                    ]
                ],
                'txtItemCode'   => [
                    'rules'     => $rulesCode,
                    'errors'    => [
                        'required'  => 'Please fill your Item Code',
                        'is_unique'  => 'Item Code already exist in database',
                        'max_length' => 'Maximum Code 5 inputs length'
                    ]
                ],
                'txtItemPrice'   => [
                    'rules'     => 'required',
                    'errors'    => [
                        'required'  => 'Please fill your Item Price',
                    ]
                ],


            ],

        );

        $txtItemID        = $this->request->getVar('txtItemID');
        $txtItemName        = $this->request->getVar('txtItemName');
        $txtItemCode        = $this->request->getVar('txtItemCode');
        $txtItemPrice       = $this->request->getVar('txtItemPrice');
        $selItemCategory    = $this->request->getVar('selItemCategory');
        $selItemBrand       = $this->request->getVar('selItemBrand');
        $selItemType        = $this->request->getVar('selItemType');
        $updatetime            = date('Y-m-d H:i:s');

        if ($valid) {
            // $ItemModel = new ItemModel;
            // $delete = $ItemModel->deleteData($txtItemID);
            // if ($delete) {
            $data = [
                'item_id'         => $txtItemID,
                'item_name'         => strToUpper($txtItemName),
                'item_code'         => strToUpper($txtItemCode),
                'item_price'        => str_replace(",", "", $txtItemPrice),
                'category_id'       => strToUpper($selItemCategory),
                'brand_id'          => strToUpper($selItemBrand),
                'type_id'           => strToUpper($selItemType),
                'updated_at'        => $updatetime

            ];

            $ItemModel->save($data);
            // }
            return redirect()->to('Item/Item');
        } else {

            session()->setFlashdata('txtItemID', $txtItemID);
            session()->setFlashdata('txtItemName', $txtItemName);
            session()->setFlashdata('txtItemCode', $txtItemCode);
            session()->setFlashdata('txtItemPrice', $txtItemPrice);

            session()->setFlashdata('selItemCategory', $selItemCategory);
            $category = $this->get_category($selItemCategory);
            $ct = array_pop($category);

            if ($ct) {
                session()->setFlashdata('txtItemCategory', $ct['category_code'] . "-" . $ct['category_name']);
            }
            session()->setFlashdata('selItemBrand', $selItemBrand);
            $brand = $this->get_brand($selItemBrand);

            $br = array_pop($brand);
            if ($br) {
                session()->setFlashdata('txtItemBrand', $br['brand_code'] . "-" . $br['brand_name']);
            }

            session()->setFlashdata('selItemType', $selItemType);
            $type = $this->get_type($selItemType);
            $ty = array_pop($type);
            if ($ty) {
                session()->setFlashdata('txtItemType', $ty['type_code'] . "-" . $ty['type_name']);
            }

            session()->setFlashdata('errors', $this->validator->listErrors());
            $validation = \Config\Services::validation();
            return $this->edit($txtItemID);
        }
        $var['title'] = "EDIT ITEM";
        return view('Inventory\Item\edit', $var);
    }

    public function get_category($param)
    {
        $CategoryModel = new CategoryModel();

        $result = $CategoryModel->get_data($param);

        return $result;
    }

    public function get_brand($param)
    {
        $BrandModel = new BrandModel();

        $result = $BrandModel->get_data($param);

        return $result;
    }

    public function get_type($param)
    {
        $TypeModel = new TypeModel();

        $result = $TypeModel->get_data($param);

        return $result;
    }


    public function delete($id)
    {
        $ItemModel = new ItemModel();
        $ItemModel->delete($id);

        return redirect()->to(base_url('/Item/Item'));
    }
}
