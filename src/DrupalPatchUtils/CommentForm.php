<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 01/09/2013
 * Time: 15:23
 * To change this template use File | Settings | File Templates.
 */

namespace DrupalPatchUtils;


use Symfony\Component\DomCrawler\Form;

class CommentForm {

  const STATUS_ACTIVE = 1;
  const STATUS_NEEDS_WORK = 13;
  const STATUS_NEEDS_REVIEW = 8;
  const STATUS_RTBC = 14;
  const STATUS_PATCH = 15;
  const STATUS_FIXED = 2;
  const STATUS_POSTPONED = 14;
  const STATUS_POSTPONED_MORE_INFO = 16;
  const STATUS_CLOSED_DUPLICATE = 3;
  const STATUS_CLOSED_WONT_FIX = 5;
  const STATUS_CLOSED_WORKS = 6;
  const STATUS_CLOSED_CANT_REPRODUCE = 18;
  const STATUS_CLOSED_FIXED = 7;

  const TAG_NEEDS_REROLL = 'Needs reroll';

  /**
   * @var \Symfony\Component\DomCrawler\Form
   */
  protected $form;

  public function __construct (Form $form) {
    $this->form = $form;
  }

  /**
   * @return $this
   */
  public function setStatusNeedsWork() {
    $this->setStatus(static::STATUS_NEEDS_WORK);
    return $this;
  }

  public function setCommentText($text) {
    $comment = $this->form->get('comment');
    $comment->setValue($text);
    $this->form->set($comment);
    return $this;
  }

  public function ensureTag($value) {
    $tags = $this->form->get('taxonomy[tags][9]');
    if (strpos($tags->getValue(), $value) === FALSE) {
      if (strlen($tags->getValue()) == 0) {
        $tags->setValue($value);
      }
      else {
        $tags->setValue($tags->getValue() . ', '. $value);
      }
      $this->form->set($tags);
    }
  }

  public function getForm () {
    return $this->form;
  }
  /**
   * @param integer $value
   * @return $this
   */
  protected function setStatus($value) {
    $status = $this->form->get('sid');
    $status->setValue($value);
    $this->form->set($status);
    return $this;
  }

}