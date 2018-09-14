<?php
/**
 * Created by PhpStorm.
 * User: diudiu
 * Date: 2018/9/14
 * Time: 9:35
 */

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportController implements WithHeadings, FromCollection, Responsable
{
    use Exportable;
    private $rs;
    private $fileName;
    private $header;

    public function __construct($rs, $filename, $header = array())
    {
        $this->rs = $rs;
        $this->fileName = $filename;
        $this->header = $header;
    }

    public function collection()
    {
        return $this->rs;
    }

    public function headings(): array
    {
        return $this->header;
    }
}