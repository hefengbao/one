<?php

namespace App\Filament\Resources\Post\ArticleResource\Pages;

use App\Constant\PostStatus;
use App\Filament\Resources\Post\ArticleResource;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewArticle extends ViewRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getActions(): array
    {
        /** @var User $auth */
        $auth = auth()->user();

        return [
            Action::make('back')
                ->label('返回')
                ->url(url()->previous()),
            Action::make('pinned')
                ->label('置顶')
                ->color('success')
                ->requiresConfirmation()
                ->action(fn(Post $record) => $record->update(['pinned_at' => Carbon::now()]))
                ->visible(fn(Post $record): bool => ($auth->isAdministrator() || $auth->isEditor()) && $record->status === PostStatus::Publish && !$record->isPinned()),
            Action::make('取消置顶')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn(Post $record) => $record->update(['pinned_at' => null]))
                ->visible(fn(Post $record): bool => ($auth->isAdministrator() || $auth->isEditor()) && $record->isPinned()),
            Action::make('移到回收站')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn(Post $record) => $record->update(['status' => PostStatus::Trash]))
                ->visible(fn(Post $record): bool => $record->status !== PostStatus::Trash && !$record->isPinned()),
            DeleteAction::make()->visible(fn(Post $record): bool => ($auth->isAdministrator() || $auth->isEditor() || $record->user_id == $auth->id) && $record->status === PostStatus::Trash),
        ];
    }
}
