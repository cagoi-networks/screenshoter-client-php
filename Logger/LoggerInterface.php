<?php
/**
 * LoggerInterface.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots\Logger;

interface LoggerInterface {

    const REQUEST = 'request';
    const RESPONSE = 'response';
    const CALLBACK = 'callback';
    const ERROR = 'error';

    /**
     * Add message to log
     * @param string $type
     * @param string $message
     * @param array $context
     */
    public function log($type, $message, array $context = []);
}