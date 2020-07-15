<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Article;

use App\Http\Requests\Request;
use App\Models\Article;

/**
 * 创建文章
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Article::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'category_id' => [
                'sometimes',
                'numeric',
                'exists:categories,id',
            ],
            'title' => [
                'required',
                'string',
                'min:5',
                'max:191',
                'ban_word'
            ],
            'description' => [
                'required',
                'string',
                'min:5',
                'max:191',
                'ban_word'
            ],
            'thumb' => [
                'sometimes',
                'dimensions:ratio=3/2'
            ],
            'content' => [
                'required',
                'string',
                'min:5',
                'max:65500',
                'ban_word'
            ],
        ];
        return $rules;
    }
}
