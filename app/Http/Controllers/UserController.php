<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Group;
use Redirect;
use Excel;

class UserController extends Controller
{
    protected $students;
    protected $groups;

    public function __construct()
    {
        $this->groups = Group::select('id', 'name')->get();
    }

    public function uploadStudents(Request $request)
    {
        if ($request->hasFile('doc')) {
            $file = $request->file('doc');
            $path = $file->getRealPath();
            $students = Excel::load($path, function ($reader) {
            })->get();
            if ($students->count() != 0) {
                foreach ($students as $student) {
                    if (starts_with($student->id_number, 'SHS') == true) {
                        $id_now = substr_replace($student->id_number, '-', 7, 0);
                        $group_id = 2;
                    } else {
                        $id_now = $student->id_number;
                        $group_id = 1;
                    }
                    $user = Student::updateOrCreate(
                        [
                            'id_number' => $student->id_number
                        ],
                        [
                            'id_number' => $student->id_number,
                            'id_now' => $id_now,
                            'firstname' => ucwords($student->firstname),
                            'middlename' => ucwords($student->middlename),
                            'lastname' => ucwords($student->lastname),
                            'group_id' => $group_id,
                        ]
                    );
                }
            }
            return Redirect::back()->with(['success_message' => 'Faculty Uploaded Successfully']);
        }
        return response()->json('Failed to Upload');
    }

    public function list()
    {
        $students = Student::with(['group'])->latest()->get();

        return response()->json($students);
    }

    public function store(Request $request)
    {
        if (starts_with($request->id_number, 'SHS') == true) {
            $id_now = substr_replace($request->id_number, '-', 7, 0);
            $group_id = 2;
        } else {
            $id_now = $request->id_number;
            $group_id = 1;
        }

        $student = Student::create([
            'id_number' => strtoupper($request->id_number),
            'id_now' => strtoupper($id_now),
            'firstname' => ucwords($request->firstname),
            'middlename' => ucwords($request->middlename),
            'lastname' => ucwords($request->lastname),
            'group_id' => $group_id,
        ]);

        return response()->json("New Student Added", 200);
    }
}
