<?php

namespace App;

class Util
{
    const DB_DATE_FORMAT = "Y-m-d H:i:s";

    static function toArray($values)
    {
        if (is_array($values)) {
            return $values;
        }

        $array = [];
        if (method_exists($values, 'keys')) {
            foreach ($values->keys() as $key) {
                $array[$key] = $values->get($key);
            }
            return $array;
        }

        foreach (get_object_vars($values) as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }
}
