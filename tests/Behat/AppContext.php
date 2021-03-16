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

    /**
     * @Given /^on se trouve sur la page "([^"]*)"$/
     */
    public function onSeTrouveSurLaPage($page)
    {
        $this->client = self::createPantherClient();
        $this->crawler = $this->client->request('GET', $page);
    }

    /**
     * @When /^Je clique sur le bouton "([^"]*)"$/
     */
    public function jeCliqueSurLeBouton($button)
    {
        $this->client->clickLink($button);
    }

    /**
     * @Then /^Je suis alors sur la page "([^"]*)"$/
     */
    public function jeSuisAlorsSurLaPage($page)
    {
        $currentPage = $this->extractPage($this->client->getCurrentURL());
        if ($page != $currentPage) {
            throw new \Exception('on est sur la page '.$currentPage);
        }
        $this->client->takeScreenshot('public/panther/jeSuisAlorsSurLaPage'.$page.'.png');
    }

    private function extractPage($url)
    {
        return explode((string) self::$defaultOptions['port'], $url)[1];
    }
}
