<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class TestRabbitMQConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:test-connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the connection to RabbitMQ';

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
        try {

            $host = config('queue.connections.rabbitmq.host');
            $port = config('queue.connections.rabbitmq.port');
            $user = config('queue.connections.rabbitmq.user');
            $password = config('queue.connections.rabbitmq.password');
            $vhost = config('queue.connections.rabbitmq.vhost');

            $host = env('RABBITMQ_HOST');
            $port = env('RABBITMQ_PORT');
            $user = env('RABBITMQ_USER');
            $password = env('RABBITMQ_PASSWORD');
            $vhost = env('RABBITMQ_VHOST');


            $connection = new AMQPStreamConnection(
                $host,
                $port,
                $user,
                $password,
                $vhost
            );

            if ($connection->isConnected()) {
                $this->info('Successfully connected to RabbitMQ.');
            } else {
                $this->error('Failed to connect to RabbitMQ.');
            }

            $connection->close();
        } catch (\Exception $e) {
            $this->error('Error connecting to RabbitMQ: ' . $e->getMessage());
        }
    }
}
