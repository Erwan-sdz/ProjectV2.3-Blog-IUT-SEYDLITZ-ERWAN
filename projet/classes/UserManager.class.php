<?php
class userManager
{

    //DECLARATION ET ISNTANCIATIONS
    private $bdd;
    private $_result;
    private $_message;
    private $_user; //instance de artciles
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

    function get_user()
    {
        return $this->user;
    }

    function set_user($_user)
    {
        $this->_user = $_user;
    }

    public function add(user $user)
    {
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mdp) VALUES (:nom, :prenom, :email, :mdp)";
        //Sécurisation des variables
        $req = $this
            ->bdd
            ->prepare($sql);
        $req->bindValue(':nom', $user->getNom() , PDO::PARAM_STR);
        $req->bindValue(':prenom', $user->getPrenom() , PDO::PARAM_STR);
        $req->bindValue(':email', $user->getEmail() , PDO::PARAM_STR);
        $req->bindValue(':mdp', $user->getMdp() , PDO::PARAM_STR);
        //Éxécution de la requete
        $req->execute();
        /*if ($req->errorCode() == 00000){
            $this->_result = true;
            $this->_getLastInsertId = $this->bdd->LastInsertId();
        } else {
        $this->_result = false;
        }
        return $this;
        }*/
    }
    public function getByEmail($email)
    {
        $sql = 'SELECT * FROM utilisateurs WHERE email = :email';
        $req = $this
            ->bdd
            ->prepare($sql);

        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();
        $donnees = $req->fetch(PDO::FETCH_ASSOC);
        $user = new user();
        $user->hydrate($donnees);
        return $user;
    }

    public function updateByEmail(user $user)
    {
        $sql = "UPDATE utilisateurs SET sid = :sid WHERE email = :email";
        $req = $this
            ->bdd
            ->prepare($sql);
        $req->bindValue(':email', $user->getEmail() , PDO::PARAM_STR);
        $req->bindValue(':sid', $user->getSid() , PDO::PARAM_STR);
        $req->execute();
        if ($req->errorCode() == 00000)
        {
            $this->_result = true;

        }
        else
        {
            $this->_result = false;
        }
        return $this;
    }
}
