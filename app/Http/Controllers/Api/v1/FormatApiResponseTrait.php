<?php

trait FormatApiResponseTrait {

    /**
     * @param int $statusCode
     * @param bool $error
     * @param $response
     * @param $errors
     * @return array
     */
    public function format($statusCode = 200, $error = false, $response, $errors)
    {

        $api_response = [
          'error' => $error,
          'response' => $response
        ];

        if (count($errors) > 0) {
            $api_response['errors'] = $errors;
        }

        return $api_response;
    }
}