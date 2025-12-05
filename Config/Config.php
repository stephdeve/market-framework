<?php
namespace Framework\Config;

class Config {
    private static $config = [];
    private static $loaded = false;
    private static $configPath;
    
    /**
     * Set the config directory path
     */
    public static function setPath(string $path): void
    {
        self::$configPath = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }
    
    /**
     * Load all config files from directory
     */
    public static function load(string $path = null): void
    {
        if ($path) {
            self::setPath($path);
        }
        
        if (!self::$configPath || !is_dir(self::$configPath)) {
            return;
        }
        
        $files = glob(self::$configPath . '*.php');
        
        foreach ($files as $file) {
            $name = basename($file, '.php');
            self::$config[$name] = require $file;
        }
        
        self::$loaded = true;
    }
    
    /**
     * Get a config value using dot notation
     * Example: Config::get('database.host')
     */
    public static function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $value = self::$config;
        
        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }
        
        return $value;
    }
    
    /**
     * Set a config value using dot notation
     */
    public static function set(string $key, $value): void
    {
        $keys = explode('.', $key);
        $config = &self::$config;
        
        foreach ($keys as $i => $segment) {
            if ($i === count($keys) - 1) {
                $config[$segment] = $value;
            } else {
                if (!isset($config[$segment]) || !is_array($config[$segment])) {
                    $config[$segment] = [];
                }
                $config = &$config[$segment];
            }
        }
    }
    
    /**
     * Check if a config key exists
     */
    public static function has(string $key): bool
    {
        $keys = explode('.', $key);
        $value = self::$config;
        
        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return false;
            }
            $value = $value[$segment];
        }
        
        return true;
    }
    
    /**
     * Get all configuration
     */
    public static function all(): array
    {
        return self::$config;
    }
}
