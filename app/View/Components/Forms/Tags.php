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
 * 标签组件
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Tags extends Component
{
    /**
     * The input id attribute.
     *
     * @var string
     */
    public $id;
    /**
     * The input name attribute.
     *
     * @var string
     */
    public $name;
    /**
     * The input label.
     *
     * @var string
     */
    public $label;
    /**
     * The selectable options.
     *
     * @var string
     */
    public $placeholder;
    /**
     * The selectable options.
     *
     * @var array
     */
    public $options;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param array $options
     *
     * @return void
     */
    public function __construct(string $name = "tags", string $label = "Select Tags", string $placeholder = "Select Option...", array $options = [])
    {
        $this->id = 'form-' . Str::kebab(class_basename(get_class($this))) . '-' . md5($name);
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->options = $options;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.tags');
    }
}
