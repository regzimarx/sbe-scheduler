<select
    class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
    wire:model="department_dept_id" id="department_dept_id">
    <option value="">Please select department</option>
    @foreach (App\Models\Department::all() as $department)
        <option value="{{ $department->dept_id }}">
            @if ($department->dept_id == 1) Elementary @elseif ($department->dept_id == 2) Junior High School @elseif ($department->dept_id == 3) Senior High School @endif
        </option>
    @endforeach
</select>
