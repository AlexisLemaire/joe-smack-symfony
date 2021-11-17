<?php
namespace App\Tests\unitaires;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class recettesControllerTest extends WebTestCase {

    // TO TEST IN DEV : "http://localhost:8000"

    // public function test_postRecette() {
    //     $client = static::createClient(); 
    //     $client->catchExceptions(false);
    //     $client->request("POST", "https://joe-smack-symfony.herokuapp.com/recettes/ajout", [], [], [], null);
    //     $this->assertEquals(200, $client->getResponse()->getStatusCode());
    // }

    public function test_findRecette() {
        $client = static::createClient(); 
        $client->catchExceptions(false);
        $client->request("GET", "https://joe-smack-symfony.herokuapp.com/recettes/recette/11", [], [], [], null);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function test_findOtherRecette() {
        $client = static::createClient(); 
        $client->request("GET", "https://joe-smack-symfony.herokuapp.com/recettes/recette/12", [], [], [], );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}

?>
