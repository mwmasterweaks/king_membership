<?php

namespace App\Http\Controllers;

use App\branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use stdClass;


class BranchController extends Controller
{
    private $cname = "BranchController";
    public function index()
    {
        $tbl = branch::all();

        return response()->json($tbl);
    }

    public function getCountries()
    {
        $tbl = DB::table('countries')->get();
        return $tbl;
    }
    public function getCities()
    {
        $tbl = DB::table('cities')->get();
        return $tbl;
    }
    public function getBarangays()
    {
        $tbl = DB::table('barangays')->get();
        return $tbl;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
            // return $request;
            $data = branch::create($request->all());

            \Logger::instance()->log(
                Carbon::now(),
                $request->user_id,
                $this->cname,
                "store",
                "message",
                "Create new Branch: " . $data
            );

            return $this->index();
        } catch (\Exception $ex) {
            \Logger::instance()->logError(
                Carbon::now(),
                $request->user_id,
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
        $tbl = branch::where("id", $id)->get();

        return response()->json($tbl);
    }


    public function edit(branch $branch)
    {
        //
    }


    public function UpdateBranch(Request $request)
    {
        try {

            $id = $request->id;
            $cmd  = branch::findOrFail($id);
            $logFrom = $cmd->replicate();
            $input = $request->all();

            $cmd->fill($input)->save();

            $logTo = $cmd;

            \Logger::instance()->log(
                Carbon::now(),
                $request->user_id,
                $this->cname,
                "update",
                "message",
                "update Branch id " . $id . "\r\nFrom: " . $logFrom . "\r\nTo: " . $logTo
            );

            return $this->index();
        } catch (\Exception $ex) {
            \Logger::instance()->logError(
                Carbon::now(),
                $request->user_id,
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
            $tbl1 = branch::findOrFail($id);
            branch::destroy($id);

            \Logger::instance()->log(
                Carbon::now(),
                "",
                "",
                $this->cname,
                "destroy",
                "message",
                "delete Branch id " . $id .
                    "\nOld Branch: " . $tbl1
            );

            return $this->index();
        } catch (\Exception $ex) {
            \Logger::instance()->logError(
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
