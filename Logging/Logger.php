<?php
namespace Framework\Logging;

class Logger {
    const DEBUG = 'DEBUG';
    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const ERROR = 'ERROR';
    const CRITICAL = 'CRITICAL';
    
    private $logPath;
    private $logFile;
    private $minLevel;
    
    private $levels = [
        self::DEBUG => 0,
        self::INFO => 1,
        self::WARNING => 2,
        self::ERROR => 3,
        self::CRITICAL => 4,
    ];
    
    public function __construct(string $logPath, string $logFile = 'app.log', string $minLevel = self::DEBUG)
    {
        $this->logPath = rtrim($logPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->logFile = $logFile;
        $this->minLevel = $minLevel;
        
        // Create log directory if it doesn't exist
        if (!is_dir($this->logPath)) {
            mkdir($this->logPath, 0755, true);
        }
    }
    
    /**
     * Log a debug message
     */
    public function debug(string $message, array $context = []): void
    {
        $this->log(self::DEBUG, $message, $context);
    }
    
    /**
     * Log an info message
     */
    public function info(string $message, array $context = []): void
    {
        $this->log(self::INFO, $message, $context);
    }
    
    /**
     * Log a warning message
     */
    public function warning(string $message, array $context = []): void
    {
        $this->log(self::WARNING, $message, $context);
    }
    
    /**
     * Log an error message
     */
    public function error(string $message, array $context = []): void
    {
        $this->log(self::ERROR, $message, $context);
    }
    
    /**
     * Log a critical message
     */
    public function critical(string $message, array $context = []): void
    {
        $this->log(self::CRITICAL, $message, $context);
    }
    
    /**
     * Log a message at any level
     */
    public function log(string $level, string $message, array $context = []): void
    {
        // Check if we should log this level
        if ($this->levels[$level] < $this->levels[$this->minLevel]) {
            return;
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $contextString = !empty($context) ? json_encode($context) : '';
        
        $logMessage = "[$timestamp] [$level] $message";
        
        if ($contextString) {
            $logMessage .= " | Context: $contextString";
        }
        
        $logMessage .= PHP_EOL;
        
        // Write to file
        $filePath = $this->logPath . $this->logFile;
        file_put_contents($filePath, $logMessage, FILE_APPEND);
    }
    
    /**
     * Log an exception
     */
    public function exception(\Throwable $exception): void
    {
        $message = sprintf(
            'Exception: %s in %s:%d',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        );
        
        $context = [
            'exception' => get_class($exception),
            'trace' => $exception->getTraceAsString(),
        ];
        
        $this->error($message, $context);
    }
    
    /**
     * Clear log file
     */
    public function clear(): void
    {
        $filePath = $this->logPath . $this->logFile;
        if (file_exists($filePath)) {
            file_put_contents($filePath, '');
        }
    }
    
    /**
     * Get log file path
     */
    public function getLogFilePath(): string
    {
        return $this->logPath . $this->logFile;
    }
    
    /**
     * Rotate log files (create new file daily)
     */
    public function rotate(): void
    {
        $this->logFile = 'app-' . date('Y-m-d') . '.log';
    }
}
