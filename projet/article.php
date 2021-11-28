<?php require_once "config/init.conf.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'include/header.inc.php'; ?>
    <body>
        <?php include 'include/nav.inc.php'; ?>
        <!-- Page Content-->
        <?php
if (isset($_POST['submit']))
{
    //print_r2($_POST);
    $articles = new articles();
    $articles->hydrate($_POST);

    $articles->setDate(date('Y-m-d'));
    $publi = $articles->getPublie() === 'on' ? 1 : 0;
    $articles->SetPubli($publi);

    $articlesManager = new articlesManager($bdd);
    $articlesManager->add($articles);

    if ($_FILES['image']['error'] == 0)
    {
        $fileInfos = pathinfo($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $articlesManager->get_getLastInsertId() . '.' . $fileInfos['extension']);
    }

    if ($articlesManager->get_result() == true)
    {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'Votre article a été ajouté';
    }
    else
    {
        $_SESSION['notification']['result'] = 'danger';
        $_SESSION['notification']['message'] = "Une erreur est survenue pendant la création de l'article";
    }
    header("Location: index.php");
    exit();
}
else
{
    $articles = new articles();
    $action = 'ajouter';
}
?>
        <div class="container px-4 px-lg-5">
            <!-- Heading Row-->
            <div class="row gx-4 gx-lg-5 align-items-center my-5">
            </div>
    <form action="article.php" method="POST" enctype='multipart/form-data'>
            <div class="input-group mb-3">
                <input type="text" name="titre" class="form-control" placeholder="Titre" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <textarea class="form-control" name="texte" placeholder="Texte de mon article" aria-label="With textarea" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <input name='image' placeholder="Charger une image" class="form-control form-control-sm" id="formFileSm" type="file">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
                Publier l'article ?
            </label>
            </div>
        <center>
            <div class="col-auto">
                <button name="submit" type="submit" class="btn btn-primary mb-3">Publier</button>
            </div>
        </center>
    </form>
        <!-- Footer-->
        <?php include 'include/footer.inc.php'; ?>
    </body>
</html>
