<?php $this->layout('layout', ['title' => 'Inscription']) ?>



<?php $this->start('main_content') ?>
<?php if(isset($errors['user'])){
        echo "<h3>".$errors['user']."</h3>";
    }?>
<form method="POST">
<div class="row">
    
    <div class="col-md-offset-2 col-md-3">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Email" name="myForm[email]" value="<?= (isset($_POST['myForm']['email']))?$_POST['myForm']['email']:''?>">
        </div>
    </div>
    <div class="row">
    <div class="col-md-offset-5 col-md-1">
        <button type="submit" class="btn btn-primary" name="connexion">Renvoi du mot de passe</button>
    </div>
</div>
</form>

<?php $this->stop('main_content') ?>