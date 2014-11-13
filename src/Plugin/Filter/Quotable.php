<?php
/**
 * @file
 * Contains \Drupal\quotable\Plugin\Filter\FilterPirate.
 */

namespace Drupal\quotable\Plugin\Filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Component\Utility\String;

/**
 * Replaces the <q> element (with optional cite="[url]"
 * attribute) with curly quotes and a <span class="q"> wrapper.
 *
 * @Filter(
 *   id = "filter_quotable",
 *   module = "quotable",
 *   title = @Translation("Quotable filter"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE,
 *   settings = {
 *     "quotable_class" = "q",
 *   },
 *   weight = -15
 * )
 */
class Quotable extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $class = String::checkPlain($this->settings['quotable_class']);
    if (!empty($class)) {
      $replacement = "<span class=\"" . $class . "\">&ldquo;\$1&rdquo;</span>";
    }
    else {
      $replacement = "&ldquo;\$1&rdquo;";
    }
    $replacement_text = preg_replace('/<q[^>]*>(([^<]|<[^\/]|<\/[^q])*)<\/q>/', $replacement, $text);
    return new FilterProcessResult($replacement_text);
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
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settings['quotable_class'] = array(
      '#type' => 'textfield',
      '#title' => t('Quotable CSS class name'),
      '#default_value' => $this->settings['quotable_class'],
      '#maxlength' => 32,
      '#description' => t('The CSS class name to wrap the quote with. Leave empty for none.'),
    );
    return $settings;
  }
}
