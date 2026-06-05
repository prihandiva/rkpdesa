<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BeritaAcara;

class BeritaAcaraController extends Controller
{
    public function index(Request $request)
    {
        $query = BeritaAcara::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('materi', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%");
        }

        if ($request->has('jenis') && $request->jenis != 'semua') {
            $query->where('jenis', $request->jenis);
        }

        $perPage = $request->get('per_page', 15);
        $data = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $data->getCollection()->transform(function ($item) {
            // file_pdf might already contain 'uploads/berita_acara/'
            $pdfPath = $item->file_pdf;
            if ($pdfPath) {
                // Remove leading slash if any to prevent double slashes
                $pdfPath = ltrim($pdfPath, '/');
                // Check if it already starts with uploads/berita_acara
                if (!str_starts_with($pdfPath, 'uploads/berita_acara')) {
                    $pdfPath = 'uploads/berita_acara/' . $pdfPath;
                }
                $item->pdf_url = url($pdfPath);
            } else {
                $item->pdf_url = null;
            }
            return $item;
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $beritaAcara = BeritaAcara::with(['dusun', 'pemimpinPegawai', 'notulis1Pegawai', 'notulis2Pegawai'])->find($id);

        if (!$beritaAcara) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if ($beritaAcara->file_pdf) {
            $pdfPath = ltrim($beritaAcara->file_pdf, '/');
            if (!str_starts_with($pdfPath, 'uploads/berita_acara')) {
                $pdfPath = 'uploads/berita_acara/' . $pdfPath;
            }
            $beritaAcara->pdf_url = url($pdfPath);
        } else {
            $beritaAcara->pdf_url = null;
        }

        return response()->json([
            'success' => true,
            'data' => $beritaAcara
        ]);
    }
}
