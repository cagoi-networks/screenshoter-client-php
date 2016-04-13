<?php
/**
 * MakeParams.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots\Params;

use Cagoi\Screenshots;

abstract class BaseParams {

    /**
     * Get params
     * @param string $secret - client key
     * @return array
     */
    public function getParams($secret) {
        return [
            'secret' => $secret,
            'params' => $this->params()
        ];
    }

    abstract public function params();
}