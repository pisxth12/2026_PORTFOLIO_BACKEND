<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Portfolio';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Project Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->default(1),
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('description')
                            ->maxLength(65535),
                        Forms\Components\TagsInput::make('languages')
                            ->required()
                            ->placeholder('Add technologies (React, Laravel, etc.)')
                            ->suggestions([
                                'React', 'Next.js', 'Vue.js', 'Angular',
                                'Laravel', 'Spring Boot', 'Node.js', 'Python',
                                'Tailwind CSS', 'Bootstrap', 'SCSS',
                                'MySQL', 'PostgreSQL', 'MongoDB',
                                'Docker', 'Git', 'AWS'
                            ]),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('projects')
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('600')
                            ->maxSize(2048),
                        Forms\Components\TextInput::make('github')
                            ->url()
                            ->prefix('https://')
                            ->placeholder('github.com/username/project'),
                        Forms\Components\TextInput::make('link')
                            ->url()
                            ->prefix('https://')
                            ->placeholder('example.com'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->size(60),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('languages')
                    ->badge()
                    ->listWithLineBreaks()
                    ->limitList(3),
                Tables\Columns\IconColumn::make('github')
                    ->boolean()
                    ->trueIcon('heroicon-o-link')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\IconColumn::make('link')
                    ->boolean()
                    ->trueIcon('heroicon-o-globe-alt')
                    ->falseIcon('heroicon-o-x-mark'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_github')
                    ->query(fn ($query) => $query->whereNotNull('github')),
                Tables\Filters\Filter::make('has_live_link')
                    ->query(fn ($query) => $query->whereNotNull('link')),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
