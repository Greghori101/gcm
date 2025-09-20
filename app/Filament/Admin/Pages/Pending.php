<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;

class Pending extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.admin.pages.pending';
}
