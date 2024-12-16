<?php

namespace App\Controller;

use App\Service\ClientService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Client;
use App\Form\ClientType;

class ClientController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->redirectToRoute('client_list');
    }

    #[Route('/client/list', name: 'client_list')]
    public function list(ClientRepository $clientRepository): Response
    {
        $clients = $clientRepository->findBy([], ['id' => 'ASC']);

        return $this->render('client/list.html.twig', [
            'clients' => $clients,
        ]);
    }

    #[Route('/client/add', name: 'client_add')]
    public function add(Request $request, ClientService $clientService): Response
    {
        $client = new Client('', '', 18, '', '', '', '', '', 0, 0.0);

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientService->save($client);

            return $this->redirectToRoute('client_list');
        }

        return $this->render('client/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/client/{id}/edit', name: 'client_edit')]
    public function edit(int $id, Request $request, ClientRepository $clientRepository, ClientService $clientService): Response
    {
        $client = $clientRepository->find($id);

        if (!$client) {
            throw $this->createNotFoundException('Client not found.');
        }

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientService->save($client);

            return $this->redirectToRoute('client_list');
        }

        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
            'client' => $client,
        ]);
    }
}
