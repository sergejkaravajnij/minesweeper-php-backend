<?php

namespace App\Response;


/**
 * Class ErrorResponse
 *
 * @package App\Response
 */
class ErrorResponse
{
    /**
     * @var string
     */
    public $status = 'error';

    /**
     * @var array
     */
    public $data = [];

    /**
     * @var string
     */
    public $message = '';

    /**
     * @param string $message
     */
    public function setMessage($message) {
        $this->message = $message;
    }

}