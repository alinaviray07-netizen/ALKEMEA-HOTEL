<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RoomImportController extends Controller
{
    public function create()
    {
        return view('admin.rooms.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,xlsx,xls|max:5120',
        ]);

        $file = $request->file('import_file');
        $extension = strtolower($file->getClientOriginalExtension());

        $rows = $extension === 'csv'
            ? $this->readCsv($file->getRealPath())
            : $this->readExcel($file->getRealPath());

        $imported = 0;

        foreach ($rows as $row) {
            if (empty($row['room_number']) || empty($row['room_type'])) {
                continue;
            }

            Room::updateOrCreate(
                ['room_number' => $row['room_number']],
                [
                    'room_type' => $row['room_type'],
                    'price' => $row['price'] ?? 0,
                    'capacity' => $row['capacity'] ?? 1,
                    'status' => $row['status'] ?? 'available',
                    'description' => $row['description'] ?? null,
                ]
            );

            $imported++;
        }

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', $imported . ' room/s imported successfully.');
    }

    private function readCsv($path)
    {
        $rows = [];
        $file = fopen($path, 'r');

        $headers = fgetcsv($file);
        $headers = $this->normalizeHeaders($headers);

        while (($data = fgetcsv($file)) !== false) {
            $row = [];

            foreach ($headers as $index => $header) {
                $row[$header] = $data[$index] ?? null;
            }

            $rows[] = $row;
        }

        fclose($file);

        return $rows;
    }

    private function readExcel($path)
    {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $allRows = $sheet->toArray();

        if (count($allRows) < 2) {
            return [];
        }

        $headers = $this->normalizeHeaders($allRows[0]);
        $rows = [];

        for ($i = 1; $i < count($allRows); $i++) {
            $row = [];

            foreach ($headers as $index => $header) {
                $row[$header] = $allRows[$i][$index] ?? null;
            }

            $rows[] = $row;
        }

        return $rows;
    }

    private function normalizeHeaders($headers)
    {
        return array_map(function ($header) {
            return strtolower(str_replace(' ', '_', trim($header)));
        }, $headers);
    }
}