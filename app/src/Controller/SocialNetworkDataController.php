<?php

namespace App\Controller;

use App\Entity\SocialNetworkData;
use App\Form\SocialNetworkDataType;
use App\Repository\SocialNetworkDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/social-network-data")
 */
class SocialNetworkDataController extends AbstractController
{
    /**
     * @Route("/", name="app_social_network_data_index", methods={"GET"})
     */
    public function index(SocialNetworkDataRepository $socialNetworkDataRepository): Response
    {
        return $this->render('social_network_data/index.html.twig', [
            'social_network_datas' => $socialNetworkDataRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_social_network_data_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SocialNetworkDataRepository $socialNetworkDataRepository): Response
    {
        $socialNetworkDatum = new SocialNetworkData();
        $form = $this->createForm(SocialNetworkDataType::class, $socialNetworkDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socialNetworkDatum->setDate(new \DateTime());
            $socialNetworkDataRepository->add($socialNetworkDatum, true);

            return $this->redirectToRoute('app_social_network_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('social_network_data/new.html.twig', [
            'social_network_datum' => $socialNetworkDatum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_social_network_data_show", methods={"GET"})
     */
    public function show(SocialNetworkData $socialNetworkDatum): Response
    {
        return $this->render('social_network_data/show.html.twig', [
            'social_network_datum' => $socialNetworkDatum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_social_network_data_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SocialNetworkData $socialNetworkDatum, SocialNetworkDataRepository $socialNetworkDataRepository): Response
    {
        $form = $this->createForm(SocialNetworkDataType::class, $socialNetworkDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socialNetworkDataRepository->add($socialNetworkDatum, true);

            return $this->redirectToRoute('app_social_network_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('social_network_data/edit.html.twig', [
            'social_network_datum' => $socialNetworkDatum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_social_network_data_delete", methods={"POST"})
     */
    public function delete(Request $request, SocialNetworkData $socialNetworkDatum, SocialNetworkDataRepository $socialNetworkDataRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socialNetworkDatum->getId(), $request->request->get('_token'))) {
            $socialNetworkDataRepository->remove($socialNetworkDatum, true);
        }

        return $this->redirectToRoute('app_social_network_data_index', [], Response::HTTP_SEE_OTHER);
    }
}
