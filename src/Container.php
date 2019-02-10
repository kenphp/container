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
     * @var array
     */
    protected $_services = [];

    /**
     * @var array
     */
    protected $_factory_id = [];

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
     */
    public function set($id, $item) {
        unset($this->_items[$id]);
        $this->_items[$id] = $item;
    }

    /**
     * Sets an item as an object factory
     * @param string   $id      Identifier of the item
     * @param callable $factory A callable that returns an object
     */
    public function setFactory($id, callable $factory) {
        if (!in_array($id, $this->_factory_id)) {
            $this->_factory_id[] = $id;
        }
        $this->set($id, $factory);
    }

    /**
     * @inheritDoc
     */
    public function get($id) {
        if (!$this->has($id)) {
            throw new NotFoundException("No entry was found for `{$id}` identifier.");
        }

        if (isset($this->_services[$id])) {
            return $this->_services[$id];
        }

        $item = $this->_items[$id];

        try {
            if (is_callable($item)) {
                $item = call_user_func($item, $this);

                if (is_object($item) && !in_array($id, $this->_factory_id)) {
                    $this->_services[$id] = $item;
                }
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
