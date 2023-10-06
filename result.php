<?php
    $error = "";
    //test si le formulaire est submit
    if(isset($_POST['submit'])){
        //test si les champs sont tous remplis
        if(!empty($_POST['title'])AND !empty($_POST['content'])AND !empty($_POST['creation_date'])){
            //tester si l'article existe 
            if(!empty(getArticle($bdd, $_POST['title'],$_POST['content'], $_POST['creation_date']))){
                $error = "L'article existe déja";
            }
            //tester si l'article n'existe pas
            else{
                //tester si l'article n'existe pas
                addArticle($bdd, $_POST['title'], $_POST['content'], $_POST['creation_date']);
                $error = "L'article à été ajouté en BDD";
            }
        }
        //test les champs ne sont pas tous remplis
        else{
            $error = "Veuillez remplir les champs du formulaire";
        }
    }
    //Fonction ajouter un article en BDD
    function addArticle($bdd, $title, $content, $date){
        try {
            //préparation de la requête
           $req = $bdd->prepare('INSERT INTO article (title, content, creation_date)
           VALUES (?,?,?)');
           //bind des paramètres
           $req->bindParam(1, $title, PDO::PARAM_STR);
           $req->bindParam(2, $content, PDO::PARAM_STR);
           $req->bindParam(3, $date, PDO::PARAM_STR);
           //exécution de la requête
           $req->execute();
        } catch (Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
    function getArticle($bdd, $title, $content, $date){
        try {
            $req = $bdd->prepare("SELECT id, title, content, creation_date FROM article WHERE
            title = ? AND content = ? AND creation_date = ?");
            $req->bindParam(1, $title, PDO::PARAM_STR);
            $req->bindParam(2, $content, PDO::PARAM_STR);
            $req->bindParam(3, $date, PDO::PARAM_STR);
            //exécution de la requête
            $req->execute();
            return $req->fetch(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) {
            die('Error : '.$e->getMessage());
        }
    }
