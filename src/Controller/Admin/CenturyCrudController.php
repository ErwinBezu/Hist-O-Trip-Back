<?php

namespace App\Controller\Admin;

use App\Entity\Century;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CenturyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Century::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id", "Id du siècle")->hideOnForm(),
            TextField::new("century", "Siècle"),
            TextField::new("period", "Période")
        ];
    }

}
