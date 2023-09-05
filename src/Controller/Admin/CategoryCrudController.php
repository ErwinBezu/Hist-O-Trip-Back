<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
  
    public function configureActions(Actions $actions) : Actions
    {
        $actions->add(Crud::PAGE_INDEX, Action::DETAIL);

        $user = $this->getUser();
        $userRole = $user->getRoles();

        if (!in_array('ROLE_ADMIN', $userRole)) {
            $actions->disable(Action::NEW, Action::EDIT, Action::DELETE);
        }

        return $actions;
    }   
    
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id", "Id de la catégorie")->hideOnForm(),
            TextField::new("name", "Nom de la catégorie"),
            TextField::new("icon", "Icone de la catégorie")
        ];
    }
    
}
