<?php

class Controller
{
    protected $view;
    protected $model;


    public function view($viewName, $data =[])
    {
        $this->view = new View($viewName, $data);
        return $this->view;
    }

    public function model($modelName, $data=[])
    {
        try {
                if(file_exists(MODEL . $modelName . '.model.php'))
                {
                    // there are we were changed require to require_once for escaping Error from model which load a few times
                    require_once MODEL . $modelName . '.model.php';
                    $this->model = new $modelName;
                } else {
                    throw new Exception("Method model wasn't successful");
                       }
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
        
    }
    // the method below loads object of current model
    public function load_model($modelName, $data=[])
    {
        try {
                if(file_exists(MODEL . $modelName . '.model.php'))
                {
                    // there are we were changed require to require_once for escaping Error from model which load a few times
                    require_once MODEL . $modelName . '.model.php';
                    return $this->model = new $modelName;
                } else {
                    throw new Exception("Method load_model wasn't successful");
                       }
            } catch (Exception $exception) {
                file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
                'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
                                           }
        
    }

     
}