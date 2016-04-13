<?php
/**
 * GetParams.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots\Params;

class GetParams extends BaseParams{

    /**@var string - screenshot pk */
    private $_id;
    /**@var string - screenshot secret */
    private $_secret;

    /**
     * Params constructor
     * @param string $id - screenshot primary key
     * @param string $secret - screenshot secret
     */
    public function __construct($id, $secret) {
        $this->_id      = $id;
        $this->_secret  = $secret;
    }

    /**
     * Parameters getter
     * @return array
     */
    public function params() {
        return [
            'id'        => $this->_id,
            'secret'    => $this->_secret
        ];
    }
}