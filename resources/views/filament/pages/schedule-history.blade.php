<x-filament-panels::page>
    <div class="relative overflow-x-auto">
        @if(count($scheduleHistories) > 0)
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs uppercase" style="background-color: rgb(65, 170, 65); color: rgb(255, 255, 255)">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            S/N
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Contacts
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Message
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Delivered At
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Frequency
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($scheduleHistories as $index => $scheduleHistory)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                            <th class="px-6 py-4">
                                {{ $scheduleHistory['contacts'] }}
                            </th>
                            <th class="px-6 py-4">
                                {{ $scheduleHistory['message'] }}
                            </th>
                            <th class="px-6 py-4">
                                {{ $scheduleHistory['delivered_at'] }}
                            </th>
                            <th class="px-6 py-4">
                                {{ $scheduleHistory['frequency'] }}
                            </th>
                            <td class="px-6 py-4">
                                @if($scheduleHistory['status'])
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="green" d="M9 16.2l-3.5-3.5L4 14l5 5 11-11-1.5-1.5L9 16.2z"/>
                                     </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z"/>
                                        <path fill="red" d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                    </svg>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <div>
                    <span class="font-medium p-2">No Schedule History</span>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
