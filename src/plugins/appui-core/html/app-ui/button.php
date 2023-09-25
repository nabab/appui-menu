<div :class="{
        'bbn-block': !isMobile,
        'bbn-h-100': !isMobile,
        'bbn-appui-menu-button': !isMobile,
        'bbn-vmiddle': isMobile,
        'bbn-middle': !isMobile,
        'bbn-right-sspace': isMobile
      }">
  <div tabindex="0"
        @keydown.enter="toggle"
        @keydown.space="toggle"
        @click.prevent.stop="toggle"
        class="bbn-c bbn-p bbn-hpadded">
    <i ref="icon"
        class="nf nf-mdi-menu bbn-xxxl"/>
  </div>
</div>
