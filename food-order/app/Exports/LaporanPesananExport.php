<?php

namespace App\Exports;

use App\Models\Pesanan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanPesananExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles, WithTitle
{
    public function __construct(
        private readonly ?int $restoranId,
        private readonly int $bulan,
        private readonly int $tahun,
    ) {
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        $query = Pesanan::query()
            ->with([
                'restoran:id_restoran,nama_restoran',
                'pelanggan:id,name',
                'detailPesanan:id_pesanan,id_menu,jumlah',
                'detailPesanan.menu:id_menu,nama_menu',
            ])
            ->whereMonth('tanggal_pesan', $this->bulan)
            ->whereYear('tanggal_pesan', $this->tahun)
            ->orderBy('tanggal_pesan');

        if ($this->restoranId) {
            $query->where('id_restoran', $this->restoranId);
        }

        return $query->get()->values()->map(function (Pesanan $pesanan, int $index): array {
            $items = $pesanan->detailPesanan
                ->map(fn ($detail) => ($detail->menu?->nama_menu ?? 'Menu') . ' x' . (int) $detail->jumlah)
                ->implode(', ');

            return [
                $index + 1,
                $pesanan->kode_pesanan,
                optional($pesanan->tanggal_pesan)->format('d-m-Y H:i') ?? '-',
                $pesanan->restoran?->nama_restoran ?? '-',
                $pesanan->pelanggan?->name ?? '-',
                $items !== '' ? $items : '-',
                strtoupper((string) $pesanan->status),
                (float) $pesanan->total_harga,
                (float) $pesanan->ongkir,
                (float) $pesanan->diskon,
                (float) $pesanan->grand_total,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Pesanan',
            'Tanggal Pesan',
            'Restoran',
            'Pelanggan',
            'Item Pesanan',
            'Status',
            'Total Harga',
            'Ongkir',
            'Diskon',
            'Grand Total',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE5E7EB');

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return sprintf('Laporan %02d-%d', $this->bulan, $this->tahun);
    }
}
