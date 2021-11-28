


<?php
require_once 'config/init.conf.php';
require_once 'classes/commentairesManager.php';
    $actualy_article = htmlspecialchars($_GET['id']);
    $articleManager = new articlesManager($bdd);
    $articles = $articleManager->get($actualy_article);
    $commentaire = new Commentaires();
    $user = new user();
    $prenom = $user->getPrenom();
    $commentaireManager = new commentairesManager($bdd);
    $commentaires = $commentaireManager->getCommentaires($actualy_article);

if (isset($_POST['submit'])){
    $commentaire = new Commentaires();
    $commentaire->hydrate($_POST);
    $commentaire->setDate(date('Y-m-d'));
    $commentaire->setIdArticle($actualy_article);
    $commentaireManager->add($commentaire);
}
?>
<!doctype html>
<html lang="en">
<?php include 'include/header.inc.php'; ?>
<body>
<script type="text/javascript">
    function ValidForm() {
        let form = document.getElementsByTagName('form');
        form.addEventListener('submit', function(e) {
            let author = document.getElementsByTagName('author');
            if (author.value.trim() === "") {
            let myError = document.getElementsByClassName('error');
            myError.innerHTML = "saisir";
            console.log(myError)
            e.preventDefault()
            }
        })
    }
</script>
    <?php include 'include/nav.inc.php'; ?>
    <div class="container">
        <h2><?= $articles->getTitre() ?></h2>
        <div class="container">
        <img class="card-img-top" src="img/<?= $articles->getId() ?>.jpg" alt="">
        </div>
        <p><?= $articles->getTexte() ?></p>
        <div class="container">
            <span class="error"></span>
            <h2>Ecrire un commentaire :</h2>
            <form id="form" action="" method="post">
                <input type="text" class="form-control" name="author" placeholder="votre pseudo" id="author">
                <input type="email" class="form-control" name="email" placeholder="votre mail" id="mail">
                <textarea class="form-control" name="content" cols="50" rows="10" placeholder="votre commentaire" id="content"></textarea>
                <input class="btn btn-primary" onclick="ValidForm()Ò" type="submit" name="submit" value="Envoyer">
            </form>
            <div class="container">
                <h2>Les commentaires :</h2>
                <?php foreach ($commentaires as $key => $ListCommentaires) {?>
                   <div class="container">
                    <h2><strong>Auteur : <?= $ListCommentaires->getAuthor() ?></strong> :</h2>
                    <p><?= $ListCommentaires->getContent(); ?></p>
                   </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>