<?php

namespace App\Controller;

use App\Core\Verificator;
use App\Core\View;
use App\Model\Restaurant as RestaurantModel;

class Restaurant
{
    public function restaurant()
    {
        session_start();
        unset($_SESSION["id_restaurant"]);
        $restaurant = new RestaurantModel();
        // utiliser la fonction getAllRestaurant() de RestaurantModel
        $allRestaurants = $restaurant->getAllRestaurants();
        $view = new View("restaurants");
        $view->assign('restaurant', $allRestaurants);
    }

    public function deleteRestaurant()
    {
        $restaurant = new RestaurantModel();
        $table = "restaurant";
        $id = $_POST['id'];
        $restaurant->databaseDeleteOneRestaurant($table, $id);
        header('Location: /restaurants');
    }

    public function getOneRestaurant()
    {
        if (empty($_POST)) {
            header('Location: /restaurants');
        }
        $restaurant = new RestaurantModel();
        $id = $_POST["id"];
        dd($id);
        session_start();
        $_SESSION["id_restaurant"] = $id;
        $table = "restaurant";
        $oneRestaurant = $restaurant->getOneRestaurant($table, $id);
        $restaurant->hydrate($oneRestaurant);
        $view = new View("restaurant-info");
        $view->assign('restaurant', $restaurant);
        $view->assign('oneRestaurant', $oneRestaurant);
    }

    public function createOneRestaurant()
    {
        $restaurant = new RestaurantModel();
        $errors = null;
        // if (!empty($_POST)) {
        // $errors = Verificator::checkForm($restaurant->getCompleteRegisterForm(), $_POST + $_FILES);

        // if (!$errors) {

        $restaurant->hydrate($_POST);
        // $restaurant->setId(null);
        $restaurant->save();
        // }
        // }
        header('Location: /restaurants');
    }

    public function updateRestaurant()
    {
        $restaurant = new RestaurantModel();
        $errors = null;



        $view = new View("create-restaurant");
        $view->assign('restaurant', $restaurant);
        $view->assign("errors", $errors);
    }

    public function restaurantOptions()
    {

        $restaurant = new RestaurantModel();
        $table = "restaurant";
        $id = $_POST["id"];
        session_start();
        $_SESSION["id_restaurant"] = $id;
        $oneRestaurant = $restaurant->getOneRestaurant($table, $id);
        $restaurant->hydrate($oneRestaurant);
        $view = new View("restaurant");
        $view->assign('restaurant', $restaurant);
        $view->assign('oneRestaurant', $oneRestaurant);
    }

    public function stock()
    {
        var_dump("SESSION", $_SESSION);
        // $view = new View("stock");
    }
}
