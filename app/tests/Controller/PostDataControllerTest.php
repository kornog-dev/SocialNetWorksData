<?php

namespace App\Test\Controller;

use App\Entity\PostData;
use App\Repository\PostDataRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostDataControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PostDataRepository $repository;
    private string $path = '/post/data/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(PostData::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PostDatum index');

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
            'post_datum[likes]' => 'Testing',
            'post_datum[engagement]' => 'Testing',
            'post_datum[cover]' => 'Testing',
            'post_datum[post]' => 'Testing',
            'post_datum[network]' => 'Testing',
        ]);

        self::assertResponseRedirects('/post/data/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PostData();
        $fixture->setLikes('My Title');
        $fixture->setEngagement('My Title');
        $fixture->setCover('My Title');
        $fixture->setPost('My Title');
        $fixture->setNetwork('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PostDatum');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PostData();
        $fixture->setLikes('My Title');
        $fixture->setEngagement('My Title');
        $fixture->setCover('My Title');
        $fixture->setPost('My Title');
        $fixture->setNetwork('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'post_datum[likes]' => 'Something New',
            'post_datum[engagement]' => 'Something New',
            'post_datum[cover]' => 'Something New',
            'post_datum[post]' => 'Something New',
            'post_datum[network]' => 'Something New',
        ]);

        self::assertResponseRedirects('/post/data/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLikes());
        self::assertSame('Something New', $fixture[0]->getEngagement());
        self::assertSame('Something New', $fixture[0]->getCover());
        self::assertSame('Something New', $fixture[0]->getPost());
        self::assertSame('Something New', $fixture[0]->getNetwork());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PostData();
        $fixture->setLikes('My Title');
        $fixture->setEngagement('My Title');
        $fixture->setCover('My Title');
        $fixture->setPost('My Title');
        $fixture->setNetwork('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/post/data/');
    }
}
