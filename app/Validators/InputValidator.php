<?php

namespace App\Validators;

use App\Service;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InputValidator
{

    public $errors;
    public $request;

    public function __construct(Request $request)
    {
        $this->errors  = [];
        $this->request  = $request;
    }

    public function validate($edit_mode = false)
    {

        $validator_array = [
            'name'         => 'required',
            'date_from'    => 'required|date',
            'date_to'      => 'required|date',
            'total_budget' => 'required|numeric',
            'daily_budget' => 'required|numeric'
        ];

        if (!$edit_mode) {
            $validator_array = array_merge($validator_array, [
                'id'        => 'exists:campaigns',
                'creatives' => 'required'
            ]);
        }

        return Validator::make($this->request->all(), $validator_array);
    }
}
