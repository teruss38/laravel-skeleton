<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Admin\Forms\Settings;

use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\URL;
use Larva\Settings\SettingEloquent;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Settings
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Settings extends Form
{
    public function __construct($data = [], $key = null)
    {
        parent::__construct($data, $key);
        $this->disableResetButton();
    }

    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        $input = Arr::dot($input);
        foreach ($input as $key => $val) {
            \Larva\Settings\Settings::set($key, $val);
        }
        return $this->success('Processed successfully.', URL::previous());
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        $settings = [];
        SettingEloquent::all()->each(function ($setting) use (&$settings) {
            $settings[$setting['key']] = $setting['value'];
        });
        return $settings;
    }
}
