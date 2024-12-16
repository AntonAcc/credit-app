<?php

namespace App\Controller;

use App\Repository\CreditRepository;
use App\Service\CreditService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;

class CreditController extends AbstractController
{
    #[Route('/credit/check-for-client/{client_id}', name: 'credit_check')]
    public function check(int $client_id, ClientRepository $clientRepository, CreditService $creditService): Response
    {
        $client = $clientRepository->find($client_id);

        if (!$client) {
            throw $this->createNotFoundException('Client not found.');
        }

        $reasons = $creditService->getRejectionReasons($client);

        return $this->render('credit/check.html.twig', [
            'client' => $client,
            'isEligible' => empty($reasons),
            'reasons' => $reasons,
        ]);
    }

    #[Route('/credit/issue-for-client/{client_id}', name: 'credit_issue')]
    public function issue(int $client_id, Request $request, ClientRepository $clientRepository, CreditService $creditService): Response
    {
        $client = $clientRepository->find($client_id);

        if (!$client) {
            throw $this->createNotFoundException('Client not found.');
        }

        if (!$creditService->isEligible($client)) {
            return $this->redirectToRoute('credit_check', ['client_id' => $client->getId()]);
        }

        $creditService->issue($client);

        return $this->render('credit/issue.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/credit/list', name: 'credit_list')]
    public function creditList(CreditRepository $creditRepository): Response
    {
        $credits = $creditRepository->findBy([], ['id' => 'ASC']);

        return $this->render('credit/list.html.twig', [
            'credits' => $credits,
        ]);
    }
}
