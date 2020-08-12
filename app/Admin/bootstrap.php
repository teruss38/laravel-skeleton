<?php

use Dcat\Admin\Admin;
use Dcat\Admin\Grid;
use Dcat\Admin\Form;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Show;

/**
 * Dcat-admin - admin builder based on Laravel.
 * @author jqh <https://github.com/jqhph>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 *
 * extend custom field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Column::extend('php', PHPEditor::class);
 * Dcat\Admin\Grid\Filter::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
//这里重写了几个上传控件的 disk 位置，统一使用 filesystems 里的 cloud 存储，避免存储混乱，你如果使用admin.php 的存储，
//那么不保存完文件，在模型读取的时候还得用admin.php 的取出，需要配置的地方太多（凡是参与上传处理的模型都得按照admin.php 的存储非常繁琐）。
//非常容易由于忘记修改某一处就出错。
//所以这里直接强制修改了默认的上传存储位置，统一保存到cloud磁盘。你想修改存储磁盘只需修改 filesystems 里的 cloud 对应的 disk 即可。
Dcat\Admin\Form::extend('file', \App\Admin\Form\Field\File::class);
Dcat\Admin\Form::extend('image', \App\Admin\Form\Field\Image::class);
Dcat\Admin\Form::extend('multipleFile', \App\Admin\Form\Field\MultipleFile::class);
Dcat\Admin\Form::extend('multipleImage', \App\Admin\Form\Field\MultipleImage::class);
