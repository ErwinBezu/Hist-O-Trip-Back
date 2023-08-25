<?php

namespace App\Serializer;

use App\Entity\Picture;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class UserNormalizer implements ContextAwareNormalizerInterface
{
    public function normalize($user, string $format = null, array $context = [])
    {
        $data = [];
        $data['id'] = $user->getId();
        $data['email'] = $user->getEmail();
        $data['lastname'] = $user->getLastname();
        $data['firstname'] = $user->getFirstname();
        $data['pseudonym'] = $user->getPseudonym();
        $data['avatar'] = $user->getAvatar();
        $data['isActive'] = $user->getIsActive();
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