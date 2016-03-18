<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:40
 */

namespace API\Application;

use \Silex\Application;

class App extends Application {

    public function __construct(array $config = array())
    {
        parent::__construct($config);

        parent::error(function (\Exception $e, $code) {
            return parent::json(array("error" => $e->getMessage()),$code);
        });
    }

} 