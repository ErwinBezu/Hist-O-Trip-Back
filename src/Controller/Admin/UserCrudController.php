<?php

namespace App\Controller\Admin;

use App\Entity\User;
use phpDocumentor\Reflection\Types\Boolean;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
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
            TextField::new('password'),
            UrlField::new('avatar', "Url de l'avatar"),
            ChoiceField::new("is_active","Actif")->setChoices([
                "oui" => "1",
                "non" => "0"
            ])->renderExpanded(),
        ];
    }
}
