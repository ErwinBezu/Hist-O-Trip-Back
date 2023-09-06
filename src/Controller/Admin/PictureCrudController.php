<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PictureCrudController extends AbstractCrudController
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
