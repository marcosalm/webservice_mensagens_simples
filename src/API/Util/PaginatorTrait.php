<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:40
 */

namespace API\Util;


trait PaginatorTrait {

    public function getPage()
    {
        return (int) (isset($_GET['p']) ? $_GET['p'] : 1) - 1;
    }

    public function getSearchParam()
    {
        return isset($_GET['s']) ? $_GET['s'] : null;
    }

}