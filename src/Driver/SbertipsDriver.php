<?php
namespace SushiMarket\Sbertips\Driver;

use Illuminate\Contracts\Http\Kernel;

class SbertipsDriver implements Kernel
{

    public function bootstrap() {}
    public function terminate($request, $response) {}
    public function getApplication() {}

    public function handle($request)
    {
        return $this->formatJson($request);
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function formatJson($data)
    {
        $data['driver_test'] = 'test_driver';
        return $data;
    }
}
