<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Place::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id", "Id de la place")->hideOnForm(),
            TextField::new("name","Nom du lieu"),
            TextField::new("subtitle","Sous Titre"),
            TextField::new("coordinate", "Coordonées GPS"),
            TextField::new("adress", "Adresse"),
            TextField::new("postcode","Code Postal"),
            TextField::new("city", "Ville"),
            TextField::new("country", "Pays"), 
            TextField::new("website","Site Internet"), 
            TextField:: new("phone", "Téléphone"),
            TextEditorField::new("description"),
            TextField::new("price","Prix"), 
            TextField::new("opening_hours","Horaires d'ouverture"),
            TextField::new("accessibility","Accessibilité"),
            ChoiceField::new("guided_tour","visite guidée")->setChoices([
                "oui" => "1",
                "non" => "0"
            ])->renderExpanded(),
            ChoiceField::new("is_valid","Valide")->setChoices([
                "oui" => "1",
                "non" => "0"
            ])->renderExpanded(),
            AssociationField::new("categories", "Categorie"),
            AssociationField::new("pictures","Image"),
            AssociationField::new("tags","Tag")

        ];
    }
  
}
