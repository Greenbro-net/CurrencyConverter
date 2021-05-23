<?php

class troubleController extends Controller
{
    public function page_404()
    {
        $this->model('trouble');
        $this->view('trouble'. DIRECTORY_SEPARATOR . 'index');
        $this->view->page_title = "404 Page not found";
        $this->view->render();
    }
}