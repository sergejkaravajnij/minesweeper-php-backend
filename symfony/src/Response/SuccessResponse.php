<?php

namespace App\Response;


/**
 * Class SuccessResponse
 *
 * @package App\Response
 */
class SuccessResponse
{
    /**
     * @var string
     */
    public $status = 'success';

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var string
     */
    public $message = 'OK';

    /**
     * @param array $data
     */
    public function setData($data) {
        $this->data = $data;
    }

}