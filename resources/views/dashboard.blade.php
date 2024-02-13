<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-lg mx-auto mt-4">
                        <h1 class="text-2xl font-bold mb-8 text-center">Submit Long URL</h1>
                        <form action="{{ route('url.submit') }}" method="POST">
                            @csrf
                            <div class="flex items-center mb-4 space-x-4">
                                <input type="url" id="url" name="url"
                                    class="flex-1 px-4 py-2 border rounded-md" placeholder="Enter Long URL here"
                                    required>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Submit</button>
                            </div>
                            @if (session()->has('error'))
                                <p class="text-[red]">{{ session('error') }}</p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mx-auto mt-4 mb-4">
                        <h1 class="text-2xl font-bold mb-4 text-center">Submitted Urls</h1>
                        <table class="w-full border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Full url</th>
                                    <th class="border border-gray-300 px-4 py-2">Short url</th>
                                    <th class="border border-gray-300 px-4 py-2">Click count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($urls as $url)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a class="font-semibold text-blue-600 hover:text-blue-900 
                                                dark:text-blue-400 dark:hover:text-white focus:outline 
                                                focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                                href="{{ $url->long_url }}" target="_blank">{{ $url->long_url }}
                                            </a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a class="font-semibold text-blue-600 hover:text-blue-900 
                                                dark:text-blue-400 dark:hover:text-white focus:outline 
                                                focus:outline-2 focus:rounded-sm focus:outline-red-500"
                                                href="{{ route('url.click', $url->id) }}" target="_blank">{{ $url->short_url }}
                                            </a>
                                        </td>
                                        <td class="border border-gray-300 px-4 py-2 text-center font-semibold">
                                            {{ $url->click_count }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="border border-gray-300 px-4 py-12 text-center font-semibold">
                                            Nothing to show !
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $urls->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
