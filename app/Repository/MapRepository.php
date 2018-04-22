<?php
/**
 * Created by PhpStorm.
 * User: liyibing
 * Date: 2018/4/22
 * Time: 上午10:29
 */

namespace App\Repository;


use App\Map;

class MapRepository
{
    public  function create(array $attributes)
    {
        return Map::create($attributes);
    }
}