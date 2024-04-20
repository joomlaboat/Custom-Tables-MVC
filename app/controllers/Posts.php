<?php

class Posts extends Controller
{
    public function __construct()
    {
        if (!isLoggedIn()) {
            redirect('users/login');
        }

        $this->postModel = $this->model('Post');
        $this->userModel = $this->model('User');
    }

    public function index()
    {
        //Get posts
        $posts = $this->postModel->getPosts();

        $data = [
            'posts' => $posts
        ];
        $this->view('posts/index', $data);

    }

    public function add()
    {
        //Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Process the form

            //Sanitize POSt data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Init data
            $data = [
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            //Validate Name
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            //Validate Body
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter body text';
            }

            //Make sure errors are empty
            if (empty($data['title_err']) and
                empty($data['body_err'])
            ) {
                //Validated

                if ($this->postModel->addPost($data)) {
                    flash('post_message', 'Post has been added');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }

            } else {
                //Load view with errors
                $this->view('posts/add', $data);
            }
        } else {
            $data = [
                'title' => '',
                'body' => ''
            ];
            $this->view('posts/add', $data);
        }
    }

    public function edit($id)
    {
        //Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //Process the form

            //Sanitize POSt data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Init data
            $data = [
                'id' => $id,
                'title' => trim($_POST['title']),
                'body' => trim($_POST['body']),
                'user_id' => $_SESSION['user_id'],
                'title_err' => '',
                'body_err' => ''
            ];

            //Validate Name
            if (empty($data['title'])) {
                $data['title_err'] = 'Please enter title';
            }

            //Validate Body
            if (empty($data['body'])) {
                $data['body_err'] = 'Please enter body text';
            }

            //Make sure errors are empty
            if (empty($data['title_err']) and
                empty($data['body_err'])
            ) {
                //Validated

                if ($this->postModel->updatePost($data)) {
                    flash('post_message', 'Post has been updated');
                    redirect('posts');
                } else {
                    die('Something went wrong');
                }

            } else {
                //Load view with errors
                $this->view('posts/edit', $data);
            }
        } else {
            //Get existing post from model
            $post = $this->postModel->getPostById($id);

            //Check
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }

            $data = [
                'id' => $id,
                'title' => $post->title,
                'body' => $post->body
            ];
            $this->view('posts/edit', $data);
        }
    }

    public function show($id)
    {
        $post = $this->postModel->getPostById($id);
        $user = $this->userModel->getUserById($post->user_id);
        $data = [
            'post' => $post,
            'user' => $user];
        $this->view('posts/show', $data);
    }

    public function delete($id)
    {

        //Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Get existing post from model
            $post = $this->postModel->getPostById($id);

            //Check
            if ($post->user_id != $_SESSION['user_id']) {
                redirect('posts');
            }


            if ($this->postModel->deletePost($id)) {
                flash('post_message', 'Post has been deleted');
                redirect('posts');
            }else{
                die('Something went wrong');
            }
        } else {
            redirect('posts');
        }
    }
}