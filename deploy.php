<?php
require_once("recipe/codeigniter.php");
server('prod_1', '120.55.67.138')
    ->user('root')
    ->password('19880709abC')
    ->env('deploy_path', '/data/wwwroot/default/duodong/')
    ->stage('production');
