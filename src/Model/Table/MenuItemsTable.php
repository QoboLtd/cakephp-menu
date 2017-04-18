<?php
namespace Menu\Model\Table;

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
            ->allowEmpty('label');

        $validator
            ->allowEmpty('url');

        $validator
            ->boolean('new_window')
            ->allowEmpty('new_window');

        $validator
            ->allowEmpty('icon');

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
}
