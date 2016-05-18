<?php $this->layout('layout', ['title' => 'Inscription']) ?>



<?php $this->start('main_content') ?>
<form method="POST">
<div class="row">
    <div class="col-md-offset-2 col-md-3">
        <div class="form-group">
            <label for="Prenom">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" placeholder="Pseudo" name="myForm[username]" value="<?=$_POST['myForm']['username']?>">
            <?php if(isset($errors['login'])){
                echo $errors['login'];
            }?>
        </div>
    </div>

    <div class="col-md-offset-1 col-md-3">
        <div class="form-group">
            <label for="Password">Mot de passe</label>
            <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="myForm[mdp]" value="<?=$_POST['myForm']['mdp']?>">
            <?php if(isset($errors['mdp'])){
                echo $errors['mdp'];
            }?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-2 col-md-7">
        <div class="form-group">
            <label for="Email">Email</label>
            <input type="text" class="form-control" id="email" placeholder="email" name="myForm[email]" value="<?=$_POST['myForm']['email']?>">
            <?php if(isset($errors['email'])){
                echo $errors['email'];
            }?>
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
