<?php

namespace Controller;


use \W\Controller\Controller;
use \Manager\PostManager;
use \W\Manager\UserManager;
use \W\Security\AuthentificationManager;

class UserController extends Controller
{
    
    public function inscription(){
        $errors = [];
        if(isset($_POST['submit'])){
            if($_POST['myForm']['username'] == ""){
                $errors['login'] = "Le champ login est vide";
            }elseif(preg_match('/[a-zA-Z0-9\_\-\@]{3,20}/' , $_POST['myForm']['username']) == false){
                $errors['login'] = "Le champ login ne respecte pas les conditions (3-20 caractère)";
            }elseif($_POST['myForm']['password'] == ""){
                $errors['mdp'] = "Le champ mot de passe est vide";
            }elseif(preg_match('/[a-zA-Z0-9\_\-\@]{5,32}/',$_POST['myForm']['password']) == false){
                $errors['mdp'] = "Le champ mot de passe ne respecte pas les conditions (5 à 32 caractère alphanumérique)";
            }elseif($_POST['myForm']['email'] == ""){
                $errors['email'] = "Le champ email est vide";
            }elseif(preg_match('/^(([a-zA-Z]|[0-9])|([-]|[_]|[.]))+[@](([a-zA-Z0-9])|([-])){2,63}[.](([a-zA-Z0-9]){2,63})+$/', $_POST['myForm']['email']) == false){
                $errors['email'] = "Merci de rentrer une adresse valide (exemple@exemple.com)";
            }
             if(!$errors){
                $email = $_POST['myForm']['email'];
                $username = $_POST['myForm']['username'];
                $manager = new UserManager();
                $mail = $manager->emailExists($email);
                $user = $manager->usernameExists($username);

                if($mail == false && $user == false){
                    $_POST['myForm']['password'] = password_hash($_POST['myForm']['password'], PASSWORD_DEFAULT);
			        $manager->insert($_POST['myForm']);
			        $this->redirectToRoute('login');
                    }else{
                    $exist = "Login ou email déjà existant";
                    echo $exist;
                    }
		     }
        }
    $this->show('default/inscription',['errors' => $errors]);
    }
    
    	public function login() 
	{
        $errors = [];
		if(isset($_POST['connexion'])) {
			$auth = new AuthentificationManager();
			$userManager = new UserManager();
			if($auth->isValidLoginInfo($_POST['myForm']['username'], $_POST['myForm']['password'])) {
				$user = $userManager->getUserByUsernameOrEmail($_POST['myForm']['username']);
				$auth->logUserIn($user);
				$this->redirectToRoute('home');
			}else{
                $errors['user'] = "Le nom de compte ou le mot de passe sont faux";
            }
		}
		$this->show('default/login',['errors' => $errors]);
	}
    
    public function logout()
    {
        $auth = new AuthentificationManager();
        $auth->logUserOut();
        $this->redirectToRoute('home');
    }
    
    public function oublie()
    {

        $errors = [];
        if(isset($_POST['reinit'])){
            if($_POST['email'] == ""){
                $errors['email'] = "Le champ email est vide";
            }elseif(preg_match('/^(([a-zA-Z]|[0-9])|([-]|[_]|[.]))+[@](([a-zA-Z0-9])|([-])){2,63}[.](([a-zA-Z0-9]){2,63})+$/', $_POST['email']) == false){
                $errors['email'] = "Merci de rentrer une adresse valide (exemple@exemple.com)";
            }else{
            if(!$errors){
                $m = new mdpManager();
                $r = $m->token();
                
                $mailTo = $_POST['email'];
                $mail             = new \PHPMailer();

                $body             = "<a href=\"http://127.0.0.1/reinit/" . $r['user']['id'] . "/" . $r['token'] . "\">lien</a>";
                    
                $mail->IsSMTP();
                $mail->SMTPAuth   = true;
                $mail->Host       = "mail.qsoetemondt.com";  
                $mail->Port       = 25;          
                $mail->Username   = "geek_e_school@qsoetemondt.com";
                $mail->Password   = "Rjne7%41";        
                $mail->From       = "geek_e_school@qsoetemondt.com"; //adresse d’envoi correspondant au login entprécédement
                $mail->FromName   = "Geek_e_school"; // nom qui sera affiché
                $mail->Subject    = "Mot de passe perdu"; // sujet
                $mail->Body       = "";
                $mail->AltBody    = "Voici le lien pour réinitialiser votre mot de passe : ".$body; //Bau format te
                $mail->WordWrap   = 50; // nombre de caractere pour le retour a la ligne automatique
                $mail->MsgHTML($body);
                    
                $mail->AddReplyTo("geek_e_school@qsoetemondt.com","Geek_e_school");
                            // piéce jointe si besoin
                $mail->AddAddress("$mailTo");
                $mail->IsHTML(true); // envoyer au format html, passer a false si en mode texte
                    
                if(!$mail->Send()) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }else {
                    echo "Le message à bien été envoyé";
                }
                $this->redirectToRoute('home');  
            } 
           
       
            }  
        }
        $this->show('default/oublie',['errors' => $errors]);
    }
    public function reinit($id,$token)
    {
        $errors = [];
        if(isset($_POST['changement'])){
            // vérifier si champs vides
            if($_POST['conf_mot_de_passe'] == "" && $_POST['mot_de_passe'] == "" ){
                $errors['mdp'] = 'Les champs sont vides';
            }
            
            // vérifier le bon format
            if(preg_match('/[a-zA-Z0-9\_\-\@]5,32}/' , $_POST['mot_de_passe']) == false) {
                $errors['mdp'] = 'Le mot de passe ne respecte pas le bon format.';
            }
            
            // vérifier si mdp et mdf conf <>
            if($_POST['conf_mot_de_passe'] != $_POST['mot_de_passe']){
                    $errors['mdp'] = "Les mot de passe ne sont pas identiques";
            }
             if(!$errors){
                $m = new mdpManager();
                $m->reinit();
                $this->redirectToRoute('login');
            }   
        }
        $this->show('default/reinit', ['errors' => $errors]);
        
    }
    
    
    
    
    
}
        
    
    
    
    
    
