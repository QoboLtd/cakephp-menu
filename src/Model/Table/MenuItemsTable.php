<?php
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
     * List of ignored icons.
     *
     * @var array
     */
    protected $_ignoreIcons = [
        'lg',
        '2x',
        '3x',
        '4x',
        '5x'
    ];

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
     * Icons list getter.
     *
     * @return array
     */
    public function getIcons()
    {
        $result = [];

        $data = file_get_contents('https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css');
        preg_match_all('/\.fa-([\w|-]+)/', $data, $matches);

        if (empty($matches[1])) {
            return $result;
        }

        $result = array_unique($matches[1]);
        $result = array_diff($result, $this->_ignoreIcons);
        sort($result);

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        // fallback to default icon
        if (!$entity->icon) {
            $entity->icon = Configure::read('Menu.default_icon');
        }
    }
}
