<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Payment;
use App\Models\Room;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function export($type, $format)
    {
        $allowedTypes = ['reservations', 'payments', 'rooms'];
        $allowedFormats = ['csv', 'json', 'xlsx', 'pdf'];

        if (! in_array($type, $allowedTypes) || ! in_array($format, $allowedFormats)) {
            abort(404);
        }

        $data = $this->getReportData($type);
        $filename = $type . '_report_' . now()->format('Y_m_d_H_i_s');

        return match ($format) {
            'csv' => $this->exportCsv($data, $filename),
            'json' => $this->exportJson($data, $filename),
            'xlsx' => $this->exportXlsx($data, $filename),
            'pdf' => $this->exportPdf($data, $filename, ucfirst($type) . ' Report'),
        };
    }

    private function getReportData($type)
    {
        if ($type === 'reservations') {
            return Reservation::with(['user', 'room', 'payment'])
                ->latest()
                ->get()
                ->map(fn ($reservation) => [
                    'Reservation ID' => $reservation->id,
                    'Guest' => $reservation->user->name ?? 'N/A',
                    'Email' => $reservation->user->email ?? 'N/A',
                    'Room Number' => $reservation->room->room_number ?? 'N/A',
                    'Room Type' => $reservation->room->room_type ?? 'N/A',
                    'Check In' => $reservation->check_in_date,
                    'Check Out' => $reservation->check_out_date,
                    'Total Price' => $reservation->total_price,
                    'Reservation Status' => $reservation->status,
                    'Rejection Reason' => $reservation->rejection_reason ?? 'N/A',
                    'Payment Method' => $reservation->payment->payment_method ?? 'N/A',
                    'Payment Status' => $reservation->payment->status ?? 'N/A',
                ])
                ->toArray();
        }

        if ($type === 'payments') {
            return Payment::with(['reservation.user', 'reservation.room'])
                ->latest()
                ->get()
                ->map(fn ($payment) => [
                    'Payment ID' => $payment->id,
                    'Guest' => $payment->reservation->user->name ?? 'N/A',
                    'Room Number' => $payment->reservation->room->room_number ?? 'N/A',
                    'Room Type' => $payment->reservation->room->room_type ?? 'N/A',
                    'Amount' => $payment->amount,
                    'Payment Method' => $payment->payment_method,
                    'Account Name' => $payment->payment_account_name ?? 'N/A',
                    'Account Number' => $payment->payment_account_number ?? 'N/A',
                    'Bank Name' => $payment->bank_name ?? 'N/A',
                    'Reference Number' => $payment->payment_reference ?? 'N/A',
                    'Card Last Four' => $payment->card_last_four ?? 'N/A',
                    'Payment Status' => $payment->status,
                    'Payment Date' => $payment->payment_date ?? 'N/A',
                ])
                ->toArray();
        }

        return Room::latest()
            ->get()
            ->map(fn ($room) => [
                'Room ID' => $room->id,
                'Room Number' => $room->room_number,
                'Room Type' => $room->room_type,
                'Price' => $room->price,
                'Capacity' => $room->capacity,
                'Status' => $room->status,
                'Description' => $room->description ?? 'N/A',
            ])
            ->toArray();
    }

    private function exportCsv(array $data, string $filename)
    {
        return response()->streamDownload(function () use ($data) {
            $file = fopen('php://output', 'w');

            if (! empty($data)) {
                fputcsv($file, array_keys($data[0]));

                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
            }

            fclose($file);
        }, $filename . '.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function exportJson(array $data, string $filename)
    {
        return Response::make(json_encode($data, JSON_PRETTY_PRINT), 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.json"',
        ]);
    }

    private function exportXlsx(array $data, string $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        if (! empty($data)) {
            $headers = array_keys($data[0]);

            foreach ($headers as $index => $header) {
                $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
            }

            $rowNumber = 2;

            foreach ($data as $row) {
                $columnNumber = 1;

                foreach ($row as $value) {
                    $sheet->setCellValueByColumnAndRow($columnNumber, $rowNumber, $value);
                    $columnNumber++;
                }

                $rowNumber++;
            }
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = storage_path('app/' . $filename . '.xlsx');

        $writer->save($tempFile);

        return response()->download($tempFile)->deleteFileAfterSend(true);
    }

    private function exportPdf(array $data, string $filename, string $title)
    {
        $html = '<h2 style="text-align:center;">' . $title . '</h2>';
        $html .= '<table width="100%" border="1" cellspacing="0" cellpadding="6" style="border-collapse: collapse; font-size: 10px;">';

        if (! empty($data)) {
            $html .= '<thead><tr>';

            foreach (array_keys($data[0]) as $header) {
                $html .= '<th>' . e($header) . '</th>';
            }

            $html .= '</tr></thead><tbody>';

            foreach ($data as $row) {
                $html .= '<tr>';

                foreach ($row as $value) {
                    $html .= '<td>' . e($value) . '</td>';
                }

                $html .= '</tr>';
            }

            $html .= '</tbody>';
        } else {
            $html .= '<tr><td>No data available.</td></tr>';
        }

        $html .= '</table>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"',
        ]);
    }
}