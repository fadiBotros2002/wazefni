<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(function () {
                        return DB::table('users')->pluck('name', 'user_id');
                    })
                    ->searchable()
                    ->required(),


                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),


                Forms\Components\TextInput::make('type')
                    ->required(),


                Forms\Components\Textarea::make('description')
                    ->required(),


                Forms\Components\Textarea::make('requirement')
                    ->required(),


                Forms\Components\TextInput::make('location')
                    ->required(),


                Forms\Components\TextInput::make('time')
                    ->required(),


                Forms\Components\TextInput::make('salary')
                    ->required(),


                Forms\Components\TextInput::make('experience_year')
                    ->numeric()
                    ->required(),


                Forms\Components\DateTimePicker::make('posted_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('posted_at')
                    ->label('Posted At')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),  
        ];
    }
}
