<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BulkApprovalLog;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index()
    {
        $pendingKaryawan = User::where('status', 'pending')
            ->where('role', 'karyawan')
            ->with(['karyawan.ruangan', 'karyawan.profesi'])
            ->latest()
            ->paginate(20);

        return view('admin.approval.index', compact('pendingKaryawan'));
    }

    public function approve(User $user)
    {
        if ($user->status !== 'pending') {
            return redirect()->back()->with('error', 'User sudah diproses sebelumnya.');
        }

        $user->update(['status' => 'approved']);

        // Log approval
        BulkApprovalLog::create([
            'admin_id' => auth()->id(),
            'approved_count' => 1,
            'karyawan_list' => [$user->id],
            'action_type' => 'approve',
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil disetujui.');
    }

    public function reject(User $user)
    {
        if ($user->status !== 'pending') {
            return redirect()->back()->with('error', 'User sudah diproses sebelumnya.');
        }

        $user->update(['status' => 'rejected']);

        // Log rejection
        BulkApprovalLog::create([
            'admin_id' => auth()->id(),
            'approved_count' => 1,
            'karyawan_list' => [$user->id],
            'action_type' => 'reject',
        ]);

        return redirect()->back()->with('success', 'Karyawan ditolak.');
    }

    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'karyawan_ids' => 'required|array',
            'karyawan_ids.*' => 'exists:users,id',
        ]);

        $userIds = $validated['karyawan_ids'];
        
        DB::transaction(function () use ($userIds) {
            $count = User::whereIn('id', $userIds)
                ->where('status', 'pending')
                ->update(['status' => 'approved']);

            // Log bulk approval
            BulkApprovalLog::create([
                'admin_id' => auth()->id(),
                'approved_count' => $count,
                'karyawan_list' => $userIds,
                'action_type' => 'approve',
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => count($userIds) . ' karyawan berhasil disetujui.',
        ]);
    }

    public function approveAll()
    {
        $pendingUserIds = User::where('status', 'pending')
            ->where('role', 'karyawan')
            ->pluck('id')
            ->toArray();

        if (empty($pendingUserIds)) {
            return redirect()->back()->with('info', 'Tidak ada karyawan yang perlu disetujui.');
        }

        DB::transaction(function () use ($pendingUserIds) {
            $count = User::whereIn('id', $pendingUserIds)
                ->update(['status' => 'approved']);

            // Log bulk approval
            BulkApprovalLog::create([
                'admin_id' => auth()->id(),
                'approved_count' => $count,
                'karyawan_list' => $pendingUserIds,
                'action_type' => 'approve',
            ]);
        });

        return redirect()->back()->with('success', count($pendingUserIds) . ' karyawan berhasil disetujui.');
    }
}
