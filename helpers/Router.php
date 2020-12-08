<?php

class Router{
    private $routes = array();
    /**
     * @var int|string|string[]|null
     */
    public $currentPage;
    private $currentTemplate;

    public function __construct($template){
        if(empty($template) ||  !file_exists(ROOT_DIR.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$template.DIRECTORY_SEPARATOR.'index.php')){
            throw new Exception("Please specify valid template");
        }
        $this->currentTemplate = $template;
    }
    public function addRoute(Route $route){
        $this->routes[]=$route;
    }

    public function processRoutes()
    {
        $found = false;
        $i = 0;
        while($i<count($this->routes) && !$found){
            $route = $this->routes[$i];
            if(preg_match('@'.$route->route.'@', $this->currentPage, $matches)){
                $found = true;
                $hasDataFn = false;
                $pageData = [];
                $hasAccess = true;
                if(!$route->isPublic){
                    if(isset($_SESSION['isLoggedIn'])){
                        $mode = "subscriber";
                        $hasAccess = isset($_SESSION['isLoggedIn']) ? $_SESSION['isLoggedIn'] : false;
                    }
                    else{
                        $mode = "instructor";
                        $hasAccess = isset($_SESSION['isLoggedInInstructor']) ? $_SESSION['isLoggedInInstructor'] : false;
                    }
                    if($hasAccess){ //re-fetch subscriber object if isLoggedIn true
                        if($mode == "subscriber"){
                            $sbObj = isset($_SESSION['subscriberObj']) && !empty($_SESSION['subscriberObj']) ? $_SESSION['subscriberObj'] : [];
                            if(empty($sbObj)){
                                $hasAccess = false;
                            }
                            else{
                                $result = makeRequest('get',['email'=>$sbObj['email'],'password'=>$sbObj['password']],['collection'=>'subscribers']);
                                if(!empty($result)){
                                    if(isset($result['success']) && !$result['success']){
                                        $hasAccess = false;
                                        $_SESSION['isLoggedIn'] = false;
                                        $_SESSION['subscriberObj'] = array();
                                    }
                                    else{
                                        $hasAccess = true;
                                        $_SESSION['isLoggedIn'] = true;
                                        $_SESSION['subscriberObj'] = $result;
                                    }
                                }
                                else{
                                    $hasAccess = false;
                                    $_SESSION['isLoggedIn'] = false;
                                    $_SESSION['subscriberObj'] = array();
                                }
                            }
                        }
                        else{
                            $sbObj = isset($_SESSION['instructorObj']) && !empty($_SESSION['instructorObj']) ? $_SESSION['instructorObj'] : [];
                            if(empty($sbObj)){
                                $hasAccess = false;
                            }
                            else{
                                $result = makeRequest('get',['username'=>$sbObj['username'],'password'=>$sbObj['password']],['collection'=>'instructors']);
                                if(!empty($result)){
                                    if(isset($result['success']) && !$result['success']){
                                        $hasAccess = false;
                                        $_SESSION['isLoggedInInstructor'] = false;
                                        $_SESSION['instructorObj'] = array();
                                    }
                                    else{
                                        $hasAccess = true;
                                        $_SESSION['isLoggedInInstructor'] = true;
                                        $_SESSION['instructorObj'] = $result;
                                    }
                                }
                                else{
                                    $hasAccess = false;
                                    $_SESSION['isLoggedInInstructor'] = false;
                                    $_SESSION['instructorObj'] = array();
                                }
                            }
                        }
                    }
                }
                if(gettype($route->data) !== "NULL"){
                    $hasDataFn = true;
                    $pageData = call_user_func($route->data,$matches);
                }
                call_user_func($route->onBeforeAction,$pageData);
                if($route->stopProcessing){
                    die();
                }
                if(!$hasAccess){
                    include($this->getTemplatePart('header.php'));
                    include($this->getTemplatePart('components/page-403.php'));
                    include($this->getTemplatePart('footer.php'));
                }
                else{
                    $is404 = $hasDataFn && (empty($pageData) || (isset($pageData['success']) && !$pageData['success']));
                    if(!$route->stopExecution && $is404){
                        $found = false;
                    }
                    else{
                        if($is404){
                            setConfigParam('robots', 'noindex,nofollow');
                            setConfigParam("canonical",'');
                            header("HTTP/1.0 404 Not Found");
                            $route->printHeader = true;
                            $route->printFooter = true;
                        }
                        include($this->getTemplatePart('header.php'));
                        if(!empty($route->file)){
                            if($is404){
                                include($this->getTemplatePart('components/page-404.php'));
                            }
                            else{
                                include($this->getTemplatePart($route->file));
                            }
                        }
                        include($this->getTemplatePart('footer.php'));
                    }
                }
                call_user_func($route->onAfterAction);
            }
            $i++;
        }
    }

    private function getTemplatePart($part){
        $base = ROOT_DIR.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.$this->currentTemplate.DIRECTORY_SEPARATOR;
        return file_exists($base.$part) ? $base.$part : $base.'page-404.php';
    }
}

class Route {
    public $route = "";
    public $isPublic = true;
    public $onBeforeAction;
    public $onAfterAction;
    public $data;
    public $printHeader = true;
    public $printFooter = true;
    public $stopProcessing = false;
    public $stopExecution = true;
    public $file = "";
    public function __construct(){
        $this->onBeforeAction = function (){};
        $this->onAfterAction = function (){};
        /*$this->data = function ($params){
            return [];
        };*/
    }
}
