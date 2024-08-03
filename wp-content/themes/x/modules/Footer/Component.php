<?php

namespace X_Modules\Footer;

use X_UI\Core\Menu;
use X_UI\Modules\Image\Component as Image;
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
                        <?= AbstractComponent::render_attributes($attr) ?>>
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
                              default:
                                break;
                            endswitch;
                            ?>
                          </span>
                          <?php
                        endif;
                        ?>
                        <span class="site-footer__contact__item__content"></span>
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
                      <svg width="97" height="19" viewBox="0 0 97 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1992_4951)">
                          <path
                            d="M22.9038 12.9945C23.5878 12.8873 24.2169 12.6496 24.771 12.2143C25.5099 11.6346 25.8885 10.8638 25.9826 9.93171C25.8866 9.89909 25.7906 9.83943 25.6946 9.83943C24.5671 9.83477 23.4396 9.83943 22.3121 9.8413C22.3121 9.3268 22.3121 8.8123 22.3121 8.29687C22.4932 8.29873 22.6742 8.30246 22.8553 8.30246C24.4025 8.30526 25.9506 8.30805 27.4979 8.31085C27.5317 8.67342 27.5994 9.036 27.5893 9.39764C27.5783 9.82918 27.5445 10.2691 27.4457 10.6876C26.9647 12.7176 25.6864 13.9825 23.7149 14.4457C21.3904 14.9919 19.3722 14.3385 17.8223 12.4865C15.2985 9.46941 16.4836 5.08684 19.8916 3.50886C20.5016 3.22645 21.1417 3.0624 21.8074 3.00089C22.1174 3.00089 22.4283 2.99996 22.7383 2.99902C23.9755 3.11274 25.0755 3.55547 26.0046 4.4111C26.0558 4.45863 26.1189 4.49219 26.193 4.54345C25.7897 4.9228 25.4267 5.26487 25.0289 5.63956C24.4556 5.1409 23.7533 4.72893 22.9093 4.6292C22.485 4.49965 22.0616 4.50244 21.6382 4.632C20.6918 4.76715 19.898 5.20894 19.2652 5.92477C17.1602 8.31085 18.2539 12.2488 21.4388 12.9357C21.5339 12.9563 21.63 12.9758 21.7251 12.9963C22.1183 13.1268 22.5106 13.1231 22.9038 12.9945Z"
                            fill="#F9F9F9" />
                          <path
                            d="M50.236 7.86959C50.2452 7.70369 50.2543 7.53685 50.2635 7.37094C50.2909 7.36255 50.3183 7.35509 50.3458 7.3467C50.792 7.35696 51.2373 7.36628 51.6836 7.37653C51.7064 7.4017 51.7302 7.42593 51.7531 7.4511C51.7586 7.7913 51.7677 8.1315 51.7677 8.47264C51.7686 10.3321 51.775 12.1925 51.7622 14.052C51.7595 14.4723 51.7284 14.902 51.6397 15.3112C51.3169 16.7997 50.4116 17.6861 48.9257 17.9387C48.505 17.9387 48.0844 17.9377 47.6637 17.9368C46.4256 17.6935 45.5715 16.9637 45.0082 15.7754C45.4828 15.5722 45.9236 15.383 46.3936 15.1816C46.475 15.3121 46.5427 15.4296 46.6186 15.5423C47.0511 16.1836 47.6299 16.5313 48.4145 16.4949C49.3554 16.452 50.0221 15.8825 50.1729 14.9384C50.226 14.6047 50.2187 14.2617 50.2388 13.9224C50.2296 13.8777 50.2196 13.8339 50.2104 13.7891L50.0788 13.9047C50.0275 13.9504 49.9754 13.996 49.9242 14.0417C49.9023 14.0604 49.8812 14.0781 49.8593 14.0967C49.0793 14.6587 48.195 14.7948 47.3245 14.5003C46.079 14.0799 45.203 13.201 44.8574 11.8775C44.2913 9.70855 45.6008 7.89103 47.0758 7.36162C47.1608 7.33272 47.2459 7.30383 47.3309 7.274H47.3291C47.4415 7.24604 47.5549 7.21808 47.6674 7.19012H47.6656C48.0332 7.18825 48.4008 7.18639 48.7684 7.18359C49.2923 7.2535 49.7294 7.50143 50.1098 7.86493C50.1921 7.9628 50.1967 7.9628 50.2388 7.86586L50.236 7.86959ZM47.9143 13.0789C48.2234 13.2159 48.5325 13.2178 48.8415 13.0789C49.4012 12.9363 49.8035 12.5858 50.0669 12.0751C50.3695 11.4879 50.429 10.8624 50.2635 10.2231C50.044 9.37487 49.5456 8.80352 48.6724 8.62643C48.4758 8.51551 48.2792 8.51644 48.0835 8.62736C47.1489 8.77742 46.3954 9.60696 46.3424 10.7655C46.2848 12.0285 47.0813 12.8953 47.9152 13.078L47.9143 13.0789Z"
                            fill="#F9F9F9" />
                          <path
                            d="M67.268 7.04046C67.2827 9.42188 67.2964 11.8033 67.311 14.1856C67.2882 14.2099 67.2653 14.2341 67.2424 14.2584C66.8556 14.2556 66.4688 14.2528 66.082 14.25C66.082 11.1369 66.082 8.02378 66.082 4.91069C66.082 4.79791 66.0875 4.6842 66.0903 4.57142C66.5027 4.56583 66.916 4.5593 67.3284 4.55371C68.2547 6.1988 69.181 7.84389 70.1083 9.48898C70.2866 9.80495 70.4667 10.1191 70.6834 10.5003C71.821 8.47863 72.9229 6.52036 74.0248 4.5621C74.4134 4.56396 74.802 4.56583 75.1907 4.56769C75.2144 4.59193 75.2382 4.61616 75.262 4.64039C75.2666 4.73919 75.2757 4.83799 75.2757 4.93679C75.2757 7.92219 75.2757 10.9076 75.2757 13.893C75.2757 13.9918 75.2666 14.0906 75.262 14.1894C75.2382 14.2127 75.2144 14.2369 75.1907 14.2602C74.8048 14.2556 74.4189 14.2509 74.0321 14.2462C74.033 12.8435 74.0284 11.4407 74.0376 10.037C74.044 9.0593 74.0696 8.0825 74.086 7.10477C74.086 7.033 74.086 6.9603 74.086 6.88853C74.0659 6.88573 74.0458 6.88294 74.0257 6.87921C73.9918 6.95191 73.9571 7.02368 73.9233 7.09638C73.06 8.63242 72.1968 10.1694 71.3318 11.7054C71.2486 11.8527 71.1589 11.9962 71.0721 12.1407C71.0501 12.1603 71.0273 12.1789 71.0053 12.1985C70.7831 12.1957 70.5618 12.192 70.3396 12.1892C70.3323 12.1612 70.3149 12.1454 70.2875 12.1398C70.2747 12.1146 70.2628 12.0894 70.25 12.0633C70.2299 12.0326 70.2107 12.0009 70.1906 11.9701C69.3127 10.408 68.4358 8.84493 67.5579 7.28279C67.5095 7.19704 67.4601 7.11129 67.4116 7.02554C67.3769 6.97894 67.3421 6.93234 67.3074 6.88573C67.2936 6.93793 67.2799 6.99012 67.2662 7.04325L67.268 7.04046Z"
                            fill="#F9F9F9" />
                          <path
                            d="M59.5537 7.19039C60.3529 7.31435 60.9656 7.75428 61.4667 8.37504C61.8316 8.82709 62.0812 9.34252 62.2504 9.94556C60.6254 10.6325 59.0151 11.3129 57.3774 12.0054C57.6435 12.5824 58.0449 12.9338 58.621 13.0782C58.9584 13.2152 59.2959 13.2152 59.6342 13.0801C60.1966 12.9571 60.5971 12.5954 60.9501 12.1107C61.3689 12.3932 61.7703 12.6653 62.2056 12.9589C61.6213 13.7847 60.8934 14.3337 59.9305 14.5257C59.6616 14.5788 59.3846 14.6077 59.1102 14.6133C57.2731 14.6488 55.8366 13.2292 55.6016 11.5515C55.4132 10.2065 55.6976 9.0107 56.6705 8.03949C57.1396 7.57067 57.7084 7.28266 58.365 7.18945C58.7609 7.18945 59.1569 7.19039 59.5537 7.19132V7.19039ZM58.6174 8.63788C57.6334 8.92868 57.0381 9.75729 57.1442 10.7387C58.2214 10.283 59.2867 9.83185 60.374 9.37141C60.1737 8.94732 59.8628 8.74134 59.4687 8.64161C59.1852 8.51019 58.9008 8.50925 58.6174 8.63881V8.63788Z"
                            fill="#F9F9F9" />
                          <path
                            d="M32.6994 7.18848C32.9518 7.25279 33.216 7.28727 33.4538 7.38701C34.6672 7.89684 35.3997 8.82145 35.6603 10.1291C36.0078 11.8721 35.14 13.6141 33.5727 14.3094C31.1622 15.3785 28.5515 13.6402 28.482 11.0099C28.4336 9.17004 29.5172 7.70484 31.218 7.21644C31.3094 7.19034 31.41 7.19687 31.507 7.18848C31.9047 7.18848 32.3016 7.18848 32.6994 7.18848ZM31.603 13.0735C31.9367 13.2152 32.2696 13.2152 32.6034 13.0735C33.687 12.6839 34.21 11.8283 34.1195 10.5952C34.0445 9.57549 33.3788 8.8317 32.3565 8.62292C32.1882 8.52039 32.02 8.52039 31.8508 8.62292C31.304 8.70867 30.8623 8.97338 30.5239 9.4217C29.6991 10.5141 29.9716 12.6038 31.603 13.0735Z"
                            fill="#F9F9F9" />
                          <path
                            d="M40.815 7.1875C41.0409 7.24342 41.2722 7.28071 41.4908 7.35714C42.1684 7.59574 42.717 8.02076 43.1413 8.6089C44.2267 10.1086 44.0521 12.3157 42.739 13.6001C42.0586 14.2647 41.2375 14.589 40.2938 14.6198C38.453 14.6813 36.8912 13.2897 36.6461 11.4918C36.3471 9.30422 37.5944 7.76538 39.1425 7.29096C39.2989 7.24342 39.4626 7.22199 39.6235 7.18843C40.0213 7.18843 40.4181 7.18843 40.8159 7.1875H40.815ZM39.9655 8.62381C39.3867 8.71422 38.9285 9.00502 38.5948 9.49342C37.8166 10.6315 38.1494 12.6186 39.7195 13.0725C40.0524 13.2152 40.3861 13.2152 40.719 13.0753C41.8081 12.6885 42.332 11.8329 42.2379 10.5951C42.1592 9.56706 41.4908 8.82047 40.4703 8.62288C40.3011 8.52221 40.1328 8.52128 39.9646 8.62474L39.9655 8.62381Z"
                            fill="#F9F9F9" />
                          <path
                            d="M84.9677 7.64113V8.53592C85.4689 7.94592 85.9782 7.55911 86.6485 7.45099C87.0426 7.45006 87.4367 7.4482 87.8308 7.44727C88.7462 7.61224 89.3826 8.17987 89.8609 8.94882C90.671 10.2509 90.608 12.4506 89.272 13.68C88.8724 14.0472 88.4307 14.3287 87.8948 14.4349C87.4587 14.434 87.0234 14.4331 86.5872 14.4312C85.9526 14.3007 85.4579 13.9316 84.9934 13.3845C84.9934 13.6017 84.9915 13.7368 84.9934 13.8729C85.0062 14.9084 85.0208 15.943 85.0299 16.9785C85.0299 17.0578 84.9934 17.1361 84.9732 17.2153C84.5873 17.1994 84.2005 17.1836 83.8147 17.1678C83.8083 17.069 83.7973 16.9702 83.7973 16.8714C83.7964 13.8897 83.7973 10.908 83.7973 7.92635C83.7973 7.82755 83.8064 7.72782 83.811 7.62902C84.1969 7.63275 84.5819 7.63741 84.9677 7.64113ZM86.8186 8.54151C86.0175 8.65708 85.4606 9.11007 85.1634 9.86224C84.8836 10.5715 84.8882 11.3079 85.1589 12.0209C85.7203 13.5019 87.5839 13.8244 88.5935 12.6184C89.1385 11.9668 89.2272 11.1998 89.1001 10.3795C88.9647 9.50526 88.2826 8.67106 87.3242 8.5443C87.156 8.43525 86.9877 8.43712 86.8186 8.54151Z"
                            fill="#F9F9F9" />
                          <path
                            d="M79.2889 8.5459C78.7256 8.6475 78.2647 8.90102 77.9877 9.49101C77.6255 9.33443 77.2735 9.1825 76.9242 9.03244C77.0833 8.28958 77.9328 7.60359 78.8655 7.44793C79.2907 7.44607 79.715 7.4442 80.1402 7.44141C81.5256 7.63341 82.4382 8.66893 82.4574 10.1183C82.4757 11.4959 82.461 12.8744 82.461 14.2529C82.0742 14.2585 81.6874 14.2641 81.2997 14.2697C81.2915 14.0171 81.2823 13.7645 81.2741 13.5119C81.2714 13.4747 81.2677 13.4383 81.265 13.401C81.2229 13.4364 81.1818 13.4728 81.1397 13.5082C80.7611 13.9808 80.3067 14.3321 79.7004 14.4384C79.2633 14.4365 78.8271 14.4337 78.39 14.4319C78.1459 14.3349 77.8862 14.2641 77.6585 14.1355C76.2649 13.3516 76.2795 11.2424 77.5844 10.4566C77.9584 10.232 78.3479 10.0605 78.7814 10.0055C79.2871 10.0055 79.7927 10.0074 80.2975 10.0083C80.5764 10.0931 80.8544 10.1789 81.1333 10.2637C81.1854 10.3103 81.2421 10.396 81.275 10.2488C81.275 9.37823 80.9074 8.87492 80.1046 8.64004C79.9994 8.60928 79.8961 8.57386 79.7918 8.54031C79.6227 8.43685 79.4544 8.43499 79.2871 8.54497L79.2889 8.5459ZM80.3039 11.0233C79.9345 10.9003 79.565 10.8966 79.1956 11.0215C78.8527 11.0541 78.5509 11.1864 78.3004 11.426C77.6548 12.043 77.8276 12.9415 78.6579 13.2463C79.8001 13.6657 80.8791 12.8604 81.1836 11.9833C81.3491 11.5061 81.2257 11.2806 80.7501 11.1221C80.6066 11.0746 80.4539 11.055 80.3048 11.0224L80.3039 11.0233Z"
                            fill="#F9F9F9" />
                          <path
                            d="M93.4226 8.55269C93.2443 8.62633 93.0477 8.672 92.8914 8.78012C92.4259 9.10168 92.457 9.67676 92.9508 9.94892C93.119 10.0421 93.3092 10.1008 93.4958 10.1502C93.8945 10.2556 94.3005 10.3339 94.6973 10.4438C94.9634 10.5175 95.2341 10.5986 95.4801 10.7244C96.7548 11.3768 96.9167 13.0061 95.8047 13.9195C95.4764 14.1898 95.0933 14.3417 94.6882 14.4461C94.1853 14.4424 93.6832 14.4396 93.1803 14.4359C92.1379 14.1246 91.4813 13.5485 91.1055 12.5913C91.4548 12.4422 91.8041 12.2931 92.1818 12.1318C92.4625 12.7442 92.8548 13.1972 93.5104 13.3342C93.8186 13.4647 94.1267 13.4647 94.4349 13.3314C94.5638 13.2801 94.6983 13.241 94.8199 13.1748C95.1125 13.0163 95.2789 12.7721 95.2734 12.4226C95.267 12.0852 95.0887 11.8419 94.8034 11.731C94.4166 11.581 94.0134 11.4626 93.6064 11.3824C92.9865 11.2603 92.425 11.0273 91.9111 10.6517C91.1018 10.0598 91.1667 8.76707 91.7538 8.2069C92.1818 7.79772 92.6746 7.53302 93.258 7.44727C93.6796 7.44727 94.1011 7.44727 94.5227 7.44727H94.52C94.6333 7.47523 94.7467 7.50412 94.861 7.53208C95.6529 7.77908 96.1229 8.19758 96.4137 8.94509C96.0781 9.0877 95.7416 9.2303 95.3868 9.3813C95.1253 8.92831 94.7934 8.60675 94.2795 8.5471C93.9932 8.43246 93.707 8.43059 93.4226 8.55269Z"
                            fill="#F9F9F9" />
                          <path
                            d="M54.5849 3.45272C54.5913 3.55152 54.6032 3.65032 54.6032 3.74912C54.6041 7.20894 54.6032 10.6688 54.6032 14.1286C54.6032 14.1994 54.5977 14.2702 54.594 14.3411C54.0682 14.3476 53.5434 14.3551 53.0176 14.3616C53.0093 14.2348 52.9929 14.1081 52.9929 13.9822C52.992 10.5961 52.992 7.20987 52.9929 3.82369C52.9929 3.69692 53.0084 3.57016 53.0166 3.44434C53.5388 3.44713 54.0618 3.44993 54.584 3.45366L54.5849 3.45272Z"
                            fill="#F9F9F9" />
                          <path
                            d="M75.271 14.2648L75.2307 14.2667L75.1914 14.2574C75.2152 14.2341 75.239 14.2098 75.2627 14.1865C75.2783 14.2117 75.281 14.2378 75.271 14.2648Z"
                            fill="#F9F9F9" />
                          <path
                            d="M75.1914 4.56575C75.217 4.55829 75.2417 4.55643 75.2682 4.55829C75.281 4.58625 75.2792 4.61235 75.2627 4.63845C75.239 4.61421 75.2152 4.58998 75.1914 4.56575Z"
                            fill="#F9F9F9" />
                          <path
                            d="M11.6443 3.36719C11.7238 3.53216 11.8034 3.69714 11.882 3.86211C11.8957 3.89101 11.9085 3.9199 11.9223 3.94879C12.4453 5.39349 12.4764 6.84099 12.0603 8.33042C11.7842 9.31841 11.3224 10.1862 10.7353 10.9961C10.172 11.7725 9.57765 12.5256 8.99242 13.2853C8.36329 14.1027 7.77714 14.9509 7.3245 15.8811C7.11875 16.3033 7.00811 16.774 6.85265 17.2223C6.80145 17.3696 6.75572 17.5187 6.69171 17.6594C6.59113 17.8813 6.42653 18.0192 6.17232 18.0211C5.91354 18.0239 5.759 17.8785 5.66024 17.6548C5.60903 17.5383 5.55508 17.4218 5.52216 17.2987C5.12438 15.8018 4.31511 14.5352 3.39062 13.3319C3.5031 13.2088 3.62106 13.0905 3.72713 12.9628C4.94607 11.4948 6.16409 10.0249 7.37845 8.55319C7.43606 8.48328 7.46441 8.38728 7.50556 8.30246L7.50007 8.30619C7.53116 8.26704 7.56225 8.2279 7.59334 8.18782C7.81281 7.94175 8.03318 7.69569 8.25265 7.45056C8.28374 7.3937 8.31391 7.33684 8.345 7.27999L8.34226 7.28558L8.42181 7.19144L8.41633 7.19424C8.53703 7.08239 8.67145 6.98266 8.7757 6.85683C9.73494 5.69641 10.6887 4.53133 11.6443 3.36812V3.36719Z"
                            fill="#086030" />
                          <path
                            d="M7.50791 8.30277C7.46585 8.38665 7.43841 8.48266 7.3808 8.55349C6.16553 10.0252 4.94842 11.4942 3.72949 12.9631C3.62341 13.0908 3.50545 13.2091 3.39298 13.3322C2.81689 12.5763 2.22891 11.8288 1.66745 11.0617C1.25413 10.4968 0.854522 9.91803 0.625 9.24136C1.35563 8.3531 2.0826 7.46205 2.8178 6.57938C3.20278 6.11708 3.60421 5.66876 3.99833 5.21484C3.9709 5.33694 3.94621 5.45998 3.91603 5.58114C3.66822 6.55981 3.88768 7.41451 4.64117 8.07162C5.40655 8.73897 6.27983 8.83311 7.2034 8.41741C7.30216 8.37267 7.40641 8.34192 7.50791 8.3037V8.30277Z"
                            fill="#FEBE00" />
                          <path
                            d="M11.644 3.36735C10.6884 4.53057 9.73469 5.69565 8.77545 6.85607C8.6712 6.98189 8.53678 7.08163 8.41608 7.19347C8.42614 7.08349 8.42522 6.96978 8.449 6.86259C8.74802 5.52415 8.03659 4.31806 6.73261 3.95828C6.35495 3.81754 5.9773 3.81847 5.60055 3.95828C5.37011 4.04124 5.14059 4.12419 4.91016 4.20714C4.96685 4.08131 5.00068 3.93591 5.0839 3.83245C5.54843 3.25737 6.02759 2.69441 6.49761 2.12492C7.00329 1.51255 7.50531 0.896456 8.00916 0.282227C8.67486 0.427628 9.2537 0.763171 9.79687 1.16023C10.5878 1.73904 11.2215 2.46232 11.644 3.36642V3.36735Z"
                            fill="#259393" />
                          <path
                            d="M3.99755 5.21334C3.60343 5.66818 3.20199 6.11651 2.81702 6.57881C2.0809 7.46241 1.35485 8.35346 0.624217 9.24078C0.295022 8.59393 0.142312 7.89954 0.0545271 7.18185C-0.0533755 6.29826 -0.00491079 5.42678 0.233755 4.57115C0.475165 3.7034 0.847337 2.90275 1.46183 2.23633C2.42107 3.06493 3.38031 3.8926 4.33954 4.72121C4.22524 4.88525 4.11185 5.04929 3.99755 5.21334Z"
                            fill="#C6000C" />
                          <path
                            d="M4.33865 4.7209C3.37941 3.8923 2.42017 3.06463 1.46094 2.23602C2.32782 1.1278 3.46262 0.458577 4.80135 0.128627C5.00344 0.0782957 5.21193 0.0559262 5.41767 0.0205078C5.91604 0.0214399 6.41349 0.0223719 6.91185 0.023304C7.27762 0.109986 7.64339 0.196668 8.00917 0.28335C7.50532 0.897579 7.00329 1.51367 6.49761 2.12604C6.02668 2.69553 5.54844 3.25943 5.08391 3.83358C5.00069 3.93704 4.96686 4.08244 4.91017 4.20827L4.90651 4.21106C4.87999 4.23157 4.85347 4.25207 4.82695 4.27258C4.66418 4.42171 4.50142 4.57084 4.33865 4.7209Z"
                            fill="#259393" />
                          <path
                            d="M7.5 8.30685C7.53109 8.2677 7.56218 8.22856 7.59327 8.18848C7.56218 8.22762 7.53109 8.26677 7.5 8.30685Z"
                            fill="#FEBE00" />
                          <path
                            d="M8.34375 7.28554C8.37027 7.25385 8.39679 7.22216 8.42331 7.19141C8.39679 7.2231 8.37027 7.25479 8.34375 7.28554Z"
                            fill="#259393" />
                        </g>
                        <defs>
                          <clipPath id="clip0_1992_4951">
                            <rect width="96.5455" height="18" fill="white" transform="translate(0 0.0205078)" />
                          </clipPath>
                        </defs>
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
