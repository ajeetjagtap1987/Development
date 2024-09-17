<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\AssetsModel;
use App\Models\CommonModel;

class CommonController extends Controller
{


    public function gettoken(){
    
        return  csrf_hash();
    }


}