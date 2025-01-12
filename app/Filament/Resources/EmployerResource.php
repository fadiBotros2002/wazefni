<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployerResource\Pages;
use App\Filament\Resources\EmployerResource\RelationManagers;
use App\Models\Employer;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmployerStatusMail;

class EmployerResource extends Resource
{
    protected static ?string $model = Employer::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')->label('User ID')->required(),
                Forms\Components\TextInput::make('company_name')->label('Company Name')->required(),
                Forms\Components\Textarea::make('company_description')->label('Company Description')->required(),
                Forms\Components\FileUpload::make('verification_documents')
                    ->label('Verification Documents')
                    ->required()
                    ->disk('local') // نستخدم disk المحلي هنا
                    ->directory('verification_documents') // تحديد المجلد الذي سيتم تخزين الملفات فيه
                    ->preserveFilenames() // الحفاظ على أسماء الملفات الأصلية
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employer_id')->label('ID'),
                Tables\Columns\TextColumn::make('user_id')->label('User ID'),
                Tables\Columns\TextColumn::make('company_name')->label('Company Name'),
                Tables\Columns\TextColumn::make('company_description')->label('Company Description'),
                Tables\Columns\TextColumn::make('verification_documents')
                    ->label('Verification Documents')
                    ->formatStateUsing(function ($state) {
                        if ($state) {
                            return '<a href="' . url('storage/verification_documents/' . basename($state)) . '" target="_blank">Open</a>';
                        }
                        return 'No Document';
                    })
                    ->html(),
            ])
            ->filters([
                Tables\Filters\Filter::make('pending')
                    ->query(function (Builder $query) {
                        $query->whereHas('users', function ($query) {
                            $query->where('userstatus', 'pending');
                        });
                    })
                    ->label('Pending Employers')
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->action(function (Employer $record, array $data): void {
                        static::handleRequest('approve', $record->user_id);
                    }),
                Action::make('reject')
                    ->label('Reject')
                    ->action(function (Employer $record, array $data): void {
                        static::handleRequest('reject', $record->user_id);
                    }),
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
            'index' => Pages\ListEmployers::route('/'),
            'create' => Pages\CreateEmployer::route('/create'),
            'edit' => Pages\EditEmployer::route('/{record}/edit'),
        ];
    }

    // الدالة المخصصة لإدارة الطلبات

    public static function handleRequest($action, $user_id)
    {
        $user = User::findOrFail($user_id);
        $employer = Employer::where('user_id', $user_id)->first();

        if ($action === 'approve') {
            $user->update(['role' => 'employer']);
            $user->update(['userstatus' => 'active']);
            Mail::to($user->email)->send(new EmployerStatusMail($user, 'approved'));
            Log::info('User approved as an employer.', ['user_id' => $user_id]);
        } elseif ($action === 'reject') {
            if ($employer && $employer->verification_documents) {
                Storage::delete('verification_documents/' . basename($employer->verification_documents)); // حذف الملف باستخدام المسار المحلي
            }
            if ($employer) {
                $employer->delete();
            }
            $user->update(['role' => 'user']);
            $user->update(['userstatus' => 'active']);
            Mail::to($user->email)->send(new EmployerStatusMail($user, 'rejected'));
            Log::info('User rejected as an employer and record deleted.', ['user_id' => $user_id]);
        } else {
            Log::warning('Invalid action provided.', ['action' => $action, 'user_id' => $user_id]);
        }
    }
}
