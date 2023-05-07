<!-- TREEMENU -->
<bbn-slider v-if="plugins['appui-menu']"
            orientation="left"
            ref="slider"
            :style="{
              width: isMobile && !isTablet ? '100%' : '35rem',
              zIndex: 100,
              maxWidth: '100%'
            }"
            @show="focusSearchMenu"
            close-button="top-right">
  <bbn-treemenu :source="plugins['appui-menu'] + '/data'"
                v-if="$refs.slider && $refs.slider.hasBeenOpened"
                ref="menu"
                @select="$refs.slider.hide()"
                :menus="menus"
                :current="currentMenu"
                :top="50"
                :shortcuts="true"
                @shortcut="addShortcut"
                @ready="menuMounted = true"
                class="bbn-top-spadded bbn-no-border"/>
</bbn-slider>
