<?php $this->layout('layout', ['title' => 'Inscription']) ?>



<?php $this->start('main_content') ?>
<form method="POST">
<div class="row">
    <div class="col-md-offset-2 col-md-3">
        <div class="form-group">
            <label for="Prenom">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" placeholder="Pseudo" name="myForm[username]" value="<?= (isset($_POST['myForm']['username']))?$_POST['myForm']['username']:''?>">
            <?php if(isset($errors['login'])){
                echo $errors['login'];
            }?>
            <span>De 3 à 20 caractères (caractère autorisé alphanumérique - _ @)</span>
        </div>
    </div>

    <div class="col-md-offset-1 col-md-3">
        <div class="form-group">
            <label for="Password">Mot de passe</label>
            <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="myForm[password]" value="<?= (isset($_POST['myForm']['password']))?$_POST['myForm']['password']:''?>">
            <?php if(isset($errors['mdp'])){
                echo $errors['mdp'];
            }?>
            <span>De 5 à 32 caractères (caractère autorisé alphanumérique - _ @)</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-2 col-md-7">
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="text" class="form-control" id="email" placeholder="email" name="myForm[email]" value="<?= (isset($_POST['myForm']['email']))?$_POST['myForm']['email']:''?>">
            <?php if(isset($errors['email'])){
                echo $errors['email'];
            }?>
            <span>Email valide sous format : exemple@exemple.com</span>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-offset-5 col-md-1">
        <button type="submit" class="btn btn-primary" name="submit">Envoyer mes informations</button>
    </div>
</div>
</form>





<?php $this->stop('main_content') ?>




<?php $this->start('footer') ?>
	
   
<?php $this->stop('footer') ?>
