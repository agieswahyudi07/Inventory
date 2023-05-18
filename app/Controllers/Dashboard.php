<?php

namespace App\Controllers;

use App\Models\itemModel;

class Dashboard extends BaseController
{


    public function index()
    {

        $title = "ITEM";
        $var['title'] = "Dashboard";
        // dd($var);


        return view('Inventory/index', $var);
    }
}
