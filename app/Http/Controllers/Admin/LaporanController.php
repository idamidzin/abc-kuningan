<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;
use App\Models\Booking;
use App\Models\Pembayaran;

class LaporanController extends Controller
{
    public function index()
    {
    	return view('pages.admin.laporan.index');
    }

    public function cetak(Request $request)
    {
    	$tanggal_awal=date('Y-m-d', strtotime($request->tahun.'-'.$request->bulan.'-01'));
		$tanggal_akhir=date('Y-m-t', strtotime($request->tahun.'-'.$request->bulan.'-01'));

		$filter_tanggal = rangeDate($tanggal_awal, $tanggal_akhir);

		if ($request->jenis == 'non-member') {
			$jenis = 'Booking';
		}else if ($request->jenis == 'member') {
			$jenis = 'Member';
		}else{
			$jenis = 'Diklat';
		}

		$transaksi = Booking::join('paket', 'paket.id', '=', 'booking.paket_id')
								->whereBetween('booking.tanggal_mulai',[$tanggal_awal, $tanggal_akhir])
								->where('paket.for_use', $request->jenis)
								->get();

		$spreadsheet = new Spreadsheet();

		$styleTextCenter = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

		$styleTextRight = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
            ],
        ];

        $styleBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getColumnDimension('A')->setWidth(3);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->mergeCells("A2:F2");
        $sheet->mergeCells("A3:F3");
        $sheet->mergeCells("A4:F4");
        $sheet->mergeCells("A5:F5");

        $sheet->setCellValue('A2', 'REKAP TRANSAKSI');
        $sheet->setCellValue('A3', strtoupper('Anrimusthi Badminton Centre Kuningan'));
        $sheet->setCellValue('A4', strtoupper($jenis));
        $sheet->setCellValue('A5', 'PERIODE '.$filter_tanggal);

        $sheet->getStyle('A7:F7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('cacaca');
        $sheet->getStyle('A7:F7')->getFont()->setBold( true );
        $sheet->setCellValue('A7', 'No');
        $sheet->setCellValue('B7', 'Nama');
        $sheet->setCellValue('C7', 'Tanggal Mulai');
        $sheet->setCellValue('D7', 'Tanggal Selesai');
        $sheet->setCellValue('E7', 'Lapang');
        $sheet->setCellValue('F7', 'Total Cash (Rp)');
    	$i = 8;
   		$no = 1;

   		$jumlah_total = [];
		foreach ($transaksi as $row) {
			$sheet->setCellValue('A'.$i, $no++);
            $sheet->setCellValue('B'.$i, $row->User->nama_lengkap);
            $sheet->setCellValue('C'.$i, tanggalIndo($row->tanggal_mulai));
	        $sheet->setCellValue('D'.$i, tanggalIndo($row->tanggal_selesai));
	        $sheet->setCellValue('E'.$i, $row->Lapang->nama);
	        $sheet->setCellValue('F'.$i, rupiah($row->harga));

	        $jumlah_total [] = $row->harga;

            $i++;
		}

		$rowCount = count($transaksi)+8;

		$sheet->mergeCells('A'.$rowCount.':E'.$rowCount);
		$sheet->getStyle('A'.$rowCount)->applyFromArray($styleTextCenter);
        $sheet->setCellValue('A'.$rowCount, 'JUMLAH TOTAL');
        $sheet->setCellValue('F'.$rowCount, rupiah(array_sum($jumlah_total)));

		$i = $i;
		$sheet->getStyle('A7:F'.$i)->applyFromArray($styleBorder);
		$sheet->getStyle('A7:F7')->applyFromArray($styleTextCenter);

		$sheet->getStyle('E8:E'.$rowCount)->applyFromArray($styleTextCenter);
		$sheet->getStyle('F8:F'.$rowCount)->applyFromArray($styleTextRight);

        $sheet->getStyle('A2:F5')->applyFromArray($styleTextCenter);

        $i +=4;
        $sheet->mergeCells("E$i:F$i");
        $sheet->setCellValue('E'.$i, 'Kuningan, '.tanggalIndo(now()));
        $i +=1;
        $sheet->mergeCells("E$i:F$i");
        $sheet->setCellValue('E'.$i, 'Pimpinan ABC');
        $i +=3;
        $sheet->mergeCells("E$i:F$i");
        $sheet->setCellValue('E'.$i, 'Yusuf, S.Kom');

        $namafile = 'laporan-transaksi-'.strtolower($jenis).'-'.bulanIndo($request->bulan).'-'.$request->tahun.'.xlsx';
        $response = response()->streamDownload(function() use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$namafile.'"');
        $response->send();
    }
}
