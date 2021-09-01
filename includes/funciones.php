<?php

require 'app.php';

function incluirTemplates (string $template, bool $inicio = false) {

    include TEMPLATES_URL . "/${template}.php";

};