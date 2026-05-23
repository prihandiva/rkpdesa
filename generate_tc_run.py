# -*- coding: utf-8 -*-
# BAGIAN 5: Runner utama — menggabungkan semua bagian dan meng-generate file Excel

import sys, os
sys.path.insert(0, r'd:\laragon\www\RKPDesa')

# Import semua bagian
exec(open(r'd:\laragon\www\RKPDesa\generate_testcase.py', encoding='utf-8').read())
exec(open(r'd:\laragon\www\RKPDesa\generate_tc_data1.py', encoding='utf-8').read())
exec(open(r'd:\laragon\www\RKPDesa\generate_tc_data2.py', encoding='utf-8').read())
exec(open(r'd:\laragon\www\RKPDesa\generate_tc_data3.py', encoding='utf-8').read())

# ══════════════════════════════════════════════════════════════
# BUAT SHEET PER MODUL
# ══════════════════════════════════════════════════════════════

SHEET_DATA = [
    ("Login & Logout",                    DATA_LOGIN),
    ("Dashboard",                         DATA_DASHBOARD),
    ("Profil & Pengaturan",               DATA_PROFIL),
    ("Notifikasi",                        DATA_NOTIFIKASI),
    ("RPJM Desa",                         DATA_RPJM),
    ("Usulan",                            DATA_USULAN),
    ("RKP Desa",                          DATA_RKP),
    ("Berita Acara",                      DATA_BA),
    ("Verifikasi",                        DATA_VERIF),
    ("Manajemen Tahun",                   DATA_TAHUN),
    ("Manajemen Pengguna",                DATA_PENGGUNA),
    ("Master Bidang",                     DATA_BIDANG),
    ("Master Sumber Dana",                DATA_SUMBER_DANA),
    ("Master Pola Pelaksanaan",           DATA_POLA),
    ("Master Dusun",                      DATA_DUSUN),
    ("Master RW",                         DATA_RW),
    ("Master RT",                         DATA_RT),
    ("Master Pegawai",                    DATA_PEGAWAI),
    ("Monitoring Sistem",                 DATA_MONITORING),
    ("Pemulihan Data",                    DATA_PEMULIHAN),
]

for sheet_name, data_list in SHEET_DATA:
    ws = wb.create_sheet(sheet_name)
    write_info_header(ws, sheet_name)
    write_col_header(ws, row=7)
    set_col_widths(ws, DEFAULT_WIDTHS)
    ws.row_dimensions[7].height = 22

    r = 8
    for row_data in data_list:
        (page, tc_id, tc_type, scenario, tc_name,
         pre_cond, steps, data_val, expected, post_cond) = row_data

        write_tc_row(ws, r, page, tc_id, tc_type, scenario, tc_name,
                     pre_cond, steps, data_val, expected, post_cond)

        # Estimasi tinggi baris berdasarkan jumlah baris teks
        max_lines = max(
            len(str(steps).split('\n')),
            len(str(expected).split('\n')),
            2
        )
        ws.row_dimensions[r].height = max(40, max_lines * 14)
        r += 1

    print(f"  Sheet '{sheet_name}' selesai ({r-8} baris)")

# ══════════════════════════════════════════════════════════════
# SIMPAN FILE
# ══════════════════════════════════════════════════════════════
wb.save(OUTPUT_PATH)
print(f"\n[OK] File Excel berhasil disimpan ke:\n   {OUTPUT_PATH}")
print(f"   Total sheet: {len(wb.sheetnames)}")
print(f"   Sheet: {', '.join(wb.sheetnames)}")
