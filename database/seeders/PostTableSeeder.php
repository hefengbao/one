<?php

namespace Database\Seeders;

use App\Constant\PostStatus;
use App\Constant\PostType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        DB::table('posts')->insert([
            [
                'id' => 1,
                'slug' => 'about',
                'user_id' => 1,
                'title' => '关于',
                'body' => '玉竹是一个简洁的博客，微博客系统。

对微博客的一点说明，有时想写点的什么但是又没有一个贴合的标题，可能因此又不想写了，于是做了一个小的模块，就像发微博那样，只写内容就可以了。显示的时候也是单独的一块。

Github: https://github.com/hefengbao/yuzhu

微博：[@8ug_icu](https://weibo.com/u/7645900557)

微信公众号：[NowInLife](https://hefengbao.github.io/assets/images/NowInLife.png)',
                'type' => PostType::Page->value,
                'status' => PostStatus::Published->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 2,
                'slug' => 'privacy',
                'user_id' => 1,
                'title' => '隐私政策',
                'body' => '## 我们是谁
我们的站点地址是：http://yuzhu.test。
## 评论
当访客留下评论时，我们会收集评论表单所显示的数据（包括用户名、邮箱地址和评论内容），和访客的IP地址及浏览器的user agent字符串来帮助检查垃圾评论。
## 媒体
如果您向此网站上传图片，您应当避免上传那些有嵌入地理位置信息（EXIF GPS）的图片。此网站的访客将可以下载并提取此网站的图片中的位置信息。
## Cookies
如果您在我们的站点上留下评论，您可以选择用cookies保存您的用户名、电子邮箱地址，这样您在下次使用时不用重复填写相关信息。
当您登录时，我们也会设置 cookies 来保存您的登录信息。登录 cookies 会保留两小时。如果您选择了“记住我”，您的登录状态则会保留两周。如果您注销登陆了您的账户，用于登录的cookies将会被移除。
## 来自其他网站的嵌入内容
此站点上的文章可能会包含嵌入的内容（如视频、图片、文章等）。来自其他站点的嵌入内容的行为和您直接访问这些其他站点没有区别。
这些站点可能会收集关于您的数据、使用cookies、嵌入额外的第三方跟踪程序及监视您与这些嵌入内容的交互，包括在您有这些站点的账户并登录了这些站点时，跟踪您与嵌入内容的交互。
## 我们保留多久您的信息
如果您留下评论，评论和其元数据将被无限期保存。
对于本网站的注册用户，我们也会保存用户在个人资料中提供的个人信息，以及您在本站发布的内容。
## 说明
参考 Wordpress 写的 😄， 站长可自行修改。',
                'type' => PostType::Page->value,
                'status' => PostStatus::Published->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            [
                'id' => 3,
                'slug' => 'first-post',
                'user_id' => 1,
                'title' => '示例文章',
                'body' => '这世界我来了！',
                'type' => PostType::Article->value,
                'status' => PostStatus::Published->value,
                'published_at' => Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
        ]);
    }
}
