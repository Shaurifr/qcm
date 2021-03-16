<?php

declare(strict_types=1);

namespace App\Tests\Behat;

require 'bin/.phpunit/phpunit-8.5-0/vendor/autoload.php';

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCase;
use Symfony\Component\Panther\PantherTestCaseTrait;
use Symfony\Component\String\Slugger\AsciiSlugger;


/**
 * This context class contains the definitions of the steps used by all the app
 * feature file.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class AppContext extends PantherTestCase implements Context
{
    private Crawler $crawler;
    private Client $client;
    private array $form = [];

    /**
     * @Given /^on se trouve sur la page "([^"]*)"$/
     */
    public function onSeTrouveSurLaPage($page)
    {
        $this->client = self::createPantherClient();
        $this->crawler = $this->client->request('GET', '/logout'); // on se déconnecte, au cas où
        $this->crawler = $this->client->request('GET', $page);
    }

    /**
     * @When /^Je clique sur le bouton "([^"]*)"$/
     */
    public function jeCliqueSurLeBouton($button)
    {
        if ($this->client->getCrawler()->selectButton($button)->getElement(0)) {
            $form = $this->client->getCrawler()->selectButton($button)->form();
            foreach ($this->form as $field => $value) {
                $form[$field] = $value;
            }
            $this->client->submit($form);
        } else {
            $this->client->clickLink($button);
        }
    }

    /**
     * @Then /^Je suis alors sur la page "([^"]*)"$/
     */
    public function jeSuisAlorsSurLaPage($page)
    {
        $currentPage = $this->extractPage($this->client->getCurrentURL());
        if ($page != $currentPage) {
            $page = $page === '/' ? 'home' : $page;
            $this->client->takeScreenshot('public/panther/echec/jeSuisAlorsSurLaPage'.$page.'.png');
            throw new \Exception('on est sur la page '.$currentPage);
        }
        $page = $page === '/' ? 'home' : $page;
        $this->client->takeScreenshot('public/panther/jeSuisAlorsSurLaPage'.$page.'.png');
    }

    private function extractPage($url)
    {
        return explode((string)self::$defaultOptions['port'], $url)[1];
    }

    /**
     * @When /^je remplis le champ "([^"]*)" avec "([^"]*)"$/
     */
    public function jeRemplisLeChampAvec($field, $value)
    {
        $this->form[$field] = $value;
    }

    /**
     * @Then /^Je lis alors sur la page "([^"]*)"$/
     */
    public function jeLisAlorsSurLaPage($text)
    {
        $slugger = new AsciiSlugger();
        $slugText = $slugger->slug($text);
        if (strpos($this->client->getCrawler()->html(), $text) === false) {
            $this->client->takeScreenshot('public/panther/echec/jeLis/'.$slugText.'.png');
            throw new \Exception('Le texte '.$text.' n\'est pas dans la page.');
        }
        $this->client->takeScreenshot('public/panther/jeLis/'.$slugText.'.png');

    }
}
