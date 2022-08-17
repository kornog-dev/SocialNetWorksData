<?php

namespace App\Controller;

use App\Entity\SocialNetwork;
use App\Form\SocialNetworkType;
use App\Repository\SocialNetworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/social-networks")
 */
class SocialNetworkController extends AbstractController
{
    /**
     * @Route("/", name="app_social_network_index", methods={"GET"})
     */
    public function index(SocialNetworkRepository $socialNetworkRepository): Response
    {
        return $this->render('social_network/index.html.twig', [
            'social_networks' => $socialNetworkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_social_network_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SocialNetworkRepository $socialNetworkRepository): Response
    {
        $socialNetwork = new SocialNetwork();
        $form = $this->createForm(SocialNetworkType::class, $socialNetwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socialNetworkRepository->add($socialNetwork, true);

            return $this->redirectToRoute('app_social_network_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('social_network/new.html.twig', [
            'social_network' => $socialNetwork,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_social_network_show", methods={"GET"})
     */
    public function show(SocialNetwork $socialNetwork): Response
    {
        return $this->render('social_network/show.html.twig', [
            'social_network' => $socialNetwork,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_social_network_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SocialNetwork $socialNetwork, SocialNetworkRepository $socialNetworkRepository): Response
    {
        $form = $this->createForm(SocialNetworkType::class, $socialNetwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socialNetworkRepository->add($socialNetwork, true);

            return $this->redirectToRoute('app_social_network_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('social_network/edit.html.twig', [
            'social_network' => $socialNetwork,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_social_network_delete", methods={"POST"})
     */
    public function delete(Request $request, SocialNetwork $socialNetwork, SocialNetworkRepository $socialNetworkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socialNetwork->getId(), $request->request->get('_token'))) {
            $socialNetworkRepository->remove($socialNetwork, true);
        }

        return $this->redirectToRoute('app_social_network_index', [], Response::HTTP_SEE_OTHER);
    }
}
