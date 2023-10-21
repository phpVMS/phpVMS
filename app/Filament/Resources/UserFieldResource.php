<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserFieldResource\Pages;
use App\Filament\Resources\UserFieldResource\RelationManagers;
use App\Models\UserField;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserFieldResource extends Resource
{
    protected static ?string $model = UserField::class;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->string()->required(),
                Forms\Components\TextInput::make('description')->string(),
                Forms\Components\Toggle::make('required')->offIcon('heroicon-m-x-circle')->offColor('danger')->onIcon('heroicon-m-check-circle')->onColor('success'),
                Forms\Components\Toggle::make('show_on_registration')->offIcon('heroicon-m-x-circle')->offColor('danger')->onIcon('heroicon-m-check-circle')->onColor('success'),
                Forms\Components\Toggle::make('private')->label('Private (Only Visible To Admins)')->offIcon('heroicon-m-x-circle')->offColor('danger')->onIcon('heroicon-m-check-circle')->onColor('success'),
                Forms\Components\Toggle::make('active')->offIcon('heroicon-m-x-circle')->offColor('danger')->onIcon('heroicon-m-check-circle')->onColor('success'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\IconColumn::make('required')->color(fn ($state) => $state ? 'success' : 'danger')->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('show_on_registration')->color(fn ($state) => $state ? 'success' : 'danger')->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('private')->label('Private (Only Visible To Admins)')->color(fn ($state) => $state ? 'success' : 'danger')->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),
                Tables\Columns\IconColumn::make('active')->color(fn ($state) => $state ? 'success' : 'danger')->icon(fn ($state) => $state ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle'),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageUserFields::route('/'),
        ];
    }
}
