<?php require_once 'config/init.conf.php'; ?>
<?php 
$arctl = NULL;
if (isset($_GET['formulaire'])) {
    $articlesManager = new articlesManager($bdd);
    $arctl = $articlesManager->getArticleById(htmlspecialchars($_GET['formulaire']));
}
?>
<?php
if (isset($_GET["formulaire"])) {
    $id_articles = $_GET["formulaire"];
    $articlesManager = new articlesManager($bdd);
    $a = $articlesManager->getArticleById($id_articles);

    if ($a->getPublie() == 0) {
        $publie = "";
    } else {
        $publie = "checked";
    }
}
?>
<?php
    if (isset($_POST['update'])) {
        $articles = new articles();
        $articles->hydrate($_POST);
        $articles->setDate(date('Y-m-d'));
        $publie = $articles->getPublie() === 'on' ? 1 : 0;
        $articles->setPublie($publie);
        $articlesManager = new articlesManager($bdd);
        $articlesManager->updateArticles($articles);

    if ($_FILES['image']['error'] == 0) {
        $fileInfos = pathinfo($_FILES['image']['name']);
        move_uploaded_file(
            $_FILES['image']['tmp_name'],

            'img/' . $articlesManager->get_getLastInsertId() 
                . '.' . $fileInfos['extension']
        );
    }


    if ($articlesManager->get_result() == true) {
        $_SESSION['notification']['result'] = 'success';
        $_SESSION['notification']['message'] = 'votre article est Supprimer';
    } else {
        $_SESSION['notification']['result'] = 'erreur';
        $_SESSION['notification']['message'] = 'une erreur est survenue pendant la supression';
    }
    header("Location: index.php");
    exit();
} else {
    $utilisateur = new utilisateur;
    $utilisateursManager = new utilisateursManager($bdd);
    $sid = $utilisateurs->getsid();
    $loader = new \Twig\Loader\FilesystemLoader(['templates/', 'templates/includes/']);
    $twig = new \Twig\Environment($loader, ['debug' => true]);
    echo $twig->render('FormUpdateArticles.html.twig', ['articles' => $arctl, 'sid' => $sid]);
?>
    <?php
}
    ?>