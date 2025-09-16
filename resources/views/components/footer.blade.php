@props(['variant' => 'full', 'dark' => false, 'class' => ''])

@if($variant === 'full')
<footer class="px-4 py-4 border-t border-slate-200 bg-slate-50/50 {{ $class }}">
    <div class="text-center">
        <div class="flex items-center justify-center space-x-2 mb-2">
            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-xs {{ $dark ? 'text-white/70' : 'text-slate-500' }} font-medium">System Online</span>
        </div>
        <p class="text-xs {{ $dark ? 'text-white/70' : 'text-slate-400' }}">RSUD Dolopo v1.0</p>
        <p class="text-xs {{ $dark ? 'text-white/70' : 'text-slate-400' }} mt-1">© NAFI' KHAKIMUL M - 2025</p>
    </div>
</footer>
@else
<footer class="px-4 py-4 {{ $class }}">
    <div class="text-center">
        <p class="text-xs {{ $dark ? 'text-white/70' : 'text-slate-400' }}">© NAFI' KHAKIMUL M - 2025</p>
    </div>
</footer>
@endif
