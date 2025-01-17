<?php

namespace Drupal\vactory_otp\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class VactoryOtpConfigForm.
 */
class VactoryOtpConfigForm extends ConfigFormBase {

  /**
   * Function get Editable Config Names.
   */
  protected function getEditableConfigNames() {
    return [
      'vactory_otp.settings',
    ];
  }

  /**
   * Function Get Form Id.
   */
  public function getFormId() {
    return 'vactory_otp_settings_form';
  }

  /**
   * Function build Form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('vactory_otp.settings');

    $form = [];

    $form['url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url'),
      '#required' => TRUE,
      '#default_value' => $config->get('url'),
    ];

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Api Key'),
      '#required' => TRUE,
      '#default_value' => $config->get('api_key'),
    ];

    $form['from'] = [
      '#type' => 'textfield',
      '#title' => $this->t('From'),
      '#required' => TRUE,
      '#default_value' => $config->get('from'),
    ];

    $form['cooldown'] = [
      '#type' => 'number',
      '#title' => $this->t('Cooldown (in seconds)'),
      '#required' => TRUE,
      '#default_value' => $config->get('cooldown'),
    ];

    $form['default_sms_body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Default SMS Body'),
      '#default_value' => $config->get('default_sms_body'),
    ];

    $form['default_mail_body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Default Mail Body'),
      '#format' => 'full_html',
      '#default_value' => $config->get('default_mail_body')['value'] ?? '',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Enregistrer la configuration'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * Function Submittion Form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('vactory_otp.settings');

    $config->set('url', $form_state->getValue('url'));
    $config->set('api_key', $form_state->getValue('api_key'));
    $config->set('from', $form_state->getValue('from'));
    $config->set('cooldown', $form_state->getValue('cooldown'));
    $config->set('default_sms_body', $form_state->getValue('default_sms_body'));
    $config->set('default_mail_body', $form_state->getValue('default_mail_body'));

    $config->save();

    parent::submitForm($form, $form_state);
  }

}
