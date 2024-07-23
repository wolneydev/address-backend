<?php

namespace App\Http\Responses;

class ResponseClass
{
    protected $status;
    protected $message;
    protected $data;
    protected $totalCount;

    protected function __construct()
    {
        //fluent builder pattern
    }

    public static function create()
    {
        return new self();
    }

    public function status($status)
    {
        $this->status = $status;
        return $this;
    }

    public function message($message)
    {
        $this->message = $message;
        return $this;
    }

    public function data($data)
    {    
        $this->data = $data;
        return $this;
    }

    public function totalCount($totalCount)
    {
        $this->totalCount = $totalCount;
        return $this;
    }

    public function build()
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
