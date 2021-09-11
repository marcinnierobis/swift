<?php

use Migrations\AbstractSeed;

/**
 * User old passwords seed.
 */
class UserOldPasswordsSeed extends AbstractSeed
{
    /**
     * Table name
     */
    private $tableName = 'user_old_passwords';

    /**
     * Run Method
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $data = [];

        InitSeed::truncateTable($this, $this->tableName, $data);
    }
}
