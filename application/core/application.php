<?php

class Application
{
    private $urlDetails = [
        "controller" => "home",
        "action" => null,
        "params" => []
    ];

    /**
     * Start the application
     * Analyze the URL elements and call controller/method accordingly with a fallback
     */
    public function __construct()
    {
        // create array with URL parts in $url
        $this->splitUrl();

        // check for controller, if no controller, load start-page
        if (!$this->urlDetails["controller"]) {
            require APP . "controller/home.php";
            $page = new Home($this->urlDetails);
            $page->index();
        } else if (file_exists(APP . "controller/" . $this->urlDetails["controller"] . ".php")) {
            // for class name, will process links with dash
            $className = implode("", array_map("ucfirst", explode("-", $this->urlDetails["controller"])));

            // load this file and create this controller
            require APP . "controller/" . $this->urlDetails["controller"] . ".php";
            $this->urlDetails["controller"] = new $className($this->urlDetails);

            // check for method
            if (method_exists($this->urlDetails["controller"], $this->urlDetails["action"] ?? "")) {
                if (!empty($this->urlDetails["params"])) {
                    // call the method and pass arguments to it
                    call_user_func_array(
                        [$this->urlDetails["controller"], $this->urlDetails["action"]],
                        $this->urlDetails["params"]
                    );
                } else {
                    // if no parameters are given, just call the method without parameters, like $this->home->method();
                    $this->urlDetails["controller"]->{$this->urlDetails["action"]}();
                }
            } else {
                if (strlen($this->urlDetails["action"] ?? "") == 0) {
                    // no action defined, call the default index() method of a selected controller
                    $this->urlDetails["controller"]->index();
                } else {
                    $this->error404();
                }
            }
        } else {
            $this->error404();
        }
    }

    /**
     * Get and split the URL
     */
    private function splitUrl()
    {
        if (isset($_GET["url"])) {
            // split URL
            $url = trim($_GET["url"], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode("/", $url);

            // Put URL parts according to properties
            $this->urlDetails["controller"] = isset($url[0]) ? strtolower($url[0]) : null;
            $this->urlDetails["action"] = isset($url[1]) ? strtolower($url[1]) : null;

            // Remove controller and action from the split URL
            unset($url[0], $url[1]);

            // Rebase array keys and store the URL params
            $this->urlDetails["params"] = array_values($url);
        }
    }

    /**
     * Redirect to error page
     */
    private function error404()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            outputJson([
                'error' => 404,
                'message' => 'Method not found.'
            ], true);
        }
        header("location: " . URL . "page-not-found");
    }
}
