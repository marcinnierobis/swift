<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserOldPasswordsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserOldPasswordsTable Test Case
 */
class UserOldPasswordsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserOldPasswordsTable
     */
    protected $UserOldPasswords;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserOldPasswords',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserOldPasswords') ? [] : ['className' => UserOldPasswordsTable::class];
        $this->UserOldPasswords = $this->getTableLocator()->get('UserOldPasswords', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserOldPasswords);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UserOldPasswordsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\UserOldPasswordsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
