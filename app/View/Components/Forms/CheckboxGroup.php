<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Forms;

use Illuminate\Support\Str;
use Illuminate\View\Component;

/**
 * 复选框组
 * @author Tongle Xu <xutongle@gmail.com>
 */
class CheckboxGroup extends Component
{
    /**
     * The input id attribute.
     *
     * @var string
     */
    public $id;
    /**
     * The input label.
     *
     * @var string
     */
    public $label;

    /**
     * Create a new component instance.
     *
     * @param null $label
     */
    public function __construct($label = null)
    {
        $this->id = 'form-' . Str::kebab(class_basename(get_class($this)));
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.checkbox-group');
    }
}
