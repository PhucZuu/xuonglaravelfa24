<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Passport;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('search');

        $query = Student::with(['passport', 'classroom'])
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhereHas('classroom', function ($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%$keyword%");
                    });
            });

        $students = $query->latest('id')->paginate(5);

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();

        return view('students.create', compact('classrooms', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', Rule::unique('students'), 'email'],
            'classroom_id'      => ['required', 'exists:classrooms,id'],
            'passport_number'   => ['required', 'string', Rule::unique('passports')],
            'issued_date'       => ['required', 'date'],
            'expiry_date'       => ['required', 'date', 'after:issued_date'],
            'subjects'          => ['array'],
            'subjects.*'        => ['exists:subjects,id'],
        ]);

        try {

            $student = Student::create($data);

            $passportData = [
                'student_id'      => $student->id,
                'passport_number' => $data['passport_number'],
                'issued_date'     => $data['issued_date'],
                'expiry_date'     => $data['expiry_date'],
            ];

            Passport::create($passportData);

            if (isset($data['subjects'])) {
                $student->subjects()->attach($data['subjects']);
            }

            return redirect()->route('students.index')->with('success', true);
        } catch (\Throwable $th) {
            return back()->with('success', false);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        $student->load(['classroom', 'subjects']);

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        $student->load(['classroom', 'subjects']);

        return view('students.edit', compact('student', 'classrooms', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', Rule::unique('students')->ignore($student->id), 'email'],
            'classroom_id'      => ['required', 'exists:classrooms,id'],
            'passport_number'   => ['required', 'string', Rule::unique('passports')->ignore($student->passport->id)],
            'issued_date'       => ['required', 'date'],
            'expiry_date'       => ['required', 'date', 'after:issued_date'],
            'subjects'          => ['array'],
            'subjects.*'        => ['exists:subjects,id'],
        ]);

        try {

            $student->update($data);

            $passportData = [
                'passport_number' => $data['passport_number'],
                'issued_date'     => $data['issued_date'],
                'expiry_date'     => $data['expiry_date'],
            ];

            $student->passport->update($passportData);

            if (isset($data['subjects'])) {
                $student->subjects()->sync($data['subjects']);
            }

            return back()->with('success', true);
        } catch (\Throwable $th) {
            return back()->with('success', false);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {
            $student->subjects()->detach();

            if ($student->passport) {
                $student->passport()->delete();
            }

            $student->delete();

            return redirect()->route('students.index')->with('success', true);
        } catch (\Throwable $th) {
            return back()->with('success', false);
        }
    }
}
