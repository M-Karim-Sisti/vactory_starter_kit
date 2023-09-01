<?php

namespace Drupal\vactory_content_package\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Migration import form.
 */
class ContentPackageImportingExportedNodesForm extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'vactory_content_package.importing_exported_nodes';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("Start import"),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * Form Validation.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $url = \Drupal::request()->query->get('url');
    if (!file_exists($url)) {
      $form_state->setErrorByName('submit', $this->t('Import is currently unavailable.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $url = \Drupal::request()->query->get('url');
    \Drupal::service('vactory_content_package.import.manager')
      ->importNodes($url);
  }

}