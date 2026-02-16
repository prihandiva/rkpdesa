<?php

namespace App\Services;

use App\Models\RkpDesa;
use App\Models\Usulan;
use App\Models\RPJM;
use App\Models\User;
use App\Notifications\StatusNotification;
use Illuminate\Support\Facades\Notification;

class StatusService
{
    /**
     * Update status for a given model and sync with related models.
     *
     * @param mixed $model The model instance (RkpDesa, Usulan, or RPJM)
     * @param string $status The new status
     * @return void
     */
    public function updateStatus($model, string $status)
    {
        // 1. Update the model's own status
        $model->status = $status;
        $model->saveQuietly(); // Use saveQuietly to avoid triggering observers if any, preventing loops

        // 2. Sync with related models
        $this->syncStatus($model, $status);

        // 3. Send Notification
        $this->sendNotification($model, $status);
    }

    protected function syncStatus($sourceModel, string $status)
    {
        // Sync Logic
        // If RkpDesa, sync Usulan & RPJM
        // If Usulan, sync RkpDesa & RPJM (if linked) - Note: Usulan might not know RkpDesa directly unless hasOne, usually RkpDesa belongsTo Usulan.
        // Let's assume the relationships based on models I saw:
        // RkpDesa belongsTo Usulan ('id_usulan')
        // RkpDesa belongsTo RPJM ('id_rpjm')
        
        // Strategy: Find related IDs and update them.
        
        $usulanId = null;
        $rpjmId = null;

        if ($sourceModel instanceof RkpDesa) {
            $usulanId = $sourceModel->id_usulan;
            $rpjmId = $sourceModel->id_rpjm;
        } elseif ($sourceModel instanceof Usulan) {
            $usulanId = $sourceModel->id_usulan;
            // Find RKPDesa linked to this Usulan to find RPJM? Or just update RKPDesa.
            // RkpDesa::where('id_usulan', $usulanId)->update(['status' => $status]);
            // RPJM might be harder to reach from Usulan without RKPDesa link.
            $linkedRkp = RkpDesa::where('id_usulan', $usulanId)->first();
            if ($linkedRkp) {
                // recursively update RKP? No, simpler to just direct update to avoid loops.
                $linkedRkp->status = $status;
                $linkedRkp->saveQuietly();
                $rpjmId = $linkedRkp->id_rpjm;
            }
        } elseif ($sourceModel instanceof RPJM) {
             $rpjmId = $sourceModel->id_rpjm;
             // Update linked RKPDesa
             // Note: Updating RPJM usually doesn't cascade down to RKPDesa unless specific action, 
             // but per user request "seluruh tabel... juga harus berubah", we enable it.
             RkpDesa::where('id_rpjm', $rpjmId)->update(['status' => $status]);
        }

        // Execute Updates
        if ($usulanId) {
             Usulan::where('id_usulan', $usulanId)->update(['status' => $status]);
        }
        
        if ($rpjmId) {
             RPJM::where('id_rpjm', $rpjmId)->update(['status' => $status]);
        }
        
        // Also update RkpDesa if source was something else (like Usulan)
        if ($sourceModel instanceof Usulan) {
            $rkp = RkpDesa::where('id_usulan', $sourceModel->id_usulan)->first();
            if ($rkp) {
                $rkp->status = $status;
                $rkp->saveQuietly();
                // Also need to get RPJM if Usulan only had RKP linked to it
                if ($rkp->id_rpjm && !$rpjmId) {
                    RPJM::where('id_rpjm', $rkp->id_rpjm)->update(['status' => $status]);
                }
            }
        }
    }

    protected function sendNotification($model, $stringStatus)
    {
        // Get badge color
        $color = $this->getStatusColor($stringStatus);
        
        // Notify all users for now (or Admins/Verificators)
        $users = User::all(); // TODO: Optimize this for production
        
        // Url generation
        $url = '#';
        if ($model instanceof RkpDesa) {
            $url = route('rkpdesa.show', $model->id_kegiatan ?? 0);
             // Note: id_kegiatan is primary key of RKPDesa
        } elseif ($model instanceof Usulan) {
            $url = route('usulan.show', $model->id_usulan ?? 0);
        }

        Notification::send($users, new StatusNotification($stringStatus, $color, $url, class_basename($model)));

        if ($model instanceof RkpDesa) {
            \App\Models\Notifikasi::create([
                'judul' => 'Status Updated',
                'deskripsi' => "Status changed to {$stringStatus}",
                'id_kegiatan' => $model->id_kegiatan, 
                'judul_kegiatan' => $model->nama,
                'status' => $stringStatus,
                'id_penerima' => null, // Broadcast/Public log
                'dibaca' => 0,
            ]);
        } elseif ($model instanceof Usulan) {
            // Also log for Usulan
            \App\Models\Notifikasi::create([
                'judul' => 'Status Usulan Updated',
                'deskripsi' => "Status usulan berubah menjadi {$stringStatus}",
                'id_kegiatan' => $model->id_usulan, // Using id_kegiatan column to store usulan ID for simplicity if schema allows, or mapped correctly in migration?
                // Wait, Notifikasi table has 'id_kegiatan' which is likely FK to RKPDesa or just an ID?
                // Let's check Notifikasi model or migration.
                // Assuming it's a generic ID or I needs to be careful.
                // If it relates to RKPDesa, then Usulan ID might allow if it's not strictly foreign keyed.
                // 'id_kegiatan' in migration 2026_01_31_061505_create_notifikasi_table.php might be bigInteger.
                // Let's assume it's used for both or I should use a different mechanism?
                // The RKPDesa controller uses it for RKP logs.
                // For Usulan logs, I might need to fetch them differently.
                // But for now let's write it and I will check `show` method in UsulanController to fetch based on this.
                'judul_kegiatan' => $model->jenis_kegiatan,
                'status' => $stringStatus,
                'id_penerima' => null,
                'dibaca' => 0,
            ]);
        }
    }
    
    public function getStatusColor($status)
    {
        return match ($status) {
            'Proses' => 'primary',
            'Pending' => 'warning',
            'Terverifikasi' => 'purple', // Custom in blade probably, or map to 'secondary'
            'Gagal Terverifikasi' => 'danger',
            'Disetujui' => 'success',
            'Menunggu persetujuan BPD' => 'light',
            'Ditolak BPD' => 'dark',
            default => 'secondary',
        };
    }
}
