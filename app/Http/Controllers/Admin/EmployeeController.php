<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEmployeeRequest;
use App\Http\Requests\Admin\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Support\RwandaLocations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Employee::query()->latest();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('employee_id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($province = $request->string('province')->toString()) {
            $query->where('province', $province);
        }

        if ($position = $request->string('position')->toString()) {
            $query->where('position', $position);
        }

        if ($district = $request->string('district')->toString()) {
            $query->where('district', $district);
        }

        $kpis = [
            [
                'label' => 'Employees',
                'value' => (string) Employee::count(),
                'description' => 'Total staff',
            ],
            [
                'label' => 'Positions',
                'value' => (string) Employee::whereNotNull('position')->where('position', '!=', '')->distinct('position')->count('position'),
                'description' => 'Distinct roles',
            ],
            [
                'label' => 'Provinces',
                'value' => (string) Employee::whereNotNull('province')->where('province', '!=', '')->distinct('province')->count('province'),
                'description' => 'Coverage',
            ],
            [
                'label' => 'With email',
                'value' => (string) Employee::whereNotNull('email')->where('email', '!=', '')->count(),
                'description' => 'Contactable online',
            ],
        ];

        return view('admin.employees.index', [
            'employees' => $query->paginate(15)->withQueryString(),
            'kpis' => $kpis,
            'provinces' => RwandaLocations::provinces(),
            'positionOptions' => Employee::query()
                ->whereNotNull('position')
                ->where('position', '!=', '')
                ->orderBy('position')
                ->distinct()
                ->pluck('position', 'position')
                ->all(),
            'districtOptions' => Employee::query()
                ->whereNotNull('district')
                ->where('district', '!=', '')
                ->orderBy('district')
                ->distinct()
                ->pluck('district', 'district')
                ->all(),
        ]);
    }

    public function create(): View
    {
        return view('admin.employees.create', [
            'provinces' => RwandaLocations::provinces(),
            'districtsByProvince' => RwandaLocations::districts(),
        ]);
    }

    public function store(StoreEmployeeRequest $request): RedirectResponse
    {
        Employee::create($request->validated());

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee): View
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        return view('admin.employees.edit', [
            'employee' => $employee,
            'provinces' => RwandaLocations::provinces(),
            'districtsByProvince' => RwandaLocations::districts(),
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $employee->update($request->validated());

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:employees,id'],
        ])['ids'];

        Employee::whereIn('id', $ids)->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Selected employees deleted successfully.');
    }
}
