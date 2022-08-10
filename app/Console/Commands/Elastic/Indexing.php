<?php

namespace App\Console\Commands\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class Indexing extends AbstractElasticCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:indexing';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing model';
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $complete = [];

        $fails = [];

        foreach ($this->mapping as $mapItem) {

            $mapClass = new $mapItem;

            $model = $mapClass->model();

            foreach ($model::cursor() as $item) {

                $message = "{$model} id: {$item->id} index: {$mapClass->index()} type: {$mapClass->type()} ";

                $params = [
                    "index" => $mapClass->index(),
                    "type" => $mapClass->type(),
                    "id" => $item->id,
                    "body" => $mapClass->source($item)
                ];

                $response = $this->client->index($params);

                if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {

                    $complete[] = "- complete - " . $message . "indexing ";

                } else {

                    $fails[] = "- fail - " . $message . "fail ";

                }
            }
        }

        $this->output->write("fails: ", true);
        $this->output->write($fails, true);
        $this->output->write("complete: ", true);
        $this->output->write($complete, true);

        $this->info(
            "Done "
                . "complete count: " . count($complete)
                . " fails count: " . count($fails)
        );
    }
}
