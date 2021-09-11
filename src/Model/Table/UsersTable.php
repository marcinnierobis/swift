<?php

declare(strict_types=1);

namespace App\Model\Table;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\UserOldPasswordsTable&\Cake\ORM\Association\HasMany $UserOldPasswords
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('UserOldPasswords', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => 'Email already in use']);

        $validator
            ->scalar('password')
            ->add(
                'password',
                'length',
                ['rule' => ['minLength', 8], 'message' => __('Password need to be at least 8 characters long')]
            )
            ->add(
                'password',
                'custom', [
                'rule' => 'validatePassword',
                'provider' => 'table',
                'message' => 'Password should contain two small letters, two capital letters, two numbers and two special characters'
                ]
            )
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->boolean('new')
            ->notEmptyString('new');

        $validator
            ->dateTime('last_activity')
            ->allowEmptyDateTime('last_activity');

        return $validator;
    }

    /**
     * Validation rules for password.
     *
     * @param Validator $validator Validator instance.
     * @return Validator
     */
    public function validationPassword(Validator $validator): Validator
    {
        $validator
            ->scalar('password')
            ->add('password', 'length', [
                'rule' => ['minLength', 8],
                'message' => __('Password need to be at least 8 characters long')
            ])
            ->add('password', 'custom', [
                'rule' => 'validatePassword',
                'provider' => 'table',
                'message' => 'Password should contain two small letters, two capital letters, two numbers and two special characters'
            ])
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->add('confirm_password', 'no-misspeling', [
                'rule' => ['compareWith', 'password'],
                'message' => __('Passwords are not equal')
            ])
            ->notEmptyString('confirm_password', __('Please repeat password'));

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }

    /**
     * Check password
     * 
     * @param string $password    Password.
     * @param string $oldPassword Old password.
     *
     * @return bool
     */
    public function checkPassword(string $password, string $oldPassword): bool
    {
        return (new DefaultPasswordHasher())->check($password, $oldPassword);
    }

    /**
     * Validate password
     * 
     * @param string $value
     * @param mixed $context
     * @return boolean
     */
    public function validatePassword($value, $context): bool
    {
        if (!preg_match('/(?:[^`!@#$%^&*\-_=+\'\/.,]*[`!@#$%^&*\-_=+\'\/.,]){2}/', $value)) {
            return false;
        }
        if (!preg_match('/(?:[^A-Z]*[A-Z]){2}/', $value)) {
            return false;
        }
        if (!preg_match('/(?:[^a-z]*[a-z]){2}/', $value)) {
            return false;
        }
        if (!preg_match('/(?:[^0-9]*[0-9]){2}/', $value)) {
            return false;
        }
        return true;
    }
}
