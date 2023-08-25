<?php

namespace App\Serializer;

use App\Entity\Century;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class CenturyNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($century, string $format = null, array $context = [])
    {
        $data = [];
        $data['id'] = $century->getId();
        $data['century'] = $century->getCentury();
        $data['period'] = $century->getPeriod();
        // dd($data);
        return $data;

    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        if($data instanceof Century) {
            return true;
        }

        return false;
    }
}