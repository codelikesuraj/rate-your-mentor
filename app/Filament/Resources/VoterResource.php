<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoterResource\Pages;
use App\Filament\Resources\VoterResource\RelationManagers;
use App\Models\Voter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VoterResource extends Resource
{
    protected static ?string $model = Voter::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
