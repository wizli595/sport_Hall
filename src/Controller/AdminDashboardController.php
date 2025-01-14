<?php

namespace App\Controller;

use App\Repository\AbonneRepository;
use App\Repository\CreneauRepository;
use App\Repository\PaiementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/admin')]
class AdminDashboardController extends AbstractController
{
    #[Route(path:'/', name:'app_admin')]
    public function admin(): Response
    {
        return $this->redirectToRoute('app_admin_dashboard');
    }




    #[Route('/dashboard', name: 'app_admin_dashboard')]
    public function index(
        AbonneRepository $abonneRepo,
        CreneauRepository $creneauRepo,
        PaiementRepository $paiementRepo
    ): Response {
        // Abonnés Data
        $totalAbonnes = $abonneRepo->count([]);
        $activeAbonnes = $abonneRepo->count(['activeSub' => true]);
        $inactiveAbonnes = $abonneRepo->count(['activeSub' => false]);
    
        // Paiements Data
        $totalPaiements = $paiementRepo->getTotalPayments(); // Custom method for total payments
        $paymentData = $paiementRepo->getMonthlyPayments(); // Monthly payment data
        $paymentMonths = array_keys($paymentData);
        $paymentValues = array_values($paymentData);
    
        // Créneaux Data
        $totalCreneaux = $creneauRepo->count([]);
        $availableCreneaux = $creneauRepo->count(['dispo' => true]);
        $reservedCreneaux = $creneauRepo->count(['dispo' => false]);
        $creneauxOverview = $creneauRepo->getCreneauxOverview(); // Daily overview
        $creneauxDates = array_keys($creneauxOverview);
        $availableCreneauxData = array_column($creneauxOverview, 'available');
        $reservedCreneauxData = array_column($creneauxOverview, 'reserved');
    
        return $this->render('admin_dashboard/index.html.twig', [
            'totalAbonnes' => $totalAbonnes,
            'activeAbonnes' => $activeAbonnes,
            'inactiveAbonnes' => $inactiveAbonnes,
            'totalPaiements' => $totalPaiements,
            'paymentMonths' => $paymentMonths,
            'paymentData' => $paymentValues,
            'totalCreneaux' => $totalCreneaux,
            'availableCreneaux' => $availableCreneaux,
            'reservedCreneaux' => $reservedCreneaux,
            'creneauxDates' => $creneauxDates,
            'availableCreneauxData' => $availableCreneauxData,
            'reservedCreneauxData' => $reservedCreneauxData,
        ]);
    }
}