<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Menu\Type\Types;

use Cake\Core\App;
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

            $key = App::shortName($controller, 'Controller', 'Controller');
            $value = implode(' - ', $parts);
            $result[$key] = $value;
        }

        // sort by value
        asort($result);

        return $result;
    }
}
