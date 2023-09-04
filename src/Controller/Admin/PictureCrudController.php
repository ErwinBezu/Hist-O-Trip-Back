<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PictureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new("id", "Id de l'image")->hideOnForm(),
            TextField::new("name", "Nom de l'image"),
            TextField::new("picture_legend","Légende de l'image"),
            TextField::new('imageFile', "Envoyer une image depuis votre système")->setFormType(VichImageType::class)->hideOnIndex(),
            UrlField::new("url","Url de l'image"),
            ChoiceField::new("is_main","Image principale")->setChoices([
                "oui" => "1",
                "non" => "0"
            ])->renderExpanded(),
            AssociationField::new("place","Lieu"),
            
        ];
    }
    
}
