<?php

namespace App\Repeats\Controllers;

use App\Repeats\Models\Page;

class PageController extends \App\Modules\Page\Controllers\PageController
{

    public function __construct(Page $page)
    {
        parent::__construct($page);
        $this->viewPath = 'Repeats::page';
        $this->model = $page->with(['translations']);
    }


    //对应repeat.php路由解开注释即访问到该控制器： 重写参考 App\Repeats\Controllers\ArticleController

}
