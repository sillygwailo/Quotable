<?php
/**
 * @file
 * Contains \Drupal\quotable\Plugin\Filter\FilterPirate.
 */

namespace Drupal\quotable\Plugin\Filter;

use Drupal\filter\Annotation\Filter;
use Drupal\Core\Annotation\Translation;
use Drupal\filter\Plugin\FilterBase;

/**
 * Replaces the <q> element (with optional cite="[url]"
 * attribute) with curly quotes and a <span class="q"> wrapper.
 *
 * @Filter(
 *   id = "filter_quotable",
 *   module = "quotable",
 *   title = @Translation("Quotable filter"),
 *   type = FILTER_TYPE_TRANSFORM_IRREVERSIBLE,
 *   settings = {
 *     "quotable_class" = "q",
 *   },
 *   weight = -15
 * )
 */
class FilterQuotable extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode, $cache, $cache_id) {
    $class = check_plain($this->settings['quotable_class']);
    $replace = preg_replace('/<q[^>]*>(([^<]|<[^\/]|<\/[^q])*)<\/q>/', "<span class=\"" . $class . "\">&ldquo;\$1&rdquo;</span>", $text);
    return $replace;
  }

  /**
   * {@inheritdoc}
   */
  public function tips($long = FALSE) {
    return t('Replaces the &lt;q cite="[url]"&gt; element with curly quotes and a &lt;span class="q"&gt; wrapper');
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, array &$form_state) {
    $settings['quotable_class'] = array(
      '#type' => 'textfield',
      '#title' => t('Quotable CSS class name'),
      '#default_value' => $this->settings['quotable_class'],
      '#maxlength' => 32,
      '#description' => t('The CSS class name to wrap the quote with.'),
    );
    return $settings;
  }
}
