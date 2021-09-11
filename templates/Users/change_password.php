<?= $this->Form->create(null) ?>
<h2>Change your password</h3>
<div class="row">
    <div class="col-3 mb-3">
        <?= $this->Form->control('password', ['type' => 'password', 'id' => 'password', 'label' => 'New password']) ?>
        <?= $this->element('error-message', ['fieldName' => 'password']) ?>
    </div>
</div>
<div class="row">
    <div class="col-3 mb-3">
        <?= $this->Form->control('confirm_password', ['type' => 'password', 'id' => 'confirm_password', 'label' => 'Confirm password']) ?>
        <?= $this->element('error-message', ['fieldName' => 'confirm_password']) ?>
    </div>
</div>
<div class="row">
    <div class="col-3 mb-3">
        <?= $this->Form->submit('Save', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?= $this->Form->end(); ?>