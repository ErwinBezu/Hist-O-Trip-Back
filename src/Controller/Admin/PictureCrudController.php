<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Validator\Constraints\File;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            UrlField::new("url","Url de l'image"),
            ChoiceField::new("is_main","Image principale")->setChoices([
                "oui" => "1",
                "non" => "0"
            ])->renderExpanded(),
            AssociationField::new("place","Lieu"),
            
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $uploadImage = Action::new('uploadImage', "Upload d'une image", 'fa fa-file-invoice')
            // ->linkToCrudAction('uploadPicture');
            ->linkToRoute('app_api_picture_upload', function(Picture $picture): array {
                
                return [
                    'entity' => self::getEntityFqcn(),
                    'id' => $picture->getId()
                ];
            });

        return $actions
            ->add(Crud::PAGE_EDIT, $uploadImage)
            ->add(Crud::PAGE_NEW, $uploadImage);
    }
    
}
