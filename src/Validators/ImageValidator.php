<?php

namespace Damnyan\Cmn\Validators;

use GuzzleHttp\Client;

class ImageValidator
{
    public function ucImage($attribute, $value, $parameters, $validator)
    {
        $isFromUCare = (strpos($value, 'https://ucarecdn.com/') === 0);

        if (!$isFromUCare) {
            return false;
        }

        $client = new Client;
        try {
            $image = $client->get($value);
            $contentType = $image->getHeaders()['Content-Type'][0];
            $isImage = (strpos($contentType, 'image/') === 0);
            if (!$isImage) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
