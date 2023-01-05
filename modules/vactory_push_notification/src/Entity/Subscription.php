<?php

namespace Drupal\vactory_push_notification\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Notification subscription entity.
 *
 * @ingroup vactory_push_notification
 *
 * @ContentEntityType(
 *   id = "vactory_wpn_subscription",
 *   label = @Translation("Push Notification subscription"),
 *   handlers = {
 *     "storage_schema" = "Drupal\vactory_push_notification\SubscriptionStorageSchema",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "views_data" = "Drupal\vactory_push_notification\Entity\SubscriptionViewsData",
 *     "form" = {
 *       "delete" = "Drupal\vactory_push_notification\Form\SubscriptionDeleteForm",
 *     },
 *   },
 *   base_table = "vactory_wpn_subscriptions",
 *   data_table = "vactory_wpn_subscriptions_field_data",
 *   admin_permission = "administer push notification subscriptions",
 *   entity_keys = {
 *     "id" = "id",
 *   },
 *   links = {
 *     "delete-form" = "/admin/config/services/vactory-push-notification/subscriptions/{wpn_subscription}/delete",
 *   }
 * )
 */
class Subscription extends ContentEntityBase implements SubscriptionInterface {

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getPublicKey() {
    return $this->get('key')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setPublicKey($key) {
    $this->set('key', $key);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getToken() {
    return $this->get('token')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setToken($token) {
    $this->set('token', $token);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getEndpoint() {
    return $this->get('endpoint')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setEndpoint($endpoint) {
    $this->set('endpoint', $endpoint);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['key'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Key'))
      ->setDescription(t('Key'))
      ->setSettings([
        'max_length' => 191,
      ])
      ->setRequired(TRUE);

    $fields['token'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Token'))
      ->setDescription(t('Token'))
      ->setSettings([
        'max_length' => 191,
      ])
      ->setRequired(TRUE);

    $fields['endpoint'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Endpoint'))
      ->setDescription(t('Communication endpoint.'))
      ->setSettings([
        'max_length' => 512,
      ])
      ->setRequired(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the subscription was created.'));

    return $fields;
  }

}