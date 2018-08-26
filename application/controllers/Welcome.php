<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('parser');
    }

    public function index() {
        $view["aaa"] = "";

        $form = $this->parser->parse('atm', $view, TRUE);

        $this->parser->parse('template/template', array(
            "Title" => "ATM Simulation",
            "Menu" => "ATM Simulation",
            "SubTitle" => "ATM Simulation",
            "Content" => $form
        ));
    }

}
