<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('owner_name')
                            ->required(),
                        TextInput::make('company_name')
                            ->required(),
                        TextInput::make('contact')
                            ->default(null),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->required(),
                        TextInput::make('address')
                            ->default(null),
                        TextInput::make('status')
                            ->default(0)
                            ->required(),
                        DatePicker::make('expire_date'),
                        FileUpload::make('logo')
                            ->default(null),
                    ]),

                Textarea::make('play_store_link')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('app_store_link')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
