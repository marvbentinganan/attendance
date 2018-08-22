<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Event;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Event $event)
    {
        $time = date('H:i:s', time());
        //dd($time);
        if(Carbon::today() >= $event->from AND $event->to >= Carbon::today()){
            try{
                // Check if Student exists
                $student = Student::where('id_now', $request->id_now)->first();
                if($student){
                    // Check if Student has record for the day
                    $record = $student->attendances()->whereDate('created_at', Carbon::today())->where('event_id', $event->id)->first();
                    if($record){
                        $message = $this->updateAttendance($record, $event, $time);
                    } else {
                        $message = $this->recordAttendance($student, $event, $time);
                    }
                    $results = $student->attendances()->where('event_id', $event->id)->get();
                    return response()->json([
                        'message' => $message,
                        'results' => $results,
                        'student' => $student
                    ]);
                } else {
                    return response()->json([
                        'message' => "Record Not Found"
                    ]);
                }
            }
            
            catch(Exception $ex){
                abort(404);
            }
        }
        return response()->json([
            'message' => "The Event hasn't Started or Already Ended"
        ]);
    }

    private function updateAttendance($record, $event, $time){
        if($event->control->from_afternoon < $time AND $event->control->to_afternoon > $time){
            if($record->afternoon == false){
                $record->update([
                    'afternoon' => true
                ]);
                return "Attendance Recorded";
            }
            return "Attendance Already Recorded";
        } elseif($event->control->from_morning < $time AND $event->control->to_morning > $time AND $record->morning == true){
            return "Attendance Already Recorded";
        }
        return "Unable to Record Attendance";
    }

    private function recordAttendance($student, $event, $time){
        if($time > $event->control->from_morning AND $time < $event->control->to_morning){
            $record = $student->attendances()->create([
                'event_id' => $event->id,
                'morning' => true
            ]);
            return "Attendance Recorded";
        } elseif($time > $event->control->from_afternoon AND $time < $event->control->to_afternoon) {
            $record = $student->attendances()->create([
                'event_id' => $event->id,
                'afternoon' => true
            ]);
            return "Attendance Recorded";
        }
        return "Unable to Record Attendance";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function attendees(Event $event){
        // Get last 10 Attendance records
        $attendees = $event->attendances()
        ->take(10)
        ->orderBy('updated_at', 'DESC')
        ->orderBy('created_at', 'DESC')
        ->get();

        return response()->json($attendees);
    }

    public function recent(Event $event){
        // Get Recent Attendance Record
        $recent = $event->attendances()
        ->orderBy('updated_at', 'DESC')
        ->orderBy('created_at', 'DESC')
        ->first();
        
        $student = $recent->student;
        $results = $student->attendances()->where('event_id', $event->id)->get();

        return response()->json([
            'student' => $student,
            'results' => $results
        ]);
    }
}
