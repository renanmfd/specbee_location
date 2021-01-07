<?php

namespace Drupal\specbee_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\specbee_location\LocationTime;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "specbee_location_time_block",
 *   admin_label = @Translation("Location Time block"),
 * )
 */
class LocationTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The location time service.
   *
   * @var Drupal\specbee_location\LocationTime
   */
  protected $locationTime;

  /**
   * {@inheritdoc}
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\specbee_location\LocationTime $locationTime
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, LocationTime $locationTime) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->locationTime = $locationTime;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('specbee_location.location_time'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['specbee_location_time_block'] = [
      '#theme' => 'block__spcebee_location_time',
      '#time' => $this->locationTime->getTime(),
      '#location' => $this->locationTime->getLocation(),
      '#cache' => [
        'max-age' => 60,
      ],
    ];

    return $build;
  }

}
