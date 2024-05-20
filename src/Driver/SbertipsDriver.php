<?php
namespace SushiMarket\Sbertips\Driver;

use Illuminate\Contracts\Http\Kernel;
use App\Services\Auth;
use SushiMarket\Sbertips\Models\ResponseStatus;
use SushiMarket\Sbertips\Models\RiderTip;
use SushiMarket\Sbertips\Sbertips;

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
        if (isset($data['error'])) {
            return [
                'message' => "Сберчаевые: {$data['error']['message']}"
            ];
        }

        $routeName = request()->route()->getName();
        if (isset($data['status']) && $data['status'] === ResponseStatus::SUCCESS->value) {
            return $this->$routeName($data);
        }

        return $data;
    }

    /**
     * @param $data
     * @return array
     */
    protected function clientRegisterStart($data)
    {
        return [
            'message'       => 'success',
            'new_otp_delay' => $data["newOtpDelay"],
            'attempts_left' => $data["attemptsLeft"]
        ];
    }
}
