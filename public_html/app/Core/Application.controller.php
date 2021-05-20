<?php

class Application
{
    static protected $controller;
    //below it's like a method
    static protected $action;
    static protected $prams = [];


    static public function call_by_url()
    {
        self::prepareCALL();
        if(file_exists(CONTROLLER. self::$controller . '.controller.php'))
        {
            self::$controller = new self::$controller;
            if(method_exists(self::$controller, self::$action)) {
                 call_user_func_array([self::$controller, self::$action], self::$prams);
            }
        }
    }

    // the  method below  prepares url for call  
    static protected function prepareCALL()
    {
            $url = self::clearupParameter();
            // the code below sets controller name for calling
            self::$controller = isset($url[0]) ? $url[0].'Controller' : 'homeController';
            // the code below sets method name for calling
            self::$action = isset($url[1]) ? $url[1] : 'index';
            unset($url[0], $url[1]);
            self::$prams = !empty($url) ? array_values($url) : [];
    }


    // the method below allows adding parameter after controller/method
    static public function clearupParameter()
    {
        $request = trim($_SERVER['REQUEST_URI'], '/');
        if(!empty($request)) {
             $url = explode('/', $request);
             // the code below checks are not empty values     
            if (!empty($url[0]) && !empty($url[1])) {
               if (strpos($url[1], '?')) {
                $position = strpos($url[1], '?');
                $url[1] = substr($url[1], 0, $position); 
                    }
                }    
                
              return $url;   
            }
           
    }


}