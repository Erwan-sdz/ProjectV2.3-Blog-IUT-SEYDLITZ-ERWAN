<?php require_once "config/init.conf.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'include/header.inc.php'; ?>
    <body>
        <?php include 'include/nav.inc.php'; ?>
        <?php
            if (isset($_POST['submit'])){
                $user = new user();
                $user->hydrate($_POST);
                $userManager = new userManager($bdd);
                $userManager->add($user);
            header("Location: index.php");
         exit();
    } else {
        $articles = new articles();
        $action = 'ajouter';
    }
    ?>
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 align-items-center my-5">
            </div>
    <form action="inscription.php" method="POST" enctype='multipart/form-data'>
         <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nom</label>
            <input type="name" name="nom" class="form-control">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Prénom</label>
            <input type="surname" name="prenom" class="form-control">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" name="email" class="form-control"  placeholder="nom@exemple.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Mot de passe</label>
            <input type="password" name="mdp" class="form-control">
        </div>
        <center>
            <div class="col-auto">
                <button name="submit" type="submit" class="btn btn-primary mb-3">S'inscrire</button>
            </div>
        </center>
    </form>
        <?php include 'include/footer.inc.php'; ?>
    </body>
</html>