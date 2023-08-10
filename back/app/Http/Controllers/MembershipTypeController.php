<?php

namespace App\Http\Controllers;

use App\membership_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use stdClass;

class MembershipTypeController extends Controller
{
    private $cname = "MembershipTypeController";
    public function index()
    {
        $tbl = membership_type::all();

        return response()->json($tbl);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        try {
            // return $request;
            $data = membership_type::create($request->all());

            \Logger::instance()->log(
                Carbon::now(),
                $request->user_id,
                $this->cname,
                "store",
                "message",
                "Create new membership_type: " . $data
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
        $tbl = membership_type::where("id", $id)->get();

        return response()->json($tbl);
    }
    public function edit(membership_type $membership_type)
    {
        //
    }
    public function update(Request $request, $id)
    {
        try {
            $cmd  = membership_type::findOrFail($id);
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
                "update membership_type id " . $id . "\r\nFrom: " . $logFrom . "\r\nTo: " . $logTo
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
            $tbl1 = membership_type::findOrFail($id);
            membership_type::destroy($id);

            \Logger::instance()->log(
                Carbon::now(),
                "",
                "",
                $this->cname,
                "destroy",
                "message",
                "delete membership_type id " . $id .
                    "\nOld membership_type: " . $tbl1
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
