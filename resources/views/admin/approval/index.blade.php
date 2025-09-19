@extends('layouts.app')

@section('breadcrumb', 'Approval')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Persetujuan Karyawan</h1>
            <p class="text-gray-600 mt-1">Kelola persetujuan pendaftaran karyawan baru</p>
        </div>
            <div class="flex gap-2 mt-4 sm:mt-0">
                @if($pendingKaryawan->count() > 0)
                <button onclick="approveAll()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Setujui Semua
                </button>
                <button onclick="bulkAction()" 
                        id="bulk-action-btn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Setujui Terpilih (<span id="selected-count">0</span>)
                </button>
                @endif
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">{{ $pendingKaryawan->total() }}</div>
                        <div class="text-gray-600">Menunggu Persetujuan</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\User::where('status', 'approved')->where('role', 'karyawan')->count() }}
                        </div>
                        <div class="text-gray-600">Sudah Disetujui</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-900">
                            {{ \App\Models\User::where('status', 'rejected')->where('role', 'karyawan')->count() }}
                        </div>
                        <div class="text-gray-600">Ditolak</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee List -->
        <div class="bg-white rounded-lg shadow">
            @if($pendingKaryawan->count() > 0)
            <div class="p-6 border-b">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="select-all" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mr-3">
                    <label for="select-all" class="text-sm font-medium text-gray-700">
                        Pilih Semua di Halaman Ini
                    </label>
                </div>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($pendingKaryawan as $karyawan)
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-start">
                        <input type="checkbox" 
                               name="karyawan_ids[]" 
                               value="{{ $karyawan->id }}"
                               class="karyawan-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded mt-1 mr-4">
                        
                        <div class="flex-1">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                <!-- Employee Info -->
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ strtoupper(substr($karyawan->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">{{ $karyawan->name }}</h3>
                                            <p class="text-gray-600">{{ $karyawan->email }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($karyawan->karyawan)
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-3 text-sm">
                                        <div>
                                            <span class="text-gray-500">Profesi:</span>
                                            <span class="font-medium ml-1">
                                                {{ $karyawan->karyawan->profesi->nama_profesi ?? 'Tidak diketahui' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Ruangan:</span>
                                            <span class="font-medium ml-1">
                                                {{ $karyawan->karyawan->ruangan->nama_ruangan ?? 'Tidak ditentukan' }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Mendaftar:</span>
                                            <span class="font-medium ml-1">{{ $karyawan->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="flex gap-2 mt-4 lg:mt-0 lg:ml-4">
                                    <form action="{{ route('admin.approval.approve', $karyawan) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center text-sm"
                                                onclick="return confirm('Setujui karyawan {{ $karyawan->name }}?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Setujui
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.approval.reject', $karyawan) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center text-sm"
                                                onclick="return confirm('Tolak karyawan {{ $karyawan->name }}?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t">
                {{ $pendingKaryawan->links() }}
            </div>
            @else
            <div class="p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Karyawan Pending</h3>
                <p class="text-gray-500">Semua pendaftaran karyawan sudah diproses.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loading-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
        <div class="text-center">
            <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-600">Memproses persetujuan...</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const karyawanCheckboxes = document.querySelectorAll('.karyawan-checkbox');
    const bulkActionBtn = document.getElementById('bulk-action-btn');
    const selectedCountSpan = document.getElementById('selected-count');
    const loadingModal = document.getElementById('loading-modal');

    function updateBulkActionButton() {
        const selectedCheckboxes = document.querySelectorAll('.karyawan-checkbox:checked');
        const count = selectedCheckboxes.length;
        
        selectedCountSpan.textContent = count;
        bulkActionBtn.disabled = count === 0;
    }

    function showLoading() {
        loadingModal.classList.remove('hidden');
        loadingModal.classList.add('flex');
    }

    function hideLoading() {
        loadingModal.classList.add('hidden');
        loadingModal.classList.remove('flex');
    }

    // Select all functionality
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            karyawanCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActionButton();
        });
    }

    // Individual checkbox change
    karyawanCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBulkActionButton();
            
            // Update select-all checkbox state
            if (selectAllCheckbox) {
                const allChecked = Array.from(karyawanCheckboxes).every(cb => cb.checked);
                const anyChecked = Array.from(karyawanCheckboxes).some(cb => cb.checked);
                
                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = anyChecked && !allChecked;
            }
        });
    });

    // Bulk action
    window.bulkAction = function() {
        const selectedCheckboxes = document.querySelectorAll('.karyawan-checkbox:checked');
        const selectedIds = Array.from(selectedCheckboxes).map(cb => cb.value);
        
        if (selectedIds.length === 0) {
            alert('Pilih minimal satu karyawan untuk disetujui.');
            return;
        }

        if (!confirm(`Setujui ${selectedIds.length} karyawan terpilih?`)) {
            return;
        }

        showLoading();

        fetch('{{ route("admin.approval.bulk-approve") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                karyawan_ids: selectedIds
            })
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            alert('Terjadi kesalahan jaringan.');
        });
    };

    // Approve all
    window.approveAll = function() {
        if (!confirm('Setujui SEMUA karyawan yang sedang pending? Tindakan ini tidak dapat dibatalkan.')) {
            return;
        }

        showLoading();
        
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.approval.approve-all") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    };
});
</script>
@endsection
