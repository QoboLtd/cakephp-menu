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
namespace Menu\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Menu\Model\Entity\MenuItem;

/**
 * MenuItems Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Menus
 * @property \Cake\ORM\Association\BelongsTo $ParentMenuItems
 * @property \Cake\ORM\Association\HasMany $ChildMenuItems
 */
class MenuItemsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('menu_items');
        $this->displayField('label');
        $this->primaryKey('id');

        $this->addBehavior('Tree');

        $this->belongsTo('Menus', [
            'foreignKey' => 'menu_id',
            'joinType' => 'INNER',
            'className' => 'Menu.Menus'
        ]);
        $this->belongsTo('ParentMenuItems', [
            'className' => 'Menu.MenuItems',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildMenuItems', [
            'className' => 'Menu.MenuItems',
            'foreignKey' => 'parent_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('label', 'create')
            ->notEmpty('label');

        $validator
            ->allowEmpty('url');

        $validator
            ->boolean('new_window')
            ->allowEmpty('new_window');

        $validator
            ->requirePresence('menu_id', 'create')
            ->notEmpty('menu_id');

        $validator
            ->allowEmpty('icon');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['menu_id'], 'Menus'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentMenuItems'));

        return $rules;
    }

    /**
     * {@inheritDoc}
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        // fallback to default icon
        if (!$entity->icon) {
            $entity->icon = Configure::read('Icons.default');
        }

        // fallback to hashtag as default url
        if (!$entity->url) {
            $entity->url = '#';
        }
    }
}
