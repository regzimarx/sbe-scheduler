@section('title', 'Users')

<div class="container grid px-6 py-6 mx-auto">

    @include('includes.messages')

    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Users
    </h2>

    <!-- With avatar -->
    @include('includes.search', ["fields" => [
    "first_name" => "First name",
    "middle_name" => "Middle name",
    "last_name" => "Last name"
    ]])

    <div class="w-full my-5 overflow-hidden rounded-lg shadow-xs">
        @include('livewire.users.user-edit-modal')
        @include('livewire.users.user-delete-modal')
        @include('livewire.users.user-reset-password')
        <div class="w-full overflow-x-auto">
            <table class="table-auto w-full">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Record ID
                                @include('includes.order-by', ["field" => 'id'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                First name
                                @include('includes.order-by', ["field" => 'first_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Middle name
                                @include('includes.order-by', ["field" => 'middle_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Last name
                                @include('includes.order-by', ["field" => 'last_name'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Email
                                @include('includes.order-by', ["field" => 'email'])
                            </span>
                        </th>
                        <th class="px-4 py-2">
                            <span class="flex flex-row items-center">
                                Admin type
                                @include('includes.order-by', ["field" => 'email'])
                            </span>
                        </th>
                        @if (Auth::user()->department_dept_id == null)
                            <th class="px-4 py-2">
                                <span class="flex flex-row items-center">
                                    Department
                                    @include('includes.order-by', ["field" => "department_dept_id"])
                                </span>
                            </th>
                        @endif
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @if ($users->count())
                        @foreach ($users as $user)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-2 text-sm">
                                    {{ $user->id }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $user->first_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $user->middle_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $user->last_name }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ Illuminate\Support\Str::title($user->admin_type) }}
                                </td>
                                @if (Auth::user()->department_dept_id == null)
                                    <td class="px-4 py-2">
                                        @php
                                            $dept = $user->department_dept_id;
                                        @endphp
                                        @if ($dept == 1) Elementary @elseif ($dept == 2) Junior High School @elseif ($dept == 3) Senior High School @endif
                                    </td>
                                @endif
                                <td class="px-4 py-2 flex">
                                    <button wire:click.prevent="edit({{ $user->id }})"
                                        class="mt-4 mb-4 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-yellow-400 border border-transparent rounded-md active:bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:shadow-outline-purple">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button wire:click.prevent="openDelete({{ $user->id }})"
                                        class="mt-4 mb-4 ml-1 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-400 border border-transparent rounded-md active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <button wire:click.prevent="openResetPassword({{ $user->id }})"
                                        class="mt-4 mb-4 ml-1 px-2 py-1 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-green-400 border border-transparent rounded-md active:bg-green-600 hover:bg-green-700 focus:outline-none focus:shadow-outline-purple">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                @include('includes.no-result')
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    {{ $users->links() }}
</div>
