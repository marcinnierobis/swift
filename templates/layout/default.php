<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>
        <?= $this->Html->meta('icon') ?>

        <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

        <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'bootstrap.min']) ?>

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
        <?= $this->fetch('script') ?>
    </head>
    <body>
        <nav class="top-nav">
            <div class="top-nav-title">
                <?php if (!empty($this->request->getSession()->read('Auth.id'))): ?>
                    <a href="<?= $this->Url->build(['_name' => 'account']) ?>">Swift<span>Recrutation</span></a>
                <?php else: ?>
                    <a href="<?= $this->Url->build('/') ?>">Swift<span>Recrutation</span></a>
                <?php endif; ?>
            </div>
            <?php if (!empty($this->request->getSession()->read('Auth.id'))): ?>
                <div class="top-nav-links">
                    <a href="<?= $this->Url->build(['_name' => 'logout']) ?>">Logout</a>
                </div>
            <?php endif; ?>
        </nav>
        <main class="main">
            <div class="container">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </main>
        <footer>
            <?= $this->Html->script('/js/bootstrap.min.js') ?>
        </footer>
    </body>
</html>
