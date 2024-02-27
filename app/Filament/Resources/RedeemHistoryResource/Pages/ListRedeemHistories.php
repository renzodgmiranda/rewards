<?php

namespace App\Filament\Resources\RedeemHistoryResource\Pages;

use App\Filament\Exports\RedeemHistoryExporter;
use App\Filament\Resources\RedeemHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Exports\Enums\ExportFormat;
use Illuminate\Support\Facades\Auth;
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
                ->visible(function () {
                    $user = Auth::user();

                    if($user->hasAnyRole(['Admin'])) {
                        return true;
                    }

                    return false;
                })
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn ($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                        ->modifyQueryUsing(fn ($query) => $query->where('redeemed_status', 'Unclaimed'))
                ]), 
        ];
    }

    public function getTabs(): array
    {
        return [
            null => ListRecords\Tab::make('All')->icon('heroicon-o-bars-4'),
            'Processing' => ListRecords\Tab::make()->query(fn ($query) => $query->where('redeemed_status', 'Processing'))->icon('heroicon-o-arrow-path'),
            'Unclaimed' => ListRecords\Tab::make()->query(fn ($query) => $query->where('redeemed_status', 'Unclaimed'))->icon('heroicon-o-inbox'),
            'Redeemed' => ListRecords\Tab::make()->query(fn ($query) => $query->where('redeemed_status', 'Redeemed'))->icon('heroicon-o-check-circle'),
        ];
    }
}
   