<?php

namespace App\Http\Controllers;

use App\city;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    private $cname = "CityController";
    public function index()
    {
        $tbl = city::with('')->get();

        return response()->json($tbl);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            $data = city::create($request->all());
            \Logger::instance()->log(
                Carbon::now(),
                $request->user_id,
                $request->user_name,
                $this->cname,
                "store",
                "message",
                "Create new city: " . $data
            );
            return $this->index();
        } catch (\Exception $ex) {
            \Logger::instance()->logError(
                Carbon::now(),
                $request->user_id,
                $request->user_name,
                $this->cname,
                "store",
                "Error",
                $ex->getMessage()
            );
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $tbl = city::where("id", $id)->get();

        return response()->json($tbl);
    }

    public function fetch_by_province($province_id)
    {
        $tbl = city::where("province_id", $province_id)->get();
        return response()->json($tbl);
    }

    public function edit(city $city)
    {
        //
    }

    public function update(Request $request, $id)
    {
        try {

            $cmd  = city::findOrFail($id);
            $logFrom = $cmd->replicate();
            $input = $request->all();

            $cmd->fill($input)->save();
            $logTo = $cmd;

            \Logger::instance()->log(
                Carbon::now(),
                $request->user_id,
                $request->user_name,
                $this->cname,
                "update",
                "message",
                "update city id " . $id . "\nFrom: " . $logFrom . "\nTo: " . $logTo
            );
            return $this->index();
        } catch (\Exception $ex) {
            \Logger::instance()->logError(
                Carbon::now(),
                $request->user_id,
                $request->user_name,
                $this->cname,
                "update",
                "Error",
                $ex->getMessage()
            );
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $tbl1 = city::findOrFail($id);
            city::destroy($id);

            \Logger::instance()->log(
                Carbon::now(),
                "",
                "",
                $this->cname,
                "destroy",
                "message",
                "delete city id " . $id .
                    "\nOld city: " . $tbl1
            );


            return $this->index();
        } catch (\Exception $ex) {
            \Logger::instance()->log(
                Carbon::now(),
                "",
                "",
                $this->cname,
                "destroy",
                "Error",
                $ex->getMessage()
            );
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
}
