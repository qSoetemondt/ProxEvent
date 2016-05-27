<?php $this->layout('layout', ['title' => 'Inscription']) ?>



<?php $this->start('main_content') ?>


        <form method="POST" action="">
            <?php if(!empty($errors)){
                    echo $errors['mdp'];
                }?>
            <input type="hidden" name="id" value="<?= $_GET['id']?>">
            <div class="row">
                <div class="col-md-offset-2 col-md-3">
                    <div class="form-group">
                        <label for="mot_de_passe">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe"       placeholder="Votre mot de passe">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-offset-2 col-md-3">
                        <div class="form-group">
                            <label for="conf_mot_de_passe">confirmation mot de passe</label>
                            <input type="password" class="form-control" id="conf_mot_de_passe" name="       conf_mot_de_passe" placeholder="confirmer votre mot de passe">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-5 col-md-1">
                            <button type="submit" class="btn btn-primary" name="changement">Confirmer nouveau mot de passe</button>
                        </div>
                    </div>
                </form>        
 
<?php $this->stop('main_content') ?>
