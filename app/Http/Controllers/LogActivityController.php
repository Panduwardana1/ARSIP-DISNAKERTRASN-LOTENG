<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogActivityController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'role' => $request->string('role')->toString(),
            'order' => $request->string('order', 'latest')->toString(),
        ];

        $filters['order'] = $filters['order'] === 'oldest' ? 'oldest' : 'latest';
        $orderDirection = $filters['order'] === 'oldest' ? 'asc' : 'desc';

        $activities = Activity::query()
            ->with('causer')
            ->where('log_name', 'activity')
            ->when($filters['role'], fn ($query, $role) => $query->whereJsonContains('properties->roles', $role))
            ->orderBy('created_at', $orderDirection)
            ->paginate(10)
            ->withQueryString();

        return view('cruds.logs.log', [
            'activities' => $activities,
            'filters' => $filters,
        ]);
    }

    public function destroy(Activity $activity)
    {
        if ($activity->log_name !== 'activity') {
            abort(403, 'Tidak dapat menghapus log ini.');
        }

        $activity->delete();

        return redirect()
            ->route('sirekap.logs.index')
            ->with('success', 'Log berhasil dihapus.');
    }

    public function clear(Request $request)
    {
        Activity::where('log_name', 'activity')->delete();

        return redirect()
            ->route('sirekap.logs.index')
            ->with('success', 'Semua log aktivitas berhasil dibersihkan.');
    }
}
