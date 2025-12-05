<?php
namespace Framework\Helpers;

class Str {
    /**
     * Create a URL-friendly slug
     */
    public static function slugify(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        
        return empty($text) ? 'n-a' : $text;
    }
    
    /**
     * Truncate a string to a certain length
     */
    public static function truncate(string $text, int $length = 100, string $suffix = '...'): string
    {
        if (mb_strlen($text) <= $length) {
            return $text;
        }
        
        return mb_substr($text, 0, $length) . $suffix;
    }
    
    /**
     * Convert string to camelCase
     */
    public static function camelCase(string $text): string
    {
        $text = str_replace(['-', '_'], ' ', $text);
        $text = ucwords($text);
        $text = str_replace(' ', '', $text);
        return lcfirst($text);
    }
    
    /**
     * Convert string to snake_case
     */
    public static function snakeCase(string $text): string
    {
        $text = preg_replace('/\s+/u', '', ucwords($text));
        return strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1_', $text));
    }
    
    /**
     * Convert string to kebab-case
     */
    public static function kebabCase(string $text): string
    {
        return str_replace('_', '-', self::snakeCase($text));
    }
    
    /**
     * Convert string to PascalCase
     */
    public static function pascalCase(string $text): string
    {
        return ucfirst(self::camelCase($text));
    }
    
    /**
     * Check if string starts with a substring
     */
    public static function startsWith(string $haystack, string $needle): bool
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }
    
    /**
     * Check if string ends with a substring
     */
    public static function endsWith(string $haystack, string $needle): bool
    {
        return substr($haystack, -strlen($needle)) === $needle;
    }
    
    /**
     * Check if string contains a substring
     */
    public static function contains(string $haystack, string $needle): bool
    {
        return strpos($haystack, $needle) !== false;
    }
    
    /**
     * Generate a random string
     */
    public static function random(int $length = 16): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $string;
    }
    
    /**
     * Limit the number of words in a string
     */
    public static function words(string $text, int $words = 100, string $end = '...'): string
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' . $words . '}/u', $text, $matches);
        
        if (!isset($matches[0]) || strlen($text) === strlen($matches[0])) {
            return $text;
        }
        
        return rtrim($matches[0]) . $end;
    }
    
    /**
     * Uppercase the first character of each word
     */
    public static function title(string $text): string
    {
        return mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');
    }
    
    /**
     * Make a string's first character uppercase
     */
    public static function ucfirst(string $text): string
    {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }
}
