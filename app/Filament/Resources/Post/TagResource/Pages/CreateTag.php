<?php

namespace App\Filament\Resources\Post\TagResource\Pages;

use App\Filament\Resources\Post\TagResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;
}
