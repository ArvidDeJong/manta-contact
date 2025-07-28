<?php

namespace Darvis\MantaContact\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manta-contact:install 
                            {--force : Overwrite existing files}
                            {--migrate : Run migrations after installation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Manta Contact package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Installing Manta Contact Package...');
        $this->newLine();

        // Step 1: Publish configuration
        $this->publishConfiguration();

        // Step 2: Publish migrations
        $this->publishMigrations();

        // Step 3: Run migrations if requested
        if ($this->option('migrate')) {
            $this->runMigrations();
        }

        // Step 4: Create default configuration
        $this->createDefaultConfiguration();

        // Step 5: Show completion message
        $this->showCompletionMessage();

        return self::SUCCESS;
    }

    /**
     * Publish configuration files
     */
    protected function publishConfiguration(): void
    {
        $this->info('📝 Publishing configuration files...');

        $params = [
            '--provider' => 'Darvis\MantaContact\ContactServiceProvider',
            '--tag' => 'manta-contact-config'
        ];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        Artisan::call('vendor:publish', $params);

        $this->line('   ✅ Configuration published to config/manta-contact.php');
    }

    /**
     * Publish migration files
     */
    protected function publishMigrations(): void
    {
        $this->info('📦 Publishing migration files...');

        $params = [
            '--provider' => 'Darvis\MantaContact\ContactServiceProvider',
            '--tag' => 'manta-contact-migrations'
        ];

        if ($this->option('force')) {
            $params['--force'] = true;
        }

        Artisan::call('vendor:publish', $params);

        $this->line('   ✅ Migrations published to database/migrations/');
    }

    /**
     * Run database migrations
     */
    protected function runMigrations(): void
    {
        $this->info('🗄️  Running database migrations...');

        if ($this->confirm('This will run the database migrations. Continue?', true)) {
            Artisan::call('migrate');
            $this->line('   ✅ Migrations completed successfully');
        } else {
            $this->warn('   ⚠️  Migrations skipped. Run "php artisan migrate" manually later.');
        }
    }

    /**
     * Create default configuration if it doesn't exist
     */
    protected function createDefaultConfiguration(): void
    {
        $this->info('⚙️  Setting up default configuration...');

        $configPath = config_path('manta-contact.php');

        if (File::exists($configPath)) {
            $config = include $configPath;
            
            // Check if configuration needs updating
            if (!isset($config['route_prefix'])) {
                $this->warn('   ⚠️  Configuration file exists but may need manual updates');
            } else {
                $this->line('   ✅ Configuration file is ready');
            }
        } else {
            $this->error('   ❌ Configuration file not found. Please run the install command again.');
        }
    }

    /**
     * Show completion message with next steps
     */
    protected function showCompletionMessage(): void
    {
        $this->newLine();
        $this->info('🎉 Manta Contact Package installed successfully!');
        $this->newLine();

        $this->comment('Next steps:');
        $this->line('1. Configure your settings in config/manta-contact.php');
        
        if (!$this->option('migrate')) {
            $this->line('2. Run migrations: php artisan migrate');
        }
        
        $this->line('3. Access the contact management at: /contact (or your configured route)');
        $this->newLine();

        $this->comment('Available routes:');
        $this->line('• GET /contact - Contact list');
        $this->line('• GET /contact/toevoegen - Create new contact');
        $this->line('• GET /contact/aanpassen/{id} - Edit contact');
        $this->line('• GET /contact/lezen/{id} - View contact');
        $this->line('• GET /contact/bestanden/{id} - Manage contact files');
        $this->line('• GET /contact/instellingen - Contact settings');
        $this->newLine();

        $this->info('📚 For more information, check the README.md file.');
    }
}
