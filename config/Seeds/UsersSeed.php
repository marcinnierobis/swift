<?php

use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
    /**
     * Table name
     */
    private $tableName = 'users';

    /**
     * Run Method
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $data = [
            [
                'email' => 'marcin.nierobis@gmail.pl',
                'password' => '$2y$10$YY0sBcx2U95luboEjq5jmuOwNaHsfAwSf1zMkBALhtbuG0jCWhuB6',
                'first_name' => 'Marcin',
                'last_name' => 'Nierobis',
            ],
            [
                'email' => 'testowy.user@mail.com',
                'password' => '$2y$10$KiKF8WZS/KcgqRBvszY5JePkmYLINqHUq.HX8Ei9u/Jz.hKTHk6jy',
                'first_name' => 'Testowy',
                'last_name' => 'User',
            ],
        ];

        InitSeed::truncateTable($this, $this->tableName, $data);
    }
}
