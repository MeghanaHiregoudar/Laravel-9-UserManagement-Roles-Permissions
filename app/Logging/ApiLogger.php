<?php

namespace App\Logging;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiLogger extends AbstractProcessingHandler
{

    // public function __construct($level = Logger::DEBUG, $bubble = true) {

    //     // die("called");
    //     $this->table = 'my_lovely_log';
    //     parent::__construct($level, $bubble);
    // }

    public function __invoke(array $config)
    {
        return new Logger(...);
    }
    // public function __invoke(array $config): Logger
    // {
    //     // print_r($config);die;
    //     // die("G");
    //     return new Logger(/* ... */);
    // }

    protected function write(array $record): void
    {
        die("h");

        DB::table('api_logs')->insert([
            'url' => $record['context']['url'],
            'method' => $record['context']['method'],
            'headers' => json_encode($record['context']['headers']),
            'params' => json_encode($record['context']['params']),
            'status' => $record['context']['status'],
            'response_headers' => json_encode($record['context']['response_headers']),
            'response_body' => $record['context']['response_body'],
            'created_at' => $record['datetime']->format('Y-m-d H:i:s'),
            'updated_at' => $record['datetime']->format('Y-m-d H:i:s'),
        ]);
    }
}