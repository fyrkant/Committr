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

    public function renderPage()
    {
        echo '<!DOCTYPE html>
        <html>
          <head>
            <meta charset="utf-8">
            <title>Committr</title>
            <link rel="stylesheet" type="text/css" href="assets/style.css">
          </head>
          <body>

          <div><p>Hello!</p></div>

          </body>
        </html>
        ';
    }

}