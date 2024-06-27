<x-filament-panels::page>
    <div class="relative overflow-x-auto">
        @if(count($statuses) > 0)
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs uppercase" style="background-color: rgb(65, 170, 65); color: rgb(255, 255, 255)">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            S/N
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Mobile number Not uploaded
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name Associated To Birth date Not uploaded
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date uploaded
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($statuses as $index => $status)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <div class="max-w-xs" style="max-height: 10rem; overflow-y: auto;">{{ $status['mobile_numbers'] }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <div class="max-w-xs" style="max-height: 10rem; overflow-y: auto;">{{ $status['email'] }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                <div class="max-w-xs" style="max-height: 10rem; overflow-y: auto;">{{ $status['birth_date'] }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($status['created_at'])->format('Y-m-d H:i:s') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <div>
                    <span class="font-medium p-2">No history</span>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
