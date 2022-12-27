<?php

use App\Controllers\PostCommentController;
use App\Controllers\PostController;
use App\Controllers\UserController;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();

    $app->group('/api/v1', function (App $app) use ($container) {

        /**
         * Rota /api/v1/users
         */
        $app->group('/users', function (App $app) use ($container) {

            $container->get('db')->table('users');
            $users = new User();

            $app->get('[/{id}]', function (Request $request, Response $response) use ($container, $users) {
                $model = new UserController($container, $users);
                return $response->withJson(
                    $model->read($request->getAttribute('id')),
                    200);
            });

            $app->post('', function (Request $request, Response $response) use ($container, $users) {
                $model = new UserController($container, $users);
                $create = $model->create($request->getParsedBody());
                if($create) {
                    return $response->withJson($create->toArray(), 201);
                }
                return $response->withJson([], 409);
            });

            $app->put('/{id}', function (Request $request, Response $response) use ($container, $users) {
                $model = new UserController($container, $users);
                $update = $model->update($request->getAttribute('id'), $request->getParsedBody());
                if(!is_numeric($update)) {
                    return $response->withJson(['message' => 'ok'], 200);
                }
                return $response->withJson([], $update);
            });

            $app->delete('/{id}', function (Request $request, Response $response) use ($container, $users) {
                $model = new UserController($container, $users);
                $delete = $model->delete($request->getAttribute('id'));
                if(!is_numeric($delete)) {
                    return $response->withJson(['message' => 'ok'], 200);
                }
                return $response->withJson(['message' => 'error'], $delete);
            });
        });

        /**
         * Rota /api/v1/posts
         */
        $app->group('/posts', function (App $app) use ($container) {

            $container->get('db')->table('posts');
            $posts = new Post();
            $comments = new PostComment();

            $app->get('[/{id}]', function (Request $request, Response $response) use ($container, $posts) {
                $model = new PostController($container, $posts);
                $post = $model->read($request->getAttribute('id'));
                return $response->withJson($post, 200);
            });

            $app->post('', function (Request $request, Response $response) use ($container, $posts) {
                $model = new PostController($container, $posts);
                $create = $model->create($request->getParsedBody());
                if ($create) {
                    return $response->withJson($create, 201);
                }
                return $response->withJson(['message' => 'error'], 409);
            });

            $app->put('/{id}', function (Request $request, Response $response) use ($container, $posts) {
                $model = new PostController($container, $posts);
                $update = $model->update($request->getAttribute('id'), $request->getParsedBody());
                if(!is_numeric($update)) {
                    return $response->withJson(['message' => 'ok']
                        , 200);
                }
                return $response->withJson([], $update);
            });

            $app->delete('/{id}', function (Request $request, Response $response) use ($container, $posts) {
                $model = new PostController($container, $posts);
                $delete = $model->delete($request->getAttribute('id'));
                if(!is_numeric($delete)) {
                    return $response->withJson(['message' => 'ok']
                        , 200);
                }
                return $response->withJson([], $delete);
            });

            /**
             * Rota /api/v1/posts/{id}/comments
             */
            $app->post('/{id}/comments', function (Request $request, Response $response) use ($container, $comments) {
                $model = new PostCommentController($container, $comments);
                $create = $model->create([...$request->getParsedBody(), 'post_id' => $request->getAttribute('id')]);
                if ($create) {
                    return $response->withJson($create, 201);
                }
                return $response->withJson(['message' => 'error'], 409);
            });

            $app->delete('/{id}/comments/{commentId}', function (Request $request, Response $response) use ($container, $comments) {
                $model = new PostCommentController($container, $comments);
                $delete = $model->delete($request->getAttribute('commentId'));
                if (!is_numeric($delete)) {
                    return $response->withJson(['message' => 'ok'], 200);
                }
                return $response->withJson(['message' => 'error'], $delete);
            });
        });
    });
};
