<?php
namespace Menu\Type;

use Cake\Filesystem\Folder;
use Cake\Utility\Inflector;
use InvalidArgumentException;
use RuntimeException;

final class TypeFactory
{
    const INTERFACE_CLASS = 'TypeInterface';

    /**
     * Create and return menu item type object.
     *
     * @param string $type Type name
     * @return \Menu\Type\TypeInterface
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public static function create($type)
    {
        if (!is_string($type)) {
            throw new InvalidArgumentException('Type must be a string.');
        }

        $className = __NAMESPACE__ . '\\Types\\' . Inflector::camelize($type);
        if (!class_exists($className)) {
            throw new RuntimeException('Class [' . $className . '] does not exist.');
        }

        $interface = __NAMESPACE__ . '\\' . static::INTERFACE_CLASS;
        if (!in_array($interface, class_implements($className))) {
            throw new RuntimeException('Class [' . $className . '] must implement [' . $interface . '] interface.');
        }

        return new $className();
    }

    /**
     * Menu item types getter.
     *
     * @return array
     */
    public static function getList()
    {
        $result = [];
        $path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Types';
        $dir = new Folder($path);

        $files = $dir->find('.*\.php');

        if (empty($files)) {
            return $result;
        }

        foreach ($files as $file) {
            $name = str_replace('.php', '', $file);
            $value = Inflector::underscore($name);
            $result[$value] = $name;
        }

        return $result;
    }
}
