<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\News;

use App\Http\Requests\Request;

/**
 * 快讯存储请求
 * @property int $user_id;
 * @property string $title
 * @property string $description
 * @property string $from
 * @property string $from_url
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class StoreNewsRequest extends Request
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return (bool)$this->user();
    }

    /**
     * 准备验证数据
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['numeric'],
            'title' => ['required', 'string', 'max:40', 'min:5', 'text_censor'],
            'description' => ['required', 'string', 'text_censor'],
            'from' => [
                'nullable', 'string', 'min:2', 'max:20', 'text_censor'
            ],
            'from_url' => [
                'nullable', 'url'
            ],
        ];
    }
}
