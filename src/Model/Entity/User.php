<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property bool $new
 * @property \Cake\I18n\FrozenTime|null $last_activity
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property UserOldPassword[] $user_old_passwords
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'first_name' => true,
        'last_name' => true,
        'new' => true,
        'last_activity' => true,
        'created' => true,
        'modified' => true,
        'user_old_passwords' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    /**
     * Password hasher.
     *
     * @param string $password Password
     *
     * @return string
     */
    protected function _setPassword(string $password): string
    {
        if (!empty($password)) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return $password;
    }
}
