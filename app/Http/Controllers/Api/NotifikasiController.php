<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    /**
     * Get all notifications for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get notifications that are targeted to the user or broadcast (id_penerima is null)
        $notifikasis = Notifikasi::where(function($query) use ($user) {
                $query->whereRaw('FIND_IN_SET(?, id_penerima)', [$user->id_user])
                      ->orWhereNull('id_penerima');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifikasis
        ]);
    }

    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();

        // We can't easily update FIND_IN_SET efficiently in raw SQL without updating all, 
        // but typically in this schema `dibaca` is a boolean. 
        // Since `dibaca` in the original schema is just a tinyint, we will update all that match.
        // Wait, if it's broadcast (null), updating it to read will affect others. 
        // In SIPDES, usually we just update the ones specifically for the user.
        
        Notifikasi::whereRaw('FIND_IN_SET(?, id_penerima)', [$user->id_user])
                  ->where('dibaca', false)
                  ->update(['dibaca' => true, 'status' => 'dibaca']);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi berhasil ditandai sebagai telah dibaca'
        ]);
    }
}
