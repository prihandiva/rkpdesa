<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $user = auth()->user() ?? \App\Models\User::find(session('user_id'));
        
        if ($user) {
            // Check if it's a UUID (Laravel Notif) or integer/custom ID (custom Notifikasi)
            if (strlen($id) > 10 && !is_numeric($id)) {
                $notification = $user->unreadNotifications->where('id', $id)->first();
                if ($notification) {
                    $notification->markAsRead();
                    return redirect($notification->data['url'] ?? '#');
                }
            } else {
                $n = \App\Models\Notifikasi::find($id);
                if ($n) {
                    if ($n->id_penerima) {
                        $arr = explode(',', $n->id_penerima);
                        if (($key = array_search($user->id_user, $arr)) !== false) {
                            unset($arr[$key]);
                            $n->id_penerima = implode(',', $arr) ?: null;
                            if (!$n->id_penerima) {
                                $n->dibaca = 1;
                            }
                            $n->save();
                        }
                    } else {
                        $n->dibaca = 1;
                        $n->save();
                    }
                    
                    // Route logic for custom notifications
                    if (str_contains($n->id_kegiatan, 'rpjm_')) {
                        return redirect()->route('rpjm.show', str_replace('rpjm_', '', $n->id_kegiatan));
                    } elseif (str_contains($n->id_kegiatan, 'rkpdesa_')) {
                        return redirect()->route('rkpdesa.show', str_replace('rkpdesa_', '', $n->id_kegiatan));
                    } elseif (str_contains($n->id_kegiatan, 'beritaacara_')) {
                        return redirect()->route('berita-acara.show', str_replace('beritaacara_', '', $n->id_kegiatan));
                    } else {
                        return redirect()->route('usulan.show', $n->id_kegiatan);
                    }
                }
            }
        }
        
        return back();
    }

    public function markAllAsRead()
    {
        $user = auth()->user() ?? \App\Models\User::find(session('user_id'));
        
        if ($user) {
            $user->unreadNotifications->markAsRead();
            
            // Mark custom notifications read
            $notifs = \App\Models\Notifikasi::where(function($q) use ($user){
                 $q->whereRaw('FIND_IN_SET(?, id_penerima)', [$user->id_user])
                   ->orWhereNull('id_penerima');
            })->where('dibaca', 0)->get();
            
            foreach($notifs as $n) {
                if ($n->id_penerima) {
                    $arr = explode(',', $n->id_penerima);
                    if (($key = array_search($user->id_user, $arr)) !== false) {
                        unset($arr[$key]);
                        $n->id_penerima = implode(',', $arr) ?: null;
                    }
                    if (empty($n->id_penerima)) {
                        $n->dibaca = 1;
                    }
                } else {
                    $n->dibaca = 1;
                }
                $n->save();
            }
        }
        
        return back();
    }
}
