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

    public function renderPage($isLoggedIn, LoginView $loginView, RepoListView $repoListView)
    {
        echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Committr</title>
            <link rel="stylesheet" type="text/css" href="assets/style.css">
          </head>
          <body>
            <h1>Committr</h1>

            '. $loginView->response($isLoggedIn) .'

            '. ($isLoggedIn ? $repoListView->renderListHTML() : "") .'

          </body>
        </html>
        ';
    }

}