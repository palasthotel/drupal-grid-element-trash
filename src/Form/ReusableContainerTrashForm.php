<?php

namespace Drupal\grid_element_trash\Form;

/**
 * Confirmation for putting a reusable container on the trash list.
 */
class ReusableContainerTrashForm extends ReusableTrashFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'grid_reusable_container_trash';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Do you really want to put the reusable container %id to the trash?', ['%id' => $this->reusableId]);
  }

  /**
   * {@inheritdoc}
   */
  protected function getTrashKey(): string {
    return 'trashed_reuse_containers';
  }

  /**
   * {@inheritdoc}
   */
  protected function getReusableIds(): array {
    return grid_get_storage()->getReuseContainerIds();
  }

  /**
   * {@inheritdoc}
   *
   * The sidebar content type has no reusable containers.
   */
  protected function getContentTypes(): array {
    $settings = $this->config('grid.settings');
    $sidebar = $settings->get('sidebar_content');
    return array_values(array_filter($settings->get('enabled_node_types') ?: [], function ($type) use ($sidebar) {
      return $type !== $sidebar;
    }));
  }

  /**
   * {@inheritdoc}
   */
  protected function getOverviewRoute(): string {
    return 'grid.admin.reusablecontainer.overview';
  }

  /**
   * {@inheritdoc}
   */
  protected function getSuccessMessage() {
    return $this->t('The container has been put to the trash.');
  }

}
