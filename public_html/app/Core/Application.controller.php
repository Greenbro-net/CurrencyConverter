<?php

class Application
{
    static protected $controller;
    //below it's like a method
    static protected $action;
    static protected $prams = [];


    // the method bellow calls to prepared
    static public function call_by_url()
    {
      try {
        self::prepareCALL();

        // the code below for name of controller in lower case
        if(file_exists(CONTROLLER. self::$controller . '.controller.php'))
        {
            self::$controller = new self::$controller;
            if(method_exists(self::$controller, self::$action)) {
                 call_user_func_array([self::$controller, self::$action], self::$prams);
            }
        }
        // the code below for name of controller in upper case
        elseif (file_exists(CONTROLLER. ucfirst(self::$controller) . '.controller.php'))
        {
            self::$controller =  'App\Controllers\\' . ucfirst(self::$controller);

            self::$controller = new self::$controller;
            if(method_exists(self::$controller, self::$action)) {
                 call_user_func_array([self::$controller, self::$action], self::$prams);
            }
        }
        else {
          throw new Exception("Method call_by_url wasn't successful, file of current controller haven't found");
             }
           } catch (Exception $exception) {
            file_put_contents("my-errors.log", 'Message:' . $exception->getMessage() . '<br />'.   'File: ' . $exception->getFile() . '<br />' .
            'Line: ' . $exception->getLine() . '<br />' .'Trace: ' . $exception->getTraceAsString());
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

    // the method below clears parameter from url, leaves only controller/method name
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
        // the code below allows to have parameter in bare case url, it clears url[0] of parameter
        elseif (!empty($url[0])) {
            if (strpos($url[0], '?') == 0) {
                unset($url[0]); // unset url[0] 
                }
            }
            
        return $url;   
        }
           
    }


}