<?php

namespace App\Http\Controllers;

use App\member;
use App\branch;
use App\member_detail;
use App\member_reference;
use App\member_valid_id;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use stdClass;


class MemberController extends Controller
{

    private $cname = "MemberController";
    private $mainComand;

    public function __construct()
    {
        $this->mainComand = member::with(['branch', 'member_details',  'member_reference', 'member_valid']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tbl = (clone $this->mainComand)
                ->get();


            return response()->json($tbl);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function subIndex($branch_id)
    {
        // return $branch_id;
        try {


            if ($branch_id == 0) {
                $tbl = (clone $this->mainComand)
                    ->where('application_status', '=', 'Pending')
                    ->orderBy("created_at", "desc")
                    ->get();
            } else {
                $tbl = (clone $this->mainComand)
                    ->where('application_status', '=', 'Pending')
                    ->where("branch_id", $branch_id)
                    ->orderBy("created_at", "desc")
                    ->get();
            }

            return response()->json($tbl);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function getApprove($branch_id)
    {
        try {


            if ($branch_id == 0) {
                $tbl = (clone $this->mainComand)
                    ->where('application_status', 'Approved')
                    ->orderBy("created_at", "desc")
                    ->get();
            } else {
                $tbl = (clone $this->mainComand)
                    ->where('application_status', 'Approved')
                    ->where("branch_id", $branch_id)
                    ->orderBy("created_at", "desc")
                    ->get();
            }
            return response()->json($tbl);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }


    public function getRejected($branch_id)
    {
        try {

            if ($branch_id == 0) {
                $tbl = (clone $this->mainComand)
                    ->where('application_status', 'Rejected')
                    ->orderBy("created_at", "desc")
                    ->get();
            } else {
                $tbl = (clone $this->mainComand)
                    ->where('application_status', 'Rejected')
                    ->where("branch_id", $branch_id)
                    ->orderBy("created_at", "desc")
                    ->get();
            }
            return response()->json($tbl);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    public function getPending($branch_id)
    {
        try {
            $tbl = (clone $this->mainComand)->where('application_status', 'Pending')->get();
            if ($branch_id == 0) {
                $tbl = (clone $this->mainComand)
                    ->where('application_status', 'Pending')
                    ->orderBy("created_at", "desc")
                    ->get();
            } else {
                $tbl = (clone $this->mainComand)
                    ->where('application_status', 'Pending')
                    ->where("branch_id", $branch_id)
                    ->orderBy("created_at", "desc")
                    ->get();
            }

            return response()->json($tbl);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly cr
     eated resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        try {
            //set_time_limit(0);
            //DB::beginTransaction();
            $income_source = implode(",", $request->income_source);

            $image1_fileName = "";
            $image2_fileName = "";
            $image3_fileName = "";
            $image4_fileName = "";
            $image5_fileName = "";

            // check images
            if (empty($request->picture_text)) {
                return response()->json(['error' => 'Please upload required images!'], 505);
            } elseif (empty($request->valid_id_1_text) && empty($request->valid_id_2_text)) {
                return response()->json(['error' => 'Please upload required images!'], 505);
            } elseif (empty($request->sketch_text)) {
                return response()->json(['error' => 'Please upload required images!'], 505);
            } elseif (empty($request->sketch2_text)) {
                return response()->json(['error' => 'Please upload required images!'], 505);
            } else {
                if (!empty($request->valid_id_1_text)) {
                    $exploded2 = explode(',', $request->valid_id_1);
                    $decoded2 = base64_decode($exploded2[1]);
                    $image2_fileName = str_random() . rand(100000, 999999) . "." . $request->valid_id_1_text;

                    $path2 = public_path() . "/attachments/" . $image2_fileName;
                    file_put_contents($path2, $decoded2);
                }
                if (!empty($request->valid_id_2_text)) {

                    $exploded3 = explode(',', $request->valid_id_2);
                    $decoded3 = base64_decode($exploded3[1]);
                    $image3_fileName = str_random() . rand(100000, 999999) . "." . $request->valid_id_2_text;

                    $path3 = public_path() . "/attachments/" . $image3_fileName;
                    file_put_contents($path3, $decoded3);
                }

                $exploded1 = explode(',', $request->picture);
                // $exploded2 = explode(',', $request->valid_id_1);
                // $exploded3 = explode(',', $request->valid_id_2);
                $exploded4 = explode(',', $request->sketch);
                $exploded5 = explode(',', $request->sketch2);

                $decoded1 = base64_decode($exploded1[1]);
                // $decoded2 = base64_decode($exploded2[1]);
                // $decoded3 = base64_decode($exploded3[1]);
                $decoded4 = base64_decode($exploded4[1]);
                $decoded5 = base64_decode($exploded5[1]);



                $image1_fileName = str_random() . rand(100000, 999999) . "." . $request->picture_text;
                // $image2_fileName = str_random() . rand(100000, 999999) . "." . $request->valid_id_1_text;
                // $image3_fileName = str_random() . rand(100000, 999999) . "." . $request->valid_id_2_text;
                $image4_fileName = str_random() . rand(100000, 999999) . "." . $request->sketch_text;
                $image5_fileName = str_random() . rand(100000, 999999) . "." . $request->sketch2_text;

                $path1 = public_path() . "/attachments/" . $image1_fileName;
                // $path2 = public_path() . "/attachments/" . $image2_fileName;
                // $path3 = public_path() . "/attachments/" . $image3_fileName;
                $path4 = public_path() . "/attachments/" . $image4_fileName;
                $path5 = public_path() . "/attachments/" . $image5_fileName;

                file_put_contents($path1, $decoded1);
                // file_put_contents($path2, $decoded2);
                // file_put_contents($path3, $decoded3);
                file_put_contents($path4, $decoded4);
                file_put_contents($path5, $decoded5);

                $acc_no = random_int(1000000, 9999999);

                $data = member::create($request->except(['acc_no', 'image', 'image_id_1', 'image_id_2', 'image_sketch', 'image_sketch_2']) + (["acc_no" => $acc_no, "image" => $image1_fileName, "image_id_1" => $image2_fileName, "image_id_2" => $image3_fileName, "image_sketch" => $image4_fileName, "image_sketch_2" => $image5_fileName]));

                $filenameDate = date("Ym");
                $fh = fopen("logs/application$filenameDate.log", 'a') or exit();
                fwrite($fh, "\r\n------\r\n" .  date('Y-m-d H:i ') .  " done create member");
                fclose($fh);

                member_detail::create($request->except(['member_id', 'income_source']) + (["member_id" => $data->id, "income_source" => $income_source]));
                member_valid_id::create($request->except('member_id') + ["member_id" => $data->id]);
                member_reference::create($request->except('member_id') + ["member_id" => $data->id]);

                // save user

                $member_pass = "123456789";
                DB::table('users')->insert([
                    [
                        'member_id' => $acc_no,
                        'email' => $acc_no,
                        'password' => bcrypt("123456789"),
                        'remember_token' => str_random(10),
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]
                ]);

                $branch = branch::where("id", $request->branch_id)->first();
                // NOTIFICATIONS
                $subject = "Online Membership Application";
                $recipient = $request->first_name . ' ' . $request->mid_name . ' ' .  $request->last_name;
                $sendTo = $request->email;

                $sender = "ONLINE MEMBERSHIP APPLICATION";
                $senderName = "King Multipurpose Cooperative";
                $fh = fopen("logs/application$filenameDate.log", 'a') or exit();
                fwrite($fh, "\r\ndone select branch");
                fclose($fh);

                $msg = "
                   <html>
                    <head>
                    </head>
                    <body style=' font-family:  Helvetica, Arial, sans-serif;font-size:12px'>
                    <p>Dear Ma'am/Sir,</p>
                    <p>Good day! You have successfully submitted your online application. We will review your application and get back to you
                    as soon as possible.</p>
                    <p>Thank you!</p>
                    <br/>
                    <br/>

                    </body>
                    </html>";
                if ($request->email_switch == true) {
                    $mailReturn = \Logger::instance()->mailerGmail(
                        $subject,
                        $msg,
                        $sender,
                        $senderName,
                        $sendTo,
                        $recipient,
                        $branch->email
                    );

                    $fh = fopen("logs/application$filenameDate.log", 'a') or exit();
                    fwrite($fh, "\r\nMain return return: $mailReturn");
                    fclose($fh);
                }

                if ($request->sms_switch == true) {

                    $number = $request->contact_no;
                    $message = "Good day! You have successfully submitted your online application. We will review your application and get back to you
                    as soon as possible.";
                    // SMS
                    $textreturn = \Logger::instance()->send_text(
                        $number,
                        $message
                    );
                    $fh = fopen("logs/application$filenameDate.log", 'a') or exit();
                    fwrite($fh, "\r\nSMS(applicant) return: $textreturn");
                    fclose($fh);
                    $admin_number = $branch->contact; //'09231006125';
                    $admin_message = "New Application has been submitted: \r\n \n\r\n
                        Applicant Name : " . $recipient . ". \r\n \r\n
                        Username:  " . $acc_no .  ". \r\n \r\n
                        Password: 123456789";

                    // SMS FOR ADMIN
                    $textreturn1 = \Logger::instance()->send_text(
                        $admin_number,
                        $admin_message
                    );
                    $fh = fopen("logs/application$filenameDate.log", 'a') or exit();
                    fwrite($fh, "\r\nSMS(admin) return: $textreturn1");
                    fclose($fh);
                }
                //DB::commit();
                $fh = fopen("logs/application$filenameDate.log", 'a') or exit();
                fwrite($fh, "\r\nbefore return");
                fclose($fh);
                return 'succcess!';
            }

            // return $this->index();
        } catch (\Exception $ex) {
            //DB::rollBack();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $id;
        $tbl = (clone $this->mainComand)->find($id);
        $member = (object)$tbl;
        $member_details = (object)$tbl->member_details;
        $member_valid = (object)$tbl->member_valid;
        $member_reference = (object)$tbl->member_reference;

        $collection = collect($member);
        $merged     = $collection->merge($member_details)->merge($member_valid)->merge($member_reference);
        $result = $merged->all();

        return response()->json($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function UpdateMember(Request $request)
    {
        $id = $request->id;

        try {

            // return $request;

            $image1_fileName = "";
            $image2_fileName = "";
            $image3_fileName = "";
            $image4_fileName = "";
            $image5_fileName = "";
            if (!empty($request->picture)) {
                $exploded1 = explode(',', $request->picture);
                $decoded1 = base64_decode($exploded1[1]);
                $image1_fileName = str_random() . rand(100000, 999999) . "." . $request->picture_text;
                $path1 = public_path() . "/attachments/" . $image1_fileName;
                file_put_contents($path1, $decoded1);

                $member_update = $request->except('image') + ["image" => $image1_fileName];
            } elseif (!empty($request->valid_id_1)) {
                $exploded2 = explode(',', $request->valid_id_1);
                $decoded2 = base64_decode($exploded2[1]);
                $image2_fileName = str_random() . rand(100000, 999999) . "." . $request->valid_id_1_text;
                $path2 = public_path() . "/attachments/" . $image2_fileName;
                file_put_contents($path2, $decoded2);

                $member_update = $request->except('image_id_1') + ["image_id_1" => $image2_fileName];
            } elseif (!empty($request->valid_id_2)) {
                $exploded3 = explode(',', $request->valid_id_2);
                $decoded3 = base64_decode($exploded3[1]);
                $image3_fileName = str_random() . rand(100000, 999999) . "." . $request->valid_id_2_text;
                $path3 = public_path() . "/attachments/" . $image3_fileName;
                file_put_contents($path3, $decoded3);

                $member_update = $request->except('image_id_2') + ["image_id_2" => $image3_fileName];
            } elseif (!empty($request->sketch)) {
                $exploded4 = explode(',', $request->sketch);
                $decoded4 = base64_decode($exploded4[1]);
                $image4_fileName = str_random() . rand(100000, 999999) . "." . $request->sketch_text;
                $path4 = public_path() . "/attachments/" . $image4_fileName;
                file_put_contents($path4, $decoded4);

                $member_update = $request->except('image_sketch') + ["image_sketch" => $image4_fileName];
            } elseif (!empty($request->sketch2)) {
                $exploded5 = explode(',', $request->sketch2);
                $decoded5 = base64_decode($exploded5[1]);
                $image5_fileName = str_random() . rand(100000, 999999) . "." . $request->sketch2_text;
                $path5 = public_path() . "/attachments/" . $image5_fileName;
                file_put_contents($path5, $decoded5);

                $member_update = $request->except('image_sketch_2') + ["image_sketch_2" => $image5_fileName];
            } else {
                $member_update = $request->all();
            }

            $member  = member::findOrFail($id);
            $member_details  = member_detail::where('member_id', $id)->first();
            $member_valid_id  = member_valid_id::where('member_id', $id)->first();
            $member_reference  = member_reference::where('member_id', $id)->first();
            // unset($member_details->income_source);
            // $member_details->income_source = $income_source;

            $member_details_attributes = array_keys($member_details->getOriginal());
            $member_valid_id_attributes = array_keys($member_valid_id->getOriginal());
            $member_reference_attributes = array_keys($member_reference->getOriginal());


            $member_details_update = request($member_details_attributes);
            $member_valid_update = request($member_valid_id_attributes);
            $member_reference_update = request($member_reference_attributes);

            $member->fill($member_update)->save();
            $member_details->fill($member_details_update)->save();
            $member_valid_id->fill($member_valid_update)->save();
            $member_reference->fill($member_reference_update)->save();


            return "updated!";
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            member::destroy($id);
            member_detail::where('member_id', $id)->delete();
            member_valid_id::where('member_id', $id)->delete();
            member_reference::where('member_id', $id)->delete();

            return "deleted!";
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function counter($branch_id)
    {


        if ($branch_id == 0) {
            $pending = member::where('application_status', '=', 'Pending')->count();
            $approved = member::where('application_status', '=', 'Approved')->count();
            $rejected = member::where('application_status', '=', 'Rejected')->count();
        } else {
            $pending = member::where('application_status', '=', 'Pending')->where("branch_id", $branch_id)->count();
            $approved = member::where('application_status', '=', 'Approved')->where("branch_id", $branch_id)->count();
            $rejected = member::where('application_status', '=', 'Rejected')->where("branch_id", $branch_id)->count();
        }


        $ret = collect();
        $ret->put("pending", $pending);
        $ret->put("approved", $approved);
        $ret->put("rejected", $rejected);

        return response()->json($ret);
    }

    public function approve(Request $request)
    {

        $data = $request;
        DB::table('members')
            ->where('id', $data->id)
            ->update([
                'application_status' => "Approved",
                'membership_status'  => "Active",
                'enrollment_date' => $data->enrollment_date,
                'updated_at' => \Carbon\Carbon::now()
            ]);

        $request = member::where('id', $data->id)->first();

        $subject = "Online Membership Application";
        $recipient = $request->first_name . ' ' . $request->mid_name . ' ' .  $request->last_name;
        $sendTo = $request->email;

        $sender = "ONLINE MEMBERSHIP APPLICATION";
        $senderName = "King Multipurpose Cooperative";

        $number = $request->contact_no;
        $message = "Good day! We're pleased to inform you that your application has been approved. Thank you!";

        $msg = "
            <html>
            <head>
            </head>
            <body style=' font-family:  Helvetica, Arial, sans-serif;font-size:12px'>
            <p>Dear Ma'am/Sir,</p>
            <p>Good day! We're pleased to inform you that your application has been approved. Thank you!</p>
            <p>Thank you!</p>
            <br/>
            <br/>

            </body>
            </html>";

        if ($data->sms_switch == true) {
            \Logger::instance()->send_text(
                $number,
                $message
            );
        }
        if ($data->email_switch == true) {
            return \Logger::instance()->mailerGmail(
                $subject,
                $msg,
                $sender,
                $senderName,
                $sendTo,
                $recipient
            );
        }

        return "success!";
    }
    public function reject(Request $request)
    {
        $data = $request;
        DB::table('members')
            ->where('id', $data->id)
            ->update([
                'application_status' => "Rejected",
                'updated_at' => \Carbon\Carbon::now()
            ]);

        $request = member::where('id', $data->id)->first();

        $subject = "Online Membership Application";
        $recipient = $request->first_name . ' ' . $request->mid_name . ' ' .  $request->last_name;
        $sendTo = $request->email;

        $sender = "MEMBERSHIP PROFILE SYSTEM";
        $senderName = "King Multipurpose Cooperative";


        $msg = "
              <html>
                    <head>
                    </head>
                    <body style=' font-family:  Helvetica, Arial, sans-serif;font-size:12px'>
                    <p>Dear Ma'am/Sir,</p>
                    <p>Good day! We're sorry to inform you that your application has been rejected. Thank you!</p>
                    <br/>
                    <br/>

                    </body>
                    </html>";

        $number = $request->contact_no;
        $message = "Good day! We're sorry to inform you that your application has been rejected. Thank you!";

        if ($data->sms_switch == true) {
            \Logger::instance()->send_text(
                $number,
                $message
            );
        }
        if ($data->email_switch == true) {
            return \Logger::instance()->mailerGmail(
                $subject,
                $msg,
                $sender,
                $senderName,
                $sendTo,
                $recipient
            );
        }
    }

    public function testSms()
    {
        $number = "09092104014";
        $message = "King Coop test sms";

        // \Logger::instance()->send_text(
        //     $number,
        //     $message
        // );
    }
}
