<?php

namespace Drupal\grid_element_trash\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Confirmation for putting a reusable box or container on the trash list.
 *
 * The list is the config grid.trash, which the box and container trash forms edit. A
 * trashed element is not offered in the editor anymore, but stays in the
 * grids that use it; it is neither deleted nor changed.
 */
abstract class ReusableTrashFormBase extends ConfirmFormBase {

  /**
   * The id of the reusable element.
   *
   * @var string
   */
  protected $reusableId;

  /**
   * Key of the trash list in the grid.trash config.
   */
  abstract protected function getTrashKey(): string;

  /**
   * The ids of all reusable elements.
   *
   * @return array
   *   The ids.
   */
  abstract protected function getReusableIds(): array;

  /**
   * The content types the element is trashed for.
   *
   * @return string[]
   *   The machine names of the content types.
   */
  abstract protected function getContentTypes(): array;

  /**
   * Route of the overview page the form returns to.
   */
  abstract protected function getOverviewRoute(): string;

  /**
   * Message shown after the element has been put on the trash list.
   */
  abstract protected function getSuccessMessage();

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
    $ids = array_map('strval', $this->getReusableIds());
    if ($id === NULL || !in_array((string) $id, $ids, TRUE)) {
      throw new NotFoundHttpException();
    }
    $this->reusableId = (string) $id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('The element is not offered in the grid editor anymore. It stays in the grids that already use it and is not deleted. You can bring it back on the box and container trash pages.');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Put to trash');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return Url::fromRoute($this->getOverviewRoute());
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $contentTypes = $this->getContentTypes();
    if (empty($contentTypes)) {
      $this->messenger()->addWarning($this->t('Grid is not enabled for any content type, so there is nothing to put to trash.'));
    }
    else {
      $config = $this->configFactory()->getEditable('grid.trash');
      $trashed = $config->get($this->getTrashKey()) ?: [];
      $entry = $trashed[$this->reusableId] ?? [];
      foreach ($contentTypes as $contentType) {
        $entry[$contentType] = $contentType;
      }
      $trashed[$this->reusableId] = $entry;
      $config->set($this->getTrashKey(), $trashed)->save();
      $this->messenger()->addStatus($this->getSuccessMessage());
    }
    $form_state->setRedirect($this->getOverviewRoute());
  }

}
