<?php
/**
 * Created by PhpStorm.
 * User: Marcos
 * Date: 17/03/2016
 * Time: 03:40
 */

namespace API\Interfaces;


interface SerializerInterface {

    public function serialize($entity);
    public function serializeAll($entities);

}