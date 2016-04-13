<?php
/**
 * MongoAdapter.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots\Adapter;

use Cagoi\Screenshots;

class MongoAdapter extends BaseAdapter implements AdapterInterface {

    /**
     * Mongo client instance
     * @var \MongoClient
     */
    private $_client;

    /**
     * Database name
     * @var string
     */
    private $_db;

    /**
     * Collection name
     * @var string
     */
    private $_collection;

    /**
     * MongoAdapter constructor.
     * @param \MongoClient $client - mongo client instance
     * @param string $db - database name
     * @param string $collection - collection name
     */
    public function __construct(\MongoClient $client, $db, $collection = 'screenshots') {
        $this->_db = $db;
        $this->_collection = $collection;

        if ($client instanceof \MongoClient) {
            $this->_client = $client;
        } else {
            throw new \RuntimeException('Incorrect mongo client!');
        }
    }

    public function makeScreenshot(array $response, Screenshots\ImageCreator $creator) {
        if ($this->isOk($response) && $this->hasParameters(['id', 'secret'], $response)) {
            // Save to database
            $client = $this->_client;
            $collection = $client->selectCollection($this->_db, $this->_collection);
            $collection->insert([
                'pk'        => $this->getParameter('id', $response),
                'secret'    => $this->getParameter('secret', $response),
                'data'      => $creator->getData()
            ]);
        }
    }

    public function onCallback(array $data) {
        if ($this->hasParameters(['id', 'secret', 'urls'], $data)) {
            // Save to database
            $client = $this->_client;
            $collection = $client->selectCollection($this->_db, $this->_collection);
            $document = $collection->findOne([
                'pk'        => $this->getParameter('id', $data),
                'secret'    => $this->getParameter('secret', $data)
            ]);

            $creator = new Screenshots\ImageCreator();
            $creator->setData($document['data']);
            $creator->create($this->getParameter('urls', $data));
        }
    }
}