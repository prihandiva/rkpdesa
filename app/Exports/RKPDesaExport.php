<?php

namespace App\Exports;

use App\Models\RKPDesa;
use App\Models\Tahun;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RKPDesaExport implements FromView, ShouldAutoSize, WithStyles
{
    public function view(): View
    {
        $tahunAktif = Tahun::where('status', 'aktif')->value('tahun') ?? date('Y');
        
        // Mengambil data RKPDesa yang disetujui, tahun aktif, dan join dengan relasinya
        $rkpdesa = RKPDesa::with(['masterBidang'])
            ->where('status', 'Disetujui')
            ->where('tahun', $tahunAktif)
            ->orderBy('prioritas', 'asc')
            ->get();

        // Mengelompokkan data berdasarkan field 'bidang' (id_bidang)
        $groupedData = $rkpdesa->groupBy('bidang');

        // Mendapatkan data Pegawai untuk Tanda Tangan
        $kades = \App\Models\Pegawai::where('posisi', 'Kepala Desa')->first();
        $sekdes = \App\Models\Pegawai::where('posisi', 'Sekretaris')->orWhere('posisi', 'Sekretaris Desa')->first();

        return view('admin.rkpdesa.export_excel', [
            'groupedRkpdesa' => $groupedData,
            'tahunAktif' => $tahunAktif,
            'kades' => $kades,
            'sekdes' => $sekdes
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Mendapatkan baris terakhir yang ada isinya
        $highestRow = $sheet->getHighestRow();

        // Mengatur Default Font ke Arial ukuran 10 untuk seluruh sheet
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
        $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

        // Styling dasar untuk seluruh sheet
        $sheet->getStyle('A1:N' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:N' . $highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        // Mendapatkan baris terakhir yang ada isinya (bisa diestimasi atau dibiarkan excel auto)
        $highestRow = $sheet->getHighestRow();
        
        // Border untuk tabel (Asumsi tabel mulai dari baris 5)
        // Table content typically spans to $highestRow - some lines for signatures, but Excel can apply borders exactly if we pinpoint it.
        // In our blade view, grand total is usually near the end of the table. Let's just border A5:N(highestRow-10) safely, 
        // but it's easier to handle borders inside blade or just let it calculate highestRow. Wait, the simplest way is to style A5:L (since it's 12 columns, A-L).
        $sheet->getStyle('A5:L' . ($highestRow - 12))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [
            // Mengatur font default untuk seluruh sheet ke Arial 10
            'A1:L' . $highestRow => [
                'font' => [
                    'name' => 'Arial',
                    'size' => 10,
                ],
            ],
            // Center text untuk header title (Baris 1-3)
            'A1:L3' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                    'size' => 12
                ]
            ],
            // Header Tabel
            'A5:L6' => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ],
        ];
    }
}
