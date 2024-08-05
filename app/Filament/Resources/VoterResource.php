<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoterResource\Pages;
use App\Models\Voter;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VoterResource extends Resource
{
    protected static ?string $model = Voter::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("ip_address")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make("votes_count")
                    ->counts("votes")
                    ->label("Votes")
                    ->sortable(),
                Tables\Columns\TextColumn::make("created_at")
                    ->sortable(),
                Tables\Columns\TextColumn::make("updated_at")
                    ->sortable()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVoters::route('/'),
        ];
    }
}
