<?php
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
