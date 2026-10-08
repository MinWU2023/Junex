<?php


namespace App\Utils;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator as BasePaginator;

class AcademyPaginator extends BasePaginator
{
    /**
     * 重写页面 URL 实现代码，去掉分页中的问号，实现伪静态链接
     * @param int $page
     * @return string
     */
    public function url($page)
    {
        if ($page <= 0) {
            $page = 1;
        }

        // 移除路径尾部的/
        $path = rtrim($this->path, '/');

        // 如果路径中包含分页信息则正则替换页码，否则将页码信息追加到路径末尾
        if (preg_match('/\_p(\d+)/', $path)) {
            $path = preg_replace('/\_p(\d+)/', '_p' . $page, $path);
        } else {
            $path .= '_p' . $page;
        }
        $this->path = $path;

        if ($this->query) {
            $url = $this->path . (Str::contains($this->path, '?') ? '&' : '?')
                . http_build_query($this->query, '', '&')
                . $this->buildFragment();
        } elseif ($this->fragment) {
            $url = url($this->path . $this->buildFragment());
        } else {
            $url = url($this->path);
        }
        return $url;
    }

    protected function setCurrentPage($currentPage, $pageName)
    {
        if (!$currentPage && preg_match('/\_p(\d+)/', $this->path, $matches)) {
            $currentPage = $matches[1];
        }
        return $this->isValidPageNumber($currentPage) ? (int) $currentPage : 1;
    }

    public static function injectIntoBuilder()
    {
        Builder::macro('seoPaginate', function ($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null) {
            $page = $page ?: Paginator::resolveCurrentPage($pageName);
            $perPage = $perPage ?: $this->model->getPerPage();
            $items = ($total = $this->toBase()->getCountForPagination())
                ? $this->forPage($page, $perPage)->get($columns)
                : $this->model->newCollection();

            $options = [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ];
            return Container::getInstance()->makeWith(AcademyPaginator::class, compact(
                'items', 'total', 'perPage', 'page', 'options'
            ));
        });
    }
}
