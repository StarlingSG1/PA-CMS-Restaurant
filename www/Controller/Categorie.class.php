<?php

namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;
use App\Core\MysqlBuilder;
use App\Model\Categorie as CategorieModel;
use App\Model\Meal as MealModel;

class Categorie
{

    public function createcategorie()
    {
        $_POST = array_map('htmlspecialchars', $_POST);
        $queryBuilder = new MysqlBuilder();
        $categorie = new CategorieModel();
        $categorie->hydrate($_POST);
        $categorie->save();

        header('Location: /restaurant/carte/meals');
    }

    public function updateCategorie()
    {
        $_POST = array_map('htmlspecialchars', $_POST);
        $categorie = new CategorieModel();
        $categorie->hydrate($_POST);
        $categorie->save();

        header('Location: /restaurant/carte/meals');
    }

    public function deleteCategorie()
    {
        $categorie = new CategorieModel();
        $categorie->deleteCategorie($_POST["id"]);

    }

}
