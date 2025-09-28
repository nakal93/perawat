@extends('layouts.app')

@section('breadcrumb', 'Activity Logs')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Activity Logs</h1>
                <p class="text-gray-600 mt-1">Monitor user activities and system changes</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-green-100 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-700">Total Activities</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($activities->total()) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-green-50 to-green-100">
                    <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-700">Active Users</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $activities->pluck('causer_id')->unique()->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-yellow-50 to-yellow-100">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-700">Today's Activities</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $activities->where('created_at', '>=', today())->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-purple-50 to-purple-100">
                    <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-700">Event Types</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $activities->pluck('description')->unique()->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Summary (window) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-2">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-red-50 to-red-100">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 4.93l14.14 14.14M12 19a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-700">Login Failed ({{ $summaryMeta['windowLabel'] ?? '6 hours' }})</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($summary['failed'] ?? 0) }}</p>
                    @php($lastFailed = $summaryMeta['last']['failed'] ?? null)
                    <p class="text-[11px] text-slate-500">Last seen: {{ $lastFailed ? $lastFailed->timezone(config('app.timezone'))->format('d/m/Y H:i') : '—' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-amber-50 to-amber-100">
                    <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.79-2.9L13.79 4.9a2 2 0 00-3.58 0L3.28 16.1A2 2 0 005.07 19z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-700">Lockouts ({{ $summaryMeta['windowLabel'] ?? '6 hours' }})</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($summary['lockout'] ?? 0) }}</p>
                    @php($lastLockout = $summaryMeta['last']['lockout'] ?? null)
                    <p class="text-[11px] text-slate-500">Last seen: {{ $lastLockout ? $lastLockout->timezone(config('app.timezone'))->format('d/m/Y H:i') : '—' }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
            <div class="flex items-center">
                <div class="p-2.5 rounded-xl bg-gradient-to-br from-rose-50 to-rose-100">
                    <svg class="w-5 h-5 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3-1.343 3-3V4a3 3 0 10-6 0v1c0 1.657 1.343 3 3 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10a7 7 0 0114 0v6a3 3 0 01-3 3H8a3 3 0 01-3-3v-6z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-semibold text-gray-700">Brute-Force Alerts ({{ $summaryMeta['windowLabel'] ?? '6 hours' }})</p>
                    <p class="text-lg font-semibold text-gray-900">{{ number_format($summary['bruteforce'] ?? 0) }}</p>
                    @php($lastBrute = $summaryMeta['last']['bruteforce'] ?? null)
                    <p class="text-[11px] text-slate-500">Last seen: {{ $lastBrute ? $lastBrute->timezone(config('app.timezone'))->format('d/m/Y H:i') : '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Window Selector and Hints -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 mb-6">
        <form method="GET" action="{{ route('admin.security.activity') }}" class="flex flex-col sm:flex-row gap-3 items-start sm:items-end">
            <input type="hidden" name="event" value="{{ $event ?? '' }}"/>
            <input type="hidden" name="date" value="{{ $date ?? '' }}"/>
            <div>
                <label for="window" class="block text-xs font-medium text-slate-500 mb-1">Summary Window</label>
                <select id="window" name="window" class="border rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    @php($win = request('window','6h'))
                    @foreach(['1h'=>'Last 1 hour','3h'=>'Last 3 hours','6h'=>'Last 6 hours','12h'=>'Last 12 hours','24h'=>'Last 24 hours','3d'=>'Last 3 days','7d'=>'Last 7 days','30d'=>'Last 30 days'] as $val => $label)
                        <option value="{{ $val }}" @selected($win===$val)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 shadow-sm">Update</button>
                <a href="{{ route('admin.security.activity') }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 shadow-sm">Reset</a>
            </div>
            @php($sinceText = ($summaryMeta['since'] ?? null) ? $summaryMeta['since']->format('d/m/Y H:i') : '—')
            <div class="text-xs text-slate-500 sm:ml-auto">
                Window since: <span class="font-medium">{{ $sinceText }}</span>
            </div>
        </form>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-4">
        <form method="GET" action="{{ route('admin.security.activity') }}" class="flex flex-col sm:flex-row gap-3 items-start sm:items-end">
            <div>
                <label for="event" class="block text-xs font-medium text-slate-500 mb-1">Event Type</label>
                <select id="event" name="event" class="border rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Events</option>
                    @foreach($events as $opt)
                        <option value="{{ $opt }}" @selected(($event ?? '') === $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="date" class="block text-xs font-medium text-slate-500 mb-1">Date</label>
                <input type="date" id="date" name="date" value="{{ $date ?? '' }}" class="border rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500"/>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">Apply</button>
                <a href="{{ route('admin.security.activity') }}" class="px-3 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200">Reset</a>
            </div>
        </form>
        @if(($event ?? false) || ($date ?? false))
            <div class="mt-3 text-xs text-slate-500">Active filters:
                @if($event) <span class="inline-flex items-center px-2 py-1 rounded bg-slate-100 text-slate-700 mr-2">event: {{ $event }}</span>@endif
                @if($date) <span class="inline-flex items-center px-2 py-1 rounded bg-slate-100 text-slate-700">date: {{ $date }}</span>@endif
            </div>
        @endif
    </div>

    <!-- Activity Logs Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Recent Activities</h2>
                <div class="text-xs text-slate-500">Showing {{ $activities->count() }} of {{ $activities->total() }}</div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($activities as $activity)
                    <tr class="hover:bg-gray-50">
                        @php($evt = $activity->event ?? $activity->description)
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php($isGuestEvt = in_array($evt, ['login_failed','login_lockout','bruteforce_warning']))
                            @php($emailTried = $activity->properties['email'] ?? null)
                            @php($displayName = $isGuestEvt ? ($emailTried ?: 'Unknown') : ($activity->causer->name ?? 'System'))
                            @php($displayEmail = $isGuestEvt ? ($emailTried ?: 'unknown@app.local') : ($activity->causer->email ?? 'system@app.local'))
                            @php(
                                $initials = (function($nameOrEmail){
                                    if (!$nameOrEmail) return '??';
                                    $base = $nameOrEmail;
                                    if (str_contains($base, '@')) {
                                        $base = explode('@', $base)[0];
                                    }
                                    $base = preg_replace('/[^A-Za-z]/','', $base);
                                    return strtoupper(substr($base ?: '??', 0, 2));
                                })($displayName)
                            )
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center">
                                        <span class="text-white text-xs font-medium">{{ $initials }}</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900 flex items-center gap-2">
                                        <span>{{ $displayName }}</span>
                                        @if($isGuestEvt)
                                            <span class="text-[10px] px-1.5 py-0.5 rounded bg-slate-100 text-slate-600 uppercase tracking-wide">guest</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $displayEmail }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap" title="{{ $summaryMeta['eventDescriptions'][$evt] ?? 'Activity event' }}">
                            @php($badge = match($evt){
                                'login' => 'bg-green-100 text-green-800',
                                'logout' => 'bg-slate-100 text-slate-800',
                                'login_failed' => 'bg-red-100 text-red-800',
                                'login_lockout' => 'bg-amber-100 text-amber-800',
                                'bruteforce_warning' => 'bg-rose-100 text-rose-800',
                                'created' => 'bg-green-100 text-green-800',
                                'updated' => 'bg-blue-100 text-blue-800',
                                'deleted' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            })
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                                {{ str_replace('_',' ', ucfirst($evt)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap" title="The Eloquent model type and identifier affected by this activity.">
                            <div class="text-sm text-gray-900">{{ class_basename($activity->subject_type ?? 'N/A') }}</div>
                            <div class="text-xs text-gray-500">ID: {{ $activity->subject_id ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500" title="Resolved from X-Forwarded-For chain if behind proxy.">
                            {{ is_string($activity->properties['ip'] ?? null) ? $activity->properties['ip'] : ($activity->properties['ip'][0] ?? 'N/A') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap" title="UTC offset: {{ $activity->created_at->timezone(config('app.timezone'))->format('P') }}">
                            <div class="text-sm text-gray-900">{{ $activity->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $activity->created_at->format('H:i:s') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($activity->properties && count($activity->properties) > 0)
                            <button 
                                onclick="toggleDetails('activity-{{ $activity->id }}')" 
                                class="text-blue-600 hover:text-blue-900 text-sm font-medium" title="Toggle full JSON properties for this event">
                                View Details
                            </button>
                            <div id="activity-{{ $activity->id }}" class="hidden mt-2 p-3 bg-gray-50 rounded-lg">
                                <pre class="text-xs text-gray-700 whitespace-pre-wrap">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                            @else
                            <span class="text-xs text-gray-400">No details</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2 text-sm font-medium">No activity logs found</p>
                                <p class="text-xs">Activity tracking will appear here when users perform actions</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($activities->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $activities->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function toggleDetails(id) {
    const element = document.getElementById(id);
    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
    } else {
        element.classList.add('hidden');
    }
}
</script>
@endsection