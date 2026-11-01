<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        if (isset($_GET['range'])) {
            $range = $_GET['range'];
        };
        if (isset($_GET['to'])) {
            $to = $_GET['to'];
        }
        if (isset($_GET['from'])) {
            $from = $_GET['from'];
        }

        $report = null;
        $reportData = new Report();
        $settings = Setting::firstOrCreate([]);

        if ($range) {
            if ($range == 'daily') {
                $report = $reportData->getReport('daily', null, null);
            } elseif ($range == 'weekly') {
                $report = $reportData->getReport('weekly', null, null);
            } elseif ($range == 'monthly') {
                $report = $reportData->getReport('monthly', null, null);
            } elseif ($range == 'yearly') {
                $report = $reportData->getReport('yearly', null, null);
            } elseif ($range == 'custom') {
                $report = $reportData->getReport('custom', $to, $from);
            }
        }

        return view('reports.index', compact('report', 'settings'));
    }

    public function download(Request $request)
    {
        $range = $request->get('range', 'daily');
        $to = $request->get('to', null);
        $from = $request->get('from', null);

        $report = null;
        $reportData = new Report();
        $settings = Setting::firstOrCreate([]);

        if ($range) {
            if ($range == 'daily') {
                $report = $reportData->getReport('daily', null, null);
            } elseif ($range == 'weekly') {
                $report = $reportData->getReport('weekly', null, null);
            } elseif ($range == 'monthly') {
                $report = $reportData->getReport('monthly', null, null);
            } elseif ($range == 'yearly') {
                $report = $reportData->getReport('yearly', null, null);
            } elseif ($range == 'custom') {
                $report = $reportData->getReport('custom', $to, $from);
            }
        }

        $html = view('reports.download', compact('report', 'settings', 'range', 'to', 'from'))->render();
        $filename = 'report-' . $range . '-' . date('Y-m-d') . '.html';
        
        // Save to temporary file and download
        $tempPath = storage_path('app/temp/' . $filename);
        if (!is_dir(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }
        
        file_put_contents($tempPath, $html);
        
        return response()->download($tempPath, $filename, [
            'Content-Type' => 'text/html; charset=utf-8',
        ])->deleteFileAfterSend(true);
    }
}
