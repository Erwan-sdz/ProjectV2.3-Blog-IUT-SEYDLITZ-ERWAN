<?php require_once 'config/init.conf.php';
define('nb_articles_par_page', 2);
$articlesManager = new articlesManager($bdd);
$page = !empty($_GET['p']) ? $_GET['p'] : 1; // si $get p est différent de vide, alors la valeur sera $_GET[p], sinon $page vaut 1
$indexDepart = ($page - 1) * nb_articles_par_page;
$nbArticlesTotalPublie = $articlesManager->countArticlesPublie();
$nbPages = ceil($nbArticlesTotalPublie / nb_articles_par_page);
$articles = $articlesManager->getList($indexDepart, nb_articles_par_page);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'include/header.inc.php'; ?>
<body>
    <?php include 'include/nav.inc.php'; ?>
    <div class="container px-4 px-lg-5">
        <?php
if (isset($_SESSION['notification']))
{
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
        <!-- Heading Row -->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-12"></div>
                <h1 class="font-weight-light"></h1>
                <p>Bostram Arabia oppida murorum adtributo Mediam contunso castrisque nomine et.</p>
        <!-- Content Row-->
        <div class="row gx-4 gx-lg-5">
            <?php
foreach ($articles as $key => $ListArticle)
{
?>
            <div class="col-md-4 mb-5">
                <div class="card h-100">
                <img class="card-img-top" src="img/<?=$ListArticle->getId() ?>.jpg">
                    <div class="card-body">
                        <h2 class="card-title"><?=$ListArticle->getTitre() ?></h2>
                        <p class="card-text"><?=$ListArticle->getTexte() ?></p>
                    </div>
                    <div class="card-footer"><a class="btn btn-primary btn-sm" href="#!"><?=$ListArticle->getDate() ?></a></div>
                    <div class="card-footer"><a class="btn btn-primary btn-sm" href="modifier_article.php?id=<?=$ListArticle->getId() ?>">Modifier</a></div>
                </div>
            </div>
            <?php
}
?>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <nav aria-label="Page navigation exemple">
                <ul class="pagination justify-content-center">
                    <?php for ($index = 1;$index <= $nbPages;$index++)
{ ?>
                        <li class="page-item <?php if ($page == $index)
    { ?>active<?php
    } ?>">
                            <a class="page-link" href="index.php?p=<?=$index ?>"><?=$index ?></a>
                        </li>
                        <?php
}
?>
                </ul>
            </nav>
        </div>
    </div>
    <?php include 'include/footer.inc.php'; ?>
</body>
</html>