<?php
/**
 * If you want to create your own adapter you need to implement custom adapter from this interface
 * Interface.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots\Adapter;
use Cagoi\Screenshots;

interface AdapterInterface {

    /**
     * Make screenshot response handler
     * @param array $response - data from server
     * @param Screenshots\ImageCreator $creator
     * Example:
     *  [
     *      'status'    => 1
     *      'id'        => (string)$this->getPrimaryKey(),
     *      'secret'    => $this->getSecret()
     *  ]
     *
     * or
     *
     *  [
     *      'status'        => 0
     *      'messages'      => [
     *          'message'
     *          ...
     *      ]
     *  ]
     */
    public function makeScreenshot(array $response, Screenshots\ImageCreator $creator);


    /**
     * Get screenshot response handler
     * @param array $response - data from server
     * Example:
     *  [
     *      'status'    => 1
     *      'urls'      => [
     *          'full'      => <url>
     *          '<w>X<h>'   => <url>
     *          ...
     *      ]
     *  ]
     *
     *  or
     *
     *  [
     *      'status'        => 0
     *      'messages'      => [
     *          'message'
     *          ...
     *      ]
     *  ]
     */
    public function getScreenshot(array $response);

    /**
     * Server callback handler
     * @param array $data - data from server
     * Example:
     *  [
     *      'id'     => (string)$this->getPrimaryKey(),
     *      'secret' => $this->getSecret(),
     *      'urls'   => $this->getUrls()
     *  ]
     *
     * @return mixed
     */
    public function onCallback(array $data);
}