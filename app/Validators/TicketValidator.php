<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Validators;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

/**
 * 票据验证
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class TicketValidator
{

    public function validate($attribute, $value, $parameters, $validator)
    {
        if (!isset($parameters[0])) {
            $parameters[0] = 'verify_code';
        }
        $config = config('services.captcha.' . $parameters[0]);
        $query = [
            'aid' => $config['aid'],
            'AppSecretKey' => $config['secret'],
            'Ticket' => $value,
            'Randstr' => request('randstr'),
            'UserIP' => request()->ip(),
        ];
        return $this->verify($query);
    }

    /**
     * @param array $query
     * @return bool
     */
    private function verify($query)
    {
        try {
            $response = Http::retry(3, 100)->get('https://ssl.captcha.qq.com/ticket/verify', $query);
            if ($response->successful() && !$passed = ($response['response'] ?? 0) == 1) {
                Log::error('Captcha verified fail:', compact('query', 'result'));
            }
            return $passed;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
