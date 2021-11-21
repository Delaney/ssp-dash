<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        return Campaign::all();
    }

    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name'             => 'required',
                'date_from'     => 'required',
                'date_to'          => 'required',
                'total_budget'      => 'required|numeric',
                'daily_budget'      => 'required|numeric',
                'creatives.*'      => 'required|mimes:jpg,jpeg,png,bmp|max:20000'
            ],
            [
                'creatives.*.required' => 'Please upload an image',
                'creatives.*.mimes' => 'Only jpeg,png and bmp images are allowed',
                'creatives.*.max' => 'Sorry! Maximum allowed size for an image is 20MB',
            ]
        );

        if ($validator->fails())
            return response()->json([
                'error' => $validator->errors()->first(),
                'message' => 'invalid_input',
            ], 400);
    }
}
