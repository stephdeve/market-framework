<?php
namespace Framework\Core;

class Response {
    private $content;
    private $statusCode;
    private $headers;
    
    public function __construct($content = '', int $statusCode = 200, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }
    
    /**
     * Set response content
     */
    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * Set status code
     */
    public function setStatusCode(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }
    
    /**
     * Add a header
     */
    public function header(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }
    
    /**
     * Send the response
     */
    public function send(): void
    {
        http_response_code($this->statusCode);
        
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }
        
        echo $this->content;
    }
    
    /**
     * Create JSON response
     */
    public static function json($data, int $statusCode = 200): self
    {
        $response = new self(json_encode($data), $statusCode);
        $response->header('Content-Type', 'application/json');
        return $response;
    }
    
    /**
     * Create HTML response
     */
    public static function html(string $html, int $statusCode = 200): self
    {
        $response = new self($html, $statusCode);
        $response->header('Content-Type', 'text/html; charset=utf-8');
        return $response;
    }
    
    /**
     * Create redirect response
     */
    public static function redirect(string $url, int $statusCode = 302): self
    {
        $response = new self('', $statusCode);
        $response->header('Location', $url);
        return $response;
    }
    
    /**
     * Create download response
     */
    public static function download(string $filePath, ?string $filename = null): self
    {
        if (!file_exists($filePath)) {
            throw new \Exception("File not found: $filePath");
        }
        
        $filename = $filename ?? basename($filePath);
        $content = file_get_contents($filePath);
        
        $response = new self($content, 200);
        $response->header('Content-Type', 'application/octet-stream');
        $response->header('Content-Disposition', "attachment; filename=\"$filename\"");
        $response->header('Content-Length', (string) strlen($content));
        
        return $response;
    }
    
    /**
     * Set a cookie
     */
    public function cookie(
        string $name, 
        string $value = '', 
        int $expire = 0, 
        string $path = '/', 
        string $domain = '', 
        bool $secure = false, 
        bool $httponly = true
    ): self {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
        return $this;
    }
    
    /**
     * Quick response helpers
     */
    public static function ok($data = null)
    {
        return self::json(['status' => 'success', 'data' => $data], 200);
    }
    
    public static function created($data = null)
    {
        return self::json(['status' => 'success', 'data' => $data], 201);
    }
    
    public static function noContent()
    {
        return new self('', 204);
    }
    
    public static function badRequest(string $message = 'Bad Request')
    {
        return self::json(['status' => 'error', 'message' => $message], 400);
    }
    
    public static function unauthorized(string $message = 'Unauthorized')
    {
        return self::json(['status' => 'error', 'message' => $message], 401);
    }
    
    public static function forbidden(string $message = 'Forbidden')
    {
        return self::json(['status' => 'error', 'message' => $message], 403);
    }
    
    public static function notFound(string $message = 'Not Found')
    {
        return self::json(['status' => 'error', 'message' => $message], 404);
    }
    
    public static function serverError(string $message = 'Internal Server Error')
    {
        return self::json(['status' => 'error', 'message' => $message], 500);
    }
}
