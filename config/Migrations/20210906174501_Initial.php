<?php

use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $this->table('users')
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('new', 'boolean', [
                'default' => true,
                'null' => false,
            ])
            ->addColumn('last_activity', 'datetime', [
                'default' => null,
                'null' => true,
            ])
            ->addTimestamps('created', 'modified')
            ->create();

        $this->table('user_old_passwords')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('user_old_passwords')
            ->addForeignKey('user_id', 'users', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION'
            ])
            ->save();
    }

    public function down()
    {
        $this->table('user_old_passwords')->dropForeignKey('user_id');
        $this->table('user_old_passwords')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
