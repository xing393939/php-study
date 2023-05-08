### Model操作

#### 增
1. 用::create/::firstOrNew/::firstOrCreate/::updateOrCreate，不要用insert和insertGetId（没有走模型保存），这个不能用timestamps特性：https://learnku.com/laravel/t/37526
2. updateOrCreate想要incr，就用firstOrNew：https://stackoverflow.com/questions/33182090

#### 查
1. Model::select() 和 Model::where，模型单例获取
1. ->get()、->get(['column1', 'column2'])，获取多条/指定字段
1. ->first()、->first(['column1', 'column2'])，获取单条/指定字段
1. ->value('column1')，获取单值
1. ->pluck('name', 'id')，表示以id为键，name为值的二维结果
1. ->where(['id' => 1])
1. ->where('id', 1)
1. ->where('id', '>', 1)
1. ->wherein('id', [1, 2])
1. ->all()，查询所有
1. ->find(1)，主键查询单条记录
1. 聚合函数：->count()、->avg()
1. N+1转化成2次查询：https://learnku.com/laravel/t/1220/laravel-queries-only-individual-fields-in-with-queries
1. 指定的字段作为查询结果的key
  * [Laravel SQL用指定的字段作为查询结果的key](https://blog.csdn.net/qq_19557947/article/details/80597460)
  * 用Eloquent：Role::all()->keyBy('name')->toArray();
  * 非Eloquent：collect(DB::table('role')->get())->keyBy('name')->toArray();
1. 集合处理
  * [十五个常用的 Laravel 集合](https://www.jianshu.com/p/28b9cc2b810c)
  * ->filter(function($value, $key) { return $key > 5; });
  * ->map(function($value, $key) { return $value; });

#### 改
1. ->increment('num', 1)，自增+1
1. ->decrement('num', 1)，自增-1

#### 删
1. ->delete()

#### 复杂查询
1. [通过查询构建器实现复杂的查询语句](https://xueyuanjun.com/post/9698)
```php
LiveComment::select('*')->where('id', 1)->where('content', '')->where(function ($query) {
    $query->where('content', 0)->orWhere(function ($query) {
        $query->where('id', 21)->where('content', '21');
    })->orWhere(function ($query) {
        $query->where('id', 22)->where('content', '22');
    });
})->get();
```