<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SkillResource\Pages;
use App\Filament\Resources\SkillResource\RelationManagers;
use App\Models\Skill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;
    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Skill Details')
                ->schema([
                    Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->default(1),
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('React, Laravel, etc.'),
                    Forms\Components\Select::make('category')
                    ->required()
                    ->options([
                        'Frontend' => 'Frontend',
                        'Backend' => 'Backend',
                        'Database' => 'Database',
                        'Tools' => 'Tools',
                        'DevOps' => 'DevOps',
                        'Mobile' => 'Mobile',
                    ]),
                    Forms\Components\Select::make('level')
                        ->required()
                        ->options([
                            'Beginner' => 'Beginner',
                            'Intermediate' => 'Intermediate',
                            'Advanced' => 'Advanced',
                            'Expert' => 'Expert',
                        ])
                        ->native(false),

                    Forms\Components\TextInput::make('experience')
                        ->placeholder('2 years')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('projects')
                        ->numeric()
                        ->default(0)
                        ->minValue(0),
                    Forms\Components\RichEditor::make('description')
                        ->maxLength(65535)
                        ->columnSpanFull(),
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->disk('cloudinary')
                        ->directory('skills')
                        ->imageResizeMode('cover')
                        ->imageResizeTargetWidth('100')
                        ->imageResizeTargetHeight('100')
                        ->maxSize(512)
                        ->getUploadedFileNameForStorageUsing(function ($file, $get) {
                            $skillName = $get('name');
                            $extension = $file->getClientOriginalExtension();
                            return Str::slug($skillName) . '.' . $extension;
                        })
                ])
                ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                ->circular()
                ->sortable(),
                Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Frontend' => 'success',
                        'Backend' => 'danger',
                        'Database' => 'info',
                        'Tools' => 'warning',
                        default => 'gray',
                    }),


                Tables\Columns\TextColumn::make('level')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Expert' => 'success',
                        'Advanced' => 'info',
                        'Intermediate' => 'warning',
                        'Beginner' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('experience'),
                Tables\Columns\TextColumn::make('projects')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Frontend' => 'Frontend',
                        'Backend' => 'Backend',
                        'Database' => 'Database',
                        'Tools' => 'Tools',
                    ]),
                Tables\Filters\SelectFilter::make('level')
                    ->options([
                        'Beginner' => 'Beginner',
                        'Intermediate' => 'Intermediate',
                        'Advanced' => 'Advanced',
                        'Expert' => 'Expert',
                    ]),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }
}
