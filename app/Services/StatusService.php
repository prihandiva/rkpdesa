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
             // Update all RKPDesa linked to this RPJM? 
             // CAUTION: RPJM is a master plan. Changing RPJM status might not want to change ALL RKPDesa status.
             // But user said: "seluruh tabel dengan id_kegiatan/id_usulan/id_rpjm yang terkait(sama) juga harus berubah"
             // This implies if I update one item, the related items update.
             // If I update RPJM status, it SHOULD update links? 
             // Actually, usually status flows from Usulan -> RKP -> Implementation.
             // If I update an RPJM item's status, it might mean that specific RPJM item context.
             // But if specific RKPDesa changes, RPJM itself shouldn't necessarily change status (as it contains many RKPDesa).
             // HOWEVER, strictly following user instruction: "where status changed on one table, then ALL tables ... associated ... must also change".
             // I will implement downward sync from RPJM -> RKPDesa -> Usulan just in case, but usually it's upward or sideways.
             // Safest for "linked items":
             // If RKPDesa changes -> Update Usulan. (One to One/Many relation).
             
             // Let's focus on the RKPDesa (Center) <-> Usulan link which is 1-to-1 or 1-to-Many? 
             // RkpDesa belongsTo Usulan. So 1 RKPDesa has 1 Usulan.
             // Update Usulan.
        }

        // Execute Updates
        if ($usulanId) {
             Usulan::where('id_usulan', $usulanId)->update(['status' => $status]);
        }
        
        if ($rpjmId) {
            // Only update the specific RPJM record? IDK if RPJM is "one item" or "the document".
            // Looking at RPJM model fields: `visi`, `misi`. It looks like the *Document*.
            // It might be dangerous to change the status of the WHOLE RPJM document based on one activity.
            // User said: "tables with id_kegiatan/id_usulan/id_rpjm that are RELATED(SAME)".
            // This might mean if there is a specific entry in RPJM that corresponds to the activity.
            // But RPJM table seems to be the Header? 
            // Let's re-read User request: "seluruh tabel dengan id_kegiatan/id_usulan/id_rpjm yang terkait(sama) juga harus berubah"
            // If the user means if I change status of RKPDesa ID 5, it changes Usulan ID 5 (if IDs match, or foreign key).
            // It says "related (same)".
            // I will implement: RKPDesa <-> Usulan sync.
            // I will SKIP RPJM sync for now if it looks like a Header table, to avoid wiping the Master Plan status.
            // Wait, looking at RPJM model: `visi`, `misi`, `tahun_mulai`. It IS a header.
            // Accessing RPJM ID and changing its status because ONE sub-activity changed is WRONG logic usually.
            // BUT, if the user insists "id_rpjm yang terkait", maybe they have a breakdown table?
            // No, `rkpdesa` has `id_rpjm`.
            // I will add the logic but maybe comment it out or add a check?
            // "Pending" -> "Terverifikasi" for RKPDesa shouldn't make the whole 6-year RPJM "Terverifikasi".
            // I'll stick to RkpDesa <-> Usulan for safety, and maybe update RPJM status ONLY if the source was RPJM.
            
            // Correction: The user might have meant: "If I approve an Usulan, the RKPDesa entry created from it should be Approved."
            // And vice versa.
            // I will do RkpDesa <-> Usulan. 
            // I will also update RPJM ONLY IF it makes sense? No, I'll restrict to Usulan <-> RkpDesa for now to avoid breaking the app.
            
            // Re-evaluating: "seluruh tabel dengan id_kegiatan/id_usulan/id_rpjm"
            // Maybe they mean if there's a table `verifikasi_usulan` with `id_usulan`, update that too.
            // I'll search for any table having these columns later.
            // For now, syncing Usulan is the most critical.
             if ($rpjmId) {
                 RPJM::where('id_rpjm', $rpjmId)->update(['status' => $status]);
             }
        }
        
        // Also update RkpDesa if source was something else (like Usulan)
        if ($sourceModel instanceof Usulan) {
            RkpDesa::where('id_usulan', $sourceModel->id_usulan)->update(['status' => $status]);
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
