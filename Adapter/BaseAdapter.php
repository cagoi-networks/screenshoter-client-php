<?php
/**
 * If you want to create your own adapter you need to extend custom adapter from this class
 * BaseAdapter.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 28.10.14
 */
namespace Cagoi\Screenshots\Adapter;

abstract class BaseAdapter {

    const STATUS_OK = 1;
    const STATUS_ERROR = 0;

    /**
     * Check if response successful
     * @param array $response
     * @return boolean
     */
    public function isOk($response) {
        return (
            is_array($response) &&
            isset($response['status']) &&
            ($response['status'] == self::STATUS_OK)
        );
    }

    /**
     * Check parameters existence
     * @param array $names - parameter names
     * @param array $response - response data
     * @return boolean
     */
    public function hasParameters(array $names, $response) {
        if (is_array($response)) {
            foreach ($names as $name) {
                if (!array_key_exists($name, $response)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Get response parameter
     * @param string $key - response parameter key
     * @param array $response - response data
     * @return array|int|string
     */
    public function getParameter($key, $response) {
        if (is_array($response) && isset($response[$key])) {
            return $response[$key];
        }
        return null;
    }


    public function getScreenshot(array $response) {}
}