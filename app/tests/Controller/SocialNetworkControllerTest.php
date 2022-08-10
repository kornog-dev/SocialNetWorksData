<?php

namespace App\Test\Controller;

use App\Entity\SocialNetwork;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SocialNetworkControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SocialNetworkRepository $repository;
    private string $path = '/social/network/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(SocialNetwork::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SocialNetwork index');

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
            'social_network[name]' => 'Testing',
            'social_network[logoUrl]' => 'Testing',
            'social_network[profileUrl]' => 'Testing',
        ]);

        self::assertResponseRedirects('/social/network/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new SocialNetwork();
        $fixture->setName('My Title');
        $fixture->setLogoUrl('My Title');
        $fixture->setProfileUrl('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SocialNetwork');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new SocialNetwork();
        $fixture->setName('My Title');
        $fixture->setLogoUrl('My Title');
        $fixture->setProfileUrl('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'social_network[name]' => 'Something New',
            'social_network[logoUrl]' => 'Something New',
            'social_network[profileUrl]' => 'Something New',
        ]);

        self::assertResponseRedirects('/social/network/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getLogoUrl());
        self::assertSame('Something New', $fixture[0]->getProfileUrl());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new SocialNetwork();
        $fixture->setName('My Title');
        $fixture->setLogoUrl('My Title');
        $fixture->setProfileUrl('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/social/network/');
    }
}
