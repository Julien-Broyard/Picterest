<?php

namespace App\Controller\Admin;

use App\Entity\Pin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();
        $url = $routeBuilder->setController(PinCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Picterest');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Entities');
        yield MenuItem::linkToCrud('Pins', 'fas fa-thumbtack', Pin::class);

        yield MenuItem::section('Other');
        yield MenuItem::linkToRoute('Back to the website', 'fa fa-home', 'app_home');
    }
}
