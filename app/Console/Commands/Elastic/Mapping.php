<?php

namespace App\Console\Commands\Elastic;

class Mapping extends AbstractElasticCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:mapping';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create mapping';
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fails = [];

        $complete = [];

        foreach ($this->mapping as $mapItem) {

            $mapClass = new $mapItem;

            $message = "{$mapItem} index: {$mapClass->index()} type: {$mapClass->type()} ";

            $params = [
                "index" => $mapClass->index(),
                "type" => $mapClass->type()
            ];

            $statusCode = $this->client->indices()->exists($params)->getStatusCode();

            if ($statusCode == 404) {
                $params["body"] = [
                    "settings" => $mapClass->settings(),
                    "mappings" => ["properties" => $mapClass->map()]
                ];
                $complete[] =   "- complete - " . $message . "create";
            } else {
                $fails[] = "- fail - "  . $message . "exists";
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
