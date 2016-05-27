<?php $this->layout('layout', ['title' => 'Mot de passe perdu']) ?>



<?php $this->start('main_content') ?>

<form method="POST">
    <div class="row">
        <div class="col-md-offset-2 col-md-3">
                <label for="email">Email</label>
                <?php if(isset($errors['email'])){
                    echo $errors['email'];
                }?>
                <input type="text" class="form-control" id="email" name="email" placeholder="Votr email">
            </div>
        </div>
        <div class="row">
        <div class="col-md-offset-5 col-md-1">
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="reinit">Réinitialise le mot de passe</button>
        </div>
        </div>
    </div>

<?php $this->stop('main_content') ?>