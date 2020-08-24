<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Api\Locoy;

use App\Http\Requests\Request;

/**
 * Class CreateArticleRequest
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CreateArticleRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => ['required', 'numeric', 'exists:article_categories,id',],
            'title' => ['required', 'string', 'min:3', 'max:191'],
            'content' => ['required', 'string', 'min:3', 'max:65500'],
            //'seo' => ['sometimes', 'array'],
            'extra' => ['sometimes', 'array'],
        ];
    }
}
