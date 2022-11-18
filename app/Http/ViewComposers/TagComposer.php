<?php
/**
 * Author: hefengbao
 * Date: 2016/11/10
 * Time: 14:50
 */

namespace App\Http\ViewComposers;

use App\Services\TagService;
use Illuminate\View\View;

class TagComposer
{
    protected $tagRepository;

    public function __construct(TagService $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * 标签云
     * @param View $view
     */
    public function compose(View $view)
    {
        $tags = $this->tagRepository->getAll();

        $view->with('tags', $tags);
    }

}
