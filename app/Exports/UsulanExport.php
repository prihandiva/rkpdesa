<?php

namespace App\Exports;

use App\Models\Usulan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsulanExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $tahun;
    protected $status;

    public function __construct($tahun = null, $status = null)
    {
        $this->tahun = $tahun;
        $this->status = $status;
    }

    public function view(): View
    {
        $userId = session('user_id');
        $currentUser = User::find($userId);

        $query = Usulan::with(['dusun', 'rw', 'rt']);

        if ($this->tahun) {
            $query->where('tahun', $this->tahun);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($currentUser && $currentUser->role == 'operator_dusun') {
            $query->where('id_dusun', $currentUser->id_dusun);
        }

        $usulans = $query->orderBy('id_dusun', 'asc')->orderBy('prioritas', 'asc')->get();
        $groupedData = $usulans->groupBy('id_dusun');

        $kades = \App\Models\Pegawai::where('posisi', 'Kepala Desa')->first();
        $sekdes = \App\Models\Pegawai::where('posisi', 'Sekretaris')->orWhere('posisi', 'Sekretaris Desa')->first();

        return view('admin.usulan.export_excel', [
            'groupedUsulans' => $groupedData,
            'kades' => $kades,
            'sekdes' => $sekdes,
            'tahun' => $this->tahun,
            'status' => $this->status
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
        $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

        // A-G columns
        $sheet->getStyle('A1:G' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:G' . $highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        // Borders mapping from row 7 (table header) down to the total
        $sheet->getStyle('A7:G' . ($highestRow - 8))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [
            'A1:G' . $highestRow => [
                'font' => [
                    'name' => 'Arial',
                    'size' => 10,
                ],
            ],
            // TITLE
            'A1:G2' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                    'size' => 12
                ]
            ],
            // TABLE HEADERS
            'A7:G7' => [
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
