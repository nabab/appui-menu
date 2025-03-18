<!-- TREEMENU -->
<bbn-slider orientation="left"
            ref="slider"
            :style="{
              zIndex: 100,
              maxWidth: '100%'
            }"
            @show="focusSearchMenu"
            close-button="top-right">
  <div class="bbn-h-100"
      :style="{width: isMobile && !isTablet ? '100%' : '35rem'}">
    <bbn-treemenu :source="root + '/data'"
                  ref="menu"
                  @select="$refs.slider.hide()"
                  :menus="source.menus"
                  :current="source.current_menu"
                  :top="50"
                  storage-name="appui-menu-main"
                  :shortcuts="true"
                  @shortcut="addShortcut"
                  class="bbn-top-spadding bbn-no-border"/>
  </div>
</bbn-slider>
