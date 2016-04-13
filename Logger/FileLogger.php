<?php
/**
 * Logger.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots\Logger;

class FileLogger implements LoggerInterface {

    /**
     * Path to the log file
     * @var string
     */
    private $file = null;

    /**
     * This holds the file handle for this instance's log file
     * @var resource
     */
    private $handle = null;

    /**
     * Class constructor
     * @param string $dir - file path to the logging directory
     * @throws \RuntimeException
     */
    public function __construct($dir) {
        $logDirectory = rtrim($dir, '\\/');
        if (!file_exists($dir)) {
            mkdir($logDirectory, 0777, true);
        }

        $this->file = $logDirectory . DIRECTORY_SEPARATOR . 'log.txt';
        if (file_exists($this->file) && !is_writable($this->file)) {
            throw new \RuntimeException('Can`t write to file. Check permissions.');
        }

        $this->handle = fopen($this->file, 'a');
        if (!$this->handle) {
            throw new \RuntimeException('Can`t open file. Check permissions.');
        }
    }

    /**
     * Add message to log
     * @param string $type
     * @param string $message
     * @param array $context
     */
    public function log($type, $message, array $context = array()) {
        $message = $this->formatMessage($type, $message, $context);
        $this->write($message);
    }

    /**
     * Writes a line to the log
     * @param string $message Line to write to the log
     * @throws \RuntimeException
     */
    public function write($message) {
        if (!is_null($this->handle)) {
            if (fwrite($this->handle, $message) === false) {
                throw new \RuntimeException('Can`t write to file. Check permissions.');
            }
        }
    }

    /**
     * Formats the message for logging.
     *
     * @param  string $type   message type
     * @param  string $message - message to log
     * @param  array  $context - the context
     * @return string
     */
    private function formatMessage($type, $message, $context) {
        $type = strtoupper($type);
        if (!empty($context)) {
            $message .= PHP_EOL . $this->indent($this->contextToString($context));
        }
        $date = date('Y-m-d H:i:s');
        return "[{$date}] [{$type}] {$message}".PHP_EOL;
    }

    /**
     * Takes the given context and coverts it to a string.
     * @param  array $context The Context
     * @return string
     */
    private function contextToString($context) {
        $export = '';
        foreach ($context as $key => $value) {
            $export .= "{$key}: ";
            $export .= preg_replace(array(
                '/=>\s+([a-zA-Z])/im',
                '/array\(\s+\)/im',
                '/^  |\G  /m',
            ), array(
                '=> $1',
                'array()',
                '    ',
            ), str_replace('array (', 'array(', var_export($value, true)));
            $export .= PHP_EOL;
        }
        return str_replace(array('\\\\', '\\\''), array('\\', '\''), rtrim($export));
    }

    /**
     * Indents the given string with the given indent.
     * @param  string $string The string to indent
     * @param  string $indent What to use as the indent.
     * @return string
     */
    private function indent($string, $indent = '    ') {
        return $indent.str_replace("\n", "\n".$indent, $string);
    }

    /** Class destructor */
    public function __destruct() {
        if ($this->handle) {
            fclose($this->handle);
        }
    }
}