<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $ajaxData = [
        'success' => false,
        'message' => '',
        'data' => ''
    ];

    public function respondWithMessage($status, $message)
    {
        if (!in_array($status, ['danger', 'warning', 'success', 'info', 'status'])) {
            throw new \Exception('status 参数不正确');
        }

        session()->flash($status, $message);
        return redirect('/');
    }


    public function respondInAjax()
    {
        return json_encode($this->ajaxData);
    }
}
