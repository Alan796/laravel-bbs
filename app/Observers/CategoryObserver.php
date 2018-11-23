<?php

namespace App\Observers;

use App\Models\Category;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class CategoryObserver
{
    public function saved(Category $category)
    {
        Category::cache();
    }


    public function deleted(Category $category)
    {
        Category::cache();
    }
}