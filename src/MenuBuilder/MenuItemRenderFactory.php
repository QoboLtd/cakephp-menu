<?php

namespace Menu\MenuBuilder;

use Cake\Utility\Inflector;
use RuntimeException;

final class MenuItemRenderFactory {
    
    const INTERFACE_CLASS = 'MenuItemRenderInterface';

    public static function render($type, $param = null, $format = [])
    {
        $obj = static::create($type);
        return $obj->render($param, $format);
    }

    /**
     * Create and return menu item type object.
     *
     * @param string $type Type name
     * @return \Menu\MenuBuilder\MenuItemRenderInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function create($type)
    {
        if (!is_string($type)) {
            throw new InvalidArgumentException('Type must be a string!');
        }

        $className = __NAMESPACE__ . '\\' . Inflector::camelize($type) . 'Render';
        if (!class_exists($className)) {
            throw new RuntimeException('Class [' . $className . '] does not exist.');
        }

        $interface = __NAMESPACE__ . '\\' . static::INTERFACE_CLASS;
        if (!in_array($interface, class_implements($className))) {
            throw new RuntimeException('Class [' . $className . '] must implement [' . $interface . '] interface.');
        }

        return new $className();
    }

}
