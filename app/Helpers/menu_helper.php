<?php

if (!function_exists('hasAnyPrivilege')) {

    function hasAnyPrivilege(array $required, array $allowed): bool
    {
        if (empty($required)) {
            return true;
        }

        return count(array_intersect(
            array_map('strtolower', $required),
            array_map('strtolower', $allowed)
        )) > 0;
    }
}