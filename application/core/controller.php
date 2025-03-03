<?php

class Controller
{
    public $urlDetails;
    public $model;

    function __construct($urlDetails)
    {
        $this->urlDetails = $urlDetails;
        $this->loadModel();
    }

    public function loadModel()
    {
        if ($this->urlDetails["controller"] && file_exists(ROOT . "application/model/page/" . $this->urlDetails["controller"] . "_model.php")) {
            require APP . "model/page/" . $this->urlDetails['controller'] . "_model.php";
            $className = implode("", array_map("ucfirst", explode("-", $this->urlDetails["controller"]))) . "Model";
            $this->model = new $className();
        } else {
            $this->model = new Database();
        }
    }
}
