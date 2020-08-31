<?php



Route::get('/', 'FrontEndController@index');
Route::get('/posts/details/{post}', 'FrontEndController@getSinglePost')->name('get.single.posts');
Route::get('/forums/details/{forum}', 'FrontEndController@getSingleForum')->name('get.single.forums');

Auth::routes();

//home
Route::get('/home', 'HomeController@index')->name('home');

// Categories
Route::get('/categories/status/update/{category}', 'CategoryController@statusUpdate')->name('categories.status.update');
Route::resource('/categories', 'CategoryController');

//post
Route::post('allposts', 'PostController@getAllPost')->name('allposts');
Route::get('/posts/trash','PostController@getTrashPosts')->name('posts.trash');
Route::delete('/posts/trash/{id}','PostController@restorePosts')->name('posts.restore');
Route::delete('/posts/delete/{id}','PostController@permanentDelete')->name('posts.pdelete');
Route::resource('/posts', 'PostController');

//forum
Route::get('allforums', 'ForumController@publicForum')->name('forum.all');
Route::resource('/forums', 'ForumController');

//comment
//Route::resource('/comments', 'CommentController');
Route::post('/comments/post/{post}', 'CommentController@postCommentStore')->name('posts.comments.store');
Route::post('/comments/forum/{forum}', 'CommentController@forumCommentStore')->name('forums.comments.store');

//tag
Route::resource('/tags','TagController');


