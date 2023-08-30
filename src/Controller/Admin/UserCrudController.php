<?php

namespace App\Controller\Admin;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Boolean;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Id')->hideOnForm(),
            TextField::new('email', 'Email'),
            ChoiceField::new('roles', 'Role')
                ->setChoices([
                'Administrateur' => "ROLE_ADMIN",
                'Modérateur' => "ROLE_MODERATOR",
                'Utilisateur' => "ROLE_USER"
                ])
                ->allowMultipleChoices(),
            TextField::new('lastname', 'Nom'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('pseudonym', 'Pseudo'),
            UrlField::new('avatar', "Url de l'avatar"),
            ChoiceField::new("is_active","Actif")->setChoices([
                "oui" => "1",
                "non" => "0"
            ])->renderExpanded(),
        ];
    }
}
