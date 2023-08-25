<?php

namespace App\Serializer;

use App\Entity\Tag;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class TagNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($tag, string $format = null, array $context = [])
    {
        $data = [];
        $data['id'] = $tag->getId();
        $data['name'] = $tag->getName();
        // dd($data);
        return $data;

    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if($data instanceof Tag) {
            return true;
        }

        return false;
    }
}