<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\Http\Requests\Api\V1\Article;

use App\Http\Requests\Request;
use App\Models\Article;

/**
 * 创建文章请求
 * @property-read int $category_id
 * @property-read string $title
 *
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
        return $this->user()->can('create', Article::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'numeric|min:1',
            'title' => 'required|string|max:191',
            'thumb' => 'sometimes|required|string|max:191',
            'description' => 'sometimes|required|string|max:191',
            'content' => 'required|string',
        ];
    }
}

