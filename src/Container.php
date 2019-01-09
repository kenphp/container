<?php

namespace Ken\Container;

use Exception;

/**
 * @inheritDoc
 */
class Container implements \Psr\Container\ContainerInterface {

    /**
     * @var array
     */
    protected $_items = [];

    /**
     * @param array $items
     */
    public function __construct($items = []) {
        $this->_items = $items;
    }

    /**
     * Sets an item into container
     * @param string $id   Identifier of the item
     * @param mixed $item  The item to be saved into the container
     * @throws ContainerException Identifier **id** has been used.
     */
    public function set($id, $item) {
        if ($this->has($id)) {
            throw new ContainerException("Identifier `{$id}` has been used.");
        }

        $this->_items[$id] = $item;
    }

    /**
     * Redefines item in the container
     * @param  string $id   Identifier of the item
     * @param  mixed $item  The item to be saved into the container
     * @throws NotFoundException No entry was found for **id** identifier.
     */
    public function redefine($id, $item) {
        if (!$this->has($id)) {
            throw new NotFoundException("No entry was found for `{$id}` identifier.");
        }

        $this->_items[$id] = $item;
    }

    /**
     * @inheritDoc
     */
    public function get($id) {
        if (!$this->has($id)) {
            throw new NotFoundException("No entry was found for `{$id}` identifier.");
        }

        $item = $this->_items[$id];

        try {
            if (is_callable($item)) {
                $item = call_user_func($item, $this);
            }
        } catch (Exception $e) {
            throw new ContainerException('Error while retrieving the entry. ' . $e->getMessage());
        }

        return $item;
    }

    /**
     * @inheritDoc
     */
    public function has($id) {
        return isset($this->_items[$id]);
    }

}
