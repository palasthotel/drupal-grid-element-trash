<?php

namespace Drupal\grid_element_trash\Form;

/**
 * Confirmation for putting a reusable box on the trash list.
 */
class ReusableBoxTrashForm extends ReusableTrashFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'grid_reusable_box_trash';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Do you really want to put the reusable box %id to the trash?', ['%id' => $this->reusableId]);
  }

  /**
   * {@inheritdoc}
   */
  protected function getTrashKey(): string {
    return 'trashed_reuse_boxes';
  }

  /**
   * {@inheritdoc}
   */
  protected function getReusableIds(): array {
    return grid_get_storage()->getReuseableBoxIds();
  }

  /**
   * {@inheritdoc}
   */
  protected function getContentTypes(): array {
    return $this->config('grid.settings')->get('enabled_node_types') ?: [];
  }

  /**
   * {@inheritdoc}
   */
  protected function getOverviewRoute(): string {
    return 'grid.admin.reusableboxes.overview';
  }

  /**
   * {@inheritdoc}
   */
  protected function getSuccessMessage() {
    return $this->t('The box has been put to the trash.');
  }

}
