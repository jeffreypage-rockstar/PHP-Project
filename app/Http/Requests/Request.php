<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {


    /**
     * @param int $statusCode
     * @param bool $error
     * @param $response
     * @param $errors
     * @return array
     */
    public function formatResponse($response, $error = false, $statusCode = 200, $errors = [])
    {

        $api_response = [
            'error' => $error,
            'response' => $response
        ];

        if (count($errors) > 0) {
            $api_response['errors'] = $errors;
        }

        // Since this is an error response log the error.
        if ($error) {
            $callers=debug_backtrace();
            \Log::error("Error occurred in ".$callers[0]['file']. " in line : ".$callers[0]['line']);
        }

        return \Response::make($api_response, $statusCode);
    }

    public function forbiddenResponse()
    {
        $template = [
            'error' => true,
            'response' => 'Permission denied !'
        ];
        return \Response::make($template, 403);
    }

    public function response(array $errors)
    {

        return $this->formatResponse($this->formatErrors($this->getValidatorInstance()), true, 400);

    }
}
