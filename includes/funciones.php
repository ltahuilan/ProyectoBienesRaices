<?php

require 'app.php';

function incluirTemplates (string $template, bool $inicio = false, bool $admin = false) {

    include TEMPLATES_URL . "/${template}.php";

};