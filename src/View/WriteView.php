<?php
/**
 * Created by PhpStorm.
 * User: fyrkant
 * Date: 2015-10-27
 * Time: 16:14
 */

namespace Committr\View;


use Committr\Exceptions\AllEmptyException;
use Committr\Exceptions\ContentEmptyException;
use Committr\Exceptions\TitleEmptyException;
use Committr\Exceptions\UnsanitaryException;
use Committr\Model\CommitList;
use Committr\Model\Post;

class WriteView
{

    private static $title = "WriteView::Title";
    private static $content = "WriteView::Content";
    private static $save = "WriteView::Save";

    private static $sha = "newPost";

    /**
     * @var
     */
    private $commitList;
    /**
     * @var Messenger
     */
    private $messenger;

    public function __construct(CommitList $commitList, Messenger $messenger)
    {
        $this->commitList = $commitList;
        $this->messenger = $messenger;
    }

    public function render()
    {

        $sha = $this->getSHAGet();
        $baseCommit = $this->commitList->findWithSHA($sha);
        $repoName = explode("_::_", $sha)[1];

        $message = $baseCommit->getMessage();
        $dateTime = $baseCommit->getDateTime();
        $url = $baseCommit->getURL();

        $inputTitle = $this->getInput(self::$title);
        $inputContent = $this->getInput(self::$content);

        return '<a class="btn btn-default" href="?repo=' . $repoName . '">Back to repo</a>
                <h2>Write new post</h2>
                <div class="col-sm-8">
                    <p class="text-muted">Based on:</p>
                    <blockquote class="blockquote-reverse">
                        <p><a href="' . $url . '">' . $message . '</a></p>
                        <footer>Commit date: ' . $dateTime . '</footer>

                    </blockquote>

                    <form method="post" class="form-group">
                      <label for="' . self::$title . '">Title</label>
                      <input class="form-control" type="text" name="' . self::$title . '" id="' . self::$title . '" value="'. $inputTitle .'" />
                      <label for="' . self::$content . '">Content</label>
                      <textarea class="form-control" rows="6" type="text" name="' . self::$content . '" id="' . self::$content . '" >'. $inputContent .'</textarea>
                      <input class="btn btn-success bl-lg pull-right" id="submit" type="submit" name="' . self::$save . '" value="Save" />
                    </form>
                </div>
                ';
    }

    public function getSHAGet()
    {
        return $_GET[ self::$sha ];
    }

    private function getInput($name)
    {
        if (!isset($_POST[ $name ])) {
            return "";
        } else {
            return filter_var(trim($_POST[ $name ]), FILTER_SANITIZE_STRING);
        }
    }

    public function userWantsToSaveNewPost()
    {
        return isset($_POST[ self::$save ]);
    }

    public function getNewPost()
    {
        $sha = $this->getSHAGet();
        $baseCommit = $this->commitList->findWithSHA($sha);

        $title = $this->getInput(self::$title);
        $content = $this->getInput(self::$content);

        try {
            $toSave = new Post($baseCommit, $title, $content);

            return $toSave;
        } catch (UnsanitaryException $e) {
            $this->messenger->setMessageKey("Unsanitary");
        } catch (TitleEmptyException $e) {
            $this->messenger->setMessageKey("TitleEmpty");
        } catch (ContentEmptyException $e) {
            $this->messenger->setMessageKey("ContentEmpty");
        } catch (AllEmptyException $e) {
            $this->messenger->setMessageKey("AllEmpty");
        }

        return false;
    }


}