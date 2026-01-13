<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                    TextInput::make('category_name')
                        ->required(),
                    TextInput::make('slug')
                        ->required(),
                ]),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('parentID')
                    ->nullable()
                    ->numeric(),
            ]);
    }
}
