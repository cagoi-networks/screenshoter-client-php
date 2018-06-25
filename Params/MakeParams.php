<?php
/**
 * MakeParams.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots\Params;

use Cagoi\Screenshots;

class MakeParams extends BaseParams {

    const AUTO_SCALE = 0;

    /**@var string - url to take screenshot */
    private $_url;
    /**@var array - screenshot scales */
    private $_scales = [];
    /**@var int - delay before screenshot */
    private $_delay = 0;
    /**@var string - callback url */
    private $_callback = '';
    /**@var string - dom element id */
    private $_elementId = '';

    /**
     * Params constructor
     * @param string $url - url to take screenshot
     * @throws Screenshots\Exception
     */
    public function __construct($url) {
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $this->_url = $url;
        } else {
            throw new Screenshots\Exception("Incorrect url");
        }
    }

    /**
     * Callback setter
     * @param string $url - callback url
     * @throws Screenshots\Exception
     */
    public function setCallback($url) {
        if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
            $this->_callback = $url;
        } else {
            throw new Screenshots\Exception("Incorrect callback url");
        }
    }

    /**
     * Delay setter
     * @param int $ms - delay
     */
    public function setDelay($ms) {
        $this->_delay = (int)$ms;
    }

    /**
     * Dom element id setter
     * @param string $id - element id
     */
    public function setElementId($id) {
        $this->_elementId = $id;
    }

    /**
     * Scale setter
     * @param $height
     * @param $width
     * @throws Screenshots\Exception
     */
    public function addScale($height, $width) {
        if (is_numeric($height) && is_numeric($width)) {
            $this->_scales[] = [
                'w' => $width ,
                'h' => $height
            ];
        } else {
            throw new Screenshots\Exception("Incorrect height or width value");
        }
    }

    /**
     * Width scale setter
     * Height will be defined automatically
     * @param $width
     * @throws Screenshots\Exception
     */
    public function addWidthScale($width) {
        if (is_numeric($width)) {
            $this->_scales[] = [
                'w' => $width ,
                'h' => self::AUTO_SCALE
            ];
        } else {
            throw new Screenshots\Exception("Incorrect width value");
        }
    }


    /**
     * Height scale setter
     * Width will be defined automatically
     * @param $height
     * @throws Screenshots\Exception
     */
    public function addHeightScale($height) {
        if (is_numeric($height)) {
            $this->_scales[] = [
                'w' => self::AUTO_SCALE,
                'h' => $height
            ];
        } else {
            throw new Screenshots\Exception("Incorrect height value");
        }
    }

    /**
     * Parameters getter
     * @return array
     */
    public function params() {
        return [
            'url'       => $this->_url,
            'callback'  => $this->_callback,
            'scales'    => $this->_scales,
            'delay'     => $this->_delay,
            'elementId' => $this->_elementId
        ];
    }
}