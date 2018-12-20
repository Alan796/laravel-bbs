<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UsersController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('用户列表')
            ->description('用户列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('用户信息')
            ->description('用户信息')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('修改用户')
            ->description('修改用户')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('创建用户')
            ->description('创建用户')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User);

        $grid->model()->whereNotIn('id', User::permission('manage users')->get()->pluck('id')->toArray());

        $grid->id()->sortable();
        $grid->name('用户名');
        $grid->email('邮箱');
        $grid->introduction('简介');
        $grid->avatar('头像')->display(function ($avatar) {
            return '<img src="'.$avatar.'" style="max-width: 50px;border-radius: 50%;">';
        });
        $grid->created_at('注册时间')->sortable();
        $grid->follower_count('粉丝数')->sortable();
        $grid->followee_count('关注数')->sortable();
        $grid->last_active_at('最后活跃时间')->sortable();

        $grid->filter(function ($filter) {
            $filter->like('name', '用户名');
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(User::findOrFail($id));

        $show->id();
        $show->name('用户名');
        $show->email('邮箱');
        $show->introduction('简介');
        $show->avatar('头像')->display(function ($avatar) {
            return '<img src="'.$avatar.'" style="max-width: 50px;border-radius: 50%;">';
        });
        $show->created_at('注册时间');
        $show->follower_count('粉丝数');
        $show->followee_count('关注数');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User);

        $id = isset(request()->route()->parameters()['user']) ? request()->route()->parameters()['user'] : null;

        $form->text('name', '用户名')->rules(function ($form) use ($id) {
            $rules = 'required|string|between:1,32';
            $rules .= $id ? '|unique:users,name,'.$id : '|unique:users,name';

            return $rules;
        });
        $form->email('email', '邮箱')->rules(function ($form) use($id) {
            $rules = 'required|email';
            $rules .= $id ? '|unique:users,email,'.$id : '|unique:users,email';

            return $rules;
        });
        if (!$id) {
            $form->password('password', '密码')->rules('required|string|between:6,32');
        }
        $form->textarea('introduction', '简介')->rules('max:255');
        $form->image('avatar', '头像')->rules('dimensions:min_width=200,min_height=200');

        return $form;
    }
}
