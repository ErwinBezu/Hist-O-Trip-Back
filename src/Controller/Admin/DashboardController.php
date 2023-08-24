<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Place;
use App\Entity\Century;
use App\Entity\Picture;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet 02 Hist O Trip Back');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Place', 'fas fa-list', Place::class);
        yield MenuItem::linkToCrud('Century', 'fas fa-list', Century::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Picture', 'fas fa-list', Picture::class);
        yield MenuItem::linkToCrud('Tag', 'fas fa-list', Tag::class);
    }
}
