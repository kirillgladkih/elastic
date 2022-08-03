<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all articles to Elasticsearch';
    /**
     * Client
     *
     * @var [type]
     */
    protected $client;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $models = config("indexing.models");

        $fails = [];

        $complete = [];

        if (count($models) < 1)
            $this->error("nothing indexing");

        foreach ($models as $model) {

            foreach ($model::cursor() as $item) {

                $message = "{$model} id: {$item->id} index: {$item->getSearchIndex()} type: {$item->getSearchType()} ";

                $response = $this->client->index([
                    'index' => $item->getSearchIndex(),
                    'type' => $item->getSearchType(),
                    'id' => $item->getKey(),
                    'body' => $item->toSearchArray(),
                ]);

                if ($response->getStatusCode() == 200) {

                    $complete[] = $message . "indexing";

                }else{

                    $fails[] = $message . "fail";

                }
            }
        }

        $this->output->write("fails: ", true);
        $this->output->write($fails, true);
        $this->output->write("complete: ", true);
        $this->output->write($complete, true);

        $this->info(
            "Done"
            . " complete count: " . count($complete)
            . " fails count: " . count($fails)
        );
    }
}
