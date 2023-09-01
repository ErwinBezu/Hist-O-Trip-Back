<?php

namespace App\Controller\Api;

use App\Entity\Picture;
use ImageKit\ImageKit;
use App\Form\PictureType;
use App\Repository\PlaceRepository;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PictureController extends AbstractController
{
    /**
     * @Route("/api/picture/upload", name="app_api_picture_upload")
     */
    public function upload($entity, $id = null, PictureRepository $pictureRepository, PlaceRepository $placeRepository, Request $request, SluggerInterface $slugger, EntityManagerInterface $manager): Response
    {
        $public_key = "public_yF2GSL446Ifs67LTlaSbYPKPVds=";
        $your_private_key = "private_CKt9uFG2DPooBBKCG4pKMvjP+6w=";
        $url_end_point = "https://ik.imagekit.io/v4u5l9d7p";
        $sample_file_path = "/sample.jpg";
        
        // créer un formulaire pour ajouter une image avec imagekit.io
        
        if ($entity == "App\\Entity\\Picture") {
            if ($id) {
                $picture = $pictureRepository->find($id);
            } else {
                $picture = new Picture();
            }
        } else if ($entity == "App\\Entity\\Place") {
            $place = $placeRepository->find($id);
            dd($place);
        }
        
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('upload')->getData();
            
            if ($imageFile) {
                
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                
                try {
                    $imageFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                
                $imageKit = new ImageKit(
                    $public_key,
                    $your_private_key,
                    $url_end_point
                );
                
                $imageUrl = $imageKit->url([
                    'path' => '/'.$newFilename
                ]);
                
                $uploadFile = $imageKit->uploadFile([
                    "file" => fopen($this->getParameter('brochures_directory')."/".$newFilename, "r"),
                    "fileName" => $newFilename,
                ]);
                
                $url = json_decode(json_encode($uploadFile), true)['result']['url'];
                
                $picture->setUrl($url);
                $manager->persist($picture);
                $manager->flush();

                $filesystem = new Filesystem();
                $filesystem->remove($this->getParameter('brochures_directory').'/'.$newFilename);

                return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);

            }


        }
        
        return $this->renderForm('api/picture/index.html.twig', [
            'form' => $form,
        ]);
    }
}
