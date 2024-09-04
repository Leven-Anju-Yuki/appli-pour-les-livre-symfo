<?php
// tests/Controller/LivreControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Livre;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LivreControllerTest extends WebTestCase
{
    public function testIndexPage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Livres');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Liste des Livres');
    }

    public function testNewLivre()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/Livre/new');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Créer un nouveau Livre');

        // Soumettre le formulaire
        $form = $crawler->selectButton('Enregistrer')->form([
            'livre[titre]' => 'Nouveau Livre',
            'livre[categorie]' => 'Catégorie Test',
            'livre[prix]' => '15.99',
            'livre[tome]' => '1',
        ]);
        $client->submit($form);

        // Vérifiez la redirection
        $this->assertResponseRedirects('/Livres');
        $client->followRedirect();

        // Vérifiez si le nouveau livre apparaît dans la liste
        $this->assertSelectorTextContains('.livre-title', 'Nouveau Livre');
    }

    public function testEditLivre()
    {
        $client = static::createClient();

        // Rechercher un livre à modifier
        $livreRepository = static::$container->get(LivreRepository::class);
        $livre = $livreRepository->findOneBy(['titre' => 'Nouveau Livre']);

        // Modifier le livre
        $crawler = $client->request('GET', '/Livre/'.$livre->getId().'/edit');
        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Mettre à jour')->form([
            'livre[titre]' => 'Livre Modifié',
        ]);
        $client->submit($form);

        // Vérifiez la redirection
        $this->assertResponseRedirects('/Livres');
        $client->followRedirect();

        // Vérifiez si le livre modifié apparaît dans la liste
        $this->assertSelectorTextContains('.livre-title', 'Livre Modifié');
    }

    public function testDeleteLivre()
    {
        $client = static::createClient();

        // Rechercher un livre à supprimer
        $livreRepository = static::$container->get(LivreRepository::class);
        $livre = $livreRepository->findOneBy(['titre' => 'Livre Modifié']);

        // Supprimer le livre
        $client->request('DELETE', '/Livre/'.$livre->getId());
        $this->assertResponseRedirects('/Livres');

        // Vérifier que le livre n'existe plus
        $client->followRedirect();
        $this->assertSelectorTextNotContains('.livre-title', 'Livre Modifié');
    }
}
