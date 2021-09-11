<?= $this->Flash->render('main'); ?>
<?= $this->Flash->render('errors'); ?>
<?= $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'Users', 'action' => 'importCsv']]) ?>
<div class="row">
    <h3>Import CSV file with members</h3>
    <div class="col-3 mb-3">
        <?= $this->Form->control('file', ['type' => 'file', 'label' => false, 'accept' => '.csv']) ?>
    </div>
</div>
<div class="row">
    <div class="col-3 mb-3">
        <?= $this->Form->submit('Proceed', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?= $this->Form->end(); ?>