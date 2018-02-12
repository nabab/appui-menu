<div class="bbn-full-screen icons-popup-edition-menu bbn-c">
  <bbn-scroll>
    <div class="bbn-w-100 bbn-c bbn-padded">
      <bbn-input style="width: 300px" :placeholder="totNumberIcon" v-model="search"></bbn-input>
    </div>
    <div class="bbn-padded">
      <template v-for="icon in icons">
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
