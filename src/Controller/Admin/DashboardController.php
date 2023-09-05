<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Place;
use App\Entity\Century;
use App\Entity\Picture;
use App\Entity\Category;
use App\Repository\PlaceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private $placeRepository;

    public function __construct(PlaceRepository $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }
    
    /**
     * @Route("/admin", name="app_admin_index")
     */
    public function index(): Response
    {
        $placesNoActived = $this->placeRepository->findBy(['is_valid' => 0], ['created_at' => 'ASC']);
        // return parent::index();
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);

        return $this->render('admin/index.html.twig', ['placesNoActived' => $placesNoActived]);
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
        yield MenuItem::linkToCrud('Century', 'fas fa-list', Century::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Category', 'fas fa-list', Category::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('Picture', 'fas fa-list', Picture::class);
        yield MenuItem::linkToCrud('Tag', 'fas fa-list', Tag::class)->setPermission('ROLE_ADMIN');
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class)->setPermission('ROLE_ADMIN');
    }
}
