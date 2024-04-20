<?php

class Pages extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        if (isLoggedIn()) {
            redirect('posts');
        } else {
            $data = [
                'title' => 'SharePosts',
                'description' => 'Show posts on SharePosts.'
            ];

            $this->view('pages/index', $data);
        }
    }

    public function about()
    {
        $data = [
            'title' => 'About Us',
            'description' => 'This is the About Us page.'
        ];

        $this->view('pages/about', $data);
    }
}