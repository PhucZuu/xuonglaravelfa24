<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Manager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    const PATH_VIEW = 'employees.';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::query()
            ->from('employees', 'e')
            ->join('departments', 'department_id', '=', 'departments.id')
            ->join('managers', 'manager_id', '=', 'managers.id')
            ->select([
                'e.id',
                'e.first_name',
                'e.last_name',
                'e.email',
                'e.phone',
                'e.date_of_birth',
                'e.hire_date',
                'e.is_active',
                'e.address',
                'e.profile_picture',
                'departments.department_name',
                'managers.manager_name'
            ])
            ->latest('e.id')
            ->paginate(5);

        return view(self::PATH_VIEW . __FUNCTION__, compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $managers = Manager::query()->latest('id')->get();
        $departments = Department::query()->latest('id')->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('departments', 'managers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'first_name'      => 'required|max:100',
            'last_name'       => 'required|max:100',
            'email'           => ['required', 'max:150', Rule::unique('employees')],
            'phone'           => 'required|max:20',
            'date_of_birth'   => 'required',
            'hire_date'       => 'required',
            'address'         => 'required',
            'is_active'       => ['nullable', Rule::in([0, 1])],
            'profile_picture' => 'required|max:2048|mimes:jpg,png,jpeg',
            'manager_id'      => 'required|exists:managers,id',
            'department_id'   => 'required|exists:departments,id',
        ]);

        try {

            $dateFormat = Carbon::parse($data['hire_date']);
            $data['hire_date'] = $dateFormat->format('Y-m-d H:i:s');

            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = file_get_contents($request->file('profile_picture')->getRealPath());
            }

            Employee::query()->create($data);

            return redirect()->route('employees.index')->with('success', true);
        } catch (\Throwable $th) {

            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $managers = Manager::query()->latest('id')->get();
        $departments = Department::query()->latest('id')->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('departments', 'managers', 'employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'first_name'      => 'required|max:100',
            'last_name'       => 'required|max:100',
            'email'           => ['required', 'max:150', Rule::unique('employees')->ignore($employee->id)],
            'phone'           => 'required|max:20',
            'date_of_birth'   => 'required',
            'hire_date'       => 'required',
            'address'         => 'required',
            'is_active'       => ['nullable', Rule::in([0, 1])],
            'profile_picture' => 'nullable|image|max:2048|mimes:jpg,png,jpeg',
            'manager_id'      => 'required|exists:managers,id',
            'department_id'   => 'required|exists:departments,id',
        ]);

        try {
            $data['is_active'] ??= 0;

            $dateFormat = Carbon::parse($data['hire_date']);
            $data['hire_date'] = $dateFormat->format('Y-m-d H:i:s');

            if ($request->hasFile('profile_picture')) {
                $data['profile_picture'] = file_get_contents($request->file('profile_picture')->getRealPath());
            }

            $employee->update($data);

            return back()->with('success', true);
        } catch (\Throwable $th) {
            return back()->with('success', false)->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            $employee->delete();

            return back()->with('success', true);
        } catch (\Throwable $th) {
            return back()->with('success', false);
        }
    }
}
