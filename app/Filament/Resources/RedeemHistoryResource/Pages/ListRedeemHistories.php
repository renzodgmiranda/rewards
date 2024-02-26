<?php

namespace App\Filament\Resources\RedeemHistoryResource\Pages;

use App\Filament\Exports\RedeemHistoryExporter;
use App\Filament\Resources\RedeemHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Exports\Enums\ExportFormat;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListRedeemHistories extends ListRecords
{
    protected static string $resource = RedeemHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                        ->modifyQueryUsing(fn ($query) => $query->where('redeemed_status', 'Unclaimed'))
                ]), 
        ];
    }
}
   