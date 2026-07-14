@php
    $employeeForm = [
        'province' => old('province', $employee->province ?? ''),
        'district' => old('district', $employee->district ?? ''),
        'districtsByProvince' => $districtsByProvince,
    ];
@endphp

<x-admin.form method="{{ $method ?? 'POST' }}" action="{{ $action }}" x-data='{
        province: @json($employeeForm["province"]),
        district: @json($employeeForm["district"]),
        districtsByProvince: @json($employeeForm["districtsByProvince"]),
        get districts() { return this.districtsByProvince[this.province] || {}; },
        onProvinceChange() { this.district = ""; }
    }'>
    <x-admin.input label="Employee ID" name="employee_id" :value="$employee?->employee_id" :required="true" />
    <x-admin.input label="Name" name="name" :value="$employee?->name" :required="true" />
    <x-admin.input label="Position" name="position" :value="$employee?->position" />
    <x-admin.input label="Phone" name="phone" type="tel" :value="$employee?->phone" />
    <x-admin.input label="Email" name="email" type="email" :value="$employee?->email" />

    <div class="space-y-1">
        <label for="province" class="block text-sm font-medium text-slate-700">Province</label>
        <select
            id="province"
            name="province"
            x-model="province"
            @change="onProvinceChange()"
            class="admin-input"
        >
            <option value="">Select…</option>
            @foreach ($provinces as $value => $label)
                <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
        @error('province') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="space-y-1">
        <label for="district" class="block text-sm font-medium text-slate-700">District <span class="text-red-500">*</span></label>
        <select
            id="district"
            name="district"
            x-model="district"
            :disabled="!province"
            required
            class="admin-input disabled:bg-slate-50 dark:disabled:bg-slate-900/50"
        >
            <option value="">Select…</option>
            <template x-for="(label, value) in districts" :key="value">
                <option :value="value" x-text="label"></option>
            </template>
        </select>
        @error('district') <p class="text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="flex flex-wrap gap-3 pt-2">
        <x-admin.button type="submit">{{ $submitLabel }}</x-admin.button>
        <x-admin.button variant="secondary" :href="route('admin.employees.index')">Cancel</x-admin.button>
        @isset($employee)
            <x-admin.button variant="secondary" :href="route('admin.employees.show', $employee)">View</x-admin.button>
        @endisset
    </div>
</x-admin.form>
