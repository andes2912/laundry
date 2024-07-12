<?php

namespace App\Helpers;

/**
 * Trait ResponderHelper
 *
 * @package App\Helpers
 */
trait ClientResponderHelper
{
    /**
     * Default response application
     *
     * @param bool $status
     * @param int $code
     * @param string $message
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function response(bool $status, int $code, string $message, $data = null, $other = [])
    {
        return response()
            ->json(
                collect(
                    [
                        'status' => $status,
                        'code' => $code,
                        'text' => config('code.' . $code),
                        'message' => $message,
                        'data' => $data
                    ]
                )->merge($other),
                $code
            );
    }

    protected function responsePaginate(int $code = 200, string $message, $data = null, $other = [])
    {
        $content = [
            'data' => $data,
            'current_page' => $data->currentPage(),
            'first_item' => $data->firstItem(),
            'last_item' => $data->lastItem(),
            "per_page" => $data->perPage(),
            'last_page' => $data->lastPage(),
            "total" => $data->total(),
        ];

        return response()
            ->json(
                collect(
                    [
                        'status' => true,
                        'code' => $code,
                        'text' => config('code.' . $code),
                        'message' => $message,
                        'data' => $content
                    ]
                )->merge($other),
                $code
            );
    }

    /**
     * Response Success
     *
     * @param String $message Message
     * @param String $data    Data
     *
     * @return json
     */
    public function responseSuccess($code = 200, $message = 'Success', $data = null, $other = [])
    {
        return $this->response(true, $code, $message, $data, $other);
    }

    /**
     * Response Failed
     *
     * @param String $message Message
     * @param Int    $code    Code
     * @param String $data    Data
     *
     * @return json
     */
    public function responseFailed($message, $code = 500, $data = null)
    {
        $result = $this->messageResponseFailed($message, $code);
        $code = $result['code'];
        $msg = $result['message'];

        return $this->response(false, 500, $msg, $data);
    }

    /**
     * Get Message Response Failed
     *
     * @param String $message Message
     * @param Int $code    Code
     *
     * @return json
     */
    public function messageResponseFailed($message, $code = 500)
    {
        $code = $code <= 0 && gettype($code) == 'integer' ? 500 : $code;
        $msg = $message == "" ? 'Something went wrong' : $message;
        $data = null;

        if (gettype(json_decode($message)) == 'object') {
            $objectMsg = json_decode($message);
            if (isset($objectMsg->message)) {
                $msg = $objectMsg->message ? $objectMsg->message : 'Something went wrong';
                if (property_exists($objectMsg, 'code')) {
                    $code = $objectMsg->code > 0 ? $objectMsg->code : $code;
                }
                if (property_exists($objectMsg, 'data')) {
                    $data = gettype($objectMsg->data) == 'object' ? $objectMsg->data : $data;
                }
            } else if (isset($objectMsg->errors)) {
                if (gettype($objectMsg->errors) == 'array') {
                    if (gettype(collect($objectMsg->errors)->first()) != 'array') {
                        $msg = collect($objectMsg->errors)->first();
                    } else if (count(collect($objectMsg->errors)->first()) > 0) {
                        $msg = collect($objectMsg->errors)->first()[0];
                    }
                } else {
                    $msg = $objectMsg->errors ? $objectMsg->errors : 'Something went wrong';
                }
            } else {
                $msg = 'Something went wrong';
            }
        }

        return [
            'code' => $code,
            'message' => $msg,
            'data' => $data
        ];
    }
}
