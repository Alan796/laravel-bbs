<?php

namespace App\Admin\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class UserController extends Controller
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
            ->header('Index')
            ->description('description')
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
            ->header('Detail')
            ->description('description')
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
            ->header('Edit')
            ->description('description')
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
            ->header('Create')
            ->description('description')
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

        $show->id('Id');
        $show->name('Name');
        $show->email('Email');
        $show->password('Password');
        $show->introduction('Introduction');
        $show->avatar('Avatar');
        $show->remember_token('Remember token');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        $show->follower_count('Follower count');
        $show->followee_count('Followee count');
        $show->notification_count('Notification count');

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

        $form->text('name', 'Name');
        $form->email('email', 'Email');
        $form->password('password', 'Password');
        $form->text('introduction', 'Introduction');
        $form->image('avatar', 'Avatar');
        $form->text('remember_token', 'Remember token');
        $form->number('follower_count', 'Follower count');
        $form->number('followee_count', 'Followee count');
        $form->number('notification_count', 'Notification count');

        return $form;
    }
}
