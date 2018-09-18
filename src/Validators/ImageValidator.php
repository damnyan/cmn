<?php

namespace Damnyan\Cmn\Validators;

use GuzzleHttp\Client;

class ImageValidator
{

    /**
     * UploadCare image validator
     *
     * @param array                            $attribute  attribute
     * @param string|int                       $value      value from request
     * @param string                           $parameters parameters
     * @param \Illuminate\Validation\Validator $validator  validator
     * @return void
     */
    public function ucImage($attribute, $value, $parameters, $validator)
    {
        $isFromUCare = (strpos($value, 'https://ucarecdn.com/') === 0);

        if (!$isFromUCare) {
            return false;
        }

        $client = new Client;
        try {
            $image       = $client->get($value);
            $contentType = $image->getHeaders()['Content-Type'][0];
            $isImage     = (strpos($contentType, 'image/') === 0);

            if (!$isImage) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
