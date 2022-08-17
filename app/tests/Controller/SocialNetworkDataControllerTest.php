<?php

namespace App\Test\Controller;

use App\Entity\SocialNetworkData;
use App\Repository\SocialNetworkDataRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SocialNetworkDataControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SocialNetworkDataRepository $repository;
    private string $path = '/social/network/data/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(SocialNetworkData::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SocialNetworkDatum index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'social_network_datum[date]' => 'Testing',
            'social_network_datum[followerCount]' => 'Testing',
            'social_network_datum[network]' => 'Testing',
        ]);

        self::assertResponseRedirects('/social/network/data/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new SocialNetworkData();
        $fixture->setDate('My Title');
        $fixture->setFollowerCount('My Title');
        $fixture->setNetwork('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SocialNetworkDatum');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new SocialNetworkData();
        $fixture->setDate('My Title');
        $fixture->setFollowerCount('My Title');
        $fixture->setNetwork('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'social_network_datum[date]' => 'Something New',
            'social_network_datum[followerCount]' => 'Something New',
            'social_network_datum[network]' => 'Something New',
        ]);

        self::assertResponseRedirects('/social/network/data/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getFollowerCount());
        self::assertSame('Something New', $fixture[0]->getNetwork());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new SocialNetworkData();
        $fixture->setDate('My Title');
        $fixture->setFollowerCount('My Title');
        $fixture->setNetwork('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/social/network/data/');
    }
}
