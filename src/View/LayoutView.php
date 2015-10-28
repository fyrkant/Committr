<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-22
 * Time: 14:42
 */

namespace Committr\View;


class LayoutView
{

    /**
     * @var Messenger
     */
    private $messenger;

    public function __construct(Messenger $messenger)
    {
        $this->messenger = $messenger;
    }

    public function renderPage($isLoggedIn, $isWriting, LoginView $loginView, RepoListView $repoListView, PostListView $postListView, WriteView $writer)
    {
        $message = $this->messenger->getMessage();

        echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Committr</title>
            <link rel="stylesheet" type="text/css" href="assets/style.css">
            <link rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
            integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
            crossorigin="anonymous">
          </head>
          <body>
              <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <h1 class="text-muted ">Committr</h1>
                    </div>
                    <div class="col-sm-2">
                        '. ($isLoggedIn ? $loginView->response($isLoggedIn) : "" ).'
                    </div>
                        <nav>
                            <ul class="nav nav-pills pull-right">
                                <li role="presentation danger"></li>
                            </ul>
                        </nav>
                    </div>

                    '. ($message != "" ? "<div class=\"alert alert-info\" role=\"alert\">$message</div>" : "" ) .'


                    '. (!$isLoggedIn ? $loginView->response($isLoggedIn) : "") .'

                    <div class="col-sm-12">

                        '. ($isLoggedIn && $isWriting ? $writer->render() : "") .'

                        '. $postListView->render() .'

                        '. ($isLoggedIn && !$isWriting ? $repoListView->render() :"") .'

                    </div>


                </div>

          </body>
        </html>
        ';
    }

}