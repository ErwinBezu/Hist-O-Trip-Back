<?php

namespace App\Controller\Admin;

use App\Entity\Place;
use App\Entity\Picture;
use Doctrine\DBAL\Types\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
            AssociationField::new("centuries", "Période")->hideOnIndex(),
            AssociationField::new("pictures","Image")->hideOnIndex(),
            AssociationField::new("tags","Tag")->hideOnIndex(),
            SlugField::new("slug", "slug")->setTargetFieldName('name')->hideOnIndex()
        ];
    }
  
    public function configureActions(Actions $actions): Actions
    {
        $uploadImage = Action::new('uploadImage', "Upload d'une image", 'fa fa-file-invoice')
            // ->linkToCrudAction('uploadPicture');
            ->linkToRoute('app_api_picture_upload', function(Place $place): array {
                return [
                    'entity' => self::getEntityFqcn(),
                    'id' => $place->getId()
                ];
            });

        return $actions
            // ->add(Crud::PAGE_NEW, $uploadImage)
            ->add(Crud::PAGE_EDIT, $uploadImage);
    }
}
