<?php

namespace App\Serializer;

use App\Entity\Category;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CategoryNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($category, string $format = null, array $context = [])
    {
        $data = [];
        $data['id'] = $category->getId();
        $data['name'] = $category->getName();
        $data['icon'] = $category->getIcon();
        // dd($data);
        return $data;

    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if($data instanceof Category) {
            return true;
        }

        return false;
    }
}