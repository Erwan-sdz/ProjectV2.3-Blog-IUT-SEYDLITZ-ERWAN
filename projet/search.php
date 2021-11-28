<?php require_once "config/init.conf.php"; ?>
<!DOCTYPE html>
<html lang="en">
    <?php include 'include/header.inc.php'; ?>
    <body>
    <?php include 'include/nav.inc.php'; ?>
        <div class="container px-4 px-lg-5">
<form action="recherche.php" method="POST" enctype='multipart/form-data'>
    <br>
            <div class="input-group rounded">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" /> </div> <br>
        <center>
            <div class="col-auto">
        <button name="Search" type="submit" class="btn btn-primary mb-3">Search</button>
            </div>
        </center>
    </div> 
</form>
        <?php include 'include/footer.inc.php'; ?>
    </body>
</html>