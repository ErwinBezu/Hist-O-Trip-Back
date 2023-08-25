<?php

namespace App\Serializer;

use App\Entity\Picture;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class PictureNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($picture, string $format = null, array $context = [])
    {
        $data = [];
        $data['id'] = $picture->getId();
        $data['name'] = $picture->getName();
        $data['picture_legend'] = $picture->getPictureLegend();
        $data['url'] = $picture->getUrl();
        $data['is_main'] = $picture->getIsMain();
        // dd($data);
        return $data;

    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if($data instanceof Picture) {
            return true;
        }

        return false;
    }
}