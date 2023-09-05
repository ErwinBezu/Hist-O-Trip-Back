<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlaceCrudController extends AbstractCrudController
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
        return Place::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $place = new Place();
        $place->setUsers($this->getUser());

        return $place;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id", "Id de la place")->hideOnForm(),
            TextField::new("name","Nom du lieu"),
            TextField::new("subtitle","Sous Titre")->hideOnIndex(),
            TextField::new("coordinate", "Coordonées GPS")->hideOnIndex(),
            TextField::new("adress", "Adresse")->hideOnIndex(),
            TextField::new("postcode","Code Postal"),
            TextField::new("city", "Ville"),
            TextField::new("country", "Pays"), 
            TextField::new("website","Site Internet")->hideOnIndex(), 
            TextField:: new("phone", "Téléphone")->hideOnIndex(),
            TextareaField::new("description")->hideOnIndex(),
            TextField::new("price","Prix")->hideOnIndex(), 
            TextField::new("opening_hours","Horaires d'ouverture")->hideOnIndex(),
            TextField::new("accessibility","Accessibilité")->hideOnIndex(),
            ChoiceField::new("guided_tour","visite guidée")->setChoices([
                "oui" => "1",
                "non" => "0"
            ])->renderExpanded()->hideOnIndex(),
            ChoiceField::new("is_valid","Valide")->setChoices([
                "oui" => "1",
                "non" => "0"
            ])->renderExpanded(),
            AssociationField::new("categories", "Categorie")->hideOnIndex(),
            AssociationField::new("pictures","Image")->hideOnIndex(),
            AssociationField::new("tags","Tag")->hideOnIndex(),
            SlugField::new("slug", "slug")->setTargetFieldName('name')->hideOnIndex(),
        ];
    }
}
