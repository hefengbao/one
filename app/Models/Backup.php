<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Sushi\Sushi;

/**
 * https://laraveldaily.com/post/filament-load-table-data-from-3rd-party-api
 */
class Backup extends Model
{
    use Sushi;

    public function getRows(): array
    {
        $files = Storage::allFiles(config('app.name'));
        $files = collect($files)->sortDesc()->map(function ($item) {
            $strs1 = explode('/', $item);
            $strs2 = explode('-', $strs1[1]);

            return [
                'datetime' => Carbon::create(...$strs2)->format('Y-m-d H:i:s'),
                'name' => $strs1[1],
            ];
        });

        return $files->all();
    }
}
