<?php
require("controller.php");
require("models/news.php");

class NewsController extends Controller
{
    
    public function __construct()
    {
        $this->folder = '';
    }

    public function index()
    {
        $this->render('home', []);
    }

    public function list()
    {
        $news = new News();
        $listsNews = $news->all();
        $this->render('news', ['listsNews' => $listsNews]);
    }

    public function saveNews()
    {
        require("api/response.php");

        $params = [];
        foreach ($_POST as $name => $value) {
            $params[$name] = $value;
        }

        $news = new News();
        $newsItem = false;

        if(!$news->exist(['title' => $params['title'], 'source' => $params['source']])){
            $newsItem = $news->create($params);
        }

        return success($newsItem);
    }

    public function delete()
    {
        require("api/response.php");

        $id = $_GET['id'];

        if(!$id){
            return error('Không tìm thấy dữ liệu!');
        }

        $news = new News();
        if($news->exist(['id' => $id])){
            $news->delete(['id' => $id]);
            return success('Xoá bài viết thành công');
        }

        return error('Không tìm thấy dữ liệu!');
    }

    public function error()
    {
        $this->render('error');
    }
}
