<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Controllers\CurrencyController;

class HomeController extends Controller
{
    // the method below for default page
    public function index()
    {
        $this->model('ConverterModel');
        $this->view('home' . DIRECTORY_SEPARATOR . 'index');
        $this->view->page_title = "Main page";
        $this->view->render();
    }
}