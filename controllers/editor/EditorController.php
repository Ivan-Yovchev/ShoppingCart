<?php

namespace Editor\Controllers;

class EditorController extends \Controllers\MasterController {
    public function __construct(
        $class_name = "\\Editor\\Controllers\\EditorController",
        $model = 'master',
        $views_dir = "views\\editor\\master\\"){

        parent::__construct($class_name, $model, $views_dir);
    }
}