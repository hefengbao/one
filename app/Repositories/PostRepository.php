<?php
/**
 * Author: hefengbao
 * Date: 2016/10/28
 * Time: 14:55
 */

namespace App\Repositories;

use App\Models\Post;
use App\One\Markdown;
use Cache;


class PostRepository
{
    protected $post;
    protected $tagRepository;
    protected $categoryRepository;
    protected $markdown;
    protected $user_id;
    public function __construct(Post $post, TagRepository $tagRepository, Markdown $markdown, CategoryRepository $categoryRepository)
    {
        $this->post = $post;
        $this->tagRepository = $tagRepository;
        $this->markdown = $markdown;
        $this->categoryRepository = $categoryRepository;
        $this->user_id = 1;
    }

    /**
     * save article
     * @param $input
     * @return static
     */
    public function save($input){
        $input['user_id']=$this->user_id;
        $input['category_id']=$input['post_category'];
        $input['post_type'] = 'post';
        $input['post_content_filter'] = $this->markdown->convertMarkdownToHtml($input['post_content']);
        $input['post_excerpt'] = trim($input['post_excerpt']) == '' ? makeExcerpt($input['post_content_filter']): trim($input['post_excerpt']);

        $post = $this->post->create($input);

        $category = $this->categoryRepository->getCategoryById($input['category_id']);
        Cache::forget('categorys');
        $category->increment('count',1);
        $tag_ids = [];
        if(array_has($input, 'tags')){
            $tags= $input['tags'];
            if (!empty($tags)) {
                foreach ($tags as $tag){
                    $tagInfo = $this->tagRepository->save(['tag_name'=>$tag]);
                    array_push($tag_ids, $tagInfo->id);
                }
            }
        }
        $post->tags()->attach($tag_ids);
        return  $post;
    }

    /**
     * update article
     * @param $id
     * @param $input
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update($id,$input){
        $post = $this->post->findOrFail($id);

        $input['user_id']=$this->user_id;
        $input['category_id']=$input['post_category'];
        $input['post_type'] = 'post';
        $input['post_content_filter'] = $this->markdown->convertMarkdownToHtml($input['post_content']);
        $input['post_excerpt'] = trim($input['post_excerpt']) == '' ? makeExcerpt($input['post_content_filter']): trim($input['post_excerpt']);

        $tag_ids = [];
        if(array_has($input, 'tags')){
            $tags= $input['tags'];
            if (!empty($tags)) {
                foreach ($tags as $tag){
                    $tagInfo = $this->tagRepository->create(['tag_name'=>$tag]);
                    array_push($tag_ids, $tagInfo->id);
                }
            }
        }
        $post->update($input);
        $post->tags()->sync($tag_ids);

        return $post;
    }

    /**
     * 首页显示
     * @return mixed
     */
    public function paginate(){
       return $this->post->select(Post::postInfo)->latest()->published()->paginate(10);
    }

    /**
     * 管理员界面显示
     * @return mixed
     */
    public function adminPaginate(){
        return $this->post->select(Post::postInfo)->latest()->post()->paginate(10);
    }

    /**
     *根据slug获取文章
     * @param $slug
     * @return \Illuminate\Database\Eloquent\Model|static
     */
    public function show($slug){
        $post = $this->post->with(['user'])->where('post_slug',$slug)->firstOrFail();
        return $post;
    }

    /**根据ID获取文章
     * @param $id
     * @return mixed
     */
    public function findById($id){
        return $post = $this->post->findOrFail($id);
    }

    /**热门文章
     * @return mixed
     */
    public function hotTopic(){
        $data = Cache::remember('hotTopic', 60*24, function (){
            return $this->post
                         ->select('post_title','post_slug')
                         ->orderBy('view_count','desc')
                         ->limit(10)
                         ->get();
        });
        return $data;
    }

    public function archive(){
        $data = $this->post->select('post_title','post_slug','published_at')
            ->where('deleted_at',"!=",null)
            ->orderBy('published_at','desc')
            ->get();
        return $data;
    }

    public function delete($id){
        $post = $this->post->findOrFail($id);
        return $post->delete();
    }
}