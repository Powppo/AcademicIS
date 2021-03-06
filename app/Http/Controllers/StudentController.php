<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use DB;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // the eloquent function to displays data
            $student = Student::with('class')->get();
            $paginate = Student::orderBy('id_student', 'asc')->paginate(3);
            return view('student.index', ['student' => $student,'paginate'=>$paginate]);
    }
    public function create()
    {
        $class = ClassModel::all(); //get data from class table
        return view('student.create',['class' => $class]);
    }
    public function store(Request $request)
    {
    //data validation
        $request->validate([
            'Nim' => 'required',
            'Name' => 'required',
            'Class' => 'required',
            'Major' => 'required',
        ]);

        $student = new Student;
        $student->nim = $request->get('Nim');
        $student->name = $request->get('Name');
        $student->major = $request->get('Major');
        $student->save();

        $class = new ClassModel;
        $class->id = $request->get('Class');

        // eloquent function to add data using belongsTo relation
        $student->class()->associate($class);
        $student->save();

        // if the data is added successfully, will return to the main page
        return redirect()->route('student.index')
            ->with('success', 'Student Successfully Added');
    }

    public function show($nim)
    {
        // displays detailed data by finding / by Student Nim
            $Student = Student::where('nim', $nim)->first();
            return view('student.detail', compact('Student'));
    }

    public function edit($nim)
    {
        // displays detail data by finding based on Student Nim for editing
            $Student = Student::with('class')->where('nim', $nim)->first();
            $class = ClassModel::all();
            return view('student.edit', compact('Student', 'class'));
    }

    public function update(Request $request, $nim)
    {
        //validate the data
            $request->validate([
            'Nim' => 'required',
            'Name' => 'required',
            'Class' => 'required',
            'Major' => 'required',
        ]);

        $student = Student::with('class')->where('nim', $nim)->first();
        $student->nim = $request->get('Nim');
        $student->name = $request->get('Name');
        $student->major = $request->get('Major');
        $student->save();

        $class = new ClassModel;
        $class->id = $request->get('Class');

        //
        $student->class()->associate($class);
        $student->save();

        //if the data successfully updated, will return to main page
            return redirect()->route('student.index')
                ->with('success', 'Student Successfully Updated');
    }

    public function destroy($nim)
    {
        //Eloquent function to delete the data
            Student::where('nim', $nim)->delete();
                return redirect()->route('student.index')
                    -> with('success', 'Student Successfully Deleted');
    }
};
