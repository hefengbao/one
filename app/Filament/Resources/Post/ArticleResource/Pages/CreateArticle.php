<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\PostType;
use App\Filament\Resources\Post\ArticleResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateArticle extends CreateRecord
{
    protected static string $resource = ArticleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['type'] = PostType::Article;

        if (!isset($data['excerpt'])) {
            $data['excerpt'] = Str::limit(str_replace(PHP_EOL, '', strip_tags(md_to_html($data['body']))), 160);
        }

        /*$data['published_at'] = match ($data['status']) {
            PostStatus::Published => Carbon::now(),
            PostStatus::Future => isset($data['published_at']) ?
                Carbon::createFromFormat('Y-m-d H:i:s', $data['published_at'])->format('Y-m-d H:i:s') :
                Carbon::now(),
            default => null
        };

        match ($data['status']) {
            PostStatus::Published => Log::info('Publish'),
            PostStatus::Future => Log::info('Future'),
            default => Log::info('Default')
        };*/

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
