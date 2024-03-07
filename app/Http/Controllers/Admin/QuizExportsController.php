<?php

namespace App\Http\Controllers\Admin;

use App\Models\Quiz;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class QuizExportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index(Request $request, Quiz $quiz)
    {
        $users = $quiz->users()->where('quiz_id', $quiz->id)
            ->get();

        $spreadsheet = new Spreadsheet();
        $activeWorksheet = $spreadsheet->getActiveSheet();

        $activeWorksheet->setCellValue('A1', 'Nom');
        $activeWorksheet->setCellValue('B1', 'Login');
        $activeWorksheet->setCellValue('C1', 'Date');
        $activeWorksheet->setCellValue('D1', 'Role');
        $activeWorksheet->setCellValue('E1', 'Plateau');
        $activeWorksheet->setCellValue('F1', 'Objectif');
        $activeWorksheet->setCellValue('G1', 'Note');
        $activeWorksheet->setCellValue('H1', 'Nb Questions');
        $activeWorksheet->setCellValue('I1', 'Nb Questions Rater');
        $activeWorksheet->setCellValue('J1', 'Taux Questions Rater');

        foreach ($users as $index => $user) {
            $tauxRater = ($user->questions()->where('rater', 1)->count())
                ? $user->questions()->where('rater', 1)->count() / $quiz->questions()->count() * 100
                : 0;

            $activeWorksheet->setCellValue('A' . $index + 2, $user->name);
            $activeWorksheet->setCellValue('B' . $index + 2, $user->username);
            $activeWorksheet->setCellValue('C' . $index + 2, $user->pivot->updated_at);
            $activeWorksheet->setCellValue('D' . $index + 2, $user->roles[0]->display_name);
            $activeWorksheet->setCellValue('E' . $index + 2, $user->segment->name ?? '');
            $activeWorksheet->setCellValue('F' . $index + 2, $quiz->objective);
            $activeWorksheet->setCellValue('G' . $index + 2, $user->pivot->score ?? 'N/A');
            $activeWorksheet->setCellValue('H' . $index + 2, $quiz->questions()->count());
            $activeWorksheet->setCellValue('I' . $index + 2, $user->questions()->where('rater', 1)->count());
            $activeWorksheet->setCellValue('J' . $index + 2, number_format($tauxRater, 2).'%');
        }

        $file_name = 'EXTRACTION_' . strtoupper($quiz->name) . '.xlsx';
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename={$file_name}");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
