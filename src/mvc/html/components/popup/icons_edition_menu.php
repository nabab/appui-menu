<div class="bbn-full-screen icons-popup-edition-menu bbn-c">
  <bbn-scroll>
    <div class="bbn-padded">
      <template v-for="icon in totIcons">
        <bbn-button class="btn"
                    @click="selectIcon(icon)"
                    :title="icon"
        >
          <i :class="icon + ' ' + 'icon-style'"></i>
        </bbn-button>
      </template>
    </div>
  </bbn-scroll>
</div>