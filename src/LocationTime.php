<?php

namespace Drupal\specbee_location;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class MyTools.
 */
class LocationTime {

  /**
   * ConfigFactory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Time service.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $datetime;

  /**
   * Formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $formatter;

  /**
   * Constructs a new MyTools object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   * @param \Drupal\Component\Datetime\TimeInterface $datetime
   * @param \Drupal\Core\Datetime\DateFormatterInterface $formatter
   */
  public function __construct(ConfigFactoryInterface $configFactory, TimeInterface $datetime, DateFormatterInterface $formatter) {
    $this->configFactory = $configFactory;
    $this->datetime = $datetime;
    $this->formatter = $formatter;
  }

  /**
   * Get the request time.
   *
   * @return string
   *   Return the formatted time.
   */
  public function getTime() {
    $config = $this->configFactory->get('specbee_location.adminsettings');
    $time = $this->datetime->getRequestTime();
    $format = 'jS M Y - h:i A';
    return $this->formatter->format($time, 'custom', $format, $config->get('timezone'), NULL);;
  }

  /**
   * Get the site location.
   *
   * @return array
   *   Return the location of the site.
   */
  public function getLocation() {
    $config = $this->configFactory->get('specbee_location.adminsettings');
    return [
      'city' => $config->get('city'),
      'country' => $config->get('country'),
      'timezone' => $config->get('timezone'),
    ];
  }

}
