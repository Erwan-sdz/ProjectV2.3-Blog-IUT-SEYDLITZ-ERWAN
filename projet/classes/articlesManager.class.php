<?php
class articlesManager
{

    //DECLARATION ET ISNTANCIATIONS
    private $bdd;
    private $_result;
    private $_message;
    private $_articles; //instance de artciles
    private $_getLastInsertId;

    public function __construct(PDO $bdd)
    {
        $this->setBdd($bdd);
    }
    function getBdd()
    {
        return $this->bdd;
    }

    function setBdd($bdd)
    {
        $this->bdd = $bdd;
    }

    function get_result()
    {
        return $this->result;
    }

    function set_result($_result)
    {
        $this->_result = $_result;
    }

    function get_message()
    {
        return $this->message;
    }

    function set_message($_message)
    {
        $this->_message = $_message;
    }

    function get_articles()
    {
        return $this->articles;
    }

    function set_articles($_articles)
    {
        $this->_articles = $_articles;
    }

    function get_getLastInsertId()
    {
        return $this->get_LastInsertId;
    }

    function set_getLastInsertId($_getLastInsertId)
    {
        $this->_getLastInsertId = $_getLastInsertId;
    }

    public function get($id)
    {
        //Prépare une requete de type SELECT avec une clause WHERE
        $sql = 'SELECT * FROM articles WHERE id = :id';
        $req = $this
            ->bdd
            ->prepare($sql);
        //Execution e la requete avec attribution des valeurs aux
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        //On stocke les données obtenues dans un tableau
        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        $articles = new articles();
        $articles->hydrate($donnees);
        //print_r2($articles);
        return $articles;
    }
    public function countArticlesPublie()
    {
        $sql = "SELECT COUNT(*) as total FROM articles";
        $req = $this
            ->bdd
            ->prepare($sql);
        $req->execute();
        $count = $req->fetch(PDO::FETCH_ASSOC);
        $total = $count['total'];
        return $total;
    }

    public function getList($depart, $limit)
    {
        $listArticle = [];
        $sql = 'SELECT id,' . ' titre, ' . ' texte, ' . ' publie, ' . ' DATE_FORMAT(date, "%d/%m/%Y") as date' . ' FROM articles ' . ' LIMIT :depart, :limit';
        $req = $this
            ->bdd
            ->prepare($sql);
        $req->bindValue(':depart', $depart, PDO::PARAM_INT);
        $req->bindValue(':limit', $limit, PDO::PARAM_INT);
        //Execution de la requete avec une attribution de valeurs
        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_ASSOC))
        {
            //On créer des objets avec les données issues de la BDD
            $articles = new articles();
            $articles->hydrate($donnees);
            $listArticle[] = $articles;
        }
        return $listArticle;
    }

    public function add(articles $articles)
    {
        $sql = "INSERT INTO articles (titre, texte, publie, date) VALUES (:titre, :texte, :publie, :date)";
        //Sécurisation des variables
        $req = $this
            ->bdd
            ->prepare($sql);
        $req->bindValue(':titre', $articles->getTitre() , PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte() , PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie() , PDO::PARAM_INT);
        $req->bindValue(':date', $articles->getDate() , PDO::PARAM_STR);
        //Éxécution de la requete
        $req->execute();
        if ($req->errorCode() == 00000)
        {
            $this->_result = true;
            $this->_getLastInsertId = $this
                ->bdd
                ->LastInsertId();
        }
        else
        {
            $this->_result = false;
        }
        return $this;
    }

    public function update(articles $articles)
    {
        $sql = "UPDATE articles SET titre = :titre, texte = :texte, publie = :publie WHERE id = :id";
        $req = $this
            ->bdd
            ->prepare($sql);
        $req->bindValue(':titre', $articles->getTitre() , PDO::PARAM_STR);
        $req->bindValue(':texte', $articles->getTexte() , PDO::PARAM_STR);
        $req->bindValue(':publie', $articles->getPublie() , PDO::PARAM_INT);
        $req->bindValue(':id', $articles->getId() , PDO::PARAM_STR);
        $req->execute();
        if ($req->errorCode() == 00000)
        {
            $this->_result = true;
            $this->_getLastInsertId = $this
                ->bdd
                ->LastInsertId();
        }
        else
        {
            $this->_result = false;
        }
        return $this;
    }

    public function getListArticlesFromRecherche($recherche)
    {
        $listAricle = [];

        $sql = 'SELECT id' . 'titre, ' . 'texte, ' . 'publie, ' . 'DATE_FORMAT(date, "%d/%m/%Y") as date ' . 'FROM articles, ' . 'WHERE publie = 1 ' . 'AND (titre LIKE :recherche ' . 'OR texte LIKE :recherche ';

        $req = $this
            ->bdd
            ->prepare($sql);

        $req->bindValue(':recherche', "%" . $recherche . "%", PDO::PARAM_STR);

        $req->execute();

        while ($donnees = $req->fetch(PDO::FETCH_ASSOC))
        {
            $articles = new articles();
            $articles = hydrate($donnees);
            $listArticles[] = $articles;
        }
        return $listArticles;
    }

}
