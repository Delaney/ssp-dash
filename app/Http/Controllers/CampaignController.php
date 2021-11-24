<?php

namespace App\Http\Controllers;

use App\Models\{
    Campaign,
    CampaignCreative
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    DB,
    Validator
};
use Illuminate\Support\Str;
use Carbon\Carbon;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaigns = Campaign::with('creatives')
            ->get()
            ->each(function ($creative) {
                $creative->creatives->map(function ($image) {
                    $link = strpos('http', $image->upload_path) === false ?
                        $image->upload_path :
                        getenv('APP_URL') . '/' . $image->upload_path;
                    $image->link = $link;
                });
            });
        return $campaigns;
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
                'creatives'    => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => 'invalid_input',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $now = Carbon::now();
        $date_from = Carbon::parse($request->input('date_from'));
        $date_to = Carbon::parse($request->input('date_to'));

        $from_formatted = $date_from->format('Y-m-d');
        $now_formatted = $date_from->format('Y-m-d');

        if ($date_from && ($from_formatted != $now_formatted) && ($date_from < $now)) {
            return response()->json([
                'error' => 'invalid_input',
                'message' => 'The start date cannot be before the current time',
            ], 400);
        }

        DB::beginTransaction();

        $campaign = Campaign::create([
            'name'         => trim($request->input('name')),
            'date_from'    => $date_from,
            'date_to'      => $date_to,
            'total_budget' => $request->input('total_budget'),
            'daily_budget' => $request->input('daily_budget'),
        ]);

        $creatives = $request->file('creatives');

        foreach ($creatives as $file) {
            if ((in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))) {
                $name = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $fileName = Str::of($name)->basename('.' . $file->getClientOriginalExtension());

                $creative              = new CampaignCreative;
                $creative->campaign_id = $campaign->id;
                $creative->filename    = $fileName;
                $creative->upload_path = 'storage/' . $file->storeAs('creatives', $name, 'public');
                $creative->extension   = $file->getClientOriginalExtension();

                $creative->save();
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'campaign' => $campaign->id
        ]);
    }

    public function get($id)
    {
        $campaign = Campaign::find($id);
        if (!$campaign) {
            return response()->json([
                'error' => 'invalid_input',
                'message' => 'Campaign does not exist',
            ], 404);
        }
        return $campaign;
    }

    public function edit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id'           => 'required|exists:campaigns',
                'name'         => 'required',
                'date_from'    => 'required|date',
                'date_to'      => 'required|date',
                'total_budget' => 'required|numeric',
                'daily_budget' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => 'invalid_input',
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $now = Carbon::now();
        $date_from = Carbon::parse($request->input('date_from'));
        $date_to = Carbon::parse($request->input('date_to'));

        $from_formatted = $date_from->format('Y-m-d');
        $now_formatted = $date_from->format('Y-m-d');

        if ($date_from && ($from_formatted != $now_formatted) && ($date_from < $now)) {
            return response()->json([
                'error' => 'invalid_input',
                'message' => 'The start date cannot be before the current time',
            ], 400);
        }

        Campaign::find($request->input('id'))
            ->update([
                'name'         => trim($request->input('name')),
                'date_from'    => $date_from,
                'date_to'      => $date_to,
                'total_budget' => $request->input('total_budget'),
                'daily_budget' => $request->input('daily_budget'),
            ]);

        return response()->json([
            'success' => true
        ]);
    }
}
