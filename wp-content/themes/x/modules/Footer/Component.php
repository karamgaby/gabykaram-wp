<?php

namespace X_Modules\Footer;

use X_UI\Core\Menu;
use X_UI\Modules\Image\Component as Image;
use X_UI\Modules\Svg\Component as Icon;
use \X_UI\Core\AbstractComponent;

/**
 * Component: Footer
 *
 * @example
 * X_Footer::render();
 *
 * @package axio
 */
class Component extends AbstractComponent
{


  public static function frontend($data)
  {
    $acfData = get_field('footer_data', 'option');

    $logoId = $acfData['logo']['id'];
    $about = $acfData['about'];
    $site_map_title = $acfData['site_map_title'];
    $contact_section = $acfData['contact_section'];
    $contact_section_title = $contact_section['title'];
    $contact_section_content = $contact_section['content'];
    $contact_section_items = $contact_section['contact_items'];
    $location_section = $acfData['location_section'];
    $location_section_title = $location_section['title'];
    $location_section_google_map_link = $location_section['google_map_link'];
    $menu_location = "site_map";
    $menu_items = Menu::get_location_menu_items($menu_location);
    ?>
    <footer <?php parent::render_attributes($data['attr']); ?>>
      <?php

      ?>
      <div class="container">
        <div class="row site-footer__container">
          <div class="col-24 col-lg-10 offset-lg-2 mb-3 mb-lg-0">
            <div class="site-footer__about-section d-flex gap-3 align-items-center">
              <div class="site-footer__logo">
                <?php
                Image::render(
                  array(
                    'size' => 'full',
                    'id' => $logoId
                  )
                );
                ?>
              </div>
              <?php
              if (!empty($about)):
                ?>
                <div class="site-footer__about">
                  <?= $about; ?>
                </div>
                <?php
              endif;
              ?>
            </div>
          </div>
          <div class="col-24 col-lg-12">
            <div class="site-footer__explore">
              <div class="site-footer__sitemap">
                <p class="site-footer__title text-start mb-1"><?= $site_map_title ?></p>
                <div class="d-flex flex-column gap-1" role="list">
                  <?php
                  foreach ($menu_items as $menu_item):
                    $title = apply_filters('the_title', $menu_item->title, $menu_item->ID);
                    $title = apply_filters('nav_menu_item_title', $title, $menu_item, [
                      'theme_location' => $menu_location
                    ], 0);
                    $link_attr = Menu::get_menu_item_link_attr($menu_item, [
                      'theme_location' => $menu_item
                    ], 0);
                    $list_attr = Menu::get_menu_item_list_attr($menu_item, [
                      'theme_location' => $menu_item
                    ], 0);
                    if (!isset($list_attr['class'])) {
                      $list_attr['class'] = [];
                    } else if (!is_array($list_attr['class'])) {
                      $list_attr['class'] = [$list_attr['class']];
                    }
                    $list_attr['class'][] = 'text-start site-footer__sitemap__list-item ';
                    ?>
                    <div role="listitem" <?php AbstractComponent::render_attributes($list_attr) ?>>
                      <a <?php AbstractComponent::render_attributes($link_attr) ?>> <?= $title; ?></a>
                    </div>
                    <?php
                  endforeach;
                  ?>
                </div>
              </div>
              <div class="site-footer__contact">
                <p class="site-footer__title text-start mb-1"><?= $contact_section_title ?></p>
                <div class="site-footer__contact__items d-flex gap-1 flex-column">
                  <!-- <?= $contact_section_content ?> -->
                  <?php
                  if (is_array($contact_section_items)):
                    foreach ($contact_section_items as $item):
                      $html_tag = 'div';
                      $attr = [];
                      if (!empty($item['url'])):
                        $html_tag = 'a';
                        $attr['href'] = $item['url'];
                        $attr['target'] = '_blank';
                      endif;

                      ?>
                      <<?= $html_tag ?> class="site-footer__contact__item"
                        <?php AbstractComponent::render_attributes($attr) ?>>
                        <?php
                        if (!empty($item['type'])):
                          ?>
                          <span class="site-footer__contact__item__icon">
                            <?php
                            switch ($item['type']):
                              case 'phone':
                                ?>
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <g clip-path="url(#clip0_1992_4938)">
                                    <path
                                      d="M9.36491 1.3536C10.7238 1.49678 11.993 2.09946 12.9628 3.06198C13.9326 4.02451 14.5448 5.28921 14.6982 6.64693M9.36491 4.02026C10.0206 4.14956 10.6223 4.47295 11.0918 4.94847C11.5614 5.42399 11.8772 6.02968 11.9982 6.68693M14.665 11.3002V13.3002C14.6657 13.4859 14.6277 13.6697 14.5533 13.8398C14.479 14.0099 14.3699 14.1626 14.233 14.2882C14.0962 14.4137 13.9347 14.5092 13.7588 14.5687C13.5829 14.6282 13.3966 14.6503 13.2117 14.6336C11.1602 14.4107 9.18966 13.7097 7.45833 12.5869C5.84755 11.5634 4.48189 10.1977 3.45833 8.58691C2.33165 6.84772 1.63049 4.86758 1.41166 2.80691C1.395 2.62256 1.41691 2.43675 1.47599 2.26133C1.53508 2.08591 1.63004 1.92471 1.75484 1.78799C1.87964 1.65128 2.03153 1.54205 2.20086 1.46726C2.37018 1.39247 2.55322 1.35375 2.73833 1.35358H4.73833C5.06187 1.3504 5.37552 1.46497 5.62084 1.67594C5.86615 1.8869 6.02638 2.17988 6.07166 2.50025C6.15608 3.14029 6.31263 3.76873 6.53833 4.37358C6.62802 4.6122 6.64744 4.87152 6.59427 5.12083C6.5411 5.37014 6.41757 5.59899 6.23833 5.78025L5.39166 6.62691C6.3407 8.29594 7.72263 9.67788 9.39166 10.6269L10.2383 9.78025C10.4196 9.60101 10.6484 9.47748 10.8977 9.42431C11.1471 9.37114 11.4064 9.39055 11.645 9.48025C12.2498 9.70595 12.8783 9.8625 13.5183 9.94691C13.8422 9.9926 14.1379 10.1557 14.3494 10.4052C14.5608 10.6548 14.6731 10.9733 14.665 11.3002Z"
                                      stroke="#FFF060" stroke-linecap="round" stroke-linejoin="round" />
                                  </g>
                                  <defs>
                                    <clipPath id="clip0_1992_4938">
                                      <rect width="16" height="16" fill="white" transform="translate(0 0.0205078)" />
                                    </clipPath>
                                  </defs>
                                </svg>

                                <?php
                                break;
                              case 'mail':
                                ?>
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path
                                    d="M14.6654 4.6875L8.68536 8.4875C8.47955 8.61645 8.24158 8.68484 7.9987 8.68484C7.75582 8.68484 7.51785 8.61645 7.31203 8.4875L1.33203 4.6875M2.66536 2.6875H13.332C14.0684 2.6875 14.6654 3.28445 14.6654 4.02083V12.0208C14.6654 12.7572 14.0684 13.3542 13.332 13.3542H2.66536C1.92898 13.3542 1.33203 12.7572 1.33203 12.0208V4.02083C1.33203 3.28445 1.92898 2.6875 2.66536 2.6875Z"
                                    stroke="#FFF060" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <?php
                                break;
                              case 'x':
                                Icon::render([
                                  'name' => 'x',
                                  'attr' => [
                                    'style' => [
                                      'color' => '#FFF060'
                                    ]
                                  ]
                                ]);
                                ?>
                                <?php
                                break;
                              default:
                                break;
                            endswitch;
                            ?>
                          </span>
                          <?php
                        endif;
                        ?>
                        <span class="site-footer__contact__item__content">
                          <?= $item['content']; ?>
                        </span>
                        </<?= $html_tag ?>>
                        <?php
                    endforeach;
                  endif;

                  ?>
                </div>
              </div>
              <div class="site-footer__location">
                <p class="site-footer__title text-start mb-1"><?= $location_section_title ?></p>
                <div class="site-footer__location__google-map">
                  <?php
                  if (!empty($location_section_google_map_link)):

                    ?>
                    <a href="<?= $location_section_google_map_link ?>" target="_blank">
                      <svg width="177" height="46" viewBox="0 0 177 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M68.4992 18.4282L65.3302 19.8982C64.5242 19.0912 63.7462 18.4862 62.1042 18.4862C60.2322 18.4862 58.2442 19.8982 58.2442 22.6052C58.2442 25.2842 60.2322 26.6662 62.1042 26.6662C63.7462 26.6662 64.5242 26.0902 65.3302 25.2842L68.5282 26.7532C67.0882 29.1732 64.8412 30.2962 62.0472 30.2962C58.7052 30.2962 54.2412 27.8762 54.2412 22.6052C54.2412 17.3912 58.7052 14.8282 62.0472 14.8282C64.7832 14.8282 67.0872 16.0082 68.4992 18.4282ZM72.6662 22.6342C72.6662 25.2842 74.6542 26.6952 76.5262 26.6952C78.3702 26.6952 80.3862 25.2842 80.3862 22.6342C80.3862 19.8972 78.3702 18.4862 76.5262 18.4862C74.6542 18.4862 72.6662 19.8972 72.6662 22.6342ZM84.3612 22.6342C84.3612 27.8762 79.9252 30.3542 76.5262 30.3542C73.1272 30.3542 68.6632 27.8762 68.6632 22.6342C68.6632 17.3912 73.1272 14.8282 76.5262 14.8282C79.9252 14.8282 84.3612 17.3912 84.3612 22.6342ZM96.7402 22.5472C96.7402 19.8692 94.8402 18.4862 92.7952 18.4862C90.7502 18.4862 88.9922 19.8692 88.9922 22.5472C88.9922 25.3132 90.7502 26.6952 92.7952 26.6952C94.8402 26.6952 96.7402 25.3132 96.7402 22.5472ZM100.658 9.7012V30.0652H96.5402V27.7032C96.5402 28.7692 94.6102 30.3532 92.0762 30.3532C88.9362 30.3532 84.9902 27.8762 84.9902 22.5472C84.9902 17.3912 88.9362 14.8272 92.0762 14.8272C94.6102 14.8272 96.5402 16.4982 96.5402 17.1902V9.7002H100.66L100.658 9.7012ZM106.182 21.1072H113.326C112.865 19.2642 111.223 18.3422 109.726 18.3422C108.256 18.3422 106.73 19.2642 106.182 21.1072ZM116.955 24.0172H106.153C106.643 25.8892 108.17 26.8682 110.157 26.8682C112.03 26.8682 112.75 26.4362 113.815 25.8602L116.091 28.0782C114.766 29.4322 112.951 30.3532 110.013 30.3532C106.298 30.3532 102.063 27.7902 102.063 22.6332C102.063 17.3912 106.355 14.8282 109.725 14.8282C113.124 14.8282 117.848 17.3922 116.955 24.0172ZM121.607 22.5472C121.607 25.3132 123.364 26.6952 125.409 26.6952C127.454 26.6952 129.355 25.3132 129.355 22.5472C129.355 19.8692 127.454 18.4862 125.409 18.4862C123.364 18.4862 121.607 19.8692 121.607 22.5472ZM129.154 17.1902V15.0872H133.272V30.0652H129.154V27.7032C129.154 28.7692 127.224 30.3532 124.689 30.3532C121.549 30.3532 117.603 27.8762 117.603 22.5472C117.603 17.3912 121.549 14.8272 124.689 14.8272C127.224 14.8272 129.154 16.4982 129.154 17.1902ZM147.127 22.5472C147.127 19.8692 145.37 18.4862 143.325 18.4862C141.28 18.4862 139.379 19.8692 139.379 22.5472C139.379 25.3132 141.279 26.6952 143.325 26.6952C145.37 26.6952 147.127 25.3132 147.127 22.5472ZM151.131 22.5472C151.131 27.8772 147.185 30.3532 144.045 30.3532C141.51 30.3532 139.58 28.7692 139.58 27.7032V30.0652H135.461V9.7012H139.58V17.1902C139.58 16.4982 141.51 14.8282 144.045 14.8282C147.185 14.8282 151.131 17.3902 151.131 22.5472Z"
                          fill="white" />
                        <mask id="mask0_66_27931" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0"
                          width="177" height="45">
                          <path d="M0 44.989H176.955V0H0V44.989Z" fill="white" />
                        </mask>
                        <g mask="url(#mask0_66_27931)">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M152.573 30.0652H156.693V9.7002H152.573V30.0652ZM162.205 21.1072H169.349C168.888 19.2642 167.246 18.3422 165.749 18.3422C164.279 18.3422 162.752 19.2642 162.205 21.1072ZM172.978 24.0172H162.176C162.666 25.8892 164.193 26.8682 166.18 26.8682C168.052 26.8682 168.773 26.4362 169.838 25.8602L172.114 28.0782C170.789 29.4322 168.974 30.3532 166.036 30.3532C162.32 30.3532 158.086 27.7902 158.086 22.6332C158.086 17.3912 162.378 14.8282 165.748 14.8282C169.147 14.8282 173.871 17.3922 172.978 24.0172Z"
                            fill="white" />
                        </g>
                        <mask id="mask1_66_27931" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0"
                          width="177" height="45">
                          <path d="M0 44.989H176.955V0H0V44.989Z" fill="white" />
                        </mask>
                        <g mask="url(#mask1_66_27931)">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M14.9961 29.9921C14.9961 38.2751 21.7101 44.9891 29.9921 44.9891C38.2751 44.9891 44.9891 38.2751 44.9891 29.9921C44.9891 21.7101 38.2751 14.9961 29.9921 14.9961V29.9921H14.9961Z"
                            fill="#FFB199" />
                        </g>
                        <mask id="mask2_66_27931" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0"
                          width="177" height="45">
                          <path d="M0 44.989H176.955V0H0V44.989Z" fill="white" />
                        </mask>
                        <g mask="url(#mask2_66_27931)">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M29.992 14.996V0H0V29.992H14.996V14.996H29.992Z"
                            fill="#165260" />
                        </g>
                      </svg>
                    </a>
                    <?php
                  endif;
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </footer>
    <?php
  }

  public static function backend($args = [])
  {

    if (!isset($args['attr']['class'])) {
      $args['attr']['class'] = [];
    }
    $args['attr']['class'][] = 'site-footer';
    $args['attr']['class'][] = 'js-site-footer';

    // id
    $args['attr']['id'] = 'colophon';

    // Schema.org
    $args['attr']['itemscope'] = null;
    $args['attr']['itemtype'] = 'https://schema.org/WPFooter';

    return $args;

  }

}
