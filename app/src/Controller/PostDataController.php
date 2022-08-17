<?php

namespace App\Controller;

use App\Entity\PostData;
use App\Form\PostDataType;
use App\Repository\PostDataRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post-data")
 */
class PostDataController extends AbstractController
{
    /**
     * @Route("/", name="app_post_data_index", methods={"GET"})
     */
    public function index(PostDataRepository $postDataRepository): Response
    {
        return $this->render('post_data/index.html.twig', [
            'post_datas' => $postDataRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_post_data_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PostDataRepository $postDataRepository): Response
    {
        $postDatum = new PostData();
        $postDatum->setCreatedAt(new \DateTime());
        $form = $this->createForm(PostDataType::class, $postDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postDataRepository->add($postDatum, true);

            return $this->redirectToRoute('app_post_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_data/new.html.twig', [
            'post_datum' => $postDatum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_post_data_show", methods={"GET"})
     */
    public function show(PostData $postDatum): Response
    {
        return $this->render('post_data/show.html.twig', [
            'post_datum' => $postDatum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_post_data_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PostData $postDatum, PostDataRepository $postDataRepository): Response
    {
        $form = $this->createForm(PostDataType::class, $postDatum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postDataRepository->add($postDatum, true);

            return $this->redirectToRoute('app_post_data_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post_data/edit.html.twig', [
            'post_datum' => $postDatum,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_post_data_delete", methods={"POST"})
     */
    public function delete(Request $request, PostData $postDatum, PostDataRepository $postDataRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postDatum->getId(), $request->request->get('_token'))) {
            $postDataRepository->remove($postDatum, true);
        }

        return $this->redirectToRoute('app_post_data_index', [], Response::HTTP_SEE_OTHER);
    }
}
