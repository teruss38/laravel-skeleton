<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Widgets;

use App\Models\Category;
use Illuminate\View\Component;

/**
 * Class SideCategory
 * @author Tongle Xu <xutongle@gmail.com>
 */
class SideCategory extends Component
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $categories = Category::getRootNodes();
        return view('components.widgets.side_category', [
            'categories' => $categories
        ]);
    }
}
