<div class="fixed inset-0 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center transition ease-in-out duration-500 @if ($openEdit) opacity-100 @else opacity-100 @endif"
    style="z-index: @if (!$openEdit) -999 @else 30 @endif ;">
    <!-- Modal -->
    <div class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl transition ease-in-out duration-500 @if ($openEdit) opacity-100 transform translate-y-0 @else opacity-100 transform translate-y-1/2 @endif"
        role="dialog" id="modal">
        <form>
            <div class="mt-4 mb-6">
                <!-- Modal title -->
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    {{ $schedule_id ? 'Edit schedule ' : 'Create new schedule' }}
                </p>
                <!-- Modal description -->
                <form>
                    <select
                        class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="subject_id" id="subject_id">
                        <option value="">Please select subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                    <select
                        class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="teacher_id" id="teacher_id">
                        <option value="">Please select teacher</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->teacher_id }}">{{ $teacher->last_name }},
                                {{ $teacher->first_name }} {{ $teacher->middle_name }}</option>
                        @endforeach
                    </select>
                    <select
                        class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="section_id" id="section_id">
                        <option value="">Please select section</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->section_id }}">{{ $section->section_name }}</option>
                        @endforeach
                    </select>
                    <select
                        class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                        wire:model="room_id" id="room_id">
                        <option value="">Please select room assignment</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->room_id }}">{{ $room->room_name }}</option>
                        @endforeach
                    </select>
                    <label class="block text-sm mt-4">
                        <label class="mb-2 dark:text-gray-300">Start time</label>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="Enter start time" type="time" wire:model="time_start" id="time_start" />
                    </label>
                    <label class="block text-sm mt-4">
                        <label class="mb-2 dark:text-gray-300">End time</label>
                        <input
                            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                            placeholder="Enter end time" type="time" wire:model="time_end" id="time_end" />
                    </label>
                    <label class="block text-sm mt-4">
                        <label class="mb-2 dark:text-gray-300">Days</label>
                        <select
                            class="block w-full mt-4 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                            wire:model="day" id="day" multiple>
                            <option value="" disabled>Please select day/s (CTRL + click to select multiple days)
                            </option>
                            @foreach ($days as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </label>
                </form>
            </div>
            <footer
                class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                <button wire:click.prevent="closeEditModal()"
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                    Cancel
                </button>
                <button
                    class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    wire:click.prevent="store()" type="button">
                    Save
                </button>
            </footer>
        </form>
    </div>
</div>
