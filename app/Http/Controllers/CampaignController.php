<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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
                'name'         => 'required',
                'date_from'    => 'required|date',
                'date_to'      => 'required|date',
                'total_budget' => 'required|numeric',
                'daily_budget' => 'required|numeric',
                'creatives.*'  => 'required|mimes:jpg,jpeg,png,bmp|max:20000'
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

        $now = Carbon::now();
        $date_from = Carbon::parse($request->input('date_from'));
        $date_to = Carbon::parse($request->input('date_to'));

        if ($date_from && ($date_from > $now)) {
            return response()->json([
                'error' => 'The start date cannot be past the current time',
                'message' => 'invalid_input',
            ], 400);
        }

        $campaign = Campaign::create([
            'name'         => trim($request->input('name')),
            'date_from'    => $date_from,
            'date_to'      => $date_to,
            'total_budget' => $request->input('total_budget'),
            'daily_budget' => $request->input('daily_budget'),
        ]);

        return response()->json([
            'success' => true,
            'campaign' => $campaign->id
        ]);
    }
}
