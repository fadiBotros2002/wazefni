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
                // حقل المستخدم (محدد بالعلاقة مع جدول المستخدمين)
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(function () {
                        return DB::table('users')->pluck('name', 'user_id');  // سحب الأسماء من جدول المستخدمين
                    })
                    ->searchable()
                    ->required(),

                // حقل العنوان
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                // حقل النوع
                Forms\Components\TextInput::make('type')
                    ->required(),

                // حقل الوصف
                Forms\Components\Textarea::make('description')
                    ->required(),

                // حقل المتطلبات
                Forms\Components\Textarea::make('requirement')
                    ->required(),

                // حقل الموقع
                Forms\Components\TextInput::make('location')
                    ->required(),

                // حقل الوقت
                Forms\Components\TextInput::make('time')
                    ->required(),

                // حقل الراتب
                Forms\Components\TextInput::make('salary')
                    ->required(),

                // حقل سنوات الخبرة
                Forms\Components\TextInput::make('experience_year')
                    ->numeric()
                    ->required(),

                // حقل تاريخ النشر
                Forms\Components\DateTimePicker::make('posted_at')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([  // تحديد الأعمدة التي ستظهر في الجدول
                Tables\Columns\TextColumn::make('user.name')  // عرض اسم المستخدم بدلاً من ID
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
            ->filters([  // إضافة فلاتر للبحث
                //
            ])
            ->actions([  // إضافة الإجراءات المتاحة على السجلات
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([  // إضافة الإجراءات المجمعة
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
            'index' => Pages\ListPosts::route('/'),  // صفحة العرض
            'create' => Pages\CreatePost::route('/create'),  // صفحة الإضافة
            'edit' => Pages\EditPost::route('/{record}/edit'),  // صفحة التعديل
        ];
    }
}
