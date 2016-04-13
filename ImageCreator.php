<?php
/**
 * Helps creating images by response from server
 * Creator.php class file
 * @author DOL <denis.oleinik@cagoi.com>
 * @date 27.10.14
 */
namespace Cagoi\Screenshots;

class ImageCreator {

    /** @var array */
    public $data = [];

    /**
     * Add file info
     * @param string $key - file key. Can be full or <width>x<height>
     * @param string $saveTo - path to save file
     * @param string $name - file name
     */
    public function add($key, $saveTo, $name) {
        $this->data[$key] = $saveTo . DIRECTORY_SEPARATOR . $name;
    }

    /**
     * Get files data
     * @return array
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Data setter
     * @param array $data - files data
     */
    public function setData(array $data) {
        $this->data = $data;
    }

    /**
     * Create files by urls
     * @param array $urls - urls to create
     */
    public function create(array $urls) {
        foreach ($this->data as $key => $path) {
            if (isset($urls[$key])) {
                $this->toFile($urls[$key], $path);
            }
        }
    }

    /**
     * Create file by url on it
     * @param $url
     * @param $path
     * @return bool
     */
    public function toFile($url, $path) {
        try {
            file_put_contents($path, file_get_contents($url));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}