<?php

namespace App\Exports;

use App\Models\RPJM;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RPJMExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $periode;

    public function __construct($periode = null)
    {
        $this->periode = $periode;
    }

    public function view(): View
    {
        $query = RPJM::with(['masterBidang', 'masterPola'])
            ->orderBy('bidang', 'asc')
            ->orderBy('prioritas', 'asc');

        if ($this->periode) {
            $query->where('periode', $this->periode);
        }

        $rpjm = $query->get();
        $groupedData = $rpjm->groupBy('bidang');

        $kades = \App\Models\Pegawai::where('posisi', 'Kepala Desa')->first();
        $sekdes = \App\Models\Pegawai::where('posisi', 'Sekretaris')->orWhere('posisi', 'Sekretaris Desa')->first();

        return view('admin.rpjm.export_excel', [
            'groupedRpjm' => $groupedData,
            'kades' => $kades,
            'sekdes' => $sekdes,
            'periode' => $this->periode
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
        $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);

        // A-P columns
        $sheet->getStyle('A1:P' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:P' . $highestRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        
        // Borders mapping from row 8 (table header) down to the total
        $sheet->getStyle('A8:P' . ($highestRow - 12))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        return [
            'A1:P' . $highestRow => [
                'font' => [
                    'name' => 'Arial',
                    'size' => 10,
                ],
            ],
            // TITLE
            'A1:P2' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                    'size' => 12
                ]
            ],
            // TABLE HEADERS
            'A8:P10' => [
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
