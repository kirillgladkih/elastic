<?php

namespace App\Console\Commands;

use App\Models\Article;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
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
    public function __construct()
    {
        parent::__construct();

        $hosts = config("app.search.hosts");

        $this->client =  ClientBuilder::create()->setHosts($hosts)->build();;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mapping = config("mapping.elastic");

        $fails = [];

        $complete = [];

        if (count($mapping) < 1)
            $this->error("nothing indexing");

        foreach ($mapping as $mapItem) {

            $map = new $mapItem();

            $model = $map->model();

            $params = [
                'index' => $map->index(),
                'type' => $map->type(),
            ];
            $this->client->indices()->delete($params);
            // /**
            //  * Exists index
            //  */
            // $existsCode = $this->client->indices()->exists($params)->getStatusCode();
            // /**
            //  * Create index if not exists
            //  */
            // if ($existsCode == 404) {
                $this->client->indices()->create(array_merge($params, [
                    "body" => ["settings" => $map->settings()
                    , "mappings" => ["properties" => $map->map()]
                    ]
                ]));
            // }
            /**
             * Indexing documents
             */
            foreach ($model::cursor() as $item) {

                $message = "{$model} id: {$item->id} index: {$map->index()} type: {$map->type()} ";

                $params["id"] = $item->id;

                $response = $this->client->index(array_merge($params, ["body" => $map->source($item)]));

                if ($response->getStatusCode() == 200 || $response->getStatusCode() == 201) {

                    $complete[] = $message . "indexing ";
                } else {

                    $fails[] = $message . "fail ";
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
