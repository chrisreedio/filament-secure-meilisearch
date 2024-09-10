<?php

namespace ChrisReedIO\FilamentSecureMeilisearch;

use ChrisReedIO\FilamentSecureMeilisearch\Commands\FilamentSecureMeilisearchCommand;
use ChrisReedIO\FilamentSecureMeilisearch\Testing\TestsFilamentSecureMeilisearch;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSecureMeilisearchServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-secure-meilisearch';

    public static string $viewNamespace = 'filament-secure-meilisearch';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('chrisreedio/filament-secure-meilisearch');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-secure-meilisearch/{$file->getFilename()}"),
                ], 'filament-secure-meilisearch-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentSecureMeilisearch);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'chrisreedio/filament-secure-meilisearch';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-secure-meilisearch', __DIR__ . '/../resources/dist/components/filament-secure-meilisearch.js'),
            Css::make('filament-secure-meilisearch-styles', __DIR__ . '/../resources/dist/filament-secure-meilisearch.css'),
            Js::make('filament-secure-meilisearch-scripts', __DIR__ . '/../resources/dist/filament-secure-meilisearch.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentSecureMeilisearchCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_filament-secure-meilisearch_table',
        ];
    }
}
