 <div wire:model="addStudentsToSection"
     class="fixed inset-0 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center transition ease-in-out duration-500 @if ($addStudentsToSection) opacity-100 @else opacity-0 @endif"
     style="z-index: @if (!$addStudentsToSection) -999 @else 30 @endif ;">
     <!-- Modal -->
     <div class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl transition ease-in-out duration-500 @if ($addStudentsToSection) opacity-100 transform translate-y-0 @else opacity-100 transform translate-y-1/2 @endif"
         role="dialog" id="modal">
         <form>
             <div class="mt-4 mb-6">
                 <!-- Modal title -->
                 <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                     Search for a student name to add
                 </p>
                 @if (session()->has('message'))
                     <div class="flex items-center bg-blue-700 text-white text-sm font-bold px-4 py-4 my-3 rounded-lg"
                         role="alert">
                         <p class="text-sm">{{ session('message') }}</p>
                     </div>
                     <br>
                 @endif
                 <!-- Modal description -->
                 <label class="block text-sm mt-4">
                     <input
                         class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                         placeholder="Enter student name" type="text" wire:model="student_name" id="student_name" />
                 </label>
                 <br>
                 @empty($student_to_add)
                     <p>Nothing yet</p>
                 @endempty
                 @if ($student_to_add)
                     <h3>{{ $student_to_add->last_name }}, {{ $student_to_add->first_name }}
                         {{ $student_to_add->middle_name }}</h3>
                 @endif
             </div>
             <footer
                 class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800">
                 <button wire:click.prevent="closeAddStudentModal()"
                     class="w-full px-5 py-3 text-sm font-medium leading-5 text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 sm:px-4 sm:py-2 sm:w-auto active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray">
                     Cancel
                 </button>
                 @if ($student_to_add)
                     <button
                         class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                         wire:click.prevent="addToSection()" type="button">
                         Add
                     </button>
                 @else
                     <button
                         class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                         wire:click.prevent="searchStudentToAdd()" type="button">
                         Search
                     </button>
                 @endif
             </footer>
         </form>
     </div>
 </div>
