<?= $this->Form->create() ?>
<div class="row">
    <div class="col-3 mb-3">
        <?= $this->Form->control('email', ['type' => 'email', 'id' => 'exampleInputEmail', 'label' => 'Email address']) ?>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
</div>
<div class="row">
    <div class="col-3 mb-3">
        <?= $this->Form->control('password', ['type' => 'password', 'id' => 'exampleInputPassword', 'label' => 'Password']) ?>
    </div>
</div>
<div class="row">
    <div class="col-3 mb-3">
        <?= $this->Form->submit('Login', ['class' => 'btn btn-primary']) ?>
    </div>
</div>
<?= $this->Form->end(); ?>