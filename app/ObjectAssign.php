<?php

namespace App;

class ObjectAssign {
    static function assign($obj, $values)
    {
        if (method_exists($values,'keys')) {
            foreach ($values->keys() as $key) {
                $obj[$key] = $values->get($key);
            }

            return $obj;
        }

        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $obj[$key] = $value;
            }

            return $obj;
        }

        foreach (get_object_vars($values) as $key => $value) {
            $obj[$key] = $value;
        }

        return $obj;
    }
}
