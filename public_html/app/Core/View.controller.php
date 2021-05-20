<?php

class View
{
    protected $view_file;
    protected $view_data;
    protected $result;

    protected $unknown_page = 404;

    public function __construct($view_file, $view_data)
    {
        $this->view_file = $view_file;
        $this->view_data = $view_data;
    }

    public function render()
    {
        if(file_exists(VIEW . $this->view_file . '.view.phtml'))
        {
            include VIEW . $this->view_file . '.view.phtml';
            
        }
        // the code below testing code for 404 page  
        else {
            include VIEW . $this->$unknown_page . '.view.phtml';
            
            
        }
    }

    public function getAction()
    {
        return (explode('/', $this->view_file)[1]);
    }
}