<?php
namespace Menu\Type\Types;

use Cake\Utility\Inflector;
use Menu\Type\TypeInterface;
use Qobo\Utils\Utility;

class Module implements TypeInterface
{
    /**
     * System modules getter.
     *
     * @return array
     */
    public function getList()
    {
        $result = [];
        $controllers = Utility::getControllers();

        if (empty($controllers)) {
            return $result;
        }

        foreach ($controllers as $controller) {
            $parts = explode('\\', $controller);
            foreach ($parts as $key => &$part) {
                if ('App' === $part) {
                    unset($parts[$key]);
                    continue;
                }

                $part = str_replace('Controller', '', $part);
                $part = Inflector::humanize(Inflector::underscore($part));
            }

            // remove empty values
            $parts = array_filter($parts);
            $result[$controller] = implode(' - ', $parts);
        }

        // sort by value
        asort($result);

        return $result;
    }
}
