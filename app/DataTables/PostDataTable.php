<?php

namespace App\DataTables;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class PostDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('thumbnail', function (Post $post) {
                return $post->thumbnail
                    ? '<img src="' . e($post->thumbnail) . '" alt="thumbnail" style="max-width: 50px;">'
                    : '<span>No image</span>';
            })
            ->addColumn('status_label', function (Post $post) {
                return $post->status_label;
            })
            ->addColumn('publish_date', function (Post $post) {
                return $post->publish_date
                    ? $post->publish_date
                    : 'No Publish Date';
            })
            ->addColumn('action', function (Post $post) {
                return '
                    <div class="btn-group">
                        <a href="' . route('post.show', $post) . '" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="' . route('post.edit', $post) . '" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="deleteForm' . $post->id . '" action="' . route('post.destroy', $post) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(\'deleteForm' . $post->id . '\')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>';
            })
            ->rawColumns(['thumbnail', 'action'])
            ->setRowId('id');
    }

    public function query(Post $post): QueryBuilder
    {
        return $post->newQuery()
            ->with(['user', 'media'])
            ->where('user_id', Auth::id());
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('postsTable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3, 'desc') 
            ->parameters([
                'pageLength' => 5,
                'language' => [
                    'url' => '//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json',
                ],
            ]);
    }

    protected function getColumns(): array
    {
        return [
            ['data' => 'thumbnail', 'name' => 'thumbnail', 'title' => 'Thumbnail', 'orderable' => false, 'searchable' => false],
            ['data' => 'title', 'name' => 'title', 'title' => 'Title'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
            ['data' => 'publish_date', 'name' => 'publish_date', 'title' => 'Publish Date'],
            ['data' => 'status_label', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'Post_' . date('YmdHis');
    }
}