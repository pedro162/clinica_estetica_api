<?php

namespace App\Console\Commands;

use App\Tenant;
use Illuminate\Console\Command;

class MigrateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:migrate {tenant?} {--fresh} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para rodar migrações de tenant';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->argument('tenant')){
            $this->migrate(
                Tenant::find($this->argument('tenant'))
            );
        }else{
            Tenant::all()->each(
                function($tenant){
                    $this->migrate($tenant);
                }
            );
        }

        return 0;
    }


    public function migrate($tenant){
        
        $tenant->configure()->use();
        $this->line('');
        $this->line('----------------------------------------------------------------');
        $this->info("Migratin Tenant #{$tenant->id} ({$tenant->name})");
        $this->line('----------------------------------------------------------------');

        $options = [
            '--force'=>true
        ];

        if($this->option('seed')){
            $options['--seed'] = true;
        }

        $this->call(
            $this->option('fresh') ? 'migrate:fresh' : 'migrate',
            $options
            
        );


    }


}
