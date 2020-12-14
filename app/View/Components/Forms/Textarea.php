<?php
/**
 * This is NOT a freeware, use is subject to license terms
 * @copyright Copyright (c) 2010-2099 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larva.com.cn/
 * @license http://www.larva.com.cn/license/
 */

namespace App\View\Components\Forms;

use Illuminate\View\Component;

/**
 * 文本输入
 * @author Tongle Xu <xutongle@gmail.com>
 */
class Textarea extends Component
{
    /**
     * The input id attribute.
     *
     * @var string
     */
    public $id;

    /**
     * The input name.
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
     * The input placeholder.
     *
     * @var string
     */
    public $placeholder;

    /**
     * The maximum length of input.
     *
     * @var int
     */
    public $max;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  string  $label
     * @param  string  $placeholder
     *
     * @return void
     */
    public function __construct($name = "text", $label = "Text Input", $placeholder = "Enter Text", $max = 200)
    {
        $this->id = 'form-' . $name;
        $this->name = $name;
        $this->label = $label;
        $this->placeholder = $placeholder;
        $this->max = $max;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.forms.textarea');
    }
}
