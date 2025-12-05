<?php
namespace Framework\Helpers;

class Arr {
    /**
     * Get an item from an array using dot notation
     */
    public static function get(array $array, string $key, $default = null)
    {
        if (array_key_exists($key, $array)) {
            return $array[$key];
        }
        
        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }
        
        return $array;
    }
    
    /**
     * Set an item in an array using dot notation
     */
    public static function set(array &$array, string $key, $value): array
    {
        $keys = explode('.', $key);
        
        while (count($keys) > 1) {
            $key = array_shift($keys);
            
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }
            
            $array = &$array[$key];
        }
        
        $array[array_shift($keys)] = $value;
        
        return $array;
    }
    
    /**
     * Check if an item exists in an array using dot notation
     */
    public static function has(array $array, string $key): bool
    {
        if (array_key_exists($key, $array)) {
            return true;
        }
        
        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return false;
            }
            $array = $array[$segment];
        }
        
        return true;
    }
    
    /**
     * Remove an item from an array using dot notation
     */
    public static function forget(array &$array, string $key): void
    {
        $keys = explode('.', $key);
        
        while (count($keys) > 1) {
            $key = array_shift($keys);
            
            if (!isset($array[$key]) || !is_array($array[$key])) {
                return;
            }
            
            $array = &$array[$key];
        }
        
        unset($array[array_shift($keys)]);
    }
    
    /**
     * Get a subset of the items from the given array
     */
    public static function only(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }
    
    /**
     * Get all items except for those with the specified keys
     */
    public static function except(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }
    
    /**
     * Pluck an array of values from an array
     */
    public static function pluck(array $array, string $value, ?string $key = null): array
    {
        $results = [];
        
        foreach ($array as $item) {
            $itemValue = is_object($item) ? $item->{$value} : $item[$value];
            
            if (is_null($key)) {
                $results[] = $itemValue;
            } else {
                $itemKey = is_object($item) ? $item->{$key} : $item[$key];
                $results[$itemKey] = $itemValue;
            }
        }
        
        return $results;
    }
    
    /**
     * Flatten a multi-dimensional array into a single level
     */
    public static function flatten(array $array): array
    {
        $result = [];
        
        array_walk_recursive($array, function($value) use (&$result) {
            $result[] = $value;
        });
        
        return $result;
    }
    
    /**
     * Filter the array using the given callback
     */
    public static function where(array $array, callable $callback): array
    {
        return array_filter($array, $callback, ARRAY_FILTER_USE_BOTH);
    }
    
    /**
     * Get the first element passing a given truth test
     */
    public static function first(array $array, ?callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            if (empty($array)) {
                return $default;
            }
            
            foreach ($array as $item) {
                return $item;
            }
        }
        
        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return $value;
            }
        }
        
        return $default;
    }
    
    /**
     * Get the last element from an array
     */
    public static function last(array $array, ?callable $callback = null, $default = null)
    {
        if (is_null($callback)) {
            return empty($array) ? $default : end($array);
        }
        
        return self::first(array_reverse($array, true), $callback, $default);
    }
}
