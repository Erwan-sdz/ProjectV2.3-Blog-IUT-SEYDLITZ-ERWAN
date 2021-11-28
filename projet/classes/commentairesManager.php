<?php
require_once 'commentaires.php';
class commentairesManager
{
    private $bdd;
    private $commentaires;
    public function __construct(PDO $bdd){
        $this->setBdd($bdd);
    }
    function getBdd() {
        return $this->bdd;
    }
    function setBdd($bdd){
        $this->bdd = $bdd;
    }
    function get_commentaires() {
        return $this->commentaires;
    }
    function set_commentaires($commentaires) {
        $this->_commentaires = $commentaires;
    }
    public function getCommentaires($id) {
        $ListCommentaires = [];
        $sql = 'SELECT * FROM commentaires WHERE id_article = ?';
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute(array($id));
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $commentaires = new Commentaires();
            $commentaires->hydrate($donnees);
            $ListCommentaires[] = $commentaires;
        }


        return $ListCommentaires;
    }

    public function add(Commentaires $commentaires){
        $sql ="INSERT INTO commentaires (author, content, date ,id_article) VALUES (:author, :content, :date, :id_article)";
        $req = $this->bdd->prepare($sql);
        $req->bindValue(':author', $commentaires->getAuthor(), PDO::PARAM_STR);
        $req->bindValue(':content', $commentaires->getContent(), PDO::PARAM_STR);
        $req->bindValue(':date', $commentaires->getDate(), PDO::PARAM_STR);
        $req->bindValue(':id_article', $commentaires->getIdArticle(), PDO::PARAM_INT);
        $req->execute();
        return $this;
    }
}