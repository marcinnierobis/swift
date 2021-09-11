<?php

use Migrations\AbstractSeed;

/**
 * Init Seed
 */
class InitSeed extends AbstractSeed
{

    /**
     * Run Method
     *
     * @return void
     */
    public function run(): void
    {
        $this->execute("SET NAMES UTF8");

        $this->call('UsersSeed');
        $this->call('UserOldPasswordsSeed');
    }

    /**
     * Truncate table if exist
     *
     * @param object|null $obj       Migration object.
     * @param string|null $tableName Table name.
     * @param array       $data      Array data.
     *
     * @return void
     */
    public static function truncateTable($obj, $tableName = '', array $data = [])
    {
        if ($obj->hasTable($tableName)) {
            $obj->execute('SET FOREIGN_KEY_CHECKS = 0;');
            $table = $obj->table($tableName);
            $table->truncate();
            $table->insert($data)->save();
            $obj->execute('SET FOREIGN_KEY_CHECKS = 1;');
        }
    }
}
