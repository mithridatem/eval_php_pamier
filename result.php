<?php
    $error = "";
    //test si le formulaire est submit
    if(isset($_POST['submit'])){
        //test si les champs sont tous remplis
        if(!empty($_POST['title'])AND !empty($_POST['content'])AND !empty($_POST['creation_date'])){
            addArticle($bdd, $_POST['title'], $_POST['content'], $_POST['creation_date']);
            $error = "L'article à été ajouté en BDD";
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
?>