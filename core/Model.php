<?php

namespace Core;

use Core\Traits\QueryTable;
use ReflectionClass;
use ReflectionProperty;

abstract class Model
{

    use QueryTable;

    public int $id;

    public function toArray(): array
    {
        $data = [];
        $reflect = new ReflectionClass($this);
        $props = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);
        $vars = (array) $this;

        foreach ($props as $prop)
        {
            $data[$prop->getName()] = $vars[$prop->getName()] ?? null;
        }
        return $data;

    }

}