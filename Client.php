<?php
/**
 * Screenshots client. Need for speaks with screenshot server
 * Client.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots;

use Cagoi\Screenshots\Adapter;
use Cagoi\Screenshots\Params;
use Cagoi\Screenshots\Logger;

class Client {

    // Make screenshot action
    const MAKE_SCREENSHOT_ACTION = '/create-job';
    // Get screenshot action
    const GET_SCREENSHOT_ACTION = '/get-job-result';

    /** @var Logger\LoggerInterface */
    private $_logger;

    /**
     * Server key
     * @var string
     */
    private $_server;

    /**
     * Client key
     * @var string
     */
    private $_secret;

    /**
     * Client constructor.
     * @param string $server - server key
     * @param string $secret - client key
     */
    public function __construct($server, $secret) {
        $this->_server = $server;
        $this->_secret = $secret;
    }

    /**
     * Enable logging
     * @param Logger\LoggerInterface $logger
     */
    public function setLogger(Logger\LoggerInterface $logger) {
        $this->_logger = $logger;
    }

    /**
     * Do request to take screenshot
     * @param Params\MakeParams $params
     * @param Adapter\AdapterInterface $adapter
     * @param ImageCreator $creator
     */
    public function makeScreenshot(Params\MakeParams $params, Adapter\AdapterInterface $adapter, ImageCreator $creator) {
        // Make request
        $params = $params->getParams();
        if ($response = $this->postRequest($this->getActionUrl(self::MAKE_SCREENSHOT_ACTION), $params)) {
            $adapter->makeScreenshot($response, $creator);
        }
    }

    /**
     * Do request to get screenshot
     * @param Params\GetParams $params
     * @param Adapter\AdapterInterface $adapter
     */
    public function getScreenshot(Params\GetParams $params, Adapter\AdapterInterface $adapter) {
        // Make request
        $params = $params->getParams();
        if ($response = $this->postRequest($this->getActionUrl(self::GET_SCREENSHOT_ACTION), $params)) {
            $adapter->getScreenshot($response);
        }
    }

    /**
     * Handler for callback
     * @param array $data - data from server
     * @param Adapter\AdapterInterface $adapter
     */
    public function onCallback(array $data, Adapter\AdapterInterface $adapter) {
        if ($this->_logger) {
            $this->_logger->log(Logger\LoggerInterface::CALLBACK, "Callback from {$this->_server}", $data);
        }
        $adapter->onCallback($data);
    }

    /**
     * Generate url by action
     * @param string $action
     * @return string - action url
     */
    protected function getActionUrl($action) {
        return rtrim($this->_server) . $action;
    }

    /**
     * POST request
     * @param $url - request to url
     * @param array - $data to send
     * @param closure - $callback
     * @return array
     */
    protected function postRequest($url, $data = []) {
        if ($this->_logger) {
            $this->_logger->log(Logger\LoggerInterface::REQUEST, "Request to {$url}", $data);
        }

        $ch = curl_init($url);
        $postString = http_build_query($data, '', '&');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '. $this->_secret,
            "Cache-Control: no-cache",
        ]);
        
        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            if ($this->_logger) {
                $this->_logger->log(Logger\LoggerInterface::ERROR, curl_error($ch));
            }
        } else {
            $response = json_decode($response, true);
            $response = (is_array($response)) ?
                $response : [$response];
            if ($this->_logger) {
                $this->_logger->log(Logger\LoggerInterface::RESPONSE, "Response from {$url}", $response);
            }
            return $response;
        }

        curl_close($ch);
        return [];
    }
}