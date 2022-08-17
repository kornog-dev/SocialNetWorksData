<?php

/**
 * @author Mari Doucet
 */

// src/Controller/DefaultController.php
namespace App\Controller;

use App\Entity\PostData;
use App\Entity\SocialNetwork;
use App\Entity\SocialNetworkData;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(ManagerRegistry $doctrine): Response
    {
        $networksFull = [];
        $networks = $doctrine->getRepository(SocialNetwork::class)->findAll();

        foreach($networks as $network)
        {
            $networkFull = [];
            $networkFull["network"] = $network;
            $data = $doctrine->getRepository(SocialNetworkData::class)->findOneBy(["network" => $network], ["id" => "DESC"]);
            $postData = $doctrine->getRepository(PostData::class)->findOneBy(["network" => $network], ["cover" => "DESC"]);

            if($data !== null)
            {
                $followerCount = $data->getFollowerCount();
                $networkFull["followerCount"] = $followerCount;
            }
            else
            {
                $networkFull["followerCount"] = 0;
            }

            if($postData !== null)
            {
                $bestCover = $postData->getCover();
                $networkFull["bestCover"] = $bestCover;
            }
            else
            {
                $networkFull["bestCover"] = 0;
            }

            $networksFull[] = $networkFull;
        }

        return $this->render('dashboard/index.html.twig', [
            "networks" => $networksFull
        ]);
    }

    /**
     * @Route("/dashboard-postdata-datasets/{year}", name="dashboard_post_data_datasets")
     */
    public function dashboardPostDataDatasets(ManagerRegistry $doctrine, string $year): Response
    {
        $datasets = [];
        $labels = [];

        $networks = $doctrine->getRepository(SocialNetwork::class)->findAll();

        foreach($networks as $network)
        {
            $dataset = [];
            $data = [];
            $dataset["label"] = $network->getName();
            $dataset["fill"] = false;
            $dataset["tension"] = 0.3;

            if($network->getName() === "Facebook")
            {
                $dataset["borderColor"] = "#4267B2";
            }
            else if($network->getName() === "Twitter")
            {
                $dataset["borderColor"] = "#8bc9f0";
            }
            else if($network->getName() === "Instagram")
            {
                $dataset["borderColor"] = "#C13584";
            }
            else if($network->getName() === "LinkedIn")
            {
                $dataset["borderColor"] = "#50FA7B";
            }

            $postData = $doctrine->getRepository(PostData::class)->findByYearAndNetwork($year, $network);

            foreach($postData as $postDatum)
            {
                $data[] = $postDatum->getCover();
                if(!in_array($postDatum->getPost()->getName(), $labels))
                {
                    $labels[] = $postDatum->getPost()->getName();
                }
            }

            $dataset["data"] = $data;
            $datasets[] = $dataset;
        }

        return new JsonResponse(["result" => [
            "labels" => $labels,
            "datasets" => $datasets
        ]]);
    }
}
