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
namespace Menu\Shell;

use Cake\Console\Shell;

class MenuShell extends Shell
{
    /**
     * {@inheritDoc}
     */
    public $tasks = [
        'Menu.Import'
    ];

    /**
     * {@inheritDoc}
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();

        $parser
            ->description('Menu Shell that handle\'s related tasks.')
            ->addSubcommand(
                'import',
                ['help' => 'Import system menus.', 'parser' => $this->Import->getOptionParser()]
            );

        return $parser;
    }
}
