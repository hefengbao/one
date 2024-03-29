<?php

namespace App\Filament\Resources\Post\CommentResource\Pages;

use App\Constant\CommentStatus;
use App\Filament\Resources\Post\CommentResource;
use App\Models\Comment;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewComment extends ViewRecord
{
    protected static string $resource = CommentResource::class;

    protected function getActions(): array
    {
        /** @var User $auth */
        $auth = auth()->user();

        return [
            Actions\Action::make('返回')
                ->url(url()->previous()),
            Actions\EditAction::make(),
            Actions\DeleteAction::make()
                ->visible(fn(Comment $record) => $record->status === CommentStatus::Spam),
            Action::make('标记为垃圾评论')
                ->color('danger')
                ->requiresConfirmation()
                ->action(fn(Comment $record) => $record->update(['status' => CommentStatus::Spam]))
                ->visible(fn(Comment $record) => $record->status !== CommentStatus::Spam && ($auth->isAdministrator() || $auth->isEditor())),
        ];
    }
}
