<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Pagination\Paginator;

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

        if (isset($response['paginator_data'])) {
            $api_response['response'] = $response['paginator_data'];
        }

        if (isset($response['paginator'])) {
            $api_response['paginator'] = $response['paginator'];
        }

        // Since this is an error response log the error.
        if ($error) {
            $callers=debug_backtrace();
            \Log::error("Error occurred in ".$callers[0]['file']. " in line : ".$callers[0]['line']);
        }

        return \Response::make($api_response, $statusCode);
    }

    /**
     * @return mixed
     */
    public function forbiddenResponse()
    {
        $template = [
            'error' => true,
            'response' => 'Permission denied !'
        ];
        return \Response::make($template, 403);
    }

    /**
     * @param array $errors
     * @return array
     */
    public function response(array $errors)
    {
        return $this->formatResponse($this->formatErrors($this->getValidatorInstance()), true, 400);

    }

    /**
     * @param $model
     * @return mixed
     */
    public function loadRelatedModels($model)
    {
        $request = $this->request->all();
        // Why using the Input facade , when the content type header is json the request object will not see the query
        // string params. But its available as Input param (trough $_GET )
        if (isset($request['with']) || \Input::has('with')) {
            return $model->with(explode(',', \Input::get('with')));

        }

        return $model;
    }

    /**
     * @param $model
     * @return mixed
     */
    public function paginateResponse($model)
    {
        $request = $this->request->all();
        $page = (isset($request['page'])) ? $request['page']: 1;
        $limit = (isset($request['limit'])) ? $request['limit']: 20;

        $skip = ($page-1 < 1) ? $limit: $page*$limit;

        $paginator = $model->paginate($limit);

        $pager = [
            'per_page' => (int) $paginator->perPage(),
            'current_page' => $paginator->currentPage(),
            'next_page' => ($paginator->hasMorePages())?($paginator->currentPage() + 1): null,
            'prev_page' => ($paginator->currentPage() - 1) < 1 ? null : ($paginator->currentPage() - 1),
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem()
        ];

        $items['paginator_data'] = $paginator->items();
        $items['paginator'] = $pager;

        return $items;

    }
}
