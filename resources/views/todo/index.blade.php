<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-100 leading-tight">
            {{ __('Todo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <!-- CREATE BUTTON & FLASH MESSAGE -->
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 text-xl text-gray-700 dark:text-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <x-create-button href="{{ route('todo.create') }}" />
                            </div>

                            @if (session('success'))
                                <p x-data="{ show: true }" x-show="show" x-transition
                                   x-init="setTimeout(() => show = false, 5000)"
                                   class="text-sm text-green-500 dark:text-green-300">
                                    {{ session('success') }}
                                </p>
                            @endif

                            @if (session('danger'))
                                <p x-data="{ show: true }" x-show="show" x-transition
                                   x-init="setTimeout(() => show = false, 5000)"
                                   class="text-sm text-red-500 dark:text-red-300">
                                    {{ session('danger') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- TODO TABLE -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-600 dark:text-gray-300">
                        <thead class="text-sm text-gray-600 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-3">Category</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($todos as $data)
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">

                                    <!-- TITLE -->
                                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-200">
                                        <a href="{{ route('todo.edit', $data) }}" class="hover:underline text-sm">
                                            {{ $data->title }}
                                        </a>
                                    </td>

                                    <!-- CATEGORY (FIXED) -->
                                    <td class="px-6 py-4">
                                        {{ $data->category->title ?? '' }}
                                    </td>

                                    <!-- STATUS -->
                                    <td class="px-6 py-4">
                                        @if ($data->is_done)
                                            <span class="bg-green-900 text-green-400 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                Done
                                            </span>
                                        @else
                                            <span class="bg-indigo-900 text-blue-400 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                Ongoing
                                            </span>
                                        @endif
                                    </td>

                                    <!-- ACTION -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-6">
                                            @if ($data->is_done)
                                                <form action="{{ route('todo.uncomplete', $data) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="text-blue-600 dark:text-blue-400 hover:underline text-sm font-medium">
                                                        Uncomplete
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('todo.complete', $data) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="text-green-600 dark:text-green-400 hover:underline text-sm font-medium">
                                                        Complete
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('todo.destroy', $data) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-red-600 dark:text-red-400 hover:underline text-sm font-medium"
                                                        onclick="return confirm('Are you sure you want to delete this todo?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- DELETE ALL COMPLETED TASK BUTTON -->
                @if ($todosCompleted > 1)
                    <div class="p-6 text-xl text-gray-700 dark:text-gray-100">
                        <form action="{{ route('todo.deleteallcompleted') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-primary-button>
                                Delete All Completed Task
                            </x-primary-button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
