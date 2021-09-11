<?php

declare(strict_types=1);

namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Migrations\Migrations;

class InitCommand extends Command
{
    /**
     * @var \Migrations\Migrations
     */
    private $migrations;

    /**
     * @return void
     */
    public function initialize(): void
    {
        $this->migrations = new Migrations();
    }

    /**
     * Init project
     *
     * @param \Cake\Console\Arguments $args Arguments
     * @param \Cake\Console\ConsoleIo $io   Io
     *
     * @return int|void|null
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->info('Initial');
        $io->hr();
        $io->out('Creating database structure...');
        $io->hr();
        $this->migrations->migrate();
        $io->out('Seeding database with default data...');
        $this->migrations->seed(
            [
                'source' => 'Seeds',
                'seed' => 'InitSeed',
            ]
        );
        $io->hr();
        $io->out('Done.');
    }
}
