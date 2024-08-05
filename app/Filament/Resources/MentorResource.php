<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MentorResource\Pages;
use App\Models\Mentor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MentorResource extends Resource
{
    protected static ?string $model = Mentor::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->unique()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->circular()
                    ->grow(false)
                    ->defaultImageUrl(fn ($record) => "https://robohash.org/{$record->name}"),
                Tables\Columns\TextColumn::make("name")
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
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMentors::route('/'),
        ];
    }
}
