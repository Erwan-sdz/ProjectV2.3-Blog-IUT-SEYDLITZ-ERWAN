<?php require_once "config/init.conf.php"; ?>
        <?php
            if (isset($_POST['submit'])){
                $user = new user();
                $user->hydrate($_POST);
                $userManager = new userManager($bdd);
                $utilisateurEnBdd=$userManager->getByEmail($user->getEmail());
                $isConnect = password_verify($user->getMdp(), $utilisateurEnBdd->getMdp());
                if ($isConnect == true){
                    $sid =md5($user->getEmail() . time());
                    setcookie('sid',$sid,time() + 86400);
                    $user->setSid($sid);
                    $userManager->updateByEmail($user);
                }
                if ($isConnect == true){
                    $_SESSION['notification']['result'] = 'success';
                    $_SESSION['notification']['message'] = 'Vous etes connecté';
                    header("Location: index.php");
                    exit();
                }else{
                    $_SESSION['notification']['result'] = 'attention';
                    $_SESSION['notification']['message'] = 'Verifier votre login et mot de passe';
                    header("Location: connexion.php");
                    exit();
                }
         exit();
    } else {
        $articles = new articles();
        $action = 'ajouter';
    }
    ?>
    <!DOCTYPE html>
<html lang="en">
    <?php include 'include/header.inc.php'; ?>
    <body>
        <?php include 'include/nav.inc.php'; ?>
        <div class="container px-4 px-lg-5">
        <?php 
                    if (isset($_SESSION['notification'])){
            ?>
                <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Well done!</h4>
                <p>Bostram Arabia oppida murorum adtributo Mediam contunso castrisque nomine et.</p>
                <hr>
                <p class="mb-0">Bostram Arabia oppida murorum adtributo Mediam contunso castrisque nomine et.</p>
                 </div>
            <?php
            unset($_SESSION['notification']);
                    }
            ?>
            <div class="row gx-4 gx-lg-5 align-items-center my-5">
            </div>
    <form action="connexion.php" method="POST" enctype='multipart/form-data'>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Mail</label>
            <input type="email" name="email" class="form-control"  placeholder="nom@exemple.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Mot de passe</label>
            <input type="password" name="mdp" class="form-control">
        </div>
        <center>
            <div class="col-auto">
                <button name="submit" type="submit" class="btn btn-primary mb-3">Connexion</button>
            </div>
        </center>
    </form>
        <?php include 'include/footer.inc.php'; ?>
    </body>
</html>